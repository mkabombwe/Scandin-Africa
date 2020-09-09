<?php
require_once 'core/init.php';
require_once 'core/buy-init.php';

if(isset($_POST['stripeToken'])) {

	$token = $_POST['stripeToken'];

	$customer = \Stripe\Customer::create(array(
		"source" => $token,
		"plan" => "SC-Advantage",
		"email" => $username)
	);

	if($stmt = $mysqli->prepare("UPDATE users SET clearance = 3 WHERE username = ?")){
		$stmt->bind_param('s', $session_user_id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($user_id);
		$stmt->fetch();
		$stmt->free_result();
		$stmt->close();
	}

	header('Location: thankyou.php');
	exit();
}