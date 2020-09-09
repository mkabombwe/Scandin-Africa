<?php
	require_once('db.class.php');
	
	class Users extends DBAccess{
		public $user_id, $profile_id, $unique_id, $username, $password;
		
		public function __construct($user_id = null, $profile_id = null, $unique_id = null, $username = null){
			
			$this->user_id      = parent::cleanner($user_id);
			$this->profile_id   = parent::cleanner($profile_id);
			$this->unique_id    = parent::cleanner($unique_id);
			$this->username     = parent::cleanner($username);

		}
		
	}
	