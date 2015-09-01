<?php
class UserSite extends Db_Object {

	public function __construct($VALUES=array()) {
		parent::__construct($VALUES);
	}
	
	public function getBasicInfo() {
		return $this->get('name');
	}

	public function getBasicInfoAdmin() {
		return $this->name().'<br/><span style="color:#666666;font-weight:normal;font-size:0.9em;">('.$this->get('email').')</span>';
	}

	public function name() {
		return $this->get('lastName').' '.$this->get('name');
	}
}
?>