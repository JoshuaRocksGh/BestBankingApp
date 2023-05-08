<!-- ========== Left Sidebar Start ========== -->

<div id="sidebar-menu" class=" overflow-hidden p-0 text-xs  bg-danger site-card text-white"
    style="box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;">

    <ul id="side-menu" class="accordion ">
        <li class="menu-item">
            <a class="menu-item-header" href="{{ url('home') }}">
                <i class="fas fa-home"></i>
                <span> Home</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="#sidebarMyAccount" class="menu-item-header" data-toggle="collapse" data-target="#sidebarMyAccount">
                <i class="fas fa-book-reader"></i><span> My Accounts</span>
                <span class="menu-arrow fas fa-angle-right"></span>
            </a>
            <div class="collapse menu-item-body" id="sidebarMyAccount">
                <ul class="nav-second-level">

                    <li>
                        <a href="{{ url('account-enquiry') }}">Transactions Enquiry</a>
                    </li>
                </ul>
            </div>

        </li>
        <li class="menu-item">
            <a href="#sidebarTransfer" class="menu-item-header" data-toggle="collapse" data-target="#sidebarTransfer">
                <i class="fas fa-sync"></i> <span> Transfers </span>
                <span class="menu-arrow fas fa-angle-right"></span>
            </a>
            <div class="collapse menu-item-body" id="sidebarTransfer">
                <ul class="nav-second-level">
                    <li>
                        <a href="{{ url('own-account') }}">Own Account</a>
                    </li>
                    <li>
                        <a href="{{ url('same-bank') }}">Same Bank</a>
                    </li>
                    <li>
                        <a href="{{ url('local-bank') }}">Other Bank</a>
                    </li>
                    <li>
                        <a href="{{ url('international-bank') }}">International Bank</a>
                    </li>
                    {{-- <li>
                        <a href="{{ url('bollore-link') }}">Bollore Link</a>
                    </li> --}}
                    <li>
                        <a href="{{ url('standing-order') }}">Create Standing Order</a>
                    </li>
                    <li>
                        <a href="{{ url('standing-order-status') }}">Standing Order Status</a>
                    </li>
                    {{-- <li>
                        <a href="#sidebarStandingOrder" data-toggle="collapse">
                            <span>Standing Order</span>
                            <span class="menu-arrow fas fa-angle-right"></span>
                        </a>
                        <div class="collapse" id="sidebarStandingOrder">
                            <ul class="nav-second-level">
                            </ul>
                        </div>
                    </li> --}}
                    @if (config('app.corporate'))
                        <li>
                            <a href="{{ url('bulk-transfer') }}">Bulk Transfer </a>
                        </li>

                        {{-- <li>
                            <a href="{{ url('swift_mt101') }}">Sierra Rutile </a>
                        </li> --}}
                    @endif

                    <li>
                        <a href="{{ url('transfer-status') }}">Transfer Status</a>
                    </li>
                    <li>
                        <a href="{{ url('beneficiary-list') }}">Beneficiaries</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="menu-item">
            <a href="#sidebarBeneficiary" class="menu-item-header" data-toggle="collapse">
                <i class="fas fa-handshake"></i>
                <span>Payments </span>
                <span class="menu-arrow fas fa-angle-right"></span>
            </a>
            <div class="collapse menu-item-body" id="sidebarBeneficiary">
                <ul class="nav-second-level">
                    <li>
                        <a href="{{ url('payments') }}">Make Payment</a>
                    </li>
                    {{-- @if (!config('app.corporate')) --}}
                        <li>
                            <a href="{{ url('airport-tax') }}">Airport Tax</a>
                        </li>
                        <li>
                            <a href="{{ url('national-id') }}">National ID</a>
                        </li>
                    {{-- @endif --}}

                    <li>
                        <a href="{{ url('salone-link') }}">Salone-Link</a>
                    </li>
                    {{--  <li>
                        <a href="{{ url('blink-pay') }}">Blink Pay</a>
                    </li>  --}}

                    {{--  <li>
                        <a href="{{ url('cardless-payment') }}">Cardless</a>
                    </li>  --}}
                    <li>
                        <a href="{{ url('qr-payment') }}">
                            <span> QR Payment</span>
                        </a>
                    </li>

                    {{--  @if (config('app.corporate'))
                        <li>
                            <a href="{{ url('bulk-salone-Link') }}">Bulk Salone-link</a>
                        </li>
                    @endif  --}}

                    <li>
                        <a href="{{ url('payment-beneficiary-list') }}">Beneficiaries</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="menu-item">

            <a class="menu-item-header" href="{{ url('loan-request') }}">
                <i class="fas fa-balance-scale-right"></i>
                <span> My
                    Loans</span></a>

            </a>

        </li>

        <li class="menu-item">
            <a class="menu-item-header" href="#sidebarAccountServices" data-toggle="collapse">
                <i class="fas fa-business-time"></i>
                <span> Account Services </span>
                <span class="menu-arrow fas fa-angle-right"></span>
            </a>
            <div class="collapse menu-item-body" id="sidebarAccountServices">
                <ul class="nav-second-level">
                    {{--  <li>
                        <a href="{{ url('fixed-deposit') }}">Fixed Deposit</a>
                    </li>  --}}
                    @if (!config('app.corporate'))
                        <li>
                            <a href="{{ url('salary-advance') }}">Salary Advance</a>
                        </li>
                    @endif


                    <li>
                        <a href="{{ url('cheque-services') }}">Cheque Services</a>
                    </li>
                    <li>
                        <a href="{{ url('requests') }}">Requests</a>
                    </li>
                    {{--  <li>
                        <a href="{{ url('kyc-update') }}">Update KYC</a>
                    </li>  --}}

                    {{--  <li>
                        <a href="{{ url('open-additional-account') }}">Open additional account</a>
                    </li>  --}}
                    {{--  <li>
                        <a href="#">Close Account</a>
                    </li>  --}}
                    {{--  <li>
                        <a href="#">Update Account Signature</a>
                    </li>  --}}
                    <li>
                        <a href="{{ url('complaint') }}">
                            <span>Make Complaint</span>
                        </a>
                    </li>

                </ul>
            </div>
        </li>
         @if (!config('app.corporate'))
        <li class="menu-item">
            <a class="menu-item-header" href="{{ url('card-services') }}">
                <i class="fas fa-credit-card"></i>
                <span> Card Services </span>
            </a>
        </li>
         @endif

        @if (config('app.corporate'))
            <li class="menu-item">
                <a href="#approvals" class="menu-item-header" data-toggle="collapse">
                    <i class="fas fa-thumbs-up"></i> <span> Approvals </span>
                    <span class="menu-arrow fas fa-angle-right"></span>
                </a>
                <div class="collapse menu-item-body" id="approvals">
                    <ul class="nav-second-level">
                        <li>
                            <a href="{{ url('approvals-pending') }}">Pending</a>
                        </li>
                        <li>
                            <a href="{{ url('approvals-approved') }}">Approved</a>
                        </li>
                        <li>
                            <a href="{{ url('approvals-rejected') }}">Rejected</a>
                        </li>

                    </ul>
                </div>
            </li>
        @endif
        <li class="menu-item">
            <a class="menu-item-header" href="{{ url('settings') }}">
                <i class="fas fa-user-cog"></i> <span> Settings </span>
            </a>


        </li>
        {{--  <li class="menu-item">
            <a class="menu-item-header" href="{{ url('branch-locator') }}">
                <i class="fas fa-search-location"></i> <span> Branch Locator </span>
            </a>
        </li>  --}}

        <li class="menu-item">
            <a class="menu-item-header" href="#" id="sidebar_logout">
                <i class="fas fa-sign-out-alt"></i> <span> Logout </span>
            </a>
        </li>
    </ul>
</div>


@section('scripts')
    {{--  @include('extras.datatables')  --}}

    <script>
        {{--  $("#sidebar_logout").click(function(e) {
            e.preventDefault();

            approve_request();
            alert('cleic')
        })  --}}
    </script>
    <script src="{{ asset('assets/plugins/chartjs/chartjs-v3.7.1.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/pages/home/home.js') }}"></script>
@endsection
