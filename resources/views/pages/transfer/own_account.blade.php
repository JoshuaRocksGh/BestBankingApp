@extends('layouts.master')

@section('content')

<legend></legend>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Own Account Transfer</h4>
                <div class="row">
                    <div class="col-md-4">
                        <form action="#" id="payment_details_form">
                            <p class="sub-header font-18 purple-color">
                                Payment Details
                            </p>
                            <div class="form-group">
                                <label>Transfer From</label>
                                {{--  <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="00/00/0000">
                                <span class="font-13 text-muted">e.g "DD/MM/YYYY"</span>
                                  --}}

                                  <select class="custom-select "  id="from_account" required>
                                    <option  value="">Select Account</option>
                                    <option value="1" >Jonas Korankye - 001023468976001</option>
                                    {{--  <option value="2">Jonas Korankye - 001020065985369</option>  --}}
                                    {{--  <option value="3">Three</option>  --}}
                                </select>
                                <span class="font-13 text-muted">GHS 5000.00</span>

                            </div>
                            <div class="form-group">
                                <label>Transfer To</label>
                                {{--  <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="00:00:00">
                                <span class="font-13 text-muted">e.g "HH:MM:SS"</span>
                                  --}}

                                  <select class="custom-select" id="to_account" required>
                                    <option value="">Select Account</option>
                                    {{--  <option value="1">Jonas Korankye - 001023468976001</option>  --}}
                                    <option value="2" >Jonas Korankye - 001020065985369</option>
                                    {{--  <option value="3">Three</option>  --}}
                                </select>
                                <span class="font-13 text-muted">GHS 50.00</span>

                            </div>

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">Schedule Payments</label>
                            </div><br>

                            <div class="form-group mb-3">
                                <label for="example-textarea">Text area</label>
                                <textarea class="form-control" id="textarea" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label class="font-16 purple-color">Enter Amount</label>
                                <input type="text" class="form-control" id="amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')" required>
                                {{--  <span class="font-13 text-muted">e.g "(xx) xxxxx-xxxx"</span>  --}}
                            </div>

                            {{--  <div class="form-group">
                                <label>Date & Hour</label>
                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="00/00/0000 00:00:00">
                                <span class="font-13 text-muted">e.g "DD/MM/YYYY HH:MM:SS"</span>
                            </div>  --}}
                            {{--  <div class="form-group">
                                <label>ZIP Code</label>
                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="00000-000">
                                <span class="font-13 text-muted">e.g "xxxxx-xxx"</span>
                            </div>  --}}
                            {{--  <div class="form-group">
                                <label>Crazy Zip Code</label>
                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="0-00-00-00">
                                <span class="font-13 text-muted">e.g "x-xx-xx-xx"</span>
                            </div>  --}}
                            {{--  <div class="form-group">
                                <label>Money</label>
                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="000.000.000.000.000,00" data-reverse="true">
                                <span class="font-13 text-muted">e.g "Your money"</span>
                            </div>  --}}
                            {{--  <div class="form-group">
                                <label>Money 2</label>
                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="#.##0,00" data-reverse="true">
                                <span class="font-13 text-muted">e.g "#.##0,00"</span>
                            </div>  --}}

                        </form>
                    </div> <!-- end col -->

                    <div class="col-md-8">
                            <img src="{{ asset('assets/images/wallet.png') }}" class="img-fluid" alt="" >
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
                <button class="btn btn-primary" type="submit" id="payment_submit" data-toggle="modal" data-target="#multiple-one">Next</button>

            </div> <!-- end card-body -->

                            {{--  <h4 class="header-title font-16 purple-color">Confirm Details</h4>  --}}
                            {{--  <p class="sub-header font-13">Display a series of modals one by one to guide your users on multiple aspects or take step wise input.</p>  --}}

                            <!-- Modal -->
                            <div id="multiple-one" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="multiple-oneModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <form action="POST" id="confirm_details">
                                        <div class="modal-header">
                                            <h4 class="modal-title font-16 purple-color" id="multiple-oneModalLabel">Confirm Details</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
{{--
                                        <div class="modal-body">
                                            <h5 class="mt-0">Text in a modal</h5>
                                            <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula.</p>
                                        </div>  --}}

                                        <div class="modal-body">
                                            {{--  <h5 class="mt-0">Text in a modal</h5>  --}}
                                            {{--  <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula.</p>  --}}
                                            From: <span class="font-13 text-primary" id="display_from_account"> &nbsp </span><br><br>
                                            To: <span class="font-13 text-muted" id="display_to_account"> &nbsp </span><br><br>
                                            Schedule Payments: <span class="font-13 text-muted" id="display_payments"> &nbsp </span><br><br>
                                            Amount: <span class="font-13 text-muted" id="display_amount"> &nbsp </span><br><br>
                                            Naration: <span class="font-13 text-muted" id="display_naration"> &nbsp </span><br><br>
                                            Transaction fee: <span class="font-13 text-muted" id="display_trasaction_fee"> </span><br><br>
                                            Total: <span class="font-13 text-muted" id="display_total"> &nbsp </span><br><br>

                                        <div class="form-group">
                                            <label class="font-16 purple-color">Enter Pin</label>
                                            <input type="text" class="form-control" id="pin" data-toggle="input-mask" placeholder="enter pin" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                            {{--  <span class="font-13 text-muted">e.g "(xx) xxxxx-xxxx"</span>  --}}
                                        </div>

                                        </div>



                                        <div class="modal-footer">
                                            <button type="send" id="send" class="btn btn-primary" data-target="#multiple-two" data-toggle="modal" data-dismiss="modal">Send</button>
                                        </div>
                                    </form>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                            <!-- Modal -->
                            {{--  <div id="multiple-two" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="multiple-twoModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="multiple-twoModalLabel"> </h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="mt-0">Text in a modal</h5>
                                            <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->  --}}

{{--
                            <div class="button-list">
                                <!-- Multiple modal -->
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#multiple-one">Multiple Modal</button>
                            </div>  --}}


    </div> <!-- end col -->

</div> <!-- end row -->



</div>


<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){

        $("#payment_submit").click(function(){
            var send_from = $('#from_account').val();
            var  send_to = $('#to_account').val();
            var custom_check = $('#customCheck1').is(":checked");
            var custom_check2 = $('#customCheck2').is(":checked");
            var  text_area = $('#textarea').val();
            var  amount = $('#amount').val();

            {{--  console.log(send_from,send_to,custom_check,text_area,amount)  --}}

            $("#display_from_account").text(send_from);
            $("#display_to_account").text(send_to);
            $("#display_amount").text(amount);
            $("#display_naration").text(text_area);
            $("#display_trasaction_fee").text();
            $("#display_total").text();

            if (custom_check == true){
                var checked = ("Payments Scheduled")
                $("#display_payments").text(checked);

            }else{
                var unchecked = ("No Scheduled Payments")
                $("#display_payments").text(unchecked);

            };


{{--
            $('#confrim_details').send(function(e){
                $.ajax({
                    type: "POST"
                    url: "submit-own-account-transfer"
                    data: {
                        "send_from" : send_from,
                        "send_to" : send_to,
                        "cashier_id" : cashier_id,
                        "text_area" : text_area,
                        "amount" : amount,
                        "cashier_id" : cashier_id
                    },
                     headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    success: function(){
                        Swal.fire(
                            'Post Successful',
                            ' ',
                            'success'
                        )
                    }
                })

            })  --}}

        });
      });
</script>
@endsection

