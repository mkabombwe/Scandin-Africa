<?php
require_once 'core/init.php';
	
	if($stmt = $mysqli->prepare("UPDATE users SET first_time = 1 WHERE username = ?")){
		$stmt->bind_param('s', $session_user_id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->fetch();
		$stmt->free_result();
		$stmt->close();
	}

	header('Location: profile.php');
	exit();