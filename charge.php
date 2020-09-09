<?php
require_once 'core/init.php';
require_once 'core/buy-init.php';

if(isset($_POST['stripeToken'])) {

	$token = $_POST['stripeToken'];

	try {
		\Stripe\Charge::create([
		  "amount" => 4000000,
		  "currency" => "dkk",
		  "source" => $token,
		  "description" => "Charge for tier 1"
		]);

		if($stmt = $mysqli->prepare("UPDATE users SET clearance = 1 WHERE username = ?")){
			$stmt->bind_param('s', $session_user_id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($user_id);
			$stmt->fetch();
			$stmt->free_result();
			$stmt->close();
		}

	} catch(Stripe_CardError $e) {
		echo "An error occurred";
	}

	header('Location: profile.php');
	exit();
}