var deviceType = getDeviceType();
var deviceOS = getDeviceOS();
var deviceID = getGPU();
function login(email, password) {
    console.log(email, password);
    // return false;
    $.ajax({
        type: "POST",
        url: "login-api",
        datatype: "application/json",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            deviceOS: deviceOS,
            deviceType: deviceType,
            deviceID: deviceID,
            user_id: email,
            password: password,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },

        success: function (response) {
            // console.log("login response =>", response);
            // console.log(
            //     "login response.responseCode =>",
            //     response.responseCode
            // );
            // return false;
            // $("#submit").attr("disabled", false);

            if (response.responseCode == "000") {
                console.log("login response =>", response.responseCode);

                if (response.data.firstTimeLogin == true) {
                    window.location = "change-password";
                    $("#submit").attr("disabled", true);
                } else {
                    // getOTP(103).then((data) => {
                    //     console.log("cget otp==>", data);
                    //     if (data.responseCode == "000") {
                    //         $("#login_form").hide(500);
                    //         $("#enter_otp").show(500);
                    //     } else {
                    //         $("#spinner").hide();
                    //         $("#spinner-text").hide();
                    //         $("#log_in").show();
                    //         error_alert(data.message, "#failed_login");
                    //     }
                    //     return;
                    // });

                    // console.log("get OTP ==>", OtpData);

                    // console.log("login response => home");
                    // return;

                    window.location = "home";
                    $("#submit").attr("disabled", true);
                }
            } else {
                $("#submit").attr("disabled", false);
                $("#spinner").hide();
                $("#spinner-text").hide();
                $("#log_in").show();
                error_alert(response.message, "#failed_login");
            }
        },
        error: function (xhr, status, error) {
            // $("#submit").attr("disabled", true);
            $("#submit").attr("disabled", false);
            $("#spinner").hide();
            $("#spinner-text").hide();
            $("#log_in").show();
            // location.reload();
            error_alert(xhr.responseText, "#failed_login");
            console.log("Ajax request failed...");
            console.log("Ajax request failed...", xhr.status);
            console.log("Ajax request failed...", xhr.responseText);
        },
    });
}

function error_alert(message, targetId) {
    $(targetId).text(message);
    $(targetId).show(200);
    setTimeout(() => {
        $(targetId).hide(200);
    }, 3000);
}

function success_alert(message, targetId) {
    $(targetId).text(message);
    $(targetId).show(200);
    setTimeout(() => {
        $(targetId).hide(200);
    }, 3000);
}

function validateCustomer(userData) {
    $.ajax({
        type: "POST",
        url: "validate-customer",
        datatype: "application/json",
        data: {
            customerNumber: userData.customerNumber,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    })
        .done((response) => {
            if (response.responseCode === "000") {
                success_alert(response.message, "#successful_self_enroll");
                setTimeout(() => {
                    $("#self_enroll_form1").hide();
                    $("#self_enroll_form2").toggle("500");
                }, 3000);

                $("#id_number_input").attr(
                    "placeholder",
                    `Enter your ID number: ${response.data.idType}`
                );

                // console.log(response);
                userData.authToken = response.data.authToken;
            } else {
                error_alert(response.message, "#self_enroll_message");
                $("#s_loading1").toggle();
                $("#s_next1").show();
                $("#b_next1").attr("disabled", false);
                return false;
            }
        })
        .fail(() => {
            $("#s_loading1").toggle();
            $("#s_next1").show();
            $("#b_next1").attr("disabled", false);
            error_alert("Connection Error", "#self_enroll_message");
        });
}

function confirmCustomer(userData) {
    $.ajax({
        type: "POST",
        url: "confirm-customer",
        datatype: "application/json",
        data: userData,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    })
        .done((response) => {
            if (response.responseCode === "000") {
                // console.log("confirmation successful");
                // console.log(response);
                success_alert(response?.message, "#successful_self_enroll");
                setTimeout(() => {
                    $("#self_enroll_form2").hide();
                    $("#s_loading2").toggle();
                    $("#self_enroll_form3").toggle(500);
                }, 3000);
            } else {
                error_alert(response?.message, "#self_enroll_message");
                $("#s_loading2").toggle();
                $("#s_next2").show();
                $("#b_next2").attr("disabled", false);
                return false;
            }
        })
        .fail(() => {
            $("#s_loading2").toggle();
            $("#s_next2").show();
            $("#b_next2").attr("disabled", false);
            error_alert("Connection Error", "#self_enroll_message");
        });
}

function registerCustomer(userData) {
    // console.log("b_next3 ==>", userData);
    // return;
    $.ajax({
        type: "POST",
        url: "register-customer",
        datatype: "application/json",
        data: userData,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    })
        .done((response) => {
            if (response.responseCode === "000") {
                // console.log(response.message);
                success_alert(response.message, "#successful_self_enroll");
                setTimeout(() => {
                    $("#one_time_input_area").hide(300);

                    window.location = "login";

                    // $("#self_enroll_form2").hide();
                    // $("#s_loading2").toggle();
                    // $("#self_enroll_form3").toggle(500);
                }, 5000);
                // $("#self_enroll_message").text(response.message);
                // $("#self_enroll_message").toggleClass(
                //     "alert-danger alert-success bg-danger bg-success"
                // );
                // $("#self_enroll_message").show;

                // setTimeout(() => {}, 3000);
            } else {
                error_alert(response.message, "#self_enroll_message");
                $("#s_next3").show();
                $("#s_loading3").toggle();
                $("#b_next3").attr("disabled", false);
                return false;
            }
        })
        .fail(() => {
            $("#s_loading3").toggle();
            $("#s_next3").show();
            $("#b_next3").attr("disabled", false);
            error_alert("Connection Error", "#self_enroll_message");
        });
}

function getSecurityQuestion(resetUserId) {
    $.ajax({
        type: "GET",
        url: "post-security-question-api/" + resetUserId,
        datatype: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            console.log("getSecurityQuestion ==>", response);
            // return;
            if (response.responseCode == 000) {
                success_alert(response.message, "#reset_success");

                let securityQuestion = response?.data[0]?.description;
                let securityQuestionCode = response?.data[0]?.code;
                $("#security_question").text(securityQuestion);
                $("#security_question_answer").attr(
                    "securityQuestionCode",
                    securityQuestionCode
                );
                $("#security_question_answer").attr(
                    "placeholder",
                    securityQuestion
                );
                getLoginOTP(116, resetUserId).then((data) => {
                    console.log("cget otp==>", data);
                    // return;
                    if (data.responseCode == "000") {
                        setTimeout(function () {
                            // $("#security_question_form").toggle(500);
                            // $("#security_question_submit").show();
                            // $(".security_question_submit_spinner").hide();
                            // $("#security_question_otp_submit").hide();
                            // $("#reset_password_submit_btn").hide();
                            // $("#user_id_next_btn").hide();
                            // $("#password_verification").hide();
                            // $("#user_id_view").hide();
                            // $("#password_verification").hide();

                            // CALL GET OP INSTEAD
                            $("#security_question_otp").toggle();
                            $("#security_question_otp_submit").toggle();
                            $(".otp_submit_spinner").hide();
                            $("#user_id_view").hide();
                            $("#user_id_next_btn").hide();
                        }, 3000);
                    } else {
                        setTimeout(function () {
                            error_alert(data.message, "#no_question");
                        }, 3000);

                        // $("#user_id_next_btn").attr("disabled", false);
                        // $(".spinner-text-next").hide();
                        // $(".user_id_next_btn_text").show();
                    }
                    return;
                });
            } else {
                error_alert(response.message, "#no_question");
                $("#user_id_next_btn").attr("disabled", false);
                $(".spinner-text-next").hide();
                $(".user_id_next_btn_text").show();
                // $("#user_id_next_btn").hide();
            }
        },
        error: function (xhr, status, error) {
            error_alert("please check your connection", "#no_question");
            $("#user_id_next_btn").attr("disabled", false);
            $(".spinner-text-next").hide();
            $(".user_id_next_btn_text").show();
        },
    });
}

function submitSecurityQuestion(userData) {
    $.ajax({
        type: "POST",
        url: "forgot-password-api",
        datatype: "application/json",
        data: {
            security_answer: userData.securityQuestionAnswer,
            password: userData.newPassword,
            security_question: userData.securityQuestionCode,
            user_id: userData.resetUserId,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            console.log(response.message);
            response.message;
            if (response.responseCode == 000) {
                // $("#security_question_otp_submit").attr("disabled", false);
                success_alert(response.message, "#reset_success");

                setTimeout(function () {
                    // $("#security_question_form").hide();
                    // $("#security_question_otp").show();
                    // $("#security_question_otp_submit").show();
                    // $("#security_question_submit").hide();
                    // $(".otp_submit_spinner").hide();
                    location.reload();
                }, 3000);

                return;

                $("#security_question_submit").attr("disabled", false);
                $("#submit_spinner").hide();
                $("#security_question_submit_text").show();
                setTimeout(function () {
                    // window.location.replace("/");
                    location.reload();
                }, 2000);
            } else {
                error_alert(response.message, "#error_alert");
                $("#security_question_submit").attr("disabled", false);
                $("#submit_spinner").hide();
                $("#security_question_submit_text").show();
            }
        },
    });
}

// Set the amount of time (in milliseconds) before the user is considered inactive
var inactivityTime = 180000; // 5 mins

// Set a timer that will trigger after the specified amount of time
var timeoutId = setTimeout(function () {
    // This code will execute when the user has been inactive for the specified amount of time
    //  console.log("User is inactive");
    location.reload();
}, inactivityTime);

// Add event listeners to detect when the user interacts with the page
$(document).on("mousemove keydown", function () {
    // If the user interacts with the page, reset the timer
    clearTimeout(timeoutId);
    timeoutId = setTimeout(function () {
        // console.log("User is inactive.......");
        location.reload();
    }, inactivityTime);
});

$(document).ready(function () {
    const userData = new Object();
    // setInterval(function() {
    //     var csrfToken = generateCsrfToken(); // replace this with your own function to generate the CSRF token
    //     document.getElementById('csrf-token').value = csrfToken;
    //   }, 60000); // update the token every 60 seconds (or change this to your desired interval)

    $("#submit").on("click", function (e) {
        e.preventDefault();
        var email = $("#user_id").val();
        var password = $("#password").val();

        if (!email) {
            error_alert("Please enter email", "#failed_login");
        } else if (!password) {
            error_alert("Please enter password", "#failed_login");
        } else {
            $("#spinner").show();
            $("#spinner-text").show();
            $("#log_in").hide();
            $("#submit").attr("disabled", true);

            // if its not co
            // return;
            login(email, password);
        }
    });

    $("#forgot_password").on("click", (e) => {
        e.preventDefault();
        $("#login_form").hide(500);
        $("#password_reset_area").show(500);
    });

    $("#verify_otp_button").click(function (e) {
        e.preventDefault();
        var otp = $("#enter_otp_input").val();

        if (!otp) {
            error_alert("Please enter otp", "#display_otp_error");
            return;
        }

        $(".submit_otp_button").hide();
        $(".spinner-text-next").show();
        $("#verify_otp_button").attr("disabled", true);

        validateOTP(otp, 103).then((data) => {
            console.log("verifyOTP==>", data);
            if (data.responseCode == "000") {
                window.location = "home";
                $("#verify_otp_button").attr("disabled", true);

                // $("#submit").attr("disabled", true);
            } else {
                $(".submit_otp_button").show();
                $(".spinner-text-next").hide();
                $("#verify_otp_button").attr("disabled", false);

                // $(".submit_otp_button").show();
                // $(".spinner-text-next").hide();
                // $("#log_in").show();
                error_alert(data.message, "#display_otp_error");
            }
            return;
        });

        // console.log("get OTP ==>", OtpData);

        // console.log("login response => home");
        return;

        // window.location = "home";
        // $("#submit").attr("disabled", true);
    });

    $("#user_id_next_btn").on("click", (e) => {
        userData.resetUserId = $("#reset_user_id").val();
        e.preventDefault();
        let { resetUserId } = userData;
        if (!resetUserId) {
            error_alert("Enter User Id", "#no_question");
            return false;
        }
        $("#user_id_next_btn").attr("disabled", true);
        $(".spinner-text-next").show();
        $(".user_id_next_btn_text").hide();
        // return;
        getSecurityQuestion(resetUserId);
    });

    $("#security_question_otp_submit").on("click", (e) => {
        e.preventDefault();
        var userOTP = $("#reset_user_id_otp").val();
        // console.log(userOTP);
        if (!userOTP) {
            error_alert("Enter Valid Otp", "#no_question");
            return;
        }

        // return;

        $("#security_question_otp_submit").attr("disabled", true);
        $(".otp_submit_spinner").show();

        $("#security_question_otp_submit_text").hide();

        validateLoginOTP(userOTP, 116, userData.resetUserId).then((data) => {
            console.log("verifyOTP==>", data);
            if (data.responseCode == "000") {
                success_alert(data.message, "#reset_success");

                // getSecurityQuestion(resetUserId);
                // $("#submit").attr("disabled", true);
                // =================================================================
                //
                // ============================
                setTimeout(function () {
                    $("#security_question_form").toggle(500);
                    $("#security_question_submit").show();
                    $(".security_question_submit_spinner").hide();
                    $("#security_question_otp_submit").hide();
                    $("#reset_password_submit_btn").hide();
                    $("#user_id_next_btn").hide();
                    // $("#password_verification").hide();
                    $("#user_id_view_otp").hide();
                    $("#reset_user_id_otp").hide();
                    $("#security_question_otp").hide();
                }, 3000);
                return;
            } else {
                $("#security_question_otp_submit").attr("disabled", false);
                $("#security_question_otp_submit_text").show();
                $(".otp_submit_spinner").hide();
                // $(".submit_otp_button").show();
                // $(".spinner-text-next").hide();
                // $("#verify_otp_button").attr("disabled", false);

                // $(".submit_otp_button").show();
                // $(".spinner-text-next").hide();
                // $("#log_in").show();
                error_alert(data.message, "#no_question");
            }
            return;
        });
    });

    $("#security_question_submit").on("click", (e) => {
        userData.securityQuestionAnswer = $("#security_question_answer").val();
        userData.newPassword = $("#reset_password").val();
        if (!userData.securityQuestionAnswer) {
            error_alert("Enter Answer to security Question", "#no_question");
            return false;
        } else if (!userData.newPassword || userData.newPassword.length < 8) {
            error_alert(
                "Password should be at least 8 characters long",
                "#no_question"
            );
            return false;
        } else if (
            userData.newPassword !== $("#reset_confirm_password").val()
        ) {
            error_alert("Passwords do not match", "#no_question");
            return false;
        }

        if (userData.newPassword.search(/[a-z]/i) < 0) {
            error_alert(
                "Password must contain at least one lower case letter.",
                "#no_question"
            );
            return;
        }
        if (userData.newPassword.search(/[A-Z]/) < 0) {
            error_alert(
                "Password must contain at least one upper case letter.",
                "#no_question"
            );
            return;
        }
        if (userData.newPassword.search(/[0-9]/) < 0) {
            error_alert(
                "Password must contain at least one digit.",
                "#no_question"
            );
            return;
        }
        if (userData.newPassword.search(/[!@#\$%\^&\*_]/) < 0) {
            error_alert(
                "password must contain a special character (! @ # $ % ^ & * _ ) ",
                "#no_question"
            );
            return;
        }
        // if (errors.length > 0) {
        //     alert(errors.join("\n"));
        //     return false;
        // }
        // return;
        userData.securityQuestionCode = $("#security_question_answer").attr(
            "securityQuestionCode"
        );
        // console.log(userData);
        $("#security_question_submit").attr("disabled", true);
        $(".security_question_submit_spinner").show();
        $("#security_question_submit_text").hide();
        submitSecurityQuestion(userData);
    });

    $("#self_enroll").on("click", function (e) {
        e.preventDefault();
        $("#login_form").hide(500);
        // $("#login_page_extras").toggle(300);
        $("#self_enroll_form2").hide();
        $("#self_enroll_form3").hide();
        $("#s_loading1").hide();
        $("#s_loading2").hide();
        $("#s_loading3").hide();
        $("#self_enroll_form").toggle(300);
        $("#customer_number_input").focus();
        return false;
    });

    $("#login_instead").on("click", function (e) {
        e.preventDefault();

        $("#self_enroll_form").hide();
        $("#login_form").toggle(300);
        // $("#login_page_extras").toggle(300);
        return false;
    });
    $("#b_next1").on("click", function (e) {
        e.preventDefault;

        userData.customerNumber = $("#customer_number_input").val();
        if (!userData.customerNumber) {
            error_alert("Customer Number is required", "#self_enroll_message");

            return false;
        } else if (userData.customerNumber.length !== 6) {
            error_alert("Invalid customer number", "#self_enroll_message");
            return false;
        } else {
            $("#s_next1").hide();
            $("#s_loading1").toggle();
            $("#b_next1").attr("disabled", true);
            validateCustomer(userData);
        }
    });

    $("#b_next2").on("click", function (e) {
        console.log(userData);
        e.preventDefault;
        let dob = $("#date_of_birth_input").val();
        if (!dob) {
            error_alert("Please enter date of birth", "#self_enroll_message");
            return false;
        }
        dob = $("#date_of_birth_input").val();
        // dob = $("#date_of_birth_input").val().split("/");
        // userData.dateOfBirth = `${dob[2]}-${dob[0]}-${dob[1]}`;
        userData.dateOfBirth = dob;
        userData.idNumber = $("#id_number_input").val();
        userData.phoneNumber = $("#phone_number_input").val();

        if (!userData.idNumber) {
            error_alert("Enter id number", "#self_enroll_message");

            return false;
        } else if (!userData.phoneNumber) {
            error_alert("Enter phone number", "#self_enroll_message");
            return false;
        } else {
            $("#s_next2").hide();
            $("#s_loading2").toggle();
            $("#b_next2").attr("disabled", true);
            confirmCustomer(userData);
            return false;
        }
    });

    $("#b_next3").on("click", function (e) {
        e.preventDefault;

        userData.oneTimePin = $("#one_time_pin_input").val();
        if (!userData.oneTimePin) {
            error_alert("One time pin is required", "#self_enroll_message");
            return false;
        } else if (userData.oneTimePin.length !== 4) {
            error_alert("Invalid code", "#self_enroll_message");

            return false;
        } else {
            $("#s_next3").hide();
            $("#s_loading3").toggle();
            $("#b_next3").attr("disabled", true);
            registerCustomer(userData);
        }
    });

    $("#reset_password_back_button").on("click", (e) => {
        location.reload();
        return;

        $("#security_question_submit").hide();
        // $("#user_id_next_btn").show();
        $("#security_question_form").hide();
        // $("#user_id_view").show();
        $("#password_reset_area").hide(500);
        // $("#login_form").show(500);
        // $("#user_id_next_btn").attr("disabled", false);
        $(".spinner-text-next").hide();
        // $(".user_id_next_btn_text").show();
        document.getElementById("reset_password_form").reset();
    });
});
