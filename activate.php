<?php
require_once 'core/init.php';

if(isset($_GET['code'])){

	if($stmt = $mysqli->prepare('SELECT username FROM users WHERE unique_id = ? AND active = 0 LIMIT 1')){
		$stmt->bind_param('s', $_GET['code']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($un_user);
		$stmt->fetch();

		if($stmt = $mysqli->prepare('UPDATE users SET active = 1 WHERE unique_id = ? AND username = ? LIMIT 1')){
			$stmt->bind_param('ss', $_GET['code'], $un_user);
			$stmt->execute();
			if($stmt->affected_rows == 1){
				header('Location: index.php?sigup=completed');
			} else {
				header('Location: index.php?sigup=failed');
			}
		}
	}

} else {
	header('Location: index.php?sigup=failed');
}
?>