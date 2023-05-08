@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/pagination/pagination.css') }}" />
    <style>
        .nodata {
            text-align: center !important
        }

        #no_data_available_img {
            max-width: 150px !important;
        }

        #cheque_book_request.active {
            background-color: #dc3545 !important;
            border-color: var(--gray) !important;
            color: white !important;
        }


        #block_cheque.active {
            color: white !important;
            background-color: #dc3545 !important;
            border-color: var(--gray) !important;
        }
    </style>
@endsection
@section('content')
    @php
        $pageTitle = 'Cheque Services';
        $basePath = 'Account Services';
        $currentPath = 'Cheque Services';
    @endphp
    @include('snippets.pageHeader')

    <div class=" dashboard site-card">
        <div class=" dashboard-body mb-1 p-3 row py-4 mx-auto" style="max-width: 80rem">
            <div class="col-lg-4">
                <label class="mb-2 d-block f-18 text-center font-weight-bold text-dark">Select Request
                    Type</label>
                <nav id="cheque_services_tabs" class="col-md-4  nav nav-pills flex-column mx-auto mb-3 flex-row"
                    style="max-width: 350px" role="tablist">
                    <button id="cheque_book_request" data-toggle="pill"
                        class=" transition-all py-md-2 active  text-sm-center mb-1 mb-md-2  mx-2 font-weight-bold bg-white rounded-pill border text-dark border-gray knav-primary nav-link"
                        href="#tab_cheque_book_request">Cheque Book Request</button>
                    <button data-toggle="pill"
                        class=" transition-all py-md-2  text-sm-center mb-1 mb-md-2  mx-2 font-weight-bold bg-white rounded-pill border text-dark border-gray knav nav-link "
                        id="block_cheque" href="#tab_block_cheque">Stop Cheque</button>
                    {{--  <button data-toggle="pill"
                        class=" transition-all coming-soon py-md-2  text-sm-center mb-1 mb-md-2  mx-2 font-weight-bold bg-white rounded-pill border text-dark border-gray knav nav-link "
                        id="block_cheque" href="#tab_confirm_cheque">Confirm A Cheque</button>  --}}

                </nav>
                <hr>
            </div>
            {{-- <div class=" form-group mb-3 justify-content-center d-md-flex mx-md-auto"
                style="max-width: 750px; min-height: 70px;">
            </div> --}}
            <div class="col-lg-8  card_request_form" style="max-width: 50rem; border-radius: 5px; padding:10px;">
                <div class=" align-self-center" style="min-width: 100px">
                    <label class="d-block f-18 font-weight-bold mb-1 text-dark">Select Account</label>
                </div>

                <select class="form-control  accounts-select" id="from_account" required>
                    <option disabled selected value="">Select
                        Account Number</option>
                    @include('snippets.accounts')
                </select>
                <hr class="">
                <div class="col-md-8 px-0" style="max-width: 650px;">
                    <div class="tab-content pt-0" id="tabContent_cheque_services">
                        <div class="tab-pane fade show active bg-white" id="tab_cheque_book_request" role="tabpanel">
                            @include('pages.accountServices.chequeServices.cheque_book_request')</div>
                        <div class="tab-pane fade bg-white" id="tab_block_cheque" role="tabpanel">
                            @include('pages.accountServices.chequeServices.block_cheque')
                        </div>
                        <div class="tab-pane fade" id="tab_confirm_cheque" role="tabpanel">...
                            {{--  @include('pages.accountServices.chequeServices.block_cheque')  --}}
                        </div>
                        {{--  tab_confirm_cheque  --}}

                    </div>
                </div>
            </div>

        </div>
    </div>
    @include('snippets.pinCodeModal')
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/pages/accountServices/chequeServices.js') }}"></script>
    <script src="{{ asset('assets/js/functions/comingSoon.js') }}"></script>
@endsection
