<?php
class PostCategory_Ui extends Ui{

	protected $object;

	public function __construct (PostCategory & $object) {
		$this->object = $object;
	}
	
}
?>