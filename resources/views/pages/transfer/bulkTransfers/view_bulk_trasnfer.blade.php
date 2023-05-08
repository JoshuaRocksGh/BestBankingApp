@extends('layouts.master')


@section('content')
    @php
        $pageTitle = 'DETAIL OF BULK UPLOAD';
        $basePath = 'Bulk Transfer';
        $currentPath = 'Detail of Bulk Transfer';
    @endphp
    @include('snippets.pageHeader')


    <div class="dashboard site-card overflow-hidden">
        <div class=" dashboard-body p-4">
            {{-- <p class="text-muted font-14 m-b-20">
                            Parsley is a javascript form validation library. It helps you provide your
                            users with feedback on their form submission before sending it to your
                            server.
                            <hr>
                        </p> --}}
            <div class="card " style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;border-radius: 10px;">

                <div class="card-body">
                    <form class="parsley-examples" id="bulk_upload_form">
                        <div class="card-box col-md-12">



                            <div class="row">



                                <div class="col-md-3 text-center">
                                    <p class="mb-2 text-danger">Account Number</p>
                                    <h4 class="text-dark display_debit_account_no ">{{ $uploadDetails['debitAccount'] }}
                                    </h4>

                                </div>
                                <div class="col-md-3 text-center">
                                    <p class="mb-2 text-danger">Bulk Amount </p>
                                    <h4 class="text-dark display_total_amount ">
                                        {{ number_format($uploadDetails['totalAmount'], 2) }}</h4>

                                </div>

                                <div class="col-md-3 text-center ">
                                    <p class="mb-2 text-danger">Narration</p>
                                    <h4 class="text-dark display_narrations">{{ $uploadData[0]['transDescription'] }}</h4>

                                </div>
                                <div class="col-md-3text-center ">
                                    <p class="mb-2 text-danger">Batch Number </p>
                                    <h4 class="text-dark display_batch_no ">{{ $uploadData[0]['uploadBatch'] }}</h4>


                                </div>




                                <!-- end row -->



                            </div>
                            <br><br>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">

                                        <div class="col-md-4 float-left text-center">
                                            <button type="button"
                                                class="btn btn-secondary btn-sm  waves-effect waves-light disappear-after-success"
                                                id="reject_upload_btn">
                                                Reject Upload
                                                <i class="mdi mdi-cancel"></i>
                                            </button>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <button type="button"
                                                class="btn btn-xs btn-outline-dark waves-effect waves-light error_modal_data "
                                                data-toggle="modal" data-target="#bs-example-modal-lg">View</button>
                                        </div>
                                        <div class="col-md-4 float-right text-center">
                                            <button type="button" class="btn btn-success btn-sm  waves-effect waves-light"
                                                id="approve_upload_btn">
                                                Submit for Approval
                                                <i class="mdi mdi-check-all"></i>
                                            </button>
                                        </div>





                                    </div>
                                </div>
                            </div>

                        </div>
                        {{-- <button type="button" class="btn btn-primary hello_clicked">Hello</button> --}}


                    </form>

                </div>
            </div>











        </div>





    </div>

    <!--  Modal content for the Large example -->
    <div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Bulk Upload Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">

                    <div class="card-box" id="beneficiary_table" style="zoom: 0.8;">
                        <br>
                        <div class="col-md-12">

                            <table id="bulk_upload_list"
                                class="table table-bordered table-striped dt-responsive nowrap w-100 bulk_upload_list">

                                <thead>
                                    <tr class="table-background">
                                        <th>No</th>
                                        <th>Credit Acc</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Ref Number</th>
                                    </tr>
                                </thead>

                                <tbody class="">
                                    @if (isset($uploadData))
                                        @php
                                            $count = 1;
                                        @endphp
                                        @foreach ($uploadData as $data)
                                            <tr>
                                                <td>{{ $count }}</td>
                                                <td>{{ $data['accountNumber'] }}</td>
                                                <td>{{ $data['name'] }}</td>
                                                <td>{{ $data['amount'] }}</td>
                                                <td>{{ $data['refNumber'] }}</td>
                                            </tr>
                                            @php
                                                $count = $count + 1;
                                            @endphp
                                        @endforeach
                                    @endif
                                </tbody>


                            </table>
                        </div>

                    </div>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('scripts')
    @include('extras.datatables')

    <script type="text/javascript" src="{{ asset('assets/js/pages/transfer/view_bulk_transfer.js') }}"></script>
    <script type="text/javascript">
        //$("#bulk_upload_list").DataTable();

        //var nodes = table.rows().nodes();
        var batch_no = `{{ $batch_no }}`
    </script>
@endsection
