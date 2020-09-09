<?php
require_once 'core/init.php';
require_once 'core/buy-init.php';

if($stmt = $mysqli->prepare("UPDATE users SET clearance = 1 WHERE username = ?")){
	$stmt->bind_param('s', $session_user_id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($user_id);
	$stmt->fetch();
	$stmt->free_result();
	$stmt->close();
}
header('Location: main.php');
?>