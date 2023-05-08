<!-- Modal -->
<div class="modal fade" id="change_transaction_pin_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white font-18 font-weight-bold">Change Transaction Pin</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>
            </div>
            <div class="modal-body pb-4">
                <div class="text-center"> <img style="height: 150px"
                        src="{{ asset('assets/images/placeholders/transaction_pin.svg') }}" />

                    <div class="form-group row hide_sec_question">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <label class=" text-dark"> Security Question</label>
                            <br>

                            <span class=" security_question text-danger"></span>
                            <br>
                            <input type="text" id="change_pin_sec_question" name="change_pin_sec_question"
                                class="form-control" autocomplete="off" aria-autocomplete="off">
                            <input type="text" id="change_pin_sec_question_code" name="change_pin_sec_question_code"
                                class="form-control" autocomplete="off" aria-autocomplete="off" style="display:none">


                        </div>

                        <div class="col-md-2"></div>

                    </div>
                    <div class="pin-change">

                        <div class="text-center mb-4">Your new PIN must be different from your current pin</div>
                        <div class="text-left font-weight-bold mx-auto mt-2" style="max-width: 250px">
                            Enter Old Pin
                            <input type="text" id="old_pin" class="pincode-input">

                        </div>
                        <div class="text-left font-weight-bold mx-auto mt-2" style="max-width: 250px">
                            Enter New Pin
                            <input type="text" id="new_pin" class="pincode-input">

                        </div>
                        <div class="text-left font-weight-bold mx-auto mt-2" style="max-width: 250px">
                            Confirm New Pin
                            <input type="text" id="confirm_new_pin" class="pincode-input">
                        </div>
                    </div>
                    <div class="otp-display" style="display: none">
                        <div class="text-center mb-4">Enter the OTP sent to your mobile number</div>
                        <div class="text-left font-weight-bold mx-auto mt-2" style="max-width: 250px">
                            Enter OTP
                            <input type="text" id="otp" class="pincode-input">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id='change_pin_proceed_button'
                    class="btn pin-change form-button">Proceed</button>
                <button style="display: none" type="button" id='confirm_change'
                    class="btn otp-display form-button">Change Pin</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    const changePin = {};

    function getSecurityQuestions(user) {
        alert("called")

        return $.ajax({
                type: 'get',
                url: `post-security-question-api/${user}`,
                datatype: "application/json",
            })
            .done(({
                data
            }) => {
                if (!data) {
                    toaster("Couldn't get security questions", "warning");
                }
                // console.log("change transaction question=>", data[0]);
                $(".security_question").val(data[0]?.code)
                $(".security_question").text(data[0]?.description)
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


    {{--  const changePin = (
        oldPin,
        newPin,
        confirmPin,
        sec_answer
    ) => {
        return $.ajax({
            type: "POST",
            url: "change-pin-api",
            datatype: "application/json",
            data: {
                oldPin,
                newPin,
                confirmPin,
                sec_answer
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        }).done((response) => {
            console.log(response);
            if (response.responseCode == "000") {
                toaster(response.message, "success");
            } else {
                toaster(response.message, "error");
            }
        });
    };  --}}
    $("#change_transaction_pin_modal").on('hidden.bs.modal', () => {
        $(".pincode-input").pincodeInput().data('plugin_pincodeInput').clear();
        $(".pin-change").show()
        $(".otp-display").hide()

    })
    $("#change_transaction_pin_modal").on('show.bs.modal', () => {
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


    $(function() {
        {{--  var customer_no = @json(session('customerNumber'))
        console.log("customer_no ==>", customer_no)  --}}

        var user = @json(session()->get('userId'));

        getSecurityQuestions(user)

        $("#change_pin_proceed_button").on("click", () => {
            {{--  alert("clicked")
            return;  --}}


            const oldPin = $("#old_pin").val();
            const newPin = $("#new_pin").val();
            const confirmPin = $("#confirm_new_pin").val();
            const sec_answer = $("#change_pin_sec_question").val();


            console.log({
                oldPin,
                newPin,
                confirmPin,
                sec_answer
            });


            if (!oldPin || !newPin || !confirmPin || !sec_answer) {
                toaster("Please enter all fields", "warning");
                return false;
            }
            if (newPin !== confirmPin) {
                toaster("New pin and confirm pin do not match", "warning");
                return false;
            }
            if (newPin.length !== 4) {
                toaster("Please enter a valid pin code", "warning");
                return false;
            }

            changePin.oldPin = oldPin
            changePin.newPin = newPin
            changePin.confirmPin = confirmPin
            changePin.sec_answer = sec_answer

            getOTP(117).then((data) => {
                if (data.responseCode == "000") {
                    //siteLoading("hide");
                    $(".pin-change").hide()
                    $(".hide_sec_question").hide()
                    $(".otp-display").show()


                } else {
                    // siteLoading("hide");

                    toaster(data.message, "warning");
                }
            })


        });

        // --------------------------------
        $("#confirm_change").on('click', () => {
            var otp = $("#otp").val()

            if (!otp) {
                toaster("Enter OTP to continue", "warning");
                return false;
            }

            //
            validateOTP(otp, 117).then((data) => {
                if (data.responseCode == "000") {
                    console.log("verifyOTP==>", data.responseCode);
                    console.log("changePin==>", changePin);
                    // return;);

                    //changePin()
                    // $("#pin_code_modal").modal("show");
                    // siteLoading("hide");

                    //saveBeneficiary(beneficiaryDetails);
                    // return;
                    return $.ajax({
                        type: "POST",
                        url: "change-pin-api",
                        datatype: "application/json",
                        data: changePin,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"),
                        },
                    }).done((response) => {
                        console.log(response);
                        if (response.responseCode == "000") {
                            toaster(response.message, "success");
                        } else {
                            toaster(response.message, "error");
                        }
                    });
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
