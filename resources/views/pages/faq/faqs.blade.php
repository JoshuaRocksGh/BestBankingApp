<div class=" container dashboard mx-auto mb-0 site-card">

    {{--  <a href="{{ url()->previous() }}" type="button" class="btn position-absolute" style="left: 5px"><i
            class="fe-arrow-left"></i>&nbsp;Go
        Back</a>  --}}
    <div class="dashboard-header text-center">

        <h3>Frequently Asked Questions</h3>

    </div>
    <div class="dashboard-body p-4">
        <section class="section" id="faq">
            <div class="container-fluid">

                <!-- end row -->

                <div class="row">
                    <div class="col-lg-5 offset-lg-1">
                        <!-- Question/Answer -->
                        <div>
                            <div class="faq-question-q-box">Q.</div>
                            <h4 class="faq-question">WHAT IS INTERNET BANKING?</h4>
                            <p class="faq-answer mb-4 pb-1 text-muted">
                                Internet banking is a real-time solution that allows you to do the following in
                                a secure manner;
                                <br>
                                <br>
                                > Access your accounts 24 hours a day, 7 days a week.<br>
                                > Check your balances, view your account statements and transaction history for
                                your various accounts.<br>
                                > Transfer money between your accounts. <br>
                                > Pay your bills. <br>
                                > Change your password over the internet. <br>
                            </p>
                        </div>

                        <!-- Question/Answer -->
                        <div>
                            <div class="faq-question-q-box">Q.</div>
                            <h4 class="faq-question">WHAT DO I NEED TO MAKE USE OF THIS SERVICE?</h4>
                            <p class="faq-answer mb-4 pb-1 text-muted">
                                Our internet banking is easy to use. All you need is: <br><br>
                                > A personal computer that is connected to the internet. <br>
                                > Any browser of your choice. <br>
                                > Open your browser and log on to Public Bank Internet Banking.

                            </p>
                        </div>

                        <!-- Question/Answer -->
                        <div>
                            <div class="faq-question-q-box">Q.</div>
                            <h4 class="faq-question">HOW SECURE IS INTERNET BANKING?</h4>
                            <p class="faq-answer mb-4 pb-1 text-muted">
                                The information you provide is kept strictly confidential. The latest electronic
                                encryption technology ensures the secure transfer of information over the
                                internet. As account security is important to us, we have built safety measures
                                into PUBLIC Bank which reflect the importance of this issue.

                            </p>
                        </div>

                    </div>
                    <!--/col-lg-5 -->

                    <div class="col-lg-5">
                        <!-- Question/Answer -->
                        <div>
                            <div class="faq-question-q-box">Q.</div>
                            <h4 class="faq-question">IS THERE A CHARGE FOR USING THE INTERNET BANKING
                                APPLICATION?</h4>
                            <p class="faq-answer mb-4 pb-1 text-muted">
                                Currently, the service is provided at no charge.
                            </p>
                        </div>

                        <!-- Question/Answer -->
                        <div>
                            <div class="faq-question-q-box">Q.</div>
                            <h4 class="faq-question">WHAT IF I FORGET MY USERNAME OR PASSWORD?</h4>
                            <p class="faq-answer mb-4 pb-1 text-muted">
                                If you forget username or password, click <a href="{{ url('forgot-password') }}">
                                    HERE</a> to reset your password.
                            </p>
                        </div>

                        <!-- Question/Answer -->
                        <div>
                            <div class="faq-question-q-box">Q.</div>
                            <h4 class="faq-question">HOW SECURE IS MY TRANSACTION?</h4>
                            <p class="faq-answer mb-4 pb-1 text-muted">
                                The safety and confidentiality of customers’ personal information is our top
                                priority. The security system makes use of the latest technologies, standards,
                                and business practices to guarantee customer security including: Firewall
                                Protection, Password and Data Security, Secure Socket Layer (SSL), Audits and
                                Inspections, Data Integrity, and Physical Security.
                            </p>
                        </div>

                    </div>
                    <!--/col-lg-5-->
                </div>
                <!-- end row -->

            </div> <!-- end container-fluid -->
        </section>
        <!-- faqs end -->

        <div class="row">
            <div class="col-md-6">
                <div class="accordion custom-accordion" id="custom-accordion-one">
                    <div class="card mb-0">
                        <div class="card-header" id="headingNine">
                            <h5 class="m-0 position-relative">
                                <a class="custom-accordion-title text-reset d-block" data-toggle="collapse"
                                    href="#collapseNine" aria-expanded="true" aria-controls="collapseNine">
                                    Q. How often can I transfer funds? <i
                                        class="mdi mdi-chevron-down accordion-arrow"></i>
                                </a>
                            </h5>
                        </div>

                        <div id="collapseNine" class="collapse show" aria-labelledby="headingFour"
                            data-parent="#custom-accordion-one">
                            <div class="card-body">
                                You can transfer funds 24 hours a day, seven days a week through the convenience
                                of your computer up to the maximum daily transfer limit.
                            </div>
                        </div>
                    </div>
                    <div class="card mb-0">
                        <div class="card-header" id="headingFive">
                            <h5 class="m-0 position-relative">
                                <a class="custom-accordion-title text-reset collapsed d-block" data-toggle="collapse"
                                    href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Q. How does the approval process work? <i
                                        class="mdi mdi-chevron-down accordion-arrow"></i>
                                </a>
                            </h5>
                        </div>
                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive"
                            data-parent="#custom-accordion-one">
                            <div class="card-body">
                                The Public Bank Inter-Account Transfer approval process consists of
                                basic
                                verification of the information that you provided. The ‘To Account’ of the
                                beneficiary account will be checked against the database for the validity of the
                                account. The approval process is done to ensure the safety and security of your
                                transaction.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div id="accordion" class="mb-3">
                    <div class="card mb-1">
                        <div class="card-header" id="headingOne">
                            <h5 class="m-0">
                                <a class="text-dark" data-toggle="collapse" href="#collapseOne" aria-expanded="true">
                                    <i class="mdi mdi-help-circle mr-1 text-primary"></i>
                                    How do I sign-up for Internet Banking?
                                </a>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                            data-parent="#accordion">
                            <div class="card-body">
                                If you are already a customer with Public Bank, click <a
                                    href="{{ url('/') }}">Here</a> to enroll.

                            </div>
                        </div>
                    </div>
                    <div class="card mb-1">
                        <div class="card-header" id="headingTwo">
                            <h5 class="m-0">
                                <a class="text-dark" data-toggle="collapse" href="#collapseTwo" aria-expanded="false">
                                    <i class="mdi mdi-help-circle mr-1 text-primary"></i>
                                    What if I have another question?
                                </a>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                Contact the Public Bank Customer Centre via email:customerservice@publicbank.com.my
                                or during normal working hours, Mon-Fri 8:00 A.M to 3:00 PM <br>
                                call: <br>
                                603-2170 8000<br>
                                603-2176 8168
                            </div>
                        </div>
                    </div>
                </div> <!-- end #accordions-->
            </div> <!-- end col -->
        </div>
    </div>
</div>
