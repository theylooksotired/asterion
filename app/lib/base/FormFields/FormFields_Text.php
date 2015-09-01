<?php
class FormFields_Text extends FormFields_Default {

	protected $options;
	
	public function __construct($options) {
		parent::__construct($options);
	}

	static public function create($options) {
		return FormFields_Default::create($options);
	}

}
?>