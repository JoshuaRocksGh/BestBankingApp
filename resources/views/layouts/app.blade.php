<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>CHASE BANK</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Internet Banking Application" name="Internet Banking Portal for Chase Bank Ltd." />
    <meta content="Banking Application" name="Union Systems Global" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/chasefavicon.png') }}">


    <script src="{{ asset('assets\plugins\jquery\jquery-3.6.0.min.js') }}"></script>
    @include('snippets.style')
    @yield('styles')
    @include('snippets.script')


</head>

<body class="pb-0"
    style="background-image: url('../../assets/images/background.png');
    background-repeat: no-repeat; background-size: cover;">
    <!-- Pre-loader
        -->
    <div id="site_loader">
        <div>
            <img class="pulse mx-auto" style="width: 100px;" src="{{ asset('assets/images/chasebankLogo.png') }}" />
            <div class="mt-2  text-danger d-flex tw-relative"><span class="lds-hourglass tw-absolute"></span> <span
                    class="text-semibold align-self-center mx-2 font-weight-bold">
                    Loading</span></div>
        </div>
    </div>
    <div id="wrapper" class="w-100 overflow-hidden" style="min-height:100vh; display: none">
        @yield('content')
    </div>


    @yield('scripts')
</body>

</html>
