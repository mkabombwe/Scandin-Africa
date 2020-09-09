<?php
require_once 'core/init.php';

if (logged_in()) {
	header('Location: main.php');
}


$error1 = "";
$error2 = "";
$error3 = "";
$error4 = "";

if (empty($_POST) === false) {


	$usn = strtolower(trim($_POST['username']));
	$psd = $_POST['password'];
	$fna = $_POST['f_name'];
	$lna = $_POST['l_name'];
	$cpn = $_POST['companyname'];
	$pos = $_POST['position'];
	$cou = $_POST['country'];
	$sec = $_POST['sector'];

	if (filter_var($usn, FILTER_VALIDATE_EMAIL)) {
		if (empty($usn) ||
			empty($psd) ||
			empty($fna) ||
			empty($lna) ||
			empty($cpn) || 
			empty($pos) ||
			empty($cou) ||
			empty($sec)) {
			$error1 = "All fields with * are required";
		} else if (user_exists($usn, $mysqli) == 1) {
			$error2 = "This email is already taken";
		} else if (user_active($usn, $mysqli) == 1) {
			$error2 = "This email is already taken";
		} else if (strlen($psd) < 5 || strlen($psd) >= 32) {
			$error3 = "Your password must have a minimum 5 characters and maximum 32 characters";
		} else {
			if (isset($_POST['username'])) {
				if ($cou == "Denmark" ||
					$cou == "Norway" ||
					$cou == "Sweden" ||
					$cou == "Finland" ||
					$cou == "Iceland"
					) {
					$cat = 1;
				} else {
					$cat = 2;
				}

				$pid = random_string(32);
				$unique = random_string(64);
				$salt = random_string(128);
				$reset_pass = random_string(32);
				$options = [
				  'cost' => 12,
				  'salt' => $salt,
				];
				$pre_psd = password_hash(trim($psd), PASSWORD_BCRYPT, $options);
				$fin_psd = openssl_digest($pre_psd, 'sha512');
				$joined = date("Y-m-d H:i:s");
				$sql = "INSERT INTO users (profile_id, username, password, reset_password, salt, f_name, l_name, companyname, joined, unique_id, position, country, sector, catagory) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				if($stmt = $mysqli->prepare($sql)){
					$stmt->bind_param('sssssssssssssi', $pid, $usn, $fin_psd, $reset_pass, $salt, $fna, $lna, $cpn, $joined, $unique, $pos, $cou, $sec, $cat);
					$stmt->execute();
					include_once 'includes/signup_mail.php';
					header('Location: signup_completed.php');	
				} else {
					header('Location: signup_failed.php');
				}
			} else {
				$error1 = "You must agree to the Terms and Conditions";
			}

		}
	} else {
		$error1 = "Please fill in all the fields an use a valid email adress";
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
	<div id="signup_container">
		<div id="signup_container_inner">
			<form action="" method="post">
<!-- DIV 1 -->
				<div id="your_self" class="signup_content_container">
					<div class="signup_content first_container">
						<h1>Tell us about yourself</h1>
						<div class="signup_input_container">
							<input type="email" name="username" id="username" placeholder="Email adress" class="input_field">
							<div class="input_info"><p id="username_p" hidden>This email is already taken</p></div>
						</div>
						<div class="signup_input_container">
							<input type="text" name="f_name" id="f_name" placeholder="First name" class="input_field">
							<div class="input_info"><p hidden>ex John</p></div>
						</div>
						<div class="signup_input_container">
							<input type="text" name="l_name" id="l_name" placeholder="Last name" class="input_field">
							<div class="input_info"><p hidden>ex Doe</p></div>
						</div>
						<div class="signup_input_container">
							<input type="password" name="password" id="password" placeholder="Create password" class="input_field">
							<div class="input_info"><p id="password_p" hidden>The password must be at least 5 charecters long</p></div>
						</div>

						<div class="navigation_field_container">
							<a href="#your_company" id="next_link_1" class="disabled"><div id="next_link_1_1" class="next_button next_1 disabled">Next</div></a>
						</div>
					</div>
				</div>
<!-- DIV 2 -->
				<div id="your_company" class="signup_content_container">
					<div class="signup_content">
						<h1>Tell us abouy your company</h1>
						
						<div class="signup_input_container">
							<input type="text" name="companyname" id="companyname" placeholder="Company name" class="input_field">
							<div class="input_info"><p hidden>Lorem ipsum</p></div>
						</div>
						<div class="signup_input_container">
							<input type="text" name="position" id="position" placeholder="Your position" class="input_field">
							<div class="input_info"><p hidden>What is your position inside your business? Ex. CEO, Founder</p></div>
						</div>
						<div class="signup_input_container">
							<select name="country" id="country" class="input_field">
								<option value="" disabled selected>Click to select your location</option>
								<?php foreach ($every_country as $key) {
									echo '
										<option value="'.$key.'">'.$key.'</option>
									';
								}
								?>
							</select>
							<div class="input_info"><p hidden>In which country is your business located?</p></div>
						</div>
						<div class="signup_input_container">
							<select name="sector" id="sector" class="input_field">
								<option value="" disabled selected>Click to select business sector</option>
								<?php 
									foreach ($every_sector as $key) {
										echo '
										<option value="'.$key.'">'.$key.'</option>
										';
									}
								?>
							</select>
							<div class="input_info"><p hidden>Which sector catagorises your business?</p></div>
						</div>

						<div class="navigation_field_container">
							<a href="#your_self"><div class="next_button next_2">Back</div></a>
							<a class="disabled" id="next_link_2"><div class="next_button next_2 disabled" id="next_link_2_1">Complete</div></a>
						</div>
						<div class="login_input_container_signup"><e>By clicking "Finish" you agree to the Scandin-Africa <a href="">Terms of Services</a> and <a href="">Privacy Policy</a>.</e></div>
					</div>

				</div>
				<input type="submit" value="sign up" id="sign_up" hidden>
<!-- scripts -->
			</form>
		</div>
	</div>
	
	<script src="js/jquery.js"></script>
	<script>
		$('.input_field').on('keyup keydown keypress change paste', function() {
			//Page one
			if ( !$('#username').val() ||
				 !$('#f_name').val() ||
				 !$('#l_name').val() ||
				 $('#password').val().length < 5 )
			{
				$('#next_link_1').addClass('disabled');
				$('#next_link_1_1').addClass('disabled');
			} else {
				$('#next_link_1').removeClass('disabled');
				$('#next_link_1_1').removeClass('disabled');
			}

			//Page two
			if ( !$('#username').val() ||
				 !$('#f_name').val() ||
				 !$('#l_name').val() ||
				 $('#password').val().length < 5 ||
				 !$('#companyname').val() ||
				 !$('#position').val() ||
				 !$('#country').val() ||
				 !$('#sector').val() )
			{
				$('#next_link_2').addClass('disabled');
				$('#next_link_2_1').addClass('disabled');
			} else {
				$('#next_link_2').removeClass('disabled');
				$('#next_link_2_1').removeClass('disabled');
			}

			 if($('#username').val().length > 3){
			 	check_availability();
			 }

			 if($("#password").val().length > 1 && $("#password").val().length < 5){
			 	$('#password_p').show();
			 } else {
			 	$('#password_p').hide();
			 }
		});

		//check username
		function check_availability(){
			
			var username = $('#username').val();

			//use ajax to run the check
			$.post("includes/check_username.php", { username: username },
			function(result){
				if(result == 1){
					$('#username_p').show();
					$('#next_link_1').addClass('disabled');
					$('#next_link_1_1').addClass('disabled');
				} else {
					$('#username_p').hide();
				}
			});
		}

		//Complete form
		if ($('next_link_2').hasClass('disabled')) {
			//
		} else {
			$('#next_link_2').click(function() {
				$('#sign_up').click();
			});
		}


	</script>
</body>
</html>