<form action="#" class="select_beneficiary" id="payment_details_form" autocomplete="off" aria-autocomplete="none">
    @csrf
    <div class="container mx-auto" style="max-width: 550px">
        <div class="form-group ">
            <label class="text-dark"> Beneficiary Name</label>
            <input class="form-control text-input" placeholder="Name Of Beneficiary" id="beneficiaryName"
                type="text" />
        </div>
        <div class="form-group ">
            <label class=" text-dark"> Cheque Amount</label>
            <input class="form-control text-input" placeholder="Cheque Amount" type="text" id="chequeAmount" />
        </div>
        <div class="form-group align-items-center ">

            <label class=" text-dark">Salary Advance Amount</label>

            {{--  <div class="input-group mb-1" style="padding: 0px;">
                <div class="input-group-prepend">
                    <input type="text" placeholder="" value="SLE" class="input-group-text account_currency "
                        style="width: 40%;" disabled>
                </div>

                &nbsp;&nbsp;
                <input class="form-control  text-input key_transfer_amount" type="text"  disabled>

                <input type="text" class="form-control text-input  " placeholder="Enter Amount " id="amount"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                     required>

            </div>  --}}
        </div>
        <div class="form-group  mb-3" id="pay_from_account">

            <label class=" text-dark">Date Issued</label>

            <input class="form-control text-input" type="date" id="issueDate" />
        </div>
        <div class="form-group row align-items-end ">
            <div class="col-6"><label class="text-dark">Start Cheque No.</label>
                <input class="form-control text-input" placeholder="Start Cheque No." type="text" id="startCheque" />
            </div>
            <div class="col-6">
                <label class="text-dark">End Cheque No</label>
                <input class="form-control text-input" placeholder="End Cheque No." type="text" id="endCheque" />
            </div>
        </div>


        <div class="form-group text-right mt-4">
            <button type="button" class="btn form-button waves-effect waves-light" id="btn_submit_cheque_block">
                Submit
            </button>
        </div>
    </div>
</form>
