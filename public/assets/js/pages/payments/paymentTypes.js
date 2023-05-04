const pageData = new Object();

const formData = new FormData();

function getPaymentBeneficiaries() {
    $.ajax({
        type: "GET",
        url: "payment-beneficiary-list-api",
        datatype: "application/json",
        success: function (response) {
            console.log("paymentBeneficiary==>", response);
            let data = response.data;
            if (response.responseCode == "000") {
                if (data.length > 0) {
                    $.each(pageData.payTypes, async (i) => {
                        const type = pageData.payTypes[i];
                        pageData["bene_" + type] = data.filter(
                            (e) => e.PAYMENT_TYPE === type
                        );
                    });
                }
                initPaymentsCarousel();
            } else {
                setTimeout(function () {
                    getPaymentBeneficiaries();
                }, $.ajaxSetup().retryAfter);
            }
        },
        error: function (xhr, status, error) {
            $("#loader").show();

            setTimeout(function () {
                getPaymentBeneficiaries();
            }, $.ajaxSetup().retryAfter);
        },
    });
}

function getAccountLinkStatus(){
    $.ajax({
        type: "GET",
        url: "get-account-link",
        datatype: "application/json",
        success: function(response){
            console.log("getAccountLinkStatus=>", response)
            if(response.responseCode == "000" || response.responseCode == "00"){

            }else{
                toaster(`${response.message} for mobile money transfer`, "warning");
            }
        }
    })
}

function paymentType() {
    $.ajax({
        type: "GET",
        url: "get-payment-types-api",
        datatype: "application/json",
        success: function (response) {
            console.log("getPaymentTypesApi ==>", response)
            $("#loader").hide();
            let data = response.data;
            if (response.responseCode == "000") {
                pageData.payTypes = [];

                if (data.length > 0) {
                    $(".payments-carousel").empty();
                    $.each(data, function (i) {
                        const type = data[i].paymentType;
                        pageData.payTypes.push(type);
                        pageData["pay_" + type] = data[i];
                        const { label, paymentType, description } = data[i];
                        const comingSoon = !label ? "coming-soon" : "";
                        let paymentCard = `<button type="button" class="${comingSoon} knav knav-primary mb-2
                        payments"  id='${paymentType}_card' data-span="${paymentType}">
                    ${description}
                    </button>`;
                        $(".payments-carousel").append(paymentCard);
                    });
                    getPaymentBeneficiaries();
                } else {
                    return false;
                }
            } else {
                // toaster("Failed", "error");
                setTimeout(function () {
                    paymentType();
                }, $.ajaxSetup().retryAfter);
            }
        },
        error: function (xhr, status, error) {
            $("#loader").show();

            setTimeout(function () {
                paymentType();
            }, $.ajaxSetup().retryAfter);
        },
    });
}

function makePayment(data) {
    console.log("my data=>", data)
    siteLoading("show");
    $.ajax({
        type: "POST",
        url: "make-payment-api",
        datatype: "application/json",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            siteLoading("hide");
            console.log("make payemet =?", response)
            if (response.responseCode == "000" || response.responseCode == "00") {
                getAccounts();
                if(pageData.paymentInfo.payeeName == "DYCAR"){
                    window.location.href = `https://sandbox.dycargroup.com/api/receipt?id=${response.data.id}`;
                    // return;
                }
                Swal.fire({
                    width: 400,
                    title: `<h2 class='text-success font-16 font-weight-bold'>${response.message}</h2>`,
                    imageUrl: "assets/images/animations/payment_successful.gif",
                    imageHeight: 200,
                    confirmButtonColor: "#1abc9c",
                }).then((result) => {
                    location.reload();
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
        error: function (error) {
            siteLoading("hide");
            toaster(error.statusText, error);
        },
    });
}

function getRecipientName() {
    siteLoading("show");
    $.ajax({
        type: "POST",
        url: "payment-name-enquiry-api",
        datatype: "application/json",
        data: pageData.paymentInfo,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.responseCode == "000") {
                siteLoading("hide");
                console.log("name-enquiry=?", response)
                // return false;
                if(pageData.paymentInfo.payeeName == "DYCAR"){
                    pageData.paymentInfo.recipientName = response.data.customerName;
                    pageData.paymentInfo.meterAddress = response.data.serviceAddress;
                    pageData.paymentInfo.lastAmount = response.data.amountLast;
                    pageData.paymentInfo.prepaidDebt = response.data.prepaidDebt;
                    // prepaidDebt
                }else{
                    pageData.paymentInfo.recipientName = response.data;
                }

                paymentVerification();
            }
        },
        error: function (xhr, status, error) {
            $("#loader").show();

            setTimeout(function () {
                paymentType();
            }, $.ajaxSetup().retryAfter);
        },
    });
}

function paymentVerification() {
    console.log("next_button ==>", pageData.paymentInfo);
    if (!ISCORPORATE) {
        // IF TYPE IS MOMO
        if (pageData.paymentInfo.paymentType == "MOM") {
            // siteLoading("show");
            getOTP(313).then((data) => {
                // console.log(data);
                if (data.responseCode == "000") {
                } else {
                    toaster(data.message, "warning");
                    return;
                }
            });
        } else if (pageData.paymentInfo.paymentType == "AIR") {
            getOTP(314).then((data) => {
                // console.log(data);
                if (data.responseCode == "000") {
                } else {
                    toaster(data.message, "warning");
                    return;
                }
            });
        } else if (pageData.paymentInfo.paymentType == "UTL") {
            getOTP(315).then((data) => {
                // console.log(data);
                if (data.responseCode == "000") {
                } else {
                    toaster(data.message, "warning");
                    return;
                }
            });
        }
    }

    if(pageData.paymentInfo.payeeName == "DYCAR"){
        $(".display_dycar").show()
    }

    const {
        paymentType,
        account,
        beneficiaryAccount,
        amount,
        recipientName,
        payeeName,
        meterAddress,
        lastAmount,
        prepaidDebt
    } = pageData.paymentInfo;
    const { paymentDescription, paymentAccount } = pageData[
        "pay_" + paymentType
    ].paySubTypes.find((e) => e.paymentCode === payeeName);
    const formattedAmount = formatToCurrency(amount)
        ? formatToCurrency(amount)
        : 0.0;
    const expensetype = pageData["pay_" + paymentType].description;
    const transFee = "0";
    const currency = "SLE";
    const totalAmount = parseFloat(amount) + parseFloat(transFee);
    $("#details_from_account").text(account);
    if(!pageData.paymentInfo.paymentDescription == "AFRICEL"){
        $(".details_to_account").hide();
    }
    $("#details_to_account").text(recipientName);
    $("#details_icon_text").text(recipientName[0]);


    $("#details_amount").text(currency + " " + formattedAmount);
    $("#details_recipient_number").text(beneficiaryAccount);
    $("#details_recipient_name").text(recipientName);
    $("#details_trans_fee").text(currency + " " + formatToCurrency(transFee));
    $("#details_narration").text(paymentDescription);
    $("#details_expense_type").text(expensetype);
    $("#details_total_amount").text(
        currency + " " + formatToCurrency(totalAmount)
    );
    $("#details_meter_address").text(meterAddress)
    $("#details_meter_balance").text(currency + " " + formatToCurrency(prepaidDebt))
    $("#details_last_meter_amount").text(currency + " " + formatToCurrency(lastAmount))
    pageData.paymentInfo.paymentAccount = paymentAccount;
    pageData.paymentInfo.paymentDescription = paymentDescription;
    $("#payment_verification_modal").modal("show");
}

function initPaymentsCarousel() {
    let payments = document.querySelectorAll(".payments");
    payments.forEach((item, i) => {
        item.addEventListener("click", (e) => {
            if (e.target.classList.contains("coming-soon")) {
                e.preventDefault();
                comingSoonToast("Stay tuned for more features");
                return;
            }
            $(".payments").removeClass("current-type active");
            const type = $(e.currentTarget).attr("data-span");
            $(e.currentTarget).addClass("current-type active");
            pageData.currentType = type;
            //populate beneficiaries
            console.log("initPaymentsCarousel=>",type)
            if(type == "MOM"){
                // $(".momo_trasfer_type").show()
                getAccountLinkStatus()
            }
            $(".momo_trasfer_type").hide()

            $("#to_account");
            populateBeneficiariesSelect(type);
            populateSubtypesSelect(type);
        });
        if (i === 0) {
            $(item).trigger("click");
        }
    });
    siteLoading("hide");
}

function populateBeneficiariesSelect(type) {
    const beneData = pageData["bene_" + type];

    $("#to_account").empty();
    if (beneData?.length < 1) {
        $("#to_account").append(noSavedBeneficiariesOption);
    } else {
        $("#to_account").append(
            `<option selected disabled> --- Select Beneficiary --- </option>`
        );
        console.log(beneData);
        beneData?.forEach((bene, i) => {
            let { ACCOUNT, NICKNAME, PAYEE_NAME } = bene;
            const paymentLogo = pageData["pay_" + type].paySubTypes.find(
                (e) => e.paymentCode === PAYEE_NAME
            ).paymentLogo;
            let logo = paymentLogo
                ? "data:image/jpg;base64," + paymentLogo
                : "assets/images/add.png";
            let content = `<div class='d-flex text-capitalize px-2 align-items-center' style='line-height: 1.5 !important'>
            <div class='text-right mr-2'><img style='width: 50px;' src='${logo}' class='img-fluid'/></div>
            <div class='font-14  '>
                 <div class='text-dark font-weight-bold'>${NICKNAME}</div>
                 <div >${ACCOUNT}</div>
            </div> </div>`;
            let option = `<option data-content="${content}" data-type='${PAYEE_NAME}' value='${ACCOUNT}'> </option> `;
            $("#to_account").append(option);
        });
    }
}

function populateSubtypesSelect(type) {
    // populate subtypes
    const typeData = pageData["pay_" + type];
    let { label } = typeData;
    label = label.toLowerCase();
    $("#subtype_select").empty();
    $("#subtype_select").append(
        `<option selected disabled class="text-capitalize"> --- ${label} --- </option>`
    );
    $("#subtype_label").val(label).text(label);

    typeData.paySubTypes.forEach((e, i) => {
    // console.log('populateSubtypesSelect=>',e)

        let { paymentLabel, paymentCode, paymentDescription, paymentLogo } = e;
        let logo = paymentLogo
            ? "data:image/jpg;base64," + paymentLogo
            : "assets/images/add.png";
        paymentLabel = paymentLabel.toLowerCase();
        paymentDescription = paymentDescription.toLowerCase();
        $("#payment_label").val(paymentLabel).text(paymentLabel);
        $("#payment_label_input").attr("placeholder", `Enter ${paymentLabel}`);
        let content = `<span class='text-capitalize font-14'><img src='${logo}' class='mx-2' style='width:50px'>${paymentDescription}</span>`;
        let option = `<option data-content="${content}"  value='${paymentCode}'> </option> `;
        $("#subtype_select").append(option);
        $("#subtype_div").show();
        return;
    });
}
function getTransType() {
    var transType = $("input[name='trans_type']:checked").val();
    $("#display_voucher_attachment").text("No");
    // transferInfo.voucher = null;
    // transferInfo.fileUploaded = null;

    // console.log(transType);
}

function getMomoTransType(){
    var getMomoTransferType = $("input[name='AcctToMomo']:checked").val();
    console.log("getMomoTransferType=>",getMomoTransferType)

}

$(() => {
    let isOnetimePayment = false;
    siteLoading("show");
    paymentType();
    getTransType();
    // getMomoTransType()

    $("input[name='AcctToMomo']").click(function(){
        var getMomoTransferType = $("input[name='AcctToMomo']:checked").val();
        console.log("getMomoTransferType=>",getMomoTransferType)

        // var getMomoTransferType = $("input[name='AcctToMomo']:checked").val();
        // pageData.paymentInfo.MomoTransferType = getMomoTransferType

        pageData.paymentInfo = {
            MomoTransferType: getMomoTransferType,
            // fileUploaded: "",
        };

        console.log("getMomoTransferType=>",pageData)


    })



    function updateTransactionType(type) {
        if (type === "onetime") {
            isOnetimePayment = true;
        } else if (type === "beneficiary") {
            isOnetimePayment = false;
        }
    }

    $("#beneficiary_tab").on("click", () => {
        updateTransactionType("beneficiary");
        $(".display_to_account").text("");
        $("#to_account").trigger("change");
    });

    $("#onetime_tab").on("click", () => {
        updateTransactionType("onetime");
        $(".display_to_account").text("");
        $("#to_account").trigger("change");
    });

    $("input[name='trans_type']").click(function () {
        // $("input[name='trans_type']:checked").val();
        var transType = $("input[name='trans_type']:checked").val();
        // console.log(transType);

        if (transType == "invoice") {
            console.log("invoice===");
            $(".display_upload_input").toggle(500);
            $("#display_voucher_attachment").text("Yes");

            return;
        }
        if (transType == "normal") {
            console.log("===normal");

            pageData.paymentInfo = {
                voucher: "",
                fileUploaded: "",
            };
            $(".display_upload_input").hide();
            $("#display_voucher_attachment").text("No");

            return;
        }
    });

    $()

    // $("#subtype_select").change(function(){

    //     console.log("get span 1=>",$(this).val())

    //    let thisPayment = document.querySelectorAll(".payments");
    //    thisPayment.forEach((item, i) => {
    //     item.addEventListener("click", (e) => {

    //         // $(".payments").removeClass("current-type active");
    //         const thisType = $(e.currentTarget).attr("data-span");
    //         $(e.currentTarget).addClass("current-type active");
    //         // pageData.currentType = type;
    //         //populate beneficiaries
    //         console.log("initPaymentsCarousel=>",thisType)

    //     });
    //     // if (i === 0) {
    //     //     $(item).trigger("click");
    //     // }
    // });


    //     // var active = $(".knav").hasClass("active")
    //     // if($(".knav").hasClass("active")){
    //     //     console.log("get span 2=>",$(".knav").attr("id"))
    //     // }
    // })

    // adding invoice file
    pageData.paymentInfo = {
        voucher: "",
        fileUploaded: "",
    };
    // const pageData.paymentInfo.voucher = ""
    // const pageData.paymentInfo.fileUploaded = ""

    $("#invoice_file").change(function () {
        var file = document.getElementById("invoice_file").files[0];
        // console.log("file ==>", file);

        if (file.size > 5000000) {
            toaster(
                "The file size is too large. Max file size of 5MB!",
                "error"
            );
            return;
        }

        // pageData.paymentInfo = {
        //     voucher: file,
        //     fileUploaded: "Y",
        // };
        // pageData.paymentInfo.;
    });

    $("#confirm_transfer_button").on("click", (e) => {
        e.preventDefault();



        if (ISCORPORATE) {
            var file = document.getElementById("invoice_file").files[0];
            // pageData.paymentInfo = {
            //     voucher: file,
            //     fileUploaded: "Y",
            // };
            if (file) {
                pageData.paymentInfo.voucher = file;
                pageData.paymentInfo.fileUploaded = "Y";
            } else {
                pageData.paymentInfo.voucher = "";
                pageData.paymentInfo.fileUploaded = "";
            }

            // console.log("data ==>", pageData.paymentInfo);
            // return;
            for (const key in pageData.paymentInfo) {
                if (pageData.paymentInfo.hasOwnProperty(key)) {
                    // console.log("key ==>", key);

                    formData.append(key, pageData.paymentInfo[key]);
                }
            }
            console.log("ISCORPORATE ==>", formData);
            // return;

            makePayment(formData);
            return;
        }
        // validate otp field
        var otp = $("#transfer_otp").val();
        if (!otp) {
            toaster("Enter Valid OTP", "warning");
            return;
        }

        if (pageData.paymentInfo.paymentType == "MOM") {
            validateOTP(otp, 313).then((data) => {
                // console.log("verifyOTP==>", data);
                if (data.responseCode == "000") {
                    $("#pin_code_modal").modal("show");
                } else {
                    toaster(data.message, "error");
                }
                return;
            });
        } else if (pageData.paymentInfo.paymentType == "AIR") {
            validateOTP(otp, 314).then((data) => {
                // console.log("verifyOTP==>", data);
                if (data.responseCode == "000") {
                    $("#pin_code_modal").modal("show");
                } else {
                    toaster(data.message, "error");
                }
                return;
            });
        } else if (pageData.paymentInfo.paymentType == "UTL") {
            validateOTP(otp, 315).then((data) => {
                // console.log("verifyOTP==>", data);
                if (data.responseCode == "000") {
                    $("#pin_code_modal").modal("show");
                } else {
                    toaster(data.message, "error");
                }
                return;
            });
        }
    });

    $("#next_button").on("click", (e) => {
        e.preventDefault();
        // alert("called");
        let account = $("#from_account option:selected").attr(
            "data-account-number"
        );
        let accountName = $("#from_account option:selected").attr(
            "data-account-description"
        );
        let accountMandate = $("#from_account option:selected").attr(
            "data-account-mandate"
        );
        let accountCurrency = $("#from_account option:selected").attr(
            "data-account-currency"
        );
        let accountCurrCode = $("#from_account option:selected").attr(
            "data-account-currency-code"
        );
        let amount = $("#amount").val();
        let paymentType = pageData.currentType;
        let beneficiaryAccount, payeeName;

        if (!isOnetimePayment) {
            beneficiaryAccount = $("#to_account").val();
            payeeName = $("#to_account option:selected").attr("data-type");
        } else {
            payeeName = $("#subtype_select").val();
            beneficiaryAccount = $("#onetime_to_account").val();
        }
        if (!amount || !account || !beneficiaryAccount || !payeeName) {
            toaster("all fields required", "warning");
            return;
        }

        var getMomoTransferType = $("input[name='AcctToMomo']:checked").val();
        pageData.paymentInfo = {
            amount,
            accountCurrCode,
            accountCurrency,
            accountMandate,
            accountName,
            account,
            beneficiaryAccount,
            payeeName,
            paymentType,
            momoTransferType: getMomoTransferType,
        };
        // if (ISCORPORATE) {
        //     getRecipientName(pageData.paymentInfo);
        // }
        // console.log("next_button ==>", pageData.paymentInfo);

        // return;

        getRecipientName(pageData.paymentInfo);
    });

    $("#transfer_pin").on("click", (e) => {
        e.preventDefault;
        const pin = $("#user_pin").val();
        if (!pin || pin.length !== 4) {
            toaster("invalid pin", "warning");
            return false;
        }
        pageData.paymentInfo.pinCode = pin;
        for (const key in pageData.paymentInfo) {
            if (pageData.paymentInfo.hasOwnProperty(key)) {
                // console.log("key ==>", key);

                formData.append(key, pageData.paymentInfo[key]);
            }
        }
        makePayment(formData);
        $("#user_pin").val("").text("");
    });
});
