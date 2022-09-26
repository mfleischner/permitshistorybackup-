<!DOCTYPE html>
<html>
<head>
	<title>PermitSearch</title>
	<style>
	table, th, td {
		border: 1px solid black;
		border-collapse: collapse;
	}
	th, td {
		padding: 5px;
		text-align: left;
	}
	#header-email h2{
		margin: 10px;
		background-color: black;
		padding: 10px 10px 10px 10px;
		color: white;
		text-align: center;
		border: 2px solid black;
	}



	#header-content{

		padding: 10px 10px 10px 10px;
		color: dark;
		text-align: center;

	}
	table, td, th {
		border: 1px solid black;
		color: dark;

	}

	table {
		width: 100%;
		border-collapse: collapse;
	}
	.btn{

	box-sizing: border-box;
    font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';
    border-radius: 4px;
    color: white !important;
    display: inline-block;
    overflow: hidden;
    text-decoration: none;
    background-color: #2d3748;
    border-bottom: 8px solid #2d3748;
    border-left: 18px solid #2d3748;
    border-right: 18px solid #2d3748;
    border-top: 8px solid #2d3748;
	}
</style>
</head>
<body>
	<div id="header-email">
		<h2>PERMIT SEARCH</h2>
		<div id="header-content" style="padding: 10px;">
            <h3>Permit Request Status: <b>{{$status}}</b> permitsearch.com</h3>
			<div style="text-align: left; ">
				Hello {{ $details['first_name']??'' }}  {{ $details['last_name']??'' }},
				<br/>
				We’ve collected permit details for the address you entered on date {{ date("m/d/Y", strtotime($details['created_at']))??'' }}. Please login and navigate to the My Reports section to view permit details.
			</div>
			<div style="text-align:left">
				<b> Street Address </b>: {{ $details['property_street_name']??'' }} <br/>
				<b> City </b>: {{ $details['property_city']??'' }} <br/>
				<b> State </b>: {{ $details['property_state']??'' }} <br/>
				<b> Zip Code </b>: {{ $details['zip_code']??'' }}<br/>
				<br/>
			</div>
			<div>
				<a href="{{url('/dashboard/permit/my-report')}}"  class="btn" target="_blank"> My Reports </a> <br/>
			</div>
			<div style="text-align: left; padding: 10px;">
				<h4>Warm Regards,</h4>
				<p>Permit Search Team</p>
			</div>
		</div>

	</div>

</body>
</html>
