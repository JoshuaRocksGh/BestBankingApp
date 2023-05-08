@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/pagination/pagination.css') }}" />
    <style>
        .history-card {
            cursor: pointer;

            box-shadow: rgba(0, 0, 0, 0.08) 0px 4px 12px;
            /* box-shadow: rgba(0, 0, 0, 0.2) 0px 20px 30px; */
            /* box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px; */
        }

        .history-card:hover {
            margin-left: 0 !important;
            margin-right: 0 !important;
            box-shadow: rgba(17, 12, 46, 0.15) 0px 48px 100px 0px;
        }

        .nodata {
            text-align: center !important
        }

        #no_data_available_img {
            max-width: 150px !important;
        }

        .knav.active {
            margin-left: 0 !important;
            margin-right: 0 !important;
            box-shadow: rgba(0, 0, 0, 0.2) 0px 20px 30px;
            /* box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1); */
        }

        #card_request.active {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
            color: white !important;
        }


        #block_card.active {
            color: white !important;
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
        }

        #activate_card.active {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
            color: white !important;
        }

        #card_limits.active {
            background-color: var(--yellow) !important;
            color: white !important;
            border-color: var(--yellow) !important;
        }
    </style>
@endsection
@section('content')
    @php
        $pageTitle = 'Card Services';
        $basePath = 'Card Services';
        $currentPath = 'Card Services';
    @endphp
    @include('snippets.pageHeader')

    <div class="dashboard site-card">
        <div class="dashboard-body mb-1 p-3 row py-4 mx-auto" style="max-width: 80rem">
            <div class="col-lg-4">
                <label class="mb-2 d-block f-18 text-center font-weight-bold text-dark">Select Request Type
                </label>

                <nav id="card_services_tabs" class="col-md-4  nav nav-pills flex-column mx-auto mb-3 flex-row"
                    style="max-width: 350px" role="tablist">
                    <button id="card_request" data-toggle="pill" data-value="unredeemed"
                        class=" transition-all py-md-2 active  text-sm-center mb-1 mb-md-2  mx-2 font-weight-bold bg-white rounded-pill border text-dark border-gray knav nav-link"
                        href="#tab_card_request">Card Request</button>
                    <button data-value="redeemed" data-toggle="pill"
                        class=" transition-all py-md-2  text-sm-center mb-1 mb-md-2  mx-2 font-weight-bold bg-white rounded-pill border text-dark border-gray knav nav-link "
                        id="block_card" href="#tab_block_card">Block Card</button>

                    <button id="activate_card" data-toggle="pill"
                        class="  transition-all py-md-2 text-sm-center mb-1  mb-md-2 mx-2 font-weight-bold bg-white rounded-pill border text-dark border-gray knav nav-link"
                        href="#tab_activate_card">Activate Card</button>
                    {{--  <button id="card_limits"
                        class="  transition-all coming-soon py-md-2 text-sm-center mb-1  mb-md-2 mx-2 font-weight-bold bg-white rounded-pill border text-dark border-gray knav nav-link"
                        href="#tab_card_limit">Card Limits</button>  --}}
                    {{--  <button id="card_limits"
                        class="  transition-all coming-soon py-md-2 text-sm-center mb-1  mb-md-2 mx-2 font-weight-bold bg-white rounded-pill border text-dark border-gray knav nav-link"
                        href="#tab_card_limit">Change Card Pin</button>  --}}
                    {{--  <button id="card_limits"
                        class="  transition-all coming-soon py-md-2 text-sm-center mb-1  mb-md-2 mx-2 font-weight-bold bg-white rounded-pill border text-dark border-gray knav nav-link"
                        href="#tab_card_limit">Report Stolen Card</button>  --}}
                </nav>
                <hr>
            </div>
            {{--  =======  --}}
            <div class="col-lg-8" style="max-width: 50rem">
                <div class=" align-self-center" style="min-width: 100px"> <label
                        class="d-block f-18 font-weight-bold mb-1 text-dark">
                        Select
                        Account</label></div>


                <select class="form-control unredeemed accounts-select" id="from_account" required>
                    <option disabled selected value="">Select
                        Account Number</option>
                    @include('snippets.accounts')
                </select>
                <hr class="">


                <div class="col-md-8 px-0" style="max-width: 650px;">
                    <div class="tab-content pt-0" id="tabContent_card_services">
                        <div class="tab-pane fade show active bg-white" id="tab_card_request" role="tabpanel">
                            @include('pages.cards.card_request')
                        </div>
                        <div class="tab-pane fade bg-white" id="tab_block_card" role="tabpanel">
                            @include('pages.cards.block_card')

                        </div>
                        <div class="tab-pane fade bg-white" id="tab_activate_card" role="tabpanel">
                            @include('pages.cards.activate_card')
                        </div>
                        <div class="tab-pane fade" id="tab_card_limit" role="tabpanel">.x..</div>
                    </div>
                </div>

            </div>


        </div>
    </div>
    @include('snippets.pinCodeModal')
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/pages/cardServices/cardServices.js') }}"></script>
    <script src="{{ asset('assets/js/functions/comingSoon.js') }}"></script>
@endsection
