<?php
class SampleObjectCategory_Ui extends Ui{

	protected $object;

	public function __construct (SampleObjectCategory & $object) {
		$this->object = $object;
	}
	
}
?>