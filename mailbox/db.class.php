<?php
	class DBAccess{
	
		private $db;
		private $debug = 0;
		
		const _HOST_     = 'DATABASE_HOST';     
		const _DB_       = 'DATABASE_NAME';       
		const _USER_     = 'DATABASE_USER';
		const _PASSWORD_ = 'DATABASE_PASSWORD';

		const _DB_CONNEXION_ERROR_ = 'Database connection error!';
		
		/**	Singleton renvoyé par la methode load()
		 */
		private	static $singleton;
		
		/** Empeche la création par assignation (clônage)
		 */
		public function __clone(){
			trigger_error('Le clônage n\'est pas autorisé.', E_USER_ERROR);
		}
		
		/**	Effectue une requête et renvoie le jeu de resultat. 
		 */		
		public function Query($q){
			if ($this->debug) { echo $q."<br/>"; }
		
			 return $this->db->query($q);
		}
		
		/*
			Clause SELECT
		 */
		public function select($table, $attr, $where, $orderby = NULL, $limit = NULL){
			$q = "SELECT $attr FROM $table WHERE $where ";
			if ($orderby != NULL)
				$q .= " ORDER BY $orderby ";
			if ($limit != NULL)
				$q .= " LIMIT $limit ";
			
			$r = $this->db->prepare($q);
			$r->execute();
			if (!$r)
				$this->db->errorInfo();
			if ($this->debug) { echo $q."<br/>"; }
			
			return $r->fetchAll();
		}
		/*
			Clause INSERT
		 */
		public function insert($table, $col, $valeurs){
			$q = "INSERT INTO $table ($col) VALUES ($valeurs)";
			$r = $this->db->prepare($q);
			$r->execute();
			if ($this->debug) { echo $q."<br/>"; }
			if ($r)
				return $this->db->lastInsertId();
			else
				return false;
		}
		/*
			Clause INSERT : Insert sans erreur dans $Table ($colonnes) les $valeurs
		 */
		public function insertIgnore($table, $col, $valeurs){
			$q = "INSERT IGNORE INTO $table ($col) VALUES ($valeurs)";
			$r = $this->db->prepare($q);
			$r->execute();
			if ($this->debug) { echo $q."<br/>"; }
			if ($r)
				return $this->db->lastInsertId();
			else
				return false;
		}
			
		/*
			Clause UPDATE
		 */
		public function update($table, $set, $where){
			$q = "UPDATE $table SET $set WHERE $where";
			if ($this->debug) { echo $q."<br/>"; }
			$r = $this->db->prepare($q);
			// return $this->db->lastInsertId();
			return $r->execute();
		}
			
		/*
			Clause UPDATE : Met a jour la $table avec $set pour toute valeur répondant a $where
		 */
		public function updateSelect($table, $set, $where){
			$q = "UPDATE $table SET $set WHERE $where";
			if ($this->debug) { echo $q."<br/>"; }
			$r = $this->db->prepare($q);
			return $r->execute();
		}
		
		/*
			Clause DELETE
		 */
		public function delete($table,$where){
			$q = "DELETE FROM $table WHERE $where";
			if ($this->debug) { echo $q."<br/>"; }
			$r = $this->db->prepare($q);
			return $r->execute();
		}
		
		/*
			Permet l'obtension de la base de donnée. 
		 */
		public static function load(){
			if (!isset(self::$singleton))
				self::$singleton = new DBAccess;
			return self::$singleton;
		}
						
		/** 	Un constructeur privé ; empêche la création directe d'objet
		 */
		private	function __construct() {
			try {
				$this->db = new PDO (
					'mysql:host='.self::_HOST_.';'.
					'dbname='.self::_DB_,
					self::_USER_,																	
					self::_PASSWORD_);
			}
			catch (Exception $e){
				die(self::_DB_CONNEXION_ERROR_);
			}
		}
		
		/**/
		public static function Protection($donnees){
			if($sqli = Messages::load()){
				return self::cleanner($donnees);
			}
		}
		
		public static function cleanner($data, $in = false){
			
			$donnees = array();
			if(is_array($data)){
				foreach($data as $k => $v){
					$donnees[$k] = self::cleanner($v);
				}
			}else{
				if(get_magic_quotes_gpc() and $in == false){
					$data = trim(stripslashes($data));
				}else{
					$data = trim(addslashes($data));
				}
				$donnees = trim($data);
			}
			$donnees = (!$in) ? stripslashes($donnees) : $donnees;
			return $donnees;
		}
		
	}
?>