alert("connect");
console.log("batchNumber ==>", customeNumber);
// return;

$(document).ready(function () {
    // console.log("batchNumber ==>", batchNumber);

    // let account = $("#my_account").val();

    $("#my_account").change(function () {
        // console.log($(this).val());
        let account = $(this).val();
        let accountDetails = account.split("~");
        console.log(accountDetails);
        $("#account_name").val(accountDetails[1]);
        $("#account_balance").val(accountDetails[4]);
        $("#account_currency").val(accountDetails[3]);
    });

    // ON FORM SUBMIT
    $("#upload_swift_form").submit(function (e) {
        e.preventDefault();
        // alert("here");

        // GET FILE
        var file = document.getElementById("excel_file").files[0];

        // VALIDATE FILE
        if (file) {
            var file_name = file.name;
            var file_extension = file_name.split(".").pop().toLowerCase();
            // console.log(
            //     "file_extension ==>",
            //     jQuery.inArray(file_extension, ["txt"])
            // );

            // return false;
            if (jQuery.inArray(file_extension, ["txt"]) == -1) {
                toaster("Invalid Document Type!", "error", 3000).then(
                    function () {
                        document.getElementById("excel_file").value = "";
                    }
                );
                return false;
            }
            var file_size = file.size;
            // console.log("file_size ==>", file_size);
            if (file_size > 20000000) {
                // check if image size is less than 20MB
                toaster(
                    "The file size is too large. The max file size 20MB!",
                    "error",
                    3000
                );
            } else {
                var form_data = new FormData();
                var account_details = $("#my_account").val();

                var file_ = document.getElementById("excel_file").files[0];
                form_data.append("my_account", account_details);
                form_data.append("excel_file", file_);
                form_data.append("file_name", file_name);
                form_data.append("file_extension", file_extension);
                form_data.append("file_size", file_size);

                $.ajax({
                    type: "POST",
                    url: "swift_mt101",
                    datatype: "application/json",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (response) {
                        console.log(response);
                        siteLoading("hide");
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.responseText);
                    },
                });
            }
            siteLoading("show");
        } else {
            swal({
                text: "Something went wrong. Upload was unsuccessful!",
                icon: "warning",
                dangerMode: true,
            }).then(function () {
                document.getElementById("file").value = "";
            });
        }
    });
});
