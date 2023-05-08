<form action="#" id="statement_request_form" autocomplete="off" aria-autocomplete="none">
    @csrf
    <div class="container mx-auto" style="max-width: 750px">
        <label class=" text-dark " hidden> Statement Type </label>
        <div class="card" hidden>
            <div class="card-body  d-flex justify-content-around" style="max-width: 700px">
                <div class="d-flex align-items-center ">
                    <input class=" mr-1 statement-type" checked type="radio" name="statement_type"
                        id="account_statement" value="account_statement">
                    <label class="d-block mb-0 text-dark" for="account_statement">Account Statement</label>
                </div>
                <div class=" d-flex align-items-center">
                    <input class="d-block statement-type mr-1" name="statement_type" type="radio" id="account_details"
                        value="account_details">
                    <label class="d-block mb-0 text-dark" for="account_details">Account Details</label>
                </div>
            </div>
        </div>
        <div class="form-group  mb-3">

            <label class=" text-dark">Statement Type</label>

            <select class="form-control " required name="statement_type" id="statement_type" required>
                <option disabled selected value="">Select number of leaflets</option>
                <option value="ORDINARY">ORDINARY Statement</option>
                <option value="VISA">VISA Statement</option>
                <option value="ELECTRONIC">ELECTRONIC Statement</option>select
            </select>
        </div>
        <div class="form-group ">
            <label class="text-dark">Select Branch </label>
            <select class="form-control select pick_up_branch" id="pick_up_branch" placeholder="Select Pick Up Branch "
                required>
                <option disabled selected value="">Select Pick Up Branch</option>
            </select>
        </div>
        <br>
        <label class=" text-dark "> Period </label>
        <div class="">
            <div class="" style="max-width: 800px">
                <div class=" d-flex  justify-content-around">
                    <button type='button' class="date-select period " id="get_first_month_statement" data-value="0">
                        <div class="d-block mb-0 " for="this_month">This month</div>
                    </button>
                    <button type='button' class="date-select period" data-value="1">
                        <div class="d-block mb-0" for="last_month">Last Month</div>
                    </button>
                    <button type='button' class="date-select period" data-value="3">
                        <div class="d-block mb-0" for="last_3_months">3 Months</div>
                    </button>
                    <button type='button' class="date-select period" data-value="6">
                        <div class="d-block mb-0" for="last_6_months">6 Months</div>
                    </button>
                </div>
                <div class=" pt-3 px-4 ">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input period" id="custom_date_toggle">
                        <label class="custom-control-label" for="custom_date_toggle">Custom Period</label>
                    </div>
                    <div class="d-flex mt-2 justify-content-between">
                        <div class="form-group">
                            <label for="from_date" class="text-dark ">From</label>
                            <input type="date" disabled class="text-input period custom_date form-control"
                                id="from_date" name="from_date">
                        </div>
                        <div class="form-group">
                            <label for="to_date" class="text-dark">To</label>
                            <input type="date" disabled class="text-input period custom_date form-control"
                                id="to_date" name="to_date">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group text-center mt-4">
            <button type="button" class="btn px-5 py-2 rounded-pill form-button waves-effect waves-light"
                id="btn_submit_request_statement">
                Request
            </button>
        </div>
    </div>
</form>
