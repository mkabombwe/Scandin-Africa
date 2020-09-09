<?php
require_once 'core/init.php';

if (logged_in()) {
	header('Location: main.php');
}

$error1 = "";

if (empty($_POST) === false) {
	$email = $_POST['email'];
	if (empty($email) === true) {
		$error1 = "Username/password is required";
	} else if (user_exists($email, $mysqli) == 0) {
		$error1 = "This account does not exist";
	} else if (user_active($email, $mysqli) == 0) {
		$error1 = "This account is not active or hasn't been activated yet";
	} else {
		if($stmt = $mysqli->prepare("SELECT reset_password FROM users WHERE username = ? LIMIT 1")){
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($code);
			$stmt->fetch();
			include_once 'includes/pass_inform.php';
			$stmt->free_result();
			$stmt->close();
			header('Location: confirm_message1.php?message=pass_reset_1');
			exit();
		}
	}
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Scandin-Africa | Sign Up</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body id="signup_body">
	<div class="form_container">
		<form action="" method="post">
			<div class="signup_content first_container">
				<h1>Reset Password</h1>
				<div class="signup_input_container">
					<input type="email" name="email" id="username" placeholder="Email" class="input_field">
					<div class="input_info"><p hidden>Email or password is wrong</p></div>
				</div>
				<div class="navigation_field_container">
					<a id="login"><div id="next_link_1_1" class="next_button next_1">Request password</div></a>
				</div>
				<div class="login_input_container">
					<p><a href="login.php">Know your password?&#160;&#160;<e style="font-weight:600;">Sign in</e></a></p>
					<p><a href="signup.php">Not a member?&#160;&#160;<e style="font-weight:600;">Sign up</e></a></p>
				</div>
			</div>
			<input class="submit_botton" type="submit" value="new_password" id="request" hidden>
		</form>
	</div>
	<script>
		$('#login').click(function() {
			$('#request').click();
		});
		$('.signup_content').keypress(function (e) {
			var key = e.which;
			if(key == 13)  // the enter key code
			{
				$('#request').click();
				return false;
			}
		}); 
	</script>
</body>
</html>