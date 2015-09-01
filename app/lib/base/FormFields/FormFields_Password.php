<?php
class FormFields_Password extends FormFields_Default {

	protected $options;
	
	public function __construct($options) {
		parent::__construct($options);
		$this->options['size'] = 50;
		$this->options['typeField'] = 'password';
	}

	static public function create($options) {
		$options['size'] = 50;
		$options['typeField'] = 'password';
		return FormFields_Default::create($options);
	}
	
}
?>