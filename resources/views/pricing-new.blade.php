@include('includes.header')
<style>
    label {
        margin-bottom: 0;
    }
    p{
        margin-bottom: 0.5rem;
    }
    .input-group-addon{
        position: absolute;
        right: 10px;
        top: 5px;
    }
</style>
<main id="main">
    <section class="px-5 mt-5">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <form method="POST" action="{{ url('/pay/payment') }}" role="form"
                          class="require-validation" enctype="multipart/form-data"
                          data-cc-on-file="false" data-stripe-publishable-key="{{ config('app.STRIPE_KEY') }}"
                          id="payment-form">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <h2 class="permit-text">Order Permit Search Reports</h2>
                                <p class="text-secondary">
                                    <i>
                                        We can obtain permit history for <span class="permit-blue">{{ request()->searchQuery }}</span>
                                    </i><br>
                                    <i class="small">Request submitted to the municipality within 24 hours. Responses usually received within 5 – 7  business days.</i>
                                </p>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-sm-12 mb-5">
                                <h3 class="permit-text">Step 1. Select an option below</h3>
                            </div>
                            @if (!empty($price))
                                @foreach ($price as $key => $value)
                                    {{-- @if ($value->plan_period != 'single') --}}
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class=" card-header permit-bg-grey">
                                                <div class="row">
                                                    <div class="col-11">
                                                        @if($value->title == "Advanced")
                                                            <img class="package-img" src="{{asset("/images/package.png")}}" alt="">
                                                        @endif
                                                        <label class="text-light" for="radio_{{ $value->price }}">
                                                            <strong>{{ $value->title }}</strong>
                                                        </label>
                                                    </div>
                                                    <div class="col-1 p-0">
                                                        <input
                                                            class="form-check-input permit-radio pull-right input"
                                                            type="radio" name="SBID"
                                                            id="radio_{{ $value->price }}"
                                                            onclick="selectionPlan('radio_{{ $value->price }}')"
                                                            value="{{ Crypt::encrypt($value->id) }}"
                                                            data-val="{{ $value->price }}">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="card-body text-center">
                                                <p class="small"><strong>{{ $value->report }}</strong></p>
                                                <p class="permit-blue lead text-center">
                                                    <strong>${{ $value->price }}</strong></p>
                                                <p class="small">{{ $value->description }}</p>
                                            </div>
                                        </div>

                                    </div>
                                    {{-- @endif --}}
                                @endforeach
                            @endif
                            <div class="col-sm-12 mt-5">
                                <p class="permit-blue">Each Permit Search Report Includes:</p>
                                <ul>
                                    <li class="small"><span class="fa fa-check permit-blue"></span> Complete Permit History
                                    </li>
                                    <li class="small"><span class="fa fa-check permit-blue"></span> Information on open
                                        permits</li>
                                    <li class="small"><span class="fa fa-check permit-blue"></span> Information on closed
                                        permits</li>
                                    <li class="small"><span class="fa fa-check permit-blue"></span> Permit dates</li>
                                    <li class="small"><span class="fa fa-check permit-blue"></span> Permit details</li>
                                    <li class="small"><span class="fa fa-check permit-blue"></span> Permit costs</li>
                                    <li class="small"><span class="fa fa-check permit-blue"></span> Access reports for 1 full
                                        year</li>
                                    <li class="small"><span class="fa fa-check permit-blue"></span> Print, download, share
                                        reports</li>
                                </ul>
                            </div>

                        </div>
                        <div class="row mt-4">

                            <div class="col-lg-12">
                                <h3 class="permit-text">Step 2. Account info</h3>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group required">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" disabled  value="{{Auth::user()->name}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group required">
                                    <label>Email Address</label>
                                    <input type="email" class="form-control" disabled  value="{{Auth::user()->email}}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h3 class="permit-text">Step 3. Payment Info</h3>
                                    </div>
                                    <div class="col-sm-6 ">
                                        <img class="img-fluid float-right" src="{{asset("/images/payment.png")}}" alt="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg">
                                        <div class="form-group required">
                                            <label>Name on Card</label>
                                            <input class='form-control nuFldEnaClasAlpha' size='4' type='text'
                                                   id="regccname">
                                            <span class="errorClasss" id="regnameCarNam"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <div class="form-group required">
                                            <label>Card Number</label>
                                            <input autocomplete='off' id="regCradname"
                                                   class='form-control card-number nuFldEnaClas' size='20'
                                                   maxLength="16"
                                                   type='text'>
                                            <span class="errorClasss" id="regnameCarNum"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 exp-month ml-0 mr-0">
                                        <div class="form-group required">
                                            <label>Exp. Month</label>
                                            <input class='form-control card-expiry-month nuFldEnaClas' maxLength="2"
                                                   size='2' type='text' id="regCradMn">
                                            <span class="errorClasss" id="regnameMon"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group required">
                                            <label>Year</label>
                                            <input class='form-control card-expiry-year nuFldEnaClas' maxLength="4"
                                                   size='4' type='text' id="regCradYr">
                                            <span class="errorClasss" id="regnameYea"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group required">
                                            <label>CVV</label>
                                            <input autocomplete='off' class='form-control card-cvc nuFldEnaClas'
                                                   maxLength="3" size='3' type='text' id="regCradCv">
                                            <span class="errorClasss" id="regnameCvv"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input class='form-control coupon' type='hidden' name="coupon_code">
                                        <div class="coupon-code-question">
                                            <a href="javascript:void(0)" class="coupon-code-link">Have a coupon?</a>
                                        </div>
                                        <input type="hidden" class="price-value" name="priceIDVal" id="priceIDVal">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-12">
                                        <div class="form-check accept by-signing">
                                            <label class="form-check-label" for="check2">
                                                <input type="checkbox" class="form-check-input" id="check2" name="option2"
                                                       value="termcheck" required="required"> I agree to the Customer Agreement
                                                and understand that PermitSearch may not have the complete history of every
                                                Permit
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-12">
                                        <span class="errorClasss" id="stPEss"></span>
                                        <div class="blue-bg-btn">
                                            <button class="btn btnn-effect" style="background: #5AB9E3!important;color:#fff;"
                                                    type="submit">Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>

    {{--    @include('includes.popup-sections')--}}
</main>
<!-- Popup section for apply coupon code -->
<section class="popup-already-account popup-account apply-couponcode-popup" style="display: none;">
    <div class="popup-table">
        <a href="javascript:void(0)" class="close-popup-coupon-code">&times;</a>
        <form method="POST" action="javascript:void(0);">
            @csrf
            <div class="popup-already-account-txt">
                <div class="popup-already-account-header">
                    <h2>Apply Coupon Code</h2>
                </div>

                <span id="coupon-code-error" class="logErrClass" style="display:none">
                    <div class="alert alert-danger"></div>
                </span>

                <div class="popup-account-info">
                    <div class="account-info-txt">
                        <div class="row">
                            <div class="col-lg-12">
                                <label>Coupon Code</label>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group required">
                                    <input type="text" class="form-control" name="coupon_code" id="coupon_code"
                                           placeholder="Enter coupon code. eg. 50PERFREE">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group required">
                                    <div class=""><button
                                            class="btn btnn-effect btn-block apply-code-btn" type="button"
                                            id="apply_code_btn">Apply</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!--Section-table-popup-End-->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
    $(function () {
        var $form = $(".require-validation");
        $('form.require-validation').bind('submit', function (e) {
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
                var token = response['id'];
                var coupon_code = $('.coupon').val();
                if (coupon_code) {
                    $.ajax({
                        type: "POST",
                        url: "{{url('validate-coupon')}}",
                        data: {coupon: coupon_code, "_token": "{{ csrf_token() }}"},
                        success: function (resp) {
                            if (resp.status && resp.status == 'false') {
                                //$('.error').css('display','block').find('.alert').text(resp.message);
                                $('#stPEss').text(resp.message).show().delay(4000).fadeOut("slow");
                                return false;
                            } else {
                                $('.coupon-error').css('display', 'none');
                                /* token contains id, last4, and card type */
                                $form.find('input[type=text]').empty();
                                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                                $form.get(0).submit();
                            }
                        }
                    });
                } else {
                    /* token contains id, last4, and card type */
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }
        }
    });
</script>
@include('includes.footer')
<script>
    $(document).ready(function () {
        $("body").removeClass("popup-open");
    });
    let selectionPlan = element => {
        $(".card-header").removeClass("permit-bg-blue").addClass("permit-bg-grey").parent().css("border", "1px solid rgba(0, 0, 0, 0.125)");
        $(`#${element}`).parent().parent().parent().removeClass("permit-bg-grey").addClass("permit-bg-blue").parent().css("border", "1px solid #5ab9e3");
    }
</script>
