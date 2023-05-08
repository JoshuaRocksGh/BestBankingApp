@extends('layouts.app')

@section('content')
    <style>
        .card-box {
            position: relative;
            height: 10rem !important;
        }

        .card-box div {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateX(-50%);
            transform: translate(-50%, -50%);
        }


        .demo {
            font-weight: 500;
            /* font-size: 36px; */
            height: 40px;
        }

        p {
            display: inline-block;
            vertical-align: top;
            margin: 0;
        }

        .word {
            position: absolute;
            /* width: 220px; */
            opacity: 0;
        }

        .wisteria {
            color: #8e44ad;
        }

        .belize {
            color: #F15BB5;
        }

        .pomegranate {
            color: #c0392b;
        }

        .green {
            color: #16a085;
        }

        .midnight {
            color: #B89C72;
        }

        .word {
            animation-iteration-count: infinite;
            animation-name: anim;
            animation-duration: 7.5s;
        }

        .word:nth-child(2) {
            animation-delay: 1.5s;
        }

        .word:nth-child(3) {
            animation-delay: 3s;
        }

        .word:nth-child(4) {
            animation-delay: 4.5s;
        }

        .word:nth-child(5) {
            animation-delay: 6s;
        }

        @keyframes anim {

            0% {
                transform: translateY(100%);
                opacity: 0;
            }

            6.66% {
                transform: translateY(0);
                opacity: 1;
                transition: transform 0.38s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            }

            20% {
                transform: translateY(0);
                opacity: 1;
                transition: transform 0.38s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            }

            46.66% {
                transform: translateY(-100%);
                opacity: 0;
                transition: transform 0.32s cubic-bezier(0.55, 0.055, 0.675, 0.19);
            }

            /*we give long pause after animation is done by this method*/
            100% {
                transform: translateY(-100%);
                opacity: 0;
                transition: transform 0.32s cubic-bezier(0.55, 0.055, 0.675, 0.19);
            }

        }
    </style>

    @php
        if (!config('app.corporate')) {
            $TYPE = 'Personal';
        } else {
            $TYPE = 'Corporate';
        }
    @endphp


    <div class="overflow-hidden d-flex" style="height: 100vh">
        <div class="auth-card h-100 px-3 py-5 "
            style="background-image: url({{ asset('assets/images/vectorBCK.jpeg') }});background-repeat: no-repeat;background-size: cover; min-width:400 ">
            <div>
                <div class="text-center">
                    <a class="d-inline-block mb-4" href="{{ url('/') }}">
                        <img src="{{ asset('assets/images/slcb-bg-logo.png') }} " alt="company logo" height="50">
                    </a>
                    <h1 class="text-red page-header font-weight-bold font-20"> {{ $TYPE }} Internet Banking
                    </h1>
                </div>
                <div class="card-body mt-5 mx-auto" style="max-width: 500px">




                    <!-- form -->
                    <form action="#" autocomplete="off" aria-autocomplete="off" id="change-password-form">
                        <h2 class="mt-0 text-left font-weight-bold font-18 mb-4">Change Password</h2>

                        <div class="alert alert-danger bg-danger text-white border-0 " role="alert"
                            id="failed_password_change" style="display: none">
                        </div>
                        <div class="alert alert-warning text-white bg-warning " role="alert" id="validate_password_change"
                            style="display: none">
                        </div>

                        <div class="alert alert-success bg-success text-white border-0 " role="alert"
                            id="successful_password_change" style="display: none">
                        </div>

                        <div class="form-group">
                            <label for="new_password">Security Question</label>
                            <div class="input-group input-group-merge">
                                <select class="form-control" id="security_questions" required>
                                    <option value="">Select Security Queston</option>
                                </select>

                            </div>
                        </div>


                        <div class="form-group">
                            <label for="security_answer">Security Answer</label>
                            <div class="input-group input-group-merge">
                                <input type="text" id="security_answer" class="form-control"
                                    placeholder="Security Answer" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="security_answer">New User ID</label>
                            <div class="input-group input-group-merge">
                                <input type="text" id="user_id" class="form-control" placeholder="User Id"
                                    utocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new_pin">New Password</label>
                            {{--  <div class="input-group input-group-merge">  --}}
                            {{--  <input type="password" id="new_password" class="form-control" placeholder="New Password"
                                    required>  --}}
                            <div class="password-group">
                                <input type="password" id="new_password" maxlength="50" class="password-input form-control"
                                    placeholder="Enter New Password eg. (Qu@lity$07)" autocomplete="off"
                                    aria-autocomplete="off" required>
                                <span class="password-eye"></span>
                            </div>
                            {{--  </div>  --}}
                        </div>

                        <div class="form-group">
                            <label for="new_pin">Confirm Password</label>
                            {{--  <div class="input-group input-group-merge">  --}}
                            {{--  <input type="password" id="confirm_new_password" class="form-control"
                                    placeholder="Confirm Password" required>  --}}
                            <div class="password-group">
                                <input type="password" id="confirm_new_password" maxlength="50"
                                    class="password-input form-control" placeholder="Enter New Password eg. (Qu@lity$07)"
                                    autocomplete="off" aria-autocomplete="off" required>
                                <span class="password-eye"></span>
                            </div>
                            {{--  </div>  --}}
                        </div>


                        <div class="form-group mb-0 text-center">
                            <button class="btn btn-danger btn-block" type="submit" id="submit"><span
                                    id="set_password">Change
                                    Password</span>
                                <span class="spinner-border spinner-border-sm mr-1" role="status" id="spinner"
                                    aria-hidden="true"></span>
                                <span id="spinner-text">Loading...</span>
                            </button>

                            {{-- <button class="btn btn-primary btn-block" type="submit">Log In </button> --}}
                        </div>


                    </form>
                    <!-- end form-->

                    <form action="#" autocomplete="off" aria-autocomplete="off" id="intial-pin-setup"
                        style="display: none">
                        <h2 class="mt-0 text-left font-weight-bold font-18 mb-4">Pin Setup</h2>

                        <div class="alert alert-danger bg-danger text-white border-0 " role="alert" id="failed_pin_setup"
                            style="display: none">
                        </div>

                        <div class="alert alert-success bg-success text-white border-0 " role="alert"
                            id="successful_pin_setup" style="display: none">
                        </div>

                        <div class="form-group">
                            <label for="new_password">Enter Transaction Pin</label>
                            <div class="password-group">
                                <input type="password" id="transaction_pin" maxlength="4"
                                    class="password-input form-control" placeholder="Enter transaction pin"
                                    autocomplete="off" aria-autocomplete="off"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    required>
                                <span class="password-eye"></span>
                            </div>
                            {{--  <div class="input-group input-group-merge">
                                <input type="text" id="transaction_pin" class="form-control"
                                    placeholder="Enter transaction pin" maxlength="4" required
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>  --}}
                        </div>
                        <div class="form-group">
                            <label for="new_password">Confirm Transaction Pin</label>
                            <div class="password-group">
                                <input type="password" id="confirm_pin" maxlength="4"
                                    class="password-input form-control" placeholder="Confirm transaction pin"
                                    autocomplete="off" aria-autocomplete="off"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    required>
                                <span class="password-eye"></span>
                            </div>
                            {{--  <div class="input-group input-group-merge">
                                <input type="text" id="confirm_pin" class="form-control"
                                    placeholder="Confirm transaction pin" maxlength="4" required
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>  --}}
                        </div>

                        <div class="form-group mb-0 text-center">
                            <button class="btn btn-danger btn-block" type="submit" id="set_initial_pin"><span
                                    id="set_initial_pin_submit">Submit</span>
                                <span class="spinner-border spinner-border-sm mr-1" role="status"
                                    id="set_initial_pin_spinner" style="display:none" aria-hidden="true"></span>
                                <span id="set_initial_pin_spinner_text" style="display:none">Loading...</span>
                            </button>

                            {{-- <button class="btn btn-primary btn-block" type="submit">Log In </button> --}}
                        </div>
                    </form>

                    <!-- Footer-->
                    {{-- <footer class="footer footer-alt">
                            <p class="text-muted">Dont have an account? <a href="auth-register-2.html" class="text-muted ml-1"><b>Sign Up</b></a></p>
                        </footer> --}}

                </div> <!-- end .card-body -->
            </div> <!-- end .align-items-center.d-flex.h-100-->
        </div>
        <!-- end auth-fluid-form-box-->

        <!-- Auth fluid right content -->
        <div class="d-none d-xl-block w-100"
            style="background-image:  linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),url({{ asset('assets/images/meeting.jpg') }});background-repeat: no-repeat;background-size: cover;">
            <div class="auth-user-testimonial">
                @if (!config('app.corporate'))
                    <div class="container d-flex p-5 flex-column justify-content-around align-content-between "
                        id="login_page_extras" style="height: 100vh;">

                        <div class="d-flex justify-content-around w-100 mx-auto">
                            <div class=" my-auto">
                                <h1 class="font-weight-bold text-danger font-28">
                                    . . . Do more with<br>
                                    <span class="pl-5 font-28"> Mi YONE </span>
                                </h1>

                                <div class="demo  mt-5 font-28">
                                    <span class="mr-3 font-24 text-white">Mi Yone App</span>
                                    <span class="font-24 word-wrap">
                                        <span class="word font-weight-bold font-24 wisteria">anywhere...</span>
                                        <span class="word font-weight-bold font-24 belize">anytime...</span>
                                        <span class="word font-weight-bold font-24 pomegranate">secure...</span>
                                        <span class="word font-weight-bold font-24 green">convenient...</span>
                                        <span class="word font-weight-bold font-24 midnight">fast...</span>
                                    </span>
                                </div>


                            </div>

                            <div class=" text-center">
                                <div id="login_carousel" style="width: 350px" class="carousel slide"
                                    data-ride="carousel">

                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="{{ asset('assets/images/login-mobile-new.png') }}" alt="image"
                                                class=" rounded" style="width:200px !important;max-height:380px;" />
                                        </div>
                                        <div class="carousel-item">
                                            <img class=" rounded" alt="image"
                                                style="width:200px !important;max-height:380px;"
                                                src="{{ asset('assets/images/mobile-home-new.png') }}">
                                        </div>
                                        <div class="carousel-item">
                                            <img class=" rounded" alt="image"
                                                style="width:200px !important;max-height:380px;"
                                                src="{{ asset('assets/images/mobile-history-new.png') }}">
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#login_carousel" role="button"
                                        data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#login_carousel" role="button"
                                        data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>


                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-3">
                                <a class="text-center d-block bg-white rounded p-4" href="{{ url('account-creation') }}">
                                    <i class="fas fa-book-open text-danger font-20"></i>
                                    <h4 class="mt-3 font-14 text-danger"> Open Account
                                    </h4>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a class="text-center d-block bg-white rounded p-4" href="{{ url('branches') }}">
                                    <i class=" fas fa-map-marked-alt  text-danger font-20"></i>
                                    <h4 class="mt-3 font-14  text-danger">Branches</h4>
                                </a>
                            </div> <!-- end .padding -->


                            <div class="col-md-3">
                                <a class="text-center d-block bg-white rounded p-4" href="{{ url('enquiry') }}">
                                    <i class=" fas fa-desktop  text-danger font-20"></i>
                                    <h4 class="mt-3 font-14  text-danger">Enquiries
                                    </h4>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a class="text-center d-block bg-white rounded p-4" href="{{ url('faq') }}">
                                    <i class="fas fa-headset  text-danger font-20"></i>

                                    <h4 class="mt-3 font-14 text-danger">FAQ</h4>
                                </a>
                            </div>

                        </div>



                    </div>

            </div>
            @endif

        </div> <!-- end auth-user-testimonial-->
        <!-- end Auth fluid right content -->


    </div>
    <!-- end auth-fluid-->
@endsection


@section('scripts')
    <script>
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


        function get_security_question() {
            $.ajax({
                type: 'GET',
                url: 'get-security-question-api',
                datatype: "application/json",
                success: function(response) {
                    console.log(response.data);
                    let data = response.data
                    $.each(data, function(index) {

                        $('#security_questions').append($('<option>', {
                            value: data[index].Q_CODE
                        }).text(data[index].Q_DESCRIPTION));

                    });

                },

            })
        };





        $(document).ready(function() {

            setTimeout(function() {
                get_security_question();
            }, 2000);

            function hide_alert() {
                setTimeout(function() {
                    $('#failed_login').hide()
                }, 3000)
            }

            $('#failed_login').hide(),
                $('#spinner').hide(),
                $('#spinner-text').hide(),



                $('#change-password-form').submit(function(e) {
                    e.preventDefault();
                    var security_question = $("#security_questions").val();
                    var security_answer = $('#security_answer').val();
                    var new_password = $('#new_password').val();
                    var confirm_new_password = $('#confirm_new_password').val();
                    var user_id = $("#user_id").val()


                    //var show_error = $('#failed_login').show();

                    if (new_password == confirm_new_password) {
                        if (confirm_new_password.length < 8) {
                            error_alert(
                                "Password should be at least 8 characters long",
                                "#validate_password_change"
                            );
                            return false;
                        }
                        if (confirm_new_password.search(/[a-z]/i) < 0) {
                            error_alert(
                                "Password must contain at least one lower case letter.",
                                "#validate_password_change"
                            );
                            return;
                        }
                        if (confirm_new_password.search(/[A-Z]/) < 0) {
                            error_alert(
                                "Password must contain at least one upper case letter.",
                                "#validate_password_change"
                            );
                            return;
                        }
                        if (confirm_new_password.search(/[0-9]/) < 0) {
                            error_alert(
                                "Password must contain at least one digit.",
                                "#validate_password_change"
                            );
                            return;
                        }
                        if (confirm_new_password.search(/[!@#\$%\^&\*_]/) < 0) {
                            error_alert(
                                "password must contain a special character (! @ # $ % ^ & * _ ) ",
                                "#validate_password_change"
                            );
                            return;
                        }

                        $('#spinner').show(),
                            $('#spinner-text').show(),

                            $('#set_password').hide(),
                            $('#submit').attr('disabled', true);

                        //
                        $.ajax({
                            type: "POST",
                            url: "post-change-password",
                            datatype: "application/json",
                            data: {
                                "security_question": security_question,
                                "security_answer": security_answer,
                                "new_password": new_password,
                                "confirm_new_password": confirm_new_password,
                                "user_id": user_id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },

                            success: function(response) {
                                console.log(response);
                                var res = response.data
                                $('#submit').attr('disabled', false);

                                if (response.responseCode == "000") {
                                    setTimeout(function() {
                                        success_alert(response.message,
                                            "#successful_password_change");
                                    }, 3000)

                                    if (ISCORPORATE) {
                                        window.location = 'login';
                                    } else {
                                        $('#change-password-form').hide()
                                        $('#intial-pin-setup').show()
                                    }

                                    {{--    --}}

                                } else {
                                    error_alert(response.message, "#failed_password_change");
                                    $('#spinner').hide(),
                                        $('#spinner-text').hide(),

                                        $('#set_password').show(),
                                        $('#submit').attr('disabled', false);

                                }
                            }
                        })
                    } else {


                        error_alert("Passwords do not match", "#validate_password_change");

                        $('#spinner').hide(),
                            $('#spinner-text').hide(),

                            $('#set_password').show(),
                            $('#submit').attr('disabled', false);
                    }

                })


            $("#intial-pin-setup").submit(function(e) {
                e.preventDefault();
                {{--  console.log("intial-pin-setup")  --}}

                var transaction_pin = $("#transaction_pin").val()
                var confirm_pin = $("#confirm_pin").val()

                if (confirm_pin.length != 4) {
                    error_alert("Pin is less than 4 characters", "#validate_password_change");
                    return
                }


                if (transaction_pin == confirm_pin) {

                    $('#set_initial_pin_spinner').show(),
                        $('#set_initial_pin_spinner_text').show(),

                        $('#set_initial_pin_submit').hide(),
                        $('#set_initial_pin').attr('disabled', true);
                    $.ajax({
                        type: 'POST',
                        url: 'initial-pin-setup',
                        datatype: 'application/json',
                        data: {
                            "pin": confirm_pin
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log("initial-pin-setup ==>", response)
                            {{--  console.log(response.errors);  --}}

                            if (response.responseCode == '000') {
                                success_alert(response.message,
                                    "#successful_pin_setup");
                                setTimeout(function() {
                                    window.location = 'login';

                                }, 5000)


                            } else {
                                $('#set_initial_pin_spinner').hide(),
                                    $('#set_initial_pin_spinner_text').hide(),

                                    $('#set_initial_pin_submit').show(),
                                    $('#set_initial_pin').attr('disabled', false);
                            }
                        }
                    })

                } else {
                    error_alert("Pins do not match", "#validate_password_change");
                    $('#set_initial_pin_spinner').hide(),
                        $('#set_initial_pin_spinner_text').hide(),

                        $('#set_initial_pin_submit').show(),
                        $('#set_initial_pin').attr('disabled', false);
                }
            })


        })
    </script>
@endsection
