const pdfData = new Object();

function getAccountTransactions(accountNumber, startDate, endDate) {
    // pdfData.details = {
    //     accountNumber,
    //     startDate,
    //     endDate,
    // };
    return $.ajax({
        type: "POST",
        url: "account-transaction-history",
        datatype: "application/json",
        data: {
            accountNumber: accountNumber,
            endDate: endDate,
            entrySource: "A",
            startDate: startDate,
            transLimit: "20",
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            console.log("account-transaction-history =>", response);

            if (response.responseCode !== "000" || response.data.length === 0) {
                if (PageData?.prompt) {
                    toaster(response.message, "warning");
                }
                PageData.transaction = [];
            } else {
                const validTrans = []

                validTrans.push({
                    'postingSysDate' : response.summary.startDate,
                    'transactionDetails': "BALANCE BROUGHT FORWARD",
                    'balance' : response.summary.openingBalance,
                    'amount': 0,
                    'batchNumber': "",
                    'documentReference' : ""
                })
                const getDates = response.data
                getDates.forEach(e => validTrans.push(e) )
                // validTrans.
                const compareDates = (date1, date2) => {
                    return new Date(date2.postingSysDate) - new Date(date1.postingSysDate)
                }
                const dateEvents = validTrans.slice().sort((date1, date2) => new Date(date1.postingSysDate) - new Date(date2.postingSysDate))
                // getDates.sort(compareDates)
                console.log('validTrans=>', validTrans)
                // PageData.transaction = response.data;
                PageData.transaction = dateEvents;
                PageData.transactionSummary = response.summary
            }
            $("#filter").trigger("change");
            return;
        },
        error: function (xhr, status, error) {
            toaster(error, "error");
        },
    });
}

const pdfHeader = (pdfData) => {
    console.log("before getting acc==>", pdfData);
    return `<div>
    <div class="d-flex justify-content-between px-3 items-center">
        <div style="height: 150px"> <img src='assets/images/slcb-bg-logo.png'>
        </div>
        <div class="font-14 font-weight-bold"> SIERRA LEONE COMMERCIAL BANK<br>
            9/31 Siaka Stevens Street<br>
            Freetown, Sierra Leone<br>
            slcb@slcb.com<br>
            (+232) - 22 -225264
        </div>
    </div>
    <div class="d-flex justify-content-around">
        <div>
            <div class="font-weight-bold font-14"> Account Details</div>
            <div class="details-label">Account Name: <span id="account_description"> </span></div>
            <div class="details-label">Account Number: <span id="account_number">${pdfData?.details?.accountNumber
        }</span> </div>
            <div class="details-label">Account Product: <span id="account_product"> </span></div>
        </div>
        <div>
            <div class="font-weight-bold font-14"> Balance Details</div>
            <div class="details-label">Account Currency:<span class="account_currency"></span> </div>
            <div class="details-label">Book Balance : <span id="account_legder_balance"></span> </div>
            <div class="details-label">Cleared Balance : <span id="account_available_balance"></span> </div>
        </div>
        <div>
            <div class="font-weight-bold font-14"> Statement Details </div>
            <div class="details-label">From: <span id="start_date"></span></div>
            <div class="details-label">To: <span id="end_date"></span></div>

            <div class="details-label">Requested On: <span id="request_date">${new Date().toLocaleString(
            "en",
            {
                year: "numeric",
                month: "short",
                day: "numeric",
            }
        )}</span></div>

        </div>
    </div>
</div>`;
};

$(function () {
    // console.log("pageData ==>", pageData);
    $("#filter").select2({
        minimumResultsForSearch: Infinity,
    });

    const date = new Date();
    const today = date.toISOString().slice(0, 10);
    let startDate = new Date(date.getFullYear() + "-01-01")
        .toISOString()
        .slice(0, 10);
    let endDate = today;
    $("#startDate").val(startDate).attr("max", today);
    $("#endDate").val(startDate).attr("max", today);
    $("#endDate").val(endDate);

    $("#from_account").on("change", function (e) {
        let option = $("#from_account option:selected");
        const accountNumber = option.attr("data-account-number");
        if (!accountNumber) {
            $(this).val("");
            return;
        }

        const accountProduct = option.attr("data-account-type");
        const accountCurrency = option.attr("data-account-currency");
        const accountBalance = option.attr("data-account-balance");
        const accountDescription = option.attr("data-account-description");
        $(".account_product").text(accountProduct);
        $(".account_number").text(accountNumber);
        $(".display_from_account_currency").text(accountCurrency);
        $(".account_description").text(accountDescription);
        $(".account_currency").text(accountCurrency);
        $("#account_balance").text(formatToCurrency(accountBalance));
        PageData.currentAccount = {
            accountCurrency,
            accountDescription,
            accountProduct,
            accountNumber,
            accountBalance,
        };
        // pdfData.accountNumber;
        // console.log("pdfData ====>", pdfData);
    });

    $("#search_transaction").on("click", async function () {
        startDate = $("#startDate").val();
        endDate = $("#endDate").val();
        if (startDate > today) {
            toaster("Start Date can't be greater than today", "warning");
            return false;
        } else if (endDate > today) {
            toaster("End Date can't be greater than today", "warning");
            return false;
        } else if (startDate > endDate) {
            toaster("Start Date can't be greater than End Date", "warning");
            return false;
        }
        const accountNumber = $("#from_account option:selected").attr(
            "data-account-number"
        );
        const pdfAccountNumber = $("#from_account option:selected").attr(
            "data-account-number"
        );
        const pdfAccountName = $("#from_account option:selected").attr(
            "data-account-description"
        );
        const pdfAccountType = $("#from_account option:selected").attr(
            "data-account-type"
        );
        const pdfAccountCurrency = $("#from_account option:selected").attr(
            "data-account-currency"
        );
        const pdfAccountBalance = $("#from_account option:selected").attr(
            "data-account-balance"
        );
        if (!from_account) {
            toaster("please select an account", "warning");
            return false;
        }
        siteLoading("show");
        // pdfHeader(accountNumber);
        pdfData.details = {
            pdfAccountNumber,
            pdfAccountName,
            pdfAccountType,
            pdfAccountCurrency,
            pdfAccountBalance,
            startDate,
            endDate,
        };

        // pdfHeader(pdfData);
        await getAccountTransactions(accountNumber, startDate, endDate);
        siteLoading("hide");
        // console.log)

        $("#display_account_number").text(accountNumber);
        $("#display_search_start_date").text(startDate);
        $("#display_search_end_date").text(endDate);

        $("#pdf_print").on("click", (e) => {
            e.preventDefault();

            $(".buttons-print").trigger("click");

            // var doc = new jsPDF();
            // var specialElementHandlers = {
            //     "#editor": function (element, renderer) {
            //         return true;
            //     },
            // };
            // $(this).click(function () {
            //     doc.fromHTML($("#content").html(), 15, 15, {
            //         width: 170,
            //         elementHandlers: specialElementHandlers,
            //     });
            //     doc.save("account-enquiry.pdf");
            // });
        });

        $("#excel_print").on("click", (e) => {
            e.preventDefault();
            $(".buttons-excel").trigger("click");
        });
        $("#filter").trigger("change");
    });

    if (PageData.requestAccount) {
        PageData.requestAccount = decodeString(PageData.requestAccount);
        $(
            `#from_account option[data-account-number=${PageData.requestAccount}]`
        )
            .prop("selected", true)
            .trigger("change");
    }
    // on page load it gets accunt details
    // $("#search_transaction").trigger("click");

    $("#filter").on("change", (e) => {
        e.preventDefault();
        drawTransactionsTable(pdfData);
    });

    // filter
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex, row) {
        const amount = parseFloat(row?.amount) ?? 0; // use data for amount column
        switch ($("#filter").val()) {
            case "credit":
                return amount > 0;
            case "debit":
                return amount < 0;
            case "all":
                return true;
            default:
                return false;
        }
    });

    function drawTransactionsTable(pdfData) {
        // console.log("PageData ==>", PageData);
        // pdfHeader(pdfData);
        $("#account_transaction_display_table tbody").empty();
        // $(".table_body_display").empty();
        ;
        $(".download").show();
        // $('#balance_b/f').click(false);
        // console.log("==>",$("#balance_foward > th"))
        $("#balance_foward").show()

        // $(".balance_startDate").text(PageData.transactionSummary.startDate)
        // $(".balance_openingBalance").text(formatToCurrency(parseFloat(PageData.transactionSummary.openingBalance)))
    //     var outerHTML = $("#balance_foward").prop("outerHTML").empty();
    // console.log("outerHTML==>",outerHTML);
    // $("#balance_foward").empty().append(`

    //             <th>${PageData.transactionSummary.startDate}</th>
    //             <th>BALANCE BROUGHT FORWARD</th>
    //             <th></th>
    //             <th></th>
    //             <th>${formatToCurrency(parseFloat(PageData.transactionSummary.openingBalance))}</th>
    //             <th></th>

    //     `).html();
        // return;
        let transactionTableOptions = {
            dom: "Bfrtip",
            responsive: true,
            buttons: [
                "excel",
                {
                    extend: "print",
                    autoPrint: true,
                    // messageTop: pdfHeader(),
                    exportOptions: {
                        columns: [0, 1,2, 3, 4, 5]
                    },
                    messageTop: `<div>
                        <div class="d-flex justify-content-between  items-center">
                            <div style="height: 150px"> <img src='assets/images/slcb-bg-logo.png'>
                            </div>
                            <div class="font-14 font-weight-bold"> SIERRA LEONE COMMERCIAL BANK<br>
                                9/31 Siaka Stevens Street<br>
                                Freetown, Sierra Leone<br>
                                slcb@slcb.com<br>
                                +232 88 225225 &nbsp; +232 79 211121 &nbsp; +232 31 464541
                            </div>
                        </div>
                        <div class="d-flex justify-content-around">
                            <div>
                                <div class="font-weight-bold font-14"> Account Details</div>
                                <div class="details-label">Account Name: <span id="account_description">${pdfData?.details?.pdfAccountName
                        } </span></div>
                                <div class="details-label">Account Number: <span id="account_number">${pdfData?.details?.pdfAccountNumber
                        } - (${(pdfData?.details?.pdfAccountCurrency)})</span> </div>
                                <div class="details-label">Account Product: <span id="account_product">${pdfData?.details?.pdfAccountType
                        }  </span></div>
                            </div>
                            <div>
                                <div class="font-weight-bold font-14"> Balance Details</div>

                                <div class="details-label">Book Balance : <span id="account_legder_balance">${formatToCurrency(parseFloat(pdfData?.details?.pdfAccountBalance))

                        }</span> </div>
                        <div class="details-label">Open Balance : <span class="account_currency">${formatToCurrency(parseFloat(PageData?.transactionSummary?.openingBalance))
                        }</span> </div>
                                <div class="details-label">Closing Balance : <span id="account_available_balance">${formatToCurrency(parseFloat(PageData?.transactionSummary?.closingBalance))
                        // pdfData?.details?.pdfAccountBalance
                        }</span> </div>
                            </div>
                            <div>
                                <div class="font-weight-bold font-14"> Statement Details </div>
                                <div class="details-label">From: <span id="start_date">${pdfData?.details?.startDate
                        }</span></div>
                                <div class="details-label">To: <span id="end_date">${pdfData?.details?.endDate
                        }</span></div>

                                <div class="details-label">Requested On: <span id="request_date">${new Date().toLocaleString(
                            "en",
                            {
                                year: "numeric",
                                month: "short",
                                day: "numeric",
                            }
                        )}</span></div>

                            </div>
                        </div>
                    </div>`,
                    messageBottom: `<div class="bg-light p-2 ">
                    <div class="row">
                            <div class="col-md-3">
                            <div class="details-label">No of Debits: <span class="font-weight-bold font-14" id="">${PageData?.transactionSummary?.numberOfDebits
                            } </span></div>

                            </div>



                            <div class="col-md-3">
                            <div class="details-label">Total Debits: <span class="font-weight-bold font-14" id="">${formatToCurrency(parseFloat(PageData?.transactionSummary?.totalDebits))
                            } </span></div>
                            </div>

                            <div class="col-md-3">
                            <div class="details-label">No of Credits: <span class="font-weight-bold font-14" id="">${PageData?.transactionSummary?.numberOfCredits
                            } </span></div>
                            </div>

                            <div class="col-md-3">
                            <div class="details-label">Total Credits: <span class="font-weight-bold font-14" id="">${formatToCurrency(parseFloat(PageData?.transactionSummary?.totalCredits))
                            } </span></div>

                            </div>
                    </div>
                    </div>`
                },

                // {
                //     extend: 'pdfHtml5',
                //     exportOptions: {
                //         columns: [ 0, 1, 2, 3 ]
                //     }
                // },
            ],
            destroy: true,
            language: {
                emptyTable: `${noDataAvailable}`,
                zeroRecords: `${noDataAvailable.replace(
                    "Data Available",
                    "Records Found"
                )}`,
            },
            row: [
                { "date": "12-12-12" }
            ],
            data: PageData.transaction,
            // row: [{ data: "amount" }],
            // columnDefs: [
            //     {
            //         target: 0,
            //         type: 'asc',
            //     },
            // ],
            columns: [
                {
                    data: "postingSysDate",
                    render: (data) => new Date(data).toISOString()
                        .slice(0, 10)
                    // render: (data) =>
                    //     new Date(data).toLocaleString("en", {
                    //         year: "numeric",
                    //         month: "short",
                    //         day: "numeric",
                    //     }),
                },
                { data: "transactionDetails" },
                { data: "documentReference",
                    render:(data , type, row) => row.documentReference
            },


                {
                    data: "amount",
                    render: (data, type, row) =>
                        row.amountSign == "D" ? `${formatToCurrency(parseFloat(Math.abs(row.amount)))}` : "",
                },
                {
                    data: "amount",
                    render: (data, type, row) =>
                        data > 0 ? `${formatToCurrency(parseFloat(row.amount))}` : "",
                },
                // { data: "narration" },
                { data: "balance" ,
                render:(data,type,row) => `${formatToCurrency(parseFloat(row.balance))}`
                },
                {
                    data: "batchNumber",
                    render: (data, type, row) => {
                        return `<a href="transaction-receipt?debitAccount=${pdfData?.details?.pdfAccountNumber}&batchNo=${row.batchNumber}&postingDate=${row.postingSysDate}&transNumber=${row.transactionNumber}&valueDate=${row.valueDate}&branch=${row.branch}
                        &narration=${row.transactionDetails}&originator=${row.originator}&approval1=${row.approval1}&approval2=${row.approval2}&approval3=${row.approval3}&approval4=${row.approval4}&approval5=${row.approval5}
                        &amount=${row.amount}&contraAccount=${row.contraAccount}&channel=${row.channel}&accountName=${pdfData?.details?.pdfAccountName}&accountCurrency=${pdfData?.details?.pdfAccountCurrency}"
                        target='_blank' type="button" class="btn btn-outline-info">Details</a>`;
                    },
                },
                // {
                //     data: "imageCheck",
                //     render: (data, type, row) =>
                //         data === 0
                //             ? (attachment = `<a href="#" data-value='${row.transactionNumber}' class="attachment-icon" >
                // <i class="fe-file-text d-block text-center text-gray"></a>`)
                //             : "N/A",
                // },
                // {
                //     data: "transactionNumber",
                //     render: (data, type, row) => {
                //         return `<button type="button" class="btn btn-outline-info more-details" data-toggle="modal" data-target="#accordion-modal" batch-no="${row.batchNumber}"
                //                 posting-date="${row.postingSysDate}" trans-number="${row.transactionNumber}" value-date="${row.valueDate}" branch="${row.branch}"
                //                 narration="${row.narration}" amount="${row.amount}" contra-account="${row.contraAccount}" channel="${row.channel}">Details</button>`;
                //     },
                // },
            ],
            order: [[0, "asc"]],
            columnDefs: [
                {

                    targets: [0, 2, 3, 4],
                    render: function (data, type) {
                        if (type === "display" || type === "filter") {
                            const color =
                                data < 0 ? "text-danger" : "text-success";
                            return `<div class="text-right"><b class='${color}'>
                                ${formatToCurrency(parseFloat(data))}
                            </b></div>
                            `;
                        }
                        return data;
                    },

                },
            ],
        };

        $("#account_transaction_display_table").DataTable(
            transactionTableOptions
        );


        $(".attachment-icon").on("click", function (e) {
            e.preventDefault();
            const docId = $(this).attr("data-value");
            console.log(docId);
            getTransDocument(docId);
        });
        $(".more-details").on("click", function () {
            console.log($(this).attr("batch-no"));
            $(".transaction_date").html($(this).attr("posting-date"));
            $(".value_date").html($(this).attr("value-date"));
            $(".transaction_number").html($(this).attr("trans-number"));
            $(".narration").html($(this).attr("narration"));
            $(".amount").html($(this).attr("amount"));
            $(".branch").html($(this).attr("branch"));
            $(".contra-account").html($(this).attr("contra-account"));
            $(".channel").html($(this).attr("channel"));
        });
        // .clear();
        // PageData.transaction.forEach((trans) => {
        //     table.row
        //         .add([
        //             trans.postingSysDate,
        //             trans.amount,
        //             trans.narration,
        //             trans.runningBalance,
        //             `${trans.imageCheck}~${trans.batchNumber}`,
        //             `<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#accordion-modal" batch-no="${trans.batchNumber}"
        //             posting-date="${trans.postingSysDate}" trans-number="${trans.transactionNumber}" value-date="${trans.valueDate}" branch="${trans.branch}"
        //             narration="${trans.narration}" amount="${trans.amount}" contra-account="${trans.contraAccount}" channel="${trans.channel}">Details</button>`,
        //         ])
        //         .order([0, "desc"])
        //         .draw(false);
        // });

        // PageData.prompt = true;
        // if (PageData?.accountAccount?.accountCurrency) {
        //     $(".currency_display").text(
        //         `(${PageData.accountAccount.accountCurrency})`
        //     );
        // }
    }

    function getTransDocument(batchNumber) {
        $.ajax({
            type: "POST",
            url: "account-trans-document-api",
            datatype: "application/json",
            data: { batchNumber },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                console.log(response);
                if (response.responseCode !== "000") {
                    return;
                }
                const data = response.data;
                $.each(data, (i) => {
                    Object.entries(data[i]).forEach(([key, value], j) => {
                        if (key.includes("image")) {
                            let active = j === 0 ? "active" : "";
                            let img = `<div class="carousel-item ${active}">
                                <img class="d-block w-100" src="data:image/jpg;base64,${value}" alt="slide-${j}">
                                </div>`;
                            $(".carousel-inner").append(img);
                            let indicator = `<li data-target="#attachment_carousel" data-slide-to="${j}" class="${active}"></li>
                              `;
                            $(".carousel-indicators").append(indicator);
                        }
                    });
                });
                $("#attachment_modal").modal("show");
            },
        });
    }
});
