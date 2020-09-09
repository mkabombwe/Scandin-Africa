<?php
require_once 'core/init.php';

if(isset($_GET['code'])){

	if($stmt = $mysqli->prepare('SELECT username FROM users WHERE reset_password = ? LIMIT 1')){
		$stmt->bind_param('s', $_GET['code']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($username);
		$stmt->fetch();

		$salt = random_string(128);
		$psd = random_string(8);
		$options = [
			'cost' => 12,
			'salt' => $salt,
		];
		$pre_psd = password_hash(trim($psd), PASSWORD_BCRYPT, $options);
		$fin_psd = openssl_digest($pre_psd, 'sha512');

		if($stmt = $mysqli->prepare('UPDATE users SET password = ?, salt = ? WHERE username = ? LIMIT 1')){
			$stmt->bind_param('sss', $fin_psd, $salt, $username);
			$stmt->execute();
			if($stmt->affected_rows == 1){
				include_once 'includes/pass_changed.php';
				header('Location: confirm_message1.php?message=pass_reset_3');
			} else {
				header('Location: confirm_message1.php?message=pass_reset_4');
			}
		}
	}

} else {
	header('Location: index.php?reset_password_failed');
}
?>