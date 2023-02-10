<!DOCTYPE html>
<html lang="en">

<head>


    <meta charset="utf-8" />
    <title>PB BANKING</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Internet Banking Application" name="Internet Banking Portal for Sierra Leone Commerical Bank Ltd." />
    <meta content="Banking Application" name="Union Systems Global" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">



    @include('snippets.style')


    @yield('styles')
    <script src="assets\plugins\jquery\jquery-3.6.0.min.js"></script>
</head>

<body style="background-color: white;">

    {{-- <div id="preloader" class="preloader">
        <div id="status" class="preloader">
            <img class="pulse" style="width: 100px; top: -50px;" src="assets/images/logoRKB.png" />
        </div>
    </div> <!-- End Preloader--> --}}


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @include('snippets.script')
    @yield('scripts')
</body>

</html>
