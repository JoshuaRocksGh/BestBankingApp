let datatableOptions = {
    destroy: true,
    // lengthChange: false,
    pageLength: 5,
    responsive: true,
    columnDefs: [
        { responsivePriority: 1, targets: 8 },
        {
            //ignore time and render only dates
            targets: [3, 4, 6, 7],
            render: (data) => data.split(" ")[0],
        },
        // {
        //     targets: [8],
        //     render: (data) =>
        //         `<button class="text-white align-items-center btn  bg-danger cancel-order text-center" data-order-number="${data}"><i style="cursor: pointer;" class="fas fa-ban mr-1"></i> cancel</button>`,
        // },
        {
            // trancate with ellipses ex
            targets: "_all",
            render: function (data, type, row) {
                return data && data.length > 45 && !data.includes("<b")
                    ? data.substr(0, 45) + "…"
                    : data;
            },
        },
    ],
};

function getStandingOrderStatus(accountNumber) {
    siteLoading("show");
    $.ajax({
        type: "POST",
        url: "get-standing-order-status-api",
        data: { accountNumber },
        datatype: "application/json",

        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            $("#standing_order_display_area tbody").empty();
            console.log("get-standing-order-status-api ->", response);
            if (response.responseCode == "000") {
                let data = response.data;
                // let table = $("#standing_order_display_area").DataTable(
                //     datatableOptions
                // );
                let table = $("#standing_order_display_area").DataTable(
                    datatableOptions
                );
                table.clear();
                $.each(data, function (i, e) {
                    formattedAmount = `<b class="text-success float-right">${formatToCurrency(
                        e.dueAmount
                    )}</b>`;
                    extraData = JSON.stringify(e);
                    table.row
                        .add([
                            e.accountNumber,
                            e.beneficiaryAccount,
                            formattedAmount,
                            e.orderDate,
                            e.expiryDate,
                            e.frequency,
                            e.firstPaymentDate,
                            e.lastPaymentDate,
                            // e.orderNumber,
                            `<button class="text-white align-items-center btn  bg-danger cancel-order text-center" data-order-number="${e.orderNumber}" onclick="renderCancelButtons()"><i style="cursor: pointer;" class="fas fa-ban mr-1"></i> cancel</button>`,
                        ])
                        .order([0, "desc"])
                        .draw(false);
                });
                // renderCancelButtons();
            } else {
                toaster(response.message, "warning");
                $("#standing_order_display_area tbody").append(
                    `<td colspan="100%" class="text-center">
                    ${noDataAvailable} </td>`
                );
                $("#no_data_available_img").css("max-width", "200px");
            }
            siteLoading("hide");
        },
        error: function (xhr, status, error) {
            // setTimeout(function () {
            getStandingOrderStatus(accountNumber);
            // }, $.ajaxSetup().retryAfter);
        },
    });
}
function renderCancelButtons() {
    $(".cancel-order").on("click", (e) => {
        let orderNumber = $(e.currentTarget).attr("data-order-number");
        Swal.fire({
            title: "Do you want to cancel Standing Order?",
            // text: "You won't be able to revert this!",
            icon: "question",
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: "#18c40d",
            cancelButtonColor: "#df1919",
            confirmButtonText: " Proceed!",
        }).then((result) => {
            if (result.isConfirmed) {
                let pass = true;
                // if (ISCORPORATE) {
                // }
                $("#pin_code_modal").modal("show");

                $("#transfer_pin").on("click", () => {
                    if (!pass) {
                        return;
                    }
                    const pinCode = $("#user_pin").val();
                    if (!pinCode || pinCode.length !== 4) {
                        toaster("invalid pin", "warning");
                    } else {
                        cancelStandingOrder(orderNumber, pinCode);
                    }
                    pass = false;
                    $("#user_pin").val("");
                });
            }
        });
    });
}

function cancelStandingOrder(orderNumber, pinCode) {
    $.ajax({
        type: "POST",
        url: "cancel-standing-order-api",
        datatype: "application/json",
        data: {
            orderNumber: orderNumber,
            pinCode: pinCode,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: (response) => {
            console.log(response);
            toaster(response.message, "warning");
        },
        error: (xhr, status, error) => {
            console.log(xhr);
            toaster(error, "error");
        },
    });
}

$(function () {
    $(".accounts-select").select2({
        minimumResultsForSearch: Infinity,
        templateResult: accountTemplate,
        templateSelection: accountTemplate,
    });
    $("#from_account").on("change", function () {
        console.log("here");
        let accountNumber = $("#from_account option:selected").attr(
            "data-account-number"
        );
        getStandingOrderStatus(accountNumber);
    });
    $("#from_account").trigger("change");

    $(".cancel-order").click(function () {
        console.log("clicked");
    });
});
