@include('includes.header')

	 <main id="main">
        <section class="Anderson-Lane px-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="Anderson-Lane-txt">
                            <h2>{{ $data[0] }}<small><a href="#" style="margin-left: 12px;">View on map</a>  </small></h2>
                        </div>
                    </div>
                    <!-- <div class="col-lg-5">
                        <div class="Anderson-Lane-icn">
                            <ul>
                                <li>
                                    <a href="#"><i class="fa fa-download"></i>Download pdf</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-print"></i> </a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-link"></i>Share</a>
                                </li>
                            </ul>
                        </div>
                    </div>   -->
                </div>

            </div>
        </section>

        <!--Section-3 Anderson Lane, Robbinsville, NJ 08691-END-->


        <!--Section-table-open-permits1-->
        <section class="table table-open-permits1 px-5">
            <div class="container-fluid">
                <div class="table100-nextcols table-responsive">
                        @if(array_key_exists('issued',$data))
                            <p>OPEN PERMITS (<?php count($data['issued']); ?>)</p>
                            <table>
                                <thead>
                                    <tr class="row100 head">
                                        <th class="cell100 column1"></th>
                                        <!-- <th class="cell100 column2">Control #</th> -->
                                        <th class="cell100 column3">Permit #</th>
                                        <th class="cell100 column4">Issue Date</th>
                                        <th class="cell100 column5">Work Type</th>
                                        <th class="cell100 column6">Work Description</th>
                                        <th class="cell100 column7">Subcodes</th>
                                        <th class="cell100 column8">Permit Status</th>
                                        <th class="cell100 column9">Permit Status Date</th>
                                        <th class="cell100 column10">Certificates</th>
                                        <th class="cell100 column11">Permit Fee</th>
                                        <th class="cell100 column12">Agent</th>
                                    </tr>
                                </thead>
                                <tbody>                           
                                    @if(!empty($data['issued']))
                                        @foreach($data['issued'] as $key => $value)
                                            <tr class="row100 body">
                                                <td class="cell100 column1"></td>
                                                <!-- <td class="cell100 column2">36940</td> -->
                                                <td class="cell100 column3">{{$value->PermitNumber}}</td>
                                                <td class="cell100 column4">{{$value->PermitStatusDate}}</td>
                                                <td class="cell100 column5">{{$value->PermitType}}</td>
                                                <td class="cell100 column6">{{$value->PermitDescription}}</td>
                                                <td class="cell100 column7">{{$value->PropertyQuadrant}}</td>
                                                <td class="cell100 column8">{{$value->PermitStatus}}</td>
                                                <td class="cell100 column9">{{$value->PermitEffectiveDate}}</td>
                                                <td class="cell100 column10">N/A</td>
                                                <td class="cell100 column11">${{$value->PermitFee}}</td>
                                                <td class="cell100 column12"></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        @endif
                </div>
            </div>

        </section>

        <!--Section-table-open-permits1-End-->


        <!--Section-table-open-permits6-->
        <section class="table table-open-permits6 px-5">
            <div class="container-fluid">
                <div class="table100-nextcols table-responsive">                   
                        @if(array_key_exists('complete',$data))
                            <p>CLOSED PERMITS (<?php count($data['complete']); ?>)</p>
                            <table>
                                <thead>
                                    <tr class="row100 head">
                                        <th class="cell100 column1"></th>
                                        <!-- <th class="cell100 column2">Control #</th> -->
                                        <th class="cell100 column3">Permit #</th>
                                        <th class="cell100 column4">Issue Date</th>
                                        <th class="cell100 column5">Work Type</th>
                                        <th class="cell100 column6">Work Description</th>
                                        <th class="cell100 column7">Subcodes</th>
                                        <th class="cell100 column8">Permit Status</th>
                                        <th class="cell100 column9">Permit Status date</th>
                                        <th class="cell100 column10">Certificates</th>
                                        <th class="cell100 column11">Permit Fee</th>
                                        <th class="cell100 column12">Agent</th>
                                    </tr>
                                </thead>
                                <tbody>                           
                                    @if(!empty($data['complete']))
                                        @foreach($data['complete'] as $key => $value)
                                            <tr class="row100 body">
                                                <td class="cell100 column1"></td>
                                                <!-- <td class="cell100 column2">36940</td> -->
                                                <td class="cell100 column3">{{$value->PermitNumber}}</td>
                                                <td class="cell100 column4">{{$value->PermitStatusDate}}</td>
                                                <td class="cell100 column5">{{$value->PermitType}}</td>
                                                <td class="cell100 column6">{{$value->PermitDescription}}</td>
                                                <td class="cell100 column7">{{$value->PropertyQuadrant}}</td>
                                                <td class="cell100 column8">{{$value->PermitStatus}}</td>
                                                <td class="cell100 column9">{{$value->PermitEffectiveDate}}</td>
                                                <td class="cell100 column10">N/A</td>
                                                <td class="cell100 column11">${{$value->PermitFee}}</td>
                                                <td class="cell100 column12"></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        @endif
                </div>
            </div>

        </section>

        <!--Section-table-open-permits6-End-->

        <!--Section-table-open-INSPECTIONS (2)-->
       <!--  <section class="table table-open-permits6 px-5">
            <div class="container-fluid">
                <div class="table100-nextcols table-responsive">                    
                        @if(array_key_exists('Inspection',$data))
                            <p>INSPECTIONS (<?php count($data['Inspection']); ?>)</p>
                            <table>
                                <thead>
                                    <tr class="row100 head">
                                        <th class="cell100 column1"></th>
                                        <th class="cell100 column2">Inspection Date</th>
                                        <th class="cell100 column3">Permit #</th>
                                        <th class="cell100 column4">Subcode</th>
                                        <th class="cell100 column5">Type</th>
                                        <th class="cell100 column6">Inspector</th>
                                        <th class="cell100 column7">Result</th>
                                        <th class="cell100 column8">TA Notes</th>
                                        <th class="cell100 column9">Findings</th>
                                        <th class="cell100 column10"></th>
                                        <th class="cell100 column11"></th>
                                        <th class="cell100 column12"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($data['Inspection']))
                                        @foreach($data['Inspection'] as $key => $value)
                                            <tr class="row100 body">
                                                <td class="cell100 column1"></td>
                                                <td class="cell100 column2">{{$value->PermitNumber}}</td>
                                                <td class="cell100 column3"></td>
                                                <td class="cell100 column4">{{$value->PermitType}}</td>
                                                <td class="cell100 column5"></td>
                                                <td class="cell100 column6"></td>
                                                <td class="cell100 column7"></td>
                                                <td class="cell100 column8">N/A</td>
                                                <td class="cell100 column9">N/A</td>
                                                <td class="cell100 column10"></td>
                                                <td class="cell100 column11"></td>
                                                <td class="cell100 column12"></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        @endif
                </div>
            </div>
        </section> -->
        <!--Section-table-open-INSPECTIONS (2)-End-->

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
                    var token = response['id'];
                    var coupon_code = $('.coupon').val();
                    if(coupon_code) {
                        $.ajax({
                            type : "POST",
                            url  : "{{url('validate-coupon')}}",
                            data : {coupon : coupon_code, "_token": "{{ csrf_token() }}"},
                            success: function(resp) {
                                if(resp.status && resp.status == 'false') {
                                    //$('.error').css('display','block').find('.alert').text(resp.message);
                                    $('#stPEss').text(resp.message).show().delay(4000).fadeOut("slow");
                                    return false;
                                }else {
                                    $('.coupon-error').css('display','none');
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