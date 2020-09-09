<?php
require_once 'core/init.php';

$current_page = "settings";

if (!logged_in()) {
	//If not loggend in
	header('Location: logout.php');
} else {

	if ($_GET['user'] != $profile_id) {
		//If not set, redirects user to own page
		header('Location: settings.php?user='.$profile_id);
	}

	//Upload profile picture
	if (isset($_POST['profile_photo'])) {
		move_uploaded_file($_FILES['file']['tmp_name'], "img/profile/" . $_FILES['file']['name']);
		try {
			$stmt = $mysqli->prepare("UPDATE users SET profile_pic = 'img/profile/". $_FILES['file']['name']."' WHERE username = ?");
			$lol = $session_user_id;
			$stmt->bind_param('s', $lol);
			$stmt->execute();
			$stmt->fetch();
			$stmt->free_result();
			$stmt->close();

			header('Location: settings.php');
			exit();
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	//submit basic info
	if (isset($_POST['submit_settings'])) {
		
		$sql = "UPDATE users SET 
					companyname = ?,
					f_name = ?,
					l_name = ?,
					position = ?,
					country = ?,
					phone = ?,
					sector = ?,
					bio = ?,
					catagory = ? 
					WHERE username = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("ssssssssis", $v1, $v2, $v3, $v4, $v5, $v6, $v7, $v8, $v9, $v10);

		$v1 = ''.$_POST['companyname'].'';
		$v2 = ''.$_POST['f_name'].'';
		$v3 = ''.$_POST['l_name'].'';
		$v4 = ''.$_POST['position'].'';
		$v5 = ''.$_POST['country'].'';
		$v6 = ''.$_POST['phone'].'';
		$v7 = ''.$_POST['sector'].'';
		$v8 = ''.nl2br(htmlentities($_POST['bio'])).'';

		if ($_POST['country'] == "Denmark" ||
			$_POST['country'] == "Norway" ||
			$_POST['country'] == "Sweden" ||
			$_POST['country'] == "Finland" ||
			$_POST['country'] == "Iceland"
			) {
			$v9 = 1;
		} else {
			$v9 = 2;
		}

		$v10 = $session_user_id;
		
		$stmt->execute();
		$stmt->close();

		header('Location: settings.php');
		exit();

	}

	//change password
	if (isset($_POST['submit_pass'])) {
		$password = $_POST['current_password'];
		$change_pass = login($username, $password, $mysqli);
		if ($change_pass === true && empty($_POST['new_password']) === false && empty($_POST['re-password']) === false) {
			if ($_POST['new_password'] === $_POST['re-password']) {
				if (strlen($_POST['new_password']) < 5 || strlen($_POST['new_password']) >= 32) {
					echo "Your password must have a minimum 5 characters and maximum 32 characters";
				} else {
					$pid = random_string(32);
					$salt = random_string(128);
					$options = [
					  'cost' => 12,
					  'salt' => $salt,
					];
					$pre_psd = password_hash(trim($_POST['new_password']), PASSWORD_BCRYPT, $options);
					$fin_psd = openssl_digest($pre_psd, 'sha512');

					if($stmt = $mysqli->prepare("UPDATE users SET password = '".$fin_psd."', salt = '".$salt."' WHERE username = ?")){
							
						$stmt->bind_param('s', $session_user_id);

						$stmt->execute();
						$stmt->store_result();
						$stmt->fetch();
						$stmt->free_result();
						$stmt->close();

						include_once 'includes/pass_changed.php';
						header('Location: settings.php');
						exit();
					}
				}
			} else {
				echo "password and re-password does not match";
			}
		} else {
			echo "You're password is wrong";
		}
	}

	//Deactivate account
	if (isset($_POST['profile_delete_profile'])) {
		if($stmt = $mysqli->prepare("UPDATE users SET online = 0, active = 0 WHERE username = ?")){
			$stmt->bind_param('s', $session_user_id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->fetch();
			$stmt->free_result();
			$stmt->close();
		}

		unset($_SESSION['username'], $_SESSION['timestamp']);

		session_unset();
		session_destroy();

		header('Location: index.php');
	    exit;
	}

	if($stmt = $mysqli->prepare("SELECT user_id, profile_pic FROM users WHERE username = ?")){
		$stmt->bind_param('s', $session_user_id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($user_id, $top_profile_pic);
		$stmt->fetch();
		$stmt->free_result();
		$stmt->close();
	}
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Scandin-Africa | Settings</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/profile_new.css">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body id="profile_body">
	<div id="profile_wrapper">
<?php include("includes/menubar_new.php"); ?>
		<div id="profile_container_outter">
			<div id="profile_container_inner">
				<?php include("includes/menu_left.php"); ?>
				<div id="wrapper">
					<div id="top_content">
						<!-- user pic -->
						<div id="top_content_left">
							<div id="top_image_container">
								<img src="<?php echo $profile_pic; ?>" width="100%">
							</div>
							<?php if ($_GET['user'] == $profile_id) {?>
							<div id="change_profile_button"><p>Change picture</p></div>
							<!-- change user -->
							<div id="change_profile" hidden>
								<div class="change_profile">
								<form action="" method="post" enctype="multipart/form-data" id="change_profile_form">
									<input type="file" name="file" class="press_profile" id="press_profile" hidden>
									<p id="are_you">Are you sure you want to change your profile picture?</p>
									<input class="submit_profile" type="submit" name="profile_photo" id="final_submit_photo">
									<p id="cancel_pic">Cancel</p>
								</form>
								</div>
							</div>
							<script>
							$("#change_profile_button").click(function() {
								$(".press_profile").click();
								$("#change_profile").show();
							});
							$("#cancel_pic").click(function() {
								$("#change_profile").hide();
							});
							</script>
							<?php } 
							if ($clearance == 0 || $clearance == 1) {?>
							<a href="premium.php"><div id="premium_badge1"><p>Discover</p></div></a>
							<?php } else if ($clearance == 2) {?>
							<a href="premium.php"><div id="premium_badge4"><p>Premium</p></div></a>
							<?php } else if ($clearance == 3) {?>
							<a href="premium.php"><div id="premium_badge2"><p>Advantage</p></div></a>
							<?php } else if ($clearance == 9){?>
							<a href="premium.php"><div id="premium_badge3"><p>Admin</p></div></a>
							<?php }?>
							<?php if ($_GET['user'] != $profile_id){
							echo '
								<a href="mailbox.php" class="mail_lightbox_trigger">
									<div id="premium_badge3">
										<p><i class="fa fa-enveloppe"></i> Send message</p>
									</div>
								</a>
							'; }?>
						</div>


						<!-- user info -->
						<div id="top_content_right">
							<p id="top_name" class="top"><?php echo htmlentities($f_name);?>&nbsp;<?php echo htmlentities($l_name);?></p>
							<div id="top_bio">
								<p><?php echo $bio;?></p>
							</div>
						</div>
					</div>
					<div id="right_container">
						<div class="post">
							<!-- Change settings -->
							<div id="post_info_basic">
								<p>Basic info</p>
								<form action="" method="POST">
									<input class="settings_input" type="text" name="companyname" placeholder="Company name" value="<?php echo htmlentities($companyname);?>">
									<input class="settings_input" type="text" name="f_name" placeholder="First name" value="<?php echo htmlentities($f_name);?>">
									<input class="settings_input" type="text" name="l_name" placeholder="Last name" value="<?php echo htmlentities($l_name);?>">
									<input class="settings_input" type="text" name="position" placeholder="Position" value="<?php echo htmlentities($position);?>">
									<select class="settings_select" name="country">
										
										<option <?php if ($country == "") { ?> selected <?php };?> value="" disabled>Select your sector</option>
										<?php 
											foreach ($every_country as $key) {
												echo '
												<option '; if ($country == $key) {echo 'selected';} echo ' value="'.$key.'">'.$key.'</option>
												';
											}
										?>

									</select>
									<input class="settings_input" type="text" name="phone" placeholder="Number (+45...)" value="<?php echo htmlentities($phone);?>">
									<select class="settings_select" name="sector">
										<option <?php if ($sector == "") { ?> selected <?php };?> value="" disabled>Select your sector</option>
										<?php 
											foreach ($every_sector as $key) {
												echo '
												<option '; if ($sector == $key) {echo 'selected';} echo ' value="'.$key.'">'.$key.'</option>
												';
											}
										?>
									</select>
									<textarea name="bio"><?php echo preg_replace('#<br[/\s]*>#si', "\n", $bio);?></textarea>
									<input type="submit" name="submit_settings" value="Update">
								</form>
							</div>
						</div>
						<div class="post">
							<div id="post_info_pass">
								<p>Change password</p>
								<form action="" method="POST">
									<input class="settings_input" type="password" name="current_password" placeholder="Current password">
									<input class="settings_input" type="password" name="new_password" placeholder="New password">
									<input class="settings_input" type="password" name="re-password" placeholder="Re-enter new password">
									<input type="submit" name="submit_pass" id="submit_pass" value="Update">
								</form>
							</div>
						</div>
						<div class="post">
							<div id="post_info_mail">
								<p>Change email</p>
								<form action="" method="POST">
									<input class="settings_input" type="email" name="current_email" placeholder="Current email">
									<input class="settings_input" type="email" name="new_email" placeholder="New email">
									<input class="settings_input" type="email" name="re_new_email" placeholder="Re-enter new email">
									<input type="submit" name="submit_email" id="submit_email" value="Update">
								</form>
							</div>
						</div>
						<div class="post">
							<div id="post_deactivate_account">
								<p>Deactivate account</p>
								<input type="button" id="deactivate_button" value="Deactivate">
							</div>
							<div id="delete_profile" hidden>
								<div class="delete_profile">
									<form action="" method="post" enctype="multipart/form-data" id="delete_profile_form">
										<input type="file" name="file" class="press_delete_profile" id="press_delete_profile" hidden>
										<p class="are_you">Are you sure you want to deactivate your account? You wont be able to use it again once deactivated.</p>
										<input class="submit_delete_profile" type="submit" name="profile_delete_profile" id="final_delete_profile" value="Yes">
										<p id="cancel_delete_account">Cancel</p>
									</form>
								</div>
								<script>
									$("#deactivate_button").click(function() {
										$("#delete_profile").show();
									});
									$("#cancel_delete_account").click(function() {
										$("#delete_profile").hide();
									});
								</script>
							</div>
						</div>
					</div>
				</div>
				<div id="side_tool_widget">
					<div class="side_tool_container">
						<p class="side_tool_title">About</p>
						<p class="side_tool_text"><e class="side_tool_marked"><?php echo htmlentities($position);?></e> at <e class="side_tool_marked"><?php echo htmlentities($companyname);?></e></p>
						<p class="side_tool_text">Located in <e class="side_tool_marked"><?php echo htmlentities($country);?></e></p>
						<p class="side_tool_text side_tool_mail">Mail: <e class="side_tool_marked"><?php echo htmlentities($username);?></e></p>
						<?php if (!empty($phone)) {echo '<p class="side_tool_text">Phone: <e class="side_tool_marked">'.$phone.'</e></p>';}?>
					</div>
				</div>
			</div>
		</div>	
	</div>
</body>
</html>
<?php
}
?>