let transferInfo = {};

function salaryFeesRequest(transferInfo) {
    siteLoading("show");
    $.ajax({
        type: "POST",
        url: "salary-advance-api",
        datatype: "application/json",
        data: transferInfo,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            siteLoading("hide");
            console.log("salaryFeesRequest =>", response);
            if (response.responseCode == "000") {
                swal.fire({
                    // title: "Transfer successful!",
                    html: response.message,
                    icon: "success",
                    // showConfirmButton: "false",
                    confirmButtonColor: "green",
                });
            } else {
                swal.fire({
                    // title: "Transfer successful!",
                    html: response.message,
                    icon: "error",
                    // showConfirmButton: "false",
                    confirmButtonColor: "red",
                });
            }
        },
        error: function (error) {
            siteLoading("hide");
            toaster(error.statusText, error);
        },
    });
}

function getSaladFees(transferInfo) {
    siteLoading("show");
    $.ajax({
        type: "POST",
        url: "get-salary-advance-fee",
        datatype: "application/json",
        data: transferInfo,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            // siteLoading("hide");
            console.log(response);
            if (response.responseCode == "000") {
                const accountBalance = transferInfo.accountBal;
                const getFee = response.data.saladFees.split(" ");
                const saladFees = getFee[1];
                console.log(saladFees);
                console.log(accountBalance);
                if (saladFees > accountBalance) {
                    siteLoading("hide");

                    swal.fire({
                        // title: "Transfer successful!",
                        html: "Your balance is insufficient for this request",
                        icon: "error",
                        // showConfirmButton: "false",
                        confirmButtonColor: "red",
                    });
                } else {
                    getOTP(406).then((data) => {
                        // console.log(data);
                        if (data.responseCode == "000") {
                            siteLoading("hide");
                            // getSaladFees(transferInfo);
                            $("#display_transfer_amount").text(
                                transferInfo.transferAmount
                            );
                            // $("#display_currency").text(transferInfo.transferCurrency);
                            $("#display_purpose").text(
                                transferInfo.tranferReason
                            );
                            $("#display_transfer_fee").text(getFee[1]);
                            $("#display_currency").text(getFee[0]);

                            $("#salary_advance_form").hide();
                            $("#salary_advance_summary").toggle(500);
                        } else {
                            siteLoading("hide");

                            toaster(data.message, "warning");
                        }
                    });
                }
            } else {
                siteLoading("hide");
                swal.fire({
                    // title: "Transfer successful!",
                    html: response.message,
                    icon: "error",
                    // showConfirmButton: "false",
                    confirmButtonColor: "red",
                });
            }
        },
        error: function (error) {
            // siteLoading("hide");
            toaster(error.statusText, error);
        },
    });
}

function corporateSalaryAdvance(transferInfo) {
    siteLoading("show");
    $.ajax({
        type: "POST",
        url: "corportate-salary-advance",
        datatype: "application/json",
        data: transferInfo,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            siteLoading("hide");
            console.log("salaryFeesRequest =>", response);
            if (response.responseCode == "000") {
                swal.fire({
                    // title: "Transfer successful!",
                    html: response.message,
                    icon: "success",
                    // showConfirmButton: "false",
                    confirmButtonColor: "green",
                });
            } else {
                swal.fire({
                    // title: "Transfer successful!",
                    html: response.message,
                    icon: "error",
                    // showConfirmButton: "false",
                    confirmButtonColor: "red",
                });
            }
        },
        error: function (error) {
            siteLoading("hide");
            toaster(error.statusText, error);
        },
    });
}

$(() => {
    $("#from_account").change(function () {
        let accountInfo = $(this).val();
        // console.log(accountInfo);

        const accountData = accountInfo.split("~");
        console.log(accountData);

        let accountName = accountData[1].trim();
        let accountNumber = accountData[2].trim();
        let accountCurrency = accountData[3].trim();
        let accountBalance = parseFloat(accountData[4].trim());
        let accountCurrencyCode = accountData[5].trim();
        let accountMandate = accountData[6];

        transferInfo.accountBal = accountBalance;
        $(".account_currency").text(accountCurrency).val(accountCurrency);
        $("#display_from_account_name").text(accountName);
        $("#display_from_account_no").text(accountNumber);
        $("#display_from_account_currency").text(accountCurrency);
        $("#display_from_account_balance").text(accountBalance);
    });

    $("#transfer_pin").on("click", (e) => {
        e.preventDefault;

        transferInfo.secPin = $("#user_pin").val();
        // console.log(transferInfo);
        // return;

        if (transferInfo.secPin.length !== 4) {
            toaster("Invalid pin", "warning");
            return false;
        }
        getSaladFees(transferInfo);

        // salaryFeesRequest(transferInfo);
        $("#user_pin").val("").text("");
        // confirmationCompleted = false;
    });

    $("#amount").on("keyup", function () {
        console.log($(this).val());
        $(".key_transfer_amount").val(formatToCurrency($(this).val()));
    });

    $("#next_button").click(function () {
        transferInfo.transferAccount = $("#from_account").val();
        transferInfo.transferAmount = $("#amount").val();
        transferInfo.transferCurrency = $(".account_currency").val();
        transferInfo.tranferReason = $("#purpose").val();

        if (
            !transferInfo.transferAccount ||
            !transferInfo.transferAmount ||
            !transferInfo.tranferReason
        ) {
            toaster("complete all fields", "warning");
            return false;
        }
        if (
            transferInfo.transferAmount <= 0 ||
            isNaN(transferInfo.transferAmount)
        ) {
            toaster("invalid transfer amount", "warning");
            return false;
        }
        $("#pin_code_modal").modal("show");
        return false;

        siteLoading("show");
    });

    $("#back_button").on("click", (e) => {
        e.preventDefault();
        $("#salary_advance_form").toggle(500);
        $("#salary_advance_summary").hide();
        // validationsCompleted = false;
    });

    $("#confirm_transfer_button").on("click", (e) => {
        e.preventDefault();
        // console.log(transferInfo);

        if (!$("#terms_and_conditions").is(":checked")) {
            toaster("Accept Terms & Conditions to continue", "warning");
            return false;
        }
        // if (!validationsCompleted) {
        //     somethingWentWrongHandler();
        //     return false;
        // }
        // confirmationCompleted = true;
        // if (ISCORPORATE) {
        //     // $("#pin_code_modal").modal("show");

        //     corporateSalaryAdvance(transferInfo);
        //     return;
        // }
        // $("#pin_code_modal").modal("show");
        salaryFeesRequest(transferInfo);
    });
});
