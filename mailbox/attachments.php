<?php
	require_once('users.class.php');
	require_once('attachments.class.php');
	
	session_start();
	
	$attachments = new Attachments;
	
	$token = $_GET['token'];
	
	if(!empty($token)){
		$files = $attachments->find(null, $token);
		
		if($files){
			echo "<strong>".count($files)." files </strong><br><br>";
			if(count($files) > 1){
				foreach($files as $file){
					echo "<a href='attachments/{$file->path}' target='_blank'>{$file->path}</a><br>";
				}
				
			}else echo "<a href='attachments/{$files->path}' target='_blank'>{$files->path}</a><br>";
		}
	}
?>