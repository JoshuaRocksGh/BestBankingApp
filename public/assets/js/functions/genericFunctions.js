function approve_request() {
    Swal.fire({
        title: "Do you want to Logout?",
        icon: "question",
        // input: "text",
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: `Proceed`,
        confirmButtonColor: "#18c40d",
        cancelButtonColor: "#df1919",
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        // console.log("result==>", result);

        // return;

        if (result.isConfirmed) {
            setTimeout(() => {
                window.location.replace("logout");
            }, 1000);
            // if (!result.value) {
            //     toaster("Enter Otp", "warning");
            //     return;
            // }
            // validateOTP(result.value, 105).then((data) => {
            //     // console.log("verifyOTP==>", data);
            //     if (data.responseCode == "000") {
            //         setTimeout(() => {
            //             window.location.replace("logout");
            //         }, 1000);

            //         // $("#submit").attr("disabled", true);
            //     } else {
            //         toaster(data.message, "warning");
            //         return;
            //     }
            //     return;
            // });

            return;
        } else if (result.isDenied) {
            return;
            // toaster('Failed to approve transaction', 'error')
            // Swal.fire('Failed to approve transaction', '', 'info')
        }
    });
}

function transactionSuccessToaster(message, timer = 3000) {
    Swal.fire({
        title: "Transaction Successful",
        text: message,
        imageUrl: "land_asset/images/statement_success.gif",
        imageHeight: "10rem",
        width: "20rem",
        imageAlt: "success image",
        confirmButtonColor: "#0388cb",
        timer: timer,
    });
}

function toaster(message, icon, timer = 3000) {
    let color = "#17a2b8";
    if (typeof icon === "string") {
        if (icon.toLowerCase() === "success") {
            color = "#1abc9c";
        } else if (icon.toLowerCase() === "warning") {
            color = "#fd7e14";
        } else if (icon.toLowerCase() === "error") {
            color = "#dc3545";
        }
    }
    return Swal.fire({
        html: `<span class="font-16 ">${message}</span>`,
        icon: icon,
        confirmButtonColor: color,
        width: 400,
    });
}

function formatToCurrency(amount) {
    let ret = parseFloat(amount)
        .toFixed(2)
        .replace(/\d(?=(\d{3})+\.)/g, "$&,");
    if (ret === "NaN") {
        return "";
    } else return ret;
}

function somethingWentWrongHandler() {
    toaster(
        "Something went wrong ... Please wait a while and try again",
        "error"
    );
    setTimeout(() => {
        location.reload();
    }, 3000);
}

function validateEmail(email) {
    let emailRegx =
        /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return emailRegx.test(email);
}

function validatePhone(phoneNumber) {
    let phoneRegex =
        /^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/;
    return phoneRegex.test(phoneNumber);
}

function currencyConvertor(
    forexRate,
    amount = 0,
    fromCur = "SLL",
    toCur = "SLL"
) {
    let currencyPair1 = fromCur + "/ " + toCur;
    let currencyPair2 = toCur + "/ " + fromCur;
    let convertedAmount = 0;
    let currencyPair;
    let midrate = 0;
    let conversionData;

    $.each(forexRate, (i) => {
        if (forexRate[i].PAIR === currencyPair1) {
            midrate = forexRate[i].MIDRATE;
            convertedAmount = (
                parseFloat(amount) * parseFloat(midrate)
            ).toFixed(2);
            currencyPair = currencyPair1;
            conversionData = {
                convertedAmount,
                midrate,
                currencyPair,
            };
            return;
        } else if (forexRate[i].PAIR === currencyPair2) {
            midrate = forexRate[i].MIDRATE;
            convertedAmount = (
                parseFloat(amount) / parseFloat(midrate)
            ).toFixed(2);
            currencyPair = currencyPair2;
            conversionData = {
                convertedAmount,
                midrate,
                currencyPair,
            };
            return;
        }
    });
    return conversionData;
}

function getCurrencies() {
    return $.ajax({
        type: "GET",
        url: "get-currency-list-api",
        datatype: "application/json",
        tryCount: 0,
        retryLimit: 5,
        success: function (response) {
            let data = response.data;
            pageData.currencies = data;
            $(".currency_select").empty();
            $.each(data, function (index) {
                const selected = data[index].isoCode === "SLL";
                $(".currency_select").append(
                    `<option ${selected ? "selected" : ""} data-description=${
                        data[index].description
                    } data-currCode=${data[index].currCode} value=${
                        data[index].isoCode
                    }>
                        ${data[index].isoCode} </option>`
                );
            });
            // console.log("here");
            $(".currency_select").trigger("change").select2({
                minimumResultsForSearch: Infinity,
            });
        },
        error: function (xhr, textStatus, errorThrown) {
            if (textStatus == "timeout") {
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                    //try again
                    $.ajax(this);
                    return;
                }
                return;
            }
            if (xhr.status == 500) {
                $.ajax(this);
            } else {
                //handle error
            }
        },
    });
}

function getFx() {
    return $.ajax({
        type: "GET",
        url: "get-correct-fx-rate-api",
        datatype: "application/json",
        tryCount: 0,
        retryLimit: 5,
        success: function (response) {
            pageData.fxRate = response.data;
            // console.log("data", response.data);
        },
        error: function (xhr, textStatus, errorThrown) {
            if (textStatus == "timeout") {
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                    //try again
                    $.ajax(this);
                    return;
                }
                return;
            }
            if (xhr.status == 500) {
                $.ajax(this);
            } else {
                //handle error
            }
        },
    });
}

function getAccounts(account_data) {
    return $.ajax({
        type: "GET",
        url: "get-accounts-api",
        datatype: "application/json",
        tryCount: 0,
        retryLimit: 5,

        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            // console.log("getAccounts called ==>", response);

            if (response.responseCode !== "000") {
                // Swal.fire({
                //     html: `<span class="font-16 ">${response.message}</span>`,
                //     icon: "error",
                //     confirmButtonColor: "red",
                //     width: 400,
                //     didDestroy: () => {
                //         window.location = "logout";
                //     },
                // });
                // toaster(response.message, "error").then(() => console.log("okay"));
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            if (textStatus == "timeout") {
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                    //try again
                    $.ajax(this);
                    return;
                }
                return;
            }
            if (xhr.status == 500) {
                $.ajax(this);
            } else {
                //handle error
            }
        },
    });
}
function accountTemplate(account) {
    const data = $(account.element).attr("data-content");
    if (!data) return $(account.element).text();
    return $(data);
}

function getAccountOption(account) {
    let {
        accountDesc,
        accountMandate,
        currencyCode,
        accountNumber,
        accountType,
        availableBalance,
        currency,
    } = account;

    var thisAmount = formatToCurrency(availableBalance);
    // console.log("thisAmount ==>", thisAmount);
    let option = ` <option data-content="<div class='account-card row'>
<div class='col-2 text-center'><div class='account-icon mx-auto'><span>${accountDesc[0]}</span></div></div>
<div class='col-10 align-self-center'>
    <div class='font-16 font-weight-bold' style='line-height:1.2;'>${accountDesc}</div>
    <div class='d-flex'><div class='mr-auto font-14'>${accountNumber}</div>
    <div class='font-14'><span class='mr-1'>${currency}</span> <span>${availableBalance}</span></div>
</div></div>
</div>" data-account-type="${accountType}" data-account-number="${accountNumber}"
data-account-currency="${currency}" data-account-balance="${availableBalance}"
data-account-mandate="${accountMandate}" data-account-description="${accountDesc}"
data-account-currency-code="${currencyCode}"
value="${accountType}~${accountDesc}~${accountNumber}~${currency}~${availableBalance}~${currencyCode}~${accountMandate}">
${accountDesc} || ${accountNumber} || ${currency} ${thisAmount}
</option>`;
    return option;
}

function siteLoading(state) {
    if (state === "show") {
        $("#site_loader").css("background-color", "#e4f8f8");
        $("#site_loader").fadeIn(500, "linear");
        return;
    }
    $("#site_loader").fadeOut(1500, "linear");
    return;
}

function blockUi(data) {
    const defaults = {
        block: "#body",
        message: "Please Wait",
        size: "75px",
        bgColor: "#e4f8f8",
        opacity: "0.3",
    };
    data = Object.assign(defaults, data);
    const { block, message, size, bgColor, opacity } = data;
    $(block).block({
        message: `<div><img class="pulse " style="width: ${size};" src="assets/images/logoSLCB.png" />
            <div class="mt-2 row tw-relative"><span class="text-semibold align-self-center mx-2 font-weight-bold">
                ${message}</span><span class="lds-hourglass tw-absolute"></span> </div>`,
        overlayCSS: {
            backgroundColor: bgColor,
            opacity: opacity,
            cursor: "wait",
            "z-index": "9999",
        },
        css: {
            width: "100%",
            height: "100%",
            "backdrop-filter": "blur(3px)",
            // padding: "10px 15px",
            "-webkit-border-radius": 2,
            "-moz-border-radius": 2,
            border: 0,
            display: "flex",
            "justify-content": "center",
            "align-items": "center",
            "z-index": "99999",
            "font-size": "1rem",
            backgroundColor: "none",
        },
    });
}
function unblockUi(block = "#body") {
    // console.log(block);
    $(block).unblock();
}

function encodeString(stringToEncode) {
    return encodeURIComponent(btoa(stringToEncode));
}

function decodeString(stringToDecode) {
    return atob(decodeURIComponent(stringToDecode));
}

$("#sidebar_logout").on("click", (e) => {
    e.preventDefault();
    approve_request();

    // Swal.fire({
    //     title: "Logout successful!",
    //     html: "Redirecting ...",
    //     icon: "success",
    //     showConfirmButton: false,
    // });
    // setTimeout(() => {
    //     window.location.replace("logout");
    // }, 1000);

    // getOTP(105).then((data) => {
    //     console.log("logout otp==>", data);
    //     if (data.responseCode == "000") {
    //         approve_request();
    //     } else {
    //         error_alert(data.message, "#failed_login");
    //     }
    // });
    // return;
});
