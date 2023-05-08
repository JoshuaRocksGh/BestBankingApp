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
    @include('snippets.top_navbar', ['page_title' => 'LOCATOR'])




    <div class="dashboard site-card container">

        <a href="{{ url()->previous() }}" type="button" class="btn position-absolute" style="left: 5px"><i
                class="fe-arrow-left"></i>&nbsp;Go
            Back</a>

        <h4 class="text-red  mb-0 text-center">Branch, ATM, Agent Locator</h4>
        <div class=" dashboard-body p-4 row pt-md-5 mx-auto">
            <nav id="card_services_tabs" class="col-md-4  nav nav-pills align-items-between flex-column mx-auto mb-3 flex-row"
                style="max-width: 350px" role="tablist">
                <span class="font-weight-bold font-14 text-center mb-2">Select: </span>
                <button data-toggle="pill"
                    class=" transition-all py-md-2 active   font-weight-bold mb-2 bg-white rounded-pill border text-dark border-gray knav nav-link"
                    href="#tab_card_request">Branch</button>
                <button data-toggle="pill"
                    class=" transition-all py-md-2   font-weight-bold  mb-2 bg-white rounded-pill border text-dark border-gray knav nav-link "
                    href="#tab_block_card">ATM</button>
                <button data-toggle="pill"
                    class=" transition-all py-md-2   font-weight-bold  mb-2 bg-white rounded-pill border text-dark border-gray knav nav-link "
                    href="#tab_block_card">Agent</button>
            </nav>
            <div class="col-md-8 px-0 mr-auto" style="max-width: 800px">
                <div class="tab-content pt-0" id="tabContent_card_services">
                    <div class="tab-pane fade show active " id="tab_card_request" role="tabpanel">
                        <div class="savings_product_list row">

                            @foreach ($Branches as $branch)
                                <div class="col-md-4 p-2">
                                    <div class="card" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
                                        <div class="card-body p-2">
                                            <img class="text-dark" src="{{ asset('assets/images/bank.png') }}"
                                                align="left" width="40px" height="40px" />
                                            <div align="right">
                                                <h3 class="p-0">{{ $branch['branchDescription'] }}</h3>
                                                <small class="p-0">08:00 - 16:00 (Mon - Fri)</small> <br>
                                                <small class=" p-0"><i
                                                        class="mr-1 fas fa-phone text-danger"></i>23350997763</small>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab_block_card" role="tabpanel">
                        <div class="current_product_list row ">
                            <div class="col-md-4 p-2">
                                <div class="card" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
                                    <div class="card-body p-2">
                                        <img src="{{ asset('assets/images/atm.png') }}" align="left" width="40px"
                                            height="40px" />
                                        <div align="right">
                                            <h3 class="p-0">BO</h3>
                                            <small class="p-0">24 Hrs (Mon - Sun)</small> <br>
                                            {{--  <small class=" p-0"><i
                                                    class="mr-1 fas fa-phone text-danger"></i>23350997763</small>  --}}
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
    <!-- end row -->
@endsection





@section('scripts')
    <script>
        $("#branches_info_display").hide();
        $("#branches_info_retry_btn").hide();

        function get_branches() {
            $.ajax({
                type: 'GET',
                url: 'get-branches-api',
                datatype: "application/json",
                success: function(response) {
                    console.log(response.data);
                    let data = response.data

                    if (response.responseCode == '000') {

                        let data = response.data;


                        $.each(data, function(index) {
                            $('#branches_display').append(`

                            <div class="d-flex shadow w-100 bg-white rounded p-2">
                                <div class="px-2 align-self-center"><i
                                        class="fas text-primary fa-building font-28"></i></i>
                                </div>
                                <div class="pl-2 w-100 ">
                                    <div class="pl-2 my-1">
                                        <div class="flex justify-content-between"><span
                                                class="d-block  font-weight-bold" style="color:#222222">ADABRAKA
                                                BRANCH</span><i class="fa-solid fa-ellipsis-vertical"></i></div>
                                        <span class="d-block   font-11">08:00 - 16:00<span class="pl-2">Mon - Fri
                                            </span></span>
                                        <span class="d-block  font-11">10:00 - 14:00<span
                                                class="pl-2">Weekends</span></span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <a href="tel:024 897 6789"
                                            class="d-block bg-muted px-2 mr-3 py-1 font-12 rounded-pill "><i
                                                class="fas pr-1 text-primary fa-phone"></i> 024 897 6789</a>
                                        <a href="mailto:info@rokel.cc"
                                            class="d-block bg-muted px-2 p-1 font-12 rounded-pill "><i
                                                class="fas pr-1 text-primary fa-envelope"></i>info@rokel.cc</a>
                                    </div>
                                </div>
                            </div>

                    `)


                        });



                        $("#branches_info_loader").hide();
                        $("#branches_info_retry_btn").hide();
                        $("#branches_info_display").show();


                    } else {
                        $("#branches_info_loader").hide();
                        $("#branches_info_display").hide();
                        $("#branches_info_retry_btn").show();
                    }


                },
                error: function(xhr, status, error) {

                    setTimeout(function() {
                        get_branches()
                    }, $.ajaxSetup().retryAfter)
                }

            })
        };

        $(document).ready(function() {

            setTimeout(function() {
                {{--  get_branches();  --}}
            }, 2000);
        })
    </script>
@endsection
