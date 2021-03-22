@extends('layouts.master')

@section('styles')

    <!-- third party css -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- third party css end -->

    <style>

    </style>

@endsection

@section('content')

    <div>

        <div class="row">
            <br>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-12">


                                <div class="tab-content">
                                    <div class="tab-pane show active" id="transfer_tab">

                                        <div class="card-body">

                                            {{-- <h4 class="header-title">Buttons example</h4>
                                            <p class="sub-header font-13">
                                                The Buttons extension for DataTables provides a common set of options, API
                                                methods and styling to display buttons on a page
                                                that will interact with a DataTable. The core library provides the based
                                                framework upon which plug-ins can built.
                                            </p> --}}

                                            <table id="datatable-buttons" style="zoom:0.9;" class="table table-striped dt-responsive nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Posting Date</th>
                                                        <th>Value Date</th>
                                                        <th style="width: 190px;">Transaction Details</th>
                                                        <th>Document Ref</th>
                                                        <th>Batch No</th>
                                                        <th>Debit</th>
                                                        <th>Credit</th>
                                                        <th>Balance</th>
                                                    </tr>
                                                </thead>


                                                <tbody>

                                                    <tr>
                                                        <td>01-Mar-2018</td>
                                                        <td>02-OCT-2018</td>
                                                        <td>Balance Brought Forword</td>
                                                        <td>00000000</td>
                                                        <td>
                                                            <!-- Info Alert modal -->
                                                                <a type="button" data-toggle="modal" data-target="#bs-example-modal-xl" class="text-primary">000000</a>
                                                        </td>
                                                        <td>.00</td>
                                                        <td>.00</td>
                                                        <td>.00</td>

                                                    </tr>

                                                    <tr>
                                                        <td>01-Mar-2018</td>
                                                        <td>02-OCT-2018</td>
                                                        <td>CASH DEPOSIT GABRIL KARGBO</td>
                                                        <td>004004085750200162</td>
                                                        <td>
                                                            <!-- Info Alert modal -->
                                                                <a type="button" data-toggle="modal" data-target="#bs-example-modal-xl" class="text-primary">201810031437</a>
                                                        </td>
                                                        <td></td>
                                                        <td>600,000.00</td>
                                                        <td>600,000.00</td>

                                                    </tr>
                                                    <tr>
                                                        <td>01-Mar-2018</td>
                                                        <td>02-OCT-2018</td>
                                                        <td>Balance Brought Forward</td>
                                                        <td>00000000</td>
                                                        <td>
                                                            <!-- Info Alert modal -->
                                                                <a type="button" data-toggle="modal" data-target="#bs-example-modal-xl" class="text-primary">000000</a>
                                                        </td>
                                                        <td>.00</td>
                                                        <td>.00</td>
                                                        <td>.00</td>

                                                    </tr>
                                                    <tr>
                                                        <td>01-Mar-2018</td>
                                                        <td>02-OCT-2018</td>
                                                        <td>Balance Brought Forward</td>
                                                        <td>00000000</td>
                                                        <td>
                                                            <!-- Info Alert modal -->
                                                                <a type="button" data-toggle="modal" data-target="#bs-example-modal-xl" class="text-primary">000000</a>
                                                        </td>
                                                        <td>.00</td>
                                                        <td>.00</td>
                                                        <td>.00</td>

                                                    </tr>
                                                    <tr>
                                                        <td>01-Mar-2018</td>
                                                        <td>02-OCT-2018</td>
                                                        <td>Balance Brought Forward</td>
                                                        <td>00000000</td>
                                                        <td>
                                                            <!-- Info Alert modal -->
                                                                <a type="button" data-toggle="modal" data-target="#bs-example-modal-lg" class="text-primary">000000</a>
                                                        </td>
                                                        <td>.00</td>
                                                        <td>.00</td>
                                                        <td>.00</td>

                                                    </tr>
                                                    <tr>
                                                        <td>01-Mar-2018</td>
                                                        <td>02-OCT-2018</td>
                                                        <td>Balance Brought Forward</td>
                                                        <td>00000000</td>
                                                        <td>
                                                            <!-- Info Alert modal -->
                                                                <a type="button" data-toggle="modal" data-target="#bs-example-modal-lg" class="text-primary">000000</a>
                                                        </td>
                                                        <td>.00</td>
                                                        <td>.00</td>
                                                        <td>.00</td>

                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div> <!-- end card body-->


                                    </div>

                                </div>
                            </div>



                        </div> <!-- end card-body -->



                    </div> <!-- end col -->

                </div> <!-- end row -->



            </div>

            <!--  Modal content for the Large example -->
            <div class="modal fade" id="bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Batch Trans</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <button type="button" class="btn btn-light" >Print</button>
                            <button type="button" class="btn btn-success">Excel</button>
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th title="Account Number">Ac No</th>
                                                        <th style="width: 150px"title="Account Description">Ac Des</th>
                                                        <th style="width: 200px;">Transaction Details</th>
                                                        <th title="Document Ref">Doc Ref</th>
                                                        <th title="Currency">CCY</th>
                                                        <th>Debit</th>
                                                        <th>Credit</th>
                                                    </tr>
                                                </thead>


                                                <tbody>
                                                    <tr>
                                                        <td>13210000010</td>
                                                        <td>SERVICES/PENALTY CHARGE</td>
                                                        <td>SAVINGS ID CARD FEE</td>
                                                        <td>201810031437</td>
                                                        <td>SLL</td>
                                                        <td>15,000.00</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>13210000010</td>
                                                        <td>SERVICES/PENALTY CHARGE</td>
                                                        <td>SAVINGS ID CARD FEE</td>
                                                        <td>201810031437</td>
                                                        <td>SLL</td>
                                                        <td></td>
                                                        <td>15,000.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>13210000010</td>
                                                        <td>SERVICES/PENALTY CHARGE</td>
                                                        <td>SAVINGS ID CARD FEE</td>
                                                        <td>201810031437</td>
                                                        <td>SLL</td>
                                                        <td>15,000.00</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>13210000010</td>
                                                        <td>SERVICES/PENALTY CHARGE</td>
                                                        <td>SAVINGS ID CARD FEE</td>
                                                        <td>201810031437</td>
                                                        <td>SLL</td>
                                                        <td></td>
                                                        <td>2,250.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->


        @endsection

        @section('scripts')

            <!-- third party js -->
            <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
            <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
            <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
            <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}">
            </script>
            <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
            <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
            <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
            <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
            <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
            <script src="{{ asset('assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
            <script src="{{ asset('assets/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>
            <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
            <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
            <!-- third party js ends -->

            <!-- Datatables init -->
            <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>

        @endsection
