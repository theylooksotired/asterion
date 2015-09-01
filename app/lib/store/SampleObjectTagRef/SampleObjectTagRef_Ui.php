<?php
class SampleObjectTagRef_Ui extends Ui{

	protected $object;

	public function __construct (SampleObjectTagRef & $object) {
		$this->object = $object;
	}
	
}
?>