<?php
session_start();

require_once 'connect.php';
require_once 'functions.php';

date_default_timezone_set('Europe/Copenhagen');


$mysqli = new mysqli($serv, $serv_user, $serv_pass, $serv_db);

if (logged_in() === true) {
	if($stmt = $mysqli->prepare("SELECT profile_id FROM users WHERE username = ?")){
		$stmt->bind_param('s', $_SESSION['username']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($profile_id);
		$stmt->fetch();
		$stmt->free_result();
		$stmt->close();
	}
	if($stmt = $mysqli->prepare("SELECT user_id, username, f_name, l_name, companyname, profile_pic, cover_pic, position, country, bio, phone, sector, clearance, first_time FROM users WHERE username = ?")){
		$stmt->bind_param('s', $_SESSION['username']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($user_id, $username, $f_name, $l_name, $companyname, $profile_pic, $cover_pic, $position, $country, $bio, $phone, $sector, $clearance, $first_time);
		$stmt->fetch();
		$stmt->free_result();
		$stmt->close();
	}
	$session_user_id = $_SESSION['username'];
}
?>