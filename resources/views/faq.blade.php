@include('includes.header')

	 <main id="main">


        <!--Section-Faq-Grid-->

        <section class="faq">
            <div class="container">
                {{ Breadcrumbs::render('faq') }}
                <div class="row">
                    <div class="col-lg-9">
                        <div class="heading-section">
                            <h2>faq</h2>
                        </div>
                    </div>
                </div>
                <div class="row faq-grid">
                    <div class="col-lg-12">
                        <div class="faq-txt">
                            <!--Accordion wrapper-->
                            <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">

                                <!-- Accordion card -->
                                <div class="card">

                                    <!-- Card header -->
                                    <div class="card-header" role="tab" id="headingOne1">
                                        <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
                                            <h5 class="mb-0">
                                                <div class="faq-heading">
                                                    <figure>
                                                        <img src="images/icn-accordian.png" alt="icn">
                                                    </figure>
                                                    How often is permit data updated?
                                                </div> <i class="fa fa-angle-down rotate-icon"></i>
                                            </h5>
                                        </a>
                                    </div>

                                    <!-- Card body -->
                                    <div id="collapseOne1" class="collapse show" role="tabpanel" aria-labelledby="headingOne1" data-parent="#accordionEx">
                                        <div class="card-body">
                                            <p>PermitSearch.com researches each request in real time, providing the most up to date information available.  In fact, as municipalities throughout the country continue to digitize their data, PermitSearch.com may even by able to upload certain permit data immediately.  For those municipalities that haven’t yet automated their data, PermitSearch.com will initiate an OPRA request within 24 hours.</p>
                                        </div>
                                    </div>

                                </div>
                                <!-- Accordion card -->

                                <!-- Accordion card -->
                                <div class="card">

                                    <!-- Card header -->
                                    <div class="card-header" role="tab" id="headingTwo2">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo2" aria-expanded="false" aria-controls="collapseTwo2">
                                            <h5 class="mb-0">
                                                <div class="faq-heading">
                                                    <figure>
                                                        <img src="images/icn-accordian.png" alt="icn">
                                                    </figure>
                                                    What is an OPRA Request?
                                                </div> <i class="fa fa-angle-down rotate-icon"></i>
                                            </h5>
                                        </a>
                                    </div>

                                    <!-- Card body -->
                                    <div id="collapseTwo2" class="collapse" role="tabpanel" aria-labelledby="headingTwo2" data-parent="#accordionEx">
                                        <div class="card-body">
                                            <p>The term OPRA (“Open Permit Records Act”) refers to the statute that provides the public the right to access certain public records in New Jersey, as well as the process by which that right may be exercised.  In Pennsylvania, this is known as the Right to Know act.</p>
                                        </div>
                                    </div>

                                </div>
                                <!-- Accordion card -->

                                <!-- Accordion card -->
                                <div class="card">

                                    <!-- Card header -->
                                    <div class="card-header" role="tab" id="headingThree3">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseThree3" aria-expanded="false" aria-controls="collapseThree3">
                                            <h5 class="mb-0">
                                                <div class="faq-heading">
                                                    <figure>
                                                        <img src="images/icn-accordian.png" alt="icn">
                                                    </figure>
                                                    How long does it take to get permit information?
                                                </div> <i class="fa fa-angle-down rotate-icon"></i>
                                            </h5>
                                        </a>
                                    </div>

                                    <!-- Card body -->
                                    <div id="collapseThree3" class="collapse" role="tabpanel" aria-labelledby="headingThree3" data-parent="#accordionEx">
                                        <div class="card-body">
                                            <p>For those municipalities in PermitSearch.com’s ever growing database, obtaining the permit information happens immediately.  For those municipalities that aren’t yet in the database, PermitSearch.com files its OPRA requests within 24 hours of an order.  The statute provides the municipality with 5-7 business days to respond.  Once the response has been received by PermitSearch.com, it will become available to you within 24 hours.</p>
                                        </div>
                                    </div>

                                </div>
                                <!-- Accordion card -->

                                <!-- Accordion card -->
                                <div class="card">

                                    <!-- Card header -->
                                    <div class="card-header" role="tab" id="headingfour4">
                                        <a data-toggle="collapse" data-parent="#accordionEx" href="#collapsefour4" aria-expanded="true" aria-controls="collapsefour4">
                                            <h5 class="mb-0">
                                                <div class="faq-heading">
                                                    <figure>
                                                        <img src="images/icn-accordian.png" alt="icn">
                                                    </figure>
                                                    What is an open permit?
                                                </div> <i class="fa fa-angle-down rotate-icon"></i>
                                            </h5>
                                        </a>
                                    </div>

                                    <!-- Card body -->
                                    <div id="collapsefour4" class="collapse" role="tabpanel" aria-labelledby="headingfour4" data-parent="#accordionEx">
                                        <div class="card-body">
                                            <p>An open permit refers to any permit for work on a property that has been issued by the municipality, but has not been formally closed, usually by a final inspection.  This would also include “expired” permits.</p>
                                        </div>
                                    </div>

                                </div>
                                <!-- Accordion card -->

                                <!-- Accordion card -->
                                <div class="card">

                                    <!-- Card header -->
                                    <div class="card-header" role="tab" id="headingfive5">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapsefive5" aria-expanded="false" aria-controls="collapsefive5">
                                            <h5 class="mb-0">
                                                <div class="faq-heading">
                                                    <figure>
                                                        <img src="images/icn-accordian.png" alt="icn">
                                                    </figure>
                                                    What happens if there are open permits on a property?
                                                </div> <i class="fa fa-angle-down rotate-icon"></i>
                                            </h5>
                                        </a>
                                    </div>

                                    <!-- Card body -->
                                    <div id="collapsefive5" class="collapse" role="tabpanel" aria-labelledby="headingfive5" data-parent="#accordionEx">
                                        <div class="card-body">
                                            <p>A surprise discovery of any open permits can derail and/or delay the sale of a property.  For example, some municipalities will not issue a Certificate of Occupancy (required by law in order to sell a home) if there is an open permit.  Open permits can also be grounds for the title company to balk or for the lender to renege on financing.  If these open permits are found after closing, the costs incurred will become the new owner’s responsibility.  Let PermitSearch.com get the open permits out in the open.</p>

                                        </div>
                                    </div>

                                </div>
                                <!-- Accordion card -->

                            </div>
                            <!-- Accordion wrapper -->
                            .
                        </div>
                        <div class="mt-4">
                            <h4>Need more information? <a href="{{ route('web.contactus') }}" class="font-weight-bold">Contact us </a></h4>
                            <!-- <p>You may contact PermitSearch.com via email here.</p> -->
                        </div>
                        <div class="load-more-btn">
                            {{-- <a class="btn btn-effect" href="#">Load more</a> --}}
                        </div>

                    </div>

                    <!-- <div class="col-lg-3">

                        <div class="faq-topic">
                            <h3>Search Topics</h3>
                            <div class="faq-topic-search">
                                <div class="form-group has-search">
                                    <span class="fa fa-search form-control-feedback"></span>
                                    <input type="text" class="form-control" name="keyword" placeholder="Search for help">
                                </div>
                            </div>
                        </div>
                    </div> -->

                </div>


            </div>
        </section>

        <!--Section-Faq-Grid-End-->


    </main>

@include('includes.footer')
