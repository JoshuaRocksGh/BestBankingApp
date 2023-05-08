
                    let my_total_account_balances = 0
                    let my_total_invested_amount = 0
                    let my_loan_amount = 0

                    let pie_chart_details = []








                   /* function show_chart(my_total_account_balances,my_loan_amount,my_total_invested_amount) {
                        $(".canvas_spinner").hide()

                        const data = {
                            labels: ['I HAVE', 'I OWE', 'INVESTMENTS'],
                            datasets: [{
                                label: 'MY ACCOUNTS',
                                backgroundColor: [
                                    "#2fc2a5",
                                    "#f37084",
                                    "#f7b84b",
                                ],

                                data: [my_total_account_balances,my_loan_amount,my_total_invested_amount],
                                hoverOffset: 10
                            }]
                        };

                        const config = {
                            type: 'doughnut',
                            data: data,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: true,
                                        text: 'MY ACCOUNT'
                                    }
                                }
                            },
                        };
                        // === include 'setup' then 'config' above ===

                        const myChart = new Chart(
                            document.getElementById('myChart'),
                            config
                        );
                    } */

                    function show_my_account_details(my_total_account_balances,my_loan_amount,my_total_invested_amount){
                        // console.log("show_my_account_deatils my_total_account_balances=>", my_total_account_balances)
                        // console.log("show_my_account_deatils my_total_invested_amount=>", my_total_invested_amount)
                        // console.log("show_my_account_deatils my_loan_amount=>", my_loan_amount)
                        console.log(pie_chart_details)
                        $(".canvas_spinner").hide()
                        var xValues = ["I HAVE", "I OWE", "INVESTMENT"];
                        var yValues = pie_chart_details;
                        var barColors = [
                        "#2fc2a5",
                        "#f37084",
                        "#f7b84b",

                        ];

                        new Chart("myChart", {
                        type: "doughnut",
                        data: {
                            labels: xValues,
                            datasets: [{
                            backgroundColor: barColors,
                            data: yValues
                            }]
                        },
                        options: {
                            title: {
                            display: true,
                            text: 'MY ACCOUNT'
                            }
                        }
                        });
                    }

                    // PIE CHART NEW FUNCTIONS //

                    function all_my_investment(my_total_account_balances,my_loan_amount){
                        // console.log("my_loan_amount =>", my_loan_amount)
                        // alert("all_my_investment")
                        // return false;
                        $.ajax({
                            type: "GET",
                            url: "fixed-deposit-account-api",
                            datatype: "application/json",
                            success: function(response){
                                // console.log("all_my_invest=>", response)

                                if(response.responseCode == "000"){
                                let investment = response.data;


                                    if(response.data == null){
                                        pie_chart_details.push(0)
                                        show_my_account_details(my_total_account_balances,my_loan_amount,my_total_invested_amount)
                                    }else{
                                        if(response.data.length > 0){

                                            $.each(investment, function(index){

                                            let your_invested_amount = investment[index].dealAmount
                                            let my_amount = your_invested_amount.replace(/,/g, "");
                                            my_total_invested_amount += Math.abs(parseFloat(my_amount))

                                            //console.log("my_total_invested_amount=>",my_total_invested_amount);
                                                // show_my_account_deatils(my_total_account_balances,my_total_invested_amount,my_loan_amount)

                                                // show_chart(my_total_account_balances,my_loan_amount,my_total_invested_amount)

                                            })
                                            pie_chart_details.push(my_total_invested_amount)
                                                show_my_account_details(my_total_account_balances,my_loan_amount,my_total_invested_amount)
                                        }else{
                                            pie_chart_details.push(0)
                                            show_my_account_details(my_total_account_balances,my_loan_amount,my_total_invested_amount)
                                        }
                                    }


                                }
                            },
                            error: function(xhr, status, error){
                                setTimeout(function() {
                                    all_my_investment()
                                }, $.ajaxSetup().retryAfter)
                            }
                        })
                    }

                    function all_my_loans(my_total_account_balances){
                        // console.log('my_total_account_balances =>' , my_total_account_balances)
                        $.ajax({
                            "type": "GET",
                            "url": "get-loan-accounts-api",
                            datatype: "application/json",
                            success: function(response){
                                // console.log('all_my_loans =>', response)

                                if(response.responseCode == "000"){
                                    let loans = response.data;

                                    if(response.data == null){
                                        pie_chart_details.push(0)
                                        all_my_investment(my_total_account_balances,my_loan_amount)
                                    }else{

                                        if(response.data.length > 0){
                                            $.each(loans, function(index){
                                            let your_loan_amount = loans[index].loanBalance
                                            let my_loan = your_loan_amount.replace(/,/g, "");
                                            my_loan_amount += Math.abs(parseFloat(my_loan));
                                            })

                                            //console.log("my_loan_amount=>", my_loan_amount)
                                            pie_chart_details.push(my_loan_amount)
                                            all_my_investment(my_total_account_balances,my_loan_amount)

                                        }else{
                                            pie_chart_details.push(0)
                                            all_my_investment(my_total_account_balances,my_loan_amount)
                                        }

                                    }
                                }
                            },
                            error: function(xhr, status, error){
                                setTimeout(function() {
                                    all_my_loans()
                                }, $.ajaxSetup().retryAfter)
                            }
                        })
                    }

                    function all_my_account_balance(){
                        $.ajax({
                            "type": "GET",
                            "url": "get-accounts-api",
                            datatype: "application/json",
                            success: function(response){
                                // console.log("all_my_account_balance=>",response)

                                if(response.responseCode == '000'){
                                    let my_account = response.data;

                                    if(response.data == null){
                                        pie_chart_details.push(0)
                                        all_my_loans(my_total_account_balances)
                                    }else{
                                        if(response.data.length > 0){

                                            $.each(my_account, function(index){
                                                // console.log("all_my_account_balance=>", my_account[index])
                                                let account_local_balance = my_account[index].localEquivalentAvailableBalance
                                                let my_account_balance = account_local_balance.replace(
                                                /,/g, "");
                                                my_total_account_balances += Math.abs(parseFloat(
                                                    my_account_balance))
                                            })
                                            pie_chart_details.push(my_total_account_balances)
                                            //console.log("my_total_account_balances=>", my_total_account_balances)
                                            all_my_loans(my_total_account_balances)
                                        }else{
                                            pie_chart_details.push(0)
                                            all_my_loans(my_total_account_balances)
                                        }
                                    }


                                }
                            },
                            error: function(xhr, status, error){
                                setTimeout(function() {
                                    all_my_account_balance()
                                }, $.ajaxSetup().retryAfter)
                            }
                        })
                    }


                    // END OF PIE CHART //

                    function account_line_chart(cus_accounts, acc_line_details) {

                        //console.log("========")
                        //console.log([cus_accounts, acc_line_details])
                        //console.log("========")

                        let acc_dataset = []
                        let chart_data_details = new Array
                        //  let show_chart_data = []

                        let before_reverse = []

                        let acc_chart_details = acc_line_details

                        empty(chart_data_details);
                        $.each(acc_chart_details, function(index) {

                            let chart_res = acc_chart_details[index]

                            //console.log("========")
                            //console.log(chart_res)
                            //console.log("========")


                            let new_chart_res = chart_res[2]
                            var mii = new_chart_res.reverse()
                            before_reverse.push(mii)

                            chart_data_details.push(

                                {
                                    label: `${chart_res[0]} ${chart_res[1]}`,
                                    data: chart_res[2],
                                    borderColor: "red",
                                    fill: false
                                }



                            )



                        })

                        let apiData = cus_accounts

                        let datasets = []
                        var numbers = []
                        var dates = []
                        $.each(apiData, function(index) {


                            //console.log("=======")
                            //console.log(apiData[index])
                            //console.log("=======")
                            let apiDataResult = apiData[index]
                            empty(numbers)
                            empty(dates)
                            $.each(apiDataResult, function(index) {



                                numbers.push(apiDataResult[index].runningBalance)
                                var d = apiDataResult[index].valueDate
                                d = d.split(' ')[0];
                                dates.push(d)
                                //console.log("d:", d);



                            })

                        })

                        const smallest_number = Math.min(...numbers);
                        const largest_number = Math.max(...numbers);

                        //console.log("dates:", dates);

                        let uniqueDates = [...new Set(dates)].sort();
                        //console.log("dates for x-axis:", uniqueDates)

                        //console.log('Smallest Value:', smallest_number);
                        //console.log('Largest Value:', largest_number);
                        //console.log('Dataset:', acc_dataset);
                        //console.log('chart_data_details:', chart_data_details);









                        // === include 'setup' then 'config' above ===



                        // w3schools chart
                        var xValues = [100, 200, 300, 400, 500, 600, 700, 800, 900, 1000];

                        new Chart("casa_myChart", {
                            type: "line",
                            data: {
                                labels: dates,
                                datasets: chart_data_details
                            },
                            options: {
                                legend: {
                                    display: true,

                                },
                                title: {
                                    display: true,
                                    text: 'Account History'
                                }

                            }
                        });
                    }

                    $(document).ready(function() {
                        $('.close-money').show()
                        $('.open-money').hide()

                        $('.eye-open').hide()
                        $('.eye-close').show()

                        $('.eye-open').click(function() {

                            $('.eye-open').hide()
                            $('.eye-close').show()

                            $('.open-money').hide()
                            $('.close-money').show()

                        })

                        $('.eye-close').click(function() {

                            $('.eye-close').hide()
                            $('.eye-open').show()

                            $('.open-money').show()
                            $('.close-money').hide()
                        })

                        all_my_account_balance()


                    })

            //     function formatToCurrency(amount) {
            //     return amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
            // };

                    function account_transaction() {
                        // return false;
                        $.ajax({
                            type: 'GET',
                            url: 'get-my-account',
                            datatype: "application/json",
                            success: function(response) {
                                //console.log(response.data);
                                let data = response.data
                                $.each(data, function(index) {
                                    $('#account_transaction').append($('<option>', {
                                        value: data[index].accountType + '~' + data[index]
                                            .accountDesc + '~' + data[index].accountNumber +
                                            '~' + data[index].currency + '~' + data[index]
                                            .availableBalance
                                    }).text(data[index].accountNumber + ' ' + '-' + ' ' + data[index]
                                        .currency + ' ' + '-' + ' ' +
                                        formatToCurrency(parseFloat(data[index].availableBalance.trim()))));
                                    //$('#to_account').append($('<option>', { value : data[index].accountType+'~'+data[index].accountNumber+'~'+data[index].currency+'~'+data[index].availableBalance}).text(data[index].accountType+'~'+data[index].accountNumber+'~'+data[index].currency+'~'+data[index].availableBalance));

                                });
                                // let name = $("from_acc_currency").val();

                                // {{-- console.log(response); --}}
                                // {{-- let currency = response.data[0].currency; --}}
                                // {{-- console.log(currency); --}}

                        //         {{-- $.each(currency, function(index) {
                        //     let data = currency[index].description ;
                        //     console.log(data);
                        // }) --}}

                            },

                        })
                    }

                    function fixed_deposit(account_data) {

                        $('.my_investment_loading_area').hide()
                        $('.my_investment_error_area').hide()
                        $('.my_investment_no_data_found').hide()
                        $('.my_investment_display_area').hide()

                        $.ajax({

                            type: "GET",
                            url: "fixed-deposit-account-api",
                            datatype: "application/json",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                console.log("fixed deposit result=>",response);

                                let data = response.data;
                                let noInvestments = noDataAvailable.replace(
                                    "Data",
                                    "Investments"
                                );



                                if (response.responseCode == '000') {


                                    // {{-- console.log("fixed-deposit" + data) --}}

                                    if (response.data == null) {
                                        $('.my_investment_loading_area').hide()
                                        $('.my_investment_error_area').hide()
                                        $('.my_investment_no_data_found').show()
                                        $('.my_investment_display_area').hide()
                                        return false;
                                    }

                                    // {{-- let loan_count = 0 --}}
                                    let fixed_deposit_count = 0
                                    if (response.data.length > 0) {
                                        //console.log(response.data.length);

                                        account_data.i_invest_total = 0
                                        account_data.i_invest_total = 0
                                        $.each(data, function(index) {
                                            //console.log(data[index])


                                            let invest_amount = data[index].dealAmount
                                            invest_amount = invest_amount.replace(/,/g, "");
                                            account_data.i_invest_total += Math.abs(parseFloat(invest_amount))
                                            // console.log("account_data.i_invest_total=>", account_data.i_invest_total)

                                            if (account_data.i_invest_total != null || account_data
                                                .i_invest_total != "") {
                                                $(".total_investment_amount").text(
                                                    `${formatToCurrency(parseFloat(account_data.i_invest_total))}`
                                                )
                                            } else {
                                                $(".total_investment_amount").text("0.00")
                                            }


                                            var data_rollover = data[index].rollover
                                            if (data_rollover == "Y") {
                                                var rollover_ = "Yes"
                                            } else {
                                                var rollover_ = "No"
                                            }

                                            var fixedInterestRate = data[index].fixedInterestRate
                                            if(fixedInterestRate == null || fixedInterestRate == undefined){
                                                var interest_rate = "0"
                                            }else {
                                                var interest_rate = data[index].fixedInterestRate
                                            }

                                            //console.log(`total investments ${account_data.i_invest_total}`)
                                            $('.fixed_deposit_account').append(
                                                `<tr>
                                                    <td><b> ${data[index].interestAccount} </b></td>
                                                    <td><b class="float-right"> ${ formatToCurrency(parseFloat(data[index].dealAmount))} </b></td>
                                                    <td><b> ${data[index].tenure} </b></td>
                                                    <td><b> ${interest_rate} </b></td>
                                                    <td><b> ${rollover_ } </b></td>
                                                </tr>`
                                            )

                                            // {{-- loan_count = loan_count + 1; --}}
                                            fixed_deposit_count = fixed_deposit_count + 1;
                                        })

                                        // {{-- console.log('i_invest_total: ' + i_invest_total) --}}

                                        // {{-- $(".loan_count").text(loan_count); --}}
                                        $(".investment_count").text(fixed_deposit_count);

                                        $('.my_investment_loading_area').hide()
                                        $('.my_investment_error_area').hide()
                                        $('.my_investment_no_data_found').hide()
                                        $('.my_investment_display_area').show()

                                        // {{-- show_chart(i_have, i_owe, i_invest_total) --}}
                                    } else {

                                        $(".fixed_deposit_account").append(
                                            `
                                                <td colspan="100%"  class="text-center">${noInvestments} </td>

                                            `
                                        );
                                        return;

                                    //     {{-- $('#p_fixed_deposit_account').html(
                                    // `<h2 class="text-center text-warning">No Investment</h2>`) --}}

                                        $('.my_investment_loading_area').hide()
                                        $('.my_investment_error_area').hide()
                                        $('.my_investment_no_data_found').show()
                                        $('.my_investment_display_area').hide()

                                    }


                                } else {
                                    $('.my_investment_loading_area').hide()
                                    $('.my_investment_error_area').show()
                                    $('.my_investment_no_data_found').hide()
                                    $('.my_investment_display_area').hide()
                                }



                            },
                            error: function(xhr, status, error) {

                                $('.my_investment_loading_area').hide()
                                $('.my_investment_error_area').show()
                                $('.my_investment_no_data_found').hide()
                                $('.my_investment_display_area').hide()

                                setTimeout(function() {
                                    fixed_deposit(account_data)
                                }, $.ajaxSetup().retryAfter)

                            }
                        })
                    }

                    function get_accounts(account_data) {

                        $(".accounts_display_area").hide()
                        $(".accounts_error_area").hide()
                        $(".accounts_loading_area").show()

                        $.ajax({
                            "type": "GET",
                            "url": "get-accounts-api",
                            datatype: "application/json",

                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {

                                console.log("CURRENT & SAVINGS ACCOUNT:", response);


                                if (response.responseCode == '000') {

                                    let data = response.data;
                                    // console.log("accounts" + data)

                                    let i_have_total = 0
                                    let count = 0


                                    $('.currency_and_savings_account_no').text(data.length)
                                    //console.log('my data')
                                    //console.log(data)

                                    account_data.i_have_total = 0
                                    $.each(data, function(index) {




                                        let localEquivalentAvailableBalance = data[index]
                                            .localEquivalentAvailableBalance
                                        localEquivalentAvailableBalance = localEquivalentAvailableBalance.replace(
                                            /,/g, "");

                                        //console.log(typeof(localEquivalentAvailableBalance))


                                        account_data.i_have_total += Math.abs(parseFloat(
                                            localEquivalentAvailableBalance))
                                        //console.log(`total money ${account_data.i_have_total}`)
                                        if (account_data.i_have_total != null || account_data.i_have_total != '') {
                                            $(".total_casa_amount").text(
                                                `${formatToCurrency(parseFloat(account_data.i_have_total))}`)
                                        } else {
                                            $(".total_casa_amount").text(
                                                `${formatToCurrency(parseFloat(0.00))}`)
                                        }
                                        if (data[index].availableBalance != null || data[index].availableBalance !=
                                            undefined) {
                                            var availableBalance = formatToCurrency(parseFloat(data[index]
                                                .availableBalance))
                                        } else {
                                            var availableBalance = "0.00"
                                        }

                                        $('.casa_list_display').append(
                                            `<tr>
                                        <td>  <a href="{{ url('account-enquiry?ac=${encodeString(data[index].accountNumber)}') }}"> <b class="text-primary">${data[index].accountNumber} </b> </a></td>
                                        <td> <b> ${data[index].accountDesc} </b>  </td>
                                        <td> <b> ${data[index].accountType}  </b>  </td>
                                        <td> <b> ${data[index].currency}  </b>  </td>
                                        <td><b> ${formatToCurrency(parseFloat(data[index].ledgerBalance))}</b></td>
                                        <td> <b> ${formatToCurrency(parseFloat(data[index].availableBalance))}   </b>  </td>
                                        <td> <b> ${formatToCurrency(parseFloat(data[index].odLimit))}   </b>  </td>
                                        <td> <b> ${formatToCurrency(parseFloat(data[index].lienAmount))}   </b>  </td>

                                    </tr>`
                                        )
                                    })


                                    // {{-- console.log('i_have_total: ' + i_have_total) --}}

                                    // {{-- SETTING TABLE VALUES --}}
                                    $('.i_have_amount').text(formatToCurrency(parseFloat(account_data.i_have_total)));

                                    // {{-- SETTING GRAPH VALUE --}}
                                    // {{-- i_have = i_have_total --}}



                                    $(".accounts_error_area").hide()
                                    $(".accounts_loading_area").hide()
                                    $(".accounts_display_area").show()

                                    // {{-- show_chart(i_have, i_owe, i_invest_total) --}}

                                } else {

                                    $(".accounts_error_area").hide()
                                    $(".accounts_loading_area").hide()
                                    $(".accounts_display_area").show()

                                }

                            },
                            error: function(xhr, status, error) {

                                $(".accounts_loading_area").hide()
                                $(".accounts_display_area").hide()
                                $(".accounts_error_area").show()
                                setTimeout(function() {
                                    get_accounts(account_data)
                                }, $.ajaxSetup().retryAfter)

                            }
                        })
                    }

                    function get_loans(account_data) {

                        $(".loan_no_data_found").hide()
                        $(".loans_display_area").hide()
                        $(".loans_error_area").hide()
                        $(".loans_loading_area").show()

                        $.ajax({
                            "type": "GET",
                            "url": "get-loan-accounts-api",
                            datatype: "application/json",

                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                //console.log("========")
                                //console.log("loan response:", response);
                                //console.log("========")

                                let noLoans = noDataAvailable.replace(
                                    "Data",
                                    "Loans"
                                );

                                if (response.responseCode == '000') {

                                    var data = response.data;
                                    let noLoans = noDataAvailable.replace("Data", "Loans");
                                    // {{-- console.log("loans" + data) --}}

                                    if (!response.data) {

                                        return false
                                        $('.loan_no_data_found').show()
                                        $(".loans_display_area").hide()
                                    } else {
                                        if (response.data == null) {
                                            $("#loans_list_body").append(
                                                `<td colspan="100%" class="text-center">
                                                ${noLoans} </td>`
                                            );
                                            return;
                                        } else {

                                            let loan_count = 0

                                            if (response.data.length > 0) {
                                                $('#p_loans_display').show()
                                                $(".loans_display_area").show()
                                                //console.log("loans_display length:", response.data.length);

                                                let i_owe_total = 0
                                                let count = 0

                                                account_data.i_owe_total = 0
                                                $.each(data, function(index) {
                                                    let loanBalance = data[index].loanBalance
                                                    loanBalance = loanBalance.replace(/,/g, "");
                                                    account_data.i_owe_total += Math.abs(parseFloat(loanBalance));

                                                    //console.log("account_data_i_owe_total:",
                                                        account_data.i_owe_total

                                                    if (account_data.i_owe_total != null || account_data
                                                        .i_owe_total != "") {
                                                        $(".total_loan_account").text(formatToCurrency(parseFloat(
                                                            account_data.i_owe_total)))
                                                    } else {
                                                        $(".total_loan_account").text(formatToCurrency(parseFloat(
                                                            0.00)))
                                                    }


                                                    //console.log(`total loans ${account_data.i_owe_total}`)
                                                    $('.loans_display').append(
                                                        `
                                                            <tr>
                                                                <td>  <a href="{{ url('account-enquiry?ac=${encodeString(data[index].facilityNo)}') }}"> <b class="text-danger">${data[index].facilityNo} </b> </a></td>
                                                                <td> <b> ${data[index].description} </b>  </td>
                                                                <td> <b> ${data[index].isoCode}  </b>  </td>
                                                                <td> <b class="float-right"> ${ formatToCurrency(parseFloat(data[index].amountGranted))}   </b> </b></td>
                                                                <td> <b class="float-right"> ${formatToCurrency(parseFloat(data[index].loanBalance))}  </b>  </td>
                                                            </tr>`
                                                    )
                                                    loan_count = loan_count + 1;


                                                })

                                                $(".loan_count").text(loan_count);

                                                // {{-- console.log('i_owe_total: ' + i_owe_total) --}}

                                                // {{-- show_chart(i_have, i_owe, i_invest_total) --}}
                                            } else {
                                                $(".loans_display").append(
                                                    `<td colspan="100%" class="text-center">
                                                        ${noLoans} </td>`
                                                );
                                                return;
                                            }
                                        }


                                    }



                                } else if (response.responseCode == '00') {
                                    $(".loan_no_data_found").show()
                                    $(".loans_error_area").hide()
                                    $(".loans_loading_area").hide()
                                    $(".loans_display_area").hide()
                                } else {
                                    $(".loans_display").append(
                                        `<td colspan="100%" class="text-center">
                                                        ${noLoans} </td>`
                                    );
                                    return;
                                    $(".loan_no_data_found").hide()
                                    {{-- $(".loans_error_area").hide()
                            $(".loans_loading_area").hide()
                            $(".loans_display_area").show() --}}

                                }

                            },
                            error: function(xhr, status, error) {
                                $(".loans_display_area").hide()
                                $(".loans_loading_area").hide()
                                $(".loans_error_area").show()
                                setTimeout(function() {
                                    get_loans(account_data)
                                }, $.ajaxSetup().retryAfter)
                            }

                        })
                    }

                    function get_currency() {
                        $.ajax({
                            type: 'GET',
                            url: 'get-currency-list-api',
                            datatype: "application/json",
                            success: function(response) {
                                //console.log(response.data);
                                let data = response.data
                                $.each(data, function(index) {
                                    $('.select_currency').append($('<option>', {
                                        value: data[index].isoCode
                                    }).text('(' + data[index].isoCode + ') ~ ' + data[index]
                                        .description));
                                });

                            },

                        })
                    };


                   /* $("#exchange_amount").keyup(function() {
                        var exch_rate_from = $("#exch_rate_from").val();
                        var exch_rate_to = $("#exch_rate_to").val();
                        let ex_amount = $(this).val();
                        //console.log(forex_rate)
                        //console.log(exch_rate_from)
                        //console.log(exch_rate_to)
                        //console.log($(this).val())

                    }) */

                    function formatToCurrency(amount) {
                        return amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
                    };

            //         {{-- var c = {}

            // var forex_rate = []
            // var cur_1 = "SLL"
            // var cur_2 = "SLL"

            // var _cur_ = []
            // var get_cur_1 = []
            // var get_cur_2 = [] --}}

                    function getCorrectFxRates() {
                        $.ajax({
                            type: "GET",
                            url: "get-correct-fx-rate-api",
                            datatype: "application/json",
                            success: (response) => {
                                // console.log("getCorrectFxRates =>" , response)
                                // return false;
                                if (response.responseCode === "000") {
                                   forex_rate = response.data
                                   console.log("forex_rate =>",forex_rate)
                                    $(".currency_fx_rate tr").remove();

                                    data = response.data;
                                    $.each(data, (i) => {
                                        let color = [
                                            'table-success',
                                            'table-warning',
                                            'table-info',
                                            'table-danger',
                                            'table-info',
                                            'table-success',
                                            'table-warning',
                                            'table-danger'
                                        ];
                                        let card_color = color[i];
                                //         {{-- console.log("======")
                                // console.log(card_color)
                                // console.log("======") --}}

                                        // {{-- let randomItem = card_color[Math.floor(Math.random() * card_color.length)]; --}}


                                        let {
                                            PAIR,
                                            MIDRATE,
                                            BUY,
                                            SELL
                                        } = data[i];


                                        let [currency1, currency2] = PAIR.split("/");
                                        let baseFlagsPath = "assets/images/flags/";
                                        let imageProps =
                                            "class='img-fluid'  style='height:13px; border-radius:1px;'";
                                        currency2 = currency2.trim();
                                        currency1 = currency1.trim();
                                        if (currency1 !== currency2) {
                                            $("#fx_rate_marquee").append(`
                                                <span>
                                                    <img src="${baseFlagsPath}${currency1}.png" ${imageProps}>
                                                    /
                                                    <img src="${baseFlagsPath}${currency2}.png" ${imageProps}> &nbsp;=&nbsp;
                                                    <span> <strong>  ${MIDRATE} </strong> </span>
                                                    </span>  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp; `);

                                            $(".currency_fx_rate").append(
                                                `
                                            <tr class="${card_color}">
                                                <td><img src="${baseFlagsPath}${currency1}.png" alt="" width='40px'
                                                        height='20px' style='border-radius:5px;'>&nbsp;${ currency1}</td>
                                                <td>${BUY}</td>
                                                <td>${SELL}</td>
                                            </tr>
                                    `
                                            )
                                        }
                                    });
                                }
                            },
                            error: function(xhr, status, error){
                                setTimeout(function() {
                                    getCorrectFxRates()
                                }, $.ajaxSetup().retryAfter)
                            }
                        });
                    }


                    function get_correct_fx_rate() {

                        $(".currency_converter_display_area").hide()
                        $(".currency_converter_error_area").hide()
                        $(".currency_converter_loading_area").show()

                        $.ajax({
                            type: 'GET',
                            url: 'get-correct-fx-rate-api',
                            datatype: "application/json",
                            success: function(response) {
                                //console.log(response.data);
                                let data = response.data
                                //console.log(data)
                                if (response.responseCode == '000') {

                                    $(".currency_converter_loading_area").hide()
                                    $(".currency_converter_error_area").hide()
                                    $(".currency_converter_display_area").show()

                                    $('#hide_fx_rate').val(JSON.stringify(data))

                                } else {
                                    $(".currency_converter_display_area").hide()
                                    $(".currency_converter_loading_area").hide()
                                    $(".currency_converter_error_area").show()
                                }



                            },
                            error: function(xhr, status, error) {
                                $(".currency_converter_display_area").hide()
                                $(".currency_converter_loading_area").hide()
                                $(".currency_converter_error_area").show()

                                setTimeout(function() {
                                    get_correct_fx_rate()
                                }, $.ajaxSetup().retryAfter)
                            }

                        })
                    };

                    function get_fx_rate(rate_type) {

                        $(".cross_rate_display_area").hide()
                        $(".cross_rates_error_area").hide()
                        $(".cross_rates_loading_area").show()

                        $.ajax({
                            "type": "GET",
                            "url": "get-fx-rate-api?rateType=" + rate_type,
                            datatype: "application/json",

                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                //console.log(response);
                                if (response.responseCode == '000') {



                                    let data = response.data;


                                    if (response.data.length > 0) {
                                        if (rate_type == "Note rate") {
                                            $.each(data, function(index) {
                                                let flag_1 = ``
                                                let flag_2 = ``
                                                //console.log(data[index].pair);
                                                let pair = data[index].pair.split('/')
                                                flag_1 = `assets/images/flags/${pair[0].trim()}.png`
                                                flag_2 = `assets/images/flags/${pair[1].trim()}.png`
                                                $('.display_cross_rates').append(
                                                    `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <td style="zoom: 0.8;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <img src='${flag_1}' width='40px' height='20px' style='border-radius:5px;'>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    /
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <img src='${flag_2}' width='40px' height='20px' style='border-radius:5px;'>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <td> <b> ${parseFloat(data[index].buy)} </b> </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <td> <b> ${parseFloat(data[index].sell)} </b> </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        `
                                                );
                                            });
                                        } else if (rate_type == "Cross rate") {
                                            $.each(data, function(index) {
                                                let flag_1 = ``
                                                let flag_2 = ``
                                                //console.log(data[index].pair);
                                                let pair = data[index].pair.split('/')
                                                flag_1 = `assets/images/flags/${pair[0].trim()}.png`
                                                flag_2 = `assets/images/flags/${pair[1].trim()}.png`
                                                $('.display_cross_rates').append(
                                                    `
                                        <tr>
                                            <td style="zoom: 0.8;">
                                                <img src='${flag_1}' width='40px' height='20px' style='border-radius:5px;'>
                                                /
                                                <img src='${flag_2}' width='40px' height='20px' style='border-radius:5px;'>

                                            </td>
                                            <td> <b> ${parseFloat(data[index].buy)} </b> </td>
                                            <td> <b> ${parseFloat(data[index].sell)} </b> </td>
                                        </tr>
                                    `
                                                );
                                            });
                                        }

                                    }


                                    $(".cross_rates_error_area").hide()
                                    $(".cross_rates_loading_area").hide()
                                    $(".cross_rate_display_area").show()

                                } else {

                                    $(".cross_rates_error_area").hide()
                                    $(".cross_rates_loading_area").hide()
                                    $(".cross_rate_display_area").show()
                                }

                            },
                            error: function(xhr, status, error) {
                                $(".cross_rate_display_area").hide()
                                $(".cross_rates_loading_area").hide()
                                $(".cross_rates_error_area").show()
                                setTimeout(function() {
                                    get_fx_rate()
                                }, $.ajaxSetup().retryAfter)

                            }
                        })
                    }

                    let today = new Date();
                    let dd = today.getDate();

                    let mm = today.getMonth() + 1;
                    const yyyy = today.getFullYear()
                    //console.log(mm)
                    //console.log(String(mm).length)
                    if (String(mm).length == 1) {
                        mm = '0' + mm
                    }

                    var end_date = '01-' + mm + '-' + today.getFullYear();
                    var start_date = '30-' + `${ mm - 3}` + '-' + (Number(today.getFullYear()) - 1);
                    var transLimit = 20;
                    //console.log(end_date)

                    let cus_accounts = []

                    let acc_line_details = []

                    function getAccountTransactions(account_number, account_currency, start_date, end_date, transLimit) {
                        //console.log([account_number, account_currency, start_date, end_date, transLimit]);
                        //return false;
                        $.ajax({
                            "type": "POST",
                            "url": "account-transaction-history",
                            datatype: "application/json",
                            data: {
                                "accountNumber": account_number,
                                "endDate": end_date,
                                "entrySource": "A",
                                "startDate": start_date,
                                "transLimit": transLimit
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                //console.log("get account transaction:", response)
                                //return false;

                                if (response.responseCode == '000') {

                                    if (response.data == "" || response.data == null || response.data == undefined) {
                                        $("#line_chart_no_data").show()
                                        $("#casa_myChart").hide()
                                    } else {

                                        $("#line_chart_no_data").hide()


                                        let data_ = response?.data;
                                        //console.log(data_);
                                        //console.log("========")
                                        //console.log(data_)
                                        //console.log("========")


                                        let acc_run_balances = []
                                        empty(cus_accounts);

                                        cus_accounts?.push(response.data)
                                        empty(acc_run_balances);
                                        $.each(data_, function(index) {

                                            acc_run_balances?.push(data_[index].runningBalance)

                                        })

                                        var details = [account_number, account_currency, acc_run_balances]
                                        empty(acc_line_details);
                                        acc_line_details.push(details)


                                        // {{-- console.log(response.data) --}}



                                        var limit = 10;
                                        let data = response?.data?.slice(0, limit);


                                        account_line_chart(cus_accounts, acc_line_details)

                                    }


                                }

                            },
                            error: function(xhr, status, error) {
                                // {{-- $("#account_transaction_loader").hide();
                                // $(".account_transaction_display").hide();
                                // $(".account_transaction_display_table").hide();
                                // $("#account_transaction_retry_btn").show(); --}}
                                //console.log(xhr, status, error);
                            }
                        })
                    }

                    var global_selected_currency = "";

                    function line_graph() {

                        //console.log(cus_accounts)


                    }

                    function empty(arr) {
                        //empty your array
                        arr.length = 0;

                    }

                    $(document).ready(function() {


                        $(".casa_chart").click(function() {
                            // {{-- alert("welcome") --}}
                            $(".accounts_display_area").show()
                            $(".my_investment_display_area").hide()
                            $(".loans_display_area").hide()
                        })

                        $(".investment_chart").click(function() {
                            // {{-- alert("welcome") --}}
                            $(".my_investment_display_area").show()
                            $(".accounts_display_area").hide()
                            $(".loans_display_area").hide()
                        })

                        $(".loans_chart").click(function() {
                            // {{-- alert("welcome") --}}
                            $(".loans_display_area").show()
                            $(".my_investment_display_area").hide()
                            $(".accounts_display_area").hide()

                        })

                        // {{-- dynamic_display("cross_rate_display_area", "cross_rates_error_area", "cross_rates_loading_area") --}}

                        $('.loan_no_data_found').hide()
                        $(".i_owe_display_no_data").hide()

                        $(".i_have_display_no_data").hide()
                        $(".fd_display_no_data").hide()
                        $(".fd_display").hide()

                        $(".cross_rate_display_area").hide()
                        $(".cross_rates_error_area").hide()
                        $(".cross_rates_loading_area").show()

                        $(".loans_display_area").hide()
                        $(".loans_error_area").hide()
                        $(".loans_loading_area").show()

                        $(".accounts_display_area").hide()
                        $(".accounts_error_area").hide()
                        $(".accounts_loading_area").show()

                        $(".currency_converter_display_area").hide()
                        $(".currency_converter_error_area").hide()
                        $(".currency_converter_loading_area").show()



                        var converter_rates = []

                        function fx_rates() {
                            get_fx_rate("Transfer rate")
                            get_fx_rate("Note rate")
                            get_fx_rate("Cross rate")
                        }
                        let account_data = new Object()
                        get_accounts(account_data);
                        get_loans(account_data);
                        fixed_deposit(account_data);
                        account_transaction();
                        fx_rates()
                        converter_rates = get_correct_fx_rate()
                        get_currency()
                        var acc_det = $("#casa_line_chart").val()
                        var my_acc = acc_det.split("~")
                        var acc_num = my_acc[2].trim()
                        var acc_cur = my_acc[3].trim()

                        setTimeout(function() {

                            getCorrectFxRates()

                            // show_chart(account_data.i_have_total, account_data.i_owe_total, account_data.i_invest_total)
                            setTimeout(function() {
                                // getAccountTransactions(acc_num, acc_cur, start_date, end_date, transLimit)
                                //line_graph()
                                account_line_chart(cus_accounts, acc_line_details)
                            }, 500)

                        }, 500);

                    // })

                    $("#casa_line_chart").change(function() {
                        var account_details = $(this).val()
                        var my_account = account_details.split("~")
                        //console.log("my_account:", my_account)

                        // getAccountTransactions(my_account[2], my_account[3],
                        //     start_date,
                        //     end_date,
                        //     transLimit)
                    })



                    $("#account_transaction").change(function() {
                        var account_details = $(this).val().split('~');
                        var account_number = account_details[2];
                        var account_currency = account_details[3];

                        global_selected_currency = account_details[3]

                        // {{-- var start_date = start_date; --}}
                        // {{-- var end_date = end_date; --}}
                        // {{-- var transLimit = transLimit; --}}
                        $(".account_currency").text(account_currency);

                        //console.log(account_details);
                        //console.log(account_number);
                        //console.log(start_date);
                        //console.log(end_date);
                        //console.log(transLimit);

                        // {{-- getAccountTransactions(account_number, start_date, end_date, transLimit) --}}

                        // {{-- let data = --}}


                    })

                    // $(function() {



                        var result = 1;
                        var exch_rate_from = '';
                        var exch_rate_to = '';
                        var rate = 0;

                        var multiply;
                        var divided;

                        $('#exch_rate_from').change(function(e) {
                            e.preventDefault();
                            // alert("changed")
                            var exch_rate_from = $('#exch_rate_from').val();
                            // console.log(forex_rate.length);
                            var exch_rate_to = $('#exch_rate_to').val();
                            var get_con = exch_rate_from + '/ ' + exch_rate_to;
                            var get_con_1 = exch_rate_to + '/ ' + exch_rate_from;
                    //         {{-- $('#result').val();
                    // $('#amount').val(); --}}
                            if (exch_rate_from = '' || exch_rate_from == undefined || exch_rate_to == '' ||
                                exch_rate_to ==
                                undefined) {
                                return false;
                            }


                            for (let index = 0; index < forex_rate.length; index++) {
                                console.log('final = ' + get_con);
                                // {{-- console.log(forex_rate.length) --}}
                                if (forex_rate[index].PAIR == get_con) {
                                    rate = forex_rate[index].MIDRATE;
                                    console.log(rate)
                                    var amount = $('#exchange_amount').val();
                                    result = parseFloat(amount) * parseFloat(rate);
                                    //console.log(amount + '*' + rate)
                                //     {{-- $('#exchange_result').html(exch_rate_to + ' ' + new Intl.NumberFormat('en-IN')
                                // .format(result)); --}}
                                    multiply = true;
                                    divided = false;
                                    // {{-- return false; --}}
                                } else {
                                    // {{-- $('#exchange_result').html("<span class='text-danger'> Rate not Found </span> "); --}}
                                    $('#exchange_amount').val('');
                                }


                                if (forex_rate[index].PAIR == get_con_1) {
                                    rate = forex_rate[index].MIDRATE;
                                    console.log(rate)
                                    var amount = $('#exchange_amount').val();
                                    result = parseFloat(amount) / parseFloat(rate);
                                    //console.log(amount + '/' + rate)
                                //     {{-- $('#exchange_result').html(exch_rate_to + ' ' + new Intl.NumberFormat('en-IN')
                                // .format(result)); --}}
                                    divided = true;
                                    multiply = false;
                                    // {{-- return false; --}}
                                } else {
                                    // {{-- $('#exchange_result').html("<span class='text-danger'> Rate not Found </span> "); --}}
                                    $('#exchange_amount').val('');
                                }

                            }






                        });

                        $('#exch_rate_to').change(function(e) {
                            e.preventDefault();
                        //     {{-- $('#result').val();
                        //  $('#amount').val(); --}}
                            var exch_rate_from = $('#exch_rate_from').val();
                            var exch_rate_to = $('#exch_rate_to').val();
                            var get_con = exch_rate_from + '/ ' + exch_rate_to;
                            var get_con_1 = exch_rate_to + '/ ' + exch_rate_from;


                            if (exch_rate_from = '' || exch_rate_from == undefined || exch_rate_to == '' ||
                                exch_rate_to == undefined) {
                                return false;
                            }


                            for (let index = 0; index < forex_rate.length; index++) {
                                //console.log('final = ' + get_con);
                                if (forex_rate[index].PAIR == get_con) {
                                    rate = forex_rate[index].MIDRATE;

                                    //console.log(rate)
                                    var amount = $('#exchange_amount').val();
                                    result = parseFloat(amount) * parseFloat(rate);
                                    //console.log(amount + '*' + rate)
                                //     {{-- $('#exchange_result').val(exch_rate_to + ' ' + new Intl.NumberFormat('en-IN')
                                // .format(
                                //     result)); --}}
                                    multiply = true;
                                    divided = false;
                                    return false;
                                } else {
                                    // {{-- $('#exchange_result').html("<span class='text-danger'> Rate not Found </span> "); --}}
                                    $('#exchange_amount').val('');
                                }


                                if (forex_rate[index].PAIR == get_con_1) {
                                    rate = forex_rate[index].MIDRATE;
                                    //console.log(rate)
                                    var amount = $('#exchange_amount').val();
                                    result = parseFloat(amount) / parseFloat(rate);
                                    //console.log(amount + '/' + rate)
                                //     {{-- $('#exchange_result').html(exch_rate_to + ' ' + new Intl.NumberFormat('en-IN')
                                // .format(
                                //     result)); --}}
                                    divided = true;
                                    multiply = false;
                                    return false;
                                } else {
                                    // {{-- $('#exchange_result').html("<span class='text-danger'> Rate not Found </span> "); --}}
                                    $('#exchange_amount').val('');
                                }
                            }
                        });

                        $('#exchange_amount').keyup(function(e) {
                            e.preventDefault();
                            //console.log('typing..')
                            var exch_rate_from = $('#exch_rate_from').val();
                            var exch_rate_to = $('#exch_rate_to').val();
                            var get_con = exch_rate_from + '/ ' + exch_rate_to;
                            var get_con_1 = exch_rate_to + '/ ' + exch_rate_from;
                            // var amount = $('#exchange_amount').val();
                            var amount = $(this).val();
                            console.log(exch_rate_from)
                            console.log(exch_rate_to)
                            console.log("amount rate=>" ,rate)

                            if (exch_rate_from == '' || exch_rate_from == undefined || exch_rate_to == '' ||
                                exch_rate_to == undefined) {
                                toaster("Select Currency For Conversion", "error" ,1000)
                                return false;
                            }
                            if (amount == '' || amount == undefined) {
                                return false;
                            }

                            if (multiply) {
                                result = parseFloat(amount) * parseFloat(rate);
                                console.log("multiply result=>" ,result)
                                console.log(amount + '*' + rate)
                                $('#exchange_result').val(exch_rate_to + ' ' + new Intl.NumberFormat('en-IN').format(
                                    result));
                            }

                            // if (!divided) {
                            //     result = parseFloat(amount) * parseFloat(rate);
                            //     console.log("divided result=>" ,result)
                            //     console.log(amount + '/' + rate)
                            //     $('#exchange_result').html(exch_rate_to + ' ' + new Intl.NumberFormat('en-IN').format(
                            //         result));
                            // }


                        });

                    })
