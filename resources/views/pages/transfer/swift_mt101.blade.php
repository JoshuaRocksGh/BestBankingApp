@extends('layouts.master')
@section('content')
    @php
        $pageTitle = 'SWIFT TRANSFER';
        $basePath = 'Transfer';
        $currentPath = 'Swift Transfer';
    @endphp
    @include('snippets.pageHeader')

    <div class="px-2">
        <div class="dashboard site-card overflow-hidden">
            <div class="form-group">
                <ul class="list-unstyled text-blue">
                    <li><i class="fa fa-info-circle text-red"></i>
                        <i> <b style="color:red;">Please Note: </b> Make Sure you have the
                            swift file in our secure shared location folder.
                        </i>
                    </li>
                </ul>
            </div>
            <div class="tab-content dashboard-body p-4">
                <div class="mx-auto  h-100 " style="max-width: 95%" id="swift_request">
                    <form id="upload_swift_form" class="" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            {{--  <div class="col-md-12">
                                <label class="text-dark">Account to transfer from</label>

                                <div class="form-group" data-title="Account Tab" data-intro="Click to select account">

                                    <select class="accounts-select " name="my_account" id="my_account" required>
                                        <option disabled selected value=""> --- Select Source Account --- </option>
                                        @include('snippets.accounts')

                                    </select>

                                </div>
                                <hr class="mt-0">

                            </div>  --}}
                            <div class="table-responsive ">
                                <label class="text-danger">File Details</label>
                                <table id=""
                                    class="table table-bordered  table-striped display responsive nowrap   w-100 pending_transaction_request ">
                                    <thead>
                                        <tr class="table-background">
                                            <th>Batch</th>
                                            <th>Debit Account</th>
                                            <th>Amount</th>
                                            <th>Beneficiary Account</th>
                                            {{--  <th >Transfer Purpose</th>  --}}
                                            <th>Beneficiary Name</th>
                                            {{--  <th class="none">Initiated By</th>  --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="request_table">

                                        {{--  {{ $swiftData }}  --}}
                                        @if (@isset($swiftData))
                                            {{--  <?php ?>  --}}
                                            @foreach ($swiftData as $data)
                                                <tr>
                                                    <td>
                                                        {{ $data['batch_no'] }}

                                                    </td>
                                                    <td>
                                                        {{ $data['creditor_account_no'] }}

                                                    </td>
                                                    <td>
                                                        {{--  @php
                                                            echo $data['currency'] . ' ' . number_format($data['transaction_amount'], 2);
                                                            echo $data['currency'] . ' ' . $data['transaction_amount'];
                                                        @endphp  --}}
                                                        {{ $data['currency'] . ' ' . $data['transaction_amount'] }}

                                                    </td>
                                                    <td>
                                                        {{ $data['creditor_account_no'] }}

                                                    </td>

                                                    <td>
                                                        {{ $data['beneficiary_name_and_address_1'] }}

                                                    </td>
                                                    <td>
                                                        {{--  {{ json_encode($data) }}  --}}
                                                        <button type="button"
                                                            class=" btn btn-xs btn-outline-info font-10 view_swift_details"
                                                            data-toggle="modal" data-target="#enquiry_modal"
                                                            data-swift="{{ json_encode($data) }}">
                                                            View </button>
                                                    </td>
                                                </tr>
                                                {{--  @foreach ($data as $lineData)

                                                @endforeach  --}}
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8">
                                                    <div class="d-flex justify-content-center">
                                                        {!! $noDataAvailable !!}

                                                    </div>
                                                </td>
                                            </tr>
                                        @endif


                                    </tbody>
                                </table>
                            </div> <!-- end card body-->


                            <div class="col-md-12">
                                {{--  <label class="text-danger">Transfer Details</label>
                                <br>  --}}
                                <div class="row">

                                    {{--  <div class="col-md-4 pb-2">
                                        <label for="inputEmail3" class="text-dark">Account Name</label>
                                        <input type="text" name="account_name" id="account_name"
                                            class="form-control input-sm" readonly="readonly">
                                    </div>  --}}

                                    {{--  <div class="col-md-4 pb-2">
                                        <label for="inputEmail3" class="text-dark">Account Balance</label>
                                        <input type="text" name="account_balance" id="account_balance"
                                            class="form-control input-sm" readonly="readonly">
                                    </div>  --}}

                                    {{--  <div class="col-md-4 pb-2">
                                        <label for="inputEmail3" class="text-dark">Account Currency</label>
                                        <input type="text" name="account_currency" id="account_currency"
                                            class="form-control input-sm" readonly="readonly">
                                    </div>  --}}

                                    {{--  <div class="col-md-4 form-group pb-2" data-title="Upload File"
                                        data-intro="Click to choose file">
                                        <label for="inputEmail3" class="col-12 col-form-label text-dark">Choose File<span
                                                class="text-danger"> *</span></label>
                                        <input type="file" name="excel_file" id="excel_file" class=" input-sm" required>
                                    </div>  --}}

                                    <div class="col-md-12 pt-4">
                                        <div class="form-group float-right">
                                            <button typ="button" class="btn btn-secondary">Cancel</button>&nbsp;&nbsp;
                                            <button type="submit" class="btn form-button" id="submit_swift">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>

            </div>


        </div>

        <div class="modal fade" id="enquiry_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document" style="wid">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white font-18 font-weight-bold">Swift Detail</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">X</span>
                        </button>
                    </div>
                    <div class="modal-body pb-4">

                        <form action="#" class="select_beneficiary p-4 mx-auto" id="payment_details_form"
                            style="max-width: 650px;" autocomplete="off" aria-autocomplete="none">
                            @csrf

                            <table class="table table-bordered  table-striped display responsive nowrap   w-100">
                                <tbody>
                                    <tr>
                                        <td>Batch No.</td>
                                        <td class='batch_no'></td>
                                    </tr>
                                    <tr>
                                        <td>Sender Reference</td>
                                        <td class='sender_ref'></td>
                                    </tr>
                                    <tr>
                                        <td>Debit Account</td>
                                        <td class='debit_account'></td>
                                    </tr>
                                    <tr>
                                        <td>Amount </td>
                                        <td class='amount'></td>
                                    </tr>
                                    <tr>
                                        <td>Beneficiary Name</td>
                                        <td class='beneficiary_name'></td>
                                    </tr>
                                    <tr>
                                        <td>Beneficiary Account</td>
                                        <td class='beneficiary_account'></td>
                                    </tr>
                                    <tr>
                                        <td>Beneficiary Address</td>
                                        <td class='beneficiary_address'></td>
                                    </tr>
                                    <tr>
                                        <td>Transaction Reference</td>
                                        <td class='transaction_ref'></td>
                                    </tr>

                                </tbody>
                            </table>

                        </form>

                    </div>
                    {{--  <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button"
                            class="btn form-button btn-rounded waves-effect waves-light disappear-after-success"
                            id="proceed_button">
                            Submit
                        </button>
                    </div>  --}}
                </div>
            </div>
        </div>

        <!-- Standard modal content -->
        {{--  <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Modal Heading</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <h6>Text in a modal</h6>
                        <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula.</p>
                        <hr>
                        <h6>Overflowing text to show scroll behavior</h6>
                        <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in,
                            egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                        <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel
                            augue laoreet rutrum faucibus dolor auctor.</p>
                        <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque
                            nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>  --}}
        <!-- /.modal -->

    </div>
@endsection

@section('scripts')
    {{--  <script src="{{ asset('assets/js/pages/transfer/swift_mt101.js') }}"></script>  --}}
    <script>
        $(document).ready(function() {
            $(".view_swift_details").click(function() {
                console.log($(this).attr('data-swift'))
                let swiftDataDispaly = JSON.parse($(this).attr('data-swift'))
                $(".batch_no").text(swiftDataDispaly.batch_no)
                $(".sender_ref").text(swiftDataDispaly.sender_reference)
                $(".debit_account").text(swiftDataDispaly.creditor_account_no)
                $(".amount").text(swiftDataDispaly.currency + " " + swiftDataDispaly.transaction_amount)
                $(".beneficiary_name").text(swiftDataDispaly.beneficiary_name_and_address_1)
                $(".beneficiary_account").text(swiftDataDispaly.beneficiary_account)
                $(".beneficiary_address").text(swiftDataDispaly.beneficiary_name_and_address_2 + " ," + swiftDataDispaly.beneficiary_name_and_address_3 )
                $(".transaction_ref").text(swiftDataDispaly.transaction_reference)

                //console.log(swiftDataDispaly.batch_no)
            })

            $("#submit_swift").click(function(e){
                e.preventDefault()
                let submitSwiftData = @json($swiftData);
                //console.log(submitSwiftData)
                $.ajax({
                    type: 'POST',
                    url: "submit-swift-approval",
                    datatype: "application/json",
                    data: {'data' :submitSwiftData},
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function(response){
                        //console.log(response)
                        if(response.responseCode == '000'){

                        toaster(response.message, "success")

                        //Redirectuser to landing page

                        }else{
                        toaster(response.message, "error")

                        }
                    },
                    error: function(xhr, status, error){
                        console.log("submission failed")
                    }

                })
            })
        })
    </script>
@endsection
