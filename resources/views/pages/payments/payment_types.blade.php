@extends('layouts.master')
@section('styles')
@endsection
@section('content')
    @php
        $pageTitle = 'payment type';
        $basePath = 'Payment';
        $currentPath = 'Make Payment';
    @endphp

    @include('snippets.pageHeader')
    @include('snippets.misc.no_beneficiary')
    @include('pages.payments.payment_verification_modal')
    <div class="site-card  dashboard">
        <div class=" mb-1 p-3 py-4 row mx-auto dashboard-body" style="max-width: 80rem">

            {{-- SELECT PAYMENT TYPE --}}

            <div class=" col-lg-4" data-title="Payment Tabs" data-intro="Click to select payment option">
                <label class="mb-2 d-block f-18 text-center font-weight-bold text-dark">Select Payment
                    Type</label>
                <div class="payments-carousel mx-auto" style="max-width: 20rem">
                </div>
                <hr class="col-md-8">

            </div>
            <div class=" col-lg-8" data-title="Payment Form" data-intro="Complete form to perform transaction">

                {{-- here --}}

                <div class="form-group d-flex bg-light p-2 momo_trasfer_type" style="border-radius: 5px;display: flex;justify-content: center;">
                    <label class="col-md-4 text-capitalize col-form-label text-dark">Mobile Money Type </label>
                    <div class="col-md-8">
                        <div class="radio radio-info form-check-inline" >
                            <input type="radio" id="AcctToMomo" value="AcctToMomo" name="AcctToMomo" checked>
                            <label class="pt-2" for="AcctToMomo mt-1">Account to MoMo </label>
                        </div>
                        <div class="radio form-check-inline">
                            <input type="radio" id="MomoToAcct" value="MomoToAcct" name="AcctToMomo">
                            <label class="pt-2" for="MomoToAcct">MoMo to Account </label>
                        </div>
                    </div>
                </div>
                {{-- hello --}}
                {{-- Select Account --}}
                <div class="mx-auto" style="max-width: 50rem">
                    <label class="d-block text-center f-18 font-weight-bold mb-1 text-dark"> Select Account To
                        Transfer
                        From</label>

                    <select class="form-control accounts-select" id="from_account" required>
                        @include('snippets.accounts')
                    </select>

                    <hr class="">
                    <div style="position: relative">
                        <ul class="nav w-100 active nav-fill nav-pills" id="onetime_bene_tab" role="tablist">
                            <li class="nav-item w-50" role="presentation" style="position: absolute">
                                <button class="switch w-100  nav-link active" id="beneficiary_tab" data-toggle="pill"
                                    href="#beneficiary_view" type="button" role="tab" aria-controls="beneficiary_view"
                                    aria-selected="false">
                                    Beneficiary</button>
                            </li>
                            <li class="nav-item w-50" role="presentation">
                                <button class=" switch leftbtn w-100 nav-link " id="onetime_tab" data-toggle="pill"
                                    href="#onetime_view" type="button" role="tab" aria-controls="onetime_view"
                                    aria-selected="true">
                                    <div class="switch-text">Onetime</div>
                                </button>
                            </li>

                        </ul>
                    </div>
                    <div class="tab-content mt-4" id="onetime_bene_tabContent">

                        {{-- ============================================= --}}
                        {{-- beneficiary toggle --}}
                        {{-- ============================================= --}}
                        <div class="p-0 tab-pane fade  show active" id="beneficiary_view" role="tabpanel"
                            aria-labelledby="beneficiary_tab">
                            <div class="form-group d-flex">
                                <label class="text-dark  col-4 col-form-label bene_details">Select Beneficiary
                                </label>
                                <select class="form-control accounts-select text-capitalize bene_details" id="to_account"
                                    required>
                                    <option value="">--- Select Beneficiary ---</option>

                                </select>
                            </div>
                        </div>
                        {{-- ============================================= --}}
                        {{-- Onetime toggle --}}
                        {{-- ============================================= --}}
                        <div class="p-0 tab-pane fade" id="onetime_view" role="tabpanel" aria-labelledby="onetime_tab">
                            <div class="form-group d-flex text-capitalize" id="subtype_div" style="display: none">
                                <label class="text-dark col-4 col-form-label text-capitalize" id="subtype_label">
                                </label>
                                <select class="form-control accounts-select " id="subtype_select" required>
                                </select>
                            </div>

                            <div class="form-group d-flex">
                                <label class="col-md-4 col-form-label text-capitalize text-dark" id="payment_label"></label>
                                <input type="number" class="form-control text-capitalize col-md-8 " id="onetime_to_account"
                                    autocomplete="off" placeholder="Enter Account Number">
                                {{-- oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"> --}}
                            </div>
                        </div>
                        @if (config('app.corporate'))
                            <div class="form-group d-flex" >

                                <label class="col-md-4 text-capitalize col-form-label text-dark">Payment Type </label>
                                <div class="col-md-8">
                                    <div class="radio radio-info form-check-inline">
                                        <input type="radio" id="inlineRadio1" value="normal" name="trans_type"
                                            checked>&nbsp;&nbsp;
                                        <label class="pt-1" for="inlineRadio1 mt-1">Normal</label>
                                    </div>
                                    <div class="radio form-check-inline">
                                        <input type="radio" id="inlineRadio2" value="invoice"
                                            name="trans_type">&nbsp;&nbsp;
                                        <label class="pt-1" for="inlineRadio2"> Invoice Transaction </label>
                                    </div>

                                </div>
                            </div>
                        @endif
                        @if (config('app.corporate'))
                            {{--  <div class="form-group d-flex">
                                <label class="col-4 text-capitalize col-form-label text-dark">Payment Invoice</label>
                                <div class="input-group ">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="invoice_file"
                                            id="invoice_file" autocomplete="off">
                                        <label class="custom-file-label" for="invoice_file">Choose file</label>
                                    </div>
                                </div>
                            </div>  --}}
                            <div class="col-12 display_upload_input" style="display: none">
                                <div class="form-group align-items-center row">
                                    <label class="col-md-4 text-dark">Attach Invoice </label>
                                    <div class="input-group mb-1 col-md-8" style="padding: 0px;">

                                        <div class="input-group"
                                            onclick="get_file_name('invoice_file','invoice_file_name')">

                                            <div class="custom-file">
                                                <input type="file" class="form-control custom-file-input"
                                                    id="invoice_file">
                                                <label class="custom-file-label" for="invoice_file_name"
                                                    id="invoice_file_name">Choose file</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endif
                        <div class="form-group d-flex">
                            <label class="col-4 text-capitalize col-form-label text-dark">Enter Amount</label>
                            <input type="number" class="col-8 form-control text-capitalize  " id="amount"
                                autocomplete="off" placeholder="Enter Amount">
                            {{-- oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"> --}}
                        </div>
                    </div>
                    <div class="text-right mt-4">
                        <button class="btn font-weight-bold form-button  font-11 next-button btn-rounded"
                            id="next_button">
                            &nbsp; Proceed &nbsp; <i class="fe-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('snippets.pinCodeModal')
@endsection

@section('scripts')
    <script>
        var myaccount = @json(session()->get('customerAccounts'))
    </script>

    <script>
        var myaccount = @json(session()->get('customerAccounts'))
    </script>

    <script src="{{ asset('assets/js/pages/payments/paymentTypes.js') }}"></script>
    <script src="{{ asset('assets/js/functions/comingSoon.js') }}"></script>
    <script>
        function get_file_name(file_name, file_label) {
            console.log(file_name);
            console.log(file_label);
            $(`#${file_name}`).change(function() {
                console.log("on chnge ==>", $(`#${file_name}`).val())

                var filename = $(`#${file_name}`)
                    .val()
                    .replace(/C:\\fakepath\\/i, "");
                console.log(filename);
                $(`#${file_label}`).empty().append(filename);
            });
        }
    </script>
@endsection
