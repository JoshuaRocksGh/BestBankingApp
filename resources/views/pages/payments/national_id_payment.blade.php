@extends('layouts.master')
@section('content')
    @php
        $pageTitle = 'NATIONAL ID';
        $basePath = 'Payments';
        $currentPath = 'National ID';
    @endphp
    @include('snippets.pageHeader')
    @include('snippets.pinCodeModal')


    <div class="px-2">
        <div class="dashboard site-card overflow-hidden">
            <div class="tab-content dashboard-body p-4">
                <div class="mx-auto  h-100 " style="max-width: 650px" id="national_id_payment">

                    <div class="col-md-12  display_airport_tax_amount">

                        <form action="#" autocomplete="off" aria-autocomplete="none" id="airport_tax_form">
                            <div class="form-group">
                                <b class=" text-dark">Account to
                                    transfer from &nbsp;
                                    <span class="text-danger">*</span> </b>


                                <select class="form-control accounts-select" id="account_of_transfer" required>
                                    <option disabled selected value=""> ---
                                        Select Source Account ---
                                    </option>
                                    @include('snippets.accounts')
                                </select>
                            </div>
                            <hr style="padding-top: 0px; padding-bottom: 0px;">

                            {{--  --}}
                            <div class="form-group ">
                                <label class="text-dark">National ID Type </label>
                                <select class="form-control pick_up_branch" id="pick_up_branch" placeholder="Select Pick Up Branch "
                                    required>
                                    <option disabled selected value="">Select National Id Type </option>
                                </select>
                            </div>

                            {{--  --}}
                            <div class="form-group ">
                                <label class=" text-dark">National ID Number</label>
                                <input class="form-control text-input" placeholder="Enter National ID Number" id="card_number" type="text"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                            </div>

                            {{--  --}}
                            <div class="form-group ">
                                <label class=" text-dark">Phone Number</label>
                                <input class="form-control text-input" placeholder="Phone Number" id="card_number" type="text"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
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
                </div>

            </div>

        </div>

    </div>
@endsection
