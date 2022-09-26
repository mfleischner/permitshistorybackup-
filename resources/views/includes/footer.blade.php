    <section class="popup-sec">
        <!--<a href="#" class="btnn">button for animated popup window</a> -->
        <div class="popup popup-loginn @if (\Session::has('loginPOPUP')) is-active @endif">
            <div class="popup__close">
                <figure><img src="{{ asset('images/x.png') }}" alt="close" /></figure>
            </div>
            <div class="popup-i">
                <h2>Login</h2>
                @if (\Session::has('loginPOPUP'))
                    <p style="color:red;">Please Login/Signup to continue.</p>
                @endif
                <div class="login">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="email">{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') @if ($message != "We can't find a user with that email address.") is-invalid @endif @enderror" name="email" @error('email')  @if ($message != "We can't find a user with that email address.") value="{{ old('email') }}" @endif @enderror  autocomplete="
                                        email" autofocus>

                                    <span id="LoginErrEm"></span>
                                    @error('email')
                                        @if ($message != " We can't find a user with that email
                                            address.")
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @endif
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Password</label>
                                    <!--  <input type="password" class="form-control" placeholder="Password">  -->

                                    <div class="input-group" id="show_hide_password">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            autocomplete="current-password">
                                        <div class="input-group-addon">
                                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                        </div>

                                        <span id="LoginErrPa"></span>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <cite>
                                            <div class="btn-forgot"> <a
                                                    href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                                            </div>
                                        </cite>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-12">
                                <button type="submit" id="loginFormVal" class="btn btn-effect">Login</button>
                            </div>
                        </div>
                        <div class="or">or</div>
                        <div class="signin-social-media"><a class="btn"
                                href="{{ url('auth/facebook') }}"><i class="fa fa-facebook"></i> Sign in with
                                Facebook</a>
                            <a class="btn" href="{{ url('auth/google') }}"><i class="fa fa-google"></i>
                                Sign in with Google</a>
                        </div>
                        <p>New here? <a class="open-signup" href="javascript:void(0)">Sign up</a></p>

                    </form>
                </div>
            </div>
        </div>
    </section>

    <!--Section-popup-recover-->
    <section class="popup-sec popup-recover @if (\Session::get('forgetPass') == 'yes') is-active @endif">

        <!--<a href="#" class="btnn">button for animated popup window</a> -->
        <div class="popup-recover @if (\Session::get('forgetPass') == 'yes') is-active @endif">
            <div class="popup__close">
                <figure>&times;</figure>
            </div>
            <div class="popup-i">
                <h2>Can't log in?</h2>
                <div class="login">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="email">{{ __("We'll send a recovery link to") }}</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email')  @if ($message != 'These credentials do not match our records.') is-invalid @endif @enderror" name="email" @error('email')  @if ($message != 'These credentials do not match our records.') value="{{ old('email') }}" @endif @enderror required autocomplete="
                                        email" autofocus>

                                    @error('email')
                                        @if ($message != 'These credentials do not match our records.')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @endif
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <button type="submit"
                                    class="btn btn-effect">{{ __('Send Password Reset Link') }}</button>
                            </div>
                        </div>
                        <p><a class="back-login" href="#">Return to Log in</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!--Section-popup-signup-->
    <section class="popup-sec popup-signup">

        <!--<a href="#" class="btnn">button for animated popup window</a> -->
        <div class="popup-sign-up">
            <div class="popup__close">
                <figure><img src="{{ asset('images/x.png') }}" alt="close" /></figure>
            </div>
            <div class="popup-i">
                <h2>Sign Up</h2>
                <div class="login">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>{{ __('First Name') }}</label>
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>{{ __('Last Name') }}</label>
                                    <input id="name" type="text"
                                        class="form-control @error('lname') is-invalid @enderror" name="lname"
                                        value="{{ old('lname') }}" required autocomplete="lname" autofocus>

                                    @error('lname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email')  @if ($message != 'These credentials do not match our records.') is-invalid @endif @enderror" name="email" @error('email')  @if ($message != 'These credentials do not match our records.') value="{{ old('email') }}" @endif @enderror required autocomplete="
                                        email">

                                    @error('email')
                                        @if ($message == 'These credentials do not match our records.')
                                        @else
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @endif
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>{{ __('Password') }}</label>
                                    <!--  <input type="password" class="form-control" placeholder="Password">  -->

                                    <div class="input-group" id="show_hide_password">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password">
                                        <div class="input-group-addon">
                                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                        </div>

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>{{ __('Confirm Password') }}</label>
                                    <!--  <input type="password" class="form-control" placeholder="Password">  -->

                                    <div class="input-group" id="show_hide_password">
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password">
                                        <div class="input-group-addon">
                                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                        </div>

                                    </div>
                                    <input type="hidden" name="userTypeRadio" value="0">
                                    <div class="form-check accept">
                                        <label class="form-check-label" for="check2">
                                            <input type="checkbox" class="form-check-input" id="check2" name="option2"
                                                value="something" required>By signing up, I accept the <a
                                                href="{{ url('/terms-and-conditions') }}">Terms &
                                                Privacy policies</a>
                                        </label>
                                    </div>
                                </div>
                            </div>



                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-effect">{{ __('Sign Up') }}</button>
                            </div>
                        </div>

                        <p>Already registered? <a class="back-login" href="javascript:void(0)">Log in</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--Section-popup-End-->

    <!-- Old Footer start -->
    <!-- <footer id="footer">

        <div class="container">
            <div class="copy-right">
                Copyright 2021
            </div>
            <div class="bottom-menu">
                <ul>
                    <li><a href="{{ url('/tems-and-conditions') }}">Terms & Conditions</a> </li>
                    <li><a href="{{ url('/privacy-policy') }}">Privacy Policy</a> </li>
                    <li><a href="{{ url('/contact-us') }}">Contact Us</a> </li>
                </ul>
            </div>
        </div>
        <div class="disclaimer-text">
            Disclaimer: We can not guarantee that all permits are shown for every property.
        </div>

    </footer>
-->

    <!-- Old Footer ends -->

    <footer class="new-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="disclaimer-text">
                        Disclaimer: We can not guarantee that all permits are shown for every property.
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="bottom-menu">
                        <ul>
                            <li><a href="{{ url('/terms-and-conditions') }}">Terms</a> </li>
                            <li><a href="{{ url('/privacy-policy') }}">Privacy Policy</a> </li>
                            <li><a href="{{ url('/contact-us') }}">Contact</a> </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </footer>
    <!--Section-table-popup-->

    <!-- RESULT NOT FOUND POPUP -->
    <section class="popup-already-account permit-popup errorPOP" style="display: none;">
        <div class="popup-table">
            <div class="popup-permit-txt">
                <div class="permit-txt">
                    <a href="#" class="close-popup-no-address-popup" id="popupCloseNoAddress">&times;</a>
                </div>
                <h5>Permit Information for <b><span id="searchRes"> </span></b></h5>
                <p>The address you searched for is not in our database, this is due to one of the following:</p>
                <ul>
                    <li>The data is not available in digital format.</li>
                    <li>The city has not released permit data for this address.</li>
                    <li>The city does not license permit data.</li>
                </ul>
                <br>
                <h5>We can still obtain permit history</h5>
                <p>Permit history can still be obtained through an <a href="#">OPRA</a> request which is a manual
                    process that uses the freedom of information act. Permitsearch.com can complete this process for
                    you. Would you like to continue?</p>
                <!-- <div style="width: 0px;" class="blue-bg-btn" id="contAddress"><a class="btn btnn-effect" href="#">CANCEL</a></div> -->
                <div class="blue-bg-btn" style="width: 0px;" id="cnctUpPop"><a class="btn btnn-effect btn_admin_notify"
                        href="#" notify="fail">Continue</a></div>
            </div>
        </div>
    </section>

    <section class="popup-already-account permit-popup " id="contAddressPOP">
        <div class="popup-table active-popup">
            <div class="popup-permit-txt address-req-form">
                <div class="permit-txt ">
                    <a href="#" class="close-popup" id="popupClosew">&times;</a>
                </div>
                <h4 class="col-lg-12 text-center">Permit Request Form</h4>
                <form method="POST" action="#" id="addressRequestForm">
                    <div class="row">
                        <small class="col-lg-4 form-arrow">
                            Step 1: Complete Form
                        </small>
                        <small class="col-lg-4 form-arrow">
                            Step 2: Pay for Service
                        </small>
                        <small class="col-lg-4">
                            Step 3: Receive Permit Data
                        </small>
                        <div class="col-lg-12 text-center border-top mt-2">
                            <h7><b>Basic Details </b></h7>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>First Name :<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" autocomplete="off" placeholder=" "
                                    name="first_name" id="first_name" required>
                                <span id="span_first_name" class="errSpanClass text-left"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Last Name :<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" autocomplete="off" placeholder=" "
                                    name="last_name" id="last_name" required>
                                <span id="span_last_name" class="errSpanClass text-left"></span>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Email Address :<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" autocomplete="off" placeholder=" "
                                    name="email_address" id="email_address" required>
                                <span id="span_email_address" class="errSpanClass text-left"></span>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Phone Number :</label>
                                <input type="number" class="form-control nuFldEnaClas" autocomplete="off"
                                    placeholder=" " name="contact_no">
                                <span id="span_contact_no" class="errSpanClass text-left"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Street Address :<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" autocomplete="off"
                                    placeholder="123 Main Street" name="property_street_name" id="property_street_name"
                                    required>
                                <!-- <small class="float-left"> Note : Only House no & Main street</small><br/> -->
                                <span id="span_property_street_name" class="errSpanClass text-left"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>City :<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" autocomplete="off" placeholder=" "
                                    name="property_city" id="property_city" required>
                                <span id="span_property_city" class="errSpanClass text-left"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>State <span class="text-danger">*</span></label>
                                @if (isset($states))
                                    <select class="form-control form-select arro" id="property_state"
                                        name="property_state" id="property_state" required>
                                        <option value=""> Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->code ?? '-' }}">{{ $state->name ?? '-' }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                                <span id="span_property_state" class="errSpanClass text-left"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Zip Code :<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" autocomplete="off" placeholder=" "
                                    name="zip_code" id="zip_code" required>
                                <span id="span_property_zip_code" class="errSpanClass text-left"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Plan to Sell/Purchase in :<span class="text-danger">*</span></label>
                                <select class="form-control form-select arro" id="purchase_with_in"
                                    name="purchase_with_in" required>
                                    <option value=""> Select </option>
                                    <option value="0 - 3 months">0 - 3 months</option>
                                    <option value="4 - 6 months">4 - 6 months</option>
                                    <option value="6+ months">6+ months</option>
                                </select>
                                <span id="span_purchase_with_in" class="errSpanClass text-left"></span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label>Additional Comment's :</label>
                                <textarea class="form-control" rows="2" name="description" id="description"
                                    placeholder=""></textarea>
                                <span class="errSpanClass text-left"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label> &nbsp;</label>
                            <button type="button" class="btn btn-effect" id="submitAddressRequest">Submit</button>
                        </div>
                    </div>
                </form>
                <span id="spann" class="errClass"></span>
            </div>
        </div>
    </section>
    @if (\Session::get('usePermit') == 0 && \Session::get('viewReportPopUp') != 'yes')
        <section class="popup-already-account view-report-popup top-popup-background display-no-credits-popup hide">
            <div class="popup-table">
                <div class="popup-view-report-txt">
                    <div class="view-report-txt">
                        <h2 style="text-align: center;">Alert!</h2>
                    </div>
                    <p>You do not have enough credits to view this report. Please <a
                            href="{{ url('/pricing') }}"><b>click here</b></a> to purchase additional credits.</p>
                </div>
            </div>
        </section>
    @else
        @if (\Session::get('viewReportPopUp') == 'yes')
        @else
            <section
                class="popup-already-account view-report-popup top-popup-background display-yes-credits-popup display-yes-credits-popup {{ \Session::get('PermitRequestData') != null ? 'show' : 'hide' }}">
                <div class="popup-table">
                    <div class="popup-view-report-txt">
                        <div class="view-report-txt text-center">
                            <strong>Permit Search</strong>
                        </div>
                        <p>Viewing this report will remove 1 credit from your account. You currently have
                            <b>{{ \Session::get('usePermit') }}</b> @if (\Session::get('usePermit') > 1) credits @else credit @endif remaining.
                            After unlocking the report, you can download, print, and email for up to 12 months.
                        </p>
                    </div>
                    <div class="blue-bg-btn bg-white">
                        <a class="btn btn-effect" href="{{ url('/') }}">Cancel</a>
                        <a class="btn btn-effect" id="conTVieTabPermitRequest" href="#">Continue</a>
                    </div>
                </div>
            </section>
        @endif
    @endif

    <!--Section-table-popup-End-->
    <script src="{{ asset('/js/bundle.min.js') }}"></script>
    <script src="{{ asset('/js/permitsearch.js') }}"></script>
    <script src="{{ asset('/js/customDev.js') }}"></script>
    <script src="{{ asset('/js/jquery.mark.min.js') }}"></script>
    <script src="{{ asset('/js/customMark.js') }}"></script>
    <script src="{{ asset('/js/jquery.validate.js') }}"></script>

    <script>
        var pricing_page_flag = @if (Request::segment(1) == 'pricing' || Request::segment(1) == 'pro') true @else false @endif;
        var is_search_result_page = @if (Request::segment(1) == 'search-result') true @else false @endif;
        $(function() {
            /** coupon code popup **/
            $('body').on('click', '.apply-code-btn', function() {
                var coupon_code = $('#coupon_code').val();
                var SBID = $('.price-value').val();
                if (coupon_code) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('validate-coupon') }}",
                        data: {
                            coupon: coupon_code,
                            'SBID': SBID,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(resp) {
                            if (resp.status && resp.status == 'false') {
                                $('#coupon-code-error').css('display', 'block').find('.alert')
                                    .text(resp.message);
                                $('#coupon-code-error').show().delay(4000).fadeOut('slow');
                                return false;
                            } else {
                                $('#coupon-code-error').css('display', 'block').find('.alert')
                                    .removeClass('alert-danger').addClass('alert-success').text(
                                        coupon_code + ' : Coupon code applied successfully!');
                                //$('#coupon-code-error').css('display','none');
                                $('.coupon-code-question').css('color', 'green').text(
                                    coupon_code + ' : Coupon code applied successfully!');
                                $('.coupon').val(coupon_code);
                                $('.apply-couponcode-popup').css('display', 'none');
                                $('.show-price').html('<s>$' + resp.original_price +
                                    '</s>  <b>$' + resp.updated_price + '</b>');
                            }
                        }
                    });
                } else {
                    $('#coupon-code-error').css('display', 'block').find('.alert').text(
                        'Please enter Coupon Code!');
                    $('#coupon-code-error').show().delay(4000).fadeOut('slow');
                }
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>

    <!-- jQuery first, then Bootstrap JS. -->

    </body>

    </html>
