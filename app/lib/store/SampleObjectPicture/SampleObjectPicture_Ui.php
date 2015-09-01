<?php
class SampleObjectPicture_Ui extends Ui{

	protected $object;

	public function __construct (SampleObjectPicture & $object) {
		$this->object = $object;
	}
	
}
?>