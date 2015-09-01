<?php
class FormFields_DateText extends FormFields_Default {

	protected $options;
	
	public function __construct($options) {
		parent::__construct($options);
		$this->options['typeField'] = 'text';
		$this->options['class'] = 'dateText';
		$this->options['value'] = (isset($this->options['value'])) ? substr($this->options['value'], 0, 10) : '';
	}

	static public function create($options) {
		$options['typeField'] = 'text';
		$options['class'] = 'dateText';
		return FormFields_Default::create($options);
	}
	
}
?>