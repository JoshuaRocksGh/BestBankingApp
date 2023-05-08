@extends('layouts.master')

@section('content')
    @php
        $pageTitle = 'Dashboard';
        $basePath = 'Home';
        $currentPath = 'Dashboard';
    @endphp
    @include('snippets.pageHeader')

    {{-- dashboard layout --}}
    <div class="">
        <div class="dashboard site-card overflow-hidden">
            <nav class="dashboard-header " data-title="Dashbord Tabs" data-intro="Click to view">
                <div class="nav nav-tabs border-0" id="nav-tab" role="tablist">
                    <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
                        aria-controls="nav-home" aria-selected="true">Account Summary</a>

                    <a class="nav-link" id="nav_acc_history_tab" data-toggle="tab" href="#nav_acc_history" role="tab"
                        aria-controls="nav_acc_history" aria-selected="false">Account History</a>
                    @if (config('app.corporate'))
                        <a class="nav-link " id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab"
                            aria-controls="nav-profile" aria-selected="false">Approvals
                            <span id="approval_count" class="badge badge-success badge-pill font-10 ml-1"></span>
                        </a>
                    @endif
                </div>
            </nav>
            <div class="tab-content dashboard-body border-danger border " id="nav-tabContent">
                <div class="tab-pane fade h-100 show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="row ">
                        <nav class="d-flex col-sm-2 col-md-auto  align-self-center no-after dashboard-header h-100 align-items-center"
                            style="height: 100%" data-title="Account Tabs" data-intro="Click to view">
                            <div class="nav nav-tabs flex-column  border-0" id="nav-tab" role="tablist">
                                <a href="#canvas_total" data-toggle="tab" data-target="totalsPie" aria-expanded="false"
                                    class="nav-link canvas-tab  mb-2 font-10 active totalsPie">
                                    <b>All</b>
                                </a>
                                <a href="#canvas_account" data-toggle="tab" data-target="accountsPie" aria-expanded="false"
                                    class="nav-link mb-2 canvas-tab font-10 accountsPie">
                                    <b>My Deposits</b>
                                </a>
                                <a href="#canvas_loan" data-toggle="tab" data-target="loansPie" aria-expanded="false"
                                    class="mb-2  font-10 canvas-tab nav-link loansPie">
                                    <b>My Loans</b>
                                </a>
                                <a href="#canvas_investment" data-toggle="tab" data-target="investmentsPie"
                                    aria-expanded="true" class="mb-2 canvas-tab font-10 nav-link investmentsPie ">
                                    <b>My Investments</b>
                                </a>
                        </nav>
                        <div class="mb-4 w-100 col-md overflow-hidden position-relative">
                            <div class="position-absolute chart-no-data" hidden
                                style="top: 50%; left: 50%; transform: translate(-50%, -50%)">
                                <span class="text-center">
                                    {!! $noDataAvailable !!}
                                </span>
                            </div>
                            <canvas id="accountsPieChart" style="max-height: 300px"></canvas>

                        </div>
                    </div>
                    <div class="  overflow-hidden">
                        <nav class="mb-2 dashboard-header" data-title="Account Description" data-intro="Click to view"
                            style="display: none">
                            <div class="nav nav-tabs border-0" id="nav-tab" role="tablist">

                                <a href="#accounts" data-toggle="tab" aria-expanded="false"
                                    class="nav-link active accounts_table">
                                    <b>My Deposits</b>
                                </a>
                                <a href="#loans" data-toggle="tab" aria-expanded="false" class="nav-link loans_table">
                                    <b>My Loans</b>
                                </a>
                                <a href="#investments" data-toggle="tab" aria-expanded="false"
                                    class="nav-link investments_table">
                                    <b>My Investments</b>
                                </a>
                        </nav>
                        <div class="tab-content ">
                            <div class="tab-pane p-0 show active" id="accounts">
                                <div class=" accounts_display_area" style="min-height: 220px">
                                    <table id="accounts_table" width="100%"
                                        class="table nowrap display  border dt-responsive table-hover rounded mb-0 ">
                                        <thead>
                                            <tr class=" table-background ">
                                                <td class="text-right"> Account Number </td>
                                                <td class="text-right"> Account Name </td>
                                                <td class="text-right"> Account Type </td>
                                                <td class="text-right"> Currreny </td>
                                                <td class="text-right"> Ledger Bal </td>
                                                <td class="text-right"> Available Bal </td>
                                                <td class="text-right"> Over Draft </td>
                                            </tr>
                                        </thead>

                                    </table>
                                </div>

                            </div>
                            <div class="tab-pane p-0" id="loans">
                                <div class="table-responsive  loans_display_area">
                                    <table id="loans_table" width="100%"
                                        class="table nowrap display border dt-responsive table-hover rounded mb-0 ">
                                        <thead>
                                            <tr class="table-background">
                                                <td class="text-right"> Facility No. </td>
                                                <td class="text-right"> Description </td>
                                                <td class="text-right"> Cur </td>
                                                <td class="text-right"> Amount Granted </td>
                                                <td class="text-right"> Loan Bal </td>

                                            </tr>
                                        </thead>
                                        <tbody class="loans_display">


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane p-0" id="investments">
                                <div class="table-responsive investments_display_area" style="min-height: 220px">
                                    <table id="investments_table" width="100%"
                                        class="table nowrap display border rounded  mb-0 ">
                                        <thead>
                                            <tr class="table-background ">
                                                <td> Account No. </td>
                                                <td> Description </td>
                                                <td> Cur </td>
                                                <td> Deal Amount </td>
                                                <td> Accured Interest </td>
                                                <td> Maturity Date </td>
                                                {{--  <td> Rollover </td>  --}}

                                            </tr>
                                        </thead>
                                        <tbody class="fixed_deposit_account">
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="table-responsive ">
                        <table id=""
                            class="table table-bordered  table-striped display responsive nowrap   w-100 pending_transaction_request ">
                            <thead>
                                <tr class="table-background">
                                    <th>Rquest Id</th>
                                    <th>Req-Type</th>
                                    <th>Account No</th>
                                    <th>Amount</th>
                                    {{--  <th >Transfer Purpose</th>  --}}
                                    <th>Posted Date</th>
                                    {{--  <th class="none">Initiated By</th>  --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="request_table">
                                <tr>
                                    <td colspan="8">
                                        <div class="d-flex justify-content-center">
                                            <div class="spinner-border avatar-lg text-primary  m-2 canvas_spinner"
                                                role="status">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> <!-- end card body-->
                </div>
                <div class="tab-pane fade" id="nav_acc_history" role="tabpanel" aria-labelledby="nav_acc_history_tab">

                    <div class="p-2" id="acc_history">
                        <div class="mx-auto mb-4" style="max-width: 550px;"> <strong class="text-primary">CURRENT &
                                SAVINGS</strong>
                            <select name="" id="chart_account" class="form-control accounts-select">
                                @include('snippets.accounts') </select>
                        </div>
                        <span class="text-center" id="transactionNoData">
                            {!! $noDataAvailable !!}
                        </span>
                        <canvas id="transactionsBarChart">
                        </canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection


@section('scripts')
    @include('extras.datatables')

    <script>
        let noDataAvailable = {!! json_encode($noDataAvailable) !!};
        let customer_no = @json(session()->get('customerNumber'));
        const pageData = {}
        pageData.accounts = @json(session()->get('customerAccounts'));
        pageData.loans = @json(session()->get('customerLoans'));
        pageData.investments = @json(session()->get('customerInvestments'));
    </script>
    <script src="{{ asset('assets/plugins/chartjs/chartjs-v3.7.1.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/pages/home/home.js') }}"></script>
@endsection
