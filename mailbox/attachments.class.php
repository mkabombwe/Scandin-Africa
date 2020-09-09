<?php
	require_once('db.class.php');
	
	class Attachments extends DBAccess{
		public  $id;
		public  $messageToken;
		public  $type;
		public  $path;
		public  $date;
		
		public function __construct($id = null, $messageToken = null, $type = null, $path = null, $date = null){
			
			$this->id           = (int) $id;
			$this->messageToken = $messageToken;
			$this->type         = $type;
			$this->path         = $path;
			$this->date         = $date;
		}
		
		/* Save an attached file */
		public function save(){
			$t = "attachments";
			$c = "*";
			$v = "message_token = '{$this->messageToken}' AND path = '{$this->path}' ORDER BY id DESC LIMIT 1";
			
			$verif = parent::load()->Select($t, $c, $v);
			
			if(!$verif){
				return parent::load()->Insert($t, "id, message_token, type, path, date", "'','{$this->messageToken}','{$this->type}','{$this->path}','".date('Y-m-d g:i a')."'");
			}
			return false;
		}
		
		 /*****
		  Find one or more attached files
		  @return object Attachments
		 */
		  public function find($id = null, $message_token = null){
				if($id == null and $message_token == null)     $files = self::load()->Select('attachments', '*', '1');
				elseif($id != null and $message_token == null) $files = self::load()->Select('attachments', '*', 'id = "'.(int)$id.'"');
				elseif($message_token != null)                 $files = self::load()->Select('attachments', '*', 'message_token = "'.$message_token.'" ');
				// return $Attachments;
				$liste   = array();
				
				if($files){
					foreach($files as $c){
						$liste[] = new Attachments($c['id'], $c['message_token'], $c['type'], $c['path'], $c['date']);
					}
				}
				
				if($id != null or ($files and count($files) == 1)) return $liste[0];
				                                                   return $liste;
		  
		  }
		// clean links
		public static function cl($chaine){
			$caracteres = array(
				'À' => 'a', 'Á' => 'a', 'Â' => 'a', 'Ä' => 'a', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ä' => 'a', '@' => 'a',
				'È' => 'e', 'É' => 'e', 'Ê' => 'e', 'Ë' => 'e', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', '€' => 'e',
				'Ì' => 'i', 'Í' => 'i', 'Î' => 'i', 'Ï' => 'i', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
				'Ò' => 'o', 'Ó' => 'o', 'Ô' => 'o', 'Ö' => 'o', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'ö' => 'o',
				'Ù' => 'u', 'Ú' => 'u', 'Û' => 'u', 'Ü' => 'u', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'µ' => 'u',
				'Œ' => 'oe', 'œ' => 'oe',
				'$' => 's');
		 
			$chaine = strtr($chaine, $caracteres);
			$chaine = preg_replace('#[^A-Za-z0-9.]+#', '-', $chaine);
			$chaine = trim($chaine, '-');
			$chaine = strtolower($chaine);
		 
			return $chaine;
		}
		
	}