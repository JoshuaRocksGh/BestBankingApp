<form action="#" class="select_beneficiary" id="payment_details_form" autocomplete="off" aria-autocomplete="none">
    @csrf
    <div class="container mx-auto" style="max-width: 550px">
        <div class="form-group ">
            <label class=" text-dark">Card Number</label>
            <input class="form-control text-input" placeholder="Card Display Name" id="activate_card_number"
                type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
        </div>
        <div class="form-group" id="pay_from_account">

            <label class=" text-dark">Card Type</label>
            <select class="form-control select card_type" id="activate_card_type" required>
                <option disabled selected value="">Select Type of Card</option>
            </select>
        </div>
        <div class="form-group ">
            <label class="text-dark">Card Branch </label>
            <select class="form-control select" id="activate_card_branch" placeholder="Select Card Branch " required>
                <option disabled selected value="">Select Pick Up Branch</option>
            </select>
        </div>
        <div class="form-group text-right mt-4">
            <button type="button" class="btn form-button waves-effect waves-light" id="btn_submit_activate_card">
                Submit
            </button>
        </div>
    </div>
</form>
