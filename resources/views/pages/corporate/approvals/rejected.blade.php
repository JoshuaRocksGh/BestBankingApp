@extends('layouts.master')

@section('styles')
    <!-- third party css -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- third party css end -->
@endsection

@section('content')
    @php
        $currentPath = 'Rejected ';
        $basePath = 'Approvals';
        $pageTitle = 'Rejected Approvals';
    @endphp
    @include('snippets.pageHeader')
    <div>
        {{-- <br> --}}
        {{-- <div class="row"> --}}
        {{-- <br> <br><br> --}}
        {{-- <div class="col-12"> --}}
        {{-- <div class=""> --}}
        {{-- <div class=""> --}}

        {{-- <div class="row"> --}}


        <div class="dashboard site-card">


            <div class="tab-content dashboard-body border-danger border table-responsive p-4">

                <table id="datatable-buttons"
                    class="table dt-responsive  table-bordered table-striped display responsive nowrap w-100 pending_transaction_request ">
                    <thead>
                        <tr class="table-background">
                            <th class="all">Rquest Id</th>
                            <th class="all">Req-Type</th>
                            <th class="all">Account No</th>
                            <th class="all">Narration</th>
                            {{--  <th class="all">Posted Date</th>  --}}
                            {{--  <th class="none">Initiated By</th>  --}}
                            <th class="all">Action</th>
                        </tr>
                    </thead>



                </table>


            </div> <!-- end card body-->



        </div>



        {{-- </div> <!-- end card-body --> --}}




        <!-- Info Alert Modal -->
        <div id="info-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="text-center">
                            <i class="dripicons-information h1 text-info"></i>
                            <h4 class="mt-2">Heads up!</h4>
                            <p class="mt-3">Cras mattis consectetur purus sit amet fermentum. Cras
                                justo
                                odio, dapibus ac facilisis in, egestas eget quam.</p>
                            <button type="button" class="btn btn-info my-2" data-dismiss="modal">Continue</button>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->




        <!-- Modal -->
        <div id="multiple-one" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="multiple-oneModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="POST" id="confirm_details" autocomplete="off" aria-autocomplete="off">
                        <div class="modal-header">
                            <h4 class="modal-title font-16 purple-color" id="multiple-oneModalLabel">Confirm
                                Details</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>

                        <div class="modal-body">


                            <div class="row" id="transaction_summary">


                                <div class="col-md-12">
                                    <div class="border p-3 mt-4 mt-lg-0 rounded">
                                        <h4 class="header-title mb-3">Transfer Detail Summary</h4>

                                        <div class="table-responsive">
                                            <table class="table mb-0">

                                                <tbody>
                                                    <tr>
                                                        <td>From Account:</td>
                                                        <td>
                                                            <span
                                                                class="font-13 text-primary text-bold display_from_account_type"
                                                                id="display_from_account_type"></span>
                                                            <span
                                                                class="d-block font-13 text-primary text-bold display_from_account_name"
                                                                id="display_from_account_name"> </span>
                                                            <span
                                                                class="d-block font-13 text-primary text-bold display_from_account_no"
                                                                id="display_from_account_no"></span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>To Account:</td>
                                                        <td>

                                                            <span
                                                                class="font-13 text-primary text-bold display_to_account_type"
                                                                id="display_to_account_type"> </span>
                                                            <span
                                                                class="d-block font-13 text-primary text-bold display_to_account_name"
                                                                id="display_to_account_name"> </span>
                                                            <span
                                                                class="d-block font-13 text-primary text-bold display_to_account_no"
                                                                id="display_to_account_no"> </span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Amount:</td>
                                                        <td>
                                                            <span class="font-15 text-primary h3 display_currency"
                                                                id="display_currency"> </span>
                                                            &nbsp;
                                                            <span class="font-15 text-primary h3 display_transfer_amount"
                                                                id="display_transfer_amount"></span>

                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td>Category:</td>
                                                        <td>
                                                            <span class="font-13 text-primary h3 display_category"
                                                                id="display_category"></span>

                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td>Purpose:</td>
                                                        <td>
                                                            <span class="font-13 text-primary h3 display_purpose"
                                                                id="display_purpose"></span>
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td>Schedule Payment:</td>
                                                        <td>
                                                            <span class="font-13 text-primary h3 display_schedule_payment"
                                                                id="display_schedule_payment">NO </span>
                                                            &nbsp; | &nbsp;
                                                            <span
                                                                class="font-13 text-primary h3 display_schedule_payment_date"
                                                                id="display_schedule_payment_date"> N/A
                                                            </span>
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td>Transfer Date: </td>
                                                        <td>
                                                            <span class="font-13 text-primary h3"
                                                                id="display_transfer_date">{{ date('d F, Y') }}</span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Posted BY: </td>
                                                        <td>
                                                            <span class="font-13 text-primary h3"
                                                                id="display_posted_by">Kwabena Ampah</span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Enter Pin: </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" name="user_pin" class="form-control"
                                                                    id="user_pin"
                                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                                            </div>
                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- end table-responsive -->
                                        <br>
                                        <div class="form-group text-center">
                                            <span> <button class="btn btn-secondary btn-rounded" type="button"
                                                    id="back_button">Back</button> &nbsp;
                                            </span>
                                            <span>&nbsp; <button class="btn btn-primary btn-rounded" type="button"
                                                    id="confirm_button">Confirm Transfer
                                                </button></span>
                                            <span>&nbsp; <button class="btn btn-light btn-rounded" type="button"
                                                    id="receipt_button">Print Receipt
                                                </button></span>
                                        </div>
                                    </div>

                                </div> <!-- end col -->





                            </div>


                        </div>



                        <div class="modal-footer">
                            <button type="send" id="send" class="btn btn-primary" data-target="#multiple-two"
                                data-toggle="modal" data-dismiss="modal">Send</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->




        {{-- </div> <!-- end col --> --}}

        {{-- </div> <!-- end row --> --}}



        {{-- </div> --}}

        {{-- </div> --}}
    </div>
@endsection

@section('scripts')
    @include('extras.datatables')
    <script>
        function get_corporate_requests(customerNumber, requestStatus) {
            var table = $('.pending_transaction_request').DataTable();
            var nodes = table.rows().nodes();

            table
                .order([0, 'desc'])
                .column(0).visible(false, false)
                .draw();

            $(".loans_display_area").hide()
            $(".loans_error_area").hide()
            $(".loans_loading_area").show()

            $.ajax({
                type: "GET",
                url: "get-pending-requests?customerNumber=" + customerNumber + '&requestStatus=' + requestStatus,
                datatype: "application/json",

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);
                    if (response.responseCode == '000') {

                        let data = response.data;

                        table.clear().draw()


                        $.each(data, function(index) {


                            let request_id = data[index].request_id;
                            let customer_no = data[index].customer_no;

                            let today = new Date(data[index].post_date);
                            let dd = String(today.getDate()).padStart(2, '0');
                            let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                            let yyyy = today.getFullYear();

                            let amount = (data[index].currency) + ' ' + formatToCurrency(parseFloat(
                                data[index].amount))

                            let request_type = ''
                            if (data[index].request_type == 'OWN') {
                                request_type = 'Own Account Transfer'
                            } else if (data[index].request_type == 'SAB') {
                                request_type = 'Same Bank Transfer'
                            } else if (data[index].request_type == 'ACH') {
                                request_type = 'ACH Transfer'
                            } else if (data[index].request_type == 'RTGS') {
                                request_type = 'RTGS Transfer'
                            } else if (data[index].request_type == 'BULK') {
                                request_type = 'Bulk Transfer'
                            } else if (data[index].request_type == 'INT') {
                                request_type = 'International Bank Transfer'
                            } else if (data[index].request_type == 'KORP') {
                                request_type = 'E-Korpor'
                            } else {
                                request_type = 'Others'
                            }
                            // let request_id = data[index].request_id;
                            // let customer_no = data[index].customer_no;


                            table.row.add([

                                data[index].request_id,
                                request_type,
                                data[index].account_no,
                                data[index].narration,
                                {{--  dd + '/' + mm + '/' + yyyy,  --}}
                                {{--  data[index].postedby,  --}}

                                `
                                                                             {{--  <a href="{{ url('approvals-pending-transfer-details/${request_id}/${customer_no}') }} " target="_blank">  --}}
                                                                             <a href="approvals-pending-transfer-details/${request_id}/${customer_no} ">
                                                                                <button type="button" class=" btn btn-xs btn-outline-danger waves-effect waves-light"> View Details</button>
                                                                            </a>
                                                                            `

                            ]).draw(false)


                        })

                        $(".loans_error_area").hide()
                        $(".loans_loading_area").hide()
                        $(".loans_display_area").show()

                    } else {

                        $(".loans_error_area").hide()
                        $(".loans_loading_area").hide()
                        $(".loans_display_area").show()

                    }

                },
                error: function(xhr, status, error) {
                    $(".loans_display_area").hide()
                    $(".loans_loading_area").hide()
                    $(".loans_error_area").show()

                    setTimeout(function() {
                        get_corporate_requests(customerNumber, requestStatus)
                    }, $.ajaxSetup().retryAfter)

                }

            })


        }

        $(document).ready(function() {

            var customer_no = @json(session()->get('customerNumber'));
            var request_status = 'R'
            console.log(customer_no);

            $('.transfer_tab_btn').click(function() {
                let customer_no = @json(session()->get('customerNumber'));
                get_corporate_requests(customer_no, 'P')
            })
            get_corporate_requests(customer_no, request_status)
        })
    </script>
@endsection
