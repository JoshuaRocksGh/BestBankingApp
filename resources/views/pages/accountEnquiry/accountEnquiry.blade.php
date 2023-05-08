@extends('layouts.master')
@section('styles')
    <style>
        @media print {
            .hide_on_print {
                display: none
            }
        }

        .table_over_flow {
            overflow-y: hidden;

        }

        .dt-buttons {
            display: none;
        }

        .dataTables_filter {
            padding: 2px 10px;
            background-color: #e2e3e5;
        }

        .dataTables_info {
            padding: 2px 10px;

        }

        .pagination {
            padding: 2px 10px;
        }

        table.dataTable#account_transaction_display_table {
            margin-top: 0px !important;
        }
    </style>

    @include('extras.datatables')
@endsection

@section('content')
    @php
        $currentPath = 'Transactions Enquiry';
        $basePath = 'Account';
        $pageTitle = 'Transactions Enquiry';
    @endphp
    @include('snippets.pageHeader')

    <div class=" dashboard site-card" id="transaction_form">
        <div class="dashboard-body p-4" style="min-height: 0px;" data-title="Transaction Enquiry"
            data-intro="Complete the following fields and click search">
            <div class="d-flex align-items-center justify-content-around">
                <div class="w-100" style="max-width: 600px">
                    <div class="form-group  ">
                        <label class=" text-dark align-self-center"> Select Account :</label>
                        <select class="form-control accounts-select " id="from_account" required>
                            @include('snippets.accounts')
                        </select>
                    </div>

                    <div class="form-group d-flex justify-content-around align-items-end">
                        <div class=" pr-4 w-100">
                            <label class="  text-dark align-self-center">Start Date :</label>
                            <input type="date" id="startDate" class=" text-input  form-control ">
                        </div>
                        <div class=" pr-0 w-100">
                            <label class=" text-dark align-self-center">End Date :</label>
                            <input type="date" id="endDate" class="text-input  form-control ">
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn  mt-1 waves-effect waves-light form-button"
                            id="search_transaction">Search</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-content dashboard-body border-danger border" id="transaction_summary" style="min-height: 0px;">



            {{-- <div class="dashboard-body p-4"> --}}
            <div class="accordion-arrow  p-3 rounded alert-secondary w-100" id="account_balance_info_display"
                role="alert">
                <div class="row">

                    <div class="col-3 ">
                        <select class="form-control col-md-8" id="filter" required>

                            <option value="all" selected> ALL</option>
                            <option value="credit"> CREDIT </option>
                            <option value="debit"> DEBIT </option>
                        </select>
                    </div>
                    <div class="col-6"></div>

                    <div class="col-3" data-title="Downloadable Format"
                        data-intro="Click to download in excel or pdf format">
                        <span style="float: right">
                            &nbsp;&nbsp;
                            <a id="pdf_print" style="display: none" class="download"
                                href="{{ url('print-account-statement') }}">
                                <img src="{{ asset('assets/images/pdf.png') }}" alt=""
                                    style="width: 22px; height: 25px;">
                            </a>
                            &nbsp;&nbsp;&nbsp;
                        </span>
                        <span style="float: right">
                            <a id="excel_print" style="display: none" class="download"
                                href="{{ url('print-account-statement') }}">
                                <img src="{{ asset('assets/images/excel.png') }}" alt=""
                                    style="width: 22px; height: 25px;">
                            </a>
                        </span>
                    </div>

                </div><br>
                {{--  <div class="row">
                    <div class="col-md-5">
                        <span>Start Date:<p>12/12/2022</p></span>
                        <span>Opening Balance:<p>SLE 14,000</p></span>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-5"></div>
                </div>  --}}
            </div>
            <div class="table-responsive mb-0  rounded ">

                <table role="table" class="table mb-0  font-12  w-100 table-bordered table-striped table-centered"
                    id="account_transaction_display_table" style="">

                    <thead>

                        <tr class="table-background ">
                            <th class="all">Date</th>
                            <th class="all">Purpose of Transfer <span class="account_currency_display_"></span> </th>
                            <th class="all">Document Reference</th>

                            <th class="all">Debit <span class="currency_display"></span></th>
                            <th class="all">Credit <span class="currency_display"></span></th>
                            {{-- <th class="all">Purpose of Transfer <span class="account_currency_display_"></span> </th> --}}


                            <th class="all">Balance<span class="currency_display"></span>
                            </th>
                            <th class="all">Details</th>
                            {{-- <th class="none">Attachment</th> --}}
                            {{--  <th class="none">Details</th>  --}}
                        </tr>




                    </thead>

                    <tbody role="rowgroup" id="table_body_display">
                        {{-- <tr id="display_all_transactions">

                        </tr> --}}
                        <td colspan="100%" class="text-center">
                            {!! $noDataAvailable !!}
                        </td>
                    </tbody>
                </table>
            </div>
            {{--
        </div> --}}
        </div>
    </div>



    <div id="accordion-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content p-0">
                <div id="accordion">
                    <div class="card mb-0">
                        <div class="card-header bg-danger" id="headingOne">
                            <h5 class="m-0">
                                <a href="#collapseOne" class="text-white" data-toggle="collapse" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <b>Transaction Details</b>
                                </a>
                                <button type="button" class="close text-white" data-dismiss="modal"
                                    aria-hidden="true">X</button>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                            data-parent="#accordion">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">

                                        <tbody>
                                            <tr>
                                                <th scope="row">Transaction Date</th>
                                                <td class="text-primary transaction_date"></td>

                                            </tr>
                                            <tr>
                                                <th scope="row">Value Date</th>
                                                <td class="text-primary value_date"></td>

                                            </tr>
                                            <tr>
                                                <th scope="row">Transaction No.</th>
                                                <td class="text-primary transaction_number"></td>

                                            </tr>
                                            <tr>
                                                <th scope="row">Narration</th>
                                                <td class="text-primary narration"></td>

                                            </tr>
                                            <tr>
                                                <th scope="row">Amount</th>
                                                <td class="text-primary amount"></td>

                                            </tr>

                                            <tr>
                                                <th scope="row">Contra Account</th>
                                                <td class="text-primary contra-account"></td>

                                            </tr>
                                            <tr>
                                                <th scope="row">Branch</th>
                                                <td class="text-primary branch"></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Channel</th>
                                                <td class="text-primary channel"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="attachment_modal" tabindex="-1" role="dialog"
        aria-labelledby="attachment_modal_title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-white font-weight-bold" id="attachment_modal_title">Attachments</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="attachment_carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                        </ol>
                        <div class="carousel-inner">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('extras.datatables')
    <script defer>
        const PageData = new Object();
        PageData.reqAccount = @json($accountNumber);
        let noDataAvailable = {!! json_encode($noDataAvailable) !!}
    </script>
    <script src="{{ asset('assets/js/pages/accounts/accountEnquiry.js') }}"></script>
@endsection
