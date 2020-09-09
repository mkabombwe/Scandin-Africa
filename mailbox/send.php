<?php
	
	require_once('users.class.php');
	require_once('messages.class.php');
	
	session_start();
	
	$r    = array(); // tableau qui sera renvoyé comme réponse
	$r[0] = 0;
	$mtoken = "";
	$message = new Messages;
	
	$token    = $message::cleanner($_POST['token'], true);
	$mtoken   = $message::cleanner($_POST['mtoken'], true);
	$mobject  = $message::cleanner($_POST['mobject'], true);
	$mrecever = $message::cleanner($_POST['mrecever'], true);
	$msgText  = $message::cleanner($_POST['message'], true);
	
	if(empty($mrecever)){
		$r[1] = 'Missing the message recipient email address';
	}elseif(!$message::isValidEmail($mrecever)){
		$r[1] = 'Invalid email address';
	}elseif(empty($message)){
		$r[1] = 'The message is empty';
	}else{
		$message->currentUser = $_SESSION['username'];
		$message->token       = (empty($token)) ? crypt('hwyethdnsbcgdferyr874h43',md5('token-'.uniqid())) : $token;
		$message->parentToken = $mtoken;
		$message->sender      = $message->currentUser;
		$message->senderName  = $message->sender;
		$message->recever     = $mrecever;
		$message->receverName = '';
		$message->object      = (!empty($mtoken)) ? 'Re : '.$mobject : $mobject;
		$message->message     = $msgText;
		$message->date        = date('Y-m-d h:i a');
		
		$envoi = $message->send();
		
		if($envoi){
			$r[0] = 1;
			$r[1] = 'Your message has been sent';
			$r[2] = crypt('hwyethdnsbcgdferyr874h43',md5('token-'.uniqid()));
		}else $r[1] = 'An error occurred while sending the message, please try again later.';
		
	}
	
	echo json_encode($r);