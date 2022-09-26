@extends('layouts.app')

@section('content')
	

   <main id="main">
        <!--Section-table-open-my-report-->
        <section class="my-report px-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-7 col-md-6">
                        <div class="my-report-txt">
                            <h2>Change Password</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>

         <!--Section-table-open-address-->
        <section class="table address-collaps px-5">
            <div class="container-fluid">
                <div class="panel panel-default">
                    <div class="panel-body">
                		<div class="col-lg-12">
	                    	<div class="row">
	                			<div class="col-lg-4">
	                				<label>Old Password</label>
	                				<input type="password" name="old_pass" class="form-control">
	                				<span id="cgpErr0"></span>
	                			</div>
	                			<div class="col-lg-4">
	                				<label>New Password</label>
	                				<input type="password" name="new_pass" class="form-control">
	                				<span id="cgpErr1"></span>
	                			</div>
	                			<div class="col-lg-4">
	                				<label>Confirm Password</label>
	                				<input type="password" name="Cnew_pass" class="form-control">
	                				<span id="cgpErr2"></span>
	                			</div>
	                		</div>
                    	</div>
                    	<div class="col-lg-4">
	                    	<div class="row">
	                    		<input type="submit" name="submit" class="btn btnn-effect" value="Update">
	                    	</div>
	                    </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection