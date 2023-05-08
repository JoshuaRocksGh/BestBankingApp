// import beneficiaryForm from "./beneficiaryForm";

function getBeneficiaryList() {
    $.ajax({
        tpye: "GET",
        url: "transfer-beneficiary-list",
        datatype: "application/json",
        success: function (response) {
            // console.log("transfer-beneficiary-list ==>", response);
            if (response.responseCode == "000") {
                const data = response.data;
                pageData.allBeneficiaries = data;
                pageData.BENE_SAB = [];
                pageData.BENE_OTB = [];
                pageData.BENE_INTB = [];
                data.forEach((e) => {
                    if (e.BENEF_TYPE === "SAB" || e.TRANS_TYPE === "SAM") {
                        pageData.BENE_SAB.push(e);
                    } else if (
                        e.BENEF_TYPE === "OTB" ||
                        e.TRANS_TYPE === "OTR"
                    ) {
                        pageData.BENE_OTB.push(e);
                    } else if (
                        e.BENEF_TYPE === "INTB" ||
                        e.TRANS_TYPE === "INT"
                    ) {
                        pageData.BENE_INTB.push(e);
                    }
                });
                drawBeneficiaryTable();
            } else {
                setTimeout(function () {
                    getBeneficiaryList();
                }, 1000);
                $("#beneficiary_table").hide();
                $("#beneficiary_list_loader").hide();
                $("#beneficiary_list_retry_btn").show();
            }
        },
        error: function (xhr, status, error) {
            console.log("xhr == >", xhr);
            console.log("status == >", status);
            console.log("error == >", error);
            setTimeout(function () {
                getBeneficiaryList();
            }, 1000);
        },
    });
}
function beneficiarySaved() {
    $("#edit_modal").modal("hide");
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
            responsive: true,
            columnDefs: [
                { responsivePriority: 1, targets: 5 },
                {
                    targets: "_all",
                    orderable: false,
                    render: (data) => (data ? data : "N/A"),
                },
            ],
        })
        .clear();
    let noBeneficiaries = noDataAvailable.replace("Data", "Beneficiaries");
    $("#beneficiary_list tbody").empty();
    const currentType = $(".current-type").attr("data-bene-type");
    let beneficiaries = pageData["BENE_" + currentType];
    if (beneficiaries && beneficiaries.length < 1) {
        $("#beneficiary_list tbody")
            .append(`<td colspan="100%" class="text-center">
        ${noBeneficiaries} </td>`);
        return;
    }
    beneficiaries.forEach((e) => {
        table.row
            .add([
                e.NICKNAME,
                e.FIRST_NAME,
                e.BEN_ACCOUNT,
                e.EMAIL,
                e.BANK_NAME,

                `<a class='edit-beneficiary' style="display:flex; place-content:center;" href="#" data-bene-id='${e.BENE_ID}'> <span class="fe-edit noti-icon text-info"></span></a>`,
            ])
            .draw("full-reset");
    });
    let editButtons = document.querySelectorAll(".edit-beneficiary");
    editButtons.forEach((button) => {
        button.addEventListener("click", (e) => {
            const editButton = e.currentTarget;
            const beneficiaryData = beneficiaries.find(
                (e) => e.BENE_ID === $(editButton).attr("data-bene-id")
            );
            siteLoading("show");
            getOTP(504).then((data) => {
                // console.log(data);
                if (data.responseCode == "000") {
                    siteLoading("hide");

                    editBankBeneficiary(beneficiaryData, currentType);
                } else {
                    siteLoading("hide");

                    toaster(data.message, "warning");
                }
            });
        });
    });
}

$(() => {
    getBeneficiaryList();

    $("#add_beneficiary").on("click", () => {
        siteLoading("show");

        getOTP(501).then((data) => {
            // console.log(data);
            if (data.responseCode == "000") {
                siteLoading("hide");

                addBankBeneficiary($(".current-type").attr("data-bene-type"));
            } else {
                siteLoading("hide");

                toaster(data.message, "warning");
            }
        });
    });

    let beneficiaryTypes = document.querySelectorAll(".beneficiary-type");
    beneficiaryTypes.forEach((beneType) => {
        beneType.addEventListener("click", (e) => {
            const currentType = e.currentTarget;
            $(".beneficiary-type").removeClass("current-type");
            $(currentType).addClass("current-type");
            $("#beneficiary_type_title").text(
                $(currentType).attr("data-title") + " "
            );
            drawBeneficiaryTable();
        });
    });
});
