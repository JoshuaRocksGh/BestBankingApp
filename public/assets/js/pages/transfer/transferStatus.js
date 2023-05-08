let datatableOptions = {
    destroy: true,
    // lengthChange: false,
    pageLength: 6,
    // searching: false,
    // scrollY: "500px",
    // info: false,
    // "scrollX":        true,
    // scrollCollapse: true,
    // paging: false,
    columnDefs: [
        {
            targets: "_all",
            render: function (data, type, row) {
                return data && data.length > 45 && !data.includes("<b")
                    ? data.substr(0, 45) + "…"
                    : data;
            },
        },
    ],
};

function getTransferStatus(customerNumber) {
    $.ajax({
        type: "GET",
        url: "get-transfer-status",
        data: { customerNumber },
        datatype: "application/json",

        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.responseCode == "000") {
                // console.log(response);
                let data = response.data;

                $("#transfer_status_body").empty();
                let table = $("#transfer_status_table").DataTable(
                    datatableOptions
                );
                // console.log(table);
                $.each(data, function (i) {
                    // console.log(data[i]);
                    formattedAmount = `<b class="text-success">${formatToCurrency(
                        data[i].amount
                    )}<b>`;
                    extraData = JSON.stringify(data[i]);
                    // console.log(extraData);
                    let button = `
                        <button type="button" class="btn btn-outline-primary btn-sm waves-effect waves-light" extra-data='${extraData}'> Details</button>`;
                    table.row
                        .add([
                            data[i].postingDate.split(" ")[0],
                            data[i].payerAccount,
                            data[i].beneficiaryAccount,
                            formattedAmount,
                            // data[i].payerAccountDescription,
                            data[i].status,
                            button,
                        ])
                        .order([0, "desc"])
                        .draw(false);
                });

                $("#transfer_status_table tbody").on(
                    "click",
                    "button",
                    function () {
                        let data = JSON.parse($(this).attr("extra-data"));
                        console.table(data);
                        $("#sender_name").text(data.payerAccountDescription);
                        $("#sender_account").text(data.payerAccount);
                        $("#sender_customer_number").text(data.customerNumber);
                        $("#beneficiary_name").text(data.beneficiaryName);
                        $("#beneficiary_account").text(data.beneficiaryAccount);
                        $("#beneficiary_bank").text(data.beneficiaryBank);
                        $("#transfer_amount").text(
                            formatToCurrency(data.amount)
                        );
                        $("#batch_number").text(data.batchNumber);
                        $("#transfer_channel").text(data.channel);
                        $("#transfer_date").text(data.postingDate);
                        $("#transfer_stage").text(data.stage);
                        $("#transfer_status").text(data.status);
                        $("#transfer_status_modal").modal("show");
                    }
                );
            }
        },
        error: function (xhr, status, error) {
            setTimeout(function () {
                getTransferStatus(customerNumber);
            }, $.ajaxSetup().retryAfter);
        },
    });
}

$(function () {
    $(".transfer_tab_btn").on("click", function () {
        getTransferStatus(customerNumber);
    });

    getTransferStatus(customerNumber);
});
