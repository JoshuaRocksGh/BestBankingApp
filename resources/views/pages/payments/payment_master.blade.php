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

        #redeemed_history.active {
            background-color: #dc3545 !important;
            color: white !important;
            border-color: #dc3545 !important;

        }


        #pending_history.active {
            background-color: #dc3545 !important;
            color: white !important;
            border-color: #dc3545 !important;

        }

        #cancelled_history.active {
            background-color: #dc3545 !important;
            color: white !important;
            border-color: #dc3545 !important;

        }
    </style>
@endsection
@section('content')
    @include('snippets.pageHeader')
    <div class="px-2">
        <div class="dashboard site-card overflow-hidden">
            <nav class="dashboard-header" data-title="Salone Tabs" data-intro="Click to view form">
                <div class="nav nav-tabs justify-content-center border-0" id="nav-tab" role="tablist">
                    <a href="#send_{{ $currentType }}_page" data-toggle="tab" aria-expanded="true"
                        class="nav-link w-100 text-center active send_{{ $currentType }}_tab" style="max-width: 175px">
                        Send {{ $currentPath }}
                    </a>
                    <a href="#{{ $currentType }}_history_page" id="{{ $currentType }}_history_tab" data-toggle="tab"
                        aria-expanded="false" class="nav-link w-100 text-center {{ $currentType }}_trans_tab"
                        style="max-width: 175px">
                        {{ $currentPath }} History
                    </a>

                    <a href="#redeem_{{ $currentType }}_page" data-toggle="tab" aria-expanded="false"
                        class="nav-link w-100 text-center redeem_{{ $currentType }}_tab" style="max-width: 175px">
                        Redeem {{ $currentPath }}
                    </a>
                </div>
            </nav>
            <div class="tab-content dashboard-body" data-title="Salone Link Form"
                data-intro="Complete fields to perform transaction">
                <div class="tab-pane show active" id="send_{{ $currentType }}_page">
                    {{--  REQUEST FORM  --}}
                    <div class="mx-auto  h-100 " style="max-width: 650px" id="request_form_div">
                        <form action="#" class="select_beneficiary" id="send_{{ $currentType }}_payment_details_form"
                            autocomplete="off" aria-autocomplete="none">
                            @csrf

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

                                <label class="col-sm-5 text-dark align-self-center"> Type of
                                    Transfer &nbsp; <span class="text-danger">*</span></label>

                                <div class="row col-sm-7 ml-3 ml-sm-0">
                                    <div class="radio radio-black form-check-inline m-1 col-sm-5 destination">
                                        <input type="radio" id="transfer_to_self" value="SELF"
                                            name="self_transfer_toggle">
                                        <label class="col-form-label ml-2" for="transfer_to_self"> Self
                                        </label>
                                    </div>
                                    <div class="radio  radio-black form-check-inline m-1 col-sm-5 transfer_type">
                                        <input type="radio" id="transfer_to_others" value="OTHERS"
                                            name="self_transfer_toggle" checked>
                                        <label class="col-form-label ml-2" for="transfer_to_others">
                                            Others</label>
                                    </div>

                                </div>

                            </div>

                            <hr style="padding-top: 0px; padding-bottom: 0px;">


                            <div id="{{ $currentType }}_transfer_form">


                                <div class="form-group row">

                                    <b class="col-md-4 text-dark"> Receiver
                                        Name
                                        &nbsp; <span class="text-danger">*</span></b>


                                    <input type="text" class="form-control col-md-8 " id="receiver_name"
                                        placeholder="Enter Receiver Name" autocomplete="off" required>
                                    <br>

                                </div>

                                <div class="form-group row">

                                    <b class="col-md-4 text-dark"> Receiver
                                        Telphone &nbsp; <span class="text-danger">*</span></b>

                                    <input type="text" class="form-control col-md-8 " id="receiver_phoneNum"
                                        placeholder="Enter Receiver Phone Number" autocomplete="off"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        required>
                                    <br>

                                </div>

                                <div class="form-group row hide-if-self-transfer">

                                    <b class="col-md-4 text-dark"> Receiver
                                        Address: &nbsp; <span class="text-danger">*</span></b>

                                    <input type="text" class="form-control col-md-8 " id="receiver_address"
                                        placeholder="Enter Receiver Address" autocomplete="off" required>
                                    <br>

                                </div>

                                <div class="form-group align-items-center row">

                                    <b class="col-md-4 text-dark">Amount&nbsp;
                                        <span class="text-danger">*</span></b>


                                    <div class="input-group mb-1 col-md-8" style="padding: 0px;">
                                        <div class="input-group-prepend">
                                            <input type="text" value="SLL" class="input-group-text display_currency"
                                                id="select_currency" style="width: 80px;" readonly />
                                        </div>

                                        &nbsp;&nbsp;
                                        <input class="form-control  text-input key_transfer_amount" type="text" disabled>
                                        {{-- <div></div> --}}
                                        <input type="text" class="form-control text-input  ml-2 " id="amount"
                                            placeholder="Enter Amount To Transfer"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                            required>
                                    </div>



                                </div>

                                <div class="form-group row">
                                    <b class="col-md-4 text-dark">Purpose of
                                        Transfer<span class="text-danger">*</span></b>

                                    <input type="text" class="form-control col-md-8 " id="narration"
                                        placeholder="Enter Naration" autocomplete="off" required
                                        value="{{ $currentPath . ' Transfer' }}">

                                </div>

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
                    {{--  SUMMARY FORM  --}}
                    <div id="transaction_summary" style='display:none'>
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
                                        <span
                                            class="font-13 text-primary h3 account_currency display_from_account_currency"
                                            id="display_from_account_currency">
                                        </span>
                                        &nbsp;
                                        <span class="font-13 text-primary h3 display_from_account_amount"
                                            id="display_from_account_amount"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Receiver Details:</td>
                                    <td>
                                        <span class="d-block font-13 text-primary h3 display_receiver_name"
                                            id="display_receiver_name">
                                        </span>
                                        <span class="d-block font-13 text-primary h3 display_receiver_telephone"
                                            id="display_receiver_telephone"></span>
                                        <span class="font-13 text-primary h3 account_currency display_receiver_Adddress"
                                            id="display_receiver_Adddress">
                                        </span>
                                        &nbsp;
                                        {{--  <span class="font-13 text-primary h3 display_from_account_balance"
                            id="display_from_account_balance"></span>  --}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Amount:</td>
                                    <td>
                                        <span class="font-13 text-success h3 display_currency" id="display_currency">
                                        </span>
                                        &nbsp;
                                        <span class="font-13 text-success h3 display_transfer_amount"
                                            id="display_transfer_amount"></span>

                                    </td>
                                </tr>
                                <tr>
                                    <td>Purpose:</td>
                                    <td>
                                        <span class="font-13 text-primary h3 display_purpose" id="display_purpose"></span>
                                    </td>
                                </tr>
                                {{--  <tr>
                    <td>Category:</td>
                    <td>
                        <span class="font-13 text-primary h3 display_category" id="display_category"></span>

                    </td>
                </tr>  --}}
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
                                            <input type="checkbox" class="custom-control-input d-block" name="terms_and_conditions"
                                                id="terms_and_conditions">
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
                <div class="tab-pane" id="redeem_{{ $currentType }}_page">

                    <div class="mx-auto " id="request_form_div" style="max-width: 650px">

                        <form action="#" class="select_beneficiary"
                            id="redeem_{{ $currentType }}_payment_details_form" autocomplete="off"
                            aria-autocomplete="none">
                            @csrf

                            <div class="row">
                                <div class="col-md-12 redeem_{{ $currentType }}">

                                    <p class="text-muted font-14 m-b-20">
                                        <span> <i class="fa fa-info-circle  text-red"></i> <b style="color:red;">Please
                                                Note:&nbsp;&nbsp;</b> <span class="">Enter the
                                                remittance and phone number for {{ $currentType }} payment details.

                                                <hr>
                                    </p>


                                    <div class="form-group row">

                                        <b class="col-md-5 text-dark"> Mobile Number &nbsp; <span
                                                class="text-danger">*</span></b>


                                        <input type="text" class="form-control col-md-7" id="mobile_no"
                                            autocomplete="off" placeholder="Enter Phone Number" required>
                                    </div>

                                    <div class=" form-group row">

                                        <b class="col-md-5 text-dark"> Remittance Number:
                                            &nbsp; <span class="text-danger">*</span></b>

                                        <input type="text" class="form-control col-md-7" id="remittance_no"
                                            placeholder="Enter Remittance Number" autocomplete="off"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '
                                    $1');"
                                            required>
                                    </div>

                                    <div class="form-group text-right ">
                                        <button type="button"
                                            class="btn btn-rounded mt-2 waves-effect waves-light disappear-after-success form-button"
                                            id="proceed_to_redeem_button">
                                            <span id="next-text">Next</span> &nbsp;<i class="fe-arrow-right"></i>
                                        </button>
                                    </div>


                                </div>
                                <div class="col-md-12 {{ $currentType }}_details" style="display: none">
                                    <div class="form-group row ">
                                        <b class="col-md-12 text-dark">Select Account To Redeem Into
                                            &nbsp;
                                            <span class="text-danger"></span> </b>
                                        <select class="form-control col-md-12 accounts-select" id="redeem_account"
                                            required>
                                            <option disabled selected value=""> ---
                                                Select
                                                Account ---
                                            </option>
                                            @include('snippets.accounts')
                                        </select>
                                    </div>
                                    <hr style="padding-top: 0px; padding-bottom: 0px;">

                                    <div class="form-group row">

                                        <b class="col-md-5 text-primary"> Receiver's Name:</b>


                                        <input type="text" class="form-control col-md-7" id="receiver_name_redeem"
                                            autocomplete="off" readonly>
                                        <br>

                                    </div>
                                    <div class="form-group row">

                                        <b class="col-md-5 text-primary"> Receiver's Phone:
                                        </b>

                                        <input type="text" class="form-control col-md-7" id="receiver_phone_redeem"
                                            autocomplete="off"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                            readonly>
                                    </div>

                                    <div class="form-group row">

                                        <b class="col-md-5 text-primary"> Receiver Address:
                                        </b>

                                        <input type="text" class="form-control col-md-7" id="receiver_address_redeem"
                                            autocomplete="off"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                            readonly>
                                    </div>
                                    <div class="form-group row">

                                        <b class="col-md-5 text-primary"> Amount:</b>

                                        <input type="text" class="form-control col-md-7" id="receiver_amount_redeem"
                                            autocomplete="off"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                            readonly>

                                    </div>

                                    <div class="form-group text-right ">
                                        <button type="button"
                                            class="btn btn-primary btn-rounded waves-effect waves-light disappear-after-success"
                                            id="done_button">
                                            <span id="redeem-text">Redeem</span>

                                        </button>
                                    </div>


                                </div>

                            </div>

                        </form>

                    </div>


                </div>
                <div class="tab-pane site-card p-2 p-sm-3 p-md-4" id="{{ $currentType }}_history_page">

                    <div class="px-md-3 mt-lg-0 rounded row">
                        <div class="col-lg-4">
                            <label class="mb-2 d-block f-18 text-center font-weight-bold text-dark">Select
                            </label>

                            <nav class="col-md-4  nav nav-pills flex-column mx-auto mb-3 flex-row"
                                style="max-width: 350px">
                                <button id="pending_history" data-value="unredeemed"
                                    class=" transition-all py-md-2 active  text-sm-center mb-1 mb-md-2   font-weight-bold bg-white rounded-pill border text-dark border-gray knav nav-link"
                                    href="#">Pending</button>
                                <button data-value="redeemed"
                                    class=" transition-all py-md-2  text-sm-center mb-1 mb-md-2   font-weight-bold bg-white rounded-pill border text-dark border-gray knav nav-link "
                                    id="redeemed_history" href="#">Redeemed</button>

                                <button id="cancelled_history" data-value="reversed"
                                    class="  transition-all py-md-2 text-sm-center mtb1  mb-md-2  font-weight-bold bg-white rounded-pill border text-dark border-gray knav nav-link"
                                    href="#">Cancelled</button>
                            </nav>
                            <hr>

                        </div>


                        <div class="col-lg-8" style="max-width: 50rem">
                            <div class=" align-self-center" style="min-width: 100px"> <label
                                    class="d-block f-18 font-weight-bold mb-1 text-dark">
                                    Select
                                    Account</label></div>

                            <select class="form-control unredeemed accounts-select"
                                id="{{ $currentType }}_history_accounts" required>
                                <option disabled selected value="">Select
                                    Account Number</option>
                                @include('snippets.accounts')
                            </select>
                            <hr class="">

                            <div class="row pt-md-4 mx-auto" style="max-width: 650px">

                                <div class="col-md-8" id="{{ $currentType }}_history_display"
                                    style="max-width: 650px;">
                                    <div id="{{ $currentType }}_history_container" style="min-height: 350px; "
                                        class="mb-3">
                                        <div class="text-center" {!! $noDataAvailable !!}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{--    --}}


                    </div>

                </div>
            </div>
        </div>
        @include('snippets.pinCodeModal')
    @endsection
    @section('scripts')
        <script>
            const customerInfo = new Object();
            customerInfo.customerType = @json(session()->get('customerType'));
            customerInfo.userAlias = @json(session()->get('userAlias'));
            customerInfo.userPhone = @json(session()->get('customerPhone'));
            customerInfo.userEmail = @json(session()->get('email'));
            const paymentType = @json($currentType);
        </script>
        <script>
            let noDataAvailable = {!! json_encode($noDataAvailable) !!}
        </script>
        <script src="{{ asset('assets/js/pages/payments/paymentMaster.js') }}"></script>
        <script src="{{ asset('assets/plugins/pagination/pagination-2.1.5.min.js') }}" defer></script>
    @endsection
