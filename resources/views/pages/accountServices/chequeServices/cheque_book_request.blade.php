<form action="#" id="cheque_request_form" autocomplete="off" aria-autocomplete="none">
    @csrf
    <div class="container-md mx-auto" style="max-width: 550px">
        {{-- <div class="form-group ">
            <label class=" text-primary"> Card Display Name</label>
            <input name="displayName" id="cheque_name" required class="form-control text-input"
                placeholder="Card Display Name" type="text" />
        </div> --}}
        <div class="form-group  mb-3">

            <label class=" text-dark">Number of Leaflets</label>

            <select class="form-control " required name="noOfLeaflets" id="no_of_leaflets" required>
                <option disabled selected value="">Select number of leaflets</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>select
            </select>
        </div>
        {{--  {{ $branches['data'] }}  --}}
        {{--  @if ($branches as $key => $value)
            {{ $branches['data'] }}
        @endif  --}}

        <div class="form-group ">
            <label class="text-dark"> Pick Up Branch</label>
            <select class="form-control" required name="pickUpBranch" id="pick_up_branch"
                placeholder="Select Pick Up Branch" required>
                <option disabled selected value="">Select Pick Up Branch</option>
                {{--  @foreach (json_encode($branches['data']) as $branch)
                    {{ $branch }}
                @endforeach  --}}
            </select>
        </div>
        <div class="form-group text-right mt-4">
            <button type="submit" class="btn form-button waves-effect waves-light" id="btn_submit_cheque_request">
                Submit
            </button>
        </div>
    </div>
</form>
