@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/plugins/bootstrap-pincode-input/bootstrap-pincode-input.css') }}" />
    <style>
        .card-img {
            font-size: 28px !important;

        }

        @media (min-width: 574px) {
            .card-img {
                font-size: 3rem !important;
            }
        }

        .text {
            position: absolute;
            width: 0px;
            height: 0px;
            transition: all 1s;

        }
    </style>
@endsection
@section('content')
    @php
        $pageTitle = 'Settings';
        $basePath = 'Settings';
        $currentPath = 'Settings';
    @endphp
    @include('snippets.pageHeader')

    <div class="dashboard site-card">
        <div class="tab-content dashboard-body border-danger border ">
            <div class="d-flex mx-auto justify-content-between flex-wrap row" id="settings_display">
            </div>
        </div>

    </div>

    {{--  <div class="tab-pane site-bg font site-card p-2 p-sm-3 p-md-4">

        <div style="max-width: 1024px;
    " class="d-flex mx-auto justify-content-between flex-wrap" id="settings_display">
        </div>

        <div class="mt-5 d-flex align-items-center justify-content-center font-11 font-weight-bold">
            <img style="height: 15px;" src="{{ asset('assets/images/logoRKB.png') }}" />
            <span class="d-block ml-1">
                Rokel
                Commercial
                Bank Internet
                Banking
            </span>
        </div>
    </div>  --}}

    @include('pages.settings.enquiry')
    @include('pages.settings.forgot_transaction_pin')
    @include('pages.settings.change_transaction_pin')
    @include('pages.settings.faq')
    @include('pages.settings.contact_us')
    @include('pages.settings.terms_condition')
    @include('pages.settings.change_password')
    @include('pages.settings.create_originator')
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/pages/settings/settings.js') }}"></script>
    <script defer src="{{ asset('assets/plugins/bootstrap-pincode-input/bootstrap-pincode-input.js') }}"></script>
    <script>
        function getSecurityQuestions(user) {
            {{--  alert("called")  --}}

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
                    // console.log("change transaction question=>", data);
                    if(data){
                        $(".change_pin_sec_question_code").val(data[0]?.code)
                    $(".security_question").text(data[0]?.description)
                    }

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
        var user = @json(session()->get('userId'));
        console.log("useruseruseruseruser", user)

        $(function() {


            var user = @json(session()->get('userId'));

            getSecurityQuestions(user)

        })
    </script>
@endsection
