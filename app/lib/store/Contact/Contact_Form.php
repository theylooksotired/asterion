<?php
class Contact_Form extends Form{

	public function create() {
		return Form::createForm($this->createFormFields(), array('submit'=>__('send'), 'class'=>'formSite'));
	}

}
?>