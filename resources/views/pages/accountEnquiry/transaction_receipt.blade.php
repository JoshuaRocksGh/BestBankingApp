<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Receipt</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style type="text/css">
        .main-body {
            display: flex;
        }

        .side {
            padding: 1px;
            width: 5%
        }



        .main-section {
            padding: 10px;
            width: 90%;
            border: solid;
            border-radius: 33px;
            border: 1px solid;
            border-color: #dc3545;
        }

        .reciept-header {
            display: grid;
            grid-template-columns: 15% 70% 15%;
        }

        .address-title {
            margin-bottom: 1px;
        }

        .address {
            padding-top: 0px
        }

        .transaction-receipt {
            display: flex;
        }

        .side-2 {
            padding: 1px;
            width: 15%
        }

        .transaction-header {
            padding: 0px;
            width: 70%;
            text-align: center;
            background-color: #dc3545 !important;
            color: #fff !important;
            margin: 5px;
            border-radius: 10px
        }

        .transaction-details {
            display: flex;
        }

        .transaction-section {
            padding: 10px;
            width: 70%;
        }
    </style>


</head>

<body style="zoom:0.8">
    <div class="main-body">
        <div class="side"></div>
        <div class="main-section">
            <div class="reciept-header">
                <div></div>
                <div>
                    <div class="float-left">
                        <br>
                        <h5 class="address-title">PUBLIC BANK LTD</h5>
                        <div class="address">
                            {{--  <small>9/31 Siaka Stevens Street</small><br>  --}}
                            {{--  <small>Freetown, Sierra Leone</small><br>  --}}
                            <small>+603-2170 8000</small><br>
                            <small>+603-2176 8555</small><br>
                            <small>+232 31 464541</small><br>
                            <small>customerservice@publicbank.com.my</small><br>
                        </div>

                    </div>
                    <div></div>
                    <img class="float-right" src="{{ asset('assets/images/slcb_logo.png') }}" alt=""
                        style="zoom:0.3; margin-left:auto">
                </div>
                <div></div>

            </div>
            {{--  <br>  --}}
            <div class="transaction-receipt">
                <div class="side-2"></div>
                <div class="transaction-header">
                    <h2>
                        Transaction Receipt
                    </h2>
                </div>
                <div class="side-2"></div>

            </div>
            <br>
            <div></div>
            <div class="transaction-details">
                <div class="side-2"></div>
                <div class="transaction-section">
                    <div class="table-responsive mb-0  rounded " id="table-data">
                        <table role="table"
                            class="table table-bordered  table-striped display responsive nowrap   w-100 pending_transaction_request ">
                            <tbody>
                                <tr>
                                    <td class="text-dark">Transaction Type</td>
                                    <td class="text-bold">{{ $batchNo }}</td>
                                </tr>
                                <tr>
                                    <td class="text-dark">Transaction Date</td>
                                    <td class="text-bold">{{ $postingDate }}</td>
                                </tr>

                                <tr>
                                    <td class="text-dark">Transaction Number</td>
                                    <td class="text-bold">{{ $transNumber }}</td>
                                </tr>

                                <tr>
                                    <td class="text-dark">Transferred From</td>
                                    <td class="text-bold">{{ $debitAccount }}</td>
                                </tr>

                                <tr>
                                    <td class="text-dark">Transferred To</td>
                                    <td class="text-bold">{{ $contraAccount }}</td>
                                </tr>

                                <tr>
                                    <td class="text-dark">Narration</td>
                                    <td class="text-bold">{{ $narration }}</td>
                                </tr>

                                <tr>
                                    <td class="text-dark">Amount</td>
                                    <td class="text-bold display_transfer_amount">{{ number_format($amount, 2) }}</td>
                                </tr>

                                <tr>
                                    <td class="text-dark">Channel</td>
                                    <td class="text-bold">{{ $channel }}</td>
                                </tr>

                                {{--  <tr>
                                    <td class="text-dark">Branch</td>
                                    <td class="text-bold"></td>
                                </tr>  --}}
                            </tbody>

                        </table>

                    </div>
                    {{--  <button type="button" class="btn btn-primary"id="print_button"
                        onclick="window.print()">click</button>  --}}

                </div>

                <div class="side-2"></div>

            </div>


        </div>
        <div class="side"></div>
    </div>
    <script src="{{ asset('assets\plugins\jquery\jquery-3.6.0.min.js') }}"></script>


    {{--  <script src="jquery-3.6.0.min.js">
        alert('calleds')
    </script>  --}}
    <script>
        function formatToCurrency(amount) {
            return amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
        };
        $(document).ready(function() {
            {{--  alert('ready')  --}}
            window.print();


            $(".display_transfer_amount").val(formatToCurrency())
            // alert('calleds')

            $("#print_button").trigger("click");


        });
    </script>
</body>

</html>
