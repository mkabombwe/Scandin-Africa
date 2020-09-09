<?php
require_once 'core/init.php';

if($stmt = $mysqli->prepare("UPDATE users SET online = 0 WHERE username = ?")){
	$stmt->bind_param('s', $session_user_id);
	$stmt->execute();
	$stmt->store_result();
	$stmt->fetch();
	$stmt->free_result();
	$stmt->close();
}

unset($_SESSION['username'], $_SESSION['timestamp']);

session_unset();
session_destroy();

header('Location: index.php');