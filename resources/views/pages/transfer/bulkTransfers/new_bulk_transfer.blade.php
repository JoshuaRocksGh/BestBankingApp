@extends('layouts.master')

@section('content')
    @php
        $pageTitle = 'BULK TRANSFER UPLOAD';
        $basePath = 'Transfer';
        $currentPath = 'Bulk Transfer';
    @endphp

    @include('snippets.pageHeader')



    <div class="dashboard site-card overflow-hidden">
        {{--  <ul class="list-unstyled text-blue">
            <li><i class="fa fa-info-circle text-red"></i>
                <i> <b style="color:red;">Please Note: </b> Download template for upload
                    (<span class="text-danger"><a href="{{ url('download_other_bank_file') }}" class="text-danger"> Click
                            Here to Download </a></span>)
                    <ol>
                        <li>Template can be used for single upload of same bank and other banks.</li>
                        <li>If an error is found in file uploaded, please delete and re-upload.</li>
                    </ol>
                </i>
            </li>
        </ul>  --}}
        {{--  <p class="text-muted font-14 m-r-20 m-b-20" data-title="Excel File" data-intro="Click to download template for upload">
            <span> <i class="fa fa-info-circle  text-red"></i> <b style="color:red;">Please Note:&nbsp;&nbsp;</b>
            </span> Download template for upload (<span class="text-danger"><a href="{{ url('download_other_bank_file') }}"
                    class="text-danger"> Click
                    Here to Download </a></span>)


        </p>  --}}
        <form id="bulk_upload_form" class="dashboard-body p-4" action="#" enctype="multipart/form-data">
            @csrf

            <div class="row ">

                <div class="col-md-8">
                    <label class="text-dark">Account to transfer from</label>

                    <div class="form-group" data-title="Account Tab" data-intro="Click to select account">

                        <select class="accounts-select " name="my_account" id="my_account" required>
                            <option disabled selected value=""> --- Select Source Account --- </option>
                            @include('snippets.accounts')

                        </select>

                    </div>
                    <hr class="mt-0">

                </div>
                <div class="col-md-4 ">
                    <ul class="list-unstyled text-blue">
                        <li><i class="fa fa-info-circle text-red"></i>
                            <i> <b style="color: rgb(0, 183, 255);">Please Note: </b><br>
                                {{--  <ol>
                                        <li>Template can be used for single upload of same bank and other banks.</li>
                                        <li>If an error is found in file uploaded, please delete and re-upload.</li>
                                    </ol>  --}}
                            </i>
                        </li>
                    </ul>
                    <div class="col-md-12  p-1 ">
                        <ul>
                            <li>
                                - Download same bank template <br>
                                (<span class="text-danger"><a href="{{ url('download_same_bank_file') }}" class="text-danger">
                                        Click
                                        Here to Download </a></span>)
                            </li>
                            <li>
                               - Download other bank template <br>
                        (<span class="text-danger"><a href="{{ url('download_other_bank_file') }}" class="text-danger">
                                Click
                                Here to Download </a></span>)

                        </li>

                        </ul>


                    </div>


                </div>



                <div class="card-box col-md-12">
                    <label class="font-weight-bold text-danger">Transfer Details</label>
                    <br>
                    <div class="row">
                        {{-- <h4 for="" class="col-12 col-form-label text-primary"><b>Transfer Details</b></h4> --}}


                        {{--  <div class="col-md-4 form-group ">
                            <label for="inputEmail3" class="text-dark">Bank Type<span class="text-danger">
                                    *</span></label>
                            <select class="custom-select " name="bank_type" id="bank_type" required>
                                <option value="SAB" selected> Same Bank </option>
                                <option value="OTB"> Other Bank </option>
                            </select>
                        </div>  --}}



                        <div class="col-md-4  form-group" data-title="Bulk Amount" data-intro="Enter total amount">
                            <label for="inputEmail3" class="text-dark">Bulk
                                Amount<span class="text-danger"> *</span></label>
                            <div class="input-group-prepend ">
                                <input type="text" placeholder="SLE"
                                    class="col-3 form-control text-input account_currency " style="width: 20px;" disabled>
                                {{--  <input type="text" class="col-4">  --}}
                                <input type="text" name="bulk_amount" id="bulk_amount"
                                    pattern="([0-9]{1,3}).([0-9]{1,3})" placeholder="Enter total credit amount"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                    class="form-control bulk_amount" autocomplete="off"  style="text-transform:uppercase" required>
                            </div>


                        </div>





                        <div class="col-md-4 form-group" data-title="Reference"
                            data-intro="Enter reference same on upload file">
                            <label for="inputEmail3" class="text-dark">Upload Reference
                                <span class="text-danger"> *</span></label>
                            <input type="text" name="reference_no" id="reference_no" class="form-control input-sm" placeholder="Enter reference same in file"
                                autocomplete="off" style="text-transform:uppercase" required>

                        </div>






                        <div class="col-md-4 form-group" data-title="Reference"
                            data-intro="Enter reference same on upload file">
                            <label for="inputEmail3" class="text-dark">Transfer Narration
                                <span class="text-danger"> *</span></label>
                            <input type="text" name="transfer_narration" id="transfer_narration" autocomplete="off" placeholder="Enter transfer narration"
                                class="form-control input-sm" autocomplete="off" style="text-transform:uppercase" required>

                        </div>
                        <div class="col-md-4 form-group" data-title="Vaue Date" data-intro="Select date">
                            <label for="inputEmail3" class="text-dark">Value Date<span class="text-danger">
                                    *</span></label>
                            <input type="date" id="value_date" name="value_date" placeholder="Enter value date"
                                autocomplete="off" class="form-control" required>
                            {{-- parsley-trigger="change" autocomzplete="none" --}}
                            {{-- data-provide="datepicker" data-date-autoclose="true" --}}
                        </div>


                        <div class="col-md-4 form-group choose_upload_file" data-title="Upload File"
                            onclick="get_file_name('excel_file','choose_upload_file_name')"
                            data-intro="Click to choose file">
                            <label for="inputEmail3" class="text-dark">Choose Excel File<span class="text-danger">
                                    *</span></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="excel_file" autocomplete="off">
                                    <label class="custom-file-label" id="choose_upload_file_name" for="excel_file">Choose
                                        file</label>
                                </div>
                            </div>
                            {{--  <input class="p-2" type="file" name="excel_file" id="excel_file" class=" input-sm"
                                autocomplete="off" required>  --}}
                        </div>



                        <div class="col-md-4 form-group" data-title="Upload File" data-intro="Click to choose file"
                            onclick="get_file_name('invoice_file','transaction_voucher_file_name')">
                            <label for="inputEmail3" class=" text-dark"> Attach Invoice<span class="text-danger">
                                    *</span></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="invoice_file"
                                        id="invoice_file">
                                    <label class="custom-file-label" for="transaction_voucher_file_name"
                                        id="transaction_voucher_file_name">Choose file</label>
                                </div>
                            </div>
                            {{--  <input class="p-2" type="file" name="transaction_voucher" id="transaction_voucher"
                                autocomplete="off" class="input-sm " required>  --}}
                        </div>



                        <!-- end row -->






                        <br>



                        <!-- Large modal -->
                        {{-- <button type="button" class="btn btn-info" data-toggle="modal"
                            data-target="#bs-example-modal-lg">Large Modal</button> --}}
                        <br>
                        <hr>
                        <div class="col-md-12" data-title="Upload Button" data-intro="Click to upload">
                            <div class="form-group row">
                                <div class="col-8 offset-4 text-right">
                                    <button type="submit"
                                        class="btn next-button btn-rounded disappear-after-success form-button "
                                        id="submit_cheque_request">
                                        Validate File
                                    </button>
                                    {{-- <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#full-width-modal">Full width Modal</button></b> --}}

                                </div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>


            <div class="breakpoint display-upload-summary" data-title="Upload Summary" data-intro="View Upload Summary"
                style="display: none">
                <hr>

                <label class="font-weight-bold text-danger">Transfer Summary</label>
                <br>




                {{--  <table id="bulk_upload_list"
                    class="table table-bordered table-striped display responsive nowrap w-100 bulk_upload_list"
                    style="zoom: 0.9;">

                    <thead>
                        <tr class="table-background">
                            <th class="all"> Reference </th>
                            <th class="all"> Debit Account </th>
                            <th class="all"> Total Upload Amount </th>
                            <th class="all"> Value date </th>
                            <th class="none"> Total Upload </th>
                            <th class="none"> Failed </th>
                            <th class="none"> Action </th>

                        </tr>
                    </thead>

                    <tbody class="all_bulk_upload_summary">

                    </tbody>


                </table>  --}}

                <div class="card " style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;border-radius: 10px;">
                    <div class="card-body bulk-summary-card">
                        <div class="row">
                            <div class="col-md-12 row">
                                <div class="col-md-2">
                                    <p class="text-danger m-0">Reference:</p>
                                    <h4 class="upload_reference "></h4>
                                    {{--  <hr>  --}}
                                </div>
                                {{--    --}}
                                <div class="col-md-3 ">
                                    <p class="text-danger m-0">
                                        Debit Account:
                                    </p>
                                    <h4 class="upload_debit_account "></h4>
                                    {{--  <hr>  --}}
                                </div>
                                {{--    --}}
                                <div class="col-md-2 ">
                                    <p class="text-danger m-0 ">
                                        Total Amount:
                                    </p>
                                    <h4 class="upload_total_amount "></h4>

                                </div>
                                <div class="col-md-2 ">
                                    <p class="text-danger m-0 ">
                                        Total Upload:
                                    </p>
                                    <h4 class="upload_total"></h4>

                                    {{--  <span class="upload_failed "></span>  --}}

                                    {{--  <h4 class="upload_total_amount "></h4>  --}}

                                </div>
                                <div class="col-md-2 ">
                                    <p class="text-danger m-0 ">
                                        Failed Upload:
                                    </p>
                                    <span class="upload_failed "></span>

                                    {{--  <span class="upload_failed "></span>  --}}

                                    {{--  <h4 class="upload_total_amount "></h4>  --}}

                                </div>
                                <div class="col-md-1 text-center" style="margin-top:-15px">
                                    {{--  <p class="text-danger m-0 ">
                                        Action:
                                    </p>  --}}
                                    <br>
                                    <span class="upload_action "></span>

                                    {{--  <span class="upload_failed "></span>  --}}

                                    {{--  <h4 class="upload_total_amount "></h4>  --}}

                                </div>
                                {{--  <hr>  --}}
                                {{--    --}}
                            </div>
                            {{--  <hr class="col-md-10 float-center">  --}}
                            {{--  <div class="col-md-4"></div>  --}}
                            {{--    --}}
                            {{--  <div class="col-md-4"></div>  --}}

                            {{--    --}}
                            {{--  <div class="pt-2 col-md-4 upload_action"></div>  --}}



                            {{--  <div class="col-md-12 row">
                                <div class="col-md-4 ">
                                    <p class=" text-danger pt-0 mb-0">
                                        Total Upload</p>
                                    <h4 class="upload_total "></h4>
                                </div>
                                <div class="col-md-4 ">
                                    <p class="  text-danger pt-0 mb-0">
                                        Successful Upload</p>
                                    <span class="upload_successful "></span>
                                </div>
                                <div class="col-md-4 ">
                                    <p class="  text-danger pt-0 mb-0">
                                        Failed Upload</p>
                                    <span class="upload_failed "></span>

                                </div>
                            </div>  --}}




                        </div>
                    </div>

                </div>
            </div>
            @isset($bulkUploads)
                 {{-- {{ $bulkUploads['uploadDetails']['referenceNumber'] }} --}}
                <div>
                    <hr>
                    <label class="font-weight-bold text-danger">Pending Uploads </label>
                    <br>
                    @foreach($bulkUploads as $bulkUpload)
                    <div class="card" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;border-radius: 10px;">
                        <div class="card-body bulk-summary-card">
                            <div class="row">
                                <div class="col-md-12 row">
                                    <div class="col-md-2">
                                        <p class="text-danger m-0">Reference:</p>
                                        <h4>{{ $bulkUpload['uploadDetails']['referenceNumber'] ?? '' }}
                                        </h4>
                                        {{--  <hr>  --}}
                                    </div>
                                    {{--    --}}
                                    <div class="col-md-3 ">
                                        <p class="text-danger m-0">
                                            Debit Account:
                                        </p>
                                        <h4>{{ $bulkUpload['uploadDetails']['debitAccount'] ?? '' }}
                                        </h4>
                                        {{--  <hr>  --}}
                                    </div>
                                    {{--    --}}
                                    <div class="col-md-2 ">
                                        <p class="text-danger m-0 ">
                                            Total Amount:
                                        </p>
                                        <h4>
                                            {{ number_format($bulkUpload['uploadDetails']['totalAmount'], 2, '.', ',') ?? '' }}
                                        </h4>
                                        {{--  {{ number_format($bulkUploads['uploadDetails']['totalAmount'], 2, '.', ',') }}  --}}

                                    </div>
                                    <div class="col-md-2 ">
                                        <p class="text-danger m-0 ">
                                            Total Upload:
                                        </p>
                                        <h4>
                                            {{ count($bulkUpload['uploadData']) ?? '' }}

                                        </h4>

                                        {{--  <span class="upload_failed "></span>  --}}

                                        {{--  <h4 class="upload_total_amount "></h4>  --}}

                                    </div>
                                    <div class="col-md-2 ">
                                        <p class="text-danger m-0 ">
                                            Failed Upload:
                                        </p>
                                        <span>{{ $bulkUpload['uploadDetails']['failed'] ?? '' }}</span>

                                        {{--  <span class="upload_failed "></span>  --}}

                                        {{--  <h4 class="upload_total_amount "></h4>  --}}

                                    </div>
                                    <div class="col-md-1 text-center" style="margin-top:-15px">
                                        {{--  <p class="text-danger m-0 ">
                                        Action:
                                    </p>  --}}
                                        <br>
                                        @if ($bulkUpload['uploadDetails']['failed'] > 0)
                                            <span>
                                                <a href="delete-bulk-transfer?batch_no={{ $bulkUpload['uploadData'][0]['uploadBatch'] }}"
                                                    class=" waves-effect waves-light text-center delete_bulk_transfer_upload"
                                                    batch_no="">
                                                    <i class="mdi mdi-delete-forever-outline mdi-36px text-danger"
                                                        style="width:50px; height:80px"></i>
                                                </a>
                                            </span>
                                        @else
                                            <span>
                                                <a href="view-bulk-transfer?batch_no={{ $bulkUpload['uploadData'][0]['uploadBatch'] }}"
                                                    class=" waves-effect waves-light text-center delete_bulk_transfer_upload"
                                                    batch_no="">
                                                    <i class="mdi mdi mdi-check-all mdi-36px text-success"
                                                        style="width:50px; height:80px"></i>
                                                </a>
                                            </span>
                                        @endif

                                        {{--  <span class="upload_failed "></span>  --}}

                                        {{--  <h4 class="upload_total_amount "></h4>  --}}

                                    </div>
                                    {{--  <hr>  --}}
                                    {{--    --}}
                                </div>
                                {{--  <hr class="col-md-10 float-center">  --}}
                                {{--  <div class="col-md-4"></div>  --}}
                                {{--    --}}
                                {{--  <div class="col-md-4"></div>  --}}

                                {{--    --}}
                                {{--  <div class="pt-2 col-md-4 upload_action"></div>  --}}








                            </div>
                        </div>
                    </div>
                    <br>
                    @endforeach
                </div>
            @endisset



        </form>


    </div>



    {{-- <div class="col-md-1"></div> --}}

    {{-- </div> <!-- end card-body --> --}}

    {{-- </div> --}}
    {{-- </div> --}}




    <!--  Modal content for the Large example -->
    <div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Bulk Upload Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="#home" data-toggle="tab" aria-expanded="false" class="nav-link  ">
                                <p class="text-success"><b>Successful Upload</b>&emsp;<span
                                        class="badge badge-pill badge-success success_badge_display">Success</span></p>


                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#profile" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                <p class="text-danger"><b>Failed Upload</b> &emsp;<span
                                        class="badge badge-pill badge-danger failed_badge_display"></span></p>

                            </a>
                        </li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show" id="home">
                            <br>
                            <div class="table-responsive">
                                <table id="all_successful_uploads_table"
                                    class="table table-bordered table-striped dt-responsive nowrap w-100 all_successful_uploads_table"
                                    style="zoom: 0.9">
                                    <thead>
                                        <tr class="table-background">
                                            {{-- <th><b>Record ID</b></th> --}}
                                            <th><b>Name</b></th>
                                            <th><b>Account No.</b></th>
                                            <th><b>Amount</b></th>
                                            <th><b>Ref No.</b></th>
                                            <th><b>&emsp;&emsp;Description&emsp;&emsp;</b></th>
                                        </tr>
                                    </thead>
                                    <tbody class="successful_uploads">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane  active" id="profile">
                            <br>
                            <div class="table-responsive">
                                <table id="all_failed_uploads_table"
                                    class="table table-bordered table-striped dt-responsive nowrap w-100 all_failed_uploads_table"
                                    style="zoom: 0.9">
                                    <thead>
                                        <tr class="table-background">
                                            {{-- //<th><b>Record ID</b></th> --}}
                                            <th><b>Name</b></th>
                                            <th><b>Account No.</b></th>
                                            <th><b>Amount</b></th>
                                            <th><b>Ref No.</b></th>
                                            <th><b>&emsp;Description&emsp;</b></th>
                                            {{-- //<th><b>&emsp;Edit&emsp;</b></th> --}}
                                        </tr>
                                    </thead>
                                    <tbody class="failed_uploads">

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection


@section('scripts')
    @include('extras.datatables')
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script> --}}

    <script type="text/javascript" src="{{ asset('assets/js/pages/transfer/new_bulkTransfer.js') }}"></script>
    <script>
        let noDataAvailable = {!! json_encode($noDataAvailable) !!};
        let customer_no = @json(session('customerNumber'))

        function get_file_name(file_name, file_label) {
            console.log(file_name);
            console.log(file_label);
            $(`#${file_name}`).change(function() {
                // console.log("on chnge ==>", $(`#${file_name}`).val())

                var filename = $(`#${file_name}`)
                    .val()
                    .replace(/C:\\fakepath\\/i, "");
                console.log(filename);
                $(`#${file_label}`).empty().append(filename);
            });
        }
    </script>
@endsection
