<?php
require_once 'core/init.php';
require_once 'core/buy-init.php';
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Scandin-Africa | Signup Failed</title>
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
			<h1>Signup failed</h1>
			<div class="login_input_container">
				<p>Signup failed. Please try again.</p>
			</div>
			<div class="navigation_field_container" style="padding: 10px 0;">
				<a id="login" href="index.php"><div id="next_link_1_1" class="next_button next_1">Main page</div></a>
			</div>
			<div class="navigation_field_container">
				<a id="login" href="signup.php"><div id="next_link_1_1" class="next_button next_1">Try again</div></a>
			</div>
		</div>
	</div>
</body>
</html>