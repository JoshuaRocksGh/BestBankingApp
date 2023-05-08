@extends('layouts.master')

@section('styles')
    <style>
        @media print {
            #qr_form {
                display: none
            }

            #print_qr {
                display: none
            }

            #qr_image_div {
                width: 400px;
                height: 400px
            }
        }

        .subHeader {
            font-weight: 600;
            background-color: #17a2b8;
            color: white;
            margin-bottom: 2rem;
            border-radius: 0.5rem;
        }

        #qr_image_div {
            animation: slide-right 300ms ease-out;
        }
    </style>
@endsection
@section('content')
    @php
        $pageTitle = 'Generate QR';
        $currentPath = 'Generate QR';
        $basePath = 'Payment';
    @endphp
    @include('snippets.pageHeader')
    <div class="dashboard site-card ">
        <div class="dashboard-body p-4 row">
            <div class="col-md-7" id="qr_form">
                <h2 class="rounded-lg text-center text-white mb-4 p-2" style="background-color: #17a2b8">QR Content</h2>
                <form role="form" class="container">
                    <div class="mb-3">
                        <ul class="nav w-100 active nav-fill nav-pills" id="qr_type_switch" role="tablist">
                            <li class="nav-item w-50" role="presentation" style="position: absolute">
                                <button class="switch w-100  nav-link active" id="receive_payment_tab" data-toggle="pill"
                                    type="button" role="tab" aria-selected="false">
                                    Recieve Payment</button>
                            </li>
                            <li class="nav-item w-50" role="presentation">
                                <button class=" switch leftbtn w-100 nav-link " id="cash_in_tab" data-toggle="pill"
                                    type="button" role="tab" aria-selected="true">
                                    <div class="switch-text">Cash in</div>
                                </button>
                            </li>

                        </ul>
                    </div>
                    <div class="form-group  row">
                        <label for="accounts" class="text-dark col-form-label col-md-4">Select Account
                        </label>
                        <select class="form-control accounts-select col-md-8" id="accounts">
                            <option selected disabled value="">Select Account</option>
                            @include('snippets.accounts')
                        </select>
                    </div>

                    <div class="form-group row" id="amount_view">
                        <label for="pin" class="col-4 col-form-label text-dark">
                            Enter Amount </label>
                        <input type="number" class="form-control col-8" placeholder="Enter a fixed amount to receive"
                            id="amount" autocomplete="off"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                    </div>

                    <div class="form-group row float-right mt-2">
                        <button type="button" class="btn btn-rounded form-button" id="generate_qr">
                            Generate QR Photo
                        </button>
                    </div>
                </form>
            </div>

            <div class="col-md-5 text-center" id="qr_image_div">
                <h2 class="rounded-lg text-white mb-4 p-2" style="background-color: #17a2b8">QR Image</h2>
                <p id="qrcode"> </p>
                <div class="form-group row float-right mt-2">
                    <button type="button" class="btn btn-dark btn-rounded" id="print_qr" onclick='window.print()'>
                        Print QR
                    </button>
                </div>
            </div> <!-- end col -->

        </div> <!-- end col -->
    </div>
@endsection

@section('scripts')
    <script src="assets/plugins/easy-qr-code-js/easy.qrcode.min.js" defer></script>
    <script src="assets/js/pages/payments/qr_payment.js"></script>
@endsection
