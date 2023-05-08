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
        <br>

        @php
            $currentPath = ' Approval Form';
            $basePath = 'Pending Approval';
            $pageTitle = 'Approval Form';
        @endphp
        @include('snippets.pageHeader')
        <div class="row  ">
            <div class="col-12">
                <div class="">
                    <div class=" card-body ">
                        <div class="row">
                            {{-- <div class="col-md-1"></div> --}}

                            <div class="col-md-8">

                                <div class="dashboard site-card">
                                    <div class=" tab-content dashboard-body border-danger border table-responsive p-8">

                                        <div class="">
                                            <div class="">
                                                <div class=" col-md-12">
                                                    <div class="col-md-12">


                                                        <div class="  text-center">
                                                            <div class="col-md-12">
                                                                <br>
                                                                <div id="approval_details">
                                                                    <div
                                                                        class="d-flex justify-content-center canvas_loader">
                                                                        <div class="spinner-border avatar-lg text-danger  m-2 canvas_spinner"
                                                                            role="status">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{-- <br><br> --}}
                                                                <table  class="table mb-0 table-striped mx-auto pending_status" style="margin-top: -15px;display:none">
                                                                    <tbody>
                                                                        <tr class="hide-on-success bg-danger  text-white">
                                                                            <td colspan="2">
                                                                                <div class="custom-control d-flex custom-checkbox ">
                                                                                    <input type="checkbox" class="custom-control-input d-block" name="terms_and_conditions"
                                                                                        id="terms_and_conditions">
                                                                                    <label class="custom-control-label d-flex  align-items-center font-weight-bold"
                                                                                        for="terms_and_conditions">
                                                                                        By checking this box, you agree to
                                                                                        abide by the Terms and Conditions
                                                                                    </label>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>

                                                                </table>
                                                                <br>
                                                                <div class="mt-3">


                                                                    <div class="col-md-12 mb-3 pending_status" style="display:none">
                                                                        <div class="row">
                                                                            <div class="col-md-2"></div>
                                                                            <button
                                                                                class="btn btn-secondary waves-effect waves-light col-md-3 btn-lg"
                                                                                id="reject_transaction"
                                                                                type="button">Reject
                                                                                <i class="mdi mdi-cancel"></i>
                                                                            </button>
                                                                            <div class="col-md-2"></div>
                                                                            <button
                                                                                class="btn btn-success waves-effect waves-light col-md-3 btn-lg"
                                                                                data-toggle="modal"
                                                                                data-target="#success-alert-modal"
                                                                                id="approve_transaction"
                                                                                type="button">Approve
                                                                                <i class="mdi mdi-check-all"></i>
                                                                            </button>
                                                                            <div class="col-md-2"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 approved_status"
                                                                        style="display: none">
                                                                        <div class="row">
                                                                            <div class="col-md-3"></div>
                                                                            <div class="col-md-6">
                                                                                <div class="alert alert-success"
                                                                                    role="alert">
                                                                                    <i class="mdi mdi-check-all"></i>
                                                                                    <strong>Transaction Approved </strong>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 rejected_status"
                                                                        style="display: none">
                                                                        <div class="row">
                                                                            <div class="col-md-3"></div>
                                                                            <div class="col-md-6">
                                                                                <div class="alert alert-danger"
                                                                                    role="alert">
                                                                                    <i class="mdi mdi-cancel"></i>
                                                                                    <strong>Transaction Rejected</strong>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3"></div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12 mb-3">
                                                                        <div class="row">
                                                                            <div class="col-md-4"></div>
                                                                            <div class="col-md-4">
                                                                                {{-- <button type="button" class="btn btn-blue btn-sm waves-effect waves-light">Btn Small</button> --}}

                                                                            </div>
                                                                            <div class="col-md-4"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 ">
                                <div class=" site-card p-1">
                                    <div class="site-card-body ">
                                        <h3 class=" text-center">Account Mandate</h3>
                                        <p id="account_mandate" class="text-center text-danger" style="font-size:18px">
                                        </p>

                                        <br>
                                        <h3 class=" text-center">Initiated By</h3>
                                        <p id="initiated_by" class="text-center text-danger" style="font-size:18px"></p>

                                        <br>
                                        <h3 class="mb-1 text-center approvers_list_title">Status</h3>
                                        <p id="approvers_list" class="text-center text-danger" style="font-size:18px">
                                        </p>

                                    </div>

                                </div>



                                <div class="site-card p-1">
                                    <div class="site-card-body py-2 bg-danger" style="min-height: 10px !important;">
                                        <h6 class="text-center mb-0 text-white text-bold">Approvers</h6>
                                    </div>
                                    <div class="site-card-body">



                                        <div class="table-responsive">
                                            <table class="table table-borderless mb-0">
                                                {{-- <thead class="bg-primary">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Mandate</th>

                                                    </tr>
                                                </thead> --}}
                                                <tbody class="approvers_list">

                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive-->

                                    </div> <!-- end card-box -->
                                </div> <!-- end col -->





                            </div>



                        </div>
                    </div>

                </div> <!-- end card-body -->



            </div> <!-- end col -->

        </div> <!-- end row -->



        {{--  bulk transfer modal  --}}
        <!--  Modal content for the Large example -->
        <div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title text-dark" id="myLargeModalLabel"> BULK TRANSACTION DETAILS</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div class=" card-body table-responsive">

                                    <table id="datatable-buttons"
                                        class="table table-bordered table-striped dt-responsive nowrap w-100 bulk_upload_list">

                                        <thead>
                                            <tr class="table-background text-white">
                                                <th>No</th>
                                                <th>
                                                    <span id="bulk_header">Credit Acc</span>
                                                    <span id="bkorp_header">Mobile Number</span>
                                                </th>
                                                <th>Name</th>
                                                <th>Amount</th>

                                            </tr>
                                        </thead>

                                        <tbody class="bulk_upload_list_body">
                                            {{--  <tr>
                                                <td colspan="4">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="spinner-border avatar-lg text-danger  m-2 canvas_spinner"
                                                            role="status">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>  --}}
                                        </tbody>


                                    </table>


                                </div> <!-- end card body-->

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        {{--  Swift Rutile modal  --}}
        <!--  Modal content for the Large example -->
        <div class="modal fade" id="bs-example-modal-lg1" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title text-dark" id="myLargeModalLabel"> SWIFT TRANSFER DETAILS</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div class=" card-body table-responsive">

                                    <table id="datatable-buttons"
                                        class="table table-bordered table-striped dt-responsive nowrap w-100 rutile_swift_details">

                                        <thead>
                                            <tr class="table-background text-white">
                                                <th>Reference</th>
                                                <th>Account</th>
                                                <th>Amount</th>
                                                <th>Beneficiary Account</th>
                                                <th>Benficary Name</th>

                                            </tr>
                                        </thead>

                                        <tbody class="rutile_swift_details_body">
                                            {{--  <tr>
                                                <td colspan="4">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="spinner-border avatar-lg text-danger  m-2 canvas_spinner"
                                                            role="status">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>  --}}
                                        </tbody>


                                    </table>


                                </div> <!-- end card body-->

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <!--  Modal content for the Large example -->
        <div class="modal fade" id="bs-example-modal-lg2" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title text-dark" id="myLargeModalLabel"> Transaction Invoice</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body display-trans-invoice">
                        <img class="display-trans-invoice" style="width:700px;height:700px;padding:10px" />
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->




    </div>
    </div>
@endsection

@section('scripts')
    <!-- third party js -->

    @include('extras.datatables')



    <script>
        function account_mandate() {

            var customer = @json($customer_no);
            var request = @json($request_id);
            var mandate = @json($mandate)

            //console.log(customer);
            //console.log(request);
            //console.log(mandate);

            $.ajax({
                type: 'GET',
                url: "../../pending-request-details-api?customer_no=" + customer + "&request_id=" + request,
                datatype: 'application/json',
                success: function(response) {
                    console.log("pending request detail=>", response);

                    if (response.responseCode == '000') {
                        $("#approval_details").empty()

                        let pending_request = response.data[0];
                        let approvers_mandate = response.data[1]
                        console.log("pending_request=>", pending_request);

                        if (pending_request == null || pending_request == '') {
                            {{-- Swal.fire('', 'Request does not exit', 'error'); --}}
                            window.close()

                        }

                        $('#account_mandate').text(pending_request.account_mandate);
                        $('#initiated_by').text(pending_request.postedby);


                        let post_date = pending_request.post_date;
                        post_date != null ? append_approval_details("Issue Date", post_date) : '';

                        let request_type = pending_request.request_type;
                        if (request_type == 'SO') {
                            let request_type = 'Standing Order';
                            request_type != null ? append_approval_details("Request Type", request_type) : '';

                        } else if (request_type == 'RTGS') {
                            let request_type = 'RTGS Transfer'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';

                        } else if (request_type == 'SAB') {
                            let request_type = 'Same Bank Transfer'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';
                        } else if (request_type == 'OWN') {
                            let request_type = 'Own Account Transfer'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';
                        } else if (request_type == 'BOL') {
                            let request_type = 'Bollore Transfer'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';
                        } else if (request_type == 'ACH') {
                            let request_type = 'ACH Transfer'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';

                        } else if (request_type == 'OBT') {
                            let request_type = 'Other Bank Transfer'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';

                        } else if (request_type == 'INTB') {
                            let request_type = 'International Bank Transfer'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';

                        } else if (request_type == 'BULK') {
                            let request_type = 'Bulk Payment'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';
                            request_type != null ? append_approval_details_bulk("Request Type", request_type) :
                                '';

                        } else if (request_type == 'SWIFT') {
                            let request_type = 'Rutile Swift'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';
                            request_type != null ? append_approval_details_rutile("Request Type",
                                    request_type) :
                                '';
                        } else if (request_type == 'DTRA') {
                            let request_type = 'Direct Transfer'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';

                            {{-- }else if (request_type == 'BULK'){
                                let request_type = 'Bulk Payment'
                                request_type != null ? append_approval_details("Request Type" , request_type) : ''; --}}

                        } else if (request_type == 'STR') {
                            let request_type = 'Statement Request'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';

                        } else if (request_type == 'FD') {
                            let request_type = 'Fixed Deposit'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';

                        } else if (request_type == 'STST') {
                            let request_type = 'Stop Standing Order'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';

                        } else if (request_type == 'COMPL') {
                            let request_type = 'Complaints'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';

                        } else if (request_type == 'CNO') {
                            let request_type = 'Create New Originator'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';

                        }else if (request_type == 'CHQS') {
                            let request_type = 'Stop Cheque Request'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';
                        } else if (request_type == 'CHQR') {
                            let request_type = 'Cheque Book Request'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';

                        } else if (request_type == 'UTL') {
                            let request_type = 'Utility'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';
                        } else if (request_type == 'AIR') {
                            let request_type = 'Airtime'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';
                        } else if (request_type == 'MOM') {
                            let request_type = 'Mobile Money'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';

                        } else if (request_type == 'KORP') {
                            //let request_type = 'E-Korpor Transaction'
                            let request_type = 'Salone-Link Transaction'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';
                        } else if (request_type == 'CARDR') {
                            let request_type = 'Card Request'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';
                        } else if (request_type == 'CARDB') {
                            let request_type = 'Card Block'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';
                        } else if (request_type == 'CARD') {
                            let request_type = 'Cardless Transaction'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';
                        } else if (request_type == 'BKORP') {
                            let request_type = 'Bulk E-Korpor Transaction'
                            request_type != null ? append_approval_details("Request Type", request_type) : '';
                            request_type != null ? append_approval_details_bulk("Request Type", request_type) :
                                '';
                        } else {
                            let request_type = ''
                            request_type != null ? append_approval_details("Request Type", request_type) : '';
                        }




                        let account_name = pending_request.account_name;
                        account_name != null ? append_approval_details("Account Name", account_name) : '';

                        let debit_account = pending_request.account_no;
                        debit_account != null ? append_approval_details("Debit Account", debit_account) : '';

                        let currency = pending_request.currency;

                        currency = pending_request.currency == ('ACH' || 'RTGS') ? pending_request.currency :
                            pending_request.currency;
                        currency != null ? append_approval_details("Currency", currency) : '';



                        let amount = pending_request.amount;
                        amount != null ? append_approval_details("Amount", formatToCurrency(parseFloat(
                            amount))) : '';



                        let total_amount = pending_request.total_amount;
                        total_amount != null ? append_approval_details("Total Amount", formatToCurrency(
                            parseFloat(total_amount))) : '';


                        let type = pending_request.type;
                        type != null ? append_approval_details("Request Type", type) : '';

                        let card_number = pending_request.card_number;
                        card_number != null ? append_approval_details("Card Number", card_number) : '';

                        let bank_name = pending_request.bank_name;
                        bank_name != null ? append_approval_details("Bank Name", bank_name) : '';

                        {{--  let beneficiary_name = pending_request.beneficiary_name;
                        beneficiary_name != null ? append_approval_details("Beneficiary Name",
                            beneficiary_name) : '';  --}}

                        let beneficiary_name_ = pending_request.beneficiaryname;
                        beneficiary_name_ != null ? append_approval_details("Beneficiary Name",
                            beneficiary_name_) : '';

                        let beneficiary_account = pending_request.creditaccountnumber;
                        beneficiary_account != null ? append_approval_details("Beneficiary Account",
                            beneficiary_account) : '';

                        let beneficiary_address = pending_request.beneficiaryaddress;
                        beneficiary_address != null ? append_approval_details("Beneficiary Address",
                            beneficiary_address) : '';



                        let beneficiary_telephone = pending_request.beneficiarytelephone;
                        beneficiary_telephone != null ? append_approval_details("Beneficiary Telephone",
                            beneficiary_telephone) : "";

                        let id_type = pending_request.id_type;
                        id_type != null ? append_approval_details("ID Type", id_type) : '';

                        let id_number = pending_request.id_number;
                        id_number != null ? append_approval_details("ID Number", id_number) : '';


                        let narration = pending_request.narration;
                        narration != null ? append_approval_details("Narration", narration) : '';

                        let category = pending_request.category;
                        category != null ? append_approval_details("Category", category) : '';

                        let batch_number = pending_request.batch;
                        batch_number != null ? append_approval_details("Batch Number", batch_number) : '';

                        let reference_number = pending_request.ref_no;
                        reference_number != null ? append_approval_details("Reference Number",
                            reference_number) : '';



                        let order_number = pending_request.order_number;
                        order_number != null ? append_approval_details("Order Number", order_number) : '';

                        let start_date = pending_request.trans_start;
                        start_date != null ? append_approval_details('Start Date', start_date) : '';

                        let end_date = pending_request.trans_end;
                        end_date != null ? append_approval_details("End Date", end_date) : '';

                        let branch_name = pending_request.branch_name;
                        branch_name != null ? append_approval_details("Pick Up Branch", branch_name) : '';

                        let frequency = pending_request.frequency;
                        frequency != null ? append_approval_details("Frequency", frequency) : '';

                        let cheque_number_from = pending_request.cheque_from;
                        cheque_number_from != null ? append_approval_details("Cheque Number From",
                            cheque_number_from) : '';

                        let cheque_number_to = pending_request.cheque_to;
                        cheque_number_to != null ? append_approval_details("Cheque Number To",
                            cheque_number_to) : '';

                        let leaflet = pending_request.leaflet;
                        leaflet != null ? append_approval_details("Number of Leaflet", leaflet) : '';

                        let utility_id = pending_request.utility_id;
                        utility_id != null ? append_approval_details("Utility Id", utility_id) : '';



                        let posted_by = pending_request.postedby;
                        posted_by != null ? append_approval_details("Posted By", posted_by) : '';

                        let transaction_invoice = pending_request.trans_invoice;
                        transaction_invoice != null ? append_transaction_invoice("Transaction Invoice",
                            transaction_invoice) : '';

                        let transaction_invoice_batch = pending_request.invoice_batch;

                        let pending_approvers = pending_request.approvers
                        if (pending_approvers == null || pending_approvers == undefined) {
                            var approvers = 'PENDING APPROVAL'
                            $('#approvers_list').append(
                                `<p class="approvers" style="font-size:18px">${approvers}</p>`)
                        } else {
                            $('.approvers_list_title').text('Approved By')
                            $('#approvers_list').append(
                                `<p class="approvers" style="font-size:18px">  ${pending_approvers}</p>`)
                        }



                        {{-- $('#request_date').text(pending_request.post_date);
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
                            $('#cheque_number_to').text(pending_request.cheque_to); --}}

                        console.log(request_type)

                        if (request_type == 'BULK') {
                            ajax_call_bulk_details_endpoint(batch_number)
                            $("#bulk_header").show();
                            $("#bkorp_header").hide();
                        } else if (request_type == 'BKORP') {
                            $("#bkorp_header").show();
                            $("#bulk_header").hide();
                            ajax_call_bulk_korpor_details_endpoint(batch_number)
                        } else if (request_type == 'SWIFT') {
                            ajax_call_rutile_swift(batch_number)
                            //console.log("swift ===>", pending_request)

                        }

                        ajax_call_transaction_invoice(transaction_invoice_batch)

                        $.each(approvers_mandate, function(index) {

                            let appr_man = approvers_mandate[index]
                            console.log(appr_man)

                            $('.approvers_list').append(
                                `
                                <tr>
                                    <td>${approvers_mandate[index].first_name} ${approvers_mandate[index].surname}</td>
                                    <td>${approvers_mandate[index].approver_state}</td>
                                </tr>
                                `
                            )

                        })

                        let request_status = response.data[0].request_status

                        console.log('======');
                        console.log(request_status);
                        console.log('======');

                        if (request_status == 'P') {
                            $('.pending_status').show();
                            $('.approved_status').hide();
                            $('.rejected_status').hide();

                        } else if (request_status == 'A') {
                            $('.approved_status').show();
                            $('.pending_status').hide();
                            $('.rejected_status').hide();
                        } else if (request_status == 'R') {
                            $('.rejected_status').show();
                            $('.pending_status').hide();
                            $('.approved_status').hide();

                        } else {
                            return false;
                        }




                    }

                },
                error: function(xhr, textStatus, errorThrown) {
                    if (textStatus == "timeout") {
                        this.tryCount++;
                        if (this.tryCount <= this.retryLimit) {
                            //try again
                            $.ajax(this);
                            return;
                        }
                        return;
                    }
                    if (xhr.status == 500) {
                        $.ajax(this);
                    } else {
                        //handle error
                    }
                },
            })
        }

        function ajax_call_bulk_details_endpoint(batch_no) {
            var table = $('.bulk_upload_list').DataTable({
                destroy: true
            });
            var nodes = table.rows().nodes();

            var customer = @json($customer_no);
            var request = @json($request_id);
            {{-- alert(batch_no)
            return false; --}}



            $.ajax({
                type: 'POST',
                url: "../../get-bulk-detail-list-for-approval",
                datatype: 'application/json',
                data: {
                    'batch_no': batch_no
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.responseCode == '000') {
                        let details = response.data.uploadData


                        // $(".bulk_upload_list tr").remove();
                        table.clear().draw()
                        let count = 1

                        $.each(details, function(index) {

                            table.row.add([
                                count,
                                details[index].accountNumber,
                                formatToCurrency(parseFloat(details[index].amount)),
                                details[index].name

                            ]).draw(false)

                            count++
                        })

                    } else {

                        console.log("get-bulk-detail-list-for-approval==>", response)

                    }


                },
                error: function(xhr, status, error) {
                    setTimeout(function() {
                        ajax_call_bulk_details_endpoint(batch_no)
                    }, $.ajaxSetup().retryAfter)
                }
            })

        }

        function ajax_call_bulk_korpor_details_endpoint(batch_no) {
            var table = $('.bulk_upload_list').DataTable();
            var nodes = table.rows().nodes();

            var customer = @json($customer_no);
            var request = @json($request_id);



            $.ajax({
                type: 'POST',
                url: "../../get-bulk-detail-list-for-approval",
                datatype: 'application/json',
                data: {
                    'batch_no': batch_no
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response)
                    if (response.responseCode == '000') {
                        let details = response.data.bulk_details

                        table.clear().draw()
                        let count = 1

                        $.each(details, function(index) {

                            {{-- $('.bulk_upload_list_body').append(`
                                    <tr class="">
                                        <th>${count}</th>
                                        <th>${details[index].bban}</th>
                                        <th>${formatToCurrency(parseFloat(details[index].amount))}</th>
                                        <th>${details[index].name}</th>
                                    </tr>
                                `) --}}

                            table.row.add([
                                count,
                                details[index].mobile_no,
                                details[index].name,
                                details[index].amount

                            ]).draw(false)

                            count++
                        })

                    } else {


                    }


                },
                error: function(xhr, status, error) {
                    setTimeout(function() {
                        ajax_call_bulk_korpor_details_endpoint(batch_no)
                    }, $.ajaxSetup().retryAfter)
                }
            })

        }

        function ajax_call_rutile_swift(batch_no) {
            var table = $('.rutile_swift_details').DataTable({
                destroy: true
            });
            var nodes = table.rows().nodes();

            $.ajax({
                type: 'POST',
                url: "../../get-swift-rutile-detail-list-for-approval",
                datatype: 'application/json',
                data: {
                    'batch_no': batch_no
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {

                    //console.log("get-swift-rutile-detail-list-for-approval ==>", JSON.parse(response));
                    var res = JSON.parse(response)

                    if (res.responseCode == '000') {
                        let swift_details = res.data


                        console.log("rutile response ==>", swift_details);

                        // $(".bulk_upload_list tr").remove();
                        table.clear().draw()
                        {{--  let count = 1  --}}

                        $.each(swift_details, function(index) {

                            table.row.add([
                                swift_details[index].transaction_reference,
                                swift_details[index].creditor_account_no,

                                swift_details[index].currency + " " + formatToCurrency(
                                    parseFloat(swift_details[index]
                                        .transaction_amount)),
                                swift_details[index].beneficiary_account,
                                swift_details[index].beneficiary_name_and_address_1,

                            ]).draw(false)
                        })

                    } else {



                    }
                }
            })
        }

        function ajax_call_transaction_invoice(batch_no) {
            $.ajax({
                type: "POST",
                url: '../../get-transaction-invoice-api',
                {{--  contentType: "application/json; charset=utf-8",  --}}
                datatype: 'application/json',
                data: {
                    'batch_no': batch_no
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    {{--  console.log(response)  --}}
                    if (response.responseCode == "000") {
                        {{--  console.log(response.data)  --}}
                        $(".display-trans-invoice").attr("src", "data:image/jpeg;base64," + response.data)
                    } else {
                        setTimeout(function() {
                            ajax_call_transaction_invoice(batch_no)
                        }, 1000)
                    }

                },
                error: function(xhr, status, error) {
                    {{--  setTimeout(function() {
                        ajax_call_bulk_korpor_details_endpoint(batch_no)
                    }, $.ajaxSetup().retryAfter)  --}}
                }
            })
        }

        function append_approval_details(description, data) {

            $('#approval_details').append(`<div class="row ">
                    <span class="col-md-6 text-left font-14">${description}</span>
                    <span class="col-md-6 text-right text-primary font-14">${data}</span>
                </div>
                <hr class="mt-0">`)
        };

        function append_approval_details_bulk(description, data) {

            $('#approval_details').append(`<div class="row ">
                    <span class="col-md-6 text-left font-14">Bulk Details</span>
                    <span class="col-md-6 text-right text-primary ">
                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#bs-example-modal-lg">View Transaction Details</button>

                    </span>
                </div>
                <hr class="mt-0">`)
        };

        function append_approval_details_rutile() {
            $('#approval_details').append(`<div class="row ">
                    <span class="col-md-6 text-left font-14">Swift Details</span>
                    <span class="col-md-6 text-right text-primary ">
                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#bs-example-modal-lg1">View Transaction Details</button>

                    </span>
                </div>
                <hr class="mt-0">`)
        }

        function append_transaction_invoice() {
            $('#approval_details').append(`<div class="row ">
                    <span class="col-md-6 text-left font-14">Transaction Invoice</span>
                    <span class="col-md-6 text-right text-primary ">
                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#bs-example-modal-lg2">View Transaction Invoice</button>

                    </span>
                </div>
                <hr class="mt-0">`)
        }

        $(document).ready(function() {

            setTimeout(function() {
                account_mandate();

            }, 300);

            //Reject Button
            $("#reject_transaction").click(function(e) {
                e.preventDefault();
                {{-- alert("Reject Transaction"); --}}

                Swal.fire({
                    title: 'Provide reason for rejection',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#f1556c',
                    confirmButtonText: 'Proceed',
                    showLoaderOnConfirm: true,
                    preConfirm: (narration) => {
                        return ajax_post_for_reject();

                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        {{-- Swal.fire({
                            title: `${result.value.login}'s avatar`,
                            imageUrl: result.value.avatar_url
                        }) --}}
                        return false;
                    }
                })

            })

            $("#approve_transaction").click(function(e) {

                e.preventDefault();
                if (!$("#terms_and_conditions").is(":checked")) {
            toaster("Accept Terms & Conditions to continue", "warning");
            return false;
        }
                $("#approve_transaction").attr("disabled", true);
                $("#reject_transaction").attr("disabled", true);





                {{-- alert("Approve Transaction"); --}}
                {{-- return false; --}}
                approve_request();





            })




            function ajax_post() {
                $('#approve_transaction').text("Processing ...")
                siteLoading('show')


                var customer = @json($customer_no);
                var request = @json($request_id);

                $.ajax({
                    type: 'POST',
                    url: "../../approved-pending-request",
                    datatype: 'application/json',
                    data: {
                        'customer_no': customer,
                        'request_id': request
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        siteLoading('hide')

                        // console.log(response)
                        let res = JSON.parse(response);
                        if (res.responseCode == '000' || res.responseCode == '200') {
                            siteLoading('hide')

                            swal.fire({
                                // title: "Transfer successful!",
                                html: res.message,
                                icon: "success",
                                //showConfirmButton: "false",
                                confirmButtonColor: "green",

                            });

                            {{-- getAccounts(); --}}


                            {{-- setTimeout(function() {
                                window.location = 'approvals-pending'
                            }, 3000) --}}


                            setTimeout(function() {
                                // window.location = 'approvals-pending'
                                // window.opener.location.reload();
                                window.close();
                            }, 3000)


                        } else {
                            siteLoading('false')


                            swal.fire({
                                // title: "Transfer successful!",
                                html: res.message,
                                icon: "error",
                                //showConfirmButton: "false",
                                confirmButtonColor: "red",

                            });
                            $("#approve_transaction").attr("disabled", false);
                            $("#reject_transaction").attr("disabled", false);

                        }

                        $('#approve_transaction').html(`Approve<i class="mdi mdi-check-all">`)
                    },
                    error: function(xhr, status, error) {
                        $('#approve_transaction').html(`Approve<i class="mdi mdi-check-all">`)
                            $("#approve_transaction").attr("disabled", false);
                $("#reject_transaction").attr("disabled", false);
                    }
                })
            }

            function approve_request() {



                Swal.fire({
                    title: 'Do you want to Approve the transaction?',
                    icon: 'question',
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

                        toaster('Failed to approve transaction', 'error')
                        $("#approve_transaction").attr("disabled", false);
                        $("#reject_transaction").attr("disabled", false);

                        {{-- Swal.fire('Failed to approve transaction', '', 'info') --}}
                    }
                })


            }

            function ajax_post_for_reject() {
                let narration = $('.swal2-input').val()
                siteLoading('show')
                $('#reject_transaction').text("Processing ...")
                var customer_no = @json($customer_no);
                var request_id = @json($request_id);

                console.log(narration)

                $.ajax({
                    type: 'POST',
                    url: "../../reject-pending-request",
                    datatype: 'application/json',
                    data: {
                        'narration': narration,
                        'request_id': request_id,
                        'customer_no': customer_no
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response)
                        if (response.responseCode == '000') {
                            siteLoading('hide')

                            // swal.fire({
                            //     // title: "Transfer successful!",
                            //     html: response.message,
                            //     icon: "success",
                            //     showConfirmButton: "false",
                            // });

                            swal.fire({
                                // title: "Transfer successful!",
                                html: response.message,
                                icon: "success",
                                //showConfirmButton: "false",
                                confirmButtonColor: "green",

                            });



                            setTimeout(function() {
                                window.location = 'approvals-pending'
                                window.opener.location.reload();
                                window.close();
                            }, 5000)


                        } else {
                            siteLoading('hide')
                            {{-- Swal.fire('', response.message, 'error'); --}}
                            swal.fire({
                                // title: "Transfer successful!",
                                html: response.message,
                                icon: "error",
                                confirmButtonColor: "red",
                            });

                        }

                        $('#reject_transaction').html(`Reject <i class="mdi mdi-cancel">`)
                    },
                    error: function(xhr, status, error) {
                        $('#reject_transaction').html(`Reject <i class="mdi mdi-cancel">`)
                        Swal.showValidationMessage(
                            `Request failed: ${error}`
                        )
                    }
                })
            }

        });
    </script>
@endsection
