$("#nav_acc_history_tab").prop("disabled", true);
$("#residential_details_tab").prop("disabled", true);
$("#employment_details_tab").prop("disabled", true);
$("#tax_information_details_tab").prop("disabled", true);
// $("#nav_acc_history_tab").prop("disabled", true);

function get_kyc_details() {
    // alert("function called");
    $.ajax({
        type: "GET",
        url: "get-kyc-details",
        datatype: "application/json",
        success: function (response) {
            console.log("kyc details =>", response);
            if (response.responseCode == "000") {
                let kyc_details = response.data;
                // return false;
                $.each(kyc_details, function (index) {});

                var TITLE = kyc_details[0].TITLE;
                var GENDER = kyc_details[0].GENDER;
                var DOB = kyc_details[0].DATE_OF_BIRTH.split("T");
                var US_CITIZEN = kyc_details[0].US_PERMANENT_VISA_CARD;
                var US_RESIDENT = kyc_details[0].US_RESIDENT;

                var get_DOB_date = DOB[0];
                var date_DOB = get_DOB_date;
                console.log(date_DOB);

                $("#title_").val(TITLE);

                $("#customer_number").val(kyc_details[0].CUSTOMER_NUMBER);
                $("#firstname").val(kyc_details[0].FIRST_NAME);
                $("#surname").val(kyc_details[0].SURNAME);
                $("#Othername").val(kyc_details[0].OTHER_NAME);
                $("#telephone_number").val(kyc_details[0].MOBILE1);
                $("#email_address").val(kyc_details[0].EMAIL_ADDRESS);
                $("#date_of_birth").val(date_DOB);
                if (GENDER == "M") {
                    $("#gender_male").prop("checked", true);
                } else if ((GENDER = "F")) {
                    $("#gender_female").prop("checked", true);
                } else {
                    return false;
                }

                // DISPLAY PROOF OF ADDRESS

                $("#display_selected_id_image").val(
                    kyc_details[0].DOC_ID_PROOFADDR
                );

                // DISPLAY MARITAL STATUS

                $("#number_of_children").val(kyc_details[0].NUMBER_OF_CHILDREN);
                $("#number_of_dependents").val(
                    kyc_details[0].NUMBER_OF_DEPENDANTS
                );
                $("#nationality").val(kyc_details[0].NATIONALITY);

                // DISPLAY ID TYPE
                // DISPLAY ID ISSUE DTAE
                // DISPLAY ID EXPIRY DATE

                $("#mother_maiden_name").val(
                    kyc_details[0].MOTHERS_MAIDEN_NAME
                );
                $("#next_of_kin_name").val(kyc_details[0].NEXT_OF_KIN);
                $("#next_of_kin_address").val(
                    kyc_details[0].NEXT_OF_KIN_ADDRESS
                );
                $("#next_of_kin_telephone").val(
                    kyc_details[0].NEXT_OF_KIN_PHONE
                );

                // DISPLAY COUNTRY OF RESIDENCE

                $("#years_at_residence").val(
                    kyc_details[0].NUMBER_OF_YRS_OF_RESIDENCE
                );
                $("#postal_address").val(kyc_details[0].POSTAL_ADDRESS);

                // WORK ON THE TOWN INPUT FIELD

                $("#residential_address").val(
                    kyc_details[0].RESIDENTIAL_ADDRESS
                );
                $("#employee_code").val(kyc_details[0].EMPLOYER_CODE);
                $("#department").val(kyc_details[0].DEPARTMENT);

                // DISPLAY EMPLOYMENT TYPE

                // DISPLAY EMPLOYMENT DATE

                $("#tax_identification_number").val(kyc_details[0].TIN);

                // DISPLAY LAST TAX UPDATED

                if (US_CITIZEN == "Y") {
                    $("#citizen_yes").prop("checked", true);
                } else if ((US_CITIZEN = "N")) {
                    $("#citizen_no").prop("checked", true);
                } else {
                    return false;
                }

                if (US_RESIDENT == "Y") {
                    $("#resident_yes").prop("checked", true);
                } else if ((US_RESIDENT = "N")) {
                    $("#resident_no").prop("checked", true);
                } else {
                    return false;
                }
            }
        },
    });
}

function accounts() {
    $.ajax({
        type: "GET",
        url: "get-my-account",
        datatype: "application/json",
        success: function (response) {
            let data = response.data;
            $.each(data, function (index) {
                $("#from_account").append(
                    $("<option>", {
                        value:
                            data[index].accountType +
                            "~" +
                            data[index].accountDesc +
                            "~" +
                            data[index].accountNumber +
                            "~" +
                            data[index].currency +
                            "~" +
                            data[index].availableBalance,
                    }).text(
                        data[index].accountType +
                            "~" +
                            data[index].accountNumber +
                            "~" +
                            data[index].currency +
                            "~" +
                            data[index].availableBalance
                    )
                );
                $("#to_account").append(
                    $("<option>", {
                        value:
                            data[index].accountType +
                            "~" +
                            data[index].accountNumber +
                            "~" +
                            data[index].currency +
                            "~" +
                            data[index].availableBalance,
                    }).text(
                        data[index].accountType +
                            "~" +
                            data[index].accountNumber +
                            "~" +
                            data[index].currency +
                            "~" +
                            data[index].availableBalance
                    )
                );
            });
        },
        error: function (xhr, status, error) {
            // alert("API SERVER ERROR ");
        },
    });
}

function lovs_list() {
    let name = $("#title_").val();

    $.ajax({
        type: "GET",
        url: "get-lovs-list-api",
        datatype: "application/json",
        success: function (response) {
            console.log(response);
            let title_list = response.data.titleList;
            let country_list = response.data.nationalityList;
            var nationality_list = response.data.nationalityList;
            let id_list = response.data.documentTypeList;
            let marital_Status_list = response.data.maritalStatusList;
            let occupation_list = response.data.occupationList;

            $.each(title_list, function (index) {
                let data = title_list[index].description;
                // console.log(data);

                if (name == title_list[index].description) {
                    $("#title").append(
                        $("<option selected>", {
                            value:
                                title_list[index].description +
                                "~" +
                                title_list[index].actualCode,
                        }).text(title_list[index].description)
                    );
                } else {
                    $("#title").append(
                        $("<option>", {
                            value:
                                title_list[index].description +
                                "~" +
                                title_list[index].actualCode,
                        }).text(title_list[index].description)
                    );
                }
            });

            $.each(marital_Status_list, function (index) {
                $("#marital_status").append(
                    $("<option>", {
                        value:
                            marital_Status_list[index].description +
                            "~" +
                            marital_Status_list[index].actualCode,
                    }).text(marital_Status_list[index].description)
                );
            });

            $.each(id_list, function (index) {
                $("#id_type").append(
                    $("<option>", {
                        value:
                            id_list[index].description +
                            "~" +
                            id_list[index].actualCode,
                    }).text(id_list[index].description)
                );
            });

            $.each(nationality_list, function (index) {
                $("#nationality").append(
                    $("<option>", {
                        value:
                            nationality_list[index].description +
                            "~" +
                            country_list[index].actualCode,
                    }).text(nationality_list[index].description)
                );
            });

            $.each(country_list, function (index) {
                $("#country_of_residence").append(
                    $("<option>", {
                        value:
                            country_list[index].description +
                            "~" +
                            country_list[index].actualCode,
                    }).text(country_list[index].description)
                );
            });

            $.each(occupation_list, function (index) {
                $("#employment_type").append(
                    $("<option>", {
                        value:
                            occupation_list[index].description +
                            "~" +
                            occupation_list[index].actualCode,
                    }).text(occupation_list[index].description)
                );
            });
        },
    });
}

$(document).ready(function () {
    setTimeout(function () {
        get_kyc_details();

        setTimeout(function () {
            accounts();
            lovs_list();
        }, 200);
    }, 200);
});

$(document).ready(function () {
    $(".display_selected_id_image").hide();

    setTimeout(function () {
        $(".mod-open").trigger("click");
    }, 3000);

    $("#basic_information_tab").addClass("active show");
    $("#first").addClass("active show");

    function toaster(message, icon, timer) {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,

            timerProgressBar: false,
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
        });

        Toast.fire({
            icon: icon,
            title: message,
            timer: timer,
        });
    }

    $("#proof_of_address").change(function () {
        //console.log('changed');
        var file = $("#proof_of_address[type=file]").get(0).files[0];

        if (file) {
            var reader = new FileReader();

            reader.onload = function () {
                $(".display_selected_id_image").attr("src", reader.result);
            };

            reader.readAsDataURL(file);

            reader.onload = function () {
                $(".display_selected_id_image").attr("src", reader.result);
                $("#proof_of_address_").val(reader.result);
            };
        }

        $(".display_selected_id_image").show();
    });

    $("#basic_information").submit(function (e) {
        e.preventDefault();
        // alert("cliked");
        // return false;

        var customer_number = $("#customer_number").val();
        var title = $("#title").val();
        var firstname = $("#firstname").val();
        var surname = $("#surname").val();
        var Othername = $("#Othername").val();
        var telephone_number = $("#telephone_number").val();
        var email_address = $("#email_address").val();
        var date_of_birth = $("#date_of_birth").val();
        var select_gender = $("input[type='radio']:checked").val();

        /* console.log(customer_number);
        console.log(title);
        console.log(firstname);
        console.log(surname);
        console.log(Othername);
        console.log(telephone_number);
        console.log(email_address);
        console.log(proof_of_address);
        console.log(date_of_birth);
        console.log(select_gender); */

        $("#nav-home").hide();

        $("#personal_details").addClass("active show");
        // $("#personal_details").toggle(500);
        $("#personal_details_tab").addClass("active");
        $("#basic_information").removeClass("active show");
        $("#nav-home-tab").removeClass("active ");
    });

    $("#personal_details_back_btn").click(function (e) {
        e.preventDefault();
        // alert("clicked");
        // return false;

        $("#personal_details").removeClass("active show");
        $("#personal_details_tab").removeClass("active");
        $("#basic_information").addClass("active show");
        $("#nav-home-tab").addClass("active");
        $("#nav-home").show();
    });

    // Personal Details
    $("#personal_details").submit(function (e) {
        e.preventDefault();

        var marital_status = $("#marital_status").val();
        var number_of_children = $("#number_of_children").val();
        var nationality = $("#nationality").val();
        var id_type = $("#id_type").val();
        var id_number = $("#id_number").val();
        var date_of_issue = $("#date_of_issue").val();
        var date_of_expiry = $("#date_of_expiry").val();
        var mother_maiden_name = $("#mother_maiden_name").val();
        var next_of_kin_name = $("#next_of_kin_name").val();
        var next_of_kin_address = $("#next_of_kin_address").val();
        var next_of_kin_telephone = $("#next_of_kin_telephone").val();

        $("#personal_details").hide();

        $("#residential_details").addClass("active show");
        $("#residential_details_tab").addClass("active");
        // $("#residential_details_tab").addClass("active show");

        $("#personal_details_tab").removeClass("active");
        $("#personal_details").removeClass("active show");
        // $("#third").addClass("active show");
    });

    $("#residential_details_back_btn").click(function (e) {
        e.preventDefault();

        $("#personal_details").addClass("active show");
        $("#personal_details_tab").addClass("active");
        $("#residential_details").removeClass("active show");

        $("#residential_details_tab").removeClass("active");
        $("#personal_details").show();

        // $("#second").addClass("active show");
        // $("#third").removeClass("active show");
    });

    $("#residential_details").submit(function (e) {
        e.preventDefault();

        var country_of_residence = $("#country_of_residence").val();
        var years_at_residence = $("#years_at_residence").val();
        var building_name = $("#building_name").val();
        var town = $("#town").val();
        var residential_address = $("#residential_address").val();
        var postal_address = $("#postal_address").val();
        $("#residential_details").hide();

        $("#employment_details").addClass("active show");
        $("#employment_details_tab").addClass("active ");
        $("#residential_details_tab").removeClass("active ");
        $("#residential_details").removeClass("active show");

        // $("#first").removeClass("active show");
        // $("#second").removeClass("active show");
        // $("#third").removeClass("active show");
        // $("#fourth").addClass("active show");
    });

    //EMPLOYMENT INFO

    $("#employment_details").submit(function (e) {
        e.preventDefault();

        var employment_type = $("#employment_type").val();
        var employee_number = $("#employee_number").val();
        var employee_code = $("#employee_code").val();
        var department = $("#department").val();
        var date_of_employment = $("#date_of_employment").val();

        $("#employment_details").hide();

        $("#tax_information").addClass("active show");
        $("#tax_information_details_tab").addClass("active");
        // $("#residential_details_tab").addClass("active show");
        $("#employment_details").removeClass("active show");
        $("#employment_details_tab").removeClass("active");

        // $("#tax_information_details_tab").removeClass("active show");
        // $("#sixth").addClass("active show");
    });

    $("#employment_details_back_btn").click(function (e) {
        e.preventDefault();

        $("#residential_details_tab").addClass("active");
        $("#residential_details").addClass("active show");

        $("#employment_details").removeClass("active show");
        $("#employment_details_tab").removeClass("active ");
        $("#residential_details").show();
    });

    $("#tax_information").submit(function (e) {
        e.preventDefault();

        var customer_number = $("#customer_number").val();
        $("#display_customer_number").text(customer_number);

        var title = $("#title").val().split("~");
        var title_ = title[0];
        console.log("title", title_);
        $("#display_title").text(title_);

        var firstname = $("#firstname").val();
        console.log("firstname", firstname);
        $("#display_firstname").text(firstname);

        var surname = $("#surname").val();
        $("#display_surname").text(surname);

        var Othername = $("#Othername").val();
        $("#display_othername").text(Othername);

        var telephone_number = $("#telephone_number").val();
        $("#display_telephone_number").text(telephone_number);

        var email_address = $("#email_address").val();
        $("#display_email_address").text(email_address);

        var date_of_birth = $("#date_of_birth").val();
        $("#display_date_of_birth").text(date_of_birth);

        if ($("#gender_male").is(":checked")) {
            var select_gender = "Male";
        } else if ($("#gender_female").is(":checked")) {
            var select_gender = "Female";
        } else {
            toaster("Gender Not Selected", "error", 60000);

            return false;
        }
        $("#display_gender_male").text(select_gender);

        var marital_status = $("#marital_status").val().split("~");
        var marital_status_ = marital_status[0];
        console.log(marital_status_);
        $("#display_marital_status").text(marital_status_);

        var number_of_children = $("#number_of_children").val();
        $("#display_number_of_children").text(number_of_children);

        var number_of_dependents = $("#number_of_dependents").val();
        $("#display_number_of_dependents").text(number_of_dependents);

        var nationality = $("#nationality").val().split("~");
        var nationality_ = nationality[0];
        console.log(nationality_);
        $("#display_nationality").text(nationality_);

        var id_type = $("#id_type").val().split("~");
        var id_type_ = id_type[0];
        console.log(id_type_);
        $("#display_id_type").text(id_type_);

        var id_number = $("#id_number").val();
        $("#display_id_number").text(id_number);

        var date_of_issue = $("#date_of_issue").val();
        $("#display_date_of_issue").text(date_of_issue);

        var date_of_expiry = $("#date_of_expiry").val();
        $("#display_date_of_expiry").text(date_of_expiry);

        var mother_maiden_name = $("#mother_maiden_name").val();
        $("#display_mother_maiden_name").text(mother_maiden_name);

        var next_of_kin_name = $("#next_of_kin_name").val();
        $("#display_next_of_kin_name").text(next_of_kin_name);

        var next_of_kin_address = $("#next_of_kin_address").val();
        $("#display_next_of_kin_address").text(next_of_kin_address);

        var next_of_kin_telephone = $("#next_of_kin_telephone").val();
        $("#display_next_of_kin_telephone").text(next_of_kin_telephone);

        var country_of_residence = $("#country_of_residence").val();
        $("#display_country_of_residence").text(country_of_residence);

        var years_at_residence = $("#years_at_residence").val();
        $("#display_years_at_residence").text(years_at_residence);

        var building_name = $("#building_name").val();
        $("#display_building_name").text(building_name);

        var town = $("#town").val();
        $("#display_town").text(town);

        var residential_address = $("#residential_address").val();
        $("#display_residential_address").text(residential_address);

        var postal_address = $("#postal_address").val();
        $("#display_postal_address").text(postal_address);

        var employment_type = $("#employment_type").val().split("~");
        var employment_type_ = employment_type[0];
        console.log(employment_type_);
        $("#display_employment_type").text(employment_type_);

        var employee_number = $("#employee_number").val();
        $("#display_employee_number").text(employee_number);

        var employee_code = $("#employee_code").val();
        $("#display_employee_code").text(employee_code);

        var department = $("#department").val();
        $("#display_department").text(department);

        var date_of_employment = $("#date_of_employment").val();
        $("#display_date_of_employment").text(date_of_employment);

        var last_update_date = $("#last_update_date").val();
        $("#display_last_update_date").text(last_update_date);

        var tax_identification_number = $("#tax_identification_number").val();
        $("#display_tax_identification_number").text(tax_identification_number);

        if ($("#citizen_yes").is(":checked")) {
            var citizen_of_US = "Yes";
        } else if ($("#citizen_no").is(":checked")) {
            var citizen_of_US = "No";
        } else {
            toaster("Select citizenship", "error", 6000);

            return false;
        }
        $("#display_citizen_of_us").text(citizen_of_US);

        if ($("#resident_yes").is(":checked")) {
            var us_resident = "Yes";
        } else if ($("#resident_no").is(":checked")) {
            var us_resident = "No";
        } else {
            toaster("Select Residency", "error", 6000);

            return false;
        }
        $("#display_us_resident").text(us_resident);

        /* console.log(select_gender);
        console.log(citizen_of_US);
        console.log(us_resident); */

        $("#proof_of_address").change(function () {
            var file = $("#proof_of_address[type=file]").get(0).files[0];

            if (file) {
                var reader = new FileReader();

                reader.onload = function () {
                    $(".display_selected_id_image").attr("src", reader.result);
                };

                reader.readAsDataURL(file);
            }

            $(".display_selected_id_image").show();
        });
    });

    $("#tax_information_back_btn").click(function (e) {
        e.preventDefault();

        $("#employment_details").addClass("active show");
        $("#employment_details_tab").addClass("active ");
        // $("#residential_details_tab").addClass("active show");
        $("#tax_information").removeClass("active show");
        $("#tax_information_details_tab").removeClass("active");

        // $("#fourth").addClass("active show");
        // $("#sixth").removeClass("active show");
        $("#employment_details").show();
    });

    $("#kyc_confirm_btn").click(function (e) {
        e.preventDefault();
        siteLoading("show");

        if ($("#gender_male").is(":checked")) {
            var select_gender = "M";
        } else if ($("#gender_female").is(":checked")) {
            var select_gender = "F";
        } else {
            return false;
        }

        if ($("#citizen_yes").is(":checked")) {
            var citizen_of_US = "Y";
        } else if ($("#citizen_no").is(":checked")) {
            var citizen_of_US = "N";
        } else {
            return false;
        }

        if ($("#resident_yes").is(":checked")) {
            var us_resident = "Y";
        } else if ($("#resident_no").is(":checked")) {
            var us_resident = "N";
        } else {
            return false;
        }

        var customer_number = $("#customer_number").val();
        var title = $("#title").val().split("~");
        var title_ = title[1];
        var firstname = $("#firstname").val();
        var surname = $("#surname").val();
        var Othername = $("#Othername").val();
        var telephone_number = $("#telephone_number").val();
        var email_address = $("#email_address").val();
        var date_of_birth = $("#date_of_birth").val();
        var gender = select_gender;
        var marital_status = $("#marital_status").val().split("~");
        var marital_status_ = marital_status[1];
        var number_of_children = $("#number_of_children").val();
        var number_of_dependents = $("#number_of_dependents").val();
        var nationality = $("#nationality").val().split("~");
        var nationality_ = nationality[1];
        var id_type = $("#id_type").val().split("~");
        var id_type_ = id_type[1];
        var id_number = $("#id_number").val();
        var date_of_issue = $("#date_of_issue").val();
        var date_of_expiry = $("#date_of_expiry").val();
        var mother_maiden_name = $("#mother_maiden_name").val();
        var next_of_kin_name = $("#next_of_kin_name").val();
        var next_of_kin_address = $("#next_of_kin_address").val();
        var next_of_kin_telephone = $("#next_of_kin_telephone").val();
        var country_of_residence = $("#country_of_residence").val();
        var years_at_residence = $("#years_at_residence").val();
        var building_name = $("#building_name").val();
        var town = $("#town").val();
        var residential_address = $("#residential_address").val();
        var postal_address = $("#postal_address").val();
        var employment_type = $("#employment_type").val().split("~");
        var employment_type_ = employment_type[1];
        var employee_number = $("#employee_number").val();
        var employee_code = $("#employee_code").val();
        var department = $("#department").val();
        var date_of_employment = $("#date_of_employment").val();
        var last_update_date = $("#last_update_date").val();
        var tax_identification_number = $("#tax_identification_number").val();
        var us_citizen = citizen_of_US;
        var resident = us_resident;
        var prove_of_address = $("#proof_of_address_").val();

        console.log(title_);
        console.log(marital_status_);
        console.log(id_type_);
        console.log(employment_type_);
        // console.log(title_);

        $.ajax({
            type: "POST",
            url: "submit-kyc",
            datatype: "application/json",
            data: {
                customer_number: customer_number,
                title: title_,
                firstname: firstname,
                surname: surname,
                Othername: Othername,
                telephone_number: telephone_number,
                email_address: email_address,
                date_of_birth: date_of_birth,
                gender: gender,
                marital_status: marital_status_,
                number_of_children: number_of_children,
                number_of_dependents: number_of_dependents,
                nationality: nationality_,
                id_type: id_type_,
                id_number: id_number,
                date_of_issue: date_of_issue,
                date_of_expiry: date_of_expiry,
                mother_maiden_name: mother_maiden_name,
                next_of_kin_name: next_of_kin_name,
                next_of_kin_address: next_of_kin_address,
                next_of_kin_telephone: next_of_kin_telephone,
                country_of_residence: country_of_residence,
                years_at_residence: years_at_residence,
                building_name: building_name,
                town: town,
                residential_address: residential_address,
                postal_address: postal_address,
                employment_type: employment_type_,
                employee_number: employee_number,
                employee_code: employee_code,
                department: department,
                date_of_employment: date_of_employment,
                last_update_date: last_update_date,
                tax_identification_number: tax_identification_number,
                us_citizen: us_citizen,
                resident: resident,
                prove_of_address: prove_of_address,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                siteLoading("hide");
                console.log(response);
                // return false;
                if (response.responseCode == "000") {
                    swal.fire({
                        // title: "Transfer successful!",
                        html: response.message,
                        icon: "success",
                        // showConfirmButton: "false",
                        confirmButtonColor: "green",
                    });
                    // toaster(response.message, "success", 10000);
                } else {
                    toaster(response.message, "error", 6000);
                }
            },
        });
    });
});
