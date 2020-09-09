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
		
		// var_dump($m);
		// exit;
		
			$mToken      = $message::cleanner($m->token);
			$mSender     = $message::cleanner($m->sender);
			$mSenderName = $mSender; //$message::cleanner($m->senderName);
			$mRecever    = $message::cleanner($m->recever);
			$mObject     = stripslashes($message::cleanner($m->object));
			$mMessage    = stripslashes($message::cleanner(nl2br($m->message)));
			// var_dump($mMessage);
			$mStatus     = (int)$m->status;
			$mDate       = $message::cleanner($m->date);
			$mDeleted    = $message::cleanner($m->deleted);
			
			$isReaded       = ($mStatus == 1) ? 'read' : 'unread';
			
			$output .= "<div class='read'>";
			$output .= "<h3 class='m-object'>{$mObject}</h3><br>";
			
			$output .= '<input type="hidden" name="token" id="aswtoken" value="'.crypt('hwyethdnsbcgdferyr874h43',md5('token-'.uniqid())).'" readonly />';
			$output .= "<input type='hidden' id='aswmtoken' value='{$mToken}' readonly>";
			$output .= "<input type='hidden' id='aswmrecever' value='{$mSender}' readonly>";
			$output .= "<input type='hidden' id='aswmobject' value='{$mObject}' readonly>";
			$output .= "<strong class='sender'>{$mSenderName}</strong>  - ";
			$output .= "<time>{$mDate}</time>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$output .= "<a href='#{$mToken}' data-token='{$mToken}' class='delete' title='Delete'><img src='img/delete.png' class='del-icone'></a>";
			// if($mStatus){
               $output .= "&nbsp;&nbsp;<a href='#{$mToken}' data-token='{$mToken}' class='as-{$isReaded}' title='Mark as {$isReaded}'></a>";
			// }			
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
				
				$output .= "<hr>";
			}
			$output .= "<h3 class='strong'>Reply</h3>";
			$output .= "<form method='post' action='#'>";
			$output .= "<textarea id='response-message' name='response-message' placeholder='Click to enter your answer'></textarea>";
			$output .= '						
						<div class="form-group" class="">
						  <p class="label"><label for="attachments[]">Join files <i class="fa fa-paperclip"></i></label></p>
						  <input type="file" id="aswattachments" name="attachments[]" class="form-control" multiple>
						  <br />
						  <div id="attachments-list"></div>
						</div>';
			$output .= "<input type='submit' value='send' id='aswsend' name='send' class='btn'>";
			$output .= "</form>";
			
			$output .= "</div>";
		
		echo $output;
		
	}
?>
<script>
	var domaine = 'https://scandin-africa.com';

	$('#aswsend').on('click',function(){
		$this        = $(this);
		$this.attr('disabled', true);
		
		var loader   = $('div#ajaxloader');
		loader.removeClass('error').removeClass('success');
		
		var token    = $('#aswtoken').val();
		var mtoken   = $('#aswmtoken').val();
		var mobject  = $('#aswmobject').val();
		var mrecever = $('#aswmrecever').val();
		var message  = $('#response-message').val();
		
		loader.fadeIn(500);
		
		// alert('ok');
		if(message != ''){
			$.ajax({
				type : "POST",
				url : domaine+"/mailbox/send.php",
				beforeSend : function(){loader.html("Sending...")},
				data : {'token':token, 'mtoken':mtoken, 'mobject':mobject, 'mrecever':mrecever, 'message':message},
				dataType : "json",
				cache : false,
				success : function(resultats){
					if(resultats[0] == 1){loader.addClass('success').html(resultats[1]); $('#response-message').val(''); $this.attr('disabled', false);}
					else                  {loader.addClass('error').html(resultats[1]); $this.attr('disabled', false);}
					
					loader.delay(15000).fadeOut(500);
				}
			});
			
		}else{
			loader.addClass('error').html('Please enter your message');
			$this.attr('disabled', false);
		}
		
		
		
		return false;
	});
	
	
$('input#aswattachments').on('change',function(){
	$this = $(this);
	
	var loader   = $('div#ajaxloader');
	  loader.removeClass('error').removeClass('success');
	
	if($this.val() != ""){
		loader.fadeIn(500);
		
		var token  = $('#aswtoken').val();
		
		loader.html("Saving files...");
		
		var files    = $this[0].files; // selected files
		var formData = new FormData();
	
		for (var i = 0; i < files.length; i++) {
		  var file = files[i];

		  // Add the file to the request.
		  formData.append('attachments[]', file, file.name);
		  // alert(file.name);
		}
		  
		  var xhr = new XMLHttpRequest();
		  xhr.open('POST', domaine+'/mailbox/upload.php?ajax=1&token='+token, true);
		  xhr.onload = function () {
			  reponse = JSON.parse(xhr.response);
			  
			  if (xhr.status === 200 && reponse[0] == 1) {
				loader.addClass('success').html(reponse[1]);
				loader.delay(5000).fadeOut(500);
			  } else {
				loader.addClass('error').html(reponse[1]);
				loader.delay(5000).fadeOut(500);
			  }
			};
			xhr.send(formData);
			
	}
});

</script>