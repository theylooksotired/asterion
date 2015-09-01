<?php
class SampleObject_Ui extends Ui{

	protected $object;

	public function __construct (SampleObject & $object) {
		$this->object = $object;
	}
	
}
?>