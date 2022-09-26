@include('includes.header')
<link rel="stylesheet" href="{{ asset('/css/pro.css') }}">
    <main id="main" class="landing-page">
        <!-- hero section  -->
        <section class="hero" style="background-image: url({{ asset('/pro_page/hero-banner.jpg') }});">
            <div class="container">
                <div class="position-relative text-left">
                    <h1 class="text-white mb-0">Permit Search</h1>
                    <h1 class="text-white mb-0"> Has Never Been Easier</h1>
                    <h5 class="text-white">Add permit history to your service offering</h5>
                </div>

            </div>
        </section>
        <!-- hero section end -->

        <!-- pro section  -->
        <section class="pro-section section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" >
                        <h2 class="main-heading">Go PRO</h2>
                        <div class="wrapper" style="text-align: justify;">
                        <p>As a real estate professional, you already know how important it can be to research for open records on property.  But, you also already know that this can be difficult and time consuming.
                        </p><p>PermitSearch.com will do this for you.</p>
                        
                        </div>
                        <p>Choose which subscription fits your business and let PermitSearch.com get those permits out in the open.</p>
                        
                        <ul class="listing-type" style="color:black">
                            <p>Benefits:</p>
                            <li>Save time.</li>
                            <li>Learn about all permits, open and/or closed on properties.</li>
                            <li>Customize your PermitSearch.com Dashboard to organize all your property searches in one place.</li>
                            <li>Smoothly integrate the PermitSearch.com results into your materials (inspection reports, listing packets, etc.)</li>
                            <li>Streamline the property sale process.</li>
                            <li>Eliminate permit surprises.</li>
                            <li>Perfect for realtors, home inspectors, brokers, real estate attorneys and anyone else involved in buying or selling a home!</li>
                        </ul>
                        <a href="@if(!Auth::check()) javascript:void(0) @else #priceSection  @endif" class="btn btn-blue btn-md @if(!Auth::check()) buy-now @endif">Buy Now</a>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 my-auto">
                        <img src="{{ asset('/pro_page/pro-img.jpg') }}" alt="Get Pro" class="img-shadow pro-image" style="margin-top: -550px !important;">
                    </div>
                </div>

            </div>
        </section>
        <!-- pro section end -->

        <!-- why us section  -->
        <section class="why-us-section bg-grey section-padding">
            <div class="container">
                <h3 class="main-heading text-center pb-3 ">PermitSearch.com is the fastest growing  permit history search available online</h3>
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 order-lg-1">
                        <div class="why-us-block">
                            <div class="why-choose d-flex align-items-center">
                                <div class="rounded-icon rounded-circle d-flex align-items-center justify-content-center flex-shrink-0">
                                    <img src="{{ asset('/pro_page/rate.png') }}" alt="">
                                </div>
                                <div class="why-choose-content flex-grow-1">
                                    <h6 class="dark-text">99%</h6>
                                    <strong class="dark-text">Customer Satisfaction</strong>
                                </div>
                            </div>

                            <div class="why-choose d-flex align-items-center">
                                <div class="rounded-icon rounded-circle d-flex align-items-center justify-content-center flex-shrink-0">
                                    <img src="{{ asset('/pro_page/user-check.png') }}">
                                </div>
                                <div class="why-choose-content flex-grow-1">
                                    <h6 class="dark-text">1,000+</h6>
                                    <strong class="dark-text">PermitSearch.com PRO users</strong>
                                </div>
                            </div>

                            <div class="why-choose d-flex align-items-center">
                                <div class="rounded-icon rounded-circle d-flex align-items-center justify-content-center flex-shrink-0">
                                    <img src="{{ asset('/pro_page/search.png') }}" alt="">
                                </div>
                                <div class="why-choose-content flex-grow-1">
                                    <h6 class="dark-text">9.7B</h6>
                                    <strong class="dark-text">Lost sales annually due to permit issues</strong>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 order-lg-0">
                        <div class="text-lg-left text-center">
                            <img src="{{ asset('/pro_page/why-us-img.png') }}" class="why-us-img">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- why us section end -->

        <!-- benefits section  -->
        <section class="benefits-section bg-blue section-padding">
            <div class="container">
                <h4 class="main-heading text-center text-white pb-3 ">PRO Subscription Benefits</h4>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 benefits-column">
                        <div class="card text-center benefits-card h-100">
                            <div class="rounded-icon rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mx-auto">
                                <img src="{{ asset('/pro_page/benefits-icon1.png') }}" alt="">
                            </div>
                            <div class="card-body p-0 d-flex flex-column justify-content-between">
                                <div class="card-content">
                                    <strong class="card-title">Personalized Dashboard</strong>
                                    <p class="card-text mb-3">Manage all of your permit searches in one place.</p>
                                </div>
                              <a href="@if(!Auth::check()) javascript:void(0) @else  {{ url('/buy-subscription/'.Crypt::encrypt(7)) }} @endif" class="btn-link dark-blue-text @if(!Auth::check()) buy-now @endif">Get Started <img src="{{ asset('/pro_page/arrow-icon.png') }}" alt=""></a>
                            </div>
                          </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 benefits-column">
                        <div class="card text-center benefits-card h-100">
                            <div class="rounded-icon rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mx-auto">
                                <img src="{{ asset('/pro_page/benefits-icon2.png') }}" alt="">
                            </div>
                            <div class="card-body p-0 d-flex flex-column justify-content-between">
                                <div class="card-content">
                                    <strong class="card-title">Customized Reports</strong>
                                    <p class="card-text mb-3">Personalize your permit history reports with logo, name, and more.</p>
                                </div>
                              <a href="@if(!Auth::check()) javascript:void(0) @else  {{ url('/buy-subscription/'.Crypt::encrypt(7)) }} @endif" class="btn-link dark-blue-text @if(!Auth::check()) buy-now @endif">Get Started <img src="{{ asset('/pro_page/arrow-icon.png') }}" alt=""></a>
                            </div>
                          </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 benefits-column">
                        <div class="card text-center benefits-card h-100">
                            <div class="rounded-icon rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mx-auto">
                                <img src="{{ asset('/pro_page/benefits-icon3.png') }}" alt="">
                            </div>
                            <div class="card-body p-0 d-flex flex-column justify-content-between">
                                <div class="card-content">
                                    <strong class="card-title">Discount Pricing</strong>
                                    <p class="card-text mb-3">Different pricing tiers available. The more you use, the more you save.</p>
                                </div>
                              <a href="@if(!Auth::check()) javascript:void(0) @else  {{ url('/buy-subscription/'.Crypt::encrypt(7)) }} @endif" class="btn-link dark-blue-text @if(!Auth::check()) buy-now @endif">Get Started <img src="{{ asset('/pro_page/arrow-icon.png') }}" alt=""></a>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- benefits section end -->

        <!-- plans pricing section  -->
        <section class="pricing section-padding">
            <div class="container">
                <h5 class="main-heading text-center pb-3 ">Plans & Pricing</h5>
                <div class="row pricing-table-row pt-0" id="priceSection">

                @if(!$price->isEmpty())
                   @foreach($price as $key => $value)
                    {{-- @if($value->plan_period != "single") --}}
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                            <div class="pricing-table-inner table-one">
                                <div class="package-name">{{ str_replace(' Monthly', '', $value->title) }}</div>
                                <div class="package-price">
                                    Only <h4>${{$value->price}}</h4>
                                </div>
                                <div class="inner-txt">{{$value->report}}</div>
                                
                                <div class="inner-txt"><a class="btn btn-effect @if(!Auth::check()) buy-now @endif" href="@if(!Auth::check()) javascript:void(0) @else  {{ url('/buy-subscription/'.Crypt::encrypt($value->id)) }} @endif" data-val="{{$value->price}}">Buy Now</a> </div>
                            </div>
                        </div>
                    {{-- @endif --}}
                @endforeach
            @endif


                    <div class="col-12 text-center">
                        <h5> Need more reports?  <span class="font-weight-bold">50+</span> <a href="{{ route('web.contactus') }}" class="font-weight-bold">Contact us </a> </h5>
                    </div>
                </div>
            </div>
        </section>
        @include('includes.popup-sections')

        </main>
        <!-- plans pricing section end -->

        <!-- Subscription section  -->
        <!-- <section class="cta-section">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                        <h6 class="main-heading text-white">For Daily Updates Subscribe Now</h6>
                        <p class="text-white mb-0">Get started by putting PermitSearch.com to work for your business.
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
                        </p>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 my-auto text-md-right">
                        <button class="btn btn-white btn-md">Subscribe</button>
                    </div>
                </div>
            </div>
        </section> -->
        <!-- Subscription section end -->

        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
    $(function() {

        var $form = $(".require-validation");
        $('form.require-validation').bind('submit', function(e) {
            e.preventDefault();
            if (!$form.data('cc-on-file')) {
              e.preventDefault();
              Stripe.setPublishableKey($form.data('stripe-publishable-key'));
              Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
              }, stripeResponseHandler);
            }
        });

      function stripeResponseHandler(status, response) {
            if (response.error) {
                $('#stPEss').text(response.error.message).show().delay(4000).fadeOut("slow");
                return false;
            } else {
                /* token contains id, last4, and card type */
                var token = response['id'];

                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }
    });
</script>
@include('includes.footer')
