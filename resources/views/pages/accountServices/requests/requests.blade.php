@extends('layouts.master')
@section('styles')
    <style>
        .knav.active {
            margin-left: 0 !important;
            margin-right: 0 !important;
            box-shadow: rgba(0, 0, 0, 0.2) 0px 20px 30px;
            /* box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1); */
        }

        #request_statement.active {
            background-color: #dc3545 !important;
            border-color: var(--gray) !important;
            color: white !important;
        }


        #request_letter.active {
            color: white !important;
            background-color: #dc3545 !important;
            border-color: var(--gray) !important;
        }

        #request_bank_draft.active {
            background-color: #dc3545 !important;
            border-color: var(--gray) !important;
            color: white !important;
        }

        .date-select {
            height: 100%;
            max-width: 100px;
            border-radius: 0;
            border: none;
            background-color: transparent;
            color: #dc3545;
            font-weight: 500;
            font-size: 6px;
            border: 1px solid var(--gray);
            border-radius: 33px;
            padding: 0.5rem 1rem;
            outline: none;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .date-select:hover {
            /* background-color: var(--info); */
            /* color: white; */
            /* transition: all 0.3s ease-in-out; */
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        .date-select.selected {
            background-color: #dc3545;
            color: white;
        }

        .date-select:disabled {
            background: #eef0f2 !important;
            color: var(--secondary) !important;
            border-color: var(--gray) !important;
        }

        .date-select:disabled:hover {
            box-shadow: none !important;
        }
    </style>
@endsection
@section('content')
    @php
        $pageTitle = 'Requests';
        $basePath = 'Account Services';
        $currentPath = 'Requests';
    @endphp
    @include('snippets.pageHeader')

    <div class="dashboard site-card">
        <div class=" dashboard-body  mb-1 p-3 row py-4 mx-auto" style="max-width: 80rem">
            <div class="col-lg-4">
                <label class="mb-2 d-block f-18 text-center font-weight-bold text-dark">Select Request
                    Type</label>
                <nav id="requests_tabs" class="col-md-4  nav nav-pills flex-column mx-auto mb-3 flex-row"
                    style="max-width: 350px" role="tablist">
                    <button id="request_statement" data-toggle="pill"
                        class=" transition-all py-md-2 active  text-sm-center mb-1 mb-md-2  mx-2 font-weight-bold bg-white rounded-pill border text-dark border-gray knav nav-link"
                        href="#tab_request_statement">Statement Request</button>
                    {{-- <button
                        class=" transition-all coming-soon py-md-2  text-sm-center mb-1 mb-md-2  mx-2 font-weight-bold bg-white rounded-pill border text-dark border-gray knav nav-link "
                        id="request_letter" href="#tab_request_letter">Request For Letter</button> --}}

                    {{-- <button id="request_bank_draft"
                        class="  transition-all coming-soon py-md-2 text-sm-center mb-1  mb-md-2 mx-2 font-weight-bold bg-white rounded-pill border text-dark border-gray knav nav-link"
                        href="#tab_request_bank_draft">Request Bank Draft</button> --}}

                </nav>
                <hr>
            </div>
            <div class=" col-lg-8 px-0" style="max-width: 650px">

                <div class=" align-self-center" style="min-width: 100px"> <label
                        class="d-block f-18 font-weight-bold mb-1 text-dark">
                        Select
                        Account</label></div>

                <select class="form-control unredeemed accounts-select" id="from_account" required>
                    <option disabled selected value="">Select
                        Account Number</option>
                    @include('snippets.accounts')
                </select>

                <hr>

                <div class="tab-content pt-0" id="tabContent_requests">
                    <div class="tab-pane fade card show active" id="tab_request_statement" role="tabpanel">
                        @include('pages.accountServices.requests.statement_request')</div>
                    <div class="tab-pane fade card" id="tab_request_letter" role="tabpanel">
                        @include('pages.cards.block_card')

                    </div>
                    <div class="tab-pane fade" id="tab_request_bank_draft" role="tabpanel">...b</div>
                    <div class="tab-pane fade" id="tab_card_limit" role="tabpanel">.x..</div>
                </div>
            </div>
            {{-- <div class="container row pt-md-4 mx-auto">

                <div class="col-md-8 mx-auto px-0" style="max-width: 650px;">

                </div>
            </div> --}}
        </div>
    </div>
    @include('snippets.pinCodeModal')
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/pages/accountServices/requests/requests.js') }}"></script>
    <script src="{{ asset('assets/js/functions/comingSoon.js') }}"></script>
@endsection
