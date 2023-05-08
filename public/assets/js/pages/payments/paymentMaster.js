// ==============================================================
// ------------------- Reverse Payment ---------------------------
// ==============================================================
function paymentReversal(data) {
    // transferInfo.type = "reversal";
    data.pass = true;
    $("#pin_code_modal").modal("show");
    $("#transfer_pin").on("click", () => {
        if (!data.pass) {
            return;
        }
        let userPin = $("#user_pin").val();
        if (userPin.length !== 4) {
            toaster("invalid pin", "warning");
            $("#user_pin").val("");
            userPin = "";
            return false;
        }
        let paymentData = new Object();
        paymentData.pinCode = userPin;
        paymentData.referenceNo = data.REMITTANCE_REF;
        paymentData.beneficiaryMobileNo = data.BENEF_TEL;
        reversePayment(`reverse-${paymentType}`, paymentData);
        $("#user_pin").val("");
        userPin = "";
        data.pass = false;
    });
}

function reversePayment(url, data) {
    siteLoading("show");
    $.ajax({
        type: "POST",
        url,
        datatype: "application/json",
        data,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            siteLoading("hide");

            console.log(response);
            if (response.responseCode === "000") {
                toaster(response.message, "success");
                // window.ref;
            } else {
                toaster(response.message, "error");
            }
        },
    });
}

function initiatePayment(url, data) {
    // console.log(data);
    // return false;
    siteLoading("show");
    $.ajax({
        type: "POST",
        url: url,
        datatype: "application/json",
        data: {
            amount: data.amount,
            debit_account: data.accountNumber,
            pin_code: data.pinCode,
            receiver_address: data.recipientAddress,
            receiver_name: data.recipientName,
            receiver_phone: data.recipientPhone,
            sender_name: data.accountName,
            account_mandate: data.accountMandate,
            account_currency: data.accountCurrency,
            currCode: data.currCode,
            narration: data.narration,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            siteLoading("hide");
            console.log("response");
            // return false;
            if (response.responseCode == "000") {
                // getAccounts();
                // $("#success-message").text(response.message);
                // $("#spinner").hide();
                // $("#spinner-text").hide();
                // $("#back_button").hide();
                Swal.fire({
                    width: 400,
                    title: `<h2 class='text-success font-16 font-weight-bold'>${response.message}</h2>`,
                    imageUrl: "assets/images/animations/payment_successful.gif",
                    imageHeight: 200,
                    confirmButtonColor: "#1abc9c",
                });
            } else {
                Swal.fire({
                    width: 400,
                    title: `<h2 class='text-danger font-16 font-weight-bold'>${response.message}</h2>`,
                    imageUrl:
                        "assets/images/animations/payment_unsuccessful.gif",
                    imageHeight: 200,
                    confirmButtonColor: "#dc3545",
                });
            }
        },
        error: function (xhr, status, error) {
            siteLoading("hide");
            console.log(error);
            toaster("something went wrong", "warning");
        },
    });
}
function getPaymentDetails(mobileNumber, remittanceNumber) {
    siteLoading("show");
    $.ajax({
        type: "POST",
        url: `${paymentType}-otp`,
        datatype: "application/json",
        data: {
            remittance_no: remittanceNumber,
            mobile_no: mobileNumber,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            siteLoading("hide");
            if (response.responseCode == "000") {
                console.log(response);
                toaster(response.message, "success");
                $(`.redeem_${paymentType}`).hide();
                $(`.${paymentType}_details`).show();
                let receiver_name = response.data.beneficiaryName;
                let receiver_address = response.data.beneficiaryAddress;
                let receiver_amount = response.data.remittanceAmount;
                let receiver_num = $("#mobile_no").val();
                // $("#receiver_name_redeem").text(receiver_name);
                $("#receiver_name_redeem").val(receiver_name);
                $("#receiver_address_redeem").val(receiver_address);
                $("#receiver_amount_redeem").val(receiver_amount);
                $("#receiver_phone_redeem").val(receiver_num);
                // let accountNo = response.data.accountNumber;
            } else {
                toaster(response.message, "error");
            }
        },
        error: (xhr, status, error) => {
            siteLoading("hide");
            console.log(error);
            toaster("something went wrong", "error");
        },
    });
}

function redeemPayment(data) {
    $.ajax({
        type: "POST",
        url: `redeem-${paymentType}`,
        datatype: "application/json",
        data: {
            redeem_amount: data.redeemAmount,
            redeem_receiver_name: data.receiverName,
            redeem_receiver_phone: data.receiverPhone,
            redeem_account: data.redeemAccount,
            redeem_remittance_no: data.remittanceNumber,
            otp_number: data.otp,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            console.log(response);

            if (response.responseCode == "000") {
                Swal.fire({
                    width: 400,
                    title: `<h2 class='text-success font-16 font-weight-bold'>${response.message}</h2>`,
                    imageUrl: "assets/images/animations/payment_successful.gif",
                    imageHeight: 200,
                    confirmButtonColor: "#1abc9c",
                }).then(({ isDismissed }) => {
                    isDismissed && location.reload();
                });
            } else {
                Swal.fire({
                    width: 400,
                    title: `<h2 class='text-danger font-16 font-weight-bold'>${response.message}</h2>`,
                    imageUrl:
                        "assets/images/animations/payment_unsuccessful.gif",
                    imageHeight: 200,
                    confirmButtonColor: "#dc3545",
                });
            }
        },
        error: (xhr, status, error) => {
            console.log(error);
            toaster("something went wrong", "error");
        },
    });
}
function getPaymentHistory(type, accountNumber) {
    return $.ajax({
        type: "GET",
        url: `${paymentType}-history-api`,
        datatype: "application/json",
        data: {
            accountNumber,
            type,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            const data = response.data;
            // console.log("renderedHistoryItems ==>", renderedHistoryItems);
            $(`#${paymentType}_history_display`).pagination({
                dataSource: data,
                pageSize: 5,
                callback: function (data, pagination) {
                    let items = [];
                    items = data.map((e) => renderPaymentHistoryItem(e));

                    if (items.length < 1) {
                        items = noDataAvailable;
                    }
                    $(`#${paymentType}_history_container`).html(items);
                },
            });
        },
    });
}

function renderPaymentHistoryItem(data) {
    const {
        BENEF_NAME: name,
        BENEF_TEL: tel,
        REG_POSTING_SYS_DATE: date,
        REMITTANCE_AMOUNT: amount,
    } = data;
    const dateOptions = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
    };

    // TODO: history cards should show modal with details on click
    const color = $(".knav.active").css("background-color");
    const type = $(".knav.active").text();
    const dateFormatted = new Date(date).toDateString("en-US", dateOptions);
    return `  <div class="history-card d-flex mx-2 transition-all justify-content-between font-12 mb-1 py-1 px-3 bg-white" style="border-left: 4px solid ${color}; ">
    <div>
        <div><i class=" fas fa-user" style="color: ${color} !important"></i> <span
                class="account-name font-weight-bold px-1">${name}</span></div>
        <div>
            <span><i class=" fas fa-phone-alt" style="color: ${color} !important"></i> <span
                    class="phone-number px-1">${tel}</span></span>
        </div>
        <div>
            <span> <i class=" fas fa-clock" style="color: ${color} !important"></i><span class="date px-1">${dateFormatted}</span></span>
        </div>
    </div>
    <div class="text-right align-self-center">
        <div>
            <span class="font-14 font-weight-bold text-success">SLL ${formatToCurrency(
                amount
            )}</span>
        </div>
        <div>
            <span style="background-color: ${color} !important;" class=" text-white font-11 font-weight-bold px-1 rounded-pill">
                ${type}</span>
        </div>
    </div>
</div> `;
}

$(function () {
    // ==============================================================
    // ------------------- Redeem Payment ---------------------------
    // ==============================================================
    const redeemInfo = new Object();
    $("#redeem_account option[data-account-currency!='SLL']").remove();
    $("#proceed_to_redeem_button").on("click", function () {
        let mobileNumber = $("#mobile_no").val();
        let remittanceNumber = $("#remittance_no").val();
        if (!mobileNumber || !remittanceNumber) {
            toaster("All Fields Are Required", "warning");
            return false;
        }
        getPaymentDetails(mobileNumber, remittanceNumber);
    });
    $("#done_button").click(function () {
        transferInfo.type = "redeem";
        const e = $("#redeem_account option:selected");
        const accountNumber = e.attr("data-account-number");
        if (!accountNumber) {
            toaster("Select account to redeem into");
            return;
        }
        redeemInfo.redeemAccount = accountNumber;
        redeemInfo.redeemAmount = $("#receiver_amount_redeem").val();
        redeemInfo.receiverPhone = $("#receiver_phone_redeem").val();
        redeemInfo.receiverName = $("#receiver_name_redeem").val();
        redeemInfo.remittanceNumber = $("#remittance_no").val();
        $("#user_pin").attr("maxlength", "8");
        $("#pin_code_modal")
            .modal("show")
            .on("hidden.bs.modal", function () {
                $("#user_pin").attr("maxlength", "4");
            });
    });
    $("#transfer_pin").on("click", (e) => {
        e.preventDefault();
        if (transferInfo.type !== "redeem") {
            return;
        }
        const otp = $("#user_pin").val();
        if (!otp || otp.length < 4) {
            toaster("Invalid OTP code", "warning");
            return;
        }
        redeemInfo.otp = otp;
        redeemPayment(redeemInfo);
        $("#user_pin").val("");
        transferInfo.type = "";
    });
    //------------- end of redeem Payment -------------

    // ====================================================
    //  ------------- Payment Transfer ------------------
    // ===================================================
    let transferInfo = new Object();
    $("#account_of_transfer").on("change", function () {
        const e = $("#account_of_transfer option:selected");
        // console.log(e.attr("data-account-currency-code"));
        const accountNumber = e.attr("data-account-number");
        const accountCurrency = e.attr("data-account-currency");
        const accountMandate = e.attr("data-account-mandate");
        const accountName = e.attr("data-account-description");
        const accountType = e.attr("data-account-type");
        const accountBalance = e.attr("data-account-balance") ?? "00.0";
        // console.log(accountBalance);
        const currCode = e.attr("data-account-currency-code");
        transferInfo = {
            accountCurrency,
            accountMandate,
            accountName,
            accountNumber,
            accountType,
            accountBalance,
            currCode,
        };
        $(".display_from_account_type").text(accountType);
        $(".display_from_account_name").text(accountName);
        $(".display_from_account_no").text(accountNumber);
        $(".display_from_account_currency").text(accountCurrency);
        $(".display_currency").text(accountCurrency).val(accountCurrency);
        $(".display_from_account_amount").text(
            formatToCurrency(accountBalance)
        );
    });

    $("#transfer_to_self").on("click", function () {
        console.log("self");
        const { userAlias, userPhone, userEmail } = customerInfo;
        // console.log("customerInfo ==>", customerInfo);
        $(".hide-if-self-transfer").hide(500);
        $("#receiver_address").val("Self");
        $("#receiver_name")
            .val(userAlias)
            .attr("disabled", true)
            .trigger("keyup");
        $("#receiver_phoneNum")
            .val(userPhone)
            .attr("disabled", true)
            .trigger("keyup");
        // $(".display_receiver_name").text("");
        $(".display_receiver_name").text(userAlias);
        $(".display_receiver_telephone").text(userPhone);
        $(".display_receiver_Adddress").text(userEmail);
        // $("#receiver_address").val(userEmail).trigger("keyup");
    });

    $("#transfer_to_others").on("click", function () {
        console.log("others");
        $(".hide-if-self-transfer").show(500);
        $("#receiver_name").val("").attr("disabled", false).trigger("keyup");
        $("#receiver_phoneNum")
            .val("")
            .attr("disabled", false)
            .trigger("keyup");
        $("#receiver_address").val("");
    });
    $("#receiver_name").on("keyup", function () {
        let name = $("#receiver_name").val();
        $(".display_receiver_name").text(name);
    });

    $("#receiver_phoneNum").on("keyup", function () {
        let phone = $("#receiver_phoneNum").val();
        $(".display_receiver_telephone").text(phone);
    });

    $("#receiver_address").on("keyup", function () {
        let address = $("#receiver_address").val();
        $(".display_receiver_Adddress").text(address);
    });

    $("#amount").on("keyup", function () {
        // console.log($(this).val())
        let amount = $("#amount").val();
        $(".display_transfer_amount").text(formatToCurrency(amount));

        $(".key_transfer_amount").val(
            formatToCurrency(amount)
        );
    });

    $(".display_purpose").text($("#narration").val())

    $("#narration").on("change", function () {
        let purpose = $(this).val();
        $(".display_purpose").text(purpose);
    });

    $("#confirm_next_button").on("click", (e) => {
        e.preventDefault();
        // console.log("here");
        let amount = $("#amount").val();
        let recipientAddress = $("#receiver_address").val();
        let recipientName = $("#receiver_name").val();
        let recipientPhone = $("#receiver_phoneNum").val();
        let narration = $("#narration").val();
        transferInfo = Object.assign(transferInfo, {
            amount,
            recipientName,
            recipientPhone,
            narration,
            recipientAddress,
        });
        if (
            !recipientName ||
            !recipientAddress ||
            !amount ||
            !recipientPhone ||
            !narration ||
            !transferInfo.accountNumber
        ) {
            toaster("All Fields are required", "warning");
            return;
        }
        if (isNaN(amount)) {
            toaster("Amount should be a number", "warning");
            return;
        }
        if (!validatePhone(recipientPhone)) {
            toaster("Invalid phone number", "warning");
            return;
        }
        if (parseFloat(amount) > parseFloat(transferInfo.accountBalance)) {
            toaster("Insufficient Account Balance", "warning");
            return;
        }
        siteLoading("show");

        // console.log("paymentType ==>", paymentType);
        // return;
        // SHOW SUMMARY HERE
        if (!ISCORPORATE) {
            if (paymentType == "cardless") {
                getOTP(301).then((data) => {
                    // console.log(data);
                    if (data.responseCode == "000") {
                        siteLoading("hide");

                        $("#request_form_div").hide(500);
                        $("#transaction_summary").show(500);
                    } else {
                        siteLoading("hide");
                        toaster(data.message, "warning");
                    }
                });
            } else {
                getOTP(310).then((data) => {
                    // console.log(data);
                    if (data.responseCode == "000") {
                        siteLoading("hide");
                        $("#request_form_div").hide(500);
                        $("#transaction_summary").show(500);
                    } else {
                        siteLoading("hide");
                        toaster(data.message, "warning");
                    }
                });
            }
        }

        siteLoading("hide");
        $("#request_form_div").hide(500);
        $("#transaction_summary").show(500);

        return;
    });

    // SUBMIT SALONE LINK FOR TRANSFER

    $("#confirm_transfer_button").click(function (e) {
        e.preventDefault();
        console.log("transferInfo ==>", transferInfo);

        if (!$("#terms_and_conditions").is(":checked")) {
            toaster("Accept Terms & Conditions to continue", "warning");
            return false;
        }

        if (ISCORPORATE) {
            corporateInitiatePayment(transferInfo);
            return;
        }

        if (!$("#transfer_otp").val()) {
            toaster("Enter OTP to continue", "warning");
            return false;
        }

        var otp = $("#transfer_otp").val();
        //
        siteLoading("show");

        if (paymentType == "cardless") {
            validateOTP(otp, 301).then((data) => {
                console.log("verifyOTP==>", data);
                if (data.responseCode == "000") {
                    // $("#pin_code_modal").modal("show");
                    siteLoading("hide");
                    transferInfo.type = "transfer";
                    $("#pin_code_modal").modal("show");
                    $("#transfer_pin").on("click", (e) => {
                        e.preventDefault();
                        if (transferInfo.type !== "transfer") {
                            return;
                        }
                        const pinCode = $("#user_pin").val();
                        if (!pinCode || pinCode.length !== 4) {
                            toaster("Invalid Pin Code", "warning");
                            return;
                        }
                        transferInfo.pinCode = pinCode;
                        initiatePayment(
                            `initiate-${paymentType}`,
                            transferInfo
                        );
                        transferInfo.pinCode = "";
                        $("#user_pin").val("");
                        transferInfo.type = "";
                    });
                } else {
                    siteLoading("hide");
                    toaster(data.message, "error");
                }
                return;
            });
        } else {
            validateOTP(otp, 310).then((data) => {
                console.log("verifyOTP==>", data);
                if (data.responseCode == "000") {
                    // $("#pin_code_modal").modal("show");
                    siteLoading("hide");
                    transferInfo.type = "transfer";
                    $("#pin_code_modal").modal("show");
                    $("#transfer_pin").on("click", (e) => {
                        e.preventDefault();
                        if (transferInfo.type !== "transfer") {
                            return;
                        }
                        const pinCode = $("#user_pin").val();
                        if (!pinCode || pinCode.length !== 4) {
                            toaster("Invalid Pin Code", "warning");
                            return;
                        }
                        transferInfo.pinCode = pinCode;
                        initiatePayment(
                            `initiate-${paymentType}`,
                            transferInfo
                        );
                        transferInfo.pinCode = "";
                        $("#user_pin").val("");
                        transferInfo.type = "";
                    });
                } else {
                    siteLoading("hide");
                    toaster(data.message, "error");
                }
                return;
            });
        }
    });

    $("#back_button").on("click", (e) => {
        e.preventDefault();
        $("#request_form_div").show(500);
        $("#transaction_summary").hide(500);
        // validationsCompleted = false;
    });
    function corporateInitiatePayment(transferInfo) {
        const endPoint = `corporate-initiate-${paymentType}`;
        initiatePayment(endPoint, transferInfo);
    }

    // ----------- Payment transfer end -----------

    //     ####################################################
    //                    Payment History
    //     ####################################################

    $(`#${paymentType}_history_tab`).on("click", () => {
        if (!$(`#${paymentType}_history_accounts`).val()) {
            $(`#${paymentType}_history_accounts option:last`).prop(
                "selected",
                true
            );
        }
        $(`#${paymentType}_history_accounts`).trigger("change");
    });

    // function accountTemplate(account) {
    //     const data = $(account.element).attr("data-content");
    //     if (!data) return $(account.element).text();
    //     return $(data);
    // }
    //initialize select2 on accounts select
    $(".accounts-select").select2({
        minimumResultsForSearch: Infinity,
        templateResult: accountTemplate,
        templateSelection: accountTemplate,
    });

    //trigger knav click on accounts change.
    $(`#${paymentType}_history_accounts`).on("change", (e) => {
        $(".knav.active").trigger("click");
    });

    $(".knav").on("click", (e) => {
        const accountNumber = $(
            `#${paymentType}_history_accounts option:selected`
        ).attr("data-account-number");
        if (!accountNumber) {
            toaster("Please select a valid account", "warning");
            return;
        }

        const navId = e.currentTarget.id;
        const type = e.currentTarget.getAttribute("data-value");
        $(".knav").removeClass("active");
        $(`#${navId}`).addClass("active");
        siteLoading("show");
        getPaymentHistory(type, accountNumber).always(siteLoading("hide"));
    });

    // ================= End of Payment history =======================
});
