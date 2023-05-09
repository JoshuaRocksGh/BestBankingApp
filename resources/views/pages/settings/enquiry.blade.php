<div class="modal fade" id="enquiry_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document" style="wid">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white font-18 font-weight-bold">Enquiry</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body pb-4">

                <form action="#" class="select_beneficiary p-4 mx-auto" id="payment_details_form"
                    style="max-width: 650px;" autocomplete="off" aria-autocomplete="none">
                    @csrf

                    <div class="form-group  mb-4">
                        <label class=" text-dark">Select Account</label>
                        <select class="form-control accounts-select " id="from_account" required>
                            <option selected disabled value=""> -- Select Account --</option>
                            @include('snippets.accounts')
                        </select>

                    </div>
                    <div class="form-group mb-4">
                        <label class=" text-dark"> Select Service Type</label>
                        <select name="" id="service_type" class="form-control">
                            <option disabled value="">---- select a service type ----</option>
                        </select>
                    </div>
                    <div class="form-group mb-1">
                        <label class=" text-dark" for="description"> Description</label>
                        <textarea name="" id="description" class="form-control "></textarea>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button"
                    class="btn form-button btn-rounded waves-effect waves-light disappear-after-success"
                    id="proceed_button">
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function getServiceType() {
        return $.ajax({
                type: "get",
                url: "get-service-type-api",
                datatype: "application/json",
            })
            .done(({
                data
            }) => {
                if (!data) {
                    toaster("Couldn't get service type", "warning");
                }
                const select = document.getElementById("service_type");
                data.forEach((service) => {
                    const option = document.createElement("option");
                    option.text = service.description;
                    option.value = service.actualCode;
                    select.appendChild(option);
                });
            })
            .fail((err) => console.log(err.message));
    }

    function submitComplaint(accountNumber, serviceType, description) {
        $.ajax({
            type: "POST",
            url: "complaint-api",
            datatype: "application/json",
            data: {
                accountNumber,
                serviceType,
                description,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function(response) {
                siteLoading("hide")

                console.log(response)
                if (response.responseCode == "000") {
                    toaster(response.message, "success");
                } else {
                    toaster(response.message, "error");
                }
            },
            error: function() {
                siteLoading("hide")

            }
        })
    }

    $(function() {
        siteLoading("show");
        getServiceType().always(siteLoading("hide"));
        $(".accounts-select").select2({
            minimumResultsForSearch: Infinity,
            templateResult: accountTemplate,
            templateSelection: accountTemplate,
        });
        $("#service_type").select2({
            minimumResultsForSearch: Infinity,
        });

        $("#proceed_button").on("click", () => {
            let accountNumber = $("#from_account option:selected").attr(
                "data-account-number"
            );
            let serviceType = $("#service_type").val();
            let description = $("#description").val();
            console.log({
                accountNumber,
                serviceType,
                description
            });
            //validate to ensure fields are not empty
            if (!accountNumber || !serviceType || !description) {
                toaster("Fields must not be empty", "warning");
                return false;
            }
            siteLoading("show");
            submitComplaint(accountNumber, serviceType, description)
        });
    });
</script>
