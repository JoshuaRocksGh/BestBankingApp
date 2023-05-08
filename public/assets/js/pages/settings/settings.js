document.addEventListener("DOMContentLoaded", function (event) {
    // console.log("dong");
    if (ISCORPORATE) {
        var settingsList = [
            {
                title: "create originator",
                icon: "user-plus",
                bgClass: "green-yellow",
                dataTarget: "#create_originator",
            },
            {
                title: "change password",
                icon: "user-lock",
                bgClass: "grad-blue-pink",
                dataTarget: "#change_password_modal",
            },
            // {
            //     title: "forgot transaction pin",
            //     icon: "window-close",
            //     bgClass: "green-yellow",
            //     dataTarget: "#forgot_pin_modal",
            // },
            {
                title: "Enquiry",
                icon: "comments",
                bgClass: "pink-cyan",
                dataTarget: "#enquiry_modal",
            },
            // {
            //     title: "Tarrif List",
            //     icon: "chart-bar",
            //     bgClass: "cyan-green",
            // },
            // {
            //     title: "Agent List",
            //     icon: "users",
            //     bgClass: "yellow-yellow",
            // },
            {
                title: "Help (FAQs)",
                icon: "question-circle",
                bgClass: "blue-blue",
                dataTarget: "#faq_modal",
            },
            {
                title: "Terms and Conditions",
                icon: "file-contract",
                bgClass: "red-orange",
                dataTarget: "#terms_condition_modal",
            },
            {
                title: "Contact Us",
                icon: "address-card",
                bgClass: "black-black",
                dataTarget: "#contact_us_modal",
            },
        ];
    } else {
        var settingsList = [
            {
                title: "change transaction pin",
                icon: "unlock-alt",
                bgClass: "grad-gray-blue",
                dataTarget: "#change_transaction_pin_modal",
            },
            {
                title: "change password",
                icon: "user-lock",
                bgClass: "grad-blue-pink",
                dataTarget: "#change_password_modal",
            },
            {
                title: "forgot transaction pin",
                icon: "window-close",
                bgClass: "green-yellow",
                dataTarget: "#forgot_pin_modal",
            },
            {
                title: "Enquiry",
                icon: "comments",
                bgClass: "pink-cyan",
                dataTarget: "#enquiry_modal",
            },
            // {
            //     title: "Tarrif List",
            //     icon: "chart-bar",
            //     bgClass: "cyan-green",
            // },
            // {
            //     title: "Agent List",
            //     icon: "users",
            //     bgClass: "yellow-yellow",
            // },
            {
                title: "Help (FAQs)",
                icon: "question-circle",
                bgClass: "blue-blue",
                dataTarget: "#faq_modal",
            },
            {
                title: "Terms and Conditions",
                icon: "file-contract",
                bgClass: "red-orange",
                dataTarget: "#terms_condition_modal",
            },
            {
                title: "Contact Us",
                icon: "address-card",
                bgClass: "black-black",
                dataTarget: "#contact_us_modal",
            },
        ];
    }

    let settingsHtml = "";
    settingsList.forEach((e) => {
        const { title, bgClass, icon, dataTarget } = e;
        settingsHtml += `   <button data-toggle="modal" data-target="${dataTarget}" class="card d-sm-block mx-auto d-flex  p-1   ${bgClass} pt-2 px-2 pt-sm-4 grad m-3 col-md-4" style="max-width: 180px;">
       <div class=" d-flex  card-img  w-20 h-20 justify-content-sm-center" >
        <i class="fas  fa-${icon}"></i>
        </div>
        <span class="sm-4 mt-2 mt-sm-4 d-sm-block font-weight-bold font-12">${title}</span>
<div class="text"> </div>
    </button>`;
    });
    document.getElementById("settings_display").innerHTML = settingsHtml;
});
