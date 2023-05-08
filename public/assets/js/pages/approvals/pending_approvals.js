// siteLoading("show");

function formatToCurrency(amount) {
    return amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
}

function get_corporate_requests(customerNumber, requestStatus) {
    $(".loans_display_area").hide();
    $(".loans_error_area").hide();
    $(".loans_loading_area").show();

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
        success: function (response) {
            console.log(response);
            if (response.responseCode == "000") {
                $(".rquest_table tr").remove();
                let data = response.data;
                console.log("get-pending-requests =>", data);
                // $(".pending_transaction_request tbody").empty();
                var table = $(".pending_transaction_request").DataTable();
                // .clear();
                // var nodes = table.rows().nodes();

                // table.order([0, "desc"]).column(0).visible(false, false).draw();

                $.each(data, function (index) {
                    let request_id = data[index].request_id;
                    let customer_no = data[index].customer_no;

                    let today = new Date(data[index].post_date);
                    let dd = String(today.getDate()).padStart(2, "0");
                    let mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
                    let yyyy = today.getFullYear();
                    if (data[index].amount) {
                        var amount =
                            data[index].currency +
                            " " +
                            formatToCurrency(parseFloat(data[index].amount));
                    } else {
                        var amount = "";
                    }

                    let request_type = "";

                    if (data[index].request_type == "OWN") {
                        request_type = "Own Account Transfer";
                    } else if (data[index].request_type == "SAB") {
                        request_type = "Same Bank Transfer";
                    } else if (data[index].request_type == "ACH") {
                        request_type = "ACH Transfer";
                    } else if (data[index].request_type == "RTGS") {
                        request_type = "RTGS Transfer";
                    } else if (data[index].request_type == "BOL") {
                        request_type = "Bollore Transfer";
                    } else if (data[index].request_type == "SO") {
                        request_type = "Standing Order";
                    } else if (data[index].request_type == "BULK") {
                        amount =
                            data[index].currency +
                            " " +
                            formatToCurrency(
                                parseFloat(data[index].total_amount)
                            );
                        //console.log(data[index].total_amount)
                        request_type = "Bulk Transfer";
                    } else if (data[index].request_type == "INTB") {
                        request_type = "International Bank Transfer";
                    } else if (data[index].request_type == "CHQS") {
                        request_type = "Stop Cheque";
                    } else if (data[index].request_type == "CHQR") {
                        request_type = "Cheque Book Request";
                    } else if (data[index].request_type == "KORP") {
                        // request_type = "E-Korpor";
                        request_type = "Salone Link";
                    } else if (data[index].request_type == "CARDR") {
                        request_type = "Card Request";
                    } else if (data[index].request_type == "CARDB") {
                        request_type = "Card Block";
                    } else if(data[index].request_type == "CNO"){
                        request_type = "Create New Originator";
                    }else if (data[index].request_type == "CARD") {
                        request_type = "Cardless";
                    } else if (data[index].request_type == "BKORP") {
                        amount =
                            data[index].currency +
                            " " +
                            formatToCurrency(
                                parseFloat(data[index].total_amount)
                            );
                        request_type = "Bulk E-Korpor";
                    } else if (data[index].request_type == "BOL") {
                        request_type = "Bollore Transfer";
                    } else if (data[index].request_type == "UTL") {
                        request_type = "Utility";
                    } else if (data[index].request_type == "AIR") {
                        request_type = "Airtime";
                    } else if (data[index].request_type == "MOM") {
                        request_type = "Mobile Money";
                    } else {
                        request_type = "Others";
                        if ((request_type = "Others")) {
                            amount = data[index].total_amount;
                        }
                    }

                    table.row
                        .add([
                            data[index].request_id,
                            request_type,
                            data[index].account_no,
                            (amount = null ? " " : amount),
                            data[index].narration,
                            // dd + "/" + mm + "/" + yyyy,
                            // data[index].postedby,
                            `<a onclick="window.open('approvals-pending-transfer-details/${request_id}/${customer_no}'), '_blank', 'location=yes,height=670,width=1200,scrollbars=yes,status=yes'">
                                        <button type="button" class=" btn btn-xs btn-outline-info waves-effect waves-light"> View Details</button>
                                    </a>
                                    `,
                        ])
                        .order([0, "desc"])
                        .draw();
                    table.column(0).visible(false);

                    // table.columns.adjust().draw();
                    // siteLoading("hide");
                });

                $(".loans_error_area").hide();
                $(".loans_loading_area").hide();
                $(".loans_display_area").show();
            } else {
                $(".loans_error_area").hide();
                $(".loans_loading_area").hide();
                $(".loans_display_area").show();
            }
        },
        error: function (xhr, status, error) {
            $(".loans_display_area").hide();
            $(".loans_loading_area").hide();
            $(".loans_error_area").show();

            setTimeout(function () {
                get_corporate_requests(customerNumber, requestStatus);
            }, $.ajaxSetup().retryAfter);
        },
    });
}

$(document).ready(function () {
    var request_status = "P";
    //console.log(customer_no);
    $(".transfer_tab_btn").click(function () {
        get_corporate_requests(customer_no, "P");
    });
    get_corporate_requests(customer_no, request_status);
});
