<?php
class FormFields_Hidden extends FormFields_Default {

	protected $options;
	
	public function __construct($options) {
		parent::__construct($options);
		$this->options['layout'] = 'simple';
		$this->options['typeField'] = 'hidden';
	}

	static public function create($options) {
		$options['layout'] = 'simple';
		$options['typeField'] = 'hidden';
		return FormFields_Default::create($options);
	}
	
}
?>