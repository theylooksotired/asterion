<?php
class Page_Ui extends Ui{

	protected $object;

	public function __construct (Page & $object) {
		$this->object = $object;
	}

	public function renderComplete() {
		return '<div class="pageComplete pagePublic">
					'.$this->object->get('description').'
				</div>';
	}
	
}
?>