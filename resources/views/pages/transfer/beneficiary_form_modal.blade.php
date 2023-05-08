{{-- @include('extras.selectize') --}}
<style>
    .modal-footer button {
        width: 6rem;
    }

    .modal-dialog {
        max-width: 600px !important;
    }

    .wizard-header {
        border: 1px solid #bfc9d4;
        background-color: transparent;
        font-weight: 600;
        font-size: 15px;
        margin-right: 6px;
        border-radius: 33px;
        text-decoration: none;
        padding: 9px 10px;
    }

    .wizard-header.active {
        background-color: var(--primary);
        color: #ffffff;
        border: none
    }
</style>

<div class="modal fade" id="edit_modal" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-danger" id="beneficiary_form_header">
                <h5 class="modal-title font-18 py-1 text-center text-white text-capitalize font-weight-bold"
                    id="beneficiary_form_title">
                    Beneficiary Form</h5>
                <button type="button" class="close align-self-center text-white" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>
            </div>
            {{-- <div id="edit_modal_content"> --}}
            <div class="modal-body p-3 ">

                {{-- form body start --}}
                <div class="card mb-0">

                    <form class="p-2 p-md-3" id="beneficiary_form">
                        <fieldset class="mb-3">
                            <div class="form-group row international-bank-form" style="display: none">
                                <label class="col-md-4"> Select Country:</label>
                                <div class="col-md-8">
                                    <select class="form-control " id="select_country" required>
                                        <option selected disabled value=""> --- Select Country ---</option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row other-bank-form international-bank-form" style="display: none">
                                <label class="col-md-4"> Select Bank:</label>
                                <div class="col-md-8">
                                    <select class="form-control" data-container="body" id="select_bank">
                                        <option selected disabled value=""> --- Select Bank ---</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4">Account Number:</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="account_number"
                                            placeholder="Enter Account Number" minlength="9" maxlength="30">
                                        <div class="input-group-append" id="account_number_search"
                                            style="display: none">
                                            <button class="btn btn-primary" type="button"> <i
                                                    class="fas fa-search"></i> </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row " id="account_name_display">
                                <label class="col-md-4">Account Name:</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="account_name"
                                        placeholder="Account Name" disabled minlength="2" maxlength="30">
                                </div>
                            </div>
                            <div class="form-group row same-bank-form" id="account_currency_display"
                                style="display:none">
                                <label class="col-md-4">Account Currency:</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="account_currency"
                                        placeholder="Account Currency" disabled minlength="1" maxlength="15">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="form-group row ">
                                <label class="col-4"> Alias:</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="beneficiary_name"
                                        placeholder="Enter Beneficiary Name">
                                </div>
                            </div>

                            <div class="form-group row other-bank-form international-bank-form" style="display: none">
                                <label class="col-4">Email:</label>
                                <div class="col-8">
                                    <input type="email" class="form-control" id="beneficiary_email"
                                        placeholder="Enter Beneficiary Email">
                                </div>
                            </div>
                            <div class="form-group row other-bank-form international-bank-form" style="display: none">
                                <label class="col-4">Address:</label>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="beneficiary_address"
                                        placeholder="Enter Beneficiary Address" minlength="3" maxlength="30">
                                </div>
                            </div>
                            <div class="form-group row  ">
                                <h4 class="col-4 text-danger">Enter Otp:</h4>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="beneficiary_otp"
                                        placeholder="Enter Otp" minlength="1" maxlength="4"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                        required>
                                </div>
                            </div>
                        </fieldset>

                        <div class="checkbox checkbox-primary mb-2 text-center mt-3" id="transfer_email">
                            <input id="send_email_check" type="checkbox">
                            <label for="send_email_check">
                                Email beneficiary when a transfer is made
                            </label>
                            <i tabindex="0" class="ml-1 fas fa-info-circle bs-popover" data-container="body"
                                role="popover" data-toggle="popover" data-trigger="hover"
                                data-content=" Providing beneficiary email and checking
                                                the box, enables us to send an alert mail to
                                                the beneficiary each time a transfer is made"></i>
                        </div>

                    </form>

                </div>
                {{-- form body end --}}

            </div>
            <div class="modal-footer px-3 pb-3 pt-0 justify-content-between">
                <button type="submit" class="btn btn-secondary" id="delete_btn"><i
                        class="fas fa-trash-alt mr-1"></i>Delete</button>

                <button type="button" class="btn btn-dark action-button" id="save_btn"> <i
                        class="fas mr-1 fa-save"></i>
                    Save</button>

            </div>

        </div>
    </div>
    <span id="beneficiary_modal_backup" hidden disabled style="display: none"></span>
</div>
<script src="assets/js/pages/transfer/beneficiary/beneficiaryForm.js"></script>
<script src="assets/js/pages/transfer/beneficiary/saveBeneficiary.js"></script>
{{-- <script src="assets/js/functions/validateEmail.js"></script> --}}
