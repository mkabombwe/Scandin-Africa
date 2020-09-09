<?php
require_once 'core/init.php';
$display_message = '';
if (isset($_GET['message'])){
	if ($_GET['message'] == 'pass_reset_1') {
		$display_message1 = 'Confirmation mail sent';
		$display_message2 = 'An email confirmation mail has been sent to your mail. Please look in your spam folder, if you don\'t see it.';
	} else if ($_GET['message'] == 'pass_reset_2') {
		$display_message1 = 'Lorem';
		$display_message2 = 'Lorem';
	} else if ($_GET['message'] == 'pass_reset_3') {
		$display_message1 = 'New password sent';
		$display_message2 = 'An email with has been sent to you with a new password.';
	} else if ($_GET['message'] == 'pass_reset_4') {
		$display_message1 = 'An error occurred';
		$display_message2 = 'An error occurred during the process of change password. Please try again or contact support.';
	}
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Scandin-Africa | Signup completed</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body id="signup_body">
	<style>
		.login_input_container p{
			font-size: 1em;
			line-height: 25px;
			color: #FFF;
		}
	</style>
	<div class="form_container">
		<div class="signup_content first_container">
			<h1><?php echo $display_message1;?></h1>
			<div class="login_input_container">
				<p><?php echo $display_message2;?></p>
			</div>
			<div class="navigation_field_container">
				<a id="login" href="profile.php"><div id="next_link_1_1" class="next_button next_1">Back</div></a>
			</div>
		</div>
	</div>
</body>
</html>