@extends('layouts.master')


@section('styles')
    <style>
        .repayment .menu-arrow {
            transform: rotate(90deg);
            transition: transform 0.5s
        }

        .dataTables_info {
            font-size: 12px;
        }

        a.page-link {
            font-size: 12px;
        }

        .repayment[aria-expanded="true"] .menu-arrow {
            transform: rotate(270deg);
        }
    </style>
@endsection
@section('content')
    @php
        $currentPath = 'Loan Request';
        $basePath = 'Loans';
    $pageTitle = 'Loan Request'; @endphp
    @include('snippets.pageHeader')

    @include('snippets.pinCodeModal')

    <div class=" px-2">
        <div class="dashboard site-card overflow-hidden">
            <nav class="dashboard-header " data-title="Loan Tabs" data-intro="Click to view form">
                <div class="nav nav-tabs justify-content-center border-0" id="nav-tab" role="tablist">
                    <a id="Balance_Tab" class="nav-link w-100 text-center active" data-toggle="tab" href="#Balances_Pill"
                        style="max-width: 175px">BALANCES</a>
                    {{-- <a id="Request_Tab" class="nav-link w-100 text-center" data-toggle="tab" href="#Requests_Pill"
                        style="max-width: 175px">REQUEST</a> --}}
                    {{-- <a id="Tracking_Tab" class="nav-link w-100 text-center" data-toggle="tab" href="#Tracking_Pill"
                        style="max-width: 175px">TRACKING</a> --}}
                </div>
            </nav>
            <div class="tab-content dashboard-body border-danger borders" id="pills-tabContent">

                <div class="tab-pane show active " id="Balances_Pill" role="tab-panel" style="height: 100%">
                    <div id="loan_balances_no_data" class=" justify-content-center align-items-center"
                        style="display: flex;">
                        {!! $noDataAvailable !!}
                    </div>
                    <div id="loan_balances" class="table-responsive" style="display: none">
                        <table id="loan_balances_table"
                            class="table table-sm table-striped table-hover table-centered table-bordered">
                            <thead class="bg-info">
                                <tr class="table-background">
                                    <th>Loan Description</th>
                                    <th>Amount Granted</th>
                                    <th>Loan Balance</th>
                                    <th> View Details </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane  " id="Requests_Pill" role="tab-panel">
                    <div id="kyc_incomplete" class="mx-auto" style="max-width: 350px;  display:none">
                        <img class=" img-fluid" src="{{ asset('assets/images/placeholders/kyc.svg') }}" />
                        <span class="my-3 d-block text-white font-13 font-weight-bold p-2 rounded-lg"
                            style="background-color: rgb(0, 0, 0)"><i class="fas fa-exclamation-circle pr-2"></i>Your KYC
                            (Know Your Customer) is not Complete </span>
                        <a href="{{ url('kyc-update') }}"
                            class="text-dark font-14 float-right text-right font-weight-bold"><i class="far fa-edit"></i>
                            Update KYC</a>
                    </div>
                    <form action="#" id="payment_details_form" autocomplete="off" class="container"
                        style="max-width: 650px;">
                        @csrf
                        <div class="mb-3 form-group ">
                            <label class="text-dark mb-1 font-weight-bold font-12" for="loan_product">Select Loan
                                Product</label>
                            <select class="form-control" id="loan_product" required>
                                <option value="" disabled selected>Select Loan Product
                                </option>
                            </select>
                            <div class="card mt-1" style="border-radius: 2px">
                                <span href="#product_info_toggle" class="text-dark repayment" data-toggle="collapse">
                                    <div class=" d-flex justify-content-between pl-3 py-1 font-12 font-weight-bold">
                                        <span> Product Detail</span>
                                        <span class="menu-arrow"></span>
                                    </div>
                                </span>
                                <div class="collapse " id="product_info_toggle">
                                    <table id="loan_product_info"
                                        class="mb-0 table table-borderless table-striped table-sm">
                                        <tbody>
                                            <tr>
                                                <th class="col-5 font-12 pl-3  font-weight-normal">Amount Range</th>
                                                <td class="text-primary  font-13 font-weight-bold pr-3 text-right"
                                                    id="lpi_amount_range"></td>
                                            </tr>
                                            <tr>
                                                <th class="col-5 font-12 pl-3  font-weight-normal">Tenure</th>
                                                <td class="text-primary  font-13 font-weight-bold pr-3 text-right"
                                                    id="lpi_tenure"></td>
                                            </tr>
                                            <tr>
                                                <th class="col-5 font-12 pl-3  font-weight-normal">Interest Type</th>
                                                <td class="text-primary  font-13 font-weight-bold pr-3 text-right"
                                                    id="lpi_interest_type"></td>
                                            </tr>
                                            <tr>
                                                <th class="col-5 font-12 pl-3  font-weight-normal">Rate</th>
                                                <td class="text-primary  font-13 font-weight-bold pr-3 text-right"
                                                    id="lpi_rate"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 form-group ">

                            <label class="text-dark mb-1 font-weight-bold font-12" for="loan_amount">Enter Amount</label>
                            <div class="input-group">

                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="loan_currency">SLE</span>
                                </div>
                                <input type="number" placeholder="0.00" id="loan_amount" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3 form-group ">
                            <label class="text-dark mb-1 font-weight-bold font-12" for="principal_repay_frequency">Select
                                Principal Frequency Type</label>
                            <select class="form-control" id="principal_repay_frequency" required>
                                {{-- <option value="" disabled selected>Select Principal Frequency Type
                            </option> --}}
                            </select>
                        </div>
                        <div class="mb-3 form-group ">
                            <label class="text-dark mb-1 font-weight-bold font-12" for="interest_repay_frequency">Select
                                Interest
                                Frequency Type</label>
                            <select class="form-control" id="interest_repay_frequency" required>
                                {{-- <option value="" disabled selected>Select Interest Frequency Type
                            </option> --}}
                            </select>
                        </div>
                        <div class="mb-3 form-group  form-check">
                            <input type="checkbox" class="form-check-input" id="terms_checkbox">
                            <label class="text-dark mb-1 font-weight-bold font-12" class="form-check-label"
                                for="terms_checkbox">I
                                agree to the Terms and Conditions</label>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" id="loan_request_btn" class="btn form-button">Submit</button>
                        </div>

                    </form>
                </div>
                <div class="tab-pane " id="Tracking_Pill" role="tab-panel">
                    {{--  <p>Tracking</p>  --}}
                    <div id="loan_tracking_no_data" class=" justify-content-center align-items-center"
                        style="display: flex;">
                        {!! $noDataAvailable !!}
                    </div>
                    <div id="loan_tracking" class="table-responsive" style="display: none">
                        <table id="loan_tracking_table"
                            class="table nowrap display border dt-responsive table-hover rounded mb-0 ">
                            <thead>
                                <tr class="table-background">
                                    <th>Loan Description</th>
                                    <th>Amount Granted</th>
                                    <th>Loan Balance</th>
                                    <th> View Details </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- LOAN DETAIL MODAL -->
    <div id="loan_detail_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="transfer_status"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div id="loan_details_content" class="loan-details-content">
                    <div class="modal-header bg-danger">
                        <h3 class="modal-title modal-title font-18 font-weight-bold text-white"
                            id="transfer_status_title">
                            LOAN DETAILS</h3>
                        <button type="button" class="close text-white" data-dismiss="modal"
                            aria-hidden="true">x</button>
                    </div>


                    <div class="modal-body">
                        <div class="rounded-circle d-flex justify-content-center align-items-center mx-auto text-center bg-secondary"
                            style="height: 200px; width: 200px">
                            <div class="text-white ">
                                <span class="d-block font-14">Amount Outstanding</span>
                                <span class="d-block font-16"><span class="d-block font-16">SLE</span>0.00</span>

                            </div>
                        </div>
                        <div class="d-flex px-2 my-4 justify-content-between">
                            <button type="button" class="btn btn-outline-primary rounded shadow-lg"
                                id="advanced_payment">Advance Payment</button>
                            <button type="button" class="btn btn-outline-primary rounded shadow-lg"
                                id="view_loan_schedule">
                                View Schedule</button>
                        </div>

                        <h2 class="text-dark  font-16 font-weight-bold mb-2 text-center">LOAN </h2>

                        <table class="table table-borderless table-striped table-sm">
                            <tbody>
                                <tr>
                                    <th class="col-5 font-14 font-weight-normal">Principal Account</th>
                                    <td class="text-primary text-right" id="principal_account"></td>
                                </tr>

                                <tr>
                                    <th class="col-5 font-14 font-weight-normal">Principal in Areas</th>
                                    <td class="text-primary text-right" id="principal_in_areas"></td>
                                </tr>
                                <tr>
                                    <th class="col-5 font-14 font-weight-normal">Interest in Amount</th>
                                    <td class="text-primary text-right" id="interest_in_amount"></td>
                                </tr>
                                <tr>
                                    <th class="col-5 font-14 font-weight-normal">Accrued interest</th>
                                    <td class="text-primary text-right" id="accrued_interest"></td>
                                </tr>
                                <tr>
                                    <th class="col-5 font-14 font-weight-normal">Interest in Areas</th>
                                    <td class="text-primary text-right" id="interest_in_areas"></td>
                                </tr>
                                <tr>
                                    <th class="col-5 font-14 font-weight-normal">Pinal Accrued</th>
                                    <td class="text-primary text-right" id="pinal_accrued"></td>
                                </tr>
                                <tr>
                                    <th class="col-5 font-14 font-weight-normal">Last Repay Date</th>
                                    <td class="text-primary text-right" id="last_repay_date"></td>
                                </tr>
                                <tr>
                                    <th class="col-5 font-14 font-weight-normal">Next Review Date</th>
                                    <td class="text-primary text-right" id="next_review_date"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="loan_schedule_content" class="loan-details-content" style="display: none">
                    <div class="p-3 bg-danger">
                        <a id="loan_schedule_back_button" class="fas text-white fa-arrow-left inline-block"></a>
                        <h3 class="pb-2 text-center modal-title modal-title font-16 font-weight-bold text-white"
                            id="transfer_status_title"> LOAN SCHEDULE</h3>
                        <div class="px-2">
                            <div class="d-flex justify-content-between ">
                                <span class="font-12 text-primary">Facility No.</span>
                                <span class="font-weight-bold  text-white display_facility_number"></span>
                            </div>
                            <hr class="my-1">
                            <div class="d-flex justify-content-between text-white">
                                <div>
                                    <span class="d-block font-12 text-primary">Current Balance</span>
                                    <span class="d-block font-weight-bold ">SLE <span
                                            class="display_current_balance"></span></span>

                                </div>
                                <div>
                                    <span class="d-block font-12 text-right text-primary">Areas</span>
                                    <span class="d-block font-weight-bold text-right ">SLE <span
                                            class="display_current_areas"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="min-height: 50vh">
                        <div class="card m-2 shadow" style="border-radius: 2px">
                            <div class="display_loan_repayment_plan">
                                {{--  <a href="#s" class="repayment" >
                                    <div class="d-flex justify-content-between pl-3 py-2">
                                        <span> Repayment #1</span>
                                        <span class="menu-arrow"></span>
                                    </div>
                                </a>
                                <div class="collapse " id="s">
                                    <div class="d-flex border-top justify-content-between px-3 py-2">
                                        <span class="text-dark"> Interest Amount</span>
                                        <span class="text-info">SLL 09347538</span>
                                    </div>
                                    <div class="d-flex border-top justify-content-between px-3 py-2">
                                        <span class="text-dark"> Prncipal Amount</span>
                                        <span class="text-info">SLL 09347538</span>
                                    </div>
                                    <div class="d-flex border-top justify-content-between px-3 py-2">
                                        <span class="text-dark"> Installment Amount</span>
                                        <span class="text-info">SLL 09347538</span>
                                    </div>
                                    <div class="d-flex border-top justify-content-between px-3 py-2">
                                        <span class="text-dark"> Interest Paid</span>
                                        <span class="text-info">SLL 09347538</span>
                                    </div>
                                    <div class="d-flex border-top justify-content-between px-3 py-2">
                                        <span class="text-dark"> Principal Paid</span>
                                        <span class="text-info">SLL 09347538</span>
                                    </div>

                                </div>
                                <div class="bg-info">
                                    <div class="d-flex border-top justify-content-between px-3 py-2">
                                        <span class="text-dark"> Repayment Date</span>
                                        <span class="text-white">SLL 09347538</span>
                                    </div>
                                </div>  --}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

    <!-- LOAN DETAIL MODAL -->
    <div id="loan_quotation_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="transfer_status"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div id="loan_detail_info" class="pb-4" style="display:none;">
                    <div class="bg-primary mb-3 p-2 d-flex align-items-center ">
                        <a id="back_to_loan_quotation" href="#" class="fas mr-4 fa-arrow-left "
                            style=" color: #343a40;"></a>
                        <h2 class="d-block modal-title modal-title font-16" id="transfer_status_title">
                            LOAN SCHEDULE</h2>
                    </div>
                    <div class="px-4">
                        <label class="mt-2  mb-0 font-weight-bold font-12 text-primary"> Intro Source
                        </label>


                        <select class="form-control mb-2" id="loan_intro_source"
                            placeholder="Select Where You Heard About The Loan" required>
                            {{-- <option value="" disabled selected>Select Where You
                            Heard About The Loan</option> --}}
                        </select>

                        <label class="mt-2 mb-0 font-weight-bold font-12 text-primary">Loan Sector
                        </label>


                        <select class="form-control mb-2 " id="loan_sectors" placeholder="Select The Sector" required>
                            {{-- <option value="" disabled selected>Select the sector
                        </option> --}}
                        </select>

                        <label class="mt-2 mb-0 font-weight-bold font-12 text-primary">Sub Sector
                        </label>


                        <select class="form-control mb-2 " id="loan_sub_sectors" placeholder="Select The Sub Sector"
                            required disabled>
                            <option value="" disabled selected>Select the sub
                                sector</option>
                        </select>

                        <label class="mt-2 mb-0 font-weight-bold font-12 text-primary">
                            Purpose
                        </label>


                        <select class="form-control mb-2" id="loan_purpose" placeholder="Purpose of the loan" required>
                            {{-- <option value="" disabled selected>Purpose
                            of the loan
                        </option> --}}
                        </select>
                        <div class=" w-100 d-flex justify-content-end mt-3">
                            <button id="finalize_loan_button"
                                class="btn btn-primary btn-lg font-12 font-weight-bold rounded">Finalize Request</button>
                        </div>

                    </div>
                </div>
                <div id="loan_quotation_content" style="">
                    <div class="px-3 py-2 bg-primary">
                        <div class="d-flex align-items-center ">
                            {{-- <a class="fas mr-4 fa-arrow-left " style=" color: #343a40;"></a> --}}
                            <h2 class="d-block modal-title modal-title font-16" id="transfer_status_title">
                                LOAN SCHEDULE</h2>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-white mb-2 text-center font-weight-bold font-16  py-1"
                                style="border-bottom: 1px solid  #e5e9ec" id="ls_loan_product">LOAN PRODUCT
                            </h3>

                            <div class=" text-white">
                                <div class="d-flex justify-content-between">
                                    <span class="d-block font-13  " style="color: #e5e9ec">Amount</span>
                                    <span class="d-block font-weight-bold" id="ls_amount"></span>

                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="d-block font-13 " style="color:#e5e9ec">Tenure</span>
                                    <span class="d-block font-weight-bold text-right" id="ls_tenure"></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="d-block font-13 " style="color:#e5e9ec">Interest Type</span>
                                    <span class="d-block font-weight-bold text-right" id="ls_interest_type"></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="d-block font-13 " style="color:#e5e9ec">Principal Repay
                                        Frequency</span>
                                    <span class="d-block font-weight-bold text-right" id="ls_principal_repay_freq"></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="d-block font-13" style="color:#e5e9ec">Interest Repay
                                        Frequency</span>
                                    <span class="d-block font-weight-bold text-right" id="ls_interest_repay_freq"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div id="repayment_schedule">
                            <div class="d-flex justify-content-between px-1">
                                <h4 class="font-13"> Repayment Schedule</h4>
                                <h4 class="text-primary font-12 font-weight-bold" id="loan_rate">Rate: </h4>
                            </div>
                            <table id="loan_quotation_table"
                                class="font-12 table text-center table-borderless table-striped table-sm">
                                <thead class="bg-primary  text-white font-weight-bold">
                                    <tr class="text-center">
                                        <th>Principal</th>
                                        <th>Interest</th>
                                        <th>Total</th>
                                        <th>Due Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class=" w-100 d-flex justify-content-end mt-2">
                                <button id="request_loan_button"
                                    class="btn btn-primary font-12 font-weight-bold rounded">Request
                                    Loan</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.modal-content -->


    {{-- ================================================================ --}}

    {{-- <div class="card-body py-3 px-md-3">
    <div class="row">
        <div class="col-md-7 px-3">
            <div class="site-card h-100" id="request_form_div">
                <br>
                <div class="container">
                    <form action="#" class="select_beneficiary" id="payment_details_form" autocomplete="off"
                        aria-autocomplete="none">
                        @csrf
                        <div class="row px-md-4  justify-content-center">
                            <div class="col-md-12">

                                <div class="form-group row mb-3">
                                    <b class="col-4 align-self-center text-primary">Loan Product
                                    </b>


                                    <select class="form-control col-8 " id="loan_product" required>
                                        <option value="" disabled selected>Select Loan Product
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group row">

                                    <b class="col-4 align-self-center text-primary" for="loan_amount">
                                        Amount
                                    </b>

                                    <div class="px-0 col-2">
                                        <div class="input-group ">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text display_from_account_currency">
                                                    SLL</div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="text" class="form-control col-6" id="loan_amount"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">


                                </div>

                                <div class="form-group row">

                                    <b class="col-4 align-self-center text-primary" for="tenure_in_months">
                                        Tenure In Months
                                    </b>
                                    <input type="text" class="form-control col-8" id="tenure_in_months" required
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">


                                </div>


                                <div class="form-group row mb-3" id="pay_from_account">

                                    <b class="col-4 align-self-center text-primary">Interest Rate
                                        Type </b>

                                    <select class="form-control col-8" id="interest_rate_type" required>
                                        <option value="" disabled selected>Select Interest Rate Type
                                        </option>
                                    </select>

                                </div>



                                <div class="form-group row">

                                    <b class="col-4 align-self-center text-primary"> Principal
                                        Repayment
                                    </b>


                                    <select class="form-control col-8 loan_frequencies" id="principal_repay_freq"
                                        placeholder="Select Principal Repay Frequency" required>
                                        <option value="" disabled selected>Select Principal Repay
                                            Frequency</option>
                                    </select>

                                </div>

                                <div class="form-group row">

                                    <b class="col-4 align-self-center text-primary"> Interest
                                        Repayment
                                    </b>


                                    <select class="form-control col-8 loan_frequencies" id="interest_repay_freq"
                                        placeholder="Select Interest Repay
                                                            Frequency" required>


                                        <option value="" disabled selected>Select Interest Repay
                                            Frequency</option>
                                    </select>

                                </div>
                                <div class="form-group row loan-detail" style="display: none">

                                    <b class="col-4 align-self-center text-primary"> Intro Source
                                    </b>


                                    <select class="form-control col-8" id="loan_intro_source"
                                        placeholder="Select Where You Heard About The Loan" required>
                                        <option value="" disabled selected>Select Where You
                                            Heard About The Loan</option>
                                    </select>

                                </div>

                                <div class="form-group row loan-detail" style="display: none">

                                    <b class="col-4 align-self-center text-primary"> Sector
                                    </b>


                                    <select class="form-control col-8 " id="loan_sectors"
                                        placeholder="Select The Sector" required>
                                        <option value="" disabled selected>Select the sector
                                        </option>
                                    </select>

                                </div>
                                <div class="form-group row loan-sub-sectors-div" style="display: none">

                                    <b class="col-4 align-self-center text-primary">Sub Sector
                                    </b>


                                    <select class="form-control col-8 " id="loan_sub_sectors"
                                        placeholder="Select The Sub Sector" required>
                                        <option value="" disabled selected>Select the sub
                                            sector</option>
                                    </select>
                                    @include("snippets.loading")

                                </div>
                                <div class="form-group row loan-detail" style="display: none">

                                    <b class="col-4 align-self-center text-primary">
                                        Purpose
                                    </b>


                                    <select class="form-control col-8" id="loan_purpose"
                                        placeholder="Purpose of the loan" required>
                                        <option value="" disabled selected>Purpose
                                            of the
                                            loan
                                        </option>
                                    </select>

                                </div>
                                <div class="form-group row loan-detail" style="display: none">

                                    <b class="col-4 align-self-center text-primary">
                                        Product Branch
                                    </b>


                                    <select class="form-control col-8" id="product_branch"
                                        placeholder="Select pick up branch" required>
                                        <option value="" disabled selected>Select pick up branch
                                        </option>
                                    </select>
                                </div>
                                <br>
                                <div class="form-group text-right yes_beneficiary">
                                    <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light "
                                        id="btn_loan_request">
                                        <span class="submit-text">Proceed</span>
                                        <span class="spinner-border spinner-border-sm mr-1 spinner-load" role="status"
                                            id="spinner" aria-hidden="true" style="display: none"></span>
                                        <span class="spinner-load" id="spinner-text"
                                            style="display: none">Loading...</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <br><br><br>

                    </form>
                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-md-5 z-1 px-3">
            <div class="site-card h-100" id="atm_request_summary">
                <br>
                <span class="text-primary transfer-detail-header "> Loan Detail </span>
                <hr class="mt-0">
                <div class="row">

                    <p class="col-md-12 success-message"></p>
                    <p class="col-md-6 transfer-detail-text my-1">Loan Product:</p>
                    <p class="text-primary display_loan_product col-md-6"></p>
                    <p class="col-md-6 transfer-detail-text my-1">Amount(SLL):</p>
                    <p class="text-primary display_loan_amount col-md-6"></p>

                    <p class="col-md-6 transfer-detail-text my-1">Tenure In Months:</p>
                    <p class="text-primary display_tenure_in_months col-md-6"></p>

                    <p class="col-md-6 transfer-detail-text my-1">Interest Rate Type:</p>
                    <p class="text-primary display_interest_rate_type col-md-6"></p>

                    <p class="col-md-6 transfer-detail-text my-1">Principal Repay Frequency:</p>
                    <p class="text-primary display_principal_repay_freq col-md-6"></p>

                    <p class="col-md-6 transfer-detail-text my-1">Interest Repay Frequency:</p>
                    <p class="text-primary display_interest_repay_freq col-md-6"></p>
                    <p class="col-md-6 transfer-detail-text my-1 loan-detail" style="display: none">Intro Source:
                    </p>
                    <p class="text-primary loan-detail display_loan_intro_source col-md-6" style="display: none">
                    </p>
                    <p class="col-md-6 transfer-detail-text my-1 loan-detail" style="display: none">Sector:</p>
                    <p class="text-primary loan-detail display_loan_sectors col-md-6" style="display: none">
                    </p>
                    <p class="col-md-6 transfer-detail-text my-1 loan-sub-sectors-div" style="display: none">Sub
                        Sector:
                    </p>
                    <p class="text-primary loan-sub-sectors-div display_loan_sub_sectors col-md-6"
                        style="display: none">
                    </p>
                    <p class="col-md-6 transfer-detail-text my-1 loan-detail" style="display: none">Purpose:</p>
                    <p class="text-primary loan-detail display_loan_purpose col-md-6" style="display: none">
                    </p>
                    <p class="col-md-6 transfer-detail-text my-1 loan-detail" style="display: none">Product Branch:
                    </p>
                    <p class="text-primary loan-detail product-branch display_product_branch col-md-6"
                        style="display: none"></p>

                </div>

                <div class="form-group text-center display_button_print" style="display: none">

                    <span> <button class="btn btn-secondary btn-rounded" type="button" id="back_button"
                            onclick="window.location.reload()">Back</button> &nbsp; </span>
                    <span>&nbsp;
                        <span>&nbsp; <button class="btn btn-light btn-rounded hide_on_print" type="button"
                                id="print_receipt" onclick="window.print()">Print
                                Receipt
                            </button></span>
                </div>
            </div>
        </div>

    </div>
</div> --}}

    {{-- <div class="card" id="payment_schedule" style="display: none">
    <div class="show col-md-12" aria-labelledby="headingOne" data-parent="#accordion">
        <div class="card-body ">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-4 text-left">
                        <b class="text-primary font-20">Loan Payment Schedule</b>
                    </div>
                    <div class="form-group row">
                        <div class="col-8 offset-4 text-right">
                            <button type="submit" id="btn_proceed_to_loan"
                                class="btn  btn-primary btn-sm btn-rounded waves-effect waves-light ">
                                <b className="text-primary" style="font-size: 12px">Proceed To Request Loan
                                </b>
                            </button>

                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive p-2 table-striped table-bordered">
                <table class="table mb-0 loan_payment_schedule w-100">
                    <thead>
                        <tr class="bg-info text-white ">
                            <td> <b> NO </b> </td>
                            <td> <b> REPAYMENT DATE </b> </td>
                            <td> <b> PRINCIPAL REPAYMENT AMOUNT </b> </td>
                            <td> <b> INTEREST REPAYMENT AMOUNT </b> </td>
                            <td> <b> TOTAL REPAYMENT AMOUNT </b> </td>
                        </tr>
                    </thead>

                </table>
            </div>
            <!-- end table-responsive -->


        </div>
    </div>
</div> --}}
@endsection

@section('scripts')
    @include('extras.datatables')
    <script src="{{ asset('assets/js/pages/loans/loan-request.js') }}"></script>
    <script>
        let noDataAvailable = {!! json_encode($noDataAvailable) !!}
        const pageData = new Object()
        pageData.myLoans = @json(session()->get('customerLoans'));
    </script>
@endsection
