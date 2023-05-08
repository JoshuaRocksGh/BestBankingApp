<div class="modal fade" id="create_originator" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document" style="wid">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white font-18 font-weight-bold">
                    Create New Originator
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <i> <b style="color:red;">Please Note:</b> Direct to Bank offers you the opportunity to create a user to
                    originate transactions only.</i> </li>

                <div id="">
                    <!-- title-->
                    <!-- form -->
                    <form id="create_originator_form" autocomplete="off" aria-autocomplete="off">
                        @csrf
                        <br>

                        {{-- <div class="form-group ">

                            <br>

                            <span class=" security_question text-danger"></span>
                        </div> --}}
                        <div class="form-group">

                            <label class=" text-dark"> Status</label>
                            {{--  <select name="" id="security_question" class="form-control">
                                <option disabled value="">---- select a service type ----</option>
                            </select>  --}}
                            <input type="text" id="" name="originator_status"
                                class="form-control originator_status" autocomplete="off" value="NEW"
                                aria-autocomplete="off" readonly>
                            {{-- <br> --}}
                            <label for="">Select Acount</label>
                            <select class="form-control col-md-12 accounts-select" id="account_number" required>
                                <option disabled selected value=""> ---
                                    Select Account ---
                                </option>
                                @include('snippets.accounts')
                            </select>
                            {{-- <br> --}}
                            <label for="">First Name</label>
                            <input type="text" placeholder="Enter originator first name" id="first_name"
                                name="first_name" class="form-control" autocomplete="off" aria-autocomplete="off"
                                required>
                            {{-- <br> --}}
                            <label for="">Last Name</label>
                            <input type="text" placeholder="Enter originator last name" id="last_name"
                                name="last_name" autocomplete="off" class="form-control" required />
                            {{-- <br> --}}
                            <label for="">Email</label>
                            <input type="email" placeholder="Enter originator email" id="email" name="email"
                                autocomplete="off" class="form-control" required />
                            {{-- <br> --}}
                            <label for="">Telephone Number</label>
                            <input type="text" id="telephone" placeholder="Enter originator telephone"
                                class="form-control" autocomplete="off" required>


                        </div>

                        <div class="modal-footer">

                            <button class="btn form-button"  id="new_originator_form">Submit
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    const originatorData = new Object();

    $(() => {

        $("#new_originator_form").click(function(e) {
            e.preventDefault()
            originatorData.status = $("#originator_status").val()
            originatorData.accountDetails = $("#account_number").val()
            originatorData.firstName = $("#first_name").val()
            originatorData.lastName = $("#last_name").val()
            originatorData.email = $("#email").val()
            originatorData.telephone = $("#telephone").val()
            // console.log($("#email").val())
            // return
            // console.log(originatorData.email)

            // console.log(originatorData.accountDetails, originatorData.firstName, originatorData.lastName, !originatorData.email ,originatorData.telephone)

            if(originatorData.account == "" || originatorData.firstName =="" || originatorData.lastName =="" || originatorData.telephone == "" || originatorData.email == ""){
                toaster("Please complete all fields", "warning")
                        return;
            }
            // if()

            siteLoading(true)
            $.ajax({
                type: "POST",
                url: "create-originator-api",
                datatype: "application/json",
                data: originatorData,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"),
                },
                success: function(response) {
                    // console.log(response)
            siteLoading(false)

                    if (response.responseCode == '000') {
                        toaster(response.message, "success");

                    } else {
                        toaster(response.message, "error");
                    }
                },


            })

        })

    })
</script>
