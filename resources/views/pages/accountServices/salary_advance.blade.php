@extends('layouts.master')


@section('content')
    @php
        $currentPath = 'Salary Advance ';
        $basePath = 'Account Services';
        $pageTitle = 'Salary Advance';
    @endphp
    @include('snippets.pageHeader')
    @include('snippets.pinCodeModal')

    <div class=" ">
        <div class="dashboard site-card overflow-hidden">
            <br>
            <div class="dashboard-body border-danger mt-0 p-4">
                <div class="row" id="salary_advance_form">
                    {{--  <div class="col-md-1"></div>  --}}
                    <div class="col-md-8">
                        <div>

                            @if ($result['responseCode'] !== '000')
                                <div id="kyc_incomplete" class="mx-auto" style="max-width: 350px; padding-top:24px">
                                    <img class=" img-fluid" src="{{ asset('assets/images/placeholders/kyc.svg') }}" />
                                    <span class="my-3 d-block text-white font-13 font-weight-bold p-2 rounded-lg"
                                        style="background-color: rgb(0, 0, 0)"><i
                                            class="fas fa-exclamation-circle pr-2"></i>{{ $result['message'] }}</span>

                                </div>
                            @else
                                <form action="#" style="max-width: 650px" autocomplete="off" aria-autocomplete="none">
                                    @csrf
                                    <div class="mb-1 ">
                                        <label class="text-dark text-bold">Select Account </label>

                                        <select class="accounts-select" id="from_account" required>
                                            <option disabled selected value=""> --- Select Source Account ---
                                            </option>
                                            @include('snippets.accounts')
                                        </select>

                                    </div>
                                    <hr class="my-3">

                                    <div class="form-group align-items-center row">

                                        <label class="col-md-4 text-dark">Salary Advance Amount</label>

                                        <div class="input-group mb-1 col-md-8" style="padding: 0px;">
                                            <div class="input-group-prepend">
                                                <input type="text" placeholder="" value="SLE"
                                                    class="input-group-text account_currency " style="width: 80px;"
                                                    disabled>
                                            </div>

                                            &nbsp;&nbsp;
                                            <input class="form-control  text-input key_transfer_amount" type="text"
                                                disabled>

                                            <input type="text" class="form-control text-input  ml-2"
                                                placeholder="Enter Amount " id="amount"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                                required>
                                            {{--  <button type="button" class="btn btn-danger  ml-2 btn-sm"><span
                                            class="mr-1 rate_button">Rate</span><i class="fas fa-calculator"></i></button>  --}}
                                        </div>
                                    </div>


                                    <div class="form-group align-items-center row">
                                        <label class="col-md-4 text-dark">Request Reason
                                        </label>
                                        <input type="text" class="form-control text-input col-md-8" id="purpose"
                                            placeholder="Enter reason for salary advance request"
                                            class="form-group row mb-3">
                                    </div>

                                    <div class="form-group text-right yes_beneficiary">
                                        <button class="btn next-button btn-rounded form-button" type="button"
                                            id="next_button">
                                            &nbsp; Next &nbsp;<i class="fe-arrow-right"></i></button>
                                    </div>
                                </form>
                            @endif
                        </div>



                    </div>
                    <div class="col-md-4">
                        <ul class="list-unstyled text-blue">
                            <li><i class="fa fa-info-circle text-red"></i>
                                <i> <b style="color: rgb(0, 183, 255);">Salary Account Details</b>: </b><br>
                                    {{--  <ol>
                                        <li>Template can be used for single upload of same bank and other banks.</li>
                                        <li>If an error is found in file uploaded, please delete and re-upload.</li>
                                    </ol>  --}}
                                </i>
                            </li>
                        </ul>
                        <div class="col-md-12">
                            <table class="table mb-0 table-striped p-4 mx-auto">
                                <tr>
                                    <p>Account Number</p>
                                    <p class="font-weight-bold" style="margin-top: -15px">
                                        {{ $result['data'][0]['accountNumber'] }}</p>
                                </tr>
                                <tr>
                                    <p>Monthly Salary</p>
                                    <p class="font-weight-bold" style="margin-top: -15px">
                                        {{ $result['data'][0]['salary'] }}</p>
                                </tr>
                                <tr>
                                    <p>Adavance Limit</p>
                                    <p class="font-weight-bold" style="margin-top: -15px">
                                        {{ $result['data'][0]['legibleFacility'] }}</p>
                                </tr>
                                <tr>
                                    <p>Advance Taken</p>
                                    <p class="font-weight-bold" style="margin-top: -15px">
                                        {{ $result['data'][0]['oldTod'] }}</p>
                                </tr>
                                <tr>
                                    <p>Advance Available</p>
                                    <p class="font-weight-bold" style="margin-top: -15px">
                                        {{ $result['data'][0]['availSalad'] }}</p>
                                </tr>

                            </table>
                        </div>
                    </div>

                </div>
                <div class="row" id="salary_advance_summary" style="display:none">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        {{--  displsplay summary  --}}
                        <div>
                            <div class="table-responsive p-4 mx-auto table_over_flow" style="max-width: 650px">
                                <table class="table mb-0 table-striped p-4 mx-auto">

                                    <tbody>

                                        <tr>
                                            <td>Account Details:</td>
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

                                        <tr>
                                            <td>Amount:</td>
                                            <td>
                                                <span class="font-13 text-success h3 account_currency"
                                                    id="display_currency">
                                                </span>
                                                &nbsp;
                                                <span class="font-13 text-success h3 display_transfer_amount"
                                                    id="display_transfer_amount"></span>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Transfer Fee</td>
                                            <td>
                                                <span class="font-13 text-danger h3 account_currency" id="display_currency">
                                                </span>
                                                &nbsp;
                                                <span class="font-13 text-danger h3 display_transfer_fee"
                                                    id="display_transfer_fee"></span>

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Reason:</td>
                                            <td>
                                                <span class="font-13 text-primary h3 display_purpose"
                                                    id="display_purpose"></span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td> Date: </td>
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
                                        <tr>
                                            <td>
                                                <h4 class="text-danger">Enter OTP</h4>
                                            </td>
                                            <td><input type="text" class="form-control text-input  "
                                                    placeholder="Enter Otp" id="transfer_otp"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                                    required></td>
                                        </tr>
                                        <tr class="hide-on-success bg-danger  text-white">
                                            <td colspan="2">
                                                <div class="custom-control d-flex custom-checkbox ">
                                                    <input type="checkbox" class="custom-control-input d-block"
                                                        name="terms_and_conditions" id="terms_and_conditions">
                                                    <label
                                                        class="custom-control-label d-flex  align-items-center font-weight-bold"
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

                                <span> <button class="btn btn-rounded back-form-button" type="button" id="back_button">
                                        <i class="mdi mdi-reply-all-outline"></i>&nbsp;Back</button>
                                    &nbsp; </span>
                                <span>
                                    &nbsp;
                                    <button class="btn  btn-rounded form-button" type="button"
                                        id="confirm_transfer_button">
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
                    <div class="col-md-1"></div>
                </div>

            </div>
        </div>
    </div>

    @include('snippets.transactionSummary')

    @include('snippets.pinCodeModal')
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/pages/accountServices/salaryAdvance.js') }}" defer></script>
@endsection
