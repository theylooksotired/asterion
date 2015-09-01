<?php
class Contact_Ui extends Ui{

	protected $object;

	public function __construct (Contact & $object) {
		$this->object = $object;
	}

	public function renderEmail() {
		return '<p>
					<strong>'.__('name').':</strong> '.$this->object->get('name').'<br/>
					<strong>'.__('email').':</strong> '.$this->object->get('email').'<br/>
					<strong>'.__('telephone').':</strong> '.$this->object->get('telephone').'<br/>
					<strong>'.__('description').':</strong> '.nl2br($this->object->get('description')).'<br/>
				</p>';
	}

}
?>