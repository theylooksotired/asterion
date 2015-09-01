<?php
class FormFields_TextLarge extends FormFields_Text {

	protected $options;
	
	public function __construct($options) {
		parent::__construct($options);
		$this->options['size'] = 80;
	}
	
	static public function create($options) {
		$options['size'] = 80;
		return FormFields_Default::create($options);
	}

}
?>