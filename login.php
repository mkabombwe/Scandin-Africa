<?php
require_once 'core/init.php';
require_once 'mailbox/users.class.php';

if (logged_in()) {
	header('Location: main.php');
}

$error1 = "";
$error2 = "";
$error3 = "";
$error4 = "";

if (empty($_POST) === false) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	if (empty($username) === true || empty($password) === true) {
		$error1 = "Username/password is required";
	} else if (user_exists($username, $mysqli) == 0) {
		$error2 = "This account does not exist";
	} else if (user_active($username, $mysqli) == 0) {
		$error3 = "This account is not active or hasn't been activated yet";
	} else {
		$login = login($username, $password, $mysqli);
		if ($login === true) {
			//set session and and time
			$_SESSION['username'] = $username;
			$_SESSION['timestamp'] = time();

			//set user as online
			if($stmt = $mysqli->prepare("UPDATE users SET online = 1 WHERE username = ?")){
				$stmt->bind_param('s', $username);
				$stmt->execute();
				$stmt->store_result();
				$stmt->fetch();
				$stmt->free_result();
				$stmt->close();
				header('Location: main.php');
				exit();
			}
		} else {
			$error4 = "Login is not correct";
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
		<form action="" method="post" autocomplete="on">
			<div class="signup_content first_container">
				<h1>Login</h1>
				<div class="signup_input_container">
					<input type="email" name="username" id="username" placeholder="Email" class="input_field">
					<div class="input_info"><p hidden>Email or password is wrong</p></div>
				</div>
				<div class="signup_input_container">
					<input type="password" name="password" id="password" placeholder="Password" class="input_field">
					<div class="input_info"></div>
				</div>
				<div class="navigation_field_container">
					<a id="login"><div id="next_link_1_1" class="next_button next_1">Login</div></a>
				</div>
				<div class="login_input_container">
					<p><a href="signup.php">Not a member?&#160;&#160;<e style="font-weight:600;">Sign up</e></a></p>
					<p><a href="reset_pass.php">Forgot your password?&#160;&#160;<e style="font-weight:600;">Request new password</e></a></p>
				</div>
			</div>
			<input class="submit_botton" type="submit" id="log_in" hidden>
		</form>
	</div>
	<script src="js/jquery.js"></script>
	<script>
		$('#login').click(function() {
			$('#log_in').click();
		});
		$('.signup_content').keypress(function (e) {
			var key = e.which;
			if(key == 13)  // the enter key code
			{
				$('#log_in').click();
				return false;
			}
		}); 
	</script>
</body>
</html>