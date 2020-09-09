<?php
	
	require_once('users.class.php');
	require_once('messages.class.php');
	
	session_start();

	// var_dump($_POST);
	// exit;
	
	if(isset($_POST)){
	    $r    = array(); 
	    $r[0] = 0;
	    $message = new messages();
		$mtokens = $_POST;

        $message->currentUser = $_SESSION['username']; //$_SESSION['user']->user_id;
		
    	foreach ($mtokens as $key => $mtoken) {
    		$operat = $message->mDelete($message::cleanner($mtoken, true));
			// var_dump($mtoken);
    	}
		
		
		if($operat){
			$r[0] = 1;
			$r[1] = 'Your message has been deleted';
		}else $r[1] = 'An error occurred while delete the message, please try again later.';
		
		echo json_encode($r);
	}
	
	