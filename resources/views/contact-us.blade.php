@include('includes.header')

	  <main id="main">

        <!--Section-Contact-->

        <section class="contact-form">
            <div class="container">
                <div class="heading-section">
                {{ Breadcrumbs::render('contact-us') }}
                    <h2>Contact Us</h2>
                </div>
                <div class="contact-us-box">
                    <div class="row align-items-center">
                        <div class="col-lg-7">                            
                            <form method="POST" action="#">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Full Name</label>
                                            <input type="text" class="form-control" autocomplete="off" placeholder="" name="name" id="nameE">
                                            <span id="span1" class="errSpanClass"></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Email Address</label>
                                            <input type="email" class="form-control" autocomplete="off" placeholder="" name="email" id="emailL">
                                            <span id="span2" class="errSpanClass"></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input type="text" class="form-control nuFldEnaClas" maxLength="10" autocomplete="off" placeholder="" name="mobile">
                                            <span id="span3" class="errSpanClass"></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Type of Inquiry</label>
                                            <select class="form-control arro" id="inquiry" name="inquiry">
                                                <option value="" selected> select </option> 
                                                @if(!$data->isEmpty())
                                                    @foreach($data as $key => $value)
                                                        <option value="{{$value->title}}">{{$value->title}}</option>
                                                    @endforeach
                                                @endif 
                                            </select>
                                            <span id="span4" class="errSpanClass"></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Message</label>
                                            <textarea class="form-control" rows="10" cols="50" name="description" id="description" placeholder=""></textarea>
                                            <span id="span5" class="errSpanClass"></span>
                                        </div>
                                    </div>


                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-effect" id="contactSubmit">Submit</button>
                                    </div>
                                </div>
                            </form> 
                            <span id="spann" class="errClass"></span>
                        </div>
                        <div class="col-lg-5">
                            <figure data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="2000">
                                <img src="images/contact.png" alt="img">
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!--Section-contact-End-->




    </main>
	
@include('includes.footer')