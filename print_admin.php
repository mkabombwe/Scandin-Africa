<?php
require_once 'core/init.php';

if (!logged_in() || $clearance != 9) {
	header('Location: index.php');
} else {
	if($stmt = $mysqli->prepare("SELECT user_id, profile_pic FROM users WHERE username = ?")){
		$stmt->bind_param('s', $session_user_id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($user_id, $top_profile_pic);
		$stmt->fetch();
		$stmt->free_result();
		$stmt->close();
	}

	//Get data from database
	if ($result = $mysqli->query("SELECT user_id, profile_id, username, f_name, l_name, companyname, joined, position, position, country, sector, phone, clearance FROM users ORDER BY f_name")) {
		while ($row = $result->fetch_assoc()) {
			$dashboard_user_id[] = $row['user_id'];
			$dashboard_profile_id[] = $row['profile_id'];
			$dashboard_username[] = $row['username'];
			$dashboard_f_name[] = $row['f_name'];
			$dashboard_l_name[] = $row['l_name'];
			$dashboard_position[] = $row['position'];
			$dashboard_companyname[] = $row['companyname'];
			$dashboard_joined[] = $row['joined'];
			$dashboard_position[] = $row['position'];
			$dashboard_country[] = $row['country'];
			$dashboard_sector[] = $row['sector'];
			$dashboard_phone[] = $row['phone'];
			$dashboard_clearance[] = $row['clearance'];
		}
		$result->free();
	}
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Scandin-Africa | Print</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>
<body>
	<style>
		body{
			float: left;
			width: 100%;
			font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
			-webkit-font-smoothing: antialiased;
			font-size: 14px;
			color: #666666;
		}
		table {
    		border-collapse: collapse;
    		width: 100%;
		}
		
		th, td {
    		text-align: left;
    		padding: 10px;
    		font-size: 
		}
		
		tr:nth-child(even){background-color: #f2f2f2}
		
		th {
    		background-color: #2196F3;
    		color: white;
    		font-weight: 600;
    		padding: 15px 10px;
		}
	</style>
	<table>
		<tr>
			<th>Name</th>
			<th>E-Mail</th>
			<th>Phone</th>
			<th>Company</th>
			<th>Position</th>
			<th>Country</th>
			<th>Sector</th>
			<th>Subscription</th>
			<th>Join date</th>
		</tr>
	<?php
	for ($i=0; $i < count($dashboard_profile_id); $i++) { 
		echo '
		<tr>
			<td>'.$dashboard_f_name[$i].' '.$dashboard_l_name[$i].'</td>
			<td>'.$dashboard_username[$i].'</td>
			<td>'.$dashboard_phone[$i].'</td>
			<td>'.$dashboard_companyname[$i].'</td>
			<td>'.$dashboard_position[$i].'</td>
			<td>'.$dashboard_country[$i].'</td>
			<td>'.$dashboard_sector[$i].'</td>
			<td>'.$dashboard_clearance[$i].'</td>
			<td>'.$dashboard_joined[$i].'</td>
		</tr>
			';
	}
	?>
	</table>
	<script>
		window.print();
	</script>
</body>
</html>
<?php
}
?>