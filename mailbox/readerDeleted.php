<?php
	
	require_once('users.class.php');
	require_once('messages.class.php');
	
	session_start();
	
	$message = new Messages;
	
	$message->currentUser = $_SESSION['user']->user_id;
	$message->token       = $_GET['token'];
	
	$messages = $message->read();
	
	if(!$messages) echo 'Message not found';
	
	else{
		$output = '';
		$m = $messages;
		
			$mToken      = $message::cleanner($m->token);
			$mSender     = $message::cleanner($m->sender);
			$mSenderName = $mSender; //$message::cleanner($m->senderName);
			$mRecever    = $message::cleanner($m->recever);
			$mObject     = $message::cleanner($m->object);
			$mMessage    = $message::cleanner(nl2br($m->message));
			$mStatus     = (int)$m->status;
			$mDate       = $message::cleanner($m->date);
			$mDeleted    = $message::cleanner($m->deleted);
			
			$isNew       = ($mStatus == 1) ? 'new' : 'old';
			
			$output .= "<div class='read'>";
			$output .= "<h3 class='m-object'>{$mObject}</h3><br>";
			
			$output .= "From : <strong class='sender'>{$mSenderName}</strong>  - ";
			$output .= "<time>{$mDate}</time>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			
            if($m->attachments != null) $output .= "&nbsp;&nbsp;<i class='fa fa-paperclip'></i>";
			$output .= "<br><br>";
			$output .= "<p>{$mMessage}</p><hr>";
			if($m->attachments != null){
				$output .= "&nbsp;&nbsp;<i class='fa fa-paperclip'></i>&nbsp;&nbsp;&nbsp;&nbsp;";
				
				if(!is_array($m->attachments)){
					if($m->attachments->type == 'image/jpeg' or $m->attachments->type == 'image/png' or $m->attachments->type == 'image/gif') 
						$output .= "<a href='attachments/{$m->attachments->path}' class='lightbox_trigger' targ='_blank'><img src='attachments/{$m->attachments->path}' class='att-preview' alt='' /></a> ";
					else
						$output .= "<a href='attachments/{$m->attachments->path}' class='lightbox_trigger' targ='_blank'>{$m->attachments->path}</a>";
				}else{
					foreach($m->attachments as $att){
						if($att->type == 'image/jpeg' or $att->type == 'image/png' or $att->type == 'image/gif') 
							$output .= "<a href='attachments/{$att->path}' class='lightbox_trigger' targ='_blank'><img src='attachments/{$att->path}' class='att-preview' alt='' /></a> ";
						else
							$output .= "<a href='attachments/{$att->path}' target='_blank'>{$att->path}</a> ";
					}
				}
				
			}
			
			$output .= "</div>";
		
		echo $output;
		
	}
?>
