<?php
require_once 'core/init.php';
require_once 'core/buy-init.php';
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Scandin-Africa | Purchase complete</title>
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
			<h1>Take for your purchase</h1>
			<div class="login_input_container">
			<p style="text-align: center;">You'll be redirected in 5 seconds.<br/>If not, click on the <e style="font-weight:600">back</e> button.</p>
			</div>
			<div class="navigation_field_container">
				<a id="login" href="profile.php"><div id="next_link_1_1" class="next_button next_1">Back</div></a>
			</div>
		</div>
	</div>
	<script>
		$( document ).ready(function() {
			//window.location = url;
			setTimeout(function(){ 
				window.location='profile.php'; 
			}, 5000);
		});
	</script>
</body>
</html>