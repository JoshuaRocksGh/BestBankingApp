<div class="w-100">
    <div class=" site-card p-1 mb-1">
        <h6 class="pl-3 pt-2">Quick Links</h6>
        <div class="d-flex w-100">
            <a href='payments'
                class="site-card-body px-2 d-flex align-items-center justify-content-around grad-blue-pink  w-100 border-0  grad "
                style="min-height: 75px">

                <div class=""><i class="fas font-24 fa-money-check-alt"></i> </div>
                <div class="font-weight-bold ml-2 font-12">&nbsp;MAKE PAYMENT</div>
            </a>
            <a href="qr-payment"
                class="site-card-body d-flex align-items-center justify-content-center  border-0  grad-gray-blue grad "
                style="min-height: 75px; min-width: 100px;">
                <div class=""><i class="fas font-24 fa-qrcode"></i> </div>
                <div class=" font-weight-bold ml-2 font-12">QR</div>
            </a>

        </div>
        <div class="d-flex w-100">
            <a href="own-account"
                class="site-card-body px-2 d-flex align-items-center justify-content-center grad-blue-pink  w-100 border-0  grad-gray-blue red-orange grad "
                style="min-height: 75px">
                <div class=""><i class="fas font-18 fa-sync"></i> </div>

                <div class=" font-weight-bold ml-2 font-12">MAKE TRANSFER</div>
            </a>
            <a href="account-enquiry"
                class="site-card-body px-2 d-flex align-items-center justify-content-center grad-yellow-pink  w-100 border-0 green-yellow grad-gray-blue grad "
                style="min-height: 75px">
                <div class=""><i class="fas font-18 fa-credit-card"></i> </div>
                <div class=" font-weight-bold ml-2 font-12">My Accounts</div>
            </a>
        </div>
    </div>
    <div class="dashboard site-card p-1 my-2">
        <div class="site-card-body p-0 border-0">
            <img class="img-fluid rounded" height="200" src="{{ asset('assets/images/placeholders/banking.png') }}" />

        </div>
    </div>
    <div class="site-card p-1 my-2" style="min-height: auto !important">
        <div class="site-card-body  p-0 border-0" style="min-height: auto !important">
            <button
                class="rate_button p-2 border-0 grad-rokel w-100 grad d-flex align-items-center justify-content-center  grad-blue-pink"
                style="min-height: 25px">
                <div class=""><i class="fas font-24 fa-money-check-alt"></i> </div>
                <div class="font-weight-bold ml-2 font-12">&nbsp;Currency Rates</div>
            </button>
        </div>
    </div>

    <div class=" site-card p-1">
        <div class="site-card-body py-2 bg-info" style="min-height: 10px !important;">
            <h6 class="text-center mb-0 text-white">Bank Contact</h6>
        </div>
        <div class="site-card-body">
            <div class="mb-2 font-13"> <i class="mr-1 fas fa-user text-info"></i><span class="font-weight-bold">Name
                    :
                </span><span>SIB Bank Ltd.</span> </div>
            <div class="mb-2 font-13"> <i class="mr-1 fas fa-phone text-info"></i><span class="font-weight-bold">Phone
                </span> <span>+232 88 225225</span>
                <br>
                <span class="text-center">+232 79 211121</span>
                <br>
                </span> <span>+232 31 464541</span>
            </div>
            <div class="mb-2 font-13"> <i class="mr-1 fas fa-envelope text-info"></i><span
                    class="font-weight-bold">Email
                    :</span> <span> customercare@sibll.com</span> </div>

        </div>
    </div>
</div>
@include('snippets.rateCalculator')

<script>
    $(() => {

        (async () => {
            await Promise.all([getCurrencies(), getFx()])
        })()
    })
    //     $(async()=>{

    //    console.log(pageData)
    //      document.getElementById('rate_carousel').innerHTML = '';
    //          pageData.currencies.forEach(function (currency , i) {
    //         if (currency.isoCode === "SLL") return
    //         document.getElementById('rate_carousel').innerHTML += `
    //         <div class="carousel-item ${currency.isoCode === 'SLO' ? 'active' : ''}">
    //                 <button data-currency='${currency.isoCode}' class="d-flex w-100 currency-button justify-content-between bg-white  align-items-center p-3 mt-2 rounded-lg ">
    //           <div class="d-flex align-items-center">  <img  class="rounded-circle" style="width: 25px; height: 25px;"
    //           src="assets/images/flags/${currency.isoCode}.png" alt="logo">
    //          <span class="font-weight-bold text-12 pl-2 text-primary">${currency?.description}</span>
    //           </div>
    //           <div class="">
    //            <div class="font-weight-bold text-12 text-right text-primary">
    //              1 ${currency.isoCode} = SLL ${formatToCurrency(currencyConvertor(pageData.fxRate, 1.00, currency.isoCode, 'SLL')?.convertedAmount)}
    //               </div>
    //                <div class="text-secondary text-right font-10">updated on => ${new Date(pageData?.fxRate?.find(r=>r.PAIR===(currency.isoCode + '/' + " SLL"))?.POSTING_DATE).toISOString().slice(0,10)} </div>
    //              </div>
    //             </button>
    //             </div> `;
    //     })
    //  })
    // })
</script>
