<?php
	require_once('db.class.php');
	require_once('attachments.class.php');
	
	class Messages extends DBAccess{
		private $id;
		public  $token;
		public  $parentToken;
		public  $sender;
		public  $senderName;
		public  $recever;
		public  $receverName;
		public  $object;
		public  $message;
		public  $status;
		public  $draft;
		public  $date;
		public  $deleted;
		public  $currentUser;
		public  $attachments;
		
		public function __construct($id = null, $token = null, $parentToken = null, $sender = null, $senderName = null, $recever = null, $receverName = null, $object = null, $message = null, $status = null, $draft = null, $date = null, $deleted = null, $currentUser = null, $attachments = null){
			
			$this->id          = (int) $id;
			$this->token       = $token;
			$this->parentToken = $parentToken;
			$this->sender      = $sender;
			$this->senderName  = $senderName;
			$this->recever     = $recever;
			$this->receverName = $receverName;
			$this->object      = $object;
			$this->message     = $message;
			$this->status      = (int) $status;
			$this->draft       = (int) $draft;
			$this->date        = $date;
			$this->deleted     = (boolean) $deleted;
			$this->currentUser = $currentUser;
			$this->attachments = $attachments;
		}
		
		/* mailbox */
		public function mailbox($sender = false, $recever = false){
			$re = false;
			$c  = "*";
			
			$t  = "messages m LEFT JOIN users u ON (m.sender = u.user_id)";
			
			if($sender!=false and $sender>0) $t  = "messages m";
			
			// selection des différents sender
			if(!$sender and !$recever){
				$ce  = " * ";
				$ve  = " recever = '".$this->currentUser."' AND (m.token NOT IN(SELECT token FROM basket)) AND draft = 0 ORDER BY m.id DESC ";
				
				$re = parent::load()->Select($t, $ce, $ve);
				
				$msg = array();
				
				if(!$re) return false;
				
				foreach($re as $k){
					
					$deleted = (self::isDeleted($k['token'])) ? true : false;
					
					$attachments = new Attachments;
					$files       = $attachments->find(null, $k['token']);
					
					$m = new Messages($k['id'], $k['token'], $k['parent_token'], $k['sender'], $k['username'], $k['recever'], '', $k['object'], $k['message'], $k['status'], $k['draft'], $k['date'], $deleted, $this->currentUser, $files);
					$msg[] = $m;
				}
				return $msg;
				
			}elseif($sender and $recever){
				$ce  = " * ";
				$ve  = " (recever='".$recever."' AND sender='".$sender."') OR (sender='".$recever."' AND recever='".$sender."') AND (m.token NOT IN(SELECT token FROM basket)) AND draft = 0 ORDER BY id ASC ";
				
				$r = parent::load()->Select("messages m", $ce, $ve);
				
				$msg = array();
				
				if(!$r) return false;
				
				foreach($r as $k){
					
					$deleted = (self::isDeleted($k['token'])) ? true : false;
					
					$attachments = new Attachments;
					$files       = $attachments->find(null, $k['token']);
					
					$m = new Messages($k['id'], $k['token'], $k['parent_token'], $k['sender'], $k['username'], $k['recever'], '', $k['object'], $k['message'], $k['status'], $k['draft'], $k['date'], $deleted, $this->currentUser, $files);
					$msg[] = $m;
				}
				return $msg;
			}
			return false;
		}
		
		/* read */
		public function read(){
			if(empty($this->token)) return false;
			
			$re = false;
			$c  = "*";
			
			$t  = "messages m LEFT JOIN users u ON (m.sender = u.user_id)";
			
			if($this->sender == $this->currentUser) $t  = "messages m LEFT JOIN users u ON (m.recever = u.user_id)";
			
			// selection du message
			
				$ve  = " token = '".$this->token."' LIMIT 1 ";
				
				$r = parent::load()->Select($t, $c, $ve);
				
				if(!$r) return false;
				
				$k = $r[0];
				
				$deleted = (self::isDeleted($k['token'])) ? true : false;
				
				$attachments = new Attachments;
				$files       = $attachments->find(null, $k['token']);
				
				$this->asRead($this->token);
				
				$k['status'] = 0;
				
				return new Messages($k['id'], $k['token'], $k['parent_token'], $k['sender'], $k['username'], $k['recever'], '', $k['object'], $k['message'], $k['status'], $k['draft'], $k['date'], $deleted, $this->currentUser, $files);
			
		}
		
		/* sent */
		public function sent($sender = false){
		
			// selection des différents sender
			if(!$sender) {
			    $ce  = " * ";
				$ve  = " sender='".$this->currentUser."' AND draft = 0 ORDER BY id DESC ";
				
				$r = parent::load()->Select("messages m", $ce, $ve);
				
				if($r){
					$msg = array();
					
					foreach($r as $k){
						$deleted = (self::isDeleted($k['token']) > 0) ? true : false;
						
						$attachments = new Attachments;
						$files       = $attachments->find(null, $k['token']);
						
						$m = new Messages($k['id'], $k['token'], $k['parent_token'], $k['sender'],"", $k['recever'], '', $k['object'], $k['message'], $k['status'], $k['draft'], $k['date'], $deleted, $this->currentUser, $files);
						$msg[] = $m;
					}
					
					return $msg;
				}
			}
			return false;
		}
		
		/*
	
		*/
		public static function isDeleted($token){

			return parent::load()->Select('basket', '*', 'token = '.$token);
		}
		
		/* Envoyer un message */
		public function send($auto = false){
			$t = "messages";
			$c = "*";
			
			if(!$auto){
				$v = "(recever = '{$this->recever}' AND sender = '{$this->sender}' AND message = '{$this->message}') OR token = '{$this->token} ORDER BY id DESC LIMIT 1";
				
				$verif = parent::load()->Select($t, $c, $v);
				
			}else{
				$v = "sender = '{$this->sender}' AND draft = '1' LIMIT 1";
				
				if(parent::load()->Select($t, $c, $v)){
					return parent::load()->update($t, "recever = '{$this->recever}', object = '{$this->object}', message = '".parent::Protection($this->message)."', draft = '{$this->draft}', date = '".date('Y-m-d g:i a')."'", "token = '{$this->token}' LIMIT 1");
					
				}else{
					$v = "token = '{$this->token}' LIMIT 1";
					
					$verif = parent::load()->Select($t, $c, $v);
					
					if($verif) return parent::load()->update($t, "recever = '{$this->recever}', object = '{$this->object}', message = '".parent::Protection($this->message)."', draft = '{$this->draft}', date = '".date('Y-m-d g:i a')."'", "token = '{$this->token}' LIMIT 1");
					
					else return parent::load()->Insert($t, "id, token, parent_token, sender, recever, object, message, status, draft, date", "'','{$this->token}','{$this->parentToken}','{$this->sender}','{$this->recever}','{$this->object}','".parent::Protection($this->message)."','1','{$this->draft}','".date('Y-m-d g:i a')."'");
					
				}
				
			}
			
			if(!$verif){
				return parent::load()->Insert($t, "id, token, parent_token, sender, recever, object, message, status, draft, date", "'','{$this->token}','{$this->parentToken}','{$this->sender}','{$this->recever}','{$this->object}','".parent::Protection($this->message)."','1','{$this->draft}','".date('Y-m-d g:i a')."'");
			}else{
				return parent::load()->update($t, "recever = '{$this->recever}', object = '{$this->object}', message = '".parent::Protection($this->message)."', draft = '{$this->draft}', date = '".date('Y-m-d g:i a')."'", "token = '{$this->token}' LIMIT 1");
			}
			return false;
		}
		
		/* messages deleted */
        public function deleted(){
    
			$t  = "SELECT * FROM basket b WHERE user_id = '".$this->currentUser."' ORDER BY b.id DESC ";
	        $u  = "SELECT m.id, m.token, m.parent_token, m.sender, m.recever, m.object, m.message, m.status, m.date FROM (".$t.") AS t INNER JOIN messages AS m USING (token)"; 
			
			$re = parent::load()->Query($u);
			
			$msg = array();
			
			if(!$re) return false;
			
			foreach($re as $k){
				
				$attachments = new Attachments;
				$files       = $attachments->find(null, $k['token']);
					
				$m = new Messages($k['id'], $k['token'], $k['parent_token'], $k['sender'],"", $k['recever'], '', $k['object'], $k['message'], $k['status'], $k['draft'], $k['date'], 1, $this->currentUser, $files);
				$msg[] = $m;
			}
			return $msg;
        }
		
        public function mDelete($mtoken){

        	$user_id = $this->currentUser;
        	return parent::load()->insert("basket","id, token, user_id", "'','{$mtoken}','{$user_id}'");

        } 
        public function asRead($mtoken){
	        $user_id = $this->currentUser;
	        $r = "UPDATE messages SET status = 0 WHERE token = '".$mtoken."'";
        	return parent::load()->Query($r);
        }
        public function asUnread($mtoken){
	        $user_id = $this->currentUser;
	        $r = "UPDATE messages SET status = 1 WHERE token = '".$mtoken."'";
        	return parent::load()->Query($r);
        }
		
		/* Méthode de vérification d'adresse email */
		public static function isValidEmail($mail) {
			if (preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$#i", $mail ) ) {
				
				list ($nom, $domaine) = @explode ('@', $mail);
				if ($k = getmxrr ($domaine, $mxhosts))  {
					return true;
				} else {
					return false;
				} 
			}return false; 
		}

		
	}