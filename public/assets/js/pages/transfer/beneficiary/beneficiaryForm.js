// let beneficiaryDetails;
function getLocalBanks() {
    return $.ajax({
        type: "GET",
        url: "get-bank-list-api",
        datatype: "application/json",
        success: function (response) {
            let data = response.data;
            if (data.length > 1) {
                // console.log(data.sort());
                let myBanksArray = data;
                myBanksArray.sort(function (a, b) {
                    let nameA = a.bankDescription.toUpperCase(); // convert name to uppercase
                    let nameB = b.bankDescription.toUpperCase(); // convert name to uppercase
                    if (nameA < nameB) {
                        return -1;
                    }
                    if (nameA > nameB) {
                        return 1;
                    }
                    return 0;
                });

                // console.log(myArray);
                $("#select_bank").empty();
                $("#select_bank").append(
                    `<option selected disabled value=""> --- Select Bank ---</option>`
                );
                $.each(data, (i) => {
                    let { bankCode, bankDescription, bankSwiftCode } =
                        myBanksArray[i];
                    option = `<option value="${bankCode}" swift-code="${bankSwiftCode}">${bankDescription}</option>`;
                    $("#select_bank").append(option);
                });
                // $("#select_bank").append("refresh");
                // $("#account_number").attr("disabled", false);
            } else {
                toaster(response.message);
            }
        },
    });
}

function getCountries() {
    return $.ajax({
        type: "GET",
        url: "get-countries-list-api",
        datatype: "application/json",
        success: function (response) {
            let data = response.data;
            if (data.length > 1) {
                // console.log("myCountriesArray", data);
                let myCountriesArray = data;
                myCountriesArray.sort(function (a, b) {
                    let nameA = a.description.toUpperCase(); // convert name to uppercase
                    let nameB = b.description.toUpperCase(); // convert name to uppercase
                    if (nameA < nameB) {
                        return -1;
                    }
                    if (nameA > nameB) {
                        return 1;
                    }
                    return 0;
                });

                // console.log(myCountriesArray);
                $("#select_country").empty();
                $("#select_country").append(
                    `<option selected disabled value=""> --- Select Country ---</option>`
                );
                $.each(data, (i) => {
                    let { actualCode, codeType, description } =
                        myCountriesArray[i];
                    option = `<option value="${codeType}"  data-country-code="${actualCode}">${description}</option>`;
                    $("#select_country").append(option);
                });
            } else {
                toaster(response.message);
            }
        },
    });
}

function getInternationalBanks(countryCode) {
    return $.ajax({
        type: "GET",
        url: "get-international-bank-list-api",
        data: {
            countryCode,
        },
        datatype: "application/json",
        success: function (response) {
            // console.log("international ==>", response)
            let data = response.data;

            // console.log("myInternationalBanks", data);
            let myInternationalBanks = data;
            myInternationalBanks.sort(function (a, b) {
                let nameA = a.BANK_DESC.toUpperCase(); // convert name to uppercase
                let nameB = b.BANK_DESC.toUpperCase(); // convert name to uppercase
                if (nameA < nameB) {
                    return -1;
                }
                if (nameA > nameB) {
                    return 1;
                }
                return 0;
            });

            // console.log(myInternationalBanks);
            $("#select_bank").empty();
            $("#select_bank").append(
                `<option selected disabled value=""> --- Select Bank ---</option>`
            );
            if (data && data.length > 1) {
                // data = data.sort((a, b) => a.COUNTRY - b.COUNTRY);
                $.each(data, (i) => {
                    let { BICODE, BANK_DESC, COUNTRY } =
                        myInternationalBanks[i];
                    option = `<option swift-code="${BICODE}" data-bank-country="${COUNTRY}" >${BANK_DESC}</option>`;
                    $("#select_bank").append(option);
                });

                // select bank if any is attached to country and clear
                const selectedBank = $("#select_country").attr("data-bank");
                if (selectedBank) {
                    $("#select_bank").val(`${selectedBank}`).trigger("change");
                    $("#select_country").attr("data-bank", "");
                }
                $("#select_bank").attr("disabled", false);
                $("#select_bank");
            } else {
                toaster(response.message);
            }
        },
    });
}
function saveBeneficiary(data) {
    console.log("saveBeneficiary ==>", data);
    // return;
    // siteLoading("show");
    $.ajax({
        type: "POST",
        url: "save-transfer-beneficiary-api",
        datatype: "application/json",
        data,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: (res) => {
            console.log("save-transfer-beneficiary-api ==>", res);
            siteLoading("hide");
            if (res.responseCode === "000") {
                beneficiarySaved();
            } else {
                toaster(res.message, "error");
            }
        },
        error: (err) => {
            siteLoading("hide");
            toaster(err.statusText, "error");
        },
    });
}

function deleteBeneficiary(beneficiaryId) {
    $.ajax({
        type: "DELETE",
        url: "delete-transfer-beneficiary-api",
        datatype: "application/json",
        data: { beneficiaryId },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: (res) => {
            if (res.responseCode === "000") {
                $("#edit_modal").modal("hide");
                beneficiaryDeleted();
            } else {
                toaster(res.message, "error");
            }
        },
        error: (err) => {
            toaster(err.statusText, "error");
        },
    });
}

//validate same bank account number
function getAccountDescription(accountNumber) {
    // console.log("Account description ==>", accountNumber);
    return $.ajax({
        type: "POST",
        url: "get-account-description",
        datatype: "application/json",
        data: {
            accountNumber,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: (res) => {
            console.log("getAccountDescription ==>", res);
            // return;
            const { data, message, responseCode } = res;
            const { accountCurrencyIso, accountDescription } = data;
            // const { accountDescription } = data;
            if (responseCode === "000") {
                // console.log(res);
                $("#account_name").val(accountDescription);
                $("#account_currency").val(accountCurrencyIso);
                !accountDescription && toaster("Account Not Found", "warning");
            } else {
                $("#account_name").val("");
                // console.log("Ac");
                $("#account_currency").val("");
                toaster(message, "error");
            }
        },
        error: (xhr, error, status) => {
            // console.log("Acv");
            $("#account_name").val("");
            toaster(status, "error");
        },
    });
}

//Adding Beneficiary
async function addBankBeneficiary(currentType) {
    await prepareBeneficiaryForm(currentType, "Add");
    $("#delete_btn").hide();
    $(".modal-footer").removeClass("justify-content-between");
    $("#edit_modal").modal("show");
}
async function prepareBeneficiaryForm(currentType, mode) {
    // console.log(currentType, mode);
    // console.log("prepareBeneficiaryForm currentType ==>", currentType);
    // console.log("prepareBeneficiaryForm mode ==>", mode);
    // return;
    $("#edit_modal").attr("data-mode", mode);
    $("#edit_modal").attr("data-type", currentType);
    if (currentType === "SAB") {
        $("#account_number_search").show();
        $("#beneficiary_form_title").text(`${mode} Same Bank Beneficiary`);
        $("#account_number").on("change", () => {
            $("#account_name").val("");
            $("#account_currency").val("");
        });
        $("#account_number_search").on("click", async () => {
            if ($("#account_number").val().length >= ACCOUNT_NUMBER_LENGTH) {
                blockUi({ block: "#beneficiary_form" });
                await getAccountDescription($("#account_number").val());
                unblockUi("#beneficiary_form");
            } else {
                toaster("invalid account length", "warning");
            }
        });

        $(".same-bank-form").show();
    } else if (currentType === "OTB") {
        $("#beneficiary_form_title").text(`${mode} Local Bank Beneficiary`);
        $(".other-bank-form").show();
        $("#account_name").attr("disabled", false);
        await getLocalBanks();
    } else if (currentType === "INTB") {
        $("#beneficiary_form_title").text(
            `${mode} International Bank Beneficiary`
        );
        await getCountries();
        $("#select_country").on("change", (e) => {
            blockUi({ block: "#beneficiary_form" });
            getInternationalBanks($("#select_country").val()).always(() => {
                unblockUi("#beneficiary_form");
            });
        });
        $(".international-bank-form").show();
        $("#account_name").attr("disabled", false);
        $("#select_bank").attr("disabled", true);
    }
    $("select").select2({ dropdownParent: $("#edit_modal") });
}

//editting beneficiary
async function editBankBeneficiary(data, type) {
    console.table("editBankBeneficiary data ==>", data);
    console.table("editBankBeneficiary type ==>", type);
    // return;
    await prepareBeneficiaryForm(type, "Edit");
    if (data.BENEF_TYPE === "OTB") {
        $(".other-bank-form").show();
        $("#select_bank").val(`${data.BANK_SWIFT_CODE}`).trigger("change");
    }
    if (data.BENEF_TYPE === "INTB") {
        $(".international-bank-form").show();
        $("#select_country")
            .val(`${data.BANK_COUNTRY}`)
            .attr("data-bank", `${data.BANK_SWIFT_CODE}`)
            .trigger("change");
    }

    $("#account_number").val(data.BEN_ACCOUNT);
    $("#account_number_search").trigger("click");
    $("#account_name").val(data.FIRST_NAME);
    $("#beneficiary_email").val(data.EMAIL);
    $("#beneficiary_address").val(data.ADDRESS_1);
    $("#beneficiary_name").val(data.NICKNAME);
    if (data.SEND_MAIL && data.SEND_MAIL.toUpperCase() !== "N") {
        // console.log("A");
        $("#send_email_check").prop("checked", true);
    }
    beneficiaryDetails.beneficiaryId = data.BENE_ID;
    // prepopulate bene form
    $("#edit_modal").modal("show");
}

function initBeneficiaryForm() {
    beneficiaryDetails = {};

    $("#save_btn").click(function () {
        console.log("beneficiaryDetails ==>", beneficiaryDetails);

        if (!validateFormInputs()) {
            return false;
        }

        if (!beneficiaryDetails.beneficiaryOTP) {
            toaster("Enter OTP to continue", "warning");
            return false;
        }
        // return;

        // siteLoading("show");

        validateOTP(beneficiaryDetails.beneficiaryOTP, 504).then((data) => {
            if (data.responseCode == "000") {
                console.log("verifyOTP==>", data.responseCode);
                //console.log("saveBeneficiary==>", beneficiaryDetails);
                // return;);

                // $("#pin_code_modal").modal("show");
                // siteLoading("hide");

                saveBeneficiary(beneficiaryDetails);
                // return;
            } else {
                // siteLoading("hide");

                toaster(data.message, "error");
                // return;
            }
            // return;
        });
    });

    $("#delete_btn").on("click", () => {
        // getOTP(505).then((data) => {
        //     console.log("delete_btn ==>", data);
        //     return;
        //     if (data.responseCode == "000") {

        //     } else {
        //         toaster(data.message, "warning");
        //     }
        // });
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                deleteBeneficiary(beneficiaryDetails.beneficiaryId);
            }
        });
    });
}

function validateFormInputs() {
    const type = $("#edit_modal").attr("data-type").toUpperCase();
    const mode = $("#edit_modal").attr("data-mode").toUpperCase();

    const accountNumber = $("#account_number").val();
    let bankName = $("#select_bank option:selected").text();
    // const bankCode = $("#select_bank").val();
    const bankCode = $("#select_bank option:selected").attr("swift-code");
    const bankCountry = $("#select_country option:selected").val();
    const beneficiaryName = $("#beneficiary_name").val();
    const beneficiaryEmail = $("#beneficiary_email").val();
    const beneficiaryAddress = $("#beneficiary_address").val();
    const accountName = $("#account_name").val();
    const beneficiaryOTP = $("#beneficiary_otp").val();
    //same bank beneficiary checks

    console.log("beneficiaryOTP==<", beneficiaryOTP);
    if (type === "SAB") {
        // bankName = "SIERRA LEONE COMMERCIAL BANK";
        bankName = "PUBLIC BANK LTD";
        if (!accountName) {
            toaster("Invalid Account Information", "warning");
            return false;
        }
        if (!beneficiaryName) {
            toaster("all fields required", "warning");
            return false;
        }
    } else {
        if (
            !accountNumber ||
            !bankCode ||
            !bankName ||
            !beneficiaryAddress ||
            !beneficiaryName ||
            !beneficiaryEmail
        ) {
            toaster("all fields required", "warning");
            return false;
        }
        if (!validateEmail(beneficiaryEmail)) {
            toaster("invalid email", "warning");
            return false;
        }
        if (accountNumber < ACCOUNT_NUMBER_LENGTH) {
            toaster("invalid account", "warning");
            return false;
        }
    }

    if ($("#send_email_check").prop("checked")) beneficiaryDetails.notify = "Y";
    const bD = {
        accountNumber,
        accountName,
        bankCode,
        bankName,
        beneficiaryName,
        beneficiaryEmail,
        beneficiaryAddress,
        type,
        mode,
        bankCountry,
        beneficiaryOTP,
    };
    // console.log(beneficiaryDetails);

    beneficiaryDetails = Object.assign(beneficiaryDetails, bD);
    // console.log(beneficiaryDetails);

    return true;
}

$(() => {
    //delete default select2 created by global
    $("select").select2("destroy");
    initialModalHtml = $("#edit_modal").html();
    initBeneficiaryForm();
    $("#edit_modal").on("hidden.bs.modal", (e) => {
        $("#edit_modal").html(initialModalHtml);
        initBeneficiaryForm();
    });
});
