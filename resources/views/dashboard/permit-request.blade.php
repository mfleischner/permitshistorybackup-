@extends('layouts.app')

@section('content')    

   <main id="main">
        <!--Section-table-open-my-report-->
        <section class="my-report px-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-7 col-md-6">
                        <div class="my-report-txt">
                            <h2>Permit Requests</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>

         <!--Section-table-open-address-->
        <section class="table address-collaps mt-0 pt-0 px-5">
            <div class="container-fluid">
                <div class="panel panel-default">

                    <div class="panel-body">
                        <div class="table100-nextcols table-responsive">
                            <!-- <p>PERMITS</p> -->
                            <table class="table text-center table-condensed border" id="accordion">
                                <thead class="bg-light border-bottom text-left">
                                    <tr class="row100 head">
                                        <th class="cell100 column7 text-center pl-2">No</th>
                                        <!-- <th class="cell100 column2">Full Name</th> -->
                                        <!-- <th class="cell100 column3">Phone / Contact</th> -->
                                        <!-- <th class="cell100 column6">Email Addres</th> -->
                                        <th class="cell100 column1">Street Address</th>
                                        <th class="cell100 column8">City</th>
                                        <th class="cell100 column9">State</th>
                                        <th class="cell100 column10">Zip Code</th>
                                        <th class="cell100 column1">Additional Comment's</th> 
                                        <th class="cell100 column4">Planining to purchase</th>
                                        <th class="cell100 column11">Status</th>
                                        <th class="cell100 column12">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white text-left pl-3"> 
                                    @if(isset($report) && count($report)>0)
                                        @foreach($report as $key => $value)
                                            <tr>
                                                <td class="cell100 column7 text-center">{{$key+1}}</td>
                                                <!-- <td class="cell100 column2">{{$value->first_name??''}} {{$value->last_name??''}}</td> -->
                                                <!-- <td class="cell100 column3">{{$value->contact_no??'-'}}</td> -->
                                                <!-- <td class="cell100 column6">{{ $value->email??'-'}}</td> -->
                                                <td class="cell100 column1">{{$value->property_street_name??''}}</td>
                                                <td class="cell100 column8">{{$value->property_city??''}}</td>
                                                <td class="cell100 column9">{{$value->property_state??''}}</td>
                                                <td class="cell100 column10">{{$value->zip_code??''}}</td>
                                                <td class="cell100 column1">{{$value->description??''}}</td>
                                                <td class="cell100 column4"> 
                                                       {{$value->purchase_with_in??''}}
                                                    </td>
                                                <td class="cell100 column11 text-{{$value->status_class??'dark'}}">
                                                    <span class="badge badge-sm p-1 badge-{{$value->status_class??'dark'}} border--{{$value->status_class??'dark'}}">{{$value->status??''}}</span></td>
                                                <td class="cell100 column12">{{ date('m/d/y', strtotime($value->created_at??'-')) }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="cell100 column1 text-center" colspan="12">No Data Found!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @if(isset($_GET['request']) && $_GET['request']=='new')
            <section class="popup-already-account apply-couponcode-popup view-report-popup">
                    <div class="popup-table ">
                        <div class="popup-view-report-txt ">
                            <div class="permit-txt">
                                <a href="{{url('/dashboard/permit-requests')}}" class="close-popup p-2 m-2" id="popupClosee">&times;</a>
                            </div>
                            <div class="view-report-txt">
                                <h5 style="text-align: center;">Thank you for your purchase.</h5>
                            </div>
                            <p>Your Permit Search has begun. A member of our team will email you when permit data is available for the address you provided. You can also check your dashboard for updates.</p>
                            <!-- <a href="{{url('/dashboard/permit-requests')}}" class="float-right m-2 btn-default nav-link"> Confirm </a> -->
                              <div class="blue-bg-btn bg-white">
                            <a class="btn btn-effect" href="{{url('/')}}"></a>
                            <a class="btn btn-effect float-right" href="{{url('/dashboard/permit-requests')}}">Confirm</a> </div>
                        </div>
                        
                    </div>
            </section>
        @endif
    </main>

@endsection