@extends('layouts.app')
@section('content')

    <main id="main">
        <section class="Anderson-Lane px-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-7 col-md-6">
                        <div class="Anderson-Lane-txt">
                            @if (isset($data) && !empty($data))
                                <h2><span id="txNm">{{ @$data[0] }}</span></h2>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6 search-share">
                        <div class="my-report-search">
                            <div class="form-group has-search">
                                @if (isset($data) && !empty($data))
                                    <ul>
                                        <li>
                                            <a href="{{ url('/dashboard/permit/download/' . \Crypt::encrypt(@$data[0])) }}"><i
                                                    class="fa fa-download ml-2"> </i> <span> Download PDF</span></a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/dashboard/permit/print/' . \Crypt::encrypt(@$data[0])) }}"
                                                target="_blank"><i class="fa fa-print ml-2"> </i> <span> Print</span></a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" id="vieMapSEar"><i class="fa fa-map ml-2"> </i>
                                                <span>View map</span></a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <p>There are <strong>{{(isset($data['issued']))?count($data['issued']):0}}</strong> open permits and <strong>{{(isset($data['complete']))?count($data['complete']):0}}</strong> closed permits for this property</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="table table-open-permits1 px-5 mb-0 pb-0">
            <span id="successStatusMsg1" style="text-align: center;">
                @if (Session::has('fail'))
                    <div class="alert alert-danger">
                        {{ Session::get('fail') }}
                    </div>
                @endif
            </span>
            <div class="container-fluid">
                <div class="table100-nextcols table-responsive">
                    @if (array_key_exists('issued', $data))
                        <table class="text-left">
                            <thead>
                                <tr class="row100 head text-left bg-light">
                                    <td class="cell100 "></td>
                                    <td colspan="10" class="">
                                        OPEN PERMITS (<?php echo count($data['issued']); ?>)
                                    </td>
                                </tr>
                                <tr class="row100 head">
                                    <th class="cell100 "></th>
                                    <th class="cell100 ">Permit Number</th>
                                    <th class="cell100 ">Issue Date</th>
                                    <th class="cell100 ">Work Type</th>
                                    <th class="cell100 ">Description</th>
                                    <th class="cell100 ">Status</th>
                                    <th class="cell100 ">Certificates</th>
                                    <th class="cell100 ">Paid Permit Fee</th>
                                    <th class="cell100 ">Job Value</th>
                                    <th class="cell100 ">Applicant Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                function smart_wordwrap($string, $width = 75, $break = "\n")
                                {
                                    // split on problem words over the line length
                                    $pattern = sprintf('/([^ ]{%d,})/', $width);
                                    $output = '';
                                    $words = preg_split($pattern, $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

                                    foreach ($words as $word) {
                                        if (false !== strpos($word, ' ')) {
                                            // normal behaviour, rebuild the string
                                            $output .= $word;
                                        } else {
                                            // work out how many characters would be on the current line
                                            $wrapped = explode($break, wordwrap($output, $width, $break));
                                            $count = $width - (strlen(end($wrapped)) % $width);

                                            // fill the current line and add a break
                                            $output .= substr($word, 0, $count) . $break;

                                            // wrap any remaining characters from the problem word
                                            $output .= wordwrap(substr($word, $count), $width, $break, true);
                                        }
                                    }

                                    // wrap the final output
                                    return wordwrap($output, $width, $break);
                                }

                                ?>
                                @if (!empty($data['issued']))
                                    @php $i = 0; @endphp
                                    @foreach ($data['issued'] as $key => $value)
                                        <tr class="row100 body" data-val="{{ $i }}"
                                            data-id="{{ Crypt::encrypt($value->id) }}">
                                            <!-- <td class="cell100 column2">36940</td> -->
                                            <td id="pNO{{ $i }}" class="cell100 ">
                                                @if ($value->alarm == 'yes') <figure><img src="{{ asset('images/bell.png') }}" alt="icn"></figure> @endif </td>
                                            <td id="pNO{{ $i }}" class="cell100 "
                                                data-set="@if ($value->alarm == 'yes'){{ 'cellAlram' }}@else{{ 'cell' }}@endif">
                                                <!-- <a href="javascript::void(0);" style="text-decoration: underline;" class="beLPoPUp">{{ $value->PermitNumber }}</a> -->
                                                {{ $value->PermitNumber }}
                                            </td>
                                            <td id="pDT{{ $i }}" class="cell100 column2">
                                                {{ date('Y-m-d', strtotime($value->PermitEffectiveDate)) }}</td>
                                            <td id="pPT{{ $i }}" class="cell100 ">
                                                {{ $value->PermitType }}
                                            </td>
                                            <td id="pPD{{ $i }}" class="cell100 ">
                                                @php
                                                $report_description = wordwrap($value->PermitDescription, 50, "\n", true);
                                                $report_description = htmlentities($report_description);
                                                $report_description = nl2br($report_description);
                                                echo $report_description;
                                                @endphp
                                            </td>
                                            <td id="pPS{{ $i }}" class="cell100 ">
                                                {{ $value->PermitStatus == 'complete' ? 'closed' : 'open' }}
                                            </td>

                                            <td id="pPC{{ $i }}" class="cell100 ">N/A</td>
                                            <td id="pPF{{ $i }}" class="cell100 ">
                                                {{ $value->PermitFee ? '$' . $value->PermitFee : '-' }}
                                            </td>
                                            <td id="pPF{{ $i }}" class="cell100 ">
                                                {{ $value->PermitJobValue ? '$' . $value->PermitJobValue : '-' }}</td>
                                            <td id="pPAN{{ $i }}" class="cell100 ">
                                                {{ $value->ApplicantName ? '$' . $value->ApplicantName : '-' }}</td>
                                        </tr>
                                        @php $i++; @endphp
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    @else
                        <table class="text-left">
                            <thead>
                                <tr class="row100 head text-left bg-light">
                                    <td colspan="10" class="pl-3">
                                        OPEN PERMITS (0)
                                    </td>
                                </tr>
                                <tr class="row100 head">
                                    <th class="cell100 ">Permit Number</th>
                                    <th class="cell100 ">Issue Date</th>
                                    <th class="cell100 ">Work Type</th>
                                    <th class="cell100 ">Description</th>
                                    <th class="cell100 ">Status</th>
                                    <th class="cell100 ">Certificates</th>
                                    <th class="cell100 ">Paid Permit Fee</th>
                                    <th class="cell100 ">Job Value</th>
                                    <th class="cell100 ">Applicant Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="row100 body">
                                    <td> No open permits for this property</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </section>
        </br></br>
        <section class="table table-open-permits6 px-5 p-0 m-0">
            <div class="container-fluid">
                <div class="table100-nextcols table-responsive">
                    @if (array_key_exists('complete', $data))
                        <table class="text-left">
                            <thead>
                                <tr class="row100 head text-left bg-light">
                                    <td class="cell100 "></td>
                                    <td colspan="10" class="">
                                        CLOSED PERMITS (<?php echo count($data['complete']); ?>)
                                    </td>
                                </tr>
                                <tr class="row100 head">
                                    <th class="cell100 "></th>
                                    <th class="cell100 ">Permit Number</th>
                                    <th class="cell100 ">Issue Date</th>
                                    <th class="cell100 ">Work Type</th>
                                    <th class="cell100 ">Description</th>
                                    <th class="cell100 ">Status</th>
                                    <th class="cell100 ">Certificates</th>
                                    <th class="cell100 ">Paid Permit Fee</th>
                                    <th class="cell100 ">Job Value</th>
                                    <th class="cell100 ">Applicant Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($data['complete']))
                                    @php $i = 0; @endphp
                                    @foreach ($data['complete'] as $key => $value)
                                        <tr class="row100 body" data-val="{{ $i }}"
                                            data-id="{{ Crypt::encrypt($value->id) }}">
                                            <td id="pNO{{ $i }}" class="cell100 ">
                                                @if ($value->alarm == 'yes') <figure><img src="{{ asset('images/bell.png') }}" alt="icn"></figure> @endif </td>
                                            <td class="cell100 " data-set="@if ($value->alarm == 'yes'){{ 'cellAlram' }}@else{{ 'cell' }}@endif">
                                                <!--  <a href="javascript::void(0);" style="text-decoration: underline;" class="beLPoPUp">{{ $value->PermitNumber }}</a> -->
                                                {{ $value->PermitNumber }}
                                            </td>
                                            <td class="cell100 ">
                                                {{ date('Y-m-d', strtotime($value->PermitEffectiveDate)) }}</td>
                                            <td class="cell100 ">
                                                {{ $value->PermitType }}</td>
                                            <td class="cell100 ">
                                                {{ $value->PermitDescription }}</td>
                                            <td class="cell100 ">
                                                {{ $value->PermitStatus == 'complete' ? 'closed' : 'open' }}</td>
                                            <td class="cell100 ">N/A</td>
                                            <td class="cell100 ">
                                                {{ $value->PermitFee ? '$' . $value->PermitFee : '-' }}</td>
                                            <td class="cell100 ">
                                                {{ $value->PermitJobValue ? '$' . $value->PermitJobValue : '-' }}
                                            </td>
                                            <td class="cell100 ">
                                                {{ $value->ApplicantName ? '$' . $value->ApplicantName : '-' }}</td>
                                        </tr>
                                        @php $i++; @endphp
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    @else
                        <table class="text-left">
                            <thead>
                                <tr class="row100 head text-left bg-light">
                                    <td colspan="10" class="pl-3">
                                        CLOSED PERMITS (0)
                                    </td>
                                </tr>
                                <tr class="row100 head">
                                    <th class="cell100 ">Permit Number</th>
                                    <th class="cell100 ">Issue Date</th>
                                    <th class="cell100 ">Work Type</th>
                                    <th class="cell100 ">Description</th>
                                    <th class="cell100 ">Status</th>
                                    <th class="cell100 ">Certificates</th>
                                    <th class="cell100 ">Paid Permit Fee</th>
                                    <th class="cell100 ">Job Value</th>
                                    <th class="cell100 ">Applicant Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="row100 body">
                                    <td class="cell100">
                                        No closed permits for this property
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </section>

        <!--  <section class="table table-open-permits6 px-5">
                <div class="container-fluid">
                    <div class="table100-nextcols table-responsive">
                            @if (array_key_exists('Inspection', $data))
                                <p>INSPECTIONS (<?php echo count($data['Inspection']); ?>)</p>
                                <table>
                                    <thead>
                                        <tr class="row100 head">
                                            <th class="cell100 "></th>
                                            <th class="cell100 column2">Inspection Date</th>
                                            <th class="cell100 column3">Permit #</th>
                                            <th class="cell100 column4">Subcode</th>
                                            <th class="cell100 column5">Type</th>
                                            <th class="cell100 column6">Inspector</th>
                                            <th class="cell100 column7">Result</th>
                                            <th class="cell100 column8">TA Notes</th>
                                            <th class="cell100 column9">Findings</th>
                                            <th class="cell100  0"></th>
                                            <th class="cell100  1"></th>
                                            <th class="cell100  2"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($data['Inspection']))
                                            @foreach ($data['Inspection'] as $key => $value)
                                                <tr class="row100 body" data-id="{{ Crypt::encrypt($value->id) }}">
                                                    <td class="cell100 "></td>
                                                    <td class="cell100 column2"></td>
                                                    <td class="cell100 column3"><a href="javascript::void(0);" style="text-decoration: underline;" class="beLPoPUp">{{ $value->PermitNumber }}</a></td>
                                                    <td class="cell100 column4"></td>
                                                    <td class="cell100 column5">{{ $value->PermitType }}</td>
                                                    <td class="cell100 column6"></td>
                                                    <td class="cell100 column7"></td>
                                                    <td class="cell100 column8">N/A</td>
                                                    <td class="cell100 column9">N/A</td>
                                                    <td class="cell100  0"></td>
                                                    <td class="cell100  1"></td>
                                                    <td class="cell100  2"></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            @endif
                    </div>
                </div>
            </section>

         Section-table-popup-->

        @if (\Session::get('usePermit') == 0 && \Session::get('viewReportPopUp') != 'yes')
            <section class="popup-already-account view-report-popup">
                <div class="popup-table">
                    <div class="popup-view-report-txt">
                        <div class="view-report-txt">
                            <h2 style="text-align: center;">Alert! </h2>
                        </div>
                        @if(\Session::get('searchQuery'))
                            <p>You do not have enough credits to view this report. Please <a
                                    href="{{ url('/pricings?type=buycredits&searchQuery='.\Session::get('searchQuery')) }}"><b>click here</b></a> to purchase additional
                                credits.</p>
                        @else
                            <p>You do not have enough credits to view this report. Please <a
                                    href="{{ url('/pricings?type=buycredits') }}"><b>click here</b></a> to purchase additional
                                credits.</p>
                        @endif

                    </div>
                </div>
            </section>
        @else

                <script>
                    var url = window.location.origin;
                    $.ajax({
                        type: "GET",
                        url: url + '/viewReportSes/' + $('#txNm').html(),
                        success: function(result) {
                            $(".conTVieTab_clicked").removeClass("show");
                            $(".conTVieTab_clicked").addClass("hide");
                            console.log(result);
                            $('#creRemSpn').html(result);
                            $("body").removeClass("popup-open");
                            $(".popup-table").addClass("active-popup");
                        }
                    });
                </script>

            {{-- <section class="popup-already-account permit-popup" id="rePoDisID">
                <div class="popup-table">
                    <form method="POST" action="{{ url('/dashboard/permit/alert') }}" id="setUpAlert">
                        <div class="popup-permit-txt">
                            @csrf
                            <input type="hidden" name="altPID">
                            <div class="blue-bg-btn bg-white p-0"> <a class="btn btn-effect" id="creAlForSin"
                                    href="javascript::void(0);">Create Alert</a></div>
                    </form>
                    <div class="permit-txt">
                        <!-- Permit -->
                        <a href="#" class="close-popup rePoDisIDCl" style="top: -20px;" id="popupClose">&times;</a>
                    </div>
                    <div class="dSlReport">

                    </div>
                </div>
                </form>
                </div>
            </section>
            <section class="popup-already-account view-report-popup" id="pricPopSh">
                <div class="popup-table">
                    <div class="popup-view-report-txt">
                        <div class="permit-txt">
                            <a href="#" class="close-popup" id="popupClosee">&times;</a>
                        </div>
                        <div class="view-report-txt">
                            <h2 style="text-align: center;">Alert!</h2>
                        </div>
                        <p>You do not have enough credits to view this report. Please <a href="{{ url('/pricing') }}"><b
                                    style="color: #5AB9E3;">click here</b></a> to purchase additional credits.</p>
                    </div>
                </div>
            </section> --}}
        @endif
        <!--Section END-->
    </main>

@endsection
