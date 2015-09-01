<?php
class Tag extends Db_Object {

	public function __construct($VALUES=array()) {
		parent::__construct($VALUES);
	}

	public function getBasicInfo() {
		return $this->get('name');
	}

}
?>