<?php
class Db_Connection extends Singleton {

	private $connexion_pdo=null;

	protected function initialize(){
		//Initialize a connection
		$this->connexion_pdo = null;
		try{
			$this->connexion_pdo = new PDO(PDO_DSN, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		} catch(PDOException $error){
			if (DEBUG) {
				echo '<pre>';
				throw new Exception($error->getMessage());
			}
		}
		$this->connexion_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->connexion_pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
	}

	public function execute($query, $values=array()){
		//Execute a query
		try {
			$this->connexion_pdo->beginTransaction();
			$prepare_execute = $this->getPDOStatement($query);
			$prepare_execute->execute($values);
			$this->connexion_pdo->commit();
		} catch(PDOException $error){
			if (DEBUG) {
				echo '<pre>';
				throw new Exception($error->getMessage());
			}
		}
	}

	public function getPDOStatement($query){
		//Get the PDO statement
		try {
			return $this->connexion_pdo->prepare($query,array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		} catch(PDOException $error){
			if (DEBUG) {
				echo '<pre>';
				throw new Exception($error->getMessage());
			}
		}
	}

}
?>