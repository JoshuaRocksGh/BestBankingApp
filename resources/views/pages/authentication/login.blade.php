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
            <div class="text-center">
                <a class="d-inline-block mb-4" href="{{ url('/') }}">
                    <img src="{{ asset('assets/images/SIBBanner.png') }} " alt="company logo" height="60">
                </a>
                <h1 class="text-red page-header font-weight-bold font-16"> {{ $TYPE }} Internet Banking </h1>
            </div>
            <div class="card-body mt-5 mx-auto" style="max-width: 500px">

                {{--  // ========= LOGIN FORM ========  --}}
                <div id="login_form">

                    <h2 class="mt-0 text-left font-weight-bold font-16 mb-4">Sign In</h2>
                    <!-- form -->
                    <form action="POST" id="login_post_form" autocomplete="off" aria-autocomplete="off">
                        @csrf

                        <div class="alert alert-danger bg-danger text-white border-0 " role="alert" id="failed_login"
                            style="display: none">
                        </div>

                        <div class="alert alert-success bg-success text-white border-0 " role="alert"
                            id="successful_login" style="display: none">
                        </div>

                        <div class="form-group">
                            <label for="user_id">User ID</label>
                            <input class="form-control" type="text" id="user_id" placeholder="Enter Username"
                                parsley-trigger="change" autocomplete="off" autofocus maxlength="50"
                                aria-autocomplete="off">
                        </div>
                        <!-- other form fields here -->
                        <input type="hidden" name="csrf-token" id="csrf-token" value="{{ csrf_token() }}">
                        <!-- submit button here -->
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-end">
                                <label for="password">Password</label>
                                {{--  @if (!config('app.corporate'))  --}}
                                <button type="button" class="text-danger text-right font-12" id="forgot_password"
                                    onmouseover='this.style.textDecoration="underline"'
                                    onmouseout='this.style.textDecoration="none"'>Forgot
                                    your
                                    password?</button>
                                {{--  @endif  --}}
                            </div>
                            <div class="password-group">
                                <input type="password" id="password" maxlength="50" class="password-input form-control"
                                    placeholder="Enter Password" autocomplete="off" aria-autocomplete="off">
                                <span class="password-eye"></span>
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <button class="btn btn-dark btn-block" type="submit" id="submit"><span id="log_in">Log
                                    In</span>
                                <span class="spinner-border spinner-border-sm mr-1" role="status" style="display: none"
                                    id="spinner" aria-hidden="true"></span>
                                <span id="spinner-text" style="display: none">Loading...</span>
                            </button>
                            {{-- <button class="btn btn-primary btn-block" type="submit">Log In </button> --}}
                        </div>
                    </form>
                    @if (!config('app.corporate'))
                        <div type="button" class="mt-5 text-center">
                            <button type="button" id="self_enroll" class="font-weight-bold text-red">Self Enroll
                                Here!</button>
                        </div>
                    @endif

                </div>


                {{--  // ====== OTP FORM =====  --}}
                <div id="enter_otp" style="display:none">
                    {{--  <div id="enter_otp">  --}}
                    <h2 class="mt-0 mb-4 font-weight-bold font-18 text-left">Enter OTP</h2>

                    <form id="validate_otp_form" action="#" autocomplete="off" aria-autocomplete="off">
                        @csrf
                        <div class="alert alert-danger bg-danger text-white border-0 " role="alert" id="display_otp_error"
                            style="display: none">
                        </div>
                        <div class="form-group" id="otp_view">
                            <label for="reset_user_id">Enter Otp</label>
                            <div class="input-group input-group-merge ">
                                <input type="email" id="enter_otp_input" placeholder="Enter otp recieved" name="enter_otp"
                                    class="form-control" autocomplete="off" aria-autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group mb-0 text-center">
                            <br />

                            <button class="btn btn-danger btn-block" type="sumbit" id="verify_otp_button">
                                <span class="submit_otp_button">Verify</span>
                                <span class="spinner-border spinner-border-sm mr-1 spinner-text-next"
                                    style="display: none" role="status" aria-hidden="true"></span>
                                <span class="spinner-text-next" style="display: none">Loading...</span>
                            </button>

                        </div>
                    </form>

                </div>


                {{--  // ======== RESET PASSWORD FORM =========  --}}
                {{--  @if (!config('app.corporate'))  --}}
                <div id="password_reset_area" style="display:none">
                    <!-- title-->
                    <h2 class="mt-0 mb-4 font-weight-bold font-18 text-left">Reset Password</h2>
                    <p class="text-muted mb-4">Enter the required details to reset password</p>

                    <!-- form -->
                    <form id="reset_password_form" action="#" autocomplete="off" aria-autocomplete="off">
                        <div class="alert alert-danger text-white bg-danger" role="alert" id="error_alert"
                            style="display: none">
                        </div>
                        <div class="alert alert-warning text-white bg-warning " role="alert" id="no_question"
                            style="display: none">
                        </div>
                        <div class="alert alert-success bg-success text-white" role="alert" id="reset_success"
                            style="display: none">
                        </div>


                        <div class="form-group" id="user_id_view">
                            <label for="reset_user_id">Enter User ID</label>
                            <div class="input-group input-group-merge ">
                                <input type="email" id="reset_user_id" placeholder="Enter User ID"
                                    name="reset_user_id" class="form-control" autocomplete="off"
                                    aria-autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group" id="security_question_form" style="display: none">
                            <div class=" text-12 text-danger">Security Question</div>
                            <label for="security_question_answer" id="security_question">Security Question</label>
                            <input type="text" id="security_question_answer" name="security_question_answer"
                                class="form-control" autocomplete="off" aria-autocomplete="off">
                            <input type="text" id="security_question_code" autocomplete="new-password" hidden>
                            <br>
                            <label for="security_question_answer">New Password</label>
                            <div class="password-group">
                                <input type="password" id="reset_password" maxlength="50"
                                    class="password-input form-control" placeholder="Enter New Password"
                                    autocomplete="off" aria-autocomplete="off">
                                <span class="password-eye"></span>
                            </div>
                            {{--  <input type="password" placeholder="Enter New Password" id="reset_password"
                                name="reset_password" class="form-control" autocomplete="off" aria-autocomplete="off">  --}}
                            <br>
                            <label for="security_question_answer">Confirm Password</label>
                            <div class="password-group">
                                <input type="password" id="reset_confirm_password" maxlength="50"
                                    class="password-input form-control" placeholder="Confirm Password" autocomplete="off"
                                    aria-autocomplete="off">
                                <span class="password-eye"></span>
                            </div>
                            {{--  <input type="password" placeholder="Confirm Password" id="reset_confirm_password"
                                name="reset_confirm_password" autocomplete="new-password" class="form-control" />  --}}
                        </div>

                        <div class="form-group" id="security_question_otp" style="display: none">
                            <div class="form-group" id="user_id_view_otp">
                                <label for="user_id_view_otp">Enter Otp</label>
                                <div class="input-group input-group-merge ">
                                    <input type="text" id="reset_user_id_otp" placeholder="Enter otp received"
                                        name="reset_user_id_otp" class="form-control" autocomplete="off"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                        aria-autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-0 text-center">
                            <br>
                            <button class="btn btn-danger btn-dark" type="button" id="user_id_next_btn">
                                <span class="user_id_next_btn_text">Next</span>
                                <span class="spinner-border spinner-border-sm mr-1 spinner-text-next"
                                    style="display: none" role="status" aria-hidden="true"></span>
                                <span class="spinner-text-next" style="display: none">Loading</span>
                            </button>
                            <button class="btn btn-danger btn-block" style="display: none" type="button"
                                id="security_question_submit">
                                <span id="security_question_submit_text">Submit</span>
                                <span class="spinner-border spinner-border-sm mr-1 security_question_submit_spinner"
                                    role="status" aria-hidden="true" id="" style="display: none"></span>
                                <span class="spinner-text-next security_question_submit_spinner" style="display: none"
                                    id="">Loading</span>

                            </button>
                            <button class="btn btn-danger btn-block" style="display: none" type="button"
                                id="security_question_otp_submit">
                                <span id="security_question_otp_submit_text">Submit</span>
                                <span class="spinner-border spinner-border-sm mr-1 otp_submit_spinner" role="status"
                                    aria-hidden="true" id="" style="display: none"></span>
                                <span class="spinner-text-next otp_submit_spinner" style="display: none"
                                    id="">Loading</span>

                            </button>
                        </div>
                        <div class="mt-4 text-center"> <button type="button" class=" font-weight-bold text-red  mx-auto"
                                id="reset_password_back_button">Back to
                                Login
                            </button>
                        </div>
                    </form>
                </div>
                {{--  @endif  --}}
                @if (!config('app.corporate'))
                    <div id="self_enroll_form" class=" form-center" style="display: none">
                        <h2 class="mt-0 text-left my-4 font-18 font-weight-bold">Self Enroll</h2>

                        <div class="alert alert-danger bg-danger text-white border-0" role="alert"
                            id="self_enroll_message" style="display: none">
                        </div>
                        <div class="alert alert-success bg-success text-white border-0 " role="alert"
                            id="successful_self_enroll" style="display: none">
                        </div>

                        <div id="self_enroll_form1" class="form-group">
                            <form action="POST" id="parent_self_enroll_form_1">
                                @csrf
                                <i class="mdi mdi-alert-circle"></i>You must be an account holder of the bank

                                <div class="form-group">
                                    <label class="my-2 " for="customer_number_input"> Customer Number</label>
                                    <input class="form-control " type="number" id="customer_number_input"
                                        placeholder="Enter your customer number" pattern="[0-9]*" inputmode="numeric"
                                        parsley-trigger="change" autocomplete="none">
                                </div>
                                <br />
                                <div id="a" class="form-group mb-0 text-center">
                                    <button class="btn btn-danger btn-block" id="b_next1" type="submit"><span
                                            id="s_next1">Next</span>
                                        <span id="s_loading1">
                                            <span class="spinner-border spinner-border-sm mr-1" role="status"
                                                id="spinner1" aria-hidden="true"></span>
                                            <span id="spinner-text1">Loading...</span>
                                        </span>
                                    </button>
                                </div>
                            </form>
                            <div class="text-center mt-5">
                                <button type="button" id="login_instead" class="text-red font-weight-bold">Login
                                    Instead</button>
                            </div>

                        </div>

                        <div id="self_enroll_form2" class="form-group">
                            <form action="POST" id="parent_self_enroll_form_2">
                                @csrf
                                <label for="phone_number_input"> Phone Number<span class="text-danger">*</span></label>

                                <input class="form-control mb-0" type="number" id="phone_number_input"
                                    placeholder="Enter register number with bank. eg(23225643079)"
                                    parsley-trigger="change" aria-autocomplete="off" autocomplete="off" />
                                <br />
                                <label for="id_number_input"> ID Number<span class="text-danger">*</span></label>

                                <input class="form-control mb-0" type="text" id="id_number_input"
                                    placeholder="Enter id number registered with bank" parsley-trigger="change"
                                    aria-autocomplete="off" autocomplete="off" />
                                <br />
                                <label for="date_of_birth_input"> Date of birth<span class="text-danger">*</span></label>

                                <input type="date" id="date_of_birth_input" placeholder="Enter your date of birth"
                                    class="form-control mb-0" parsley-trigger="change" autocomplete="off"
                                    aria-autocomplete="off" data-provide="datepicker" data-date-autoclose="true">

                                <br />


                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-danger btn-block" id="b_next2" type="submit"><span
                                            id="s_next2">Next</span>
                                        <span id="s_loading2">
                                            <span class="spinner-border spinner-border-sm mr-1" role="status"
                                                id="spinner2" aria-hidden="true"></span>
                                            <span id="spinner-text2">Loading...</span>
                                        </span>
                                    </button>
                                    <br />
                                </div>
                            </form>
                        </div>

                        <div id="self_enroll_form3" class="form-group">
                            <form action="POST" id="parent_self_enroll_form_3">
                                @csrf
                                <div id="one_time_input_area">
                                    <label for="one_time_pin_input"> Enter one time pin<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control mb-0" type="text" id="one_time_pin_input"
                                        placeholder="Enter one time pin" parsley-trigger="change" autocomplete="none" />
                                    <br />
                                </div>
                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-danger btn-block" id="b_next3" type="submit"><span
                                            id="s_next3">Register</span>
                                        <span id="s_loading3">
                                            <span class="spinner-border spinner-border-sm mr-1" role="status"
                                                id="spinner3" aria-hidden="true"></span>
                                            <span id="spinner-text3">Loading...</span>
                                        </span>
                                    </button>
                                    <br />
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
                </form>


                <br><br><br>
                @if (!config('app.corporate'))
                    <div class="auth-extras  d-xl-none row" id="">


                        <div class="col-6 py-2">
                            <a href="{{ url('account-creation') }}" class="btn btn-outline-danger w-100 btn-rounded"> <i
                                    class="fas fa-book-open text-danger"></i> Open
                                Account</a>
                        </div>
                        <div class="col-6 py-2">

                            <a href="{{ url('enquiry') }}" class="btn btn-outline-danger w-100 btn-rounded"> <i
                                    class="fas fa-desktop text-danger"></i> Make Enquiry</a>
                        </div>

                        <div class="col-6 py-2">
                            <a href="{{ url('branches') }}" class="btn btn-outline-danger w-100 btn-rounded"> <i
                                    class="fas fa-map-marked-alt text-danger"></i> Branches</a>
                        </div>
                        <div class="col-6 py-2">

                            <a href="{{ url('faq') }}" class="btn btn-outline-danger w-100 btn-rounded"> <i
                                    class="fas fa-headset text-danger"></i> FAQs</a>
                        </div>

                    </div>
                @endif

            </div> <!-- end .card-body -->
        </div>

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
                                    <span class="pl-5 font-28"> Mi YONE App </span>
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
    </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/pages/login.js') }}"></script>
@endsection
