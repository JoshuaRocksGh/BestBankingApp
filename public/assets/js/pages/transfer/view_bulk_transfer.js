// alert("view_bulk_transfer");
// return;
// siteLoading("show");

function reject_file_upload(batch_no) {
    url = "delete-bulk-upload-file?batch_no=" + `${batch_no}`;
    $.ajax({
        type: "GET",
        url: url,
        datatype: "application/json",
        // data: {
        //     'narration': narration,
        //     'request_id': request_id,
        //     'customer_no': customer_no
        // },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            console.log(response);
            if (response.responseCode == "000") {
                siteLoading("hide");

                swal.fire({
                    // title: "Transfer successful!",
                    html: response.message,
                    icon: "success",
                    showConfirmButton: "false",
                });

                setTimeout(function () {
                    // window.location = "approvals-pending";
                    window.location = "bulk-transfer";
                    window.opener.location.reload();
                    window.close();
                }, 5000);
            } else {
                siteLoading("hide");
                swal.fire({
                    // title: "Transfer successful!",
                    html: response.message,
                    icon: "error",
                    showConfirmButton: "false",
                });
            }

            // $("#reject_transaction").html(`Reject <i class="mdi mdi-cancel">`);
        },
        error: function (xhr, status, error) {
            // $("#reject_transaction").html(`Reject <i class="mdi mdi-cancel">`);
            // Swal.showValidationMessage(`Request failed: ${error}`);
        },
    });
}

function get_bulk_list(batch_no) {
    siteLoading("show");
    // alert(batch_no);
    // return false;
    $.ajax({
        tpye: "GET",
        url: "get-bulk-upload-list-api?fileBatch=" + batch_no,
        datatype: "application/json",
        success: function (response) {
            // console.log("get_bulk_list =>", response);
            // return false;
            if (response.responseCode == "000") {
                let uploadData = response.data.uploadData;
                let uploadSummary = $("#bulk_upload_list").DataTable();
                let count = 1;

                uploadData.forEach((e) => {
                    const {
                        name,
                        accountNumber,
                        amount,
                        refNumber,
                        acctValid,
                        valid,
                    } = e;

                    uploadSummary.row
                        .add([
                            `<b>${count}</b>`,
                            `<b>${accountNumber}</b>`,
                            `<b>${name}</b>`,
                            `<b>${amount}</b>`,
                            `<b>${refNumber}</b>`,
                        ])
                        .draw(false);
                    count++;
                });

                siteLoading("hide");
            }
        },
    });
}

function submit_upload(batch_no) {
    siteLoading("show");

    //const ipAPI = 'post-bulk-transaction-api?batch_no=' + batch_no + "~" + customer_no

    $.ajax({
        type: "GET",
        url: "post-bulk-transaction-api?batch_no=" + batch_no,
        datatype: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            console.log("bulk-transaction-api =>", response);
            //return false
            siteLoading("hide");

            if (response.responseCode == "000") {
                swal.fire({
                    // title: "Transfer successful!",
                    html: response.message,
                    icon: "success",
                    showConfirmButton: "false",
                }).then(() => {
                    // window.location.reload();
                    setTimeout(function () {
                        window.location = "bulk-transfer";
                    }, 200);
                });
            } else {
                swal.fire({
                    // title: "Transfer successful!",
                    html: response.message,
                    icon: "error",
                    showConfirmButton: "false",
                }).then(() => {
                    // window.location.reload();
                    setTimeout(function () {
                        window.location = "";
                    }, 200);
                });
            }
            // setTimeout(function() {
            //     window.location = "{{ url('bulk-transfer') }}"
            // }, 3000)
        },

        error: function (xhr, status, error) {
            siteLoading("hide");
            Swal.fire({
                icon: "error",
                title: error,
            });
        },
    });
}

function reject_upload(batch_no) {
    // const ipAPI = "reject-bulk-transaction-api?customer_no=" + customer_no;
    const ipAPI = "delete-bulk-transfer?batch_no=" + batch_no;

    // Swal.fire([
    //     {
    //         title: "Are you sure you want to reject",
    //         icon: "warning",
    //         showCancelButton: true,
    //         confirmButtonColor: "#d33",
    //         cancelButtonColor: "#3085d6",
    //         confirmButtonText: "Yes, Reject!",
    //         showLoaderOnConfirm: true,
    //         preConfirm: () => {
    //             return fetch(ipAPI)
    //                 .then((response) => response.json())
    //                 .then((data) => {
    //                     if (data.responseCode == "000") {
    //                         Swal.fire({
    //                             icon: "success",
    //                             title: data.message,
    //                         });

    //                         setTimeout(function () {
    //                             window.location = "{{ url('bulk-transfer') }}";
    //                         }, 2000);
    //                     } else {
    //                         Swal.fire({
    //                             icon: "error",
    //                             title: data.message,
    //                         });
    //                     }
    //                 })
    //                 .catch(() => {
    //                     Swal.fire({
    //                         icon: "error",
    //                         title: "API SERVER ERROR",
    //                     });
    //                 });
    //         },
    //     },
    // ]);

    Swal.fire({
        title: "Are you sure?",
        text: "",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Reject",
    }).then((result) => {
        reject_file_upload(batch_no);
        // return fetch(ipAPI);
        // if (result.isConfirmed) {
        //     Swal.fire("", "File Rejected SUccesfully", "success");
        // }
    });
}

$(document).ready(function () {
    //call function to upload
    get_bulk_list(batch_no);
    //end call function
    // var batch_no = @json($batch_no)
    // setTimeout(function() {
    //     get_bulk_list(batch_no)
    // }, 200)

    $("#approve_upload_btn").click(function () {
        //console.log(batch_no)
        submit_upload(batch_no);
    });

    $("#reject_upload_btn").click(function () {
        reject_upload(batch_no);
    });
});
