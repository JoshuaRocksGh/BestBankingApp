<div class="modal fade" id="forgot_pin_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document" style="wid">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white font-18 font-weight-bold">
                    Reset pin
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>
            </div>
            <div class="modal-body p-4">

                <div id="pin_reset_area">
                    <!-- title-->
                    <p class="text-muted mb-4">Enter the required details to reset pin</p>
                    <!-- form -->
                    <form id="reset_pin_form" action="#" autocomplete="off" aria-autocomplete="off">
                        <div class="alert alert-danger text-white bg-danger" role="alert" id="error_alert"
                            style="display: none">
                        </div>
                        <div class="alert alert-warning text-white bg-warning " role="alert" id="no_question"
                            style="display: none">
                        </div>
                        <div class="alert alert-success bg-success text-white" role="alert" id="reset_success"
                            style="display: none">
                        </div>
                        <div class="form-group" id="security_question_form">
                            <label for="security_question_answer" id="security_question">Security Question</label>
                            <br>

                            <span class=" security_question text-danger"></span>
                            <input type="text" id="security_question_answer" name="security_question_answer"
                                class="form-control" autocomplete="off" aria-autocomplete="off">
                            <input type="text" id="security_question_code" autocomplete="new-pin" hidden>
                            <br>
                            <label for="security_question_answer">New Pin</label>
                            <input type="pin" placeholder="Enter New Pin" id="reset_pin" name="reset_pin"
                                class="form-control" autocomplete="off" aria-autocomplete="off">
                            <br>
                            <label for="security_question_answer">Confirm Pin</label>
                            <input type="pin" placeholder="Confirm Pin" id="reset_confirm_pin"
                                name="reset_confirm_pin" autocomplete="new-pin" class="form-control" />
                        </div>
                    </form>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-dark" type="button" id="user_id_next_btn">
                    <span class="user_id_next_btn_text">Next</span>
                    <span class="spinner-border spinner-border-sm mr-1 spinner-text-next" style="display: none"
                        role="status" aria-hidden="true"></span>
                    <span class="spinner-text-next" style="display: none">Loading</span>
                </button>
                <button class="btn form-button " style="display: none" type="button" id="security_question_submit">
                    <span id="security_question_submit_text">Submit</span>
                    <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"
                        id="submit_spinner" style="display: none"></span>
                </button>
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button"
                    class="btn btn-primary btn-rounded waves-effect waves-light disappear-after-success"
                    id="proceed_button">
                    Submit
                </button> --}}
            </div>
        </div>
    </div>
</div>
