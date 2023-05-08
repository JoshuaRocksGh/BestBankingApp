function makeTransfer(data) {
    siteLoading("show");
    $.ajax({
        type: "POST",
        url: "bollore-tranfer",
        datatype: "application/json",
        data: data,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            siteLoading("hide");
            console.log(response);
            if (response.responseCode == "000") {
                swal.fire({
                    // title: "Transfer successful!",
                    html: response.message,
                    icon: "success",
                    // showConfirmButton: "false",
                    confirmButtonColor: "green",
                });

                getAccounts();
                $(".show-on-success").show();
                $("#success-message").text(response.message);

                $(".hide-on-success").hide();
            } else {
                toaster(response.message, "error", 3000);
            }
        },
        error: function (error) {
            siteLoading("hide");
            toaster(error.statusText, error);
        },
    });
}

function lovs_list() {
    $.ajax({
        type: "GET",
        url: "get-lovs-list-api",
        datatype: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            siteLoading("hide");
            if (response.responseCode == "000") {
                const { data } = response;
                // console.log("get-lovs-list-api", data);
                const select = document.getElementById("id_type");
                data.documentTypeList.forEach((e) => {
                    const option = document.createElement("option");
                    option.text = e.description;
                    option.value = e.actualCode;
                    select.appendChild(option);
                });
            } else {
                setTimeout(function () {
                    lovs_list();
                }, $.ajaxSetup().retryAfter);
            }
        },
        error: function (xhr, status, error) {
            siteLoading("hide");

            // console.log(xhr.status);
            // console.log(xhr.responseText);
            setTimeout(function () {
                lovs_list();
            }, $.ajaxSetup().retryAfter);
        },
    });
    // return $.ajax({
    //     type: "GET",
    //     url: "get-lovs-list-api",
    //     datatype: "application/json",
    // }).done((response) => {
    //     console.log(response);
    //     if (response?.data) {
    //         const { data } = response;
    //         const select = document.getElementById("card_type");
    //         data.forEach((e) => {
    //             const option = document.createElement("option");
    //             option.text = e.description;
    //             option.value = e.actualCode;
    //             select.appendChild(option);
    //         });
    //     }
    // });
}

$(document).ready(function () {
    // alert("bollore");
    lovs_list();
    const bolloreInfo = new Object();
    // $("#confirm_next_button").click(function () {
    //     alert("clicked");
    // });

    $("#account_of_transfer").change(function () {
        var details = $(this).val();
        var getValues = details.split("~");
        $("#select_currency").val(getValues[3]);
        // console.log(getValues);
        $("#display_from_account_name").text(getValues[1]);
        $("#display_from_account_no").text(getValues[2]);
        $("#display_from_account_currency").text(getValues[3]);
        $("#display_currency").text(getValues[3]);
        $("#display_from_account_balance").text(getValues[4]);
    });

    $("#confirm_next_button").click(function (e) {
        e.preventDefault();

        bolloreInfo.accountDetails = $("#account_of_transfer").val();
        bolloreInfo.beneficiaryName = $("#beneficiary_name").val();
        bolloreInfo.beneficiaryAddress = $("#beneficiary_address").val();
        bolloreInfo.receiverName = $("#reciever_name").val();
        bolloreInfo.transferAmount = $("#amount").val();
        bolloreInfo.idType = $("#id_type").val();
        bolloreInfo.idTypeName = $("#id_type option:selected").text();
        bolloreInfo.idNumber = $("#id_number").val();
        bolloreInfo.transferPurpose = $("#transfer_purpose").val();
        bolloreInfo.receiverTelephone = $("#telephone_number").val();

        if (
            !bolloreInfo.accountDetails ||
            !bolloreInfo.beneficiaryName ||
            !bolloreInfo.beneficiaryAddress ||
            !bolloreInfo.receiverName ||
            !bolloreInfo.transferAmount ||
            !bolloreInfo.idType ||
            !bolloreInfo.idNumber ||
            !bolloreInfo.transferPurpose ||
            !bolloreInfo.receiverTelephone
        ) {
            console.log(bolloreInfo);
            toaster("All Fields are required", "warning");
            return;
        }

        $("#display_beneficiary_name").text(bolloreInfo.beneficiaryName);
        $("#display_beneficiary_address").text(bolloreInfo.beneficiaryAddress);
        $("#display_to_receiver_name").text(bolloreInfo.receiverName);
        $("#display_to_receiver_id_type").text(bolloreInfo.idTypeName);
        $("#display_to_receiver_id_number").text(bolloreInfo.idNumber);
        $("#display_to_receiver_telephone").text(bolloreInfo.receiverTelephone);
        $("#display_transfer_amount").text(bolloreInfo.transferAmount);
        $("#display_purpose").text(bolloreInfo.transferPurpose);

        $("#transaction_summary").toggle(500);
        $("#bollore_request").hide();
    });

    $("#back_button").click(function (e) {
        e.preventDefault();

        $("#transaction_summary").hide();
        $("#bollore_request").toggle(500);
    });

    $("#amount").on("keyup", function () {
        // e.preventDefault();
        bolloreInfo.transferAmount = $(this).val();
        console.log(bolloreInfo.transferAmount);

        //
        $(".display_transfer_amount").text(
            formatToCurrency(bolloreInfo.transferAmount)
        );

        $(".key_transfer_amount").val(
            formatToCurrency(bolloreInfo.transferAmount)
        );
    });

    $("#confirm_transfer_button").on("click", (e) => {
        e.preventDefault();
        console.log(bolloreInfo);

        if (!$("#terms_and_conditions").is(":checked")) {
            toaster("Accept Terms & Conditions to continue", "warning");
            return false;
        }

        makeTransfer(bolloreInfo);
        // if (!validationsCompleted) {
        //     somethingWentWrongHandler();
        //     return false;
        // }
        // confirmationCompleted = true;
        // if (ISCORPORATE) {
        //     corporateSpecific(transferInfo);
        //     return;
        // }
        // $("#pin_code_modal").modal("show");
    });
});
