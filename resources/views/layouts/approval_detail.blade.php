<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>SLCB BANKING</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Internet Banking Application" name="Internet Banking Portal for Rokel Commercial Bank." />
    <meta content="Banking Application" name="Union Systems Global" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    @include('snippets.style')
    <style type="text/css">
        * {
            scrollbar-width: thin;
            scrollbar-color: rgb(221, 221, 223) rgb(217, 217, 216);
        }

        *::-webkit-scrollbar {
            width: 12px;
        }

        *::-webkit-scrollbar-track {
            background: rgb(217, 217, 216);
        }

        *::-webkit-scrollbar-thumb {
            background-color: rgb(230, 230, 231);
            border-radius: 20px;
            border: 3px solid rgb(217, 217, 216);
        }

        @media print {
            .hide_on_print {
                display: none
            }
        }

        @font-face {
            font-family: 'password';
            font-style: normal;
            font-weight: 400;
            src: url("assets/fonts/password.ttf")
                /* src: url(https://jsbin-user-assets.s3.amazonaws.com/rafaelcastrocouto/password.ttf); */
        }

        input.key {
            font-family: 'password';
            width: 300px;
            height: 80px;
            font-size: 100px;
        }

        #body {
            width: 100%;
            background-color: white;
        }
    </style>
    @yield('styles')
    <script src="{{ asset('assets\plugins\jquery\jquery-3.6.0.min.js') }}"></script>
    {{-- @include('snippets.script') --}}
</head>

<body>


    {{-- <!-- Pre-loader -->
    <div id="preloader" class="preloader">
        <div id="status" class="preloader">
            <img class="pulse" style="width: 100px; top: -50px;"
                src="{{ asset('assets/images/logoRKB.png') }}" />
        </div>
    </div> <!-- End Preloader--> --}}

    <!-- Begin page -->
    <div id="wrapper1">
        @include('snippets.nav')


        <div>
            <div class="content" style="zoom: 0.9 ;">
                @yield('content')
            </div>

            {{-- @include('snippets.footer') --}}
        </div>
    </div>

    @include('snippets.script')


    @yield('scripts')
    {{-- @include('sweetalert::alert') --}}

</body>
{{-- <script src="bootstrap.min.js"></script> --}}
{{-- <script src="//code.jquery.com/jquery-1.12.1.min.js"></script> --}}
{{-- <script src="dist/jquery.userTimeout.js"></script> --}}

</html>
