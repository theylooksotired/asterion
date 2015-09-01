<?php
class SampleObjectTag_Ui extends Ui{

	protected $object;

	public function __construct (SampleObjectTag & $object) {
		$this->object = $object;
	}
	
}
?>