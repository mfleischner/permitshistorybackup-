@php
if (Request::segment(1) == 'pricing' || Request::segment(1) == 'pro') {
    $flag = 'hide';
} else {
    $flag = 'show';
}
@endphp
<!--Section-table-popup-->
<section class="popup-already-account pricePOPUP" id="priPopUp" style="display: none;" data-val="{{ $flag }}">
    <div class="popup-table">
        <a href="{{ url('/?permit=cancel') }}" class="close-popup">&times;</a>
        <div class="popup-already-account-txt">
            <div class="popup-already-account-header">
                <h2>Already have an account? <a href="javascript:void(0)" id="loginPOP">Log In</a></h2>
            </div>
            <span id="SchooRESpan">
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        1{{ Session::get('success') }}
                    </div>
                @endif
                @if (Session::has('ffail'))
                    <div class="alert alert-danger">
                        3{{ Session::get('ffail') }}
                    </div>
                @endif
                @if (Session::has('fail'))
                    <div class="alert alert-danger">
                        {!! Session::get('fail')->first('name', '<div class="error-block">:message</div>') !!}
                        {!! Session::get('fail')->first('email', '<div class="error-block">:message</div>') !!}
                        6{!! Session::get('fail')->first('password', '<div class="error-block">:message</div>') !!}
                        {!! Session::get('fail')->first('stripeToken', '<div class="error-block">:message</div>') !!}
                        {!! Session::get('fail')->first('priceIDVal', '<div class="error-block">:message</div>') !!}
                    </div>
                @endif
            </span>
            <div class="popup-already-account-package">
                @if (!empty($price))
                    <div class="row package-row justify-content-center">
                        @foreach ($price as $key => $value)
                            {{-- @if ($value->plan_period != 'single') --}}
                                <div class="col-sm-6 p-0">
                                    <div class="package-txt">
                                        <label class="form-check-label">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="pricePlan"
                                                    id="radio_{{ $value->price }}"
                                                    value="{{ Crypt::encrypt($value->id) }}"
                                                    data-val="{{ $value->price }}" @if ($key == 0)checked @endif>
                                                <div class="form-check-label">
                                                    {{ $value->title }}
                                                </div>
                                            </div>
                                            <ul>
                                                <li><i class="fa fa-circle"></i>${{ $value->price }}</li>
                                                <li><i class="fa fa-circle"></i>{{ $value->report }}</li>
                                                <li><i class="fa fa-circle"></i>{{ $value->description }}</li>
                                            </ul>
                                        </label>
                                    </div>
                                </div>
                            {{-- @endif --}}
                        @endforeach
                    </div>
                @endif
                <!-- <div class="annual-subscription">Annual Subscription Pricing | <a href="{{ url('/pricing') }}"> Learn more</a></div> -->
            </div>
        </div>
        <div class="blue-bg-btn" id="contAddress"><a class="btn btnn-effect" href="javascript:void(0)">
                {{ isset($_GET['getcredits']) && $_GET['getcredits'] == 'yes' ? 'Next' : 'Continue to Register' }}</a>
        </div>
    </div>
</section>

<section class="popup-already-account popup-account accountLoginPOPUP" style="display: none;">
    <div class="popup-table">
        <a href="javascript:void(0)" class="close-popup">&times;</a>
        <form method="POST" action="javascript:void(0);">
            @csrf
            <div class="popup-already-account-txt">
                <div class="popup-already-account-header">
                    <h2>Sign In</h2>
                </div>

                <span id="SchooRESpan" class="logErrClass"></span>

                <div class="popup-account-info">
                    <div class="account-info-txt">
                        <div class="row">
                            <div class="col-lg-12">
                                <h3>Account info</h3>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group required">
                                    <label>Email Address</label>
                                    <input type="email" class="form-control" name="email" id="logEmail">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group required">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" id="logPass">
                                </div>
                            </div>
                            <a href="{{ url('/forgetpassword') }}">Forgot Your Password?</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="blue-bg-btn"><a href="javascript:void(0)" id="priceBkPOP"
                    class="btn btnn-effect signAnch">Sign up</a><button class="btn btnn-effect"
                    style="background: #5AB9E3!important;color:#fff;" type="submit" id="logSubmitForm">Login</button>
            </div>
        </form>
    </div>
</section>

<section class="popup-already-account popup-account accountPOPUP" style="display: none;">
    <div class="popup-table">
        <a href="javascript:void(0)" class="close-popup">&times;</a>
        <form method="POST" action="{{ url('/register/account') }}" role="form" class="require-validation" enctype="multipart/form-data"
            data-cc-on-file="false" data-stripe-publishable-key="{{ config('app.STRIPE_KEY') }}" id="payment-form">
            @csrf
            <div class="popup-already-account-txt">
                <div class='form-row row'>
                    <div class='col-md-12 error form-group' id="disErr" style="text-align:center;display: none;">
                        <div class='alert-danger alert'></div>
                    </div>
                    <span class="errorMSG"
                        style="color:red;font-size: 15px;font-family: 'Montserrat';padding-left: 43%;"></span>
                    <span class="reglogErrClass"
                        style="color:red;font-size: 15px;font-family: 'Montserrat';padding-left: 43%;"></span>
                </div>
                <div class="popup-account-info">
                    <div class="account-info-txt">
                        <div class="row">
                            <div class="col-lg-12">
                                <h3>Account info</h3>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group required">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" name="name" id="regname">
                                    <span class="errorClasss" id="regnameErr"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group required">
                                    <label>Email Address</label>
                                    <input type="email" class="form-control" name="email" id="regemail">
                                    <span class="errorClasss" id="regnameMai"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group required">
                                    <label>Password</label>
                                    <div class="input-group" id="show_hide_password">
                                        <input class="form-control" type="password" name="password" id="regpass">
                                        <div class="input-group-addon">
                                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <span class="errorClasss" id="regnamePass"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group required">
                                    <label>Confirm Password</label>
                                    <div class="input-group" id="show_hide_password">
                                        <input class="form-control" type="password" name="password_confirmation"
                                            id="redcpass">
                                        <div class="input-group-addon">
                                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <span class="errorClasss" id="regnameCpass"></span>
                                </div>
                            </div>
                            <input type="hidden" name="userTypeRadio" value="1">
                            <div class="col-lg-12">
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <h3>Addtional Info</h3>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Address 1</label>
                                    <input type="text" class="form-control" name="address1">
                                    <!-- <span id="errorMSG1"></span> -->
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Address 2</label>
                                    <input type="text" class="form-control" name="address2">
                                    <span id="errorMSG1"></span>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" value="United states" name="country">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>State</label>
                                    <input type="text" class="form-control" name="state">
                                    <span id="errorMSG1"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" class="form-control" name="city" >
                                    <span id="errorMSG1"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Zipcode</label>
                                    <input type="text" class="form-control" name="zipcode" >
                                    <span class="errorMSG text-danger"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Alternate Contact Number</label>
                                    <input type="text" class="form-control" id="altphone" name="contact">
                                    <span class="errorMSG text-danger"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="userImage" class="form-label">
                                                User Profile : </label>
                                            <br>
                                            <input class="form-control p-1" type="file" id="userImage" name="userImage">
                                        </div>
                                        <div class="col-lg-6">
                                            <img src='{{ asset('images/user_sample.png') }}' alt='{{ asset('images/user_sample.png') }}' height="100" width="100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- company fields -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Company Name</label>
                                    <input type="text" class="form-control" name="company_name">
                                    <span id="errorMSG1 text-danger"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="companyLogo" class="form-label">
                                                Company Logo : </label>
                                            <br>
                                            <input class="form-control p-1" type="file" id="companyLogo" name="companyLogo">
                                        </div>
                                        <div class="col-lg-6">
                                            <img src='{{ asset('images/user_sample.png') }}' alt='{{ asset('images/user_sample.png') }}' height="100" width="100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Company Mobile :</label>
                                    <input type="text" class="form-control nuFldEnaClas" id="companyphone" name="company_phone_no">
                                    <span class="errorMSG text-danger"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Website URL :</label>
                                    <input type="text" class="form-control" name="website_url">
                                    <span class="errorMSG text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row loader-sec" id="loader-sec">
                            <div class="col-lg-12">
                                <h3>Payment info</h3>
                            </div>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-7">
                                        <div class="form-group required">
                                            <label>Name on Card</label>
                                            <input class='form-control nuFldEnaClasAlpha' size='4' type='text'
                                                id="regccname">
                                            <span class="errorClasss" id="regnameCarNam"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="form-group required">
                                            <label>Card Number</label>
                                            <input autocomplete='off' id="regCradname"
                                                class='form-control card-number nuFldEnaClas' size='20' maxLength="16"
                                                type='text'>
                                            <span class="errorClasss" id="regnameCarNum"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 exp-month ml-0 mr-0">
                                        <div class="form-group required">
                                            <label>Exp. Month</label>
                                            <input class='form-control card-expiry-month nuFldEnaClas' maxLength="2"
                                                size='2' type='text' id="regCradMn">
                                            <span class="errorClasss" id="regnameMon"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group required">
                                            <label>Year</label>
                                            <input class='form-control card-expiry-year nuFldEnaClas' maxLength="4"
                                                size='4' type='text' id="regCradYr">
                                            <span class="errorClasss" id="regnameYea"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group required">
                                            <label>CVV</label>
                                            <input autocomplete='off' class='form-control card-cvc nuFldEnaClas'
                                                maxLength="3" size='3' type='text' id="regCradCv">
                                            <span class="errorClasss" id="regnameCvv"></span>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-4">
                                            <div class="form-group required">
                                                <label>Coupon Code <small>(Optional)</small> </label>
                                                <input autocomplete='off' class='form-control coupon' type='text' id="regCoupon" name="coupon_code">
                                                <span class="errorClasss" id=""></span>
                                            </div>
                                        </div> --}}
                                </div>
                                <input class='form-control coupon' type='hidden' name="coupon_code">
                                <div class="coupon-code-question">
                                    <a href="javascript:void(0)" class="coupon-code-link">Have a coupon?</a>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="package-select" id="package-selectID"></div>
                            </div>
                        </div>
                        <input type="hidden" class="price-value" name="priceIDVal" id="priceIDVal">
                    </div>
                    <div class="cf">
                        <div class="three col">
                            <div class="loader" id="loader-1"></div>
                        </div>
                    </div>
                    <div class="form-check accept by-signing">
                        <label class="form-check-label" for="check2">
                            <input type="checkbox" class="form-check-input" id="check2" name="option2"
                                value="termcheck" required="required"> I Accept Terms and conditions
                        </label>
                    </div>
                </div>
                <span class="errorClasss" id="stPEss"></span>
            </div>
            <div class="blue-bg-btn">
                <a class="btn btnn-effect" href="javascript:void(0)" id="bkBTNPOP">Back</a>
                <button class="btn btnn-effect" style="background: #5AB9E3!important;color:#fff;" id="regSubForm"
                    type="submit">Submit</button>
            </div>
        </form>
    </div>
</section>

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
