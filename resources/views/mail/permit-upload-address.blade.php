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
				<h3>{{ $details['title'] }}</h3>
			<div style="text-align: left; padding: 10px;">
				{{ $details['body'] }}
			</div>
					<div style="text-align: left; padding: 10px;"> 
						<h4>Warm Regards,</h4>
						<p>Permit Search Team</p>
					</div>
			</div>
			<div id="header-email">
			  <h2>	</h2>
			</div>
			
		</div>
	
	</body>
</html>