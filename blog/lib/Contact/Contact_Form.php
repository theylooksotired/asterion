<?php
/**
* @class ContactForm
*
* This class manages the forms for the Contact objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Contact_Form extends Form{

	/**
	* Render the public form.
	*/
	public function createPublic() {
		return Form::createForm($this->createFormFields(), array('class'=>'formContact'));
	}

}
?>