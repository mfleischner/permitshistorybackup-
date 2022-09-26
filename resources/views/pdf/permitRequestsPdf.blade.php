<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Permit Requests</title>
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
        th{
            font-size: 12px;
        }
        td{
            font-size: 12px;
            text-transform: capitalize;
        }

        .row {
            margin-left:-5px;
            margin-right:-5px;
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
    
        .row th, .row td {
            text-align: left;
            padding: 16px;
            font-size: 16px;
            border: none;
            text-transform: uppercase;
            margin-top: 20px;
        }
        .row th{
            padding-top: 20px;
        }
    
        .row tr:nth-child(even) {
            background-color: #f2f2f2;
            border: 1px;
        }
        h4 {
            margin-bottom: 0;
            padding: 0 5px;
        }
        .address-width {
            max-width: 320px;
            width: 100%;
        }
        .map-img table tr td {text-align: left;}
    </style>
    <body style="padding: 0px; border:1px solid #ddd">
        <div class="logo" style="padding: 10px; border-bottom:1px solid #ddd">
            <img src="http://permitsearch.customerdevsites.com/images/permit.png" alt="img-logo" style="margin-top: 0px;width: 100px;height: 70px;">        
        </div>
        
        <h4 style="text-align: right;margin-top: 10px;"></h4>
        <div class="main-table-map-details">
        @if(isset($array))
            <div class="row">
                <h4 style="padding-left: 8px;margin: 10px;font-family: Arial, sans-serif;">Permit Requests List</h4>
            </div>
            <table style="border-collapse: collapse;max-width: 700px;margin: 1px;width: 100%;text-align: left; border-top:1px solid #ddd; border-bottom: 1px solid #ddd; font-family: Arial, sans-serif;">
                <thead>          
                    <tr class="row100 head">
                        <th style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left; padding-left: 5px">Full Name </th>
                         <th style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">Email</th>
                         <th style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">Mobile</th>                   
                        <th style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">Address</th>
                        <th style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">Description</th>
                        <th style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">Planning to<br/> Purchase in</th>
                        <th style="border-bottom: 1px solid #ddd;border-top: 0;color: #002257;font-size: 12px;padding: 12px 10px;padding-left: 0;white-space: nowrap;text-align: left;">Status</th>
                       
                    </tr>
                </thead>
                <tbody style=" font-family: Arial, sans-serif;">
                    @foreach($array as $key => $value)
                        <tr class="row100" style=" border-bottom: 1px solid #ddd">
                            <td class="cell100 column1" style="font-size: 11px; padding-left: 5px; border-bottom: 1px solid #ddd">
                                {{$value['first_name']??''}} {{$value['last_name']??''}}
                            </td>
                            <td class="cell100 column1" style="font-size: 11px; padding-left: 5px; border-bottom: 1px solid #ddd">
                            	{{$value['email_address']?$value['email_address']:'-'}}
                            </td>
                            <td class="cell100 column1" style="font-size: 11px; padding-left: 5px; border-bottom: 1px solid #ddd">
                                {{$value['contact_no']?$value['contact_no']:'-'}}                            	
                            </td>               
                            <td class="cell100 column1" style="font-size: 11px; padding-left: 5px; border-bottom: 1px solid #ddd">
                            	{{ucfirst($value['property_street_name']??'')}},  <br/>
                            	{{ucfirst($value['property_city']??'')}} , <br/>
                           		{{ucfirst($value['state_name']??'')}}, 
                           		{{ucfirst($value['zip_code']?$value['zip_code']:'-')}}
                           	</td>
                            <td class="cell100 column1" style="font-size: 11px; padding-left: 5px; border-bottom: 1px solid #ddd">
                                {{$value['description']?$value['description']:'-'}}
                            </td>
                            <td class="cell100 column1" style="font-size: 11px; padding-left: 5px; border-bottom: 1px solid #ddd">
                                {{$value['purchase_with_in']?$value['purchase_with_in']:'-'}}
                            </td>
                            <td class="cell100 column1" style="font-size: 11px; padding-left: 5px; border-bottom: 1px solid #ddd">
                                {{$value['status']?$value['status']:'-'}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        </div>
        <div class="footer">
            Page <span class="pagenum"></span>
        </div>
    </body>
</html>