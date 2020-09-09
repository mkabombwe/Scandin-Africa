<?php
	
	require_once('users.class.php');
	require_once('messages.class.php');
	
	session_start();

	if(isset($_POST)){
	    $r    = array(); 
	    $r[0] = 0;
	    $message = new messages();
		$mtoken = $_POST['token'];

        $message->currentUser = $_SESSION['user']->user_id;
    
    	$operat = $message->asRead($message::cleanner($mtoken, true));
 
		
		if($operat){
			$r[0] = 1;
			$r[1] = 'Your message has been mark as read';
		}else $r[1] = 'An error occurred , please try again later.';
		
		echo json_encode($r);
	}
	
	