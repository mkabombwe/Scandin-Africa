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
	
	if(empty($token)){
		$r[1] = 'Missing the message recipient';
	}else{
		$message->currentUser = $_SESSION['username'];
		$message->token       = $token;
		$message->parentToken = $mtoken;
		$message->sender      = $message->currentUser;
		$message->senderName  = $_SESSION['user']->username;
		$message->recever     = $mrecever;
		$message->receverName = '';
		$message->object      = (!empty($mtoken)) ? 'Re : '.$mobject : $mobject;
		$message->message     = $msgText;
		$message->draft       = 1;
		$message->date        = date('Y-m-d h:i a');
		
		if(!empty($message->currentUser)) $envoi = $message->send(true);
		
		if($envoi){
			$r[0] = 1;
			$r[1] = 'Your message has been autosaved';
		}else $r[1] = 'An error occurred while saving the message, please try again later.';
		
	}
	
	echo json_encode($r);