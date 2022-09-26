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
		</style>
	</head>
	<body>
		<div id="header-email">
			<h2>PERMIT SEARCH</h2>
			<div id="header-content">	
				<h3>New Permit/Address Request</h3>
			<div style="text-align: left; padding: 10px;">
				You have received new permit request from <b>{{ $details['first_name']??'' }}  {{ $details['last_name']??'' }} </b>. 	
			</div>
					<table>
					  <tr>
					    <th style="width:200px">Full Name</th>
					    <td>
					    	{{ $details['first_name']??'' }}&nbsp;&nbsp; {{ $details['last_name']??'' }}
					    </td>
					  </tr>
					  <tr>
					    <th style="width:200px">Contact details : </th>
					    <td>
					    	<b> Mobile / Phone No. </b>: {{ $details['first_name']??'' }}  <br/>
					    	<b> Email Address </b>: {{ $details['email']??($details['email_address']??'') }}
					    </td>
					  </tr>
					  <tr>
					    <th style="width:200px">Property Details</th>
					    <td>
					    	<b> Street Addres </b>: {{ $details['property_street_name']??'' }} <br/>
					    	<b> City </b>: {{ $details['property_city']??'' }} <br/>
					    	<b> State </b>: {{ $details['property_state']??'' }} <br/>
					    	<b> Zip Code </b>: {{ $details['zip_code']??'' }}

					    </td>
					  </tr>
					  <tr>
					   	<th style="width:200px">Planning to Purchase in </th>
					    <td>
					    	{{$details['purchase_with_in']??''}}
					    </td>
					  </tr>
					  <tr>
					   	<th style="width:200px">Additional Comment's </th>
					    <td>
					    	{{$details['description']??'-'}}
					    </td>
					  </tr>
					</table>
					<div style="text-align: left; padding: 10px;"> 
						<h4>Warm Regards,</h4>
						<p>Permit Search Team</p>
					</div>
					<sm
			</div>
			<div id="header-email">
			  <h2>	</h2>
			</div>
			
		</div>
	
	</body>
</html>