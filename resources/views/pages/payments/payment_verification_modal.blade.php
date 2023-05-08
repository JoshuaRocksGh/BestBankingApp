<!-- Modal -->
<style>
    .detail-card {
        border-radius: 15px;
        border: 1px var(--danger) solid;
        /* box-shadow: 2px 2px 1px #d3d3d3; */
    }

    .total {
        /* box-shadow: 2px 2px 1px var(--primary); */
        border: none;
    }

    .d-item {
        display: flex;
        padding: 2px 0px;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    .d-item span {
        font-size: 14px;
    }
</style>
<div class="modal fade" id="payment_verification_modal" tabindex="-1" role="dialog"
    aria-labelledby="payment_verification_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="max-width: 900px;">
            <div class="modal-header bg-danger">
                <div class="close mx-0">
                    <span aria-hidden="true"></span>
                </div>
                <h5 class="modal-title mx-auto font-weight-bold font-15 text-white text-uppercase">Payment summary
                </h5>
                <button type="button" class="close mx-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">X</span>
                </button>
            </div>
            <div class="modal-body font-14 p-3">
                {{-- <div class='mx-3 py-3 row justify-content-center mb-1 detail-card'>
                    <div class='account-icon'><span id="details_icon_text">A</span></div>
                    <div class='ml-3'>
                        <div class='font-16 font-weight-bold' id="details_recipient_name"></div>
                        <div class='font-14 text-center' id="details_recipient_number"></div>
                    </div>
                </div> --}}
                <div class='mx-3 px-3 py-3 mb-2 detail-card'>
                    {{-- <div class='font-14 py-2 font-weight-bold text-primary'>Details</div> --}}
                    <div class="d-item">
                        <span> From</span><span class="font-weight-bold" id="details_from_account"> </span>
                    </div>
                    <div class="d-item">
                        <span class="details_to_account"> Recipient Name</span><span class="font-weight-bold details_to_account" id="details_to_account"> </span>

                    </div>
                    <div class="d-item">
                        <span>Recipient Account</span><span class="font-weight-bold" id="details_recipient_number">
                        </span>

                    </div>
                    <div class="d-item display_dycar" style="display: none">
                        <span> Meter Address</span><span class="font-weight-bold" id="details_meter_address"> </span>
                    </div>
                    <div class="d-item">
                        <span> Amount</span><span class="font-weight-bold" id="details_amount"> </span>
                    </div>
                    <div class="d-item">
                        <span> Narration</span><span class="font-weight-bold" id="details_narration"> </span>

                    </div>
                    <div class="d-item">
                        <span> Expense Type</span><span class="font-weight-bold" id="details_expense_type"> </span>
                    </div>
                    <div class="d-item display_dycar" style="display: none">
                        <span>Meter Balance</span><span class="font-weight-bold" id="details_meter_balance"> </span>
                    </div>


                    <div class="d-item display_dycar" style="display: none">
                        <span> Last Meter Amount</span><span class="font-weight-bold" id="details_last_meter_amount"> </span>
                    </div>
                    {{-- <div class="d-item display_dycar" style="display: none">
                        <span> Prepaid Debt</span><span class="font-weight-bold" id="details_prepaid_debt"> </span>
                    </div> --}}
                    <div class="d-item">
                        <span> Transaction Fee</span><span class="font-weight-bold" id="details_trans_fee"> </span>
                    </div>
                    @if (!config('app.corporate'))
                        <div class="d-item">
                            {{--  <span class="text-danger"> Enter OTP</span>  --}}
                            <input type="text" class="form-control text-input" id="transfer_otp"
                                placeholder="Enter OTP"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                required />
                        </div>
                    @endif


                </div>
                <div class='mx-3 px-3 py-1 detail-card total bg-info'>
                    <div class="d-item text-white my-1 font-weight-bold">
                        <span> TOTAL</span><span id="details_total_amount">SLL xxx</span>

                    </div>
                </div>
                <div class="alert mx-3 font-11 mb-1 px-3 rounded mt-4 alert-primary" role="alert">
                    <i class="fas font-13 alert-link mr-1 fa-exclamation-circle"></i> <span>By proceeding you agree to
                        abide by our terms and conditions</span>
                </div>
                <div class='mx-3'>
                    <button type="button" data-dismiss="modal" id="confirm_transfer_button"
                        class="btn font-weight-bold btn-block btn-rounded py-2 mb-4 form-button">PROCEED</button>
                </div>

            </div>
        </div>
    </div>
</div>
