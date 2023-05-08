        {{--  @php
$isApp = true;
@endphp  --}}
        @extends('layouts.app')
        @section('styles')
            <style>
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
                    background-color: #dc3545 !important;
                    border-color: #dc3545 !important;
                    color: white !important;
                }
            </style>
        @endsection
        @section('content')
            @include('snippets.top_navbar', ['page_title' => 'ACCOUNT OPENING'])



            <div class="dashboard site-card container">

                <a href="{{ url()->previous() }}" type="button" class="btn position-absolute" style="left: 5px"><i
                        class="fe-arrow-left"></i>&nbsp;Go
                    Back</a>

                <h4 class="text-red  mb-0 text-center">Account Creation</h4>
                <div class=" dashboard-body p-4 row pt-md-5 mx-auto">
                    <nav id="card_services_tabs"
                        class="col-md-4  nav nav-pills align-items-between flex-column mx-auto mb-3 flex-row"
                        style="max-width: 350px" role="tablist">
                        <span class="font-weight-bold font-14 text-center mb-2">Select Account Type: </span>
                        <button data-toggle="pill"
                            class=" transition-all py-md-2 active   font-weight-bold mb-2 bg-white rounded-pill border text-danger border-danger knav nav-link"
                            href="#tab_card_request">SAVINGS ACCOUNTS</button>
                        <button data-toggle="pill"
                            class=" transition-all py-md-2   font-weight-bold bg-white rounded-pill border text-danger border-danger knav nav-link "
                            href="#tab_block_card">CURRENT ACCOUNTS</button>
                    </nav>
                    <div class="col-md-8 px-0 mr-auto" style="max-width: 800px">
                        <div class="tab-content pt-0" id="tabContent_card_services">
                            <div class="tab-pane fade show active " id="tab_card_request" role="tabpanel">
                                <div class=" row">
                                    <div class="col-md-1"></div>
                                    <div class=" col-md-10 savings_product_list  row">
                                    </div>
                                    <div class="col-md-1"></div>

                                </div>

                            </div>
                            <div class="tab-pane fade" id="tab_block_card" role="tabpanel">
                                <div class="current_product_list row ">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        @endsection


        @section('scripts')
            <script src="{{ asset('assets/js/pages/accountCreation.js') }}"></script>
        @endsection
