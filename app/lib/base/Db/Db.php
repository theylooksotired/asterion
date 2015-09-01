<?php
class Db {
	
	static public function execute($query, $values=array()) {
		//Execute a query
		$query = str_replace('\"', '"', $query);
		$db = Db_Connection::getInstance();
		$db->execute($query, $values);
	}

	static public function returnSingle($query) {
		//Return a single element
		$query = str_replace('\"', '"', $query);
		$db = Db_Connection::getInstance();
        $prepare_execute = $db->getPDOStatement($query);
		$prepare_execute->execute();
        return $prepare_execute->fetch(PDO::FETCH_ASSOC);
	}

	static public function returnAll($query) {
		//Return a list of elements
		$query = str_replace('\"', '"', $query);
		$db = Db_Connection::getInstance();
        $prepare_execute = $db->getPDOStatement($query);
        $prepare_execute->execute();
        return $prepare_execute->fetchAll(PDO::FETCH_ASSOC);
	}

	static public function returnAllColumn($query) {
		//Return a list of columns
        $query = str_replace('\"', '"', $query);
		$db = Db_Connection::getInstance();
        $prepare_execute = $db->getPDOStatement($query);
        $prepare_execute->execute();
        return $prepare_execute->fetchAll(PDO::FETCH_COLUMN);
	}

	static public function describe($table) {
		//Describe a table
		return Db::returnSingle('DESCRIBE '.Db::prefixTable($table).';');
	}

	static public function initTable($table) {
		//Create the table if not exists already
		foreach (explode(',', $table) as $objectName) {
			$objectName = trim($objectName);
			if (!Db::returnSingle('SHOW TABLES LIKE "'.Db::prefixTable($objectName).'";')) {
				$object = new $objectName();
				$object->createTable();
			}
		}
	}

	static public function prefixTable($table) {
		//Prefix a set of tables
		$result = array();
		foreach (explode(',', $table) as $objectName) {
			array_push($result, DB_PREFIX.trim($objectName));
		}
		return implode(',',$result) ;
	}
	
}
?>