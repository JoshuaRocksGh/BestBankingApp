$(".prod_list").hide();

function productList() {
    $.ajax({
        type: "GET",
        url: "get-lovs-list-api",
        datatype: "application/json",
        success: function (response) {
            $(".spinner-border").hide();
            $(".prod_list").toggle("500");
            if (response.responseCode == "000") {
                let product = response.data.productList;
                $.each(product, function (index) {
                    let subCode = product[index].subCode;
                    let description = product[index].description;
                    if (subCode == "M" && description.indexOf("CA") >= 0) {
                        $(".current_product_list").append(
                            `
                                        <div class="col-md-6">
                                            <div class="card card-body">
                                                <i class="mdi mdi-account-plus-outline  mdi-48px" style="margin-left: 40%"></i>
                                                <h5 class="card-title" style="text-align: center">${product[index].description}</h5>

                                                <a href="#"
                                                    class="btn btn-outline-danger waves-effect waves-light">Apply</a>
                                            </div>
                                        </div>
                                        `
                        );
                    }

                    if (subCode == "M" && description.indexOf("SA") >= 0) {
                        // {{-- console.log(product[index]); --}}

                        if (description.indexOf("STAFF") >= 0) {
                        } else {
                            $(".savings_product_list").append(
                                `
                                        <div class="col-md-6">
                                            <div class="card card-body">
                                                <i class="mdi mdi-account-plus-outline  mdi-48px" style="margin-left: 40%"></i>
                                                <h5 class="card-title" style="text-align: center">${product[index].description}</h5>

                                                <a href="./account-creation/savings-account-creation"
                                                    class="btn btn-outline-danger waves-effect waves-light">Apply</a>
                                            </div>
                                        </div>
                                        `
                            );
                        }
                    }
                });
            } else {
                setTimeout(function () {
                    productList();
                }, 1000);
            }
        },
        errorfunction(xhr, status, error) {
            setTimeout(function () {
                productList();
            }, 1000);
        },
    });
}

$(() => {
    productList();
});
