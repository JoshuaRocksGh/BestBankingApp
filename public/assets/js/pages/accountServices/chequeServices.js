// TODO : Test the request Card method. especially the API response
if (ISCORPORATE) {
    var url = "corporate-chequebook-request";
} else {
    var url = "cheque-book-request-api";
}
const PageData = {};
function getBranches() {
    $.ajax({
        type: "GET",
        url: "get-branches-api",
        datatype: "application/json",
    }).done((response) => {
        console.log(response);
        if (response?.data) {
            const { data } = response;
            const select = document.getElementById("pick_up_branch");
            data.forEach((e) => {
                const option = document.createElement("option");
                option.text = e.branchDescription;
                option.value = e.branchCode;
                select.appendChild(option);
            });
        }
    });
}

$(".coming-soon").on("click", (e) => {
    e.preventDefault();
    comingSoonToast("Stay tuned for more features");
});

function submitChequeRequest(data) {
    // console.log(data);
    return $.ajax({
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "application/json",
        url: url,
        data,
        beforeSend: (xhr) => {
            siteLoading("show");
        },
    })
        .always((e) => siteLoading("hide"))
        .done((response) => {
            console.log(response);
            if (response?.data) {
                const { data } = response;
                if (data.responseCode === "000") {
                    toaster(data.message, "success");
                    $("#cheque_request_form")[0].reset();
                } else {
                    toaster(data.message, "error");
                }
            }
        })
        .fail((e) => {
            console.log(e.responseText);
            const res = JSON.parse(e.responseText);
            if (res?.message) {
                toaster(res.message, "error");
                return;
            }
            toaster("Something went wrong", "error");
        });
}

function submitChequeBlock(data) {
    // console.log(data);

    if (ISCORPORATE) {
        var url = "corporate-chequebook-block";
    } else {
        var url = "cheque-book-block-api";
    }
    // var url = "cheque-book-block-api";

    return $.ajax({
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "application/json",
        url: url,
        data,
        beforeSend: (xhr) => {
            siteLoading("show");
        },
    })
        .always((e) => siteLoading("hide"))
        .done((response) => {
            console.log(response);
            if (response?.data) {
                const { data } = response;
                if (data.status === "success") {
                    toaster(data.message, "success");
                    $("#cheque_request_form")[0].reset();
                } else {
                    toaster(data.message, "error");
                }
            }
        })
        .fail((e) => {
            console.log(e.responseText);
            const res = JSON.parse(e.responseText);
            if (res?.message) {
                toaster(res.message, "error");
                return;
            }
            toaster("Something went wrong", "error");
        });
}

$(function () {
    siteLoading("show");
    Promise.all([getBranches()])
        .finally((e) => siteLoading("hide"))
        .catch((e) => {
            somethingWentWrongHandler(e);
        });

    $("select").select2();
    $(".accounts-select").select2({
        minimumResultsForSearch: Infinity,
        templateResult: accountTemplate,
        templateSelection: accountTemplate,
    });

    $("#btn_submit_cheque_request").on("click", (e) => {
        e.preventDefault();
        const accountNumber = $("#from_account option:selected").attr(
            "data-account-number"
        );
        let accountMandate = $("#from_account option:selected").attr(
            "data-account-mandate"
        );
        // const chequeName = $("#cheque_name").val();
        const leaflets = $("#no_of_leaflets").val();
        const branchCode = $("#pick_up_branch").val();
        const branchName = $("#pick_up_branch option:selected").html();
        const chequeRequestType = "Request";

        console.log({ leaflets, branchCode, accountNumber });
        if (!accountNumber || !leaflets || !branchCode) {
            toaster("Please fill all the fields", "warning");
            return;
        }
        PageData.chequeRequestData = {
            accountNumber,
            leaflets,
            branchCode,
            accountMandate,
            branchName,
            chequeRequestType,
        };
        if (!ISCORPORATE) {
            $("#pin_code_modal").modal("show");
        } else {
            submitChequeRequest(PageData.chequeRequestData);
        }
    });

    $("#btn_submit_cheque_block").on("click", (e) => {
        e.preventDefault();
        // alert("herrrrrr");

        const accountNumber = $("#from_account option:selected").attr(
            "data-account-number"
        );
        let accountMandate = $("#from_account option:selected").attr(
            "data-account-mandate"
        );
        let accountDetails = $("#from_account option:selected").val();

        const beneficiaryName = $("#beneficiaryName").val();
        const chequeAmount = $("#chequeAmount").val();
        const issueDate = $("#issueDate").val();
        const startCheque = $("#startCheque").val();
        const endCheque = $("#endCheque").val();
        const chequeRequestType = "Block";

        PageData.chequeBlockData = {
            accountNumber,
            beneficiaryName,
            chequeAmount,
            accountMandate,
            issueDate,
            startCheque,
            endCheque,
            chequeRequestType,
            accountDetails,
        };

        if (
            !beneficiaryName ||
            !chequeAmount ||
            !issueDate ||
            !startCheque ||
            !endCheque
        ) {
            toaster("Please fill all the fields", "warning");
            return;
        }

        if (ISCORPORATE) {
            submitChequeBlock(PageData.chequeBlockData);

            // $("#pin_code_modal").modal("show");
        } else {
            // submitChequeBlock(PageData.chequeBlockData);
            $("#pin_code_modal").modal("show");
        }
    });

    $("#transfer_pin").on("click", (e) => {
        e.preventDefault();
        const pinCode = $("#user_pin").val();
        if (!pinCode) {
            toaster("Please enter the pin code", "warning");
            return;
        }
        if (pinCode.length !== 4) {
            toaster("Pin code must be 4 digits", "warning");
            return;
        }
        // console.log(PageData);
        // console.log(PageData.chequeBlockData);
        // console.log(pinCode);

        // PageData.chequeRequestData.pinCode = pinCode;

        // return false;

        if (PageData.chequeRequestData) {
            PageData.chequeRequestData.pinCode = $("#user_pin").val();
            console.log(PageData.chequeRequestData);
            // return false;
            submitChequeRequest(PageData.chequeRequestData);
            $("#user_pin").val("");
        } else if (PageData.chequeBlockData) {
            PageData.chequeBlockData.pinCode = $("#user_pin").val();
            console.log(PageData.chequeBlockData);
            // return false;
            submitChequeBlock(PageData.chequeBlockData);
            $("#user_pin").val("");
        } else {
            return;
        }
    });
});
