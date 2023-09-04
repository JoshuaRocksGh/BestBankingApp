function getLocalBanks() {
    return $.ajax({
        type: "GET",
        url: "get-bank-list-api",
        datatype: "application/json",
        success: function (response) {
            let data = response.data;
            if (data.length > 1) {
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
                $("#onetime_select_bank").empty();
                $("#onetime_select_bank").append(
                    `<option selected disabled value=""> --- Select Bank ---</option>`
                );
                $.each(data, (i) => {
                    let { bankCode, bankDescription, bankSwiftCode } =
                        myBanksArray[i];
                    option = `<option value="${bankCode}" data-bank-swift-code="${bankSwiftCode}">${bankDescription}</option>`;
                    $("#onetime_select_bank").append(option);
                });
                // $("#onetime_select_bank").selectpicker("refresh");
            } else {
                toaster(response.message);
            }
        },
        error: function (xhr, status, error) {
            setTimeout(function () {
                getLocalBanks();
            }, $.ajaxSetup().retryAfter);
        },
    });
}

$(document).ready(function () {
    getLocalBanks();
    let transferInfo = {};
    let fromAccount = {};

    $("#onetime_tab").on("click", () => {
        console.log("onetime");
    });

    $("#from_account").on("change", function () {
        let accountInfo = $(this).val();

        if (!accountInfo) {
            $(".display_from_account").val("").text("");
            $(".account_currency").text("SLL");
            return false;
        }
        const accountData = accountInfo.split("~");
        // let accountType = accountData[0].trim();
        let accountName = accountData[1].trim();
        let accountNumber = accountData[2].trim();
        let accountCurrency = accountData[3].trim();
        let accountBalance = parseFloat(accountData[4].trim());
        let accountCurrencyCode = accountData[5].trim();
        let accountMandate = accountData[6];
        fromAccount = {
            accountName,
            accountNumber,
            accountCurrency,
            accountBalance,
            accountCurrencyCode,
            accountMandate,
        };
        $(".display_from_account_name").text(accountName);
        $(".display_from_account_no").text(accountNumber);
        $(".display_from_account_currency").text(accountCurrency);
        $(".account_currency").text(accountCurrency).val(accountCurrency);
        $(".display_from_account_balance").text(
            formatToCurrency(accountBalance)
        );
    });

    $("#amount").on("keyup", function () {
        transferInfo.transferAmount = $(this).val();
        console.log("#amount==>", transferInfo.transferAmount);
        // if (!transferInfo.transferAmount) {
        //     $(".display_transfer_amount").text("");
        //     $(".display_transfer_currency").text("");
        //     return false;
        // }
        // if (!fromAccount.accountCurrency && !transferInfo.transferCurrency) {
        //     $(".display_transfer_currency").text("SLL");
        // } else {
        //     $(".display_transfer_currency").text(
        //         transferInfo?.transferCurrency || fromAccount.accountCurrency
        //     );
        // }
        // $(".display_transfer_amount").text(
        //     formatToCurrency(transferInfo.transferAmount)
        // );

        // if (transferType === "International Bank") {
        //     convertToLocalCurrency();
        // }
        // if (
        //     transferInfo.transferAmount == "" ||
        //     transferInfo.transferAmount == null
        // ) {
        //     formatToCurrency("");
        // }
        $(".key_transfer_amount").val(
            formatToCurrency(transferInfo.transferAmount)
        );
    });

    $("#select_bank").on("change", () => {
        transferInfo.bankCode = $("#select_bank").val();
        transferInfo.bankName = $("#select_bank option:selected").text();
        $(".display_to_bank_name").text(onetimeToAccount.bankName);
    });

    $("#onetime_account_number").on("keyup", function () {
        if (fromAccount.beneficiaryAccountNumber === $(this).val()) {
            return false;
        }
        fromAccount.beneficiaryAccountNumber = "";
        if ($(this).val() === fromAccount.beneficiaryAccountNumber) {
            toaster("Cannot send to same account", "warning");
            return false;
        }
        fromAccount.beneficiaryAccountNumber = $(this).val();
        // if (transferType === "Same Bank") {
        //     if (onetimeToAccount.beneficiaryAccountNumber.length > 17) {
        //         getAccountDescription(onetimeToAccount);
        //     }
        // } else {
        //     handleToAccount(onetimeToAccount);
        // }
    });
});
