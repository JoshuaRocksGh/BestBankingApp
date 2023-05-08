<style>
    .input-span {
        position: absolute;
        top: 0.8rem;
        right: 0.5rem;
        z-index: 222;
    }

    .text-rokel-blue {
        color: #00bdf3 !important
    }
</style>


<div class=" dashboard site-card " id="transaction_form"> <br>
    <div class=" dashboard-body mt-0 p-4 " data-title="Transfer Form"
        data-intro="Complete the fields below to perform trnsaction">
        <form action="#" class="mx-auto" style="max-width: 650px" id="payment_details_form" autocomplete="off"
            aria-autocomplete="none">
            @csrf
            {{-- ======================================================= --}}
            {{-- TRANSFER TYPE WITH INVOICE --}}
            {{-- ======================================================= --}}

            @if (config('app.corporate'))
                @if (
                    $currentPath === 'Local Bank' ||
                        $currentPath === 'Same Bank' ||
                        $currentPath === 'International Bank' ||
                        $currentPath === 'Standing Order')
                    <div class="col-12">
                        <div class="form-group align-items-center row bg-light p-2" style="border-radius: 5px">

                            <label class="col-md-4 text-dark">Transfer Type </label>
                            <div class="col-md-8">
                                <div class="radio radio-info form-check-inline">
                                    <input type="radio" id="inlineRadio1" value="normal" name="trans_type" checked>&nbsp;&nbsp;
                                    <label class="pt-1" for="inlineRadio1 mt-1">Normal</label>
                                </div>
                                <div class="radio form-check-inline">
                                    <input type="radio" id="inlineRadio2" value="invoice" name="trans_type">&nbsp;&nbsp;
                                    <label class="pt-1" for="inlineRadio2"> Invoice Transaction </label>
                                </div>

                            </div>
                        </div>

                    </div>
                    <hr class="my-3">
                @endif

            @endif

            {{-- ======================================================= --}}
            {{-- Own account Area --}}
            {{-- ======================================================= --}}
            <div class=" mb-1 ">
                <label class="text-dark text-bold">Account to transfer from</label>

                <select class="accounts-select" id="from_account" required>
                    <option disabled selected value=""> --- Select Source Account --- </option>
                    @include('snippets.accounts')
                </select>

            </div>
            <hr class="my-3">

            {{-- ============================================================== --}}
            {{-- Beneficiary and Onetime Switch --}}
            {{-- ============================================================== --}}
            @if ($currentPath === 'Local Bank' || $currentPath === 'Same Bank' || $currentPath === 'International Bank')
                <div class="mb-2">
                    <ul class="nav w-100 active position-relative nav-fill nav-pills" id="onetime_bene_tab"
                        role="tablist">
                        <li class="nav-item w-50 position-absolute" role="presentation">
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
            @endif

            <div class="tab-content" id="onetime_bene_tabContent">


                {{-- =============================================================== --}}
                {{-- beneficiary view --}}
                {{-- =============================================================== --}}

                @php
                    if ($currentPath === 'Own Account') {
                        $destination = 'Destination A/C';
                    } else {
                        $destination = 'Beneficiary A/C';
                    }
                @endphp
                <div class="tab-pane py-3 px-0 fade show active" id="beneficiary_view" role="tabpanel"
                    aria-labelledby="beneficiary_tab">
                    <div class="col-12">
                        @if ($currentPath === 'Standing Order')
                            <div class="form-group align-items-center row">
                                <label class="text-dark col-md-4"> Standing Other Type </label>
                                <div class="col-md-8 px-0"> <select class="form-control  " id="standing_other_type"
                                        required>
                                        <option disabled value=""> -- Select
                                            Type --</option>
                                        <option value="own account"> Own Account</option>
                                        <option value="same bank"> Same Bank</option>
                                        <option value="other bank">Other Bank</option>
                                    </select></div>
                            </div>
                        @endif
                        <div class="form-group row align-items-center">
                            <label class="col-md-4 form-check-label text-dark"> {{ $destination }} </label>
                            <div class="col-md-8 px-0"> <select data-title=" --- Select {{ $destination }} ---"
                                    data-none-selected-text="--- Select {{ $destination }} ---"
                                    class="form-control select_beneficiary" id="to_account" required>
                                    <option disabled selected value=""> -- Select
                                        {{ $destination }} --</option>
                                    {{-- @if ($currentPath === 'Own Account' || $currentPath === 'Standing Order') --}}
                                    @if ($currentPath === 'Own Account')
                                        @include('snippets.accounts')
                                    @endif
                                </select></div>
                        </div>
                        @if ($currentPath === 'Local Bank' || $currentPath === 'International Bank' || $currentPath === 'Standing Order')
                            <div class="form-group align-items-center row bank_div">
                                <label class="text-dark  col-md-4">{{ $destination }} Bank</label>
                                <input
                                    class="form-control  text-input col-md-8 display_to_account display_to_account_bank "
                                    type="text" id="beneficiary_bank_name" disabled>
                            </div>
                        @endif
                        <div class="form-group align-items-center row">
                            <label class="col-md-4 text-dark"> {{ $destination }}
                                Number</label>
                            <input type="text"
                                class="form-control  text-input  display_to_account display_to_account_no col-md-8 "
                                id="saved_beneficiary_account_number" disabled>
                        </div>

                        <div class="form-group align-items-center row">
                            <label class="col-md-4 text-dark"> {{ $destination }} Name</label>
                            <input type="text"
                                class="form-control  text-input display_to_account display_to_account_name col-md-8  "
                                id="saved_beneficiary_name" disabled>
                        </div>
                        @if ($currentPath !== 'Own Account')
                            <div class="form-group align-items-center row email-div">
                                <label class="col-md-4 text-dark"> {{ $destination }} Email</label>
                                <input type="text"
                                    class="form-control  text-input display_to_account display_to_receiver_email col-md-8 "
                                    id="saved_beneficiary_email" disabled>
                            </div>
                        @endif
                        @if ($currentPath === 'Local Bank' || $currentPath === 'International Bank')
                            <div class="row align-items-center mb-1">
                                <label class="text-dark col-md-4">Beneficiary Address</label>
                                <input class="form-control  text-input col-md-8  " type="text"
                                    id="beneficiary_address" disabled>
                            </div>
                        @endif
                    </div>
                </div>
                {{-- =============================================================== --}}
                {{-- onetime view --}}
                {{-- =============================================================== --}}

                @if ($currentPath === 'Local Bank' || $currentPath === 'Same Bank' || $currentPath === 'International Bank')
                    <div class="tab-pane py-3 px-0 fade" id="onetime_view" role="tabpanel"
                        aria-labelledby="onetime_tab">
                        <div class="col-12">
                            @if ($currentPath === 'International Bank')
                                <div class="row align-items-center mb-1">
                                    <label class="text-dark col-md-4">Bank Country</label>
                                    <div class="px-0 col-md-8"> <select class="form-control "
                                            id="onetime_select_country" required>
                                            <option disabled selected>--- Not Selected ---</option>

                                        </select></div>
                                </div>
                            @endif
                            @if ($currentPath === 'Local Bank' || $currentPath === 'International Bank')
                                <div class="row align-items-center mb-1">
                                    <label class="text-dark col-md-4  ">Transfer Bank</label>
                                    <div class="col-md-8 px-0"><select class="form-control " id="onetime_select_bank"
                                            required>
                                            <option disabled selected>--- Not Selected ---</option>

                                        </select></div>
                                </div>
                            @endif
                            <div class="form-group align-items-center row">
                                <label class="col-md-4 text-dark"> Beneficiary A/C
                                    Number</label>
                                <input type="text" class="form-control  text-input col-md-8 "
                                    id="onetime_account_number" placeholder="Enter Account Number"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>
                            @if ($currentPath === 'Same Bank')
                                <div class="form-group align-items-center row">
                                    <label class="col-md-4  text-dark"> Beneficiary A/C Name</label>
                                    <div class="input-group px-0 col-md-8" style="position: relative">
                                        <input type="text"
                                            class="form-control  text-input  onetime_beneficiary_name"
                                            placeholder="Beneficiary Name" id="onetime_beneficiary_name" disabled>
                                        <span class="spinner-grow-sm input-span  spinner-grow text-rokel-blue"
                                            role="status" id="onetime_beneficiary_name_loader"
                                            style="display: none">
                                            {{-- <span class="sr-only">Loading...</span> --}}
                                        </span>
                                    </div>
                                </div>
                            @else
                                <div class="form-group align-items-center row">
                                    <label class="col-md-4 text-dark"> Beneficiary A/C Name</label>
                                    <input type="text"
                                        class="form-control  text-input col-md-8 onetime_beneficiary_name"
                                        placeholder="Enter Beneficiary Name" id="onetime_beneficiary_name">
                                </div>
                            @endif
                            <div class="form-group align-items-center row">
                                <label class="col-md-4 text-dark"> Beneficiary Email</label>
                                <input type="text" class="form-control text-input col-md-8 "
                                    id="onetime_beneficiary_email" placeholder="Enter Beneficiary Email">
                            </div>
                            @if ($currentPath === 'Local Bank' || $currentPath === 'International Bank')
                                <div class="row align-items-center mb-1">
                                    <label class="text-dark col-md-4">Beneficiary Address</label>
                                    <input class="form-control text-input col-md-8" type="text"
                                        id="onetime_beneficiary_address" placeholder="Enter Beneficiary Address">
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            {{-- =============================================================== --}}
            {{-- Invoice Transaction --}}
            {{-- =============================================================== --}}

            <div class="col-12 display_upload_input" style="display: none">
                <div class="form-group align-items-center row">
                    <label class="col-md-4 text-dark">Attach Invoice </label>
                    <div class="input-group mb-1 col-md-8" style="padding: 0px;">

                        <div class="input-group" onclick="get_file_name('invoice_file','invoice_file_name')">

                            <div class="custom-file">
                                <input type="file" class="form-control custom-file-input" id="invoice_file">
                                <label class="custom-file-label" for="invoice_file_name"
                                    id="invoice_file_name">Choose file</label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            {{-- =============================================================== --}}
            {{-- Rest of the Form --}}
            {{-- =============================================================== --}}

            <div class="col-12">

                <div class="form-group align-items-center row">

                    <label class="col-md-4 text-dark"> Amount</label>

                    <div class="input-group mb-1 col-md-8" style="padding: 0px;">
                        <div class="input-group-prepend">
                            @if ($currentPath !== 'International Bank')
                                <input type="text" placeholder="SLL" class="input-group-text account_currency "
                                    style="width: 80px;" disabled>
                            @endif
                            @if ($currentPath === 'International Bank')
                                <select class="select2-no-search currency_select" style="width: 100px;"
                                    id="transfer_currency" required>
                                    <option value="SLL">SLL</option>
                                </select>
                            @endif
                        </div>

                        &nbsp;&nbsp;
                        {{--  <div class="input-group-prepend">  --}}
                        <input class="form-control  text-input key_transfer_amount" type="text" disabled>
                        {{--  </div>  --}}
                        <input type="text" class="form-control text-input  ml-2"
                            placeholder="Enter Amount To Transfer" id="amount"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                            required>
                        {{--  <button type="button" class="btn btn-danger  ml-2 btn-sm" data-title="Rate Calculator"
                            data-intro="Click to find and calculate FX Rate"><span
                                class="mr-1 rate_button">Rate</span><i class="fas fa-calculator"></i></button>  --}}
                    </div>
                </div>

                @if ($currentPath === 'Local Bank')
                    <div class="form-group align-items-center row">
                        <label class="text-dark col-md-4 "> Transfer Mode</label>
                        <div class="col-md-8 px-0">
                            <select class="form-control  " id="transfer_mode" required>
                                <option disabled selected> -- Select Transfer Mode --
                                </option>
                                <option value="ACH">ACH</option>
                                <option value="RTGS">RTGS</option>
                            </select>
                        </div>
                    </div>
                @endif
                @if ($currentPath === 'Standing Order')
                    <div class="form-group align-items-center row mb-3">
                        <label class=" col-md-4 text-dark">Start Date</label>
                        <input type="date" class="form-control text-input col-md-8" min="01-01-1997"
                            max="31-12-2030" id="so_start_date" required>
                    </div>
                    <div class="form-group align-items-center row mb-3">
                        <label class=" col-md-4 text-dark">End Date</label>
                        <input type="date" class="form-control text-input col-md-8" id="so_end_date" required>
                    </div>
                    <div class="form-group align-items-center row">
                        <label class="col-md-4 text-dark">Frequency</label>
                        <div class="col-md-8 px-0"> <select class=" form-control  so_frequency"
                                id="beneficiary_frequency" placeholder="Select Pick Up Branch" required>
                                <option disabled selected value="">--Select Frequency--
                                </option>
                            </select></div>
                    </div>
                @endif
                @if ($currentPath !== 'Standing Order')
                    <div class="form-group align-items-center row">
                        <label class="col-md-4 text-dark">Purpose of Transfer
                        </label>
                        <input type="text" value="{{ $currentPath }} Transfer"
                            class="form-control text-input col-md-8" id="purpose"
                            placeholder="Enter purpose of transaction" class="form-group row mb-3">
                    </div>
                @endif
                {{-- <div class="form-group align-items-center row">
                    <label class="text-dark col-4">Expense Category
                    </label>
                    <div class="col-md-8 px-0"> <select class="  " id="category" required>
                            <option disabled selected value="">-- Select expense
                                category --
                            </option>
                        </select>
                    </div>
                </div> --}}
            </div>
            @if ($currentPath == 'Local Bank')
                <div class="form-group align-items-center row bg-light p-2 "
                    style="border-radius: 5px;display: flex;justify-content: center;">

                    <i class="mdi mdi-alert-circle "></i>After 1:30pm all transactions will be processed the
                    next
                    business day.
                    {{--  <label class="col-md-6 text-dark">Transfer Type </label>
                        <div class="col-md-6">
                            <div class="radio radio-info form-check-inline">
                                <input type="radio" id="inlineRadio1" value="normal" name="trans_type" checked>
                                <label for="inlineRadio1 mt-1">Normal</label>
                            </div>
                            <div class="radio form-check-inline">
                                <input type="radio" id="inlineRadio2" value="invoice" name="trans_type">
                                <label for="inlineRadio2"> Invoice Transaction </label>
                            </div>

                        </div>  --}}
                </div>
            @endif
            <div class="form-group text-right yes_beneficiary">
                <button class="btn next-button btn-rounded form-button" type="button" id="next_button">
                    &nbsp; Next &nbsp;<i class="fe-arrow-right"></i></button>
            </div>


        </form>

    </div>
</div>
