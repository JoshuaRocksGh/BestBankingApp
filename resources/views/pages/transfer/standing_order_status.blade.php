@extends('layouts.master')

@section('content')
    @php
        $basePath = 'Transfer';
        $currentPath = 'Standing Order Status';
        $pageTitle = ' STANDING ORDER STATUS';
    @endphp
    @include('snippets.pageHeader')


    {{-- <div class="dashboard site-card overflow-hidden">
        <div class=" dashboard-body p-4">
            <div>
                <div>
                    <label class="d-block text-center  font-weight-bold mb-1 text-primary"> Select Account To Transfer
                        From</label>
                    <select data-style="" class="form-control accounts-select" id="from_account" required>
                        @include('snippets.accounts')
                    </select>
                </div>
                <hr class="col-md-9">
                <div class=" p-2 table-responsive">
                    <table class="table table-striped w-100 rounded table-bordered nowrap" id="standing_order_display_area">
                        <thead>
                            <tr class="bg-primary text-white ">
                                <td> <b> Account No </b> </td>
                                <td> <b> Beneficiary Account </b> </td>
                                <td> <b> Amount (SLL) </b> </td>
                                <td> <b> Order Date </b> </td>
                                <td> <b> End Date </b> </td>
                                <td> <b> Frequency </b> </td>
                                <td> <b> First Payment </b> </td>
                                <td> <b> Last Payment </b> </td>
                                <td> <b> Cancel </b> </td>
                            </tr>
                        </thead>
                        <tbody class="standing_order_details">
                            <td colspan="100%" class="text-center">
                                {!! $noDataAvailable !!}
                            </td>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="dashboard site-card">
        <div class="tab-content dashboard-body border-danger border p-4">
            <div data-title="Account Tab" data-intro="Select account to display all standing orders">
                <label class="d-block mb-1 text-dark"> Select Account</label>
                <select data-style="" class="form-control accounts-select" id="from_account" required>
                    @include('snippets.accounts')
                </select>
            </div>
            <hr>
            <table class="table table-striped table-bordered display responsive nowrap w-100"
                id="standing_order_display_area">
                <thead>
                    <tr class="table-background ">
                        <th class="all"> Account No </th>
                        <th class="all"> Beneficiary Account </th>
                        <th class="all"> Amount </th>
                        <th class="all"> Order Date </th>
                        <th class="all"> End Date </th>
                        <th class="all"> Frequency </th>
                        <th class="none"> First Payment </th>
                        <th class="none"> Last Payment </th>
                        <th class="none"> Cancel </th>
                    </tr>
                </thead>
                <tbody class="standing_order_details">
                    <td colspan="100%" class="text-center">
                        {!! $noDataAvailable !!}
                    </td>

                </tbody>
            </table>
        </div>

    </div>
    @include('snippets.pinCodeModal')
@endsection

@section('scripts')
    @include('extras.datatables')
    <script>
        let noDataAvailable = {!! json_encode($noDataAvailable) !!}
        let account_data = new Object()
    </script>
    <script src="assets\js\pages\transfer\standingOrderStatus.js"></script>
@endsection
