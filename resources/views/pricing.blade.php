@include('includes.header')

    <main id="main">
        <!--Section-Pricing-->
        <section class="pricing">
            <div class="container">
                {{ Breadcrumbs::render('pricing') }}
                <div class="heading-section">
                    <h2>Pricing</h2>
                </div>
                <span id="errorSpanC" style="text-align: center;">
                    @if(\Session::get('success'))
                        <div class="alert alert-danger">{{\Session::get('success')}}</div>
                    @endif
                    @if(Session::has('ffail'))
                        <div class="alert alert-danger">
                            {{Session::get('ffail')}}
                        </div>
                    @endif
                </span>

                <!-- Nav pills -->
               <!--  <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#first">Monthly</a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#second">Annual</a>
                    </li>
                </ul> -->

                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="first" class="container tab-pane active"><br>
                        @if(!$price->isEmpty())

                            <div class="row pricing-table-row">
                                @foreach($price as $key => $value)
                                    {{-- @if($value->plan_period != "single") --}}
                                        <div class="col-lg-4">
                                            <div class="pricing-table-inner table-one">
                                                <div class="package-name">{{$value->title}}</div>
                                                <div class="package-price">
                                                    Only <h4>${{$value->price}}</h4>
                                                </div>
                                                <div class="inner-txt">{{$value->report}}</div>
                                                <div class="inner-txt"><a class="btn btn-effect" href="{{ url('/') }}">Start Search</a> </div>
                                                <!-- <div class="inner-txt"><a class="btn btn-effect" href="{{ url('/buy-subscription/'.Crypt::encrypt($value->id)) }}">Buy Now</a> </div> -->
                                                <!-- <div class="inner-txt"><a class="btn btn-effect @if(!Auth::check()) buy-now @endif" href="@if(!Auth::check()) javascript:void(0) @else  {{ url('/buy-subscription/'.Crypt::encrypt($value->id)) }} @endif" data-val="{{$value->price}}">Buy Now</a> </div> -->
                                            </div>
                                        </div>
                                    {{-- @endif --}}
                                @endforeach
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12 text-center ">
                                    <a href="{{url('/pro')}}" class="text-link text-dark">Are you a real estate agent, inspector, or pro? Check out our PRO pricing</a>
                                </div>
                            </div>
                        @endif

                        <div class="row purchase-individuals d-none">
                            <div class="col-lg-12">
                                <div class="purchase-individuals-txt">
                                    @if(!$price->isEmpty())
                                        @foreach($price as $key => $value)
                                            @if($value->plan_period == "single")
                                                Purchase individual reports for $19/each. <a class="@if(!Auth::check()) buy-now @endif" class="@if(!Auth::check()) buy-now @endif" href="@if(!Auth::check()) javascript:void(0) @else  {{ url('/buy-subscription/'.Crypt::encrypt($value->id)) }} @endif " data-val="{{$value->price}}"> Buy Now.</a> Please <a href="{{  url('/subscribe') }}"> Subscribe </a>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Section-Pricing-End-->

    @include('includes.popup-sections')

    </main>
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
