@extends('layouts.app')

@section('content')
    <style>
        /* scrollbar-width: thin; */

    </style>

    <main id="main">
        <span id="errorSpanC" style="text-align: center;">
            @if (\Session::get('fail'))
                <div class="alert alert-success">{{ \Session::get('fail') }}</div>
            @endif
        </span>
        <!--Section-table-open-my-report-->
        <section class="my-report px-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-7 col-md-6">
                        <h2>My Reports</h2>
                    </div>
                    @if(Auth::user()->role_id == 1)
                     <div class="col-lg-5 col-md-6 text-right">
                            <a href="javascript:void(0)" data-url="{{ url('/dashboard/permituploadview') }}" class="submit-printrep btn upload-btn btn-effect" ><i class="fa fa-upload" ></i><span style="margin-left:10px;">Upload </span></a>
                     </div>
                     @endif
                    <!--           <div class="col-lg-5 col-md-6">
                            <div class="my-report-search">
                                <div class="form-group has-search">
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0)" data-url="{{ url('/dashboard/permit/download/' . \Crypt::encrypt('report')) }}" class="submit-print" ><i class="fa fa-download" ></i><span style="margin-left:10px;">Download PDF</span></a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" data-url="{{ url('/dashboard/permit/print/' . \Crypt::encrypt('report')) }}" class="submit-print"><i class="fa fa-print"></i><span style="margin-left:10px;">Print</span></a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" id="sharePermitPop"><i class="fa fa-link"></i><span style="margin-left:10px;">Share</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div> -->
                    <!-- <div class="col-lg-5 col-md-6">
                            <div class="my-report-search">
                                <div class="form-group has-search">

                                    <input type="text" class="form-control" placeholder="Search for another address">
                                    <button type="submit" class="btn-search">
                                        <span class="fa fa-search form-control-feedback"></span></button>
                                </div>
                            </div>
                        </div> -->
                </div>

            </div>
        </section>
        <!--Section-table-my-report-end-->

        <!--Section-table-open-address-->
        <section class="table address-collaps px-5 pt-2">
            <div class="container-fluid">
                <div class="row-">
                    <div class="panel panel-default">

                        <div class="panel-body">
                            <div class="table100-nextcols table-responsive">
                                <div class="col-sm-12">
                                    <div class="row bg-light">
                                        <div class="col-lg-7 col-md-7">
                                            <div class="my-report-txt mt-2  mb-2">
                                                <!-- <h6 class="text-dark">PERMITS</h6> -->
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-5">
                                            <div class="my-report-search mt-2 mb-2">
                                                <ul>
                                                    <!--    <li class="col-auto float-right">
                                                            <a href="javascript:void(0);" id="sharePermitPop">
                                                                <i class="fa fa-link"> </i> Share </a>
                                                        </li>   -->

                                                    <li class="col-auto  float-right">
                                                    <input type="hidden" name="copy_text_link" id="copy_text_link" value="">
                                                        <button
                                                            onclick="copyPermalink()"
                                                            class="enabled_btn btn-link hide">
                                                            <i class=" fa fa-copy"></i> Copy Link
                                                        </button>
                                                        <button data-toggle="tooltip" data-placement="top"
                                                            title="Please Select Permits to Download"
                                                            class="disabled_btn btn-link text-decoration-none text-dark show btn_report_popup">
                                                            <i class=" fa fa-copy"></i> Copy Link
                                                        </button>
                                                    </li>
                                                    <li class="col-auto float-right">
                                                        <button id="sharePermitPop" class="enabled_btn  btn-link hide">
                                                            <i class="fa fa-print"></i> Share
                                                        </button>
                                                        <button data-toggle="tooltip" data-placement="top"
                                                            title="Please Select Permits to share"
                                                            class="disabled_btn text-decoration-none btn-link text-dark show btn_report_popup">
                                                            <i class="fa fa-print"></i> Share
                                                        </button>

                                                    </li>

                                                    <li class="col-auto float-right">
                                                        <button
                                                            data-url="{{ url('/dashboard/permit/print/' . \Crypt::encrypt('report')) }}"
                                                            class="enabled_btn submit-print btn-link hide">
                                                            <i class="fa fa-print"></i> Print
                                                        </button>
                                                        <button data-toggle="tooltip" data-placement="top"
                                                            title="Please Select Permits to Print"
                                                            class="disabled_btn text-decoration-none btn-link text-dark show btn_report_popup">
                                                            <i class="fa fa-print"></i> Print
                                                        </button>

                                                    </li>
                                                    <li class="col-auto  float-right">
                                                        <button
                                                            data-url="{{ url('/dashboard/permit/download/' . \Crypt::encrypt('report')) }}"
                                                            class="enabled_btn submit-print  btn-link hide">
                                                            <i class=" fa fa-download"></i> Download
                                                        </button>
                                                        <button data-toggle="tooltip" data-placement="top"
                                                            title="Please Select Permits to Download"
                                                            class="disabled_btn btn-link text-decoration-none text-dark show btn_report_popup">
                                                            <i class=" fa fa-download"></i> Download
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="successDiv" style="color:green;text-align: center;"></div>
                                <table class="table table-condensed" id="accordion">
                                    <thead>
                                        <tr class="row100 head">
                                            <th class="cell100 column11">
                                                <div class="custom-checkbox-new ">
                                                    <label class="label">
                                                        <input type="checkbox"
                                                            class=" form-check-input ckbCheckAll pl-2 label__checkbox checkBoxClass"
                                                            id="check2" name="print_all" value="all" />
                                                        <span class="label__text">
                                                            <span class="label__check">
                                                                <i class="fa fa-check icon"></i>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <!-- All -->
                                            </th>
                                            <th class="cell100 column11">Address</th>
                                            <th class="cell100 column11"></th>
                                            <th class="cell100 column11"></th>
                                            <th class="cell100 column11">City</th>
                                            <th class="cell100 column11"></th>
                                            <th class="cell100 column11">State</th>
                                            <th class="cell100 column11">Zip code</th>
                                            <th class="cell100 column11">Status</th>
                                            <th class="cell100 column11"></th>
                                            <th class="cell100 column11">Report Expires</th>
                                            <!-- <th class="cell100 column12">Last viewed <i class="fa fa-long-arrow-down"></i></th> -->

                                        </tr>
                                    </thead>
                                    <tbody class="selectedReports">
                                        @if (!empty($data))
                                            @for ($s = 0; $s < count($data); $s++)
                                                @foreach ($data[$s] as $key => $value)
                                                    <tr data-toggle="collapse" data-target="#demo{{ $s }}"
                                                        class="accordion-toggle accordion row100 body"
                                                        aria-expanded="false">
                                                        <td class="cell100 column11">
                                                            <!-- <input type="checkbox" class="checkBoxClass form-check-input" onclick="event.stopPropagation();"  id="check_{{ $key }}" name="print[]" value="{{ $value['id'] }}"> -->
                                                            <div class="custom-checkbox-new"
                                                                onclick="event.stopPropagation();">
                                                                <label class="label">
                                                                    <input type="checkbox"
                                                                        class="checkBoxClass form-check-input label__checkbox"
                                                                        id="check_{{ $key }}" name="print[]"
                                                                        value="{{ $value['id'] }}" />
                                                                    <span class="label__text">
                                                                        <span class="label__check">
                                                                            <i class="fa fa-check icon"></i>
                                                                        </span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td class="cell100 column11">
                                                            <!-- {{ $value['street'] }} -->
                                                            @php
                                                                $addressArr = explode(', ', $value['street']);
                                                            @endphp
                                                            {{ $addressArr[0] ?? '-' }}
                                                        </td>
                                                        <td class="cell100 column11">
                                                            <i class="fa fa-chevron-down rotate"></i>
                                                        </td>
                                                        <td class="cell100 column11"></td>
                                                        <td class="cell100 column11">{{ $value['city'] }}</td>
                                                        <td class="cell100 column11"></td>
                                                        <td class="cell100 column11">{{ $value['state'] }}</td>
                                                        <td class="cell100 column11">{{ $value['zipcode'] }}</td>
{{--                                                        <td class="cell100 column11">--}}
{{--                                                            <label class="switch">--}}
{{--                                                                <input type="checkbox" class="checkboxID"--}}
{{--                                                                    value="{{ Crypt::encrypt($value['alert']) }}"--}}
{{--                                                                    @if ($value['alert'] == 1) checked="checked" @endif--}}
{{--                                                                    data-val="{{ Crypt::encrypt($value['street']) }}">--}}
{{--                                                                <div class="slider"></div>--}}
{{--                                                            </label>--}}
{{--                                                        </td>--}}
                                                        <td class="cell100 column11">
                                                            @if(!empty($value['PermitStatus']))
                                                                @switch($value['PermitStatus'])
                                                                @case('applied')
                                                                <span
                                                                    title="Request will be submitted to municipality within 24 hours">Pending</span>
                                                                @break
                                                                @case('issued')
                                                                    <span class="badge badge-success" title="Request submitted to municipality. Responses generally received within 7 - 10 business days on average. ">Pending</span>
                                                                @break
                                                                @case('complete')
                                                                <span
                                                                    title="Permit information has been received and is available in your dashboard.">Completed</span>
                                                                @break
                                                                @case('final')
                                                                <span
                                                                    title="Permit information has been received and is available in your dashboard.">Completed</span>
                                                                @break
                                                                @case('pending')
                                                                <span class="badge badge-success" title="Request submitted to municipality. Responses generally received within 7 - 10 business days on average. ">Pending</span>
                                                                @break
                                                                @default
                                                                <span
                                                                    title="{{$value['PermitStatus']}}">{{$value['PermitStatus']}}</span>
                                                                @break
                                                            @endswitch
                                                            @endif
                                                        </td>
                                                        <td class="cell100 column11"></td>
                                                        <td class="cell100 column11">{{ $value['valid'] }}</td>
                                                        <!-- <td class="cell100 column12">{{ $value['lastseen'] }}</td> -->

                                                    </tr>
                                                    <tr>
                                                        <td colspan="13" class="hiddenRow p-0">
                                                            <div id="demo{{ $s }}"
                                                                class="accordian-body collapse">
                                                                <div class="table100-nextcols table-responsive inner-table">
                                                                    <table class="table">
                                                                        <thead>
                                                                            @php $t = 0; @endphp
                                                                            @foreach ($value['result'] as $key1 => $value1)
                                                                                @if ($key1 == 'issued')
                                                                                    <tr class="bg-light text-white">
                                                                                        <!--  <td class="cell100 column0"></td>
                                                                                    <td class="cell100 column1"></td> -->
                                                                                        <td colspan="10"> <strong> OPEN PERMITS
                                                                                                ({{ count($value1) }}) </strong></td>
                                                                                    </tr>
                                                                                @else
                                                                                    <tr class="bg-light text-white">
                                                                                        <!--  <td class="cell100 column0"></td>
                                                                                    <td class="cell100 column1"></td> -->
                                                                                        <td colspan="10"><strong> CLOSED PERMITS
                                                                                                ({{ count($value1) }}) </strong></td>
                                                                                    </tr>
                                                                                @endif
                                                                                <tr class="row100 head table-dark">
                                                                                    <!--  <th class="cell100 column0"></th>
                                                                                 <th class="cell100 column1"></th> -->
                                                                                    <!-- <th class="cell100 column2">Control #</th> -->
                                                                                    <th class="cell100 column11">Date Issued</th>
                                                                                    <th class="cell100 column11">Permit Number</th>
                                                                                    <th class="cell100 column11">Permit Type</th>
{{--                                                                                    <th class="cell100 column11">Description</th>--}}
                                                                                    <!-- <th class="cell100 column7">Subcodes</th> -->
{{--                                                                                    <th class="cell100 column11">Status </th>--}}
                                                                                    <!-- <th class="cell100 column9">Close Date</th> -->
{{--                                                                                    <th class="cell100 column11">Certificates</th>--}}
{{--                                                                                    <th class="cell100 column11">Paid Permit Fee</th>--}}
{{--                                                                                    <th class="cell100 column11">Job Value</th>--}}
{{--                                                                                    <th class="cell100 column11">Applicant Name</th>--}}
                                                                                </tr>
                                                                                @foreach ($value1 as $key2 => $value2)
                                                                                    <tr class="row100 body">
                                                                                        <!-- <td class="cell100 column0">
                                                                                </td>
                                                                                <td class="cell100 column1">

                                                                                </td> -->
                                                                                        <!-- <td class="cell100 column2">36940</td> -->
                                                                                        <td class="cell100 column11">
                                                                                            {{ date('m/d/y', strtotime($value2->PermitEffectiveDate)) }}
                                                                                        </td>
                                                                                        <td class="cell100 column11">
                                                                                            <a href="javascript:void(0)" class="btn-link text-dark" data-toggle="modal" data-target="#permit{{$value2->PermitNumber}}">
                                                                                                {{ $value2->PermitNumber }}
                                                                                            </a>
                                                                                        </td>
                                                                                        <td class="cell100 column11">
                                                                                            {{ $value2->PermitType }}</td>
{{--                                                                                        <td class="cell100 column11">--}}
{{--                                                                                            {{ $value2->PermitDescription }}--}}
{{--                                                                                        </td>--}}
                                                                                        <!-- <td class="cell100 column7">N/A</td> -->
{{--                                                                                        <td class="cell100 column11">--}}
{{--                                                                                            {{ ( $value2->PermitStatus == 'complete' || $value2->PermitStatus == 'closed') ? 'closed' : 'open' }}--}}
{{--                                                                                        </td>--}}
                                                                                        <!-- <td class="cell100 column9">{{ date('m/d/y', strtotime($value2->PermitStatusDate)) }}</td> -->
{{--                                                                                        <td class="cell100 column11">N/A </td>--}}
{{--                                                                                        <td class="cell100 column11">--}}
{{--                                                                                            {{ $value2->PermitFee ? '$' . $value2->PermitFee : '-' }}--}}
{{--                                                                                        </td>--}}
{{--                                                                                        <td class="cell100 column11">--}}
{{--                                                                                            {{ $value2->PermitJobValue ? '$' . $value2->PermitJobValue : '-' }}--}}
{{--                                                                                        </td>--}}
{{--                                                                                        <td class="cell100 column11">--}}
{{--                                                                                            {{ $value2->ApplicantName ? $value2->ApplicantName : '-' }}--}}
{{--                                                                                        </td>--}}
                                                                                    </tr>
                                                                                @endforeach
                                                                                @php $t++; @endphp
                                                                            @endforeach
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endfor
                                        @else
                                            <tr>
                                                <td class="cell100 column1">No Data Found!</td>
                                                <td class="cell100 column2"></td>
                                                <td class="cell100 column3"></td>
                                                <td class="cell100 column4"></td>
                                                <td class="cell100 column5"></td>
                                                <td class="cell100 column6"></td>
                                                <td class="cell100 column7"></td>
                                                <td class="cell100 column8"></td>
                                                <td class="cell100 column9"></td>
                                                <td class="cell100 column10"></td>
                                                <td class="cell100 column11"></td>
                                                <td class="cell100 column12"></td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <!--
                                 <div class="col-sm-12">
                                     <div class="row bg-light p-1 mt-2">
                                    <div class="col-lg-7 col-md-7">

                                    </div>
                                    <div class="col-lg-5 col-md-5">
                                        <div class="my-report-search mt-2 mb-2">
                                                <ul>
                                                  <li class="col-auto float-right">
                                                        <a href="javascript:void(0)"  data-url="{{ url('/dashboard/permit/print/' . \Crypt::encrypt('report')) }}" class="submit-print selected-print">
                                                            <i class="fa fa-print"></i>
                                                            <span class="ml-2 span-selected">Print selected</span></a>
                                                    </li>
                                                    <li class="col-auto  float-right">
                                                        <a href="javascript:void(0)" data-url="{{ url('/dashboard/permit/download/' . \Crypt::encrypt('report')) }}" class="submit-print selected-print" >
                                                            <i class="fa fa-download" ></i><span  class="ml-2">Download selected</span></a>
                                                    </li>  -->
                                <!--   <li class="col-auto float-right">
                                                        <a href="javascript:void(0);" id="sharePermitPop"><i class="fa fa-link"></i><span style="margin-left:10px;">Share</span></a>
                                                    </li>
                                                </ul>
                                        </div>
                                    </div>
                                </div>
                                 </div>
                            </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--Section-table-open-address-End-->
        <section class="popup-already-account permit-popup" id="poShFrnPop">
            {{-- <div class="popup-table">
                <div class="popup-view-report-txt">
                    <div class="permit-txt">
                        <a href="#" class="close-popup" id="popupClosee">&times;</a>
                    </div>
                    <div class="inputEmail">
                        <form>
                            @csrf
                            @if (Auth::user()->user_role_type)
                                <label>Multiple Email Address</label>
                                <input type="text" name="email" id="shareEmail" class="form-control"
                                    placeholder="Enter Multiple Email Address By Comma Separated">
                                <span id="spanPh"></span>
                                <input id="formSharSub" class="btn btn-effect" type="submit" value="submit"
                                    data-url="/share/report">
                            @else
                                <label>Email Address</label>
                                <input type="text" name="email" id="shareEmail" class="form-control"
                                    placeholder="Enter Email Address">
                                <span id="spanPh"></span>
                                <input id="formSharSub" class="btn btn-effect" type="submit" value="submit"
                                    data-url="/share/report">
                            @endif
                    </div>
                    </form>
                </div>
            </div> --}}
            </div>
        </section>


        <!--Section-table-open-Popup Report Validation-End-->
        <section class="popup-already-account permit-popup" id="poShFrnErrorPop">
            {{-- <div class="popup-table">
                <div class="popup-view-report-txt">
                    <div class="permit-txt">
                        <a href="#" class="close-popup_report poShFrnErrorPopClose" id="popupClosee">&times;</a>
                    </div>
                    <div class="inputEmail">
                        <label>Please select a report from the list.</label>
                    </div>
                </div>
            </div> --}}
            </div>
        </section>

    @if (!empty($data))
        @for ($s = 0; $s < count($data); $s++)
            @foreach ($data[$s] as $key => $value)
                @php $t = 0; @endphp
                @foreach ($value['result'] as $key1 => $value1)
                    @foreach ($value1 as $key2 => $value2)
                        <!-- Modal -->
                            <div class="modal fade" id="permit{{$value2->PermitNumber}}" tabindex="-1" role="dialog" aria-labelledby="permits{{$value2->PermitNumber}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="permits{{$value2->PermitNumber}}">Permit Number: {{$value2->PermitNumber}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table">
                                                <thead class="table-info">
                                                    <tr>
                                                        <td>
                                                            <span class="lead"><strong>{{ $value2->PermitType }}</strong></span> <br>
                                                            <span class="small"><strong>{{ $value2->PermitNumber }}</strong></span> <br><br>
                                                            <span class="lead">
                                                                <strong>
                                                                    @php
                                                                        $addressArr = explode(', ', $value['street']);
                                                                    @endphp
                                                                    {{ $addressArr[0] ?? '-' }}
                                                                </strong>
                                                            </span>
                                                        </td>
                                                        <td class="pull-right"><strong>ISSUED:</strong> &nbsp; {{ date('m/d/y', strtotime($value2->PermitEffectiveDate)) }}</td>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th width="40%">Date Issued</th>
                                                        <td width="75%">
                                                            {{ date('m/d/y', strtotime($value2->PermitEffectiveDate)) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Permit Number</th>
                                                        <td>
                                                            <a href="javascript:void(0)" class="btn-link text-dark" data-toggle="modal" data-target="#permit{{$value2->PermitNumber}}">
                                                                {{ $value2->PermitNumber }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Permit Type</th>
                                                        <td>
                                                            {{ $value2->PermitType }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Description</th>
                                                        <td>
                                                            {{ $value2->PermitDescription }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Status </th>
                                                        <td>
                                                            {{ ( $value2->PermitStatus == 'complete' || $value2->PermitStatus == 'closed') ? 'closed' : 'open' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Paid Permit Fee</th>
                                                        <td>
                                                            {{ $value2->PermitFee ? '$' . $value2->PermitFee : '-' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Job Value</th>
                                                        <td>
                                                            {{ $value2->PermitJobValue ? '$' . $value2->PermitJobValue : '-' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Applicant Name</th>
                                                        <td>
                                                            {{ $value2->ApplicantName ? $value2->ApplicantName : '-' }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                @endforeach
            @endforeach
        @endfor
    @endif


    </main>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function copyPermalink()
        {
            var oldText = "{{ url('/dashboard/permit/copylink/') }}";
            var ids = new Array();
            $(".selectedReports input[type=checkbox]:checked").each(function() {
                ids.push(this.value);
            });

            var newLink = oldText + "/" + ids.toString();
            $("#copy_text_link").val(newLink);

            /* Get the text field */
            var copyText = document.getElementById("copy_text_link");

            /* Select the text field */
            copyText.select();
            // copyText.setSelectionRange(0, 99999); /* For mobile devices */

            /* Copy the text inside the text field */
            navigator.clipboard.writeText(copyText.value);

            swal({
                    title: "You Have Successfully Copied The Link!",
                    icon: "success",
                    button: "Okay!",
                });
        }
    </script>
@endsection
