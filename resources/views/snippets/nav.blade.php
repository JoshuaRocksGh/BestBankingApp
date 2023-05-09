<!-- Topbar Start -->
<div id="top-nav-bar"
    class="d-flex  align-items-center justify-content-between py-2 px-2 px-sm-5 bg-white site-shadow sticky ">
    <a class="d-block d-md-none " type="button" data-toggle="offcanvas">
        <div class="hamburger-menu"><span></span><span></span><span></span></div>
    </a>

    <a href="{{ url('home') }}" class="d-none d-md-block">
        <img src="{{ asset('assets/images/SIBBanner.png') }}" height="30" alt="company logo">
    </a>


    <div class="logo-box" style="display: flex; align-items: center;">

        {{-- <span>
            {{ session()->get('accountDescription') }}
        </span> --}}
        <div class="d-none d-md-block rounded-pill border font-11 mx-4 py-1  text-capitalize px-2 border-info">
            @if (config('app.corporate'))
                corporate
            @else
                personal
            @endif
            Internet Banking
        </div>


        <div class="d-none d-xl-flex align-items-center mx-4">
            <div>
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="mx-2">
                <div class="font-12 ">
                    {{ session()->get('deviceInfo')['deviceIp'] }}
                </div>
                <div class="text-info  font-10">
                    Last Login IP
                </div>
            </div>
        </div>

        <div class="d-none d-lg-flex align-items-center mx-4">
            <div>
                <i class="far fa-clock"></i>
            </div>
            <div class="mx-2">
                <div class="font-12">
                    {{ explode('GMT', session()->get('lastLogin'), 4)[0] }}
                </div>
                <div class="text-info  font-10">
                    Last Login Date
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center">
            <div class="d-none d-md-block">
                {{-- <img src="{{ asset('assets/images/logoRKB.png') }}" alt="company logo" height="45"> --}}
            </div>

            <div class="mx-2">
                <div class="font-10 text-center text-info" style="line-height: 1"> Welcome Back </div>
                <div class="font-14 font-weight-bold text-uppercase">
                    {{ session()->get('userAlias') }}

                </div>
            </div>
            <a href="{{ url('logout') }}" class=" ml-2">
                <i class="d-none d-sm-inline-block text-info fas fa-sign-out-alt"></i>
            </a>

        </div>
    </div>

</div>
