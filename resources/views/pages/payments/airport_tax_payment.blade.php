@extends('layouts.master')
@section('content')
    @php
        $pageTitle = 'AIRPORT TAX';
        $basePath = 'Payments';
        $currentPath = 'Airport Tax';
    @endphp
    @include('snippets.pageHeader')
    @include('snippets.pinCodeModal')
    <div class="px-2">
        <div class="dashboard site-card overflow-hidden">
            <div class="tab-content dashboard-body p-4">
                <div class="mx-auto  h-100 " style="max-width: 650px" id="airport_tax_payment">
                    <div class="col-12 row display_airport_tax_amount">

                        {{--  <div class="form-group align-items-center  bg-light p-2 col-md-5" style="border-radius: 5px">

                            <h3 class="text-center font-weight-bold">SLE: 400.00</h3>

                        </div>
                        <div class="col-md-2"></div>
                        <div class="form-group align-items-center bg-light p-2 col-md-5" style="border-radius: 5px">

                            <h3 class="text-center font-weight-bold">USD: 25.00</h3>



                        </div>  --}}

                    </div>
                    <hr class="my-3" style="padding-top: 0px;marign-top: -5px; padding-bottom: 0px;">
                    <form action="#" autocomplete="off" aria-autocomplete="none" id="airport_tax_form">
                        <div class="form-group row ">
                            <b class="col-md-12 text-dark">Account to
                                transfer from &nbsp;
                                <span class="text-danger">*</span> </b>


                            <select class="form-control col-md-12 accounts-select" id="account_of_transfer" required>
                                <option disabled selected value=""> ---
                                    Select Source Account ---
                                </option>
                                @include('snippets.accounts')
                            </select>
                        </div>
                        <hr style="padding-top: 0px; padding-bottom: 0px;">
                        {{--    --}}
                        <div class="form-group row mb-3">

                            <b class="col-md-4 text-dark">Amount&nbsp;
                                <span class="text-danger">*</span></b>


                            <div class="input-group mb-1 col-md-8" style="padding: 0px;">
                                <div class="input-group-prepend">
                                    <input type="text" value="SLE" class="input-group-text display_currency"
                                        id="select_currency" style="width: 80px;" readonly>
                                </div>

                                &nbsp;
                                <input class="form-control  text-input key_transfer_amount font-weight-bold" type="text"
                                    disabled>
                                &nbsp;


                                {{--  <input type="text" class="form-control " id="amount"
                                    placeholder="Enter Amount To Transfer"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                    required>  --}}
                            </div>



                        </div>


                        {{--    --}}
                        <div class="form-group row">

                            <b class="col-md-4 text-dark"> Passport Number

                                &nbsp; <span class="text-danger">*</span></b>


                            <input type="text" class="form-control col-md-8 " id="passport_number"
                                placeholder="Enter Passport Number" autocomplete="off" required>
                            <br>

                        </div>

                        {{--    --}}
                        <div class="form-group row">

                            <b class="col-md-4 text-dark"> Flight Number
                                &nbsp; <span class="text-danger">*</span></b>


                            <input type="text" class="form-control col-md-8 " id="flight_number"
                                placeholder="Enter Flight Number" autocomplete="off" required>
                            <br>

                        </div>
                        {{--    --}}

                        <div class="form-group row">

                            <b class="col-md-4 text-dark"> Flight Date
                                &nbsp; <span class="text-danger">*</span></b>


                            <input type="date" class="form-control col-md-8 " id="flight_date"
                                placeholder="Enter Beneficiary Name" autocomplete="off" required>
                            <br>

                        </div>

                        <div class="form-group text-right mt-2">
                            <button type="button"
                                class="btn  btn-rounded waves-effect waves-light disappear-after-success form-button"
                                id="confirm_next_button">
                                <span class="submit-text">&nbsp; Next
                                    &nbsp;<i class="fe-arrow-right"></i></span>

                            </button>
                        </div>
                    </form>

                </div>


                <div class="" id="transaction_summary" style="display:none">

                    <div class="table-responsive p-4 mx-auto table_over_flow" style="max-width: 650px">
                        <table class="table mb-0 table-striped p-4 mx-auto">

                            <tbody>
                                {{--  <tr class="success_gif show-on-success" style="display: none">
                                    <td class="text-center bg-white" colspan="2">
                                        <img src="{{ asset('land_asset/images/statement_success.gif') }}"
                                            style="zoom: 0.5" alt="">
                                    </td>
                                </tr>
                                <tr class="show-on-success" style="display: none">
                                    <td class="text-center bg-white" colspan="2">
                                        <span class="text-success font-13 text-bold " id="success-message"></span>
                                    </td>
                                </tr>  --}}

                                <tr>
                                    <td>Sender Details:</td>
                                    <td>
                                        <span class="d-block font-13 text-primary h3 display_from_account_name"
                                            id="display_from_account_name"> </span>
                                        <span class="d-block font-13 text-primary h3 display_from_account_no"
                                            id="display_from_account_no"></span>
                                        <span class="font-13 text-primary h3 account_currency"
                                            id="display_from_account_currency">
                                        </span>
                                        &nbsp;
                                        <span class="font-13 text-primary h3 display_from_account_balance"
                                            id="display_from_account_balance"></span>
                                    </td>
                                </tr>
                                {{--  <tr>
                                    <td>Beneficiary Details:</td>
                                    <td>
                                        <span class="d-block font-13 text-primary h3 display_beneficiary_name"
                                            id="display_beneficiary_name"> </span>
                                        <span class="d-block font-13 text-primary h3 display_beneficiary_address"
                                            id="display_beneficiary_address"> </span>
                                    </td>
                                </tr>  --}}


                                <tr>
                                    <td>Amount:</td>
                                    <td>
                                        <span class="font-13 text-success h3 account_currency" id="display_currency">
                                        </span>
                                        &nbsp;
                                        <span class="font-13 text-success h3 display_transfer_amount"
                                            id="display_transfer_amount"></span>

                                    </td>
                                </tr>


                                <tr>
                                    <td>Passport Number:</td>
                                    <td>
                                        <span class="font-13 text-primary h3 display_passport_number"
                                            id="display_passport_number"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Flight Number:</td>
                                    <td>
                                        <span class="font-13 text-primary h3 display_flight_number"
                                            id="display_flight_number"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Flight Date:</td>
                                    <td>
                                        <span class="font-13 text-primary h3 display_flight_date"
                                            id="display_flight_date"></span>
                                    </td>
                                </tr>



                                <tr>
                                    <td>Payment Date: </td>
                                    <td>
                                        <span class=" font-13 text-primary h3"
                                            id="display_transfer_date">{{ date('d F, Y') }}</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Posted By: </td>
                                    <td>
                                        <span class="font-13 text-primary h3"
                                            id="display_posted_by">{{ session()->get('userAlias') }}</span>
                                    </td>
                                </tr>
                                {{--  ====== ENTER OTP =======  --}}
                                @if (!config('app.corporate'))
                                    <tr>
                                        <td>
                                            <h4 class="text-danger">Enter OTP</h4>
                                        </td>
                                        <td><input type="text" class="form-control text-input  " placeholder="Enter Otp"
                                                id="transfer_otp"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                                required></td>
                                    </tr>
                                @endif
                                <tr class="hide-on-success bg-danger  text-white">
                                    <td colspan="2">
                                        <div class="custom-control d-flex custom-checkbox ">
                                            <input type="checkbox" class="custom-control-input d-block"
                                                name="terms_and_conditions" id="terms_and_conditions">
                                            <label class="custom-control-label d-flex  align-items-center font-weight-bold"
                                                for="terms_and_conditions">
                                                By checking this box, you agree to
                                                abide by the Terms and Conditions
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    {{-- @include("snippets.pinCodeModal") --}}
                    <br>
                    <div class="form-group text-center hide-on-success">

                        <span> <button class="btn btn-rounded back-form-button" type="button" id="back_button"> <i
                                    class="mdi mdi-reply-all-outline"></i>&nbsp;Back</button>
                            &nbsp; </span>
                        <span>
                            &nbsp;
                            <button class="btn  btn-rounded form-button" type="button" id="confirm_transfer_button">
                                <span id="confirm_transfer">Confirm
                                    Transfer</span>
                                <span class="spinner-border spinner-border-sm mr-1" role="status" id="spinner"
                                    aria-hidden="true" style="display: none"></span>
                                <span id="spinner-text" style="display: none">Loading...</span>
                            </button>
                        </span>

                        <span>&nbsp; <button class="btn btn-light btn-rounded hide_on_print" type="button"
                                id="print_receipt" onclick="window.print()" style="display: none">Print
                                Receipt
                            </button></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/pages/payments/airportTaxPayment.js') }}"></script>
@endsection
