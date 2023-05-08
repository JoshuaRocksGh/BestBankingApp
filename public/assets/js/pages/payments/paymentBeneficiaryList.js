function getBeneficiaryList() {
    $.ajax({
        tpye: "GET",
        url: "payment-beneficiary-list-api",
        datatype: "application/json",
        success: function (response) {
            console.log("paymentBeneficiaryList==>", response);
            if (response.responseCode == "000") {
                const data = response.data;

                if (data && data.length > 0) {
                    $.each(pageData.payTypes, (i) => {
                        const type = pageData.payTypes[i];
                        pageData["bene_" + type] = data.filter(
                            (e) => e.PAYMENT_TYPE === type
                        );
                    });
                    drawBeneficiaryTable();
                    return;
                }
                siteLoading("hide");
            } else {
                setTimeout(function () {
                    getBeneficiaryList();
                }, $.ajaxSetup().retryAfter);
            }
        },
        error: function (xhr, status, error) {
            setTimeout(function () {
                getBeneficiaryList();
            }, $.ajaxSetup().retryAfter);
        },
    });
}

function getPaymentTypes() {
    $.ajax({
        tpye: "GET",
        url: "get-payment-types-api",
        datatype: "application/json",
        success: function (response) {
            console.log("paymentTypesAPi==>", response);
            if (response.responseCode == "000") {
                const data = response.data;
                pageData.payTypes = [];
                $.each(data, function (i) {
                    console.log(data[i]);
                    const { label, paymentType, description } = data[i];
                    pageData.payTypes.push(paymentType);
                    pageData["pay_" + paymentType] = data[i];
                    const comingSoon = !label ? "coming-soon" : "";
                    let paymentCard = `
                    <button class="${comingSoon} beneficiary-type knav mb-2  current-type  knav-primary" data-value=${paymentType}
                    data-title=${description} id=''>
                    <span class="box-circle"></span>
                    <span id=''>${description}</span>
                </button>
                    `;
                    $(".payment-tabs").append(paymentCard);
                });
                initPaymentTabs();
                getBeneficiaryList();
            } else {
                setTimeout(function () {
                    getPaymentTypes();
                }, 1000);
            }
        },
        error: function (xhr, status, error) {
            setTimeout(function () {
                getPaymentTypes();
            }, 1000);
        },
    });
}
function beneficiarySaved() {
    Swal.fire({
        width: 300,
        title: "<h2 class='text-success font-16 font-weight-bold'>Beneficiary Saved</h2>",
        imageUrl: "assets/images/animations/sprinkles.gif",
        imageHeight: 100,
        confirmButtonColor: "#1abc9c",
    });
    getBeneficiaryList();
}
function beneficiaryDeleted() {
    Swal.fire({
        width: 300,
        title: "<h2 class='text-danger font-16 font-weight-bold'>Beneficiary Deleted</h2>",
        imageUrl: "assets/images/animations/delete-message.gif",
        imageHeight: 100,
        confirmButtonColor: "#dc3545",
    });
    getBeneficiaryList();
}
function drawBeneficiaryTable() {
    let table = $("#beneficiary_list")
        .DataTable({
            destroy: true,
            pageLength: 5,
            lengthChange: false,
            columnDefs: [
                {
                    targets: "_all",
                    orderable: false,
                },
            ],
        })
        .clear();
    let noBeneficiaries = noDataAvailable.replace("Data", "Beneficiaries");
    let data = [];
    $("#beneficiary_list tbody").empty();
    const currentType = $(".current-type").attr("data-value");
    data = pageData["bene_" + currentType];
    if (data && data.length < 1) {
        $("#beneficiary_list tbody")
            .append(`<td colspan="100%" class="text-center">
        ${noBeneficiaries} </td>`);
        return;
    }
    $.each(data, (index) => {
        const beneData = JSON.stringify(data[index]);
        const editIcon = `<a class='edit-beneficiary' style="display:flex; place-content:center;" href="#" data-value='${beneData}'> <span class="fe-edit noti-icon text-info"></span></a>`;
        const { NICKNAME, ACCOUNT, PAYEE_NAME } = data[index];

        const logo = pageData["pay_" + currentType].paySubTypes.find(
            (e) => e.paymentCode === PAYEE_NAME
        ).paymentLogo;
        // logo = "";
        const img = logo
            ? "data:image/jpg;base64," + logo
            : "assets/images/add.png";
        const payeeImage = `<img src="${img}" height="25" class="payment_icon">`;
        const payeeText = `<span> ${PAYEE_NAME} </span>`;
        const payee = `<div class="d-flex align-items-center m-0">${payeeImage}<span class="ml-2">${payeeText}</span></div>`;
        table.row.add([NICKNAME, ACCOUNT, payee, editIcon]).draw("full-reset");
    });
    // return;
    let editButtons = document.querySelectorAll(".edit-beneficiary");
    editButtons.forEach((item, i) => {
        item.addEventListener("click", (e) => {
            const editButton = e.currentTarget;
            const beneficiaryData = JSON.parse(
                $(editButton).attr("data-value")
            );

            getOTP(503).then((data) => {
                // console.log(data);
                if (data.responseCode == "000") {
                    editPaymentBeneficiary(beneficiaryData, currentType);

                    // editBankBeneficiary(beneficiaryData, currentType);
                } else {
                    toaster(data.message, "warning");
                }
            });
        });
    });
    siteLoading("hide");
}
const initPaymentTabs = () => {
    let beneficiaryType = document.querySelectorAll(".beneficiary-type");
    beneficiaryType.forEach((item, i) => {
        item.addEventListener("click", (e) => {
            const currentType = e.currentTarget;
            if (e.currentTarget.classList.contains("coming-soon")) {
                e.preventDefault();
                comingSoonToast(
                    "Feature not available at the moment. Please check back later"
                );
                return;
            }
            $(".beneficiary-type")
                .removeClass("current-type")
                .removeClass("active");
            $(currentType).addClass("current-type").addClass("active");
            $("#beneficiary_type_title").text(
                $(currentType).attr("data-title") + " "
            );
            drawBeneficiaryTable();
        });
        if (i === 0) {
            $(item).trigger("click");
        }
    });
};
$(() => {
    siteLoading("show");
    getPaymentTypes();
    $("#add_beneficiary").on("click", () => {
        siteLoading("show");

        getOTP(502).then((data) => {
            console.log(data.responseCode);
            if (data.responseCode == "000") {
                // editBankBeneficiary(beneficiaryData, currentType);
                siteLoading("hide");

                addPaymentBeneficiary($(".current-type").attr("data-value"));
            } else {
                siteLoading("hide");

                toaster(data.message, "warning");
            }
        });
    });
});
