<?php
	
	require_once('users.class.php');
	require_once('messages.class.php');
	
	session_start();
	
	$message = new Messages;
	
	$message->currentUser = $_SESSION['username'];
	
	$messages = $message->deleted();
	

	if(!$messages) echo 'Empty inbox';
	
	else{
		$output = '';
		
		foreach($messages as $m){
			// $mId      = (int)$m->id;
			$mToken      = $message::cleanner($m->token);
			$mSender     = $message::cleanner($m->sender);
			$mSenderName = $mSender; //$message::cleanner($m->senderName);
			$mRecever    = $message::cleanner($m->recever);
			$mObject     = stripslashes($message::cleanner($m->object));
			$mMessage    = stripslashes($message::cleanner(nl2br($m->message)));
			$mStatus     = (int)$m->status;
			$mDate       = $message::cleanner($m->date);
	
			
			$isNew       = ($mStatus == 1) ? 'new' : 'old';
			
			$att         = (!empty($m->attachments)) ? '<i class="fa fa-paperclip"></i>' : '';
			
			$output .= "<table class='msg old deleted'>";
				$output .= "<tr>";
					$output .= "<td class=''>";
						$output .= "<div class='msg-preview' data-preview='deleted' data-token='{$mToken}'>";
							$output .= "<p class='ellipsis'>From : <strong class='sender'>{$mSenderName}</strong><br></p>";
							$output .= "<time>{$mDate} {$att}</time><br>";
							$output .= "<p class='ellipsis'>{$mObject}</p>";
							$output .= "<p class='ellipsis fnormal'>{$mMessage}</p>";
						$output .= "</div>";
					$output .= "</td>";
				$output .= "</tr>";
			$output .= "</table>";
		}
		
		echo $output;
		
	}
?>
