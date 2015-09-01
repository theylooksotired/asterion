<?php
class FormFields_TextLong extends FormFields_Text {

	protected $options;
	
	public function __construct($options) {
		parent::__construct($options);
		$this->options['size'] = '95%';
	}

	static public function create($options) {
		$options['size'] = '95%';
		return FormFields_Default::create($options);
	}
	
}
?>