@extends('layouts.master')
@section('content')
    @php
        $pageTitle = 'BOLLORE LINK';
        $basePath = 'Transfer';
        $currentPath = 'Bollore Link';
    @endphp
    @include('snippets.pageHeader')

    <div class="px-2">
        <div class="dashboard site-card overflow-hidden">
            <div class="tab-content dashboard-body p-4">
                <div class="mx-auto  h-100 " style="max-width: 650px" id="bollore_request">
                    <form action="#" autocomplete="off" aria-autocomplete="none" id="bollore_request_form">
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
                        <div class="form-group row">

                            <b class="col-md-4 text-dark"> Beneficiary
                                Name
                                &nbsp; <span class="text-danger">*</span></b>


                            <input type="text" class="form-control col-md-8 " id="beneficiary_name"
                                placeholder="Enter Beneficiary Name" autocomplete="off" required>
                            <br>

                        </div>

                        <div class="form-group row">

                            <b class="col-md-4 text-dark"> Beneficiary
                                Address
                                &nbsp; <span class="text-danger">*</span></b>


                            <input type="text" class="form-control col-md-8 " id="beneficiary_address"
                                placeholder="Enter Beneficiary Address" autocomplete="off" required>
                            <br>

                        </div>

                        <div class="form-group row">

                            <b class="col-md-4 text-dark"> Receiver
                                Name
                                &nbsp; <span class="text-danger">*</span></b>


                            <input type="text" class="form-control col-md-8 " id="reciever_name"
                                placeholder="Enter Receiver Name" autocomplete="off" required>
                            <br>

                        </div>

                        <div class="form-group row mb-3">

                            <b class="col-md-4 text-dark">Amount&nbsp;
                                <span class="text-danger">*</span></b>


                            <div class="input-group mb-1 col-md-8" style="padding: 0px;">
                                <div class="input-group-prepend">
                                    <input type="text" value="SLE" class="input-group-text display_currency"
                                        id="select_currency" style="width: 80px;" readonly>
                                </div>

                                &nbsp;
                                <input class="form-control  text-input key_transfer_amount" type="text" disabled>
                                &nbsp;


                                <input type="text" class="form-control " id="amount"
                                    placeholder="Enter Amount To Transfer"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                    required>
                            </div>



                        </div>

                        {{--  <div class="form-group row">

                            <b class="col-md-4 text-dark"> Beneficiary
                                Address
                                &nbsp; <span class="text-danger">*</span></b>


                            <input type="text" class="form-control col-md-8 " id="beneficiary_address"
                                placeholder="Enter Beneficiary Address" autocomplete="off" required>
                            <br>

                        </div>  --}}
                        <div class="form-group align-items-center row">
                            <b class="text-dark col-md-4"> Select ID Type </b>
                            <div class="col-md-8 px-0"> <select class="form-control  " id="id_type" required>
                                    <option disabled value="" selected> -- Select
                                        Type --</option>
                                    {{--  <option selected value="passport"> Passport</option>
                                    <option value="National_id"> National ID</option>
                                    <option value="Voter_id">Voter ID</option>  --}}
                                </select></div>
                        </div>
                        <div class="form-group row">

                            <b class="col-md-4 text-dark"> ID
                                Number
                                &nbsp; <span class="text-danger">*</span></b>


                            <input type="text" class="form-control col-md-8 " id="id_number"
                                placeholder="Enter ID Number" autocomplete="off" required>
                            <br>

                        </div>

                        <div class="form-group align-items-center row">
                            <b class="col-md-4 text-dark">Purpose of Transfer
                            </b>
                            <input type="text" value="Bollore Transfer" class="form-control text-input col-md-8"
                                id="transfer_purpose" placeholder="Enter purpose of transaction"
                                class="form-group row mb-3">
                        </div>

                        <div class="form-group row">

                            <b class="col-md-4 text-dark"> Telephone
                                Number
                                &nbsp; <span class="text-danger">*</span></b>


                            <input type="text" class="form-control col-md-8 " id="telephone_number"
                                placeholder="Enter Receiver Telephone" autocomplete="off"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                required>
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
                                <tr class="success_gif show-on-success" style="display: none">
                                    <td class="text-center bg-white" colspan="2">
                                        <img src="{{ asset('land_asset/images/statement_success.gif') }}"
                                            style="zoom: 0.5" alt="">
                                    </td>
                                </tr>
                                <tr class="show-on-success" style="display: none">
                                    <td class="text-center bg-white" colspan="2">
                                        <span class="text-success font-13 text-bold " id="success-message"></span>
                                    </td>
                                </tr>

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
                                <tr>
                                    <td>Beneficiary Details:</td>
                                    <td>
                                        <span class="d-block font-13 text-primary h3 display_beneficiary_name"
                                            id="display_beneficiary_name"> </span>
                                        <span class="d-block font-13 text-primary h3 display_beneficiary_address"
                                            id="display_beneficiary_address"> </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Receiver Details:</td>
                                    <td>
                                        <span class="d-block font-13 text-primary h3 display_to_receiver_name"
                                            id="display_to_receiver_name"> </span>
                                        <span class="d-block font-13 text-primary h3 display_to_receiver_id_type"
                                            id="display_to_receiver_id_type"> </span>
                                        <span class="d-block font-13 text-primary h3 display_to_receiver_id_number"
                                            id="display_to_receiver_id_number"> </span>
                                        <span class="d-block font-13 text-primary h3 display_to_receiver_telephone"
                                            id="display_to_receiver_telephone"> </span>

                                        {{--  @if ($currentPath === 'Local Bank' || $currentPath === 'International Bank' || $currentPath === 'Standing Order')
                                            <span class="d-block font-13 h3 text-bold text-primary display_to_bank_name">
                                            </span>
                                            <span class="d-block font-13 h3 text-bold text-primary display_to_account_address">
                                            </span>
                                        @endif  --}}
                                        {{--  <span class="d-block font-13 text-primary h3 display_to_account_no"
                                            id="display_to_account_no"> </span>
                                        @if ($currentPath !== 'International Bank' && $currentPath !== 'Local Bank' && $currentPath !== 'Standing Order')
                                            <span
                                                class="d-block font-13 text-primary text-bold display_to_account_currency"
                                                id="display_to_account_currency"></span>
                                        @endif  --}}

                                    </td>
                                </tr>

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
                                {{--  <tr>
                                    <td>Transfer Fee</td>
                                    <td>
                                        <span class="font-13 text-danger h3 account_currency" id="display_currency">
                                        </span>
                                        &nbsp;
                                        <span class="font-13 text-danger h3 display_transfer_fee"
                                            id="display_transfer_fee">0.00</span>

                                    </td>
                                </tr>  --}}

                                <tr>
                                    <td>Purpose:</td>
                                    <td>
                                        <span class="font-13 text-primary h3 display_purpose" id="display_purpose"></span>
                                    </td>
                                </tr>

                                {{--  <tr>
                                    <td>Category:</td>
                                    <td>
                                        <span class="font-13 text-primary h3 display_category"
                                            id="display_category"></span>

                                    </td>
                                </tr>  --}}
                                @if ($currentPath === 'Standing Order')
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
                                @endif
                                <tr>
                                    <td>Transfer Date: </td>
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
    <script src="{{ asset('assets/js/pages/transfer/bollore.js') }}"></script>
@endsection
