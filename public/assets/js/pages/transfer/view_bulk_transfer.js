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
            siteLoading("hide");

            console.log(response);
            if (response.responseCode == "000") {
                toaster(response.message, "success", "").then(() => {
                    setTimeout(function () {
                        window.location = "bulk-transfer";
                    }, 200);
                });
            } else {
                // siteLoading("hide");
                toaster(response.message, "error", "").then(() => {
                    setTimeout(function () {
                        window.location = "bulk-transfer";
                    }, 200);
                });
            }

            // $("#reject_transaction").html(`Reject <i class="mdi mdi-cancel">`);
        },
        error: function (xhr, status, error) {
            siteLoading("hide");

            // $("#reject_transaction").html(`Reject <i class="mdi mdi-cancel">`);
            // Swal.showValidationMessage(`Request failed: ${error}`);
        },
    });
}

// function get_bulk_list(batch_no) {

//     $.ajax({
//         tpye: "GET",
//         url: "get-bulk-upload-list-api?fileBatch=" + batch_no,
//         datatype: "application/json",
//         success: function (response) {

//             if (response.responseCode == "000") {
//                 let uploadData = response.data.uploadData;
//                 let uploadSummary = $("#bulk_upload_list").DataTable();
//                 let count = 1;

//                 uploadData.forEach((e) => {
//                     const {
//                         name,
//                         accountNumber,
//                         amount,
//                         refNumber,
//                         acctValid,
//                         valid,
//                     } = e;

//                     uploadSummary.row
//                         .add([
//                             `<b>${count}</b>`,
//                             `<b>${accountNumber}</b>`,
//                             `<b>${name}</b>`,
//                             `<b>${amount}</b>`,
//                             `<b>${refNumber}</b>`,
//                         ])
//                         .draw(false);
//                     count++;
//                 });

//                 siteLoading("hide");
//             }
//         },
//     });
// }

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
                toaster(response.message, "success", "").then(() => {
                    setTimeout(function () {
                        window.location = "bulk-transfer";
                    }, 200);
                });
                // swal.fire({
                //     html: response.message,
                //     icon: "success",
                //     confirmButtonColor: "green",
                // }).then(() => {
                //     setTimeout(function () {
                //         window.location = "bulk-transfer";
                //     }, 200);
                // });
            } else {
                toaster(response.message, "error", "").then(() => {
                    setTimeout(function () {
                        window.location = "";
                    }, 200);
                });

                // swal.fire({
                //     html: response.message,
                //     icon: "error",
                //     confirmButtonColor: "red",
                // }).then(() => {
                //     setTimeout(function () {
                //         window.location = "";
                //     }, 200);
                // });
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
    // const ipAPI = "delete-bulk-transfer?batch_no=" + batch_no;

    Swal.fire({
        title: "Are you sure?",
        text: "",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Reject",
    }).then((result) => {
        if (result.isConfirmed) {
            alert("confirme");
            // reject_file_upload(batch_no);
        } else {
            alert("cancelled");
        }
        // return fetch(ipAPI);
        // if (result.isConfirmed) {
        //     Swal.fire("", "File Rejected SUccesfully", "success");
        // }
    });
}

$(document).ready(function () {
    $("#bulk_upload_list").DataTable();
    //call function to upload
    // get_bulk_list(batch_no);
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
        // reject_upload(batch_no);
    });
});
