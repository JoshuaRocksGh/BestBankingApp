@extends('layouts.master')

@section('content')

<div    <legend></legend>

    <div class="row">
        <div class="col-12">
            <div class="card" style="background-image: url('assets/images/background.png'); background-repeat: no-repeat; background-size: cover;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2"></div>

                        <div class="col-md-8">
                            <p class="sub-header font-18 purple-color">
                                OTHER LOCAL BANK TRANSFER

                            </p>
                            <hr>


                            <div class="row" id="transaction_form">


                                <div class="col-md-7">
                                    <form action="#" id="payment_details_form" autocomplete="off" aria-autocomplete="none">
                                        @csrf
                                        <div class="form-group">
                                            <label class="h6">Payer Account</label>


                                            <select class="custom-select " id="from_account" required>
                                                <option value="">Select Account</option>
                                                <option value="CA - PERSONAL ~kwabeane Ampah~001023468976001~GHS~2000">
                                                    Current Account ~ 001023468976001 </option>

                                            </select>


                                            <table
                                                class="table-responsive table table-centered table-nowrap mb-0 from_account_display_info">
                                                <tbody class="text-primary">
                                                    <tr class="text-primary">

                                                        <td class="text-primary">
                                                            <a
                                                                class="text-body font-weight-semibold display_from_account_name text-primary"></a>
                                                            <small class="d-block display_from_account_no text-primary"></small>
                                                        </td>

                                                        <td class="text-right font-weight-semibold text-primary">
                                                            <span class="display_from_account_currency text-primary"></span>
                                                            <span class="display_from_account_amount text-primary"></span>

                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table>


                                        </div>

                                        <div class="form-group">

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input radio" type="radio" name="onetime" id="inlineRadio1" value="beneficiary" checked="checked">
                                                <label class="form-check-label" for="inlineRadio1">Select beneficiary</label>
                                            </div>
                                            &nbsp;&nbsp;
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input radio" type="radio" name="onetime" id="inlineRadio2" value="onetime">
                                                <label class="form-check-label" for="inlineRadio2">Onetime beneficiary</label>
                                            </div>
                                        </div>


                                        <div class="form-group select_beneficiary" >
                                            <label class="h6">Beneficiary Account</label>
                                            <br>

                                            <label for="form-group">Select Account</label>
                                            <select class="custom-select" id="to_account" required>
                                                <option value="">Select Account</option>
                                                <option value="Standard Chartered Bank~Joshua Amarfio~004004110449140121~GHS~800">
                                                    Currenct Account ~ 004004110449140121 </option>
                                            </select>


                                            <table
                                                class="table-responsive table table-centered table-nowrap mb-0 to_account_display_info">
                                                <tbody>
                                                    <tr>

                                                        <td>
                                                            <a
                                                                class="text-body font-weight-semibold display_to_account_name"></a>
                                                            <small class="d-block display_to_account_no"></small>
                                                        </td>

                                                        <td class="text-right font-weight-semibold">
                                                            <span class="display_to_account_currency"></span>
                                                            <span class="display_to_account_amount"></span>

                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table>


                                        </div>

                                        <div class="select_onetime">
                                        <hr>
                                            <div class="form-group">
                                                 <label class="">Alias Name</label>
                                                <input type="text" class="form-control" id="onetime_beneficiary_alias_name"
                                                   placeholder="Alias Name"
                                                    required>
                                            </div>

                                            <div class="form-group">
                                                <label class="">Bank Name</label>
                                               <input type="email" class="form-control" id="onetime_beneficiary_bank_name"
                                                  placeholder="Bank Name"
                                                   required>
                                           </div>

                                            <div class="form-group">
                                                 <label class="">Account Number</label>
                                                <input type="text" class="form-control" id="onetime_beneficiary_account_number"
                                                   placeholder="Account Number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                                    required>
                                            </div>

                                            <div class="form-group">
                                                <label class="">Select Currency</label>

                                                <select class="custom-select" id="onetime_beneficiary_account_currency" required>
                                                    <option value="">Select Currency</option>
                                                    <option value="GHS">GHS</option>
                                                    <option value="USD">USD</option>
                                                    <option value="EURO">EURO</option>
                                                    <option value="SLL">SLL</option>
                                                    <option value="GBP">GBP</option>
                                                </select>

                                            </div>







                                            <div class="form-group">
                                                 <label class="">Enter Telephone Number</label>
                                                <input type="text" class="form-control" id="onetime_beneficiary_phone"
                                                   placeholder="Phone"
                                                    required>
                                            </div>
                                            <hr>

                                        </div>

                                        <div class="form-group">
                                            <label for="form-group"> Amount</label>
                                             <label class="">Enter Amount</label>
                                            <input type="text" class="form-control" id="amount" placeholder="Amount: 0.00"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label class="h6">Category</label>
                                            <label for="form-group">Category</label>
                                            <select class="custom-select" id="category" required>
                                                <option value="">Select Category</option>
                                                <option value="001~Fees">Fees</option>
                                                <option value="002~Electronics">Electronics</option>
                                                <option value="003~Travels">Travels</option>
                                            </select>

                                        </div>


                                        <div class="form-group">
                                            <label for="form-group">Enter Naration</label>

                                            <input type="text" class="form-control" id="purpose" placeholder="Enter purpose / narration" required>

                                        </div>


                                        <div class="form-group">

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1">Schedule
                                                    Payments</label>
                                            </div>
                                            <legend></legend>

                                            <input type="text" class="form-control" id="schedule_payment_contraint_input">

                                            <input type="date" class="form-control" id="schedule_payment_date">

                                        </div>



                                        <div class="form-group text-right">
                                            <button class="btn btn-primary btn-rounded" type="button" id="next_button">
                                                &nbsp; Next &nbsp;</button>
                                        </div>




                                    </form>
                                </div> <!-- end col -->



                                <div class="col-md-5 text-center" style="margin-top: 80px;">

                                    <img src="{{ asset('assets/images/same_bank.jpg') }}" class="img-fluid" alt="">
                                </div> <!-- end col -->


                                <!-- end row -->



                            </div>

                            <div class="row" id="transaction_summary">


                                <div class="col-md-12">
                                    <div class="border p-3 mt-4 mt-lg-0 rounded">
                                        <h4 class="header-title mb-3">Transfer Detail Summary</h4>

                                        <div class="table-responsive">
                                            <table class="table mb-0">

                                                <tbody>
                                                    <tr>
                                                        <td>From Account:</td>
                                                        <td>
                                                            <span
                                                                class="font-13 text-primary text-bold display_from_account_type"
                                                                id="display_from_account_type"></span>
                                                            <span
                                                                class="d-block font-13 text-primary text-bold display_from_account_name"
                                                                id="display_from_account_name"> </span>
                                                            <span
                                                                class="d-block font-13 text-primary text-bold display_from_account_no"
                                                                id="display_from_account_no"></span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>To Account:</td>
                                                        <td>

                                                            <span
                                                                class="font-13 text-primary text-bold display_to_account_type"
                                                                id="display_to_account_type"> </span>
                                                            <span
                                                                class="d-block font-13 text-primary text-bold display_to_account_name"
                                                                id="display_to_account_name"> </span>
                                                            <span
                                                                class="d-block font-13 text-primary text-bold online_display_beneficiary_email"
                                                                id="online_display_beneficiary_bank_name"></span>
                                                            <span
                                                                class="d-block font-13 text-primary text-bold display_to_account_no"
                                                                id="display_to_account_no"> </span>


                                                            <span
                                                                class="d-block font-13 text-primary text-bold display_to_account_name"
                                                                id="online_display_beneficiary_alias_name"> Daniel Hammond</span>

                                                            <span class="font-13 text-primary h3 online_display_beneficiary_account_no"
                                                                id="">0000333030303 </span>
                                                                &nbsp; | &nbsp;
                                                            <span class="font-13 text-primary h3 online_display_beneficiary_account_currency" id=""> GHS
                                                            </span>

                                                            <span
                                                            class="d-block font-13 text-primary text-bold online_display_beneficiary_phone"
                                                            id="online_display_beneficiary_phone">0554602954</span>


                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Amount:</td>
                                                        <td>
                                                            <span class="font-15 text-primary h3 display_currency"
                                                                id="display_currency"> </span>
                                                            &nbsp;
                                                            <span class="font-15 text-primary h3 display_transfer_amount"
                                                                id="display_transfer_amount"></span>

                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td>Category:</td>
                                                        <td>
                                                            <span class="font-13 text-primary h3 display_category"
                                                                id="display_category"></span>

                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td>Purpose:</td>
                                                        <td>
                                                            <span class="font-13 text-primary h3 display_purpose"
                                                                id="display_purpose"></span>
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td>Schedule Payment:</td>
                                                        <td>
                                                            <span class="font-13 text-primary h3 display_schedule_payment"
                                                                id="display_schedule_payment">NO </span>
                                                                &nbsp; | &nbsp;
                                                            <span class="font-13 text-primary h3 display_schedule_payment_date" id="display_schedule_payment_date"> N/A
                                                            </span>
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td>Transfer Date: </td>
                                                        <td>
                                                            <span class="font-13 text-primary h3"
                                                                id="display_transfer_date">{{  date('d F, Y') }}</span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Posted BY: </td>
                                                        <td>
                                                            <span class="font-13 text-primary h3"
                                                                id="display_posted_by">Kwabena Ampah</span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Enter Pin: </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" name="user_pin" class="form-control"
                                                                    id="user_pin"
                                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                                            </div>
                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- end table-responsive -->
                                        <br>
                                        <div class="form-group text-center">

                                            <span> <button class="btn btn-secondary btn-rounded" type="button"
                                                    id="back_button">Back</button> &nbsp; </span>
                                            <span>&nbsp; <button class="btn btn-primary btn-rounded" type="submit"
                                                    id="confirm_button">Confirm Transfer </button></span>
                                            <span>&nbsp; <button class="btn btn-light btn-rounded" type="button"
                                                    id="print_button" onclick="window.print()">Print Receipt </button></span>
                                        </div>
                                    </div>

                                </div> <!-- end col -->





                            </div>



                        </div>

                        <div class="col-md-2"></div>

                    </div> <!-- end card-body -->


                    <!-- Modal -->
                    <div id="multiple-one" class="modal fade" tabindex="-1" role="dialog"
                        aria-labelledby="multiple-oneModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="POST" id="confirm_details" autocomplete="off" aria-autocomplete="off">
                                    <div class="modal-header">
                                        <h4 class="modal-title font-16 purple-color" id="multiple-oneModalLabel">Confirm
                                            Details</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">×</button>
                                    </div>

                                    <div class="modal-body">

                                        From: <span class="font-13 text-primary" id="display_from_account"> &nbsp
                                        </span><br><br>
                                        To: <span class="font-13 text-muted" id="display_to_account"> &nbsp </span><br><br>
                                        Schedule Payments: <span class="font-13 text-muted" id="display_payments"> &nbsp
                                        </span><br><br>
                                        Amount: <span class="font-13 text-muted" id="display_amount"> &nbsp </span><br><br>
                                        Naration: <span class="font-13 text-muted" id="display_naration"> &nbsp
                                        </span><br><br>
                                        Transaction fee: <span class="font-13 text-muted" id="display_trasaction_fee">
                                        </span><br><br>
                                        Total: <span class="font-13 text-muted" id="display_total"> &nbsp </span><br><br>

                                        <div class="form-group">
                                            <label class="font-16 purple-color">Enter Pin</label>
                                            <input type="text" class="form-control" id="pin" data-toggle="input-mask"
                                                placeholder="enter pin" required
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">

                                        </div>

                                    </div>



                                    <div class="modal-footer">
                                        <button type="send" id="send" class="btn btn-primary" data-target="#multiple-two"
                                            data-toggle="modal" data-dismiss="modal">Send</button>
                                    </div>
                                </form>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->




                </div> <!-- end col -->

            </div> <!-- end row -->



        </div>


        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        <script>
            $(document).ready(function() {



                function toaster(message, icon )
                {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 10000,
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
                };

                $(".select_onetime").css("display", "none");
                $(".select_beneficiary").css("display", "block");

               // $(".select_beneficiary").show();
                //$(".select_onetime").hide();

                var type = $("input[type='radio']:checked").val();

                $(".radio").click(function(){

                    var type = $("input[type='radio']:checked").val();

                    if(type == 'beneficiary'){
                        $(".select_onetime").css("display", "none");
                        $(".select_beneficiary").css("display", "block");

                        // set amonut to empty
                        $("#amount").val('');


                        //$(".select_onetime").hide();
                        //$(".select_beneficiary").show();

                    }
                    if(type == 'onetime'){

                        $(".select_beneficiary").css("display", "none");
                        $(".select_onetime").css("display", "block");

                        // set amonut to empty
                        $("#amount").val('');

                       // $(".select_beneficiary").hide();
                        //$(".select_onetime").show();
                    }

                });



                // hide seleect accounts info
                $(".from_account_display_info").hide()
                $(".to_account_display_info").hide()
                $("#schedule_payment_date").hide()
                $('#schedule_payment_contraint_input').hide()
                $('.display_schedule_payment_date').text('N/A'),
                $('#select_frequency').hide(),
                $('#select_frequency_text').hide(),

                $("#transaction_form").show()
                $("#transaction_summary").hide()

                {{--  $("#next_button").click(function(e) {
                    e.preventDefault()
                    $("#transaction_form").hide()
                    $("#transaction_summary").show()
                })  --}}

                $("#back_button").click(function(e) {
                    e.preventDefault()
                    $("#transaction_summary").hide()
                    $("#transaction_form").show()

                })

                {{-- Event on From Account field --}}

                $("#from_account").change(function() {
                    var from_account = $(this).val()
                    {{-- alert(from_account) --}}
                    if (from_account.trim() == '' || from_account.trim() == undefined) {
                        {{-- alert('money') --}}
                        $(".from_account_display_info").hide()

                    } else {
                        from_account_info = from_account.split("~")
                        {{-- alert('continue') --}}

                        var to_account = $('#to_account').val()

                        if ((from_account.trim() == to_account.trim()) && from_account.trim() != '' &&
                            to_account.trim() != '') {
                            toaster('can not transfer to same account','error')
                            {{--  alert('can not transfer to same account')  --}}
                            $(this).val('')
                        }

                        // set summary values for display
                        $(".display_from_account_type").text(from_account_info[0].trim())
                        $(".display_from_account_name").text(from_account_info[1].trim())
                        $(".display_from_account_no").text(from_account_info[2].trim())
                        $(".display_from_account_currency").text(from_account_info[3].trim())

                        $(".display_currency").text(from_account_info[3].trim()) // set summary currency

                        $(".display_from_account_amount").text(formatToCurrency(Number(from_account_info[4]
                            .trim())))
                        {{-- alert('and show' + from_account_info[3].trim()) --}}
                        $(".from_account_display_info").show()
                    }




                    // alert(from_account_info[0]);
                });


                $("#to_account").change(function() {
                    var to_account = $(this).val()
                    {{-- alert(to_account) --}}
                    if (to_account.trim() == '' || to_account.trim() == undefined) {

                        $(".to_account_display_info").hide()

                    } else {
                        to_account_info = to_account.split("~")


                        var from_account = $('#from_account').val()

                        if ((from_account.trim() == to_account.trim()) && from_account.trim() != '' &&
                            to_account.trim() != '') {
                            toaster('can not transfer to same account','error')
                            {{--  alert('can not transfer to same account')  --}}
                            $(this).val('')
                        }

                        // set summary values for display
                        $(".display_to_account_type").text(to_account_info[0].trim())
                        $(".display_to_account_name").text(to_account_info[1].trim())
                        $(".display_to_account_no").text(to_account_info[2].trim())
                        $(".display_to_account_currency").text(to_account_info[3].trim())
                        $(".display_to_account_amount").text(formatToCurrency(Number(to_account_info[4].trim())))

                        $(".to_account_display_info").show()
                    }




                    // alert(to_account_info[0]);
                });


                $("#amount").keyup(function() {

                    var type = $("input[type='radio']:checked").val();
                    //alert(type);
                    //return false;

                    if(type == 'beneficiary'){
                        var from_account = $('#from_account').val()
                        var to_account = $('#to_account').val()

                        if (from_account.trim() == '' || to_account.trim() == '') {
                            toaster('Please select source and destination accounts','error')
                            {{--  alert('Please select source and destination accounts')  --}}
                            $(this).val('')
                            return false;
                        } else {
                            var transfer_amount = $(this).val()
                            $(".display_transfer_amount").text(formatToCurrency(Number(transfer_amount.trim())))
                        }

                    }
                    else if(type == 'onetime'){

                        var from_account = $('#from_account').val()
                        var onetime_beneficiary_alias_name = $('#onetime_beneficiary_alias_name').val()
                        var onetime_beneficiary_account_number = $('#onetime_beneficiary_account_number').val()
                        var onetime_beneficiary_account_currency = $('#onetime_beneficiary_account_currency').val()
                        var onetime_beneficiary_bank_name = $('#onetime_beneficiary_bank_name').val()
                        var onetime_beneficiary_phone = $('#onetime_beneficiary_phone').val()

                        {{-- console.log(onetime_beneficiary_alias_name)
                        console.log(onetime_beneficiary_account_number)
                        console.log(onetime_beneficiary_account_currency) --}}


                        if (from_account.trim() == '' || onetime_beneficiary_alias_name.trim() == '' || onetime_beneficiary_account_number.trim() == '' || onetime_beneficiary_account_currency.trim() == '') {
                            toaster('Please select source and destination accounts','error')
                            {{--  alert('Please select source and destination accounts')  --}}
                            $(this).val('')
                            return false;
                        } else {
                            //alert('set')
                            var transfer_amount = $(this).val()
                            $(".display_transfer_amount").text(formatToCurrency(Number(transfer_amount.trim())))
                        }

                    }else{
                        alert( type + ' 00000000 Select either beneficiary or onetime beneficiary')
                        $(this).val('')
                        return false;
                    }




                })


                function formatToCurrency(amount) {
                    return amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
                };


                // CHECK BOX CONSTRAINT SCHEDULE PAYMENT
                $("input:checkbox").on("change", function() {
                    if ($(this).is(":checked")) {
                        {{-- console.log("Checkbox Checked!"); --}}
                        $("#schedule_payment_date").show(),
                        $(".display_schedule_payment").text('YES'),
                        $('#schedule_payment_contraint_input').val('TRUE'),
                        $('#select_frequency').show();
                        $('#select_frequency_text').show();

                    } else {
                        {{-- console.log("Checkbox UnChecked!"); --}}
                        $("#schedule_payment_date").val('')
                        $("#schedule_payment_date").hide()
                        $('.display_schedule_payment').text('NO')
                        $('.display_schedule_payment_date').text('N/A')

                        $('#schedule_payment_contraint_input').val('')
                        $('#schedule_payment_contraint_input').hide(),
                        $('#schedule_payment_date').val(''),
                        $('#select_frequency').hide();
                        $('#select_frequency_text').hide();
                    }
                });





                // NEXT BUTTON CLICK
                $("#next_button").click(function() {

                    var type = $("input[type='radio']:checked").val();

                    var from_account = $('#from_account').val()
                    var transfer_amount = $('#amount').val()
                    var category = $('#category').val()
                    var purpose = $('#purpose').val()
                    var schedule_payment_contraint_input = $('#schedule_payment_contraint_input').val()
                    var schedule_payment_date = $('#schedule_payment_date').val();

                    if (from_account.trim() == '' || transfer_amount.trim() == '' || category.trim() == '' || purpose.trim() == '' ) {
                        toaster('Field must not be empty','error');
                        return false

                    }

                    //set purpose and category values
                    var category_info = category.split("~")
                    $("#display_category").text(category_info[1])
                    $("#display_purpose").text(purpose)

                    $("#transaction_form").hide()
                    $("#transaction_summary").show()
                    $('#print_button').hide();



                    if(schedule_payment_contraint_input.trim() != '' && schedule_payment_date.trim() == ''){
                        $('.display_schedule_payment_date').text('N/A') // shedule date NULL
                        toaster('Select schedule date for subsequent transfers','error')
                        {{--  alert('Select schedule date for subsequent transfers')  --}}
                        return false
                    }

                    $('.display_schedule_payment_date').text(schedule_payment_date)

                    if(type == 'beneficiary'){

                        var to_account = $('#to_account').val()

                        $('.display_schedule_payment_date').text(schedule_payment_date)


                        if (from_account.trim() == '' || to_account.trim() == '' || transfer_amount.trim() == '' || category.trim() == '' || purpose.trim() == '' ) {
                            toaster('Field must not be empty','error');
                            {{--  alert('Field must not be empty')  --}}
                            return false
                        }else{
                            //set purpose and category values
                            var category_info = category.split("~")
                            $("#display_category").text(category_info[1])
                            $("#display_purpose").text(purpose)

                            $("#transaction_form").hide()
                            $("#transaction_summary").show()
                        }




                    }else if(type == 'onetime'){

                        var from_account = $('#from_account').val()

                        // ONETIME BENEFICIARY DETAILS
                        var onetime_beneficiary_alias_name = $('#onetime_beneficiary_alias_name').val()
                        var onetime_beneficiary_account_number = $('#onetime_beneficiary_account_number').val()
                        var onetime_beneficiary_account_currency = $('#onetime_beneficiary_account_currency').val()
                        var onetime_beneficiary_name = $('#onetime_beneficiary_name').val()
                        var onetime_beneficiary_bank_name = $('#onetime_beneficiary_bank_name').val()
                        var onetime_beneficiary_phone = $('#onetime_beneficiary_phone').val()


                        {{-- console.log(onetime_beneficiary_alias_name)
                        console.log(onetime_beneficiary_account_number)
                        console.log(onetime_beneficiary_account_currency) --}}


                        // END OF ONETIME BENEFICIARY DETAILS


                        if (from_account.trim() == '' || onetime_beneficiary_account_number.trim() == '' || transfer_amount.trim() == '' || category.trim() == '' || purpose.trim() == '' ) {
                            toaster('Field must not be empty', 'error');
                            {{--  alert('Field must not be empty')  --}}
                            return false;
                        }else{
                            //set purpose and category values
                            var category_info = category.split("~")
                            $("#display_category").text(category_info[1])
                            $("#display_purpose").text(purpose)

                            $("#transaction_form").hide()
                            $("#transaction_summary").show()
                        }




                    }else{
                        toaster('CHOOSE EITHER BENEFICIARY OR ONTIME');
                        {{--  alert('CHOOSE EITHER BENEFICIARY OR ONTIME')  --}}
                    }
                });


                var user_pin = $('#user_pin').val();
                // POST TO API

                $('#confirm_button').click(function(e){
                    e.preventDefault();

                    var type = $("input[type='radio']:checked").val();
                    {{-- console.log(type); --}}

                    if(type == 'beneficiary'){

                        var from_account = $('#from_account').val().split('~')
                        var to_account = $('#to_account').val().split('~')
                        var transfer_amount = $('#amount').val()
                        var category = $('#category').val().split('~')
                        var purpose = $('#purpose').val()
                        var schedule_payment_contraint_input = $('#schedule_payment_contraint_input').val()
                        var schedule_payment_date = $('#schedule_payment_date').val();


                        var from_account_ = from_account[2];
                        var to_account_ = to_account[2];
                        var account_name = to_account[1];
                        var currency = to_account[3];
                        var category_ = category[0]
                        var bank_name = to_account[0]
                        var user_pin = $('#user_pin').val();

                        {{-- console.log(from_account_);
                        console.log(to_account);
                        console.log(transfer_amount);
                        console.log(category_);
                        console.log(purpose);
                        console.log(schedule_payment_contraint_input);
                        console.log(schedule_payment_date); --}}

                        $.ajax({
                            'type' : 'POST' ,
                            'url' : 'international-bank-transfer-beneficiary-api' ,
                            "datatype" : "application/json",
                            'data' : {
                                'from_account' : from_account_ ,
                                'to_account' : to_account_ ,
                                'amount' : transfer_amount ,
                                'category' : category_ ,
                                'currency' : currency ,
                                'bank_name' : bank_name ,
                                'secPin' : user_pin ,
                                'payment_date' : schedule_payment_date ,
                                'beneficiaryName' : account_name ,
                                'naration' : purpose ,

                            },headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success:
                                function(response){
                                    {{--  console.log(response);  --}}

                                    if(response.responseCode == '000'){
                                        toaster(response.message,'success')

                                    }else {
                                        toaster(response.message,'error')



                                    }
                                }
                        })

                    }else{

                        //alert('Hello');
                        var from_account = $('#from_account').val().split('~')
                        var from_account_ = from_account[2];
                        var alias_name = $('#onetime_beneficiary_alias_name').val();
                        var to_account = $('#onetime_beneficiary_account_number').val();
                        var currency = $('#onetime_beneficiary_account_currency').val();
                        var currency_ = currency[0];
                        var bank_name = $('#onetime_beneficiary_bank_name').val();
                        var onetime_beneficiary_phone = $('#onetime_beneficiary_phone').val();
                        var amount = $('#amount').val();
                        var category = $('#category').val().split('~');
                        var category_ = category[0];
                        var naration = $('#purpose').val();
                        var schedule_date = $('#schedule_payment_date').val();
                        var user_pin = $('#user_pin').val();

                        console.log(from_account_);
                        console.log(alias_name);
                        console.log(to_account);
                        console.log(currency_);
                        console.log(bank_name);
                        console.log(onetime_beneficiary_phone);
                        console.log(amount);
                        console.log(category_);
                        console.log(naration);
                        console.log(schedule_date);

                        $.ajax({
                            'type' : 'POST',
                            'url' : 'international-bank-onetime-api' ,
                            "datatype" : "application/json",
                            "data" : {
                                'from_account' : from_account_ ,
                                'beneficiary_name' : alias_name ,
                                'to_account' : to_account ,
                                'account_currency' : currency_ ,
                                'bankName' : bank_name ,
                                'beneficiary_phone' : onetime_beneficiary_phone ,
                                'amount' : amount ,
                                'category' : category_ ,
                                'naration' : naration ,
                                'schedule_date' : schedule_date ,
                                'secPin' : user_pin

                            },headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success:
                                function(response){
                                    {{--  console.log(response);  --}}

                                    if(response.responseCode == '000'){
                                        toaster(response.message,'success')


                                    }else {
                                        toaster(response.message,'error')



                                    }
                                }
                        })

                    }
                });




            });

        </script>
    @endsection
