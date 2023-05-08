<div class="modal fade" id="change_password_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document" style="wid">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white font-18 font-weight-bold">
                    Change Password
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body p-4">

                <div id="pin_reset_area">
                    <!-- title-->
                    <!-- form -->
                    <form id="change_password_form"action="#" autocomplete="off" aria-autocomplete="off">
                        @csrf
                        <div class="form-group mb-4">
                            <label class=" text-dark"> Security Question</label>
                            {{--  <select name="" id="security_question" class="form-control">
                                <option disabled value="">---- select a service type ----</option>
                            </select>  --}}
                            {{--  <input type="text" id="" name="security_question"
                                class="form-control security_question" autocomplete="off" aria-autocomplete="off"
                                readonly>  --}}
                            <br>

                            <span class=" security_question text-danger"></span>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="">Security Answer</label>
                            <input type="text" placeholder="Enter Security Question" id="security_answer"
                                name="security_answer" class="form-control" autocomplete="off" aria-autocomplete="off"
                                required>
                            <br>
                            <label for="">Old Password</label>
                            <input type="text" placeholder="Enter Old Password" id="old_password" name="old_password"
                                class="form-control" autocomplete="off" aria-autocomplete="off" required>
                            <br>
                            <label for="">New Password</label>
                            <input type="text" placeholder="Enter New Password eg. (Qu@lity$07)" id="new_password"
                                name="new_password" autocomplete="off" class="form-control" required />
                            <br>
                            <label for="">Confirm Password</label>
                            <input type="text" placeholder="Confirm Password eg. (Qu@lity$07)"
                                id="confirm_new_password" name="new_password" autocomplete="off" class="form-control"
                                required />

                            <div class="otp-display" style="display: none">
                                {{--  <div class="text-center mb-4">Enter the OTP sent to your mobile number</div>  --}}

                                <br>
                                <label for="">Enter OTP</label>


                                <input type="text" id="change_password_otp" placeholder="Enter OTP"
                                    class="form-control" autocomplete="off" class="pincode-input">

                            </div>
                        </div>

                        <div class="modal-footer">

                            <button class="btn form-button " type="submit" id="new_password_form">Submit
                            </button>
                            <button style="display: none" type="button" id='confirm_change_password'
                                class="btn otp-display form-button">Change Password</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    const formData = new Object()
    let userId = @json(session()->get('userId'));

    $("#change_password_modal").on('hidden.bs.modal', () => {
        $(".pincode-input").pincodeInput().data('plugin_pincodeInput').clear();
        //$(".pin-change").show()
        $(".otp-display").hide()

    })
    $("#change_password_modal").on('show.bs.modal', () => {
        $('proceed_button').attr('data-current', 'pin');
        $(".pincode-input").pincodeInput({
            inputs: 4
        });



        // siteLoading("show");
        // changePin({
        //     oldPin,
        //     newPin,
        //     confirmPin,
        // }).then(() => {
        //     siteLoading("hide");
        // });

    })

    function getSecurityQuestions() {
        return $.ajax({
                type: 'get',
                url: `post-security-question-api/${userId}`,
                datatype: "application/json",
            })
            .done(({
                data
            }) => {
                if (!data) {
                    toaster("Couldn't get security questions", "warning");
                }
                // console.log("question=>", data[0]);
                $("#security_question").val(data[0]?.code)
                $("#security_question").text(data[0]?.description)
                {{--  const input = document.getElementById("security_question");
                input.value = data[0].question.code;
                input.innerHTML = data[0].question.description;  --}}
                /* data.forEach((question) => {


                     document.getElementById("security_question")
                     input.value = question.code;
                     input.value = "question.code";
                     input.innerHTML = "hello";
                 }) */
            })
    }

    $(function() {
        {{--  siteLoading("show");  --}}
        {{--  getSecurityQuestions().always(siteLoading("hide"));  --}}



        $("#new_password_form").click(function(e) {
            e.preventDefault();

            formData.securityQuestionCode = $("#security_question").val()
            formData.securityQuestionText = $("#security_question").html()
            formData.securityAnswer = $("#security_answer").val()
            formData.oldPassword = $("#old_password").val()
            formData.newPassword = $("#new_password").val()
            formData.cornfirmPassword = $("#confirm_new_password").val()
            console.log(formData)

            if (!formData.securityAnswer || !formData.oldPassword || !formData.newPassword) {
                toaster("Please complete all fields", "warning")
                return;
            }

            if (formData.cornfirmPassword == formData.newPassword) {
                if (formData.cornfirmPassword.length < 8) {

                    toaster("Password should be at least 8 characters long", "warning");

                    return false;
                }
                if (formData.cornfirmPassword.search(/[a-z]/i) < 0) {

                    toaster("Password must contain at least one lower case letter.", "warning");

                    return;
                }
                if (formData.cornfirmPassword.search(/[A-Z]/) < 0) {

                    toaster("Password must contain at least one upper case letter.",
                        "warning");

                    return;
                }
                if (formData.cornfirmPassword.search(/[0-9]/) < 0) {

                    toaster("Password must contain at least one digit.",
                        "warning");

                    return;
                }
                if (formData.cornfirmPassword.search(/[!@\$%\^&\*_]/) < 0) {

                    toaster("Password must contain a special character (! @ # $ % ^ & * _ ) ",
                        "warning");

                    return;
                }

                getOTP(124).then((data) => {
                    if (data.responseCode == "000") {
                        //siteLoading("hide");
                        //$(".pin-change").hide()
                        $("#new_password_form").hide()
                        $(".otp-display").show()


                    } else {
                        // siteLoading("hide");

                        toaster(data.message, "warning");
                    }
                })

            } else {
                toaster("Passwords do not match", "warning");
            }

            {{--  return;  --}}


        })

        $("#confirm_change_password").click(function(e) {
            e.preventDefault();
            // alert('confirm_change ==>')

            var otp = $("#change_password_otp").val()

            if (!otp) {
                toaster("Enter OTP to continue", "warning");
                return false;
            }

            //
            validateOTP(otp, 117).then((data) => {
                if (data.responseCode == "000") {
                    //console.log("verifyOTP==>", data.responseCode);
                    //console.log("changePin==>", changePin);
                    $.ajax({
                        type: 'POST',
                        url: 'change-password-api',
                        datatype: "application/json",
                        data: formData,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"),
                        },
                        success: function(response) {
                            console.log(response)
                            if (response.responseCode == "000") {
                                toaster(response.message, "success");
                            } else {
                                toaster(response.message, "error");
                            }
                        }
                    })

                } else {
                    // siteLoading("hide");

                    toaster(data.message, "error");
                    // return;
                }
                // return;
            });


        })

    })
</script>
