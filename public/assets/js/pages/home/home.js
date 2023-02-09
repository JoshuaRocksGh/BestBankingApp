// --------- PENDING APPROVAL ------------ //
// $("#approval_count").html(4);
// alert("welcome home");

function getCorporateRequests(customerNumber, requestStatus) {
    $.ajax({
        type: "GET",
        url:
            "get-pending-requests?customerNumber=" +
            customerNumber +
            "&requestStatus=" +
            requestStatus,
        datatype: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function ({ responseCode, data }) {
            if (responseCode !== "000" || !data) {
                return;
            }
            $(".request_table tr").remove();
            // console.log("data length =>", data);
            $("#approval_count").text(data.length > 0 ? data.length : 0);
            // $("#approval_count").text(data.length);
            // $("#approval_count").text("1");
            const tableOptions = {
                lengthChange: false,
                pageLength: 5,
            };
            const table = $(".pending_transaction_request").DataTable(
                tableOptions
            );

            const requestTypeExpanded = {
                OWN: "Own Account transfer",
                SAB: "Same Account transfer",
                ACH: "ACH transfer",
                RTGS: "RTGS transfer",
                SO: "Standing Order",
                BULK: "Bulk transfer",
                INTB: "International Transfer",
                CHQR: "Cheque Book Request",
                CHQS: "Stop Cheque",
                CARD: "Cardless Transfer",
                STR: "Statement Request",
                KORP: "Salone-Link",
                BKORP: "Bulk E-Korpor",
                UTL: "Utility Payment",
                AIR: "Airtime Payment",
                MOM: "Mobile Money Payment",
                BOL: "Bollore Transfer",
                CARDR: "ATM Card Request",
            };
            data.forEach((data) => {
                const {
                    narration,
                    postedby,
                    request_id: requestId,
                    request_type: requestType,
                    customer_no: customerNo,
                    currency,
                    account_no: accountNo,
                } = data;
                const date = new Date(data.post_date)
                    .toISOString()
                    .slice(0, 10);
                const amount = data.amount || data.total_amount;
                if (!amount || !currency) {
                    return;
                }
                const formattedAmount =
                    currency + " " + formatToCurrency(amount);
                const formattedRequestType =
                    requestTypeExpanded[requestType] || "Others";
                const actionButton = `
                <button type="button"
                    onclick="window.open('approvals-pending-transfer-details/${requestId}/${customerNo}'),
                        '_blank', 'location=yes,height=670,width=1200,scrollbars=yes,status=yes'"
                    class=" btn btn-xs btn-outline-info font-10"
                >
                    Details
                </button>
            `;
                table.row
                    .add([
                        requestId,
                        formattedRequestType,
                        accountNo,
                        formattedAmount,
                        narration,
                        date,
                        postedby,
                        actionButton,
                    ])
                    .order([0, "desc"])
                    .draw();
                table.column(0).visible(false);
            });
        },
        error: function (xhr, status, error) {},
    });
}
pageData.barColors = [
    "#F15BB5",
    "#007ECC",
    "#9B5DE5",
    "#00F5D4",
    "#F3704B",
    "#686770",
    "#99E9FF",
    "#00BBF9",
    "#FEE440",
];
function transactionsBarChart(transactions) {
    // check if transactions is an array
    // console.log("transactions =>", transactions);
    // return false;
    if (transactions?.length <= 0) {
        $("#transactionNoData").show();
        return;
    } //trim transactions to 30
    // console.log("transactions ===>", transactions);

    transactions = transactions?.slice(0, 10).reverse();
    // check for previous chart and destroy it if any
    let chartStatus = Chart.getChart("transactionsBarChart");
    if (chartStatus != undefined) {
        chartStatus.destroy();
    }
    const transactionAmount = transactions?.map(
        (transaction) => transaction.amount
    );
    const runningBalance = transactions?.map(
        (transaction) => transaction.runningBalance
    );
    const labels = transactions?.map((transaction) => {
        const date = new Date(transaction.postingSysDate).toLocaleString("en", {
            year: "numeric",
            month: "short",
            day: "numeric",
        });
        return date;
    });
    $("#transactionNoData").hide();
    new Chart("transactionsBarChart", {
        type: "line",
        data: {
            labels,
            datasets: [
                {
                    data: transactionAmount,
                    label: "Transaction Amount",
                    backgroundColor: "#00F5D4",
                },
                {
                    data: runningBalance,
                    label: "Account Balance",
                    backgroundColor: "#00BBF9",
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: "top",
                },
                title: {
                    display: true,
                    text: "Last 10 transactions",
                },
            },
            scales: {
                y: {
                    beginAtZero: false,
                },
            },
        },
    });
}
function accountsPieChart({ xValues = [], yValues = [], title }) {
    // check for previous chart and destroy it if any
    let chartStatus = Chart.getChart("accountsPieChart");
    if (chartStatus != undefined) {
        chartStatus.destroy();
    }
    new Chart("accountsPieChart", {
        type: "doughnut",
        data: {
            labels: xValues,
            datasets: [
                {
                    backgroundColor: pageData?.barColors,
                    data: yValues,
                },
            ],
        },
        options: {
            emptyDoughnut: {
                color: "#007ECC",
                width: 2,
                radiusDecrease: 20,
            },
            plugins: {
                legend: {
                    position: "top",
                },
                title: {
                    position: "top",
                    display: true,
                    text: title.toUpperCase(),
                },
            },
        },
    });
}

// PIE CHART NEW FUNCTIONS //

function getData({ url, name, data, method }) {
    return $.ajax({
        type: method ?? "GET",
        url,
        data,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        datatype: "application/json",
        success: function (response) {
            const { data } = response;
            pageData[name] = data;
        },
        error: function (xhr, status, error) {
            // console.log(xhr.status);
            // console.log(xhr.responseText);
        },
    });
}

function prepareGraphValues() {
    const accountsPie = {};
    const totalsPie = {
        xValues: ["Deposits", "Loans", "Investments"],
        yValues: [],
    };
    accountsPie.xValues = pageData?.accounts?.map((account) =>
        String(account.accountNumber)
    );
    // console.log("prepareGraphValue===>", pageData);

    //accounts
    let accountsTotal = 0;
    accountsPie.yValues = pageData?.accounts?.map((account) => {
        const amount =
            parseFloat(
                String(account.localEquivalentAvailableBalance).replace(
                    /,/g,
                    ""
                )
            ) || 0.0;
        accountsTotal += amount;
        return amount;
    });

    //loans
    const loansPie = {};
    loansPie.xValues = pageData?.loans?.map((loan) => String(loan.FACILITY_NO));
    let loansTotal = 0;
    loansPie.yValues = pageData?.loans?.map((loan) => {
        const amount = parseFloat(loan.LOAN_BALANCE) || 0.0;
        loansTotal += amount;
        return amount;
    });

    //investments
    const investmentsPie = {};
    investmentsPie.xValues = pageData?.investments?.map((investment) =>
        String(investment.sourceAccount)
    );
    let investmentsTotal = 0;
    investmentsPie.yValues = pageData?.investments?.map((investment) => {
        const amount = parseFloat(investment.currentBalance) || 0.0;
        investmentsTotal += amount;
        return amount;
    });

    totalsPie.yValues = [accountsTotal, loansTotal, investmentsTotal];
    pageData.pieValues = {
        accountsPie,
        loansPie,
        investmentsPie,
        totalsPie,
    };
}

const renderDataTables = (data, tableId) => {
    const noDataDisplay = `<div colspan='100%' class='text-center' >
    ${noDataAvailable}
</div>`;
    const datatableOptions = {
        searching: false,
        lengthChange: false,
        paging: false,
        responsive: true,
        info: false,
        language: {
            emptyTable: noDataDisplay,
            zeroRecords: noDataDisplay,
        },
    };
    function renderCurrency(data, row) {
        return `<div class="table-cur text-right"><span class="font-weight-bold">${formatToCurrency(
            parseFloat(data)
        )}</span></div>`;
    }

    $("#accounts_table")
        .DataTable({
            ...datatableOptions,
            responsive: {
                details: {
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                        tableClass: "table table-detail",
                    }),
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            const data = row.data();
                            return "Account Details";
                            // data["accountNumber"] +
                            // " " +
                            // data["accountDesc"]
                        },
                    }),
                },
            },
            data: pageData?.accounts,
            columns: [
                {
                    data: "accountNumber",
                    render: function (data) {
                        return `<a href='account-enquiry?ac=${encodeString(
                            data
                        )}'>${data}</a>`;
                    },
                },
                { data: "accountDesc" },
                { data: "accountType" },
                { data: "currency" },
                {
                    data: "ledgerBalance",
                    render: (data, type, row) => renderCurrency(data, row),
                },
                {
                    data: "availableBalance",
                    render: (data, type, row) => renderCurrency(data, row),
                },
                {
                    data: "odLimit",
                    render: (data, type, row) => renderCurrency(data, row),
                },
            ],
        })
        .draw();
    $("#investments_table")
        .DataTable({
            ...datatableOptions,
            responsive: {
                details: {
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                        tableClass: "table table-detail",
                    }),
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            const data = row.data();
                            return (
                                "Details for Investment with Account Number: " +
                                data["AccountNo"]
                            );
                        },
                    }),
                },
            },
            data: pageData.investments,
            columns: [
                {
                    data: "sourceAccount",
                },
                {
                    data: "dealAmount",
                    render: (data, type, row) => renderCurrency(data, row),
                },
                { data: "tenure" },
                {
                    data: "maturityDate",
                    render: (data) =>
                        new Date(data).toLocaleString("en", {
                            year: "numeric",
                            month: "short",
                            day: "numeric",
                        }),
                },
                { data: "rollover" },
            ],
        })
        .draw();
    $("#loans_table")
        .DataTable({
            ...datatableOptions,
            responsive: {
                details: {
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                        tableClass: "table table-detail",
                    }),
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            const data = row.data();
                            return (
                                "Details for " +
                                data["description"] +
                                " with facility Number: " +
                                data["facilityNo"]
                            );
                        },
                    }),
                },
            },
            data: pageData.loans,
            columns: [
                {
                    data: "FACILITY_NO",
                },
                { data: "DESCRIPTION" },
                { data: "ISO_CODE" },
                {
                    data: "AMOUNT_GRANTED",
                    render: (data, type, row) => renderCurrency(data, row),
                },
                {
                    data: "LOAN_BALANCE",
                    render: (data, type, row) => renderCurrency(data, row),
                },
            ],
        })
        .draw();
};

$(() => {
    $("select").select2();
    $(".accounts-select").select2({
        minimumResultsForSearch: Infinity,
        templateResult: accountTemplate,
        templateSelection: accountTemplate,
    });
    blockUi({ block: "#nav-tabContent" });
    // return;
    Promise.all([
        getData({ url: "fixed-deposit-account-api", name: "investments" }),
        // getData({ url: "get-loan-accounts-api", name: "loans" }),
        // getData({ url: "get-accounts-api", name: "accounts" }),
    ])
        .then((value) => {
            // siteLoading("hide");
            // pageData.accounts = @json(session()->get('userId'));
            // console.log("VALUES ==>", value);
            // console.log("promise.AllSetteled ==>", pageData);
            // return false

            prepareGraphValues();
            accountsPieChart({
                title: "Accounts",
                ...pageData.pieValues.totalsPie,
            });
            unblockUi("#nav-tabContent");
            renderDataTables();
        })
        .catch(function (err) {
            // dispatch a failure and throw error
            // console.log("error==>", err.responseText);
        });

    $(".canvas-tab").on("click", (e) => {
        const selectedTab = $(e.currentTarget).attr("data-target");
        // console.log(pageData.pieValues[selectedTab]?.yValues?.length);
        if (!pageData.pieValues[selectedTab]?.yValues?.length) {
        }
        $(".chart-no-data").attr(
            "hidden",
            !!pageData.pieValues[selectedTab]?.yValues?.length
        );
        accountsPieChart({
            title: selectedTab.slice(0, -3),
            ...pageData.pieValues[selectedTab],
        });
    });

    $(".toggle-account-visibility").on("click", function () {
        $(".eye-open").toggle();
        $(".open-money").toggleClass("password-font");
    });
    // all_my_account_balance();
    ISCORPORATE && getCorporateRequests(customer_no, "P");

    $("#chart_account").on("change", async function (e) {
        const target = $("#chart_account option:selected");
        const accountNumber = target.attr("data-account-number");
        const accountCurrency = target.attr("data-account-currency");
        // console.log("A", { target, accountCurrency, accountNumber });
        const today = new Date();
        let startDate = new Date(today.setMonth(today.getMonth() - 300))
            .toISOString()
            .split("T")[0];
        const endDate = new Date().toISOString().split("T")[0];
        const transLimit = "20";
        blockUi({ block: "#acc_history" });
        getData({
            url: "account-transaction-history",
            name: "transactions",
            method: "POST",
            data: {
                accountNumber,
                startDate,
                endDate,
                transLimit,
            },
        }).then((data) => {
            $("account-transaction-history", data);
            unblockUi("#acc_history");
            transactionsBarChart(pageData.transactions);
            // console.log("trans", pageData);
        });
    });
    $("#chart_account").trigger("change");
});
