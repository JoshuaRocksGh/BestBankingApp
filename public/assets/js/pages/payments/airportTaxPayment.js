// alert("here");
function getAirporTaxAmount() {
    $.ajax({
        type: "GET",
        url: "get-airport-tax-amount",
        datatype: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            res = JSON.parse(response);
            console.log("getAirporTaxAmount ==>", res);
            // console.log("getAirporTaxAmount ==>", response);

            if (res.responseCode == "000") {
                $.each(res.data, function (index) {
                    $(".display_airport_tax_amount").append(
                        `
                            <div class="form-group align-items-center  bg-light p-2 col-md-5" style="border-radius: 5px">

                            <h3 class="text-center font-weight-bold">${res.data[index]?.CURRENCY}: ${res.data[index]?.AMOUNT}</h3>

                        </div>
                        <div class="col-md-2"></div>

                        `
                    );
                });
            }
        },
    });
}

function personalAirportTax(data) {
    // console.log("data ==>", data);
    siteLoading("show");
    $.ajax({
        type: "POST",
        url: "airport-tax-payment-api",
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

$(document).ready(function () {
    const airportTaxInfo = new Object();

    getAirporTaxAmount();
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
        // console.log(getValues[3]);

        if (getValues[3] == "USD") {
            console.log("USD");
            $(".key_transfer_amount").val("25.00");
            $(".display_transfer_amount").val("25.00");
            var transferAmount = "25";
            airportTaxInfo.transferAmount = 25;
        } else {
            console.log("SLE");
            $(".key_transfer_amount").val("400.00");
            $(".display_transfer_amount").val("400.00");
            var transferAmount = "400";
            airportTaxInfo.transferAmount = 400;
        }
    });

    $("#confirm_next_button").click(function (e) {
        e.preventDefault();

        airportTaxInfo.accountDetails = $("#account_of_transfer").val();
        airportTaxInfo.passportNumber = $("#passport_number").val();
        airportTaxInfo.flightNumber = $("#flight_number").val();
        airportTaxInfo.flightDate = $("#flight_date").val();

        if (
            !airportTaxInfo.accountDetails ||
            !airportTaxInfo.passportNumber ||
            !airportTaxInfo.flightNumber ||
            !airportTaxInfo.flightDate
        ) {
            console.log(airportTaxInfo);
            toaster("All Fields are required", "warning");
            return;
        }
        siteLoading("show");

        $("#display_passport_number").text(airportTaxInfo.passportNumber);
        $("#display_flight_number").text(airportTaxInfo.flightNumber);
        $("#display_flight_date").text(airportTaxInfo.flightDate);

        getOTP(311).then((data) => {
            // console.log(data);
            if (data.responseCode == "000") {
                siteLoading("hide");

                $("#transaction_summary").toggle(500);
                $("#airport_tax_payment").hide();
                return;
            } else {
                siteLoading("hide");

                toaster(data.message, "warning");
                return;
            }
        });
    });

    $("#back_button").click(function (e) {
        e.preventDefault();

        $("#transaction_summary").hide();
        $("#airport_tax_payment").toggle(500);
    });

    $("#confirm_transfer_button").on("click", (e) => {
        e.preventDefault();
        // console.log(airportTaxInfo);

        if (!$("#terms_and_conditions").is(":checked")) {
            toaster("Accept Terms & Conditions to continue", "warning");
            return false;
        }

        var otp = $("#transfer_otp").val();
        if (!otp) {
            toaster("Enter Valid OTP", "warning");
            return;
        }
        siteLoading("show");
        // makeTransfer(bolloreInfo);
        // if (!validationsCompleted) {
        //     somethingWentWrongHandler();
        //     return false;
        // }
        // confirmationCompleted = true;
        if (ISCORPORATE) {
            // corporateSpecific(transferInfo);
            return;
        }
        validateOTP(otp, 311).then((data) => {
            // console.log("verifyOTP==>", data);
            if (data.responseCode == "000") {
                siteLoading("hide");
                $("#pin_code_modal").modal("show");
            } else {
                siteLoading("hide");

                toaster(data.message, "error");
            }
            return;
        });
        // $("#pin_code_modal").modal("show");
    });

    $("#transfer_pin").click(function (e) {
        e.preventDefault();
        let userPin = $("#user_pin").val();
        // console.log(userPin);

        if (userPin.length !== 4) {
            toaster("invalid pin", "warning");
            $("#user_pin").val("");
            userPin = "";
            return false;
        }

        airportTaxInfo.userPin = $("#user_pin").val();

        personalAirportTax(airportTaxInfo);
    });
});
