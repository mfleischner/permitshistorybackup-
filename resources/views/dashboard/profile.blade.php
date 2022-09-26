@extends('layouts.app')
@section('content')
    <main id="main">
        <section class="Anderson-Lane px-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="Anderson-Lane-txt">
                            <h2>My Profile</h2>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <span id="successStatusMsg" style="text-align: center;">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif 

            @if (isset($status) && $status!= null)
                <div class="text-danger">
                    {{$status??''}}
                </div>
            @endif

            @if (Session::has('fail'))
                <div class="alert alert-danger">
                    {!! Session::get('fail')->first('name', '<div class="error-block">:message</div>') !!}
                    {!! Session::get('fail')->first('phone', '<div class="error-block">:message</div>') !!}
                    {!! Session::get('fail')->first('oldpass', '<div class="error-block">:message</div>') !!}
                    {!! Session::get('fail')->first('newpass', '<div class="error-block">:message</div>') !!}
                    {!! Session::get('fail')->first('cnewpass', '<div class="error-block">:message</div>') !!}
                </div>
            @endif

            @if (Session::has('faill'))
                <div class="alert alert-danger">
                    {{ Session::get('faill') }}
                </div>
            @endif
        </span>

        <section class="table table-open-permits6 px-5">
            <form action="{{ url('/dashboard/account') }}" method="POST" enctype='multipart/form-data'>
                @csrf
                <div class="container-fluid">
                    <h3>Account Info</h3>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $data[0]->name }}">
                                <span id="errorMSG1 text-danger"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" value="{{ $data[0]->email }}"
                                    disabled="disabled">
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="form-group">    
                                <label>Phone Number</label>
                                <input type="text" id="phone" class="form-control nuFldEnaClas" name="phone" 
                                    value="{{ $data[0]->phone }}">
                                <span class="errorMSG text-danger"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="user_role_type" value="<?php echo $data[0]->user_role_type ?>" />
                @if (isset($data[0]->user_role_type) && $data[0]->user_role_type == 1)
                    <div class="container-fluid">
                        <h3>Addtional Info</h3>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Address 1</label>
                                    <input type="text" class="form-control" name="address1"
                                        value="{{ $data[0]->address1 }}">
                                    <!-- <span id="errorMSG1"></span> -->
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Address 2</label>
                                    <input type="text" class="form-control" name="address2"
                                        value="{{ $data[0]->address2 }}">
                                    <span id="errorMSG1"></span>
                                </div>
                            </div>
                                    <input type="hidden" class="form-control" value="United states" name="country">
                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label>State</label>
                                    <input type="text" class="form-control" name="state" value="{{ $data[0]->state }}">
                                    <span id="errorMSG1"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" class="form-control" name="city" value="{{ $data[0]->city }}">
                                    <span id="errorMSG1"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Zipcode</label>
                                    <input type="text" class="form-control" name="zipcode" value="{{ $data[0]->zipcode }}">
                                    <span class="errorMSG text-danger"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Alternate Contact Number</label>
                                    <input type="text" class="form-control" id="altphone" name="contact"
                                        value="{{ $data[0]->contact }}">
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
                                               @if(isset($data[0]->user_image) && !empty($data[0]->user_image))
                                            <img src="{{ asset('storage/images/users/'.$data[0]->user_image) }}" alt="{{ asset('storage/images/users/'.$data[0]->user_image) }}" class="p-2 border" width="80%">
                                        @else
                                            <img src='{{ asset('images/user_sample.png') }}' alt='{{ asset('images/user_sample.png') }}' height="100" width="100">
                                        @endif
                                         </div>                                         
                                      
                                    </div>
                                </div>
                            </div>
                            <!-- company fields -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Company Name</label>
                                    <input type="text" class="form-control" name="company_name"
                                        value="{{ $data[0]->company_name }}">
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
                                               @if(isset($data[0]->company_logo) && !empty($data[0]->company_logo))
                                            <img src="{{ asset('storage/images/users/'.$data[0]->company_logo) }}" alt="{{ asset('storage/images/users/'.$data[0]->company_logo) }}" class="p-2 border" width="80%">
                                        @else
                                            <img src='{{ asset('images/user_sample.png') }}' alt='{{ asset('images/user_sample.png') }}' height="100" width="100">
                                        @endif
                                         </div>                                         
                                      
                                    </div>
                                </div>
                            
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Company Mobile :</label>
                                    <input type="text" class="form-control nuFldEnaClas" id="companyphone" name="company_phone_no"
                                        value="{{ $data[0]->company_phone_no }}">
                                    <span class="errorMSG text-danger"></span>
                                </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Website URL :</label>
                                        <input type="text" class="form-control" name="website_url"
                                            value="{{ $data[0]->website_url }}">
                                        <span class="errorMSG text-danger"></span>
                                    </div>
                                </div>
                             
                               

                        </div>
                    </div>
                @endif

                <div class="col-lg-6">
                    <div class="form-group">
                        <div class="blue-bg-btn"><button class="btn btnn-effect"
                                style="background: #5AB9E3!important;color:#fff;" id="saveActInfo" type="submit">Save
                                Info</button></div>
                    </div>
                    <span id="span"></span>
                </div>

            </form>

            <!--  <div class="container-fluid">
                        <h3>Change Password</h3>
                        <form action="{{ url('/dashboard/account/update') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Old Password</label>
                                        <input type="password" class="form-control" name="oldpass">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input type="password" class="form-control" name="newpass">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" name="cnewpass">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-effect">Update</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div> -->
        </section>
    </main>

@endsection
