@extends('layouts.master')
@section('content')
    @php
        $pageTitle = 'INSTANT PAYMENT';
        $basePath = 'Payments';
        $currentPath = 'Instant Payment';
    @endphp
    @include('snippets.pageHeader')
    @include('snippets.pinCodeModal')
    <div class="px-2">
        <div class="dashboard site-card overflow-hidden">
            <div class="tab-content dashboard-body p-4">
                <div class="mx-auto  h-100 " style="max-width: 650px" id="instant_payment">
                    <form action="#" autocomplete="off" aria-autocomplete="none" id="intant_payment_form">
                        <div class="form-group row ">
                            <b class="col-md-12 text-dark">Account to
                                transfer from &nbsp;
                                <span class="text-danger">*</span> </b>


                            <select class="form-control col-md-12 accounts-select" id="from_account" required>
                                <option disabled selected value=""> ---
                                    Select Source Account ---
                                </option>
                                @include('snippets.accounts')
                            </select>
                        </div>
                        <hr class="my-3">
                        {{--  <div class="mb-2">
                            <ul class="nav w-100 active position-relative nav-fill nav-pills" id="onetime_bene_tab"
                                role="tablist">
                                <li class="nav-item w-50 position-absolute" role="presentation">
                                    <button class="switch w-100  nav-link active" id="beneficiary_tab" data-toggle="pill"
                                        href="#beneficiary_view" type="button" role="tab"
                                        aria-controls="beneficiary_view" aria-selected="false">
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
                        </div>  --}}
                        {{--    --}}
                        @php
                            $destination = 'Beneficiary A/C';
                        @endphp


                        {{--  <div class="tab-content" id="onetime_bene_tabContent">  --}}
                        {{-- =============================================================== --}}
                        {{-- beneficiary view --}}
                        {{-- =============================================================== --}}

                        <div class="row align-items-center mb-1">
                            <label class="text-dark col-md-4  ">Transfer Bank</label>
                            <div class="col-md-8 px-0"><select class="form-control " id="onetime_select_bank" required>
                                    <option disabled selected>--- Not Selected ---</option>

                                </select></div>
                        </div>

                        {{--  <div class="tab-pane py-3 px-0 fade show active" id="beneficiary_view" role="tabpanel"
                                aria-labelledby="beneficiary_tab">
                                <div class="form-group align-items-center row bank_div">
                                    <label class="col-md-4 form-check-label text-dark"> Beneficiary A/C Bank</label>
                                    <div class="col-md-8 px-0"> <select data-title=" --- Select {{ $destination }} ---"
                                            data-none-selected-text="--- Select {{ $destination }} ---"
                                            class="form-control select_beneficiary" id="to_account" required>
                                            <option disabled selected value=""> -- Select
                                                {{ $destination }} --</option>
                                        </select></div>

                                </div>
                            </div>  --}}

                        <div class="form-group align-items-center row">
                            <label class="col-md-4 text-dark"> {{ $destination }}
                                Number</label>
                            <input type="text"
                                class="form-control  text-input  display_to_account display_to_account_no col-md-8 "
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                id="onetime_account_number" placeholder="Enter Beneficiary Account">
                        </div>

                        <div class="form-group align-items-center row">
                            <label class="col-md-4 text-dark"> {{ $destination }} Name</label>
                            <input type="text"
                                class="form-control  text-input display_to_account display_to_account_name col-md-8  "
                                id="saved_beneficiary_name" placeholder="Enter Beneficiary Name">
                        </div>

                        {{--  <div class="form-group align-items-center row email-div">
                            <label class="col-md-4 text-dark"> {{ $destination }} Email</label>
                            <input type="text"
                                class="form-control  text-input display_to_account display_to_receiver_email col-md-8 "
                                id="saved_beneficiary_email" placeholder="Enter Beneficiary Email">
                        </div>  --}}

                        {{--  <div class="row align-items-center mb-1">
                            <label class="text-dark col-md-4">Beneficiary Address</label>
                            <input class="form-control text-input col-md-8" type="text" id="onetime_beneficiary_address"
                                placeholder="Enter Beneficiary Address">
                        </div>  --}}

                        <div class="form-group align-items-center row">
                            <label class="col-md-4 text-dark"> Amount</label>
                            <div class="input-group mb-1 col-md-8" style="padding: 0px;">
                                <div class="input-group-prepend">
                                    <input type="text" placeholder="SLL" class="input-group-text account_currency "
                                        style="width: 80px;" disabled>

                                </div>

                                &nbsp;&nbsp;
                                {{--  <div class="input-group-prepend">  --}}
                                <input class="form-control  text-input key_transfer_amount" type="text" disabled>
                                {{--  </div>  --}}
                                <input type="text" class="form-control text-input  ml-2"
                                    placeholder="Enter Amount To Transfer" id="amount"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                    required>
                            </div>

                        </div>

                        <div class="form-group align-items-center row">
                            <label class="col-md-4 text-dark">Purpose of Transfer
                            </label>
                            <input type="text" value="Instant Payment" class="form-control text-input col-md-8"
                                id="purpose" placeholder="Enter purpose of transaction" class="form-group row mb-3">
                        </div>

                        {{-- =============================================================== --}}
                        {{-- onetime view --}}
                        {{-- =============================================================== --}}

                        {{--  <div class="tab-pane py-3 px-0 fade" id="onetime_view" role="tabpanel"
                                aria-labelledby="onetime_tab">
                                onetime_view
                            </div>  --}}

                        {{--  </div>  --}}


                        <div class="form-group text-right yes_beneficiary">
                            <button class="btn next-button btn-rounded form-button" type="button" id="next_button">
                                &nbsp; Next &nbsp;<i class="fe-arrow-right"></i></button>
                        </div>
                    </form>

                </div>

            </div>

        </div>

    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/pages/payments/instantPayment.js') }}"></script>
@endSection
