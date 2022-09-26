<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permit Report</title>
</head>
<style type="text/css">
    .footer {
        width: 100%;
        position: fixed;
        text-align: center;
    }

    .footer {
        bottom: 0px;
    }

    .pagenum:before {
        content: counter(page);
    }

    th {
        font-size: 12px;
    }

    td {
        font-size: 12px;
    }

    .row {
        margin-left: -5px;
        margin-right: -5px;
    }

    .column {
        float: left;
        width: 50%;
        padding: 5px;
    }

    .column-7 {
        float: left;
        width: 50%;
        padding: 5px;
    }

    .column-4 {
        float: left;
        width: 50%;
        padding: 5px;
    }

    /* Clearfix (clear floats) */
    .row:after {
        content: "";
        clear: both;
        display: table;
    }

    .row table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
        border: none;
    }

    .row th,
    .row td {
        text-align: left;
        padding: 16px;
        font-size: 16px;
        border: none;
        margin-top: 20px;
    }

    .row th {
        padding-top: 20px;
    }

    .row tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    h4 {
        margin-bottom: 0;
        padding: 0 5px;
    }

    .address-width {
        max-width: 320px;
        width: 100%;
    }

    .map-img table tr td {
        text-align: left;
    }

    .contact_details>p {
        line-height: 0.1;
    }

</style>

<body style="padding: 0px; border:1px solid #ddd">
    @if ((@$is_pro_user) && @$is_pro_user == 1)
        <div class="logo" style="padding: 10px; border-bottom:1px solid #ddd;height:250px">
            <div class="normal_user_div" style="display: block;width: 50%;float: left;margin-top:15px;">
            @if(isset($user_details->company_logo) && !empty($user_details->company_logo))
                <img src="{{ asset('storage/images/users/'.$user_details->company_logo) }}"  alt="img-logo"
                    style="margin-top: 0px;width: 100px;height: 70px;">
                @else
                <img src="http://permitsearch.customerdevsites.com/images/permit.png" alt="img-logo"
                    style="margin-top: 0px;width: 100px;height: 70px;">
                @endif
                    <p>{{ $user_details->company_name }}</p>
                    <p>{{ $user_details->website_url }}</p>
                    <p>{{ $user_details->company_phone_no }}</p>
                    
            </div>
            <div class="pro_user_div" style="width:50%;float: right;font-size:16px;">
                @if($user_image)
                    <img src="{{ $user_image }}" alt="img-logo"
                    style="margin-top: 0px;width: 100px;height: 70px;position: relative;right:5%;">
                @endif
                <div class="contact_details"
                    style="text-align: right;right: 5%;position: relative;font-family: Arial, sans-serif;">
                    <p>{{ $user_details->name }}</p>
                    <p> Pro User</p>
                    <p> {{ ($user_details->address1) ? $user_details->address1.','.$user_details->address2 : '' }} </p>
                    <p>{{ ($user_details->city) ? $user_details->city.','.$user_details->state : '' }}</p>
                    <p>{{ ($user_details->country) ? $user_details->country.'-'.$user_details->zipcode : '' }}</p>
                    <p>{{ $user_details->email }}</p>
                    <p>{{ $user_details->contact }}</p>
                </div>
                {{-- <p class="contact_details" style="text-align: right;right: 5%;position: relative;font-family: Arial, sans-serif;">Pro</p> --}}
                {{-- <p class="contact_details" style="text-align: right;right: 5%;position: relative;font-family: Arial, sans-serif;">{{ $user_details->email }}</p> --}}
                {{-- <p class="contact_details" style="text-align: right;right: 5%;position: relative;font-family: Arial, sans-serif;">{{ $user_details->contact }}</p> --}}
            </div>
        </div>
    @else
        <div class="logo" style="padding: 10px; border-bottom:1px solid #ddd">
            <img src="http://permitsearch.customerdevsites.com/images/permit.png" alt="img-logo"
                style="margin-top: 0px;width: 100px;height: 70px;">
        </div>
    @endif

    <h4 style="text-align: right;margin-top: 10px;"></h4>
    <div class="main-table-map-details">
        @if (isset($array))
            @php
                $counter = 1;
                $not_found_key = '';
            @endphp
            @foreach ($array as $adresss => $type)
                <div class="row">

                    <div class="column-8 map-img" style="padding:0px; margin:15px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr style="width:100%;text-align: center;">
                                <th class="address-width"
                                    style="vertical-align: middle; font-family: Arial, sans-serif; text-align: left; padding-left: 5px;">
                                    {{ $adresss }} </th>
                            </tr>
                            <tr>    
                                <td style="padding:0px;">
                                    <!-- <img src="{{ url('images/map-img.png') }}" alt="" style="margin-top: 0px; width: 150px; height: 150px;"> -->

                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $adresss }}"
                                        target="_blank"><img
                                            src="https://maps.googleapis.com/maps/api/streetview?size=400x150&location={{ $type['location'] ?? '' }}&sensor=false&fov=270&pitch=-10&key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg"
                                            alt=""
                                            style="width: 400px; height: 150px;margin-top:23px;margin-left:15px; top: 150px;">
                                    </a>
                                    <!-- <a href="https://www.google.com/maps/search/?api=1&query={{ $adresss }}" target="_blank"><img src="https://maps.googleapis.com/maps/api/staticmap?center={{ $adresss ?? '' }}&zoom=13&size=600x300&maptype=roadmap&key=AIzaSyAX3psBF__fiVXmIL3lPI3lUxwzssVAB3s" alt=""style="margin-top: 5px; width: 70px; height: 70px; border:1px solid darktgray;"> </a> -->
                                </td>
                                <td style="float: right;">
                                    <img src="https://permitsearch.com/images/map-img.png" alt=""
                                        style="margin-top: 23px; width: 250px; height: 150px;">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                @php unset($type['location']) @endphp

                @foreach ($type as $key => $reports)
                    @php $not_found_key = ucfirst($key??''); @endphp
                    <div class="row">
                        <h4 style="padding-left: 8px; font-family: Arial, sans-serif;">{{ ucfirst($key ?? '') }}
                            ({{ @count($reports) }})</h4>
                    </div>
                    <table
                        style="border-collapse: collapse;max-width: 700px;margin: 10px auto;width: 100%;text-align: left; border-top:1px solid #ddd; border-bottom: 1px solid #ddd; font-family: Arial, sans-serif;">
                        <thead>
                            <tr class="row100 head">
                                <th
                                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left; padding-left: 5px">
                                    Permit #</th>
                                <th
                                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                                    Issue Date</th>
                                <th
                                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                                    Work type</th>
                                <th
                                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                                    Description</th>
                                <th
                                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                                    Address</th>
                                <th
                                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                                    Status <br></th>
                                <th
                                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                                    Status Date</th>
                                <th
                                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                                    Fee Paid</th>
                                <th
                                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left; padding-right: 5px">
                                    Agent</th>
                            </tr>
                        </thead>
                        <tbody style=" font-family: Arial, sans-serif;">
                            @foreach ($reports as $key => $value)
                                <tr class="row100 body">
                                    <td class="cell100 column1" style="font-size: 11px; padding-left: 5px">
                                        {{ $value['number'] ?? '' }}</td>
                                    <td class="cell100 column3" style="font-size: 11px;"> {{ $value['date'] ?? '' }}</td>
                                    <td class="cell100 column4" style="font-size: 11px;">
                                        {{ $value['type'] ? $value['type'] : '-' }}</td>
                                    <td class="cell100 column5" style="font-size: 11px;">
                                        {{ $value['description'] ? $value['description'] : '-' }} </td>
                                    <td class="cell100 column6" style="font-size: 11px;"> {{ $value['address'] ?? '' }}
                                    </td>
                                    <td class="cell100 column6" style="font-size: 11px;"> {{ $value['status'] ?? '' }}
                                    </td>
                                    <td class="cell100 column6" style="font-size: 11px;"> {{ $value['cdate'] ?? '' }}
                                    </td>
                                    <td class="cell100 column6" style="font-size: 11px;">
                                        {{ $value['cost'] ? '$ ' . $value['cost'] : '-' }}</td>
                                    <td class="cell100 column6" style="font-size: 11px; padding-right: 5px;">
                                        {{ $value['agent'] ? $value['agent'] : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach

                @if ($counter == 1)
                    </br></br>
                    <div class="row">
                        <h4 style="padding-left: 8px; font-family: Arial, sans-serif;">
                            {{ isset($not_found_key) && !empty($not_found_key) && $not_found_key == 'Open' ? 'Closed' : 'Open' }}
                            (0)</h4>
                    </div>
                    <table
                        style="border-collapse: collapse;max-width: 700px;margin: 10px auto;width: 100%;text-align: left; border-top:1px solid #ddd; border-bottom: 1px solid #ddd; font-family: Arial, sans-serif;">
                        <thead>
                            <tr class="row100 head">
                                <th
                                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left; padding-left: 5px">
                                    Permit #</th>
                                <th
                                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                                    Issue Date</th>
                                <th
                                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                                    Work type</th>
                                <th
                                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                                    Description</th>
                                <th
                                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                                    Address</th>
                                <th
                                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                                    Status <br></th>
                                <th
                                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                                    Status Date</th>
                                <th
                                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                                    Fee Paid</th>
                                <th
                                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left; padding-right: 5px">
                                    Agent</th>
                            </tr>
                        </thead>
                        <tbody style=" font-family: Arial, sans-serif;">
                            <tr class="row100 body">
                                <td colspan="9">No Records Found...!</td>
                            </tr>
                        </tbody>
                    </table>
    </div>
    <div class="footer">
        Page <span class="pagenum"></span>
    </div>
    @endif
    @endforeach
@else
    <div class="row">
        <h4 style="padding-left: 8px; font-family: Arial, sans-serif;"> Open (0)</h4>
    </div>
    <table
        style="border-collapse: collapse;max-width: 700px;margin: 10px auto;width: 100%;text-align: left; border-top:1px solid #ddd; border-bottom: 1px solid #ddd; font-family: Arial, sans-serif;">
        <thead>
            <tr class="row100 head">
                <th
                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left; padding-left: 5px">
                    Permit #</th>
                <th
                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                    Issue Date</th>
                <th
                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                    Work type</th>
                <th
                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                    Description</th>
                <th
                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                    Address</th>
                <th
                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                    Status <br></th>
                <th
                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                    Status Date</th>
                <th
                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                    Fee Paid</th>
                <th
                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left; padding-right: 5px">
                    Agent</th>
            </tr>
        </thead>
        <tbody style=" font-family: Arial, sans-serif;">
            <tr class="row100 body">
                <td colspan="9">No Records Found...!</td>
            </tr>
        </tbody>
    </table>
    </div>
    <div class="footer">
        Page <span class="pagenum"></span>
    </div>
    </br></br>
    <div class="row">
        <h4 style="padding-left: 8px; font-family: Arial, sans-serif;"> Closed (0)</h4>
    </div>
    <table
        style="border-collapse: collapse;max-width: 700px;margin: 10px auto;width: 100%;text-align: left; border-top:1px solid #ddd; border-bottom: 1px solid #ddd; font-family: Arial, sans-serif;">
        <thead>
            <tr class="row100 head">
                <th
                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left; padding-left: 5px">
                    Permit #</th>
                <th
                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                    Issue Date</th>
                <th
                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                    Work type</th>
                <th
                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                    Description</th>
                <th
                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                    Address</th>
                <th
                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                    Status <br></th>
                <th
                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                    Status Date</th>
                <th
                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">
                    Fee Paid</th>
                <th
                    style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left; padding-right: 5px">
                    Agent</th>
            </tr>
        </thead>
        <tbody style=" font-family: Arial, sans-serif;">
            <tr class="row100 body">
                <td colspan="9">No Records Found...!</td>
            </tr>
        </tbody>
    </table>
    </div>
    <div class="footer">
        Page <span class="pagenum"></span>
    </div>

    @endif
</body>
</html>
