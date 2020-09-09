<?php
require_once 'core/init.php';
require_once 'core/buy-init.php';
$current_page = "profile";

if (!logged_in()) {
	//If not loggend in
	header('Location: logout.php');
}
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Scandin-Africa | Premium</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/premium.css">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body id="premium_body">
	<div id="premium_wrapper">
<?php 	// Get user_id
		if($stmt = $mysqli->prepare("SELECT user_id, profile_pic FROM users WHERE username = ?")){
			$stmt->bind_param('s', $session_user_id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($user_id, $top_profile_pic);
			$stmt->fetch();
			$stmt->free_result();
			$stmt->close();
		}
		include("includes/menubar_new.php");
?>
		<div id="premium_container_outter">
			<div id="premium_container_inner">
				<div id="wrapper">
					<div id="pricing">
						<div class="pricing_container">
							<h1 class="hidden1">Start your subscription now</h1>
							<div class="pricing_box hidden1">
								<div class="pricing_box_top">
									<p>Discover</p>
								</div>
								<div class="pricing_box_middle">
									<p id="pricing_box_title1">free</p>
								</div>
								<div class="pricing_box_bottom">
									<p>Upload opportunities</p>
								</div>
								<div class="pricing_box_button" id="get_discover">
									<a href="charge1.php"><p>Get Discover</p></a>
								</div>
							</div>

							<div class="pricing_box hidden1">
								<div class="pricing_box_top">
									<p>Premium</p>
								</div>
								<div class="pricing_box_middle">
									<p id="pricing_box_title2">149€/trimester</p>
								</div>
								<div class="pricing_box_bottom">
									<p>Upload opportunities</p>
									<p>Find new customers</p>
									<p>Find target groups</p>
									<p>Reach decision-makers</p>
									<p>Matching</p>
								</div>
								<div class="pricing_box_button" id="get_premium">
									<p>Get Premium</p>
								</div>
							</div>

							<div class="pricing_box hidden1">
								<div class="pricing_box_top">
									<p>Advantage</p>
								</div>
								<div class="pricing_box_middle">
									<p id="pricing_box_title3">From 299€/trimester</p>
								</div>
								<div class="pricing_box_bottom">
									<p>Upload opportunities</p>
									<p>Find new customers</p>
									<p>Find target groups</p>
									<p>Reach decision-makers</p>
									<p>Matching</p>
									<p>Advertising</p>
									<p>Leads Marketing</p>
									<p>Statistics and Report</p>
								</div>
								<div class="pricing_box_button" id="get_advantage">
									<p>Get Advantage</p>
								</div>
							</div>
						</div>
					</div>
					<div id="forms_container" hidden>
						<form id="form1" action="charge2.php" method="POST">
							<script
								src="https://checkout.stripe.com/checkout.js" class="stripe-button"
								data-key="<?php echo $stripe['publishable']; ?>"
								data-name="Scandin-Africa"
								data-description="Get Premium (149€/trimester)"
								data-email="<?php echo $username; ?>";
								data-panel-label="Subscribe"
								data-label="Subscribe"
								data-currency="eur"
								data-amount="14900"
								data-allow-remember-me="false">
							</script>
						</form>
						<form id="form2" action="charge3.php" method="POST">
							<script
								src="https://checkout.stripe.com/checkout.js" class="stripe-button"
							  	data-key="<?php echo $stripe['publishable']; ?>"
							    data-name="Scandin-Africa"
							    data-description="Get Advantage (299€/trimester)"
							    data-email="<?php echo $username; ?>";
							    data-panel-label="Subscribe"
							    data-label="Subscribe"
							    data-currency="eur"
							    data-amount="29900"
							    data-allow-remember-me="false">
							</script>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		$('#get_premium').click(function(){
			$('#form1 span').click();
		});
		$('#get_advantage').click(function(){
			$('#form2 span').click();
		});
	</script>
</body>
</html>