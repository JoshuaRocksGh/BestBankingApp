<style>
    .modal-footer button {
        width: 5rem;
    }

    #payment_type_image {
        background-position: center;
        background-size: contain;
        transition: all .5s ease-in-out;
        border-radius: 10px;
        height: 80px;
        width: 120px;
        background-image: url("assets/images/add.png");
        box-shadow: rgb(0 0 0 / 53%) 3px 3px 0px;
    }
</style>

<div class="modal fade" id="edit_modal" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-danger" id="beneficiary_form_header">
                <h5 class="modal-title text-white text-capitalize font-weight-bold" id="beneficiary_form_title">
                    Beneficiary Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">X</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center mt-2 mb-4">
                    <div id="payment_type_image">
                        {{-- <h3 class="font-16 font-weight-bold">Beneficiary
                            Info</h3> --}}
                    </div>
                </div>
                <form class="mx-2">
                    <div class="row mb-2">
                        <label class="col-md-12 font-14 text-capitalize " id="subtype_label">
                        </label>
                        <div class="col-md-12">
                            <select class="form-control " id="payment_subtype" placeholder="--- Not Selected ---">
                            </select>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-12 font-14 text-capitalize" id="payment_label"></label>
                        <div class="col-12">
                            <input type="number" class="form-control" id="payment_label_input" placeholder="">
                        </div>

                    </div>
                    <div class="row mb-2" id="account_name_display">
                        <label class="col-12 font-14 text-capitalize">Name:</label>
                        <div class="col-12">
                            <input type="text" class="form-control" id="beneficiary_name"
                                placeholder="Enter beneficiary name">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <h4 class="col-12 text-danger">Enter Otp:</h4>
                        <div class="col-12">
                            <input type="text" class="form-control" id="beneficiary_otp" placeholder="Enter Otp"
                                minlength="1" maxlength="4"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                required>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="delete_btn">Delete</button>

                <button type="button" class="btn form-button mx-2" id="save_btn">Save</button>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/pages/payments/paymentBeneficiaryForm.js"></script>
