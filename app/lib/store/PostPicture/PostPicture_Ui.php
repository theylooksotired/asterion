<?php
class PostPicture_Ui extends Ui{

	protected $object;

	public function __construct (PostPicture & $object) {
		$this->object = $object;
	}
	
}
?>