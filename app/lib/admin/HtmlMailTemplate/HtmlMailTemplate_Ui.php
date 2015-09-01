<?php
class HtmlMailTemplate_Ui extends Ui{

	protected $object;

	public function __construct (HtmlMailTemplate & $object) {
		$this->object = $object;
	}

	public function renderTemplate($options=array()) {
		//Render an email template using values in the form #VALUE
		$values = (isset($options['values']) && is_array($options['values'])) ? $options['values'] : array();
		$template = $this->object->get('template');
		foreach ($values as $key=>$value) {
			$template = str_replace('#'.$key, $value, $template);
		}
		return $template;
	}

}
?>