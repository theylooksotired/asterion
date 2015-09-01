<?php
class Post_Ui extends Ui{

	protected $object;

	public function __construct (Post & $object) {
		$this->object = $object;
	}
	
}
?>