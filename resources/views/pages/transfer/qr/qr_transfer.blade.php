@extends('layouts.master')

@section('content')

    <div>


        <div class="container-fluid">
            <br>
            <!-- start page title -->
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-primary">
                        <img src="{{ asset('assets/images/logoRKB.png') }}" alt="logo" style="zoom: 0.05">&emsp;
                        GENERATE QR
                    </h4>
                </div>

                <div class="col-md-6 text-right">
                    <h6>

                        <span class="flaot-right">
                            <b class="text-primary"> Payment </b> &nbsp; > &nbsp; <b class="text-danger">Generate QR</b>


                        </span>

                    </h6>

                </div>

                <div class="col-md-12 ">
                    <hr class="text-primary" style="margin: 0px;">
                </div>

            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-12">

                            <div class="row">

                                <div class="col-md-1"></div>

                                <div class="col-md-10 m-2"
                                    style="background-image: linear-gradient(to bottom right, white, rgb(223, 225, 226));">

                                    <div class="row">

                                        <div class="col-md-7" id="request_form_div">
                                            <br><br><br>
                                            <div class="">

                                                <table class="table mb-0 table-striped table-bordered">

                                                    <tbody>
                                                        <tr class="bg-primary text-white">
                                                            <td>QR Content</td>
                                                        </tr>

                                                        <tr>
                                                        </tr>

                                                    </tbody>


                                                </table>

                                                <p>


                                                <form role="form" class="parsley-examples">
                                                    <div class="container">
                                                        <div class="form-group row">
                                                            <b for="inputEmail3" class="text-primary col-md-4">My Account
                                                                &nbsp;<span class="text-danger ">*</span></b>
                                                            <div class="col-md-8">
                                                                <select class="custom-select text-primary" id="my_account"
                                                                    required>
                                                                    <option value="">Select Account</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <b for="hori-pass2" class="col-4 col-form-label text-primary">
                                                                Enter Amount &nbsp;
                                                                <span class="text-danger">*</span></b>
                                                            <div class="col-8">
                                                                <input type="text" class="form-control" id="pin"
                                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">

                                                            </div>
                                                        </div>
                                                    </div>






                                                    <div class="form-group row">
                                                        <div class="col-8 offset-4 text-right">
                                                            <button type="button"
                                                                class="btn btn-primary btn-rounded waves-effect waves-light disappear-after-success"
                                                                id="submit_cheque_request">
                                                                Generate QR Photo
                                                            </button>

                                                        </div>
                                                    </div>


                                                    {{-- <div class="form-group row">


                                                            <div class="col-7 offset-4 text-right">

                                                                <button type="button"
                                                                    class="btn btn-primary btn-rounded waves-effect waves-light">
                                                                    Submit
                                                                </button>

                                                            </div>


                                                    </div> --}}


                                                </form>

                                                </p>


                                            </div> <!-- end card-box -->


                                        </div>


                                        <div class="col-md-5 disappear-after-success" id="request_detail_div">
                                            <br><br><br>
                                            <table class="table mb-0 table-striped table-bordered">

                                                <tbody>
                                                    <tr class="bg-primary text-white">
                                                        <td>QR Image</td>
                                                    </tr>
                                                    <tr class="">

                                                        <td>
                                                            <p>
                                                                <img src="{{ asset('assets/images/qr.png') }}"
                                                                    class="img-fluid" alt="">
                                                            </p>
                                                        </td>



                                                    </tr>


                                                </tbody>

                                            </table>

                                            <br>


                                        </div> <!-- end col -->

                                        <div class="col-md-5 text-center">
                                            {{-- <span class="hh"><span> --}}
                                            <p class="display-4 text-center text-success success-message ">

                                            </p>
                                        </div>


                                        <!-- end row -->



                                    </div>

                                </div>

                                <div class="col-md-1"></div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- <div class="row">
                    <div class="col-md-1"></div>

                    <div class=" card card-body col-md-10">
                        <h2 class="header-title m-t-0 text-primary">GENERATE QR TO RECIEVE PAYMENT</h2>
                        <hr>





                    </div>

                    <div class="col-md-1"></div>

                </div> --}}

            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
    <script>
        var qr;
    </script>


    <script>
        function my_account() {
            $.ajax({
                type: 'GET',
                url: 'get-my-account',
                datatype: "application/json",
                success: function(response) {
                    console.log(response.data);
                    let data = response.data
                    $.each(data, function(index) {

                        $('#my_account').append($('<option>', {
                            value: data[index].accountType + '~' + data[index].accountDesc +
                                '~' + data[index].accountNumber + '~' + data[index]
                                .currency + '~' + data[index].availableBalance
                        }).text(data[index].accountType + '~' + data[index].accountNumber +
                            '~' + data[index].currency + '~' + data[index].availableBalance));

                    });
                },

            })
        }



        function branches() {
            $.ajax({
                type: 'GET',
                url: 'get-bank-branches-list-api',
                datatype: "application/json",
                success: function(response) {
                    console.log(response.data);
                    let data = response.data
                    $.each(data, function(index) {

                        $('#branch').append($('<option>', {
                            value: data[index].branchCode + '~' + data[index]
                                .branchDescription
                        }).text(data[index].branchDescription));

                    });
                },

            })
        }



        function formatToCurrency(amount) {
            return amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
        };


        function toaster(message, icon, timer) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: timer,
                timerProgressBar: false,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: icon,
                title: message
            })
        }



        $(document).ready(function() {

            setTimeout(function() {
                branches()
                my_account()
            }, 1000)



            $("#my_account").change(function() {
                var my_account = $(this).val()

                my_account_info = my_account.split("~")
                // set summary values for display
                $(".display_my_account_type").text(my_account_info[0].trim())
                $(".display_my_account_name").text(my_account_info[1].trim())
                $(".display_my_account_no").text(my_account_info[2].trim())
                $(".display_my_account_currency").text(my_account_info[3].trim())

                $(".display_currency").text(my_account_info[3].trim()) // set summary currency

                $(".display_my_account_amount").text(formatToCurrency(parseFloat(my_account_info[4]
                    .trim())))

                console.log
                {{-- alert('and show' + my_account_info[3].trim()) --}}
                $(".my_account_display_info").show()





                // alert(my_account_info[0]);
            });


            $("#leaflet").change(function() {
                $('.display_leaflet').text("")
                var leaflet = $(this).val()
                if (leaflet != "") {
                    $('.display_leaflet').text("Leaflet: " + leaflet)
                }


            })




            $("#branch").change(function() {
                $('.display_branch').text("")
                var branch = $(this).val()
                if (branch != "") {
                    let branch_info = branch.split("~")
                    console.log(branch)
                    $('.display_branch').text("Pickup Branch: " + branch_info[1])
                }


            })

            $("#submit_cheque_request").click(function() {

                //MY ACCOUNT
                let my_account = $('#my_account').val()
                //Leaflet
                let leaflet = $('#leaflet').val()
                //branch
                let branch = $('#branch').val()

                let pin = $('#pin').val()





                if (branch == "" || my_account == "" || leaflet == "" || pin == "") {
                    toaster("Please fill all required fieilds", "error", 6000);
                } else {

                    let branch_info = branch.split("~")
                    let branchCode = branch_info[0]

                    my_account_info = my_account.split("~")
                    let accountNumber = my_account_info[2].trim()


                    $.ajax({

                        type: 'POST',
                        url: 'submit-cheque-book-request',
                        datatype: "application/json",
                        'data': {
                            'accountNumber': accountNumber.trim(),
                            'branchCode': branchCode.trim(),
                            'leaflet': leaflet.trim(),
                            'pinCode': pin
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {

                            console.log(response)

                            if (response.responseCode == '000') {
                                toaster(response.message, 'success', 200000)
                                $("#request_form_div").hide()
                                $(".disappear-after-success").hide()
                                $(".success-message").html(
                                    '<img src="{{ asset('land_asset/images/statement_success.gif') }}" />'
                                )
                                {{-- $(".hh").text(response.message) --}}
                                $("#request_detail_div").show()


                            } else {

                                toaster(response.message, 'error', 9000);


                            }
                        }

                    })


                }
            })


        });
    </script>
@endsection