@extends('layouts.approval_detail')

@section('styles')

    <style>
        @media print {
            .hide_on_print {
                display: none;
            }

            ;
        }

        @page {
            size: A4;
            {{-- margin: 10px; --}}
        }

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
            }

            /* ... the rest of the rules ... */
        }


        @font-face {
            font-family: 'password';
            font-style: normal;
            font-weight: 400;
            src: url(https://jsbin-user-assets.s3.amazonaws.com/rafaelcastrocouto/password.ttf);
        }

    </style>


@endsection

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="">
                    <div class="card-body ">
                        <div class="row">
                            {{-- <div class="col-md-1"></div> --}}

                            <div class="col-md-8">

                                <div class="receipt">
                                    <div class="container card card-body">

                                        <div class="container">
                                            <div class="">
                                                <div class="col-md-12 body-main">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-4 "> <img class="img " alt="InvoIce Template"
                                                                    src="{{ asset('assets/images/' . env('APPLICATION_INFO_LOGO_LIGHT')) }} "
                                                                    style="zoom: 0.6" /> </div>
                                                            <div class="col-md-4"></div>
                                                            <div class="col-md-4 text-right">
                                                                <h4 class="text-primary"><strong>ROKEL COMMERCIAL
                                                                        BANK</strong>
                                                                </h4>
                                                                <p>25-27 Siaka Stevens St</p>
                                                                <p> Freetown, Sierra Leone</p>
                                                                <p>rokelsl@rokelbank.sl</p>
                                                                <p>(+232)-76-22-25-01</p>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="page-header">
                                                            <h2>Approval Form</h2>
                                                        </div>
                                                        <br>
                                                        <div class="col-md-1"></div>

                                                        <div class="container col-md-10 text-center">
                                                            <div class="col-md-12">
                                                                <div id="approval_details"></div>

                                                                <div class="mt-1">

                                                                    <div class="col-md-12 mb-3">
                                                                        <div class="row">
                                                                            <div class="col-md-2"></div>
                                                                            <button class="btn btn-danger waves-effect waves-light col-md-3 btn-lg" id="reject_transaction"
                                                                                type="button">Reject
                                                                                <i class="mdi mdi-cancel"></i>
                                                                            </button>
                                                                            <div class="col-md-2"></div>
                                                                            <button class="btn btn-success waves-effect waves-light col-md-3 btn-lg" data-toggle="modal" data-target="#success-alert-modal"
                                                                            id="approve_transaction"
                                                                                type="button">Approve
                                                                                <i class="mdi mdi-check-all"></i>
                                                                            </button>
                                                                            <div class="col-md-2"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 mb-3">
                                                                        <div class="row">
                                                                            <div class="col-md-4"></div>
                                                                            <div class="col-md-4">
                                                                                {{--  <button type="button" class="btn btn-blue btn-sm waves-effect waves-light">Btn Small</button>  --}}

                                                                            </div>
                                                                            <div class="col-md-4"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-1"></div>


                                                        <br><br>

                                                        {{-- <div>
                                                            <div class="col-md-12">
                                                                <p><b>Date Posted :</b> {{ date('d F, Y') }}</p> <br /> <br />
                                                                <p><b>Posted By : {{ session('userId') }}</b></p>
                                                            </div>
                                                        </div> --}}
                                                        <br><br>
                                                        {{-- <div class="row">
                                                            <div class="col-md-5"></div>
                                                            <div class="col-md-2">
                                                                  <button class="btn btn-light btn-rounded hide_on_print text-center"
                                                                    type="button" onclick="window.print()">Print
                                                                    Receipt
                                                                </button>


                                                            </div>
                                                            <div class="col-md-5"></div>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card ">
                                    <div class="p-3 mt-4 mt-lg-0">
                                        <h4 class="mb-1 text-center">Account Mandate</h4>
                                        <h2 id="account_mandate"></h2>
                                        {{-- <div class="table-responsive">
                                            <table class="table mb-0 table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td id="account_mandate"><h3></h3></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div> --}}

                                    </div>
                                </div>

                                {{-- <br> --}}
                                <div class="card">
                                    <div class="p-3 mt-4 mt-lg-0">
                                        <h4 class="mb-1 text-center">Initiated By</h4>
                                        <h2 id="initiated_by"></h2>
                                        {{-- <div class="table-responsive">
                                                <table class="table mb-0 table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td id="initiated_by"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div> --}}

                                    </div>
                                </div>

                                {{-- <br> --}}
                                <div class="card">
                                    <div class="p-3 mt-4 mt-lg-0">
                                        <h4 class="mb-1 text-center">Approvers</h4>
                                        <span id="approvers_list"></span>

                                        {{--  <h2 class="approvers">Jonas Korankye</h2>
                                        <h2 class="approvers">Joshua Tetteh</h2>  --}}


                                    </div>
                                </div>



                            </div>



                        </div>
                    </div>

                </div> <!-- end card-body -->



            </div> <!-- end col -->

        </div> <!-- end row -->



    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
            function account_mandate() {

                var customer = @json($customer_no);
                var request = @json($request_id);
                var mandate = @json($mandate)

                console.log(customer);
                console.log(request);
                console.log(mandate);

                $.ajax({
                    type : 'GET',
                    url : "../../pending-request-details-api?customer_no=" + customer + "&request_id=" + request ,
                    datatype : 'application/json',
                    success: function(response){
                         console.log(response.data);

                         if (response.responseCode == '000'){

                            let pending_request = response.data;
                            console.log(pending_request);

                            $('#account_mandate').text(pending_request.account_mandate);
                            $('#initiated_by').text(pending_request.postedby);


                            let post_date = pending_request.post_date;
                            post_date != null ? append_approval_details("Issue Date" , post_date) : '';

                            let request_type = pending_request.request_type;
                            if (request_type == 'SO') {
                                let request_type =  'Standing Order' ;
                                request_type != null ? append_approval_details("Request Type" , request_type) : '';

                            }else if (request_type == 'RTGS'){
                                let request_type = 'RTGS Transfer'
                                request_type != null ? append_approval_details("Request Type" , request_type) : '';

                            }else if (request_type == 'SAB'){
                                let request_type = 'Same Bank Transfer'
                                request_type != null ? append_approval_details("Request Type" , request_type) : '';
                            }else if (request_type == 'OWN'){
                                let request_type = 'Own Account Transfer'
                                request_type != null ? append_approval_details("Request Type" , request_type) : '';
                            }else if (request_type == 'ACH'){
                                let request_type = 'ACH Transfer'
                                request_type != null ? append_approval_details("Request Type" , request_type) : '';

                            }else if (request_type == 'OBT'){
                                let request_type = 'Other Bank Transfer'
                                request_type != null ? append_approval_details("Request Type" , request_type) : '';

                            }else if (request_type == 'BULK'){
                                let request_type = 'Bulk Payment'
                                request_type != null ? append_approval_details("Request Type" , request_type) : '';

                            }else if (request_type == 'DTRA'){
                                let request_type = 'Direct Transfer'
                                request_type != null ? append_approval_details("Request Type" , request_type) : '';

                            }else if (request_type == 'BULK'){
                                let request_type = 'Bulk Payment'
                                request_type != null ? append_approval_details("Request Type" , request_type) : '';

                            }else if (request_type == 'STR'){
                                let request_type = 'Statement Request'
                                request_type != null ? append_approval_details("Request Type" , request_type) : '';

                            }else if (request_type == 'FD'){
                                let request_type = 'Fixed Deposit'
                                request_type != null ? append_approval_details("Request Type" , request_type) : '';

                            }else if (request_type == 'STST'){
                                let request_type = 'Stop Standing Order'
                                request_type != null ? append_approval_details("Request Type" , request_type) : '';

                            }else if (request_type == 'COMPL'){
                                let request_type = 'Complaints'
                                request_type != null ? append_approval_details("Request Type" , request_type) : '';

                            }else if (request_type == 'CHQR'){
                                let request_type = 'Cheque Book Request'
                                request_type != null ? append_approval_details("Request Type" , request_type) : '';

                            }else {
                                let request_type = ''
                                request_type != null ? append_approval_details("Request Type" , request_type) : '';
                            }


                            let posted_by = pending_request.postedby;
                            posted_by != null ? append_approval_details("Posted By" , posted_by) : '';

                            let debit_account = pending_request.account_no;
                            debit_account != null ? append_approval_details("Debit Account" , debit_account) : '';



                            let bank_name = pending_request.bank_name;
                            bank_name != null ? append_approval_details("Bank Name" , bank_name) : '';

                            let beneficiary_account = pending_request.creditaccountnumber;
                            beneficiary_account != null ? append_approval_details("Beneficiary Account" , beneficiary_account) : '';

                            let beneficiary_address = pending_request.beneficiaryaddress;
                            beneficiary_address != null ? append_approval_details("Beneficiary Address" , beneficiary_address) : '';

                            let beneficiary_name = pending_request.beneficiaryname;
                            beneficiary_name != null ? append_approval_details("Beneficiary Name" , beneficiary_name) : '';

                            let currency = pending_request.currency;
                            currency != null ? append_approval_details("Currency" , currency) : '';

                            let amount = pending_request.amount;
                            amount != null ? append_approval_details("Amount" , formatToCurrency(parseFloat(amount))) : '';



                            let total_amount = pending_request.total_amount;
                            total_amount != null ? append_approval_details("Total Amount" , formatToCurrency(parseFloat(total_amount))) : '';

                            let narration = pending_request.narration;
                            narration != null ? append_approval_details("Narration" , narration) : '';

                            let category = pending_request.category;
                            category != null ? append_approval_details("Cartegory" , category) : '';

                            let batch_number = pending_request.batch;
                            batch_number != null ? append_approval_details("Batch Number" , batch_number) : '';

                            let reference_number = pending_request.ref_no;
                            reference_number != null ? append_approval_details("Reference Number" , reference_number) : '';

                            let frequency = pending_request.frequency;
                            frequency != null ? append_approval_details("Frequency" , frequency) : '';

                            let order_number = pending_request.order_number;
                            order_number != null ? append_approval_details("Order Number" , order_number) : '';

                            let cheque_number_from = pending_request.cheque_from;
                            cheque_number_from != null ? append_approval_details("Cheque Number From" , cheque_number_from) : '';

                            let cheque_number_to = pending_request.cheque_to;
                            cheque_number_to != null ? append_approval_details("Cheque Number To" , cheque_number_to) : '';

                            let leaflet = pending_request.leaflet;
                            leaflet != null ? append_approval_details("Number of Leaflet" , leaflet) : '';

                            $('#approvers_list').append(`<h2 class="approvers">${pending_request.approvers}</h2>`)


                            {{--  $('#request_date').text(pending_request.post_date);
                            $('#request_type').text(pending_request.request_type);
                            $('#posted_by').text(pending_request.postedby);
                            $('#debit_account').text(pending_request.account_no);
                            $('#beneficiary_name').text(pending_request.beneficiary_name);
                            $('#beneficiary_account').text(pending_request.creditaccountnumber);
                            $('#beneficiary_address').text(pending_request.beneficiaryaddress);
                            $('#amount').text(formatToCurrency(parseFloat(pending_request.amount)));
                            $('#total_amount').text(formatToCurrency(parseFloat(pending_request.total_amount)));
                            $('#currency').text(pending_request.currency);
                            $('#Narration').text(pending_request.narration);
                            $('#category').text(pending_request.category);
                            $('#batch_number').text(pending_request.batch);
                            $('#reference_number').text(pending_request.ref_no);
                            $('#frequency').text(pending_request.frequency);
                            $('#cheque_number_from').text(pending_request.cheque_from);
                            $('#cheque_number_to').text(pending_request.cheque_to);  --}}


                         }

                    },
                    error: function(xhr, status, error) {

                        setTimeout ( function(){ account_mandate(customer, request) }, $.ajaxSetup().retryAfter )
                    }
                })
            }

            function append_approval_details(description , data) {

                $('#approval_details').append(`<div class="row ">
                    <span class="col-md-6 text-left h4">${description}</span>
                    <span class="col-md-6 text-right text-primary h4">${data}</span>
                </div>
                <hr class="mt-0">`)
             };

        $(document).ready(function() {

            setTimeout(function() {
                account_mandate();

            },300);

            //Reject Button
            $("#reject_transaction").click(function(e){
                e.preventDefault();
                {{--  alert("Reject Transaction");  --}}

                Swal.fire({
                    title: 'Proveide reason for rejection',
                    input: 'text',
                    inputAttributes: {
                      autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#f1556c',
                    confirmButtonText: 'Proceed',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                      return fetch(`//api.github.com/users/${login}`)
                        .then(response => {
                          if (!response.ok) {
                            throw new Error(response.statusText)
                          }
                          return response.json()
                        })
                        .catch(error => {
                          Swal.showValidationMessage(
                            `Request failed: ${error}`
                          )
                        })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                  }).then((result) => {
                    if (result.isConfirmed) {
                      Swal.fire({
                        title: `${result.value.login}'s avatar`,
                        imageUrl: result.value.avatar_url
                      })
                    }
                  })

            })

            $("#approve_transaction").click(function (e){
                e.preventDefault();



                {{-- alert("Approve Transaction"); --}}

                approve_request();





            })

            function ajax_post(){
                $('#approve_transaction').text("Processing ...")
                var customer = @json($customer_no);
                var request = @json($request_id);

                $.ajax({
                    type : 'POST',
                    url : "../../approved-pending-request" ,
                    datatype : 'application/json',
                    data : {
                        'customer_no' : customer,
                        'request_id' : request
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response)
                        if (response.responseCode == '000') {
                            Swal.fire('', response.message, 'success');

                            setTimeout(function(){
                                window.opener.location.reload();
                                window.close();
                            }, 5000)

                        }else {
                            Swal.fire('', response.message, 'error');

                        }

                        $('#approve_transaction').html(`Approve<i class="mdi mdi-check-all">`)
                    },
                    error: function(xhr, status, error) {
                        $('#approve_transaction').html(`Approve<i class="mdi mdi-check-all">`)
                    }
                })
            }

            function approve_request() {



                Swal.fire({
                    title: 'Do you want to Approve the transaction?',
                    showDenyButton: false,
                    showCancelButton: true,
                    confirmButtonText: `Proceed`,
                    confirmButtonColor: '#18c40d',
                    cancelButtonColor: '#df1919',
                    {{-- denyButtonText: `Don't save`, --}}
                  }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        ajax_post()

                    } else if (result.isDenied) {
                      Swal.fire('Failed to approve transaction', '', 'info')
                    }
                  })


            }

         });
    </script>
@endsection
