@include('includes.header')
	
	<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <main id="main">
        <section class="pricing">
            <div class="container">
                <div class="heading-section">
                    <h2>Payment Form</h2>
                </div>

                <div class="col-lg-12">
                	<p><b>Total Price : </b><span class="show-price">${{$data[0]->price}}</span></p>
                	<form 
                    role="form" 
                    action="{{ url('/pay/payment') }}" 
                    method="post" 
                    class="require-validation"
                    data-cc-on-file="false"
                    data-stripe-publishable-key="{{ config('app.STRIPE_KEY')}}"

                    id="payment-form">
                    @csrf

                    <input type="hidden" name="SBID" class="price-value" value="{{Crypt::encrypt($data[0]->id)}}" id="SBID">
                	<div class='form-row row'>
	                    <div class='col-md-12 error form-group' style="text-align:center;display: none;">
	                      	<div class='alert-danger alert'>Please correct the errors and try
	                         again.</div>
	                    </div>
	                    <!-- <div class='col-md-12 coupon-error form-group' style="text-align:center;display: none;">
	                      	<div class='alert-danger alert'></div>
	                    </div> -->
	                </div>
                    <div class="form-row row">
                        <div class="form-group col-md-6 required">
                            <label class='control-label'>Name on Card</label> <input
                            class='form-control nuFldEnaClasAlpha' size='4' type='text' placeholder="John Smith">
                        </div>
                        <div class="form-group col-md-6 card required" style="border: 0px solid !important;">
                            <label class='control-label'>Card Number</label> <input
                            autocomplete='off' class='form-control card-number nuFldEnaClas' size='20' maxLength="16"
                            type='text' placeholder="xxxx xxxx xxxx xxxx">
                        </div>
                    </div>
                    <div class="form-row row">                       
                        <div class="form-group col-md-4 expiration required">
                           <label class='control-label'>Expiration Month</label> <input
                            class='form-control card-expiry-month nuFldEnaClas' maxLength="2" placeholder='MM' size='2'
                            type='text'>
                        </div>
                        <div class="form-group col-md-4 expiration required">
                            <label class='control-label'>Expiration Year</label> <input
                            class='form-control card-expiry-year nuFldEnaClas' maxLength="4" placeholder='YYYY' size='4'
                            type='text'>
                            <span class="pay-now-btn-error text-danger"></span>
                        </div>
                        <div class="form-group col-md-4 cvc required">
                            <label class='control-label'>CVV</label> <input autocomplete='off'
                            class='form-control card-cvc nuFldEnaClas' maxLength="3" placeholder='ex. 311' size='3'
                            type='text'>
                        </div>
                        {{-- 
                        <div class="form-group col-md-3 required">
                            <label class='control-label'>Coupon Code <small>(Optional)</small></label> <input autocomplete='off'
                            class='form-control coupon nuFldEnaClasAlpha' placeholder='ex. 50PERFREE'
                            type='text' name="coupon_code">
                        </div>
                        --}}
                            <input class='form-control coupon' type='hidden' name="coupon_code">
                    </div>                    
                    <div class="form-row row">
                    	<div class="col-md-12 coupon-code-question">
                    		 <a href="javascript:void(0)" class="coupon-code-link" ><h7>Have a coupon?</h7></a>
                    	</div>
                    </div>
                    <div class="row">
                       <div class="col-xs-12 blue-bg-btn" style="padding-left: 40%;padding-top: 3%;">
                       		<span class="errorMSG" style="color:red;font-size: 15px;font-family:'sans-serif;';padding-left: 20%;"></span>
                          	<button class="btn btnn-effect pay-now-btn btn-block" style="background-color: #5AB9E3!important;color:#fff" type="submit">Pay Now</button>
                       </div>
                    </div>
                </form>
                </div>
            </div>
        </section>

        <!-- Popup section for apply coupon code -->
        <section class="popup-already-account popup-account apply-couponcode-popup" style="display: none;">
            <div class="popup-table">
                <a href="javascript:void(0)" class="close-popup">&times;</a>
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
                                         <label class='control-label'>Coupon Code</label>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group required">
                                            <input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="Enter coupon code. eg. 50PERFREE">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group required">
						                    <div class=""><button class="btn btnn-effect btn-block apply-code-btn" style="background-color: #5AB9E3!important;color:#fff;" type="button" id="apply_code_btn">Apply</button></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  
	<script type="text/javascript">
		$(function() {		   
		    var $form = $(".require-validation");		   
		    $('.card-expiry-year').bind('keyup', function(e) {
                var month = $('.card-expiry-month').val();
                var currentMonth = new Date().getDate();
                var year = $('.card-expiry-year').val();
                var currentYear = new Date().getFullYear();

                if(year>=currentYear){
                    $('.pay-now-btn-error').html('');
                    $('.pay-now-btn').prop('disabled', false);
                }else{
                    $('.pay-now-btn-error').html('Please enter valid expiry year');
                    $('.pay-now-btn').prop('disabled',true);
                }
            });
            $('form.require-validation').bind('submit', function(e) {
                e.preventDefault();
		        var $form         = $(".require-validation"),
		        inputSelector = ['input[type=email]', 'input[type=password]',
		                         'input[type=text]', 'input[type=file]',
		                         'textarea'].join(', '),
		        $inputs       = $form.find('.required').find(inputSelector),
		        $errorMessage = $form.find('div.error'),
		        valid         = true;
		        $errorMessage.hide();		  
		        $('.has-error').removeClass('has-error');
		        $inputs.each(function(i, el) {
		          var $input = $(el);
		          if ($input.val() === '') {
		            $input.parent().addClass('has-error');
		            $errorMessage.show();
		            e.preventDefault();
		          }
		        });		   
		        if (!$form.data('cc-on-file')) {
		          e.preventDefault();
                  //update with dynamic
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
		            $('.error')
		                .removeClass('hide')
		                .find('.alert')
		                .text(response.error.message);
		        } else {
		            /* token contains id, last4, and card type */
		            var token = response['id'];
		            var coupon_code = $('.coupon').val();
            		// if(coupon_code) {
            		//     $.ajax({
              //               type : "POST",
              //               url  : "{{url('validate-coupon')}}",
              //               data : {coupon : coupon_code, "_token": "{{ csrf_token() }}"},
              //               success: function(resp) {
            		//         	if(resp.status && resp.status == 'false') {
            		//         		$('.error').css('display','block').find('.alert').text(resp.message);
            		//         		return false;
            		//         	}
            		//         	else {
            		//         		$('.coupon-error').css('display','none');
            		//         		/* token contains id, last4, and card type */
            		//         		$form.find('input[type=text]').empty();
            		//         		$form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            		//         		$form.get(0).submit();
            		//         	}
              //               }
              //           });
            		// } else {
			            $form.find('input[type=text]').empty();
			            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
			            $form.get(0).submit();
			        //}
		        }
		    }
		    /** show the popup for enter coupon code **/
		    /*$('body').on('click','.coupon-code-link', function(){ 
		    	$('.apply-couponcode-popup').css('display','block');
		    });*/

		    
		});
	</script>

@include('includes.footer')