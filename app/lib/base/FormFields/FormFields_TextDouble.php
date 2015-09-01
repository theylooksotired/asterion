<?php
class FormFields_TextDouble extends FormFields_Text {

	protected $options;
	
	public function __construct($options) {
		parent::__construct($options);
		$this->options['size'] = 6;
	}

	static public function create($options) {
		$options['size'] = 6;
		return FormFields_Default::create($options);
	}
	
}
?>