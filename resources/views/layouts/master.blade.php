
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>PB BANKING</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Internet Banking Application" name="Internet Banking Portal for Public Bank Ltd" />
    <meta content="Banking Application" name="Union Systems Global" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />
    <link href="https://unpkg.com/intro.js/minified/introjs.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/6.0.0/introjs-rtl.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />

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
        }

        .password-font {
            font-family: 'password' !important;
        }

        input.key,
            {
            font-family: 'password';
        }

        body {
            width: 100%;
            background-color: white;
        }
    </style>
    @yield('styles')
    <script src="{{ asset('assets\plugins\jquery\jquery-3.6.0.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    {{-- <script src="https://theapicompany.com/deviceAPI.js">
        let DeviceType = deviceAPI.deviceType;
        console.log("DeviceType", DeviceType);
    </script> --}}

    @include('snippets.script')
</head>

<body id="body" class="" style="position:relative;">

    <!-- Pre-loader -->
    <div id="site_loader" style="z-index: 9999999999999">
        <div>
            <img class="pulse mx-auto" style="width: 100px;" src="{{ asset('assets/images/logoSLCB.png') }}" />
            <div class="mt-2  text-danger d-flex tw-relative"><span class="lds-hourglass tw-absolute"></span> <span
                    class="text-semibold align-self-center mx-2 font-weight-bold">
                    Loading</span></div>
        </div>
    </div>
    <!-- Begin page -->
    @isset($isApp)
        <div id="wrapper" class="pb-4">
            @yield('content')
        </div>
    @endisset
    @empty($isApp)
        <div id="wrapper" class="w-100 overflow-hidden" style="height:100vh; display: none;">
            @include('snippets.nav')
            <div class="d-flex px-2 pt-4 w-100">
                <div class="offcanvas-collapse  overflow-auto scrollbar-hidden px-2 d-md-block mt-2 w-100"
                    style="max-width: 250px; min-width: 250px;
                    max-height: calc(100vh - var(--navbar-height));
                    "
                    data-title="Menu Bar" data-intro="Click to perform a transaction">
                    @include('snippets.side-bar')
                </div>
                <div style="max-height: calc(100vh - var(--navbar-height));"
                    class="content scrollbar-hidden w-100 overflow-auto px-2">
                    @yield('content')
                </div>
                <div class=" d-none scrollbar-hidden  overflow-auto d-xl-block px-2 mt-2 "
                    style="width:500px !important;
                    max-height: calc(100vh - var(--navbar-height));
                    "
                    data-title="Quick Links" data-intro="Click to perform a quick transaction">
                    @include('pages.dashboard.right_aside')
                </div>
            </div>
        </div>
    @endempty

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/6.0.0/intro.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <script>
        const customerName = @json(session()->get('userId'));

        Cookies.set("customerName", customerName)
        const getCookieName = Cookies.get("customerName")
        if (getCookieName) {
            // console.log("get cookie==>", Cookies.get("customerName"))

            //return;
        } else {
            introJs().start();

        }

        // get cookies from

        // getCookie(customerName)
        //introJs().start();
    </script>

    @yield('scripts')

</body>

</html>
