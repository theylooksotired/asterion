<?php
class PostTag_Ui extends Ui{

	protected $object;

	public function __construct (PostTag & $object) {
		$this->object = $object;
	}
	
}
?>