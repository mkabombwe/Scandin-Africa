<?php
require_once 'core/init.php';

$current_page = "admin";

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
	if(!isset($_GET['sort'])) {
		header('Location: admin.php?sort=name');
	} else {
		if ($_GET['sort'] == 'name') { $sort = 'f_name'; }
		else if ($_GET['sort'] == 'email'){$sort = 'username';}
		else if ($_GET['sort'] == 'company'){$sort = 'companyname';}
		else if ($_GET['sort'] == 'position'){$sort = 'position';}
		else if ($_GET['sort'] == 'country'){$sort = 'country';}
		else if ($_GET['sort'] == 'joined'){$sort = 'joined';}
		else if ($_GET['sort'] == 'subscription'){$sort = 'clearance';}
		//Get data from database
		if ($result = $mysqli->query("SELECT user_id, profile_id, username, f_name, l_name, companyname, joined, position, position, country, sector, phone, clearance FROM users ORDER BY ".$sort."")) {
			while ($row = $result->fetch_assoc()) {
				$dashboard_user_id[] = $row['user_id'];
				$dashboard_profile_id[] = $row['profile_id'];
				$dashboard_username[] = $row['username'];
				$dashboard_f_name[] = $row['f_name'];
				$dashboard_l_name[] = $row['l_name'];
				$dashboard_position[] = $row['position'];
				$dashboard_companyname[] = $row['companyname'];
				$dashboard_joined[] = $row['joined'];
				$dashboard_country[] = $row['country'];
				$dashboard_sector[] = $row['sector'];
				$dashboard_phone[] = $row['phone'];
				$dashboard_clearance[] = $row['clearance'];
			}
			$result->free();
		}
	}

	//Total user
	if ($result = $mysqli->query("SELECT user_id FROM users")) {
		$row_cnt = $result->num_rows;
		$total_users = $row_cnt;
		$result->close();
	}
	//Activated users
	if ($result = $mysqli->query("SELECT active FROM users")) {
		$row_cnt = $result->num_rows;
		$total_active = $row_cnt;
		$result->close();
	}
	//Total Discover accounts
	if ($result = $mysqli->query("SELECT user_id FROM users WHERE clearance = 0")) {
		$row_cnt = $result->num_rows;
		$total_discover = $row_cnt;
		$result->close();
	}
	//Total Premium accounts
	if ($result = $mysqli->query("SELECT user_id FROM users WHERE clearance = 2")) {
		$row_cnt = $result->num_rows;
		$total_premium = $row_cnt;
		$result->close();
	}
	//Total Advantage accounts
	if ($result = $mysqli->query("SELECT user_id FROM users WHERE clearance = 3")) {
		$row_cnt = $result->num_rows;
		$total_advantage = $row_cnt;
		$result->close();
	}
	//Total Advantage accounts
	if ($result = $mysqli->query("SELECT user_id FROM users WHERE clearance = 9")) {
		$row_cnt = $result->num_rows;
		$total_admin = $row_cnt;
		$result->close();
	}

?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Scandin-Africa | Admin Panel</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/admin.css">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body id="admin_body">
	<div id="admin_wrapper">
	<?php include("includes/menubar_new.php"); ?>
		<div id="admin_container_outter">
			<div id="admin_container_inner">
				<?php include("includes/menu_left.php"); ?>
				<div id="wrapper">
					<div id="users" class="box printable">
						<p class="box_title printable">Users</p>
						<div class="box_outter">
							<div class="box_inner">
								<div class="box_row first_box printable">
									<div class="box_cell first_row" onclick="window.location.href='admin.php?sort=name';">Name</div>
									<div class="box_cell first_row" onclick="window.location.href='admin.php?sort=email';">E-Mail</div>
									<div class="box_cell first_row" onclick="window.location.href='admin.php?sort=company';">Company</div>
									<div class="box_cell first_row" onclick="window.location.href='admin.php?sort=position';">Position</div>
									<div class="box_cell first_row" onclick="window.location.href='admin.php?sort=country';">Country</div>
									<div class="box_cell first_row" onclick="window.location.href='admin.php?sort=joined';">Joined date</div>
									<div class="box_cell first_row" onclick="window.location.href='admin.php?sort=subscription';">Subscription</div>
									<div class="box_cell first_row noprint">Action</div>
								</div>
								<?php 
								for ($i=0; $i < count($dashboard_profile_id); $i++) { 
								echo '
									<div class="box_row">
										<div class="box_cell site_link" onclick="window.location.href=\'profile.php?user='.$dashboard_profile_id[$i].'\'">'.$dashboard_f_name[$i].' '.$dashboard_l_name[$i].'</div>
										<div class="box_cell">'.$dashboard_username[$i].'</div>
										<div class="box_cell">'.$dashboard_companyname[$i].'</div>
										<div class="box_cell">'.$dashboard_position[$i].'</div>
										<div class="box_cell">'.$dashboard_country[$i].'</div>
										<div class="box_cell">'.$dashboard_joined[$i].'</div>
										<div class="box_cell">
											<select class="select_subscription" name="select_subs" id="sub_'.$dashboard_user_id[$i].'">
												<option value="1" '; if($dashboard_clearance[$i] == 1) {echo 'selected';} echo '>Discover</option>
												<option value="2" '; if($dashboard_clearance[$i] == 2) {echo 'selected';} echo '>Premium</option>
												<option value="3" '; if($dashboard_clearance[$i] == 3) {echo 'selected';} echo '>Advantage</option>
												<option value="9" '; if($dashboard_clearance[$i] == 9) {echo 'selected';} echo '>Admin</option>
											</select>
										</div>
										<div class="box_cell noprint">
											<select class="select_action" name="select_action" id="action_'.$dashboard_user_id[$i].'" att="'.$dashboard_username[$i].'">
												<option value="" selected>Select an action...</option>
												<option value="send_mail">Mail user</option>
												<option value="delete_user">Delete user</option>
											</select>
										</div>
										<div class="delete_post_confirm" id="delete_post_confirm_'.$dashboard_user_id[$i].'" hidden>
											<div class="delete_post_container">
												<form action="" method="post" enctype="multipart/form-data" id="delete_post_form">
													<input type="file" name="file" class="delete_profile" id="delete_profile" hidden>
													<p id="are_you_delete">Are you sure you want to delete this post?</p>
													<p id="delete_'.$dashboard_user_id[$i].'" class="final_delete">Yes</p>
													<input type="hidden" name="post_display_id" value="'.$dashboard_user_id[$i].'"/> 
													<p id="cancel_delete_'.$i.'" class="cancel_delete">Cancel</p>
												</form>
											</div>
										</div>
									</div>
								';
								}?>
							</div>
						</div>
					</div>
				</div>

				<div id="side_tool_widget">
					<div class="side_tool_container">
						<p class="side_tool_title">Info</p>
						<p class="side_tool_text">Total users: <e class="side_tool_marked"><?php echo $total_users;?></e></p>
						<p class="side_tool_text">Activated users: <e class="side_tool_marked"><?php echo $total_active;?></e></p>
						<p class="side_tool_text"></p>
						<p class="side_tool_text">Discover users: <e class="side_tool_marked"><?php echo $total_discover;?></e></p>
						<p class="side_tool_text">Premium users: <e class="side_tool_marked"><?php echo $total_premium;?></e></p>
						<p class="side_tool_text">Advantage users: <e class="side_tool_marked"><?php echo $total_advantage;?></e></p>
						<p class="side_tool_text">Admin users: <e class="side_tool_marked"><?php echo $total_admin;?></e></p>
					</div>
					<div class="side_tool_container">
						<p class="side_tool_title">Actions</p>
						<p class="side_tool_text"><e id="print_all" class="side_tool_marked">Print</e></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		function sendEmail(mail){
			window.location = "mailto: " + mail;
		}
		//change subs
		$(".select_subscription").change(function(){
			ID = $(this).attr('id');
			sid = ID.split("sub_");
			newID = sid[1];
			newValue = $('#'+ID).val();
			URL = 'includes/admin_change.php';
			dataString = 'newid=' + newID + '&newvalue=' + newValue + '&delete=false';
			$.ajax({
				type: "POST",
				url: URL,
				data: dataString,
				cache: false,
				success: function(){
					window.location.reload(true);
				}
			});
		});

		$(".cancel_delete").click(function(){
			$(".delete_post_confirm").hide();
		});

		//Mail, delete
		$(".select_action").change(function(){
			value = $(this).val();
			userMail = $(this).attr('att');
			if (value == 'send_mail') {
				sendEmail(userMail);
			} else if (value == 'delete_user'){
				ID2 = $(this).attr('id');
				sid2 = ID2.split("action_");
				newID2 = sid2[1];
				$("#delete_post_confirm_"+newID2).show();
				$("#delete_"+newID2).click(function(){
					URL = 'includes/admin_change.php';
					dataString = 'newid=' + newID2 + '&delete=true';
					$.ajax({
						type: "POST",
						url: URL,
						data: dataString,
						cache: false,
						success: function(){
							window.location.reload(true);
						}
					});
				});
			}
		});
		$(".cancel_delete").click(function(){
			$(".delete_post_confirm").hide();
		});

		//Print
		$('#print_all').click(function() {
			window.open('print_admin.php');
			return false;
		});
	</script>
</body>
</html>
<?php
}
?>