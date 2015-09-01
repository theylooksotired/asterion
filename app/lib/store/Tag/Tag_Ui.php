<?php
class Tag_Ui extends Ui{

	protected $object;

	public function __construct (Tag & $object) {
		$this->object = $object;
	}
	
}
?>