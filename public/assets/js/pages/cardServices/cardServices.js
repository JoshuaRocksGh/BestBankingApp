// TODO : Test the request Card method. especially the API response
const PageData = {};
function getBranches() {
    $.ajax({
        type: "GET",
        url: "get-branches-api",
        datatype: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            console.log(response);
            if (response.responseCode == "000") {
                const { data } = response;
                let branchesList = data;

                const select = document.getElementById("pick_up_branch");
                const select2 = document.getElementById("card_branch");
                const select3 = document.getElementById("activate_card_branch");

                branchesList.sort(function (a, b) {
                    let nameA = a.branchDescription.toUpperCase(); // convert name to uppercase
                    let nameB = b.branchDescription.toUpperCase(); // convert name to uppercase
                    if (nameA < nameB) {
                        return -1;
                    }
                    if (nameA > nameB) {
                        return 1;
                    }
                    return 0;
                });

                branchesList.forEach((e) => {
                    const option = document.createElement("option");
                    option.text = e.branchDescription;
                    option.value = e.branchCode;
                    select.appendChild(option);
                    // select2.appendChild(option);
                });
                branchesList.forEach((e) => {
                    const option = document.createElement("option");
                    option.text = e.branchDescription;
                    option.value = e.branchCode;
                    // select.appendChild(option);
                    select2.appendChild(option);
                });
                branchesList.forEach((e) => {
                    const option = document.createElement("option");
                    option.text = e.branchDescription;
                    option.value = e.branchCode;
                    // select.appendChild(option);
                    select3.appendChild(option);
                });
            } else {
                // setTimeout(function () {
                getBranches();
                // }, $.ajaxSetup().retryAfter);
            }
        },
        error: function (xhr, status, error) {
            getBranches();
        },
    });
}

// ===== CIB REQUEST ====

function corporateCardRequest({
    accountDetails,
    cardType,
    cardTypeName,
    pickUpBranch,
    pickUpBranchName,
}) {
    siteLoading("show");
    return $.ajax({
        type: "POST",
        url: "corporate-atm-card-request-api",
        datatype: "application/json",
        data: {
            accountDetails,
            cardType,
            cardTypeName,
            pickUpBranch,
            pickUpBranchName,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    }).done((response) => {
        console.log(response);
        if (response.responseCode == "000") {
            toaster(response.message, "success");
        } else {
            toaster(response.message, "error");
        }
    });
}

function corporateCardBlock({
    accountDetails,
    cardType,
    cardTypeName,
    cardBranch,
    cardBranchName,
    cardNumber,
}) {
    siteLoading("show");
    return $.ajax({
        type: "POST",
        url: "corporate-block-card-request-api",
        datatype: "application/json",
        data: {
            accountDetails,
            cardType,
            cardTypeName,
            cardBranch,
            cardBranchName,
            cardNumber,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    }).done((response) => {
        console.log(response);
        if (response.responseCode == "000") {
            toaster(response.message, "success");
        } else {
            toaster(response.message, "error");
        }
    });
}

// ====== END OF CIB REQUEST====

// ======= PIB REQUEST ==========
function requestCard({ accountNumber, cardType, pickUpBranch, pinCode }) {
    return $.ajax({
        type: "POST",
        url: "atm-card-request-api",
        datatype: "application/json",
        data: {
            accountNumber,
            cardType,
            pickUpBranch,
            pinCode,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    }).done((response) => {
        console.log("requestCard ==>", response);
        if (response.responseCode == "000") {
            toaster(response.message, "success");
        } else {
            toaster(response.message, "error");
        }
    });
}

function blockCard(data) {
    return $.ajax({
        type: "POST",
        url: "atm-card-block-api",
        datatype: "application/json",
        data,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    }).done((response) => {
        console.log(response);
        if (response.responseCode == "000") {
            toaster(response.message, "success");
        } else {
            toaster(response.message, "error");
        }
    });
}

function activateCard(data) {
    return $.ajax({
        type: "POST",
        url: "atm-card-activate-api",
        datatype: "application/json",
        data,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    }).done((response) => {
        console.log(response);
        if (response.responseCode == "000") {
            toaster(response.message, "success");
        } else {
            toaster(response.message, "error");
        }
    });
}

// ====== END OF PIB REQUEST ====

function getCardTypes() {
    $.ajax({
        type: "GET",
        url: "get-card-types-api",
        datatype: "application/json",
        success: function (response) {
            if (response.responseCode == "000") {
                const { data } = response;
                const select = document.getElementById("card_type");
                const select2 = document.getElementById("card_type_select");
                const select3 = document.getElementById("activate_card_type");
                data.forEach((e) => {
                    const option = document.createElement("option");
                    option.text = e.description;
                    option.value = e.actualCode;
                    select.appendChild(option);
                    // select2.appendChild(option);
                });
                data.forEach((e) => {
                    const option = document.createElement("option");
                    option.text = e.description;
                    option.value = e.actualCode;
                    // select.appendChild(option);
                    select2.appendChild(option);
                });
                data.forEach((e) => {
                    const option = document.createElement("option");
                    option.text = e.description;
                    option.value = e.actualCode;
                    // select.appendChild(option);
                    select3.appendChild(option);
                });
            } else {
                getCardTypes();
            }
        },
        error: function (xhr, status, error) {
            getCardTypes();
        },
    });
    // .done((response) => {
    //     if (response?.data) {

    // });
}

$(function () {
    // siteLoading("show");
    getCardTypes();
    getBranches();
    // Promise.all([getCardTypes(), getBranches()])
    //     .finally((e) => siteLoading("hide"))
    //     .catch((e) => {
    //         somethingWentWrongHandler(e);
    //     });

    $(".select").select2();
    $(".accounts-select").select2({
        minimumResultsForSearch: Infinity,
        templateResult: accountTemplate,
        templateSelection: accountTemplate,
    });

    $(".coming-soon").on("click", function (e) {
        e.preventDefault();
        comingSoonToast("");
    });
    // make card request
    $("#btn_card_request").on("click", (e) => {
        e.preventDefault();
        const accountNumber = $("#from_account option:selected").attr(
            "data-account-number"
        );
        const accountDetails = $("#from_account option:selected").val();
        const cardType = $("#card_type").val();
        const cardTypeName = $("#card_type option:selected").html();
        const pickUpBranch = $("#pick_up_branch").val();
        const pickUpBranchName = $("#pick_up_branch option:selected").html();
        const requestType = "Card Request";
        console.log("accountNumber ==>", accountNumber);
        // console.log("pickUpBranchName ==>", pickUpBranchName);
        if (!accountNumber || !cardType || !pickUpBranch) {
            toaster("Please complete all fields", "warning");
            return false;
        }
        PageData.cardRequest = {
            requestType,
            accountNumber,
            cardType,
            pickUpBranch,
            // pinCode,
        };

        if (ISCORPORATE) {
            corporateCardRequest({
                accountDetails,
                cardType,
                cardTypeName,
                pickUpBranch,
                pickUpBranchName,
            }).then(() => {
                siteLoading("hide");
            });
            return;
        }
        $("#pin_code_modal").modal("show");
    });

    // block card requestCard
    $("#btn_submit_block_card").on("click", (e) => {
        e.preventDefault();

        // alert("clicked");
        // return false;
        const accountNumber = $("#from_account option:selected").attr(
            "data-account-number"
        );
        var accountDetails = $("#from_account option:selected").val();
        var cardType = $("#card_type_select").val();
        var cardNumber = $("#card_number").val();
        var cardBranch = $("#card_branch").val();
        var cardBranchName = $("#card_branch option:selected").html();
        var cardTypeName = $("#card_type_select option:selected").html();

        if (!accountNumber || !cardType || !cardNumber || !cardBranch) {
            toaster("Please complete all fields", "warning");
            return false;
        }
        PageData.cardBlock = {
            accountNumber,
            cardType,
            cardNumber,
            cardBranch,
        };
        // console.log(PageData);
        // return;

        if (ISCORPORATE) {
            corporateCardBlock({
                accountDetails,
                cardType,
                cardTypeName,
                cardBranch,
                cardBranchName,
                cardNumber,
            }).then(() => {
                siteLoading("hide");
            });
            return;
        }
        $("#pin_code_modal").modal("show");
    });

    // acctivate card

    $("#btn_submit_activate_card").on("click", (e) => {
        e.preventDefault();

        // alert("clicked");
        // return false;
        const accountNumber = $("#from_account option:selected").attr(
            "data-account-number"
        );
        var accountDetails = $("#from_account option:selected").val();
        var cardType = $("#activate_card_type").val();
        var cardNumber = $("#activate_card_number").val();
        var cardBranch = $("#activate_card_branch").val();
        var cardBranchName = $("#activate_card_branch option:selected").html();
        var cardTypeName = $("#activate_card_type option:selected").html();

        if (!accountNumber || !cardType || !cardNumber || !cardBranch) {
            toaster("Please complete all fields", "warning");
            return false;
        }
        PageData.cardActivate = {
            accountNumber,
            cardType,
            cardNumber,
            cardBranch,
        };
        console.log(PageData);
        // return;
        $("#pin_code_modal").modal("show");
    });

    $("#transfer_pin").on("click", () => {
        const pinCode = $("#user_pin").val();
        console.log(pinCode);
        if (!pinCode || pinCode.length !== 4) {
            toaster("Please enter a valid pin code", "warning");
            return false;
        }
        siteLoading("show");
        if (PageData?.cardRequest) {
            PageData.cardRequest.pinCode = $("#user_pin").val();
        } else if (PageData?.cardBlock) {
            PageData.cardBlock.pinCode = $("#user_pin").val();
        } else if (PageData?.cardActivate) {
            PageData.cardActivate.pinCode = $("#user_pin").val();
        }

        //

        if (PageData.cardRequest) {
            // console.log(PageData);
            // return;
            // requestCard({
            //     accountNumber,
            //     accountDetails,
            //     cardType,
            //     pickUpBranch,
            //     pinCode,
            // }).then(() => {
            //     siteLoading("hide");
            // });

            requestCard(PageData.cardRequest).then(() => {
                siteLoading("hide");
            });
        } else if (PageData.cardBlock) {
            // (PageData.cardBlock.pinCode = pinCode),
            blockCard(PageData.cardBlock).then(() => {
                siteLoading("hide");
            });
        } else if (PageData.cardActivate) {
            // (PageData.cardBlock.pinCode = pinCode),
            activateCard(PageData.cardActivate).then(() => {
                siteLoading("hide");
            });
        } else {
            // alert("card block");
            siteLoading("hide");
        }
    });
});
