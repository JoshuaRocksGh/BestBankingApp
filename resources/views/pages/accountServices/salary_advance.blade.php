@extends('layouts.master')


@section('content')
    @php
        $currentPath = 'Salary Advance ';
        $basePath = 'Account Services';
        $pageTitle = 'Salary Advance';
    @endphp
    @include('snippets.pageHeader')
    <div class="dashboard site-card">
        <br>
        <div class="dashboard-body border-danger mt-0 p-4">
            {{--  {{ $result['responseCode'] }}  --}}
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    {{--  form details  --}}
                    <div id="salary_advance_form">

                        @if ($result['responseCode'] !== '000')
                            <div id="kyc_incomplete" class="mx-auto" style="max-width: 350px; padding-top:24px">
                                <img class=" img-fluid" src="{{ asset('assets/images/placeholders/kyc.svg') }}" />
                                <span class="my-3 d-block text-white font-13 font-weight-bold p-2 rounded-lg"
                                    style="background-color: rgb(0, 0, 0)"><i
                                        class="fas fa-exclamation-circle pr-2"></i>{{ $result['message'] }}</span>
                                {{--  <a href="{{ url('kyc-update') }}" class="text-dark font-14 float-right text-right font-weight-bold"><i
                        class="far fa-edit"></i>
                    Update KYC</a>  --}}
                            </div>
                        @else
                            <form action="#" style="max-width: 650px" autocomplete="off" aria-autocomplete="none">
                                @csrf
                                <div class="mb-1 ">
                                    <label class="text-dark text-bold">Select Account </label>

                                    <select class="accounts-select" id="from_account" required>
                                        <option disabled selected value=""> --- Select Source Account --- </option>
                                        @include('snippets.accounts')
                                    </select>

                                </div>
                                <hr class="my-3">

                                <div class="form-group align-items-center row">

                                    <label class="col-md-4 text-dark">Salary Advance Amount</label>

                                    <div class="input-group mb-1 col-md-8" style="padding: 0px;">
                                        <div class="input-group-prepend">
                                            <input type="text" placeholder="" class="input-group-text account_currency "
                                                style="width: 80px;" disabled>
                                        </div>

                                        &nbsp;&nbsp;
                                        <input type="text" class="form-control text-input  "
                                            placeholder="Enter Salary Advance Amount " id="amount"
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
                                        placeholder="Enter reason for salary advance request" class="form-group row mb-3">
                                </div>

                                <div class="form-group text-right yes_beneficiary">
                                    <button class="btn next-button btn-rounded form-button" type="button" id="next_button">
                                        &nbsp; Next &nbsp;<i class="fe-arrow-right"></i></button>
                                </div>
                            </form>
                        @endif
                    </div>

                    {{--  displsplay summary  --}}
                    <div id="salary_advance_summary" style="display: none">
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
                                    {{--  <tr class=" show-on-success" style="display: none">
                        <td class="text-center bg-white" colspan="2">
                            <div class="row" style="place-content: space-evenly">
                                <button class="btn my-1 btn-primary" onclick="location.reload()"> make another
                                    transfer
                                </button>
                                <button class="btn my-1 btn-primary" id="save_as_beneficiary" style="display: none">
                                    save as beneficiary
                                </button>
                                @if ($currentPath === 'Same Bank')
                                    <button class="btn my-1 btn-primary"> make reccuring </button>
                                @endif
                            </div>
                        </td>
                    </tr>  --}}
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

                                    {{--  <tr>
                                        <td>Receiver Details:</td>
                                        <td>
                                            <span class="d-block font-13 text-primary h3 display_to_account_name"
                                                id="display_to_account_name"> </span>

                                            @if ($currentPath === 'Local Bank' || $currentPath === 'International Bank' || $currentPath === 'Standing Order')
                                                <span
                                                    class="d-block font-13 h3 text-bold text-primary display_to_bank_name">
                                                </span>

                                                </span>
                                            @endif
                                            <span class="d-block font-13 text-primary h3 display_to_account_no"
                                                id="display_to_account_no"> </span>
                                            @if ($currentPath !== 'International Bank' && $currentPath !== 'Local Bank' && $currentPath !== 'Standing Order')
                                                <span
                                                    class="d-block font-13 text-primary text-bold display_to_account_currency"
                                                    id="display_to_account_currency"></span>
                                            @endif

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
                                    {{--  @if ($currentPath === 'Local Bank')
                                        <tr>
                                            <td>Transfer Type:</td>
                                            <td>

                                                <span class="font-13 text-primary h3 display_to_transfer_type"></span>

                                            </td>
                                        </tr>
                                    @endif  --}}
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

                                    {{--  <tr>
                                        <td>Category:</td>
                                        <td>
                                            <span class="font-13 text-primary h3 display_category"
                                                id="display_category"></span>

                                        </td>
                                    </tr>  --}}
                                    {{--  @if ($currentPath === 'Standing Order')
                                        <tr>
                                            <td>Start Date: </td>
                                            <td>
                                                <span class="font-13 text-primary h3 display_so_start_date"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>End Date: </td>
                                            <td>
                                                <span class="font-13 text-primary h3 display_so_end_date"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Frequency: </td>
                                            <td>
                                                <span class="font-13 text-primary h3 display_frequency_so"></span>
                                            </td>
                                        </tr>
                                    @endif  --}}
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
                <div class="col-md-1"></div>

            </div>

        </div>
    </div>
    @include('snippets.transactionSummary')

    @include('snippets.pinCodeModal')
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/pages/accountServices/salaryAdvance.js') }}" defer></script>
@endsection
