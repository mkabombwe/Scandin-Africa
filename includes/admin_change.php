<?php
require_once '../core/init.php';

if(isset($_POST['newid']) && isset($_POST['newvalue']) && $_POST['delete'] == 'false') {
	$new_user_id = $_POST['newid'];
	$new_clearence = $_POST['newvalue'];

	if($stmt2 = $mysqli->prepare("UPDATE users SET clearance = ? WHERE user_id = ?")){
		$stmt2->bind_param('is', $new_clearence, $new_user_id);
		$stmt2->execute();
		$stmt2->free_result();
		$stmt2->close();
	}
}
if(isset($_POST['newid']) && $_POST['delete'] == 'true') {
	$new_user_id = $_POST['newid'];

	if($stmt2 = $mysqli->prepare("DELETE FROM users WHERE user_id = ?")){
		$stmt2->bind_param('s', $new_user_id);
		$stmt2->execute();
		$stmt2->free_result();
		$stmt2->close();
	}
}

