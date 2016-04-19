<?php
class FormFields_Textarea extends FormFields_DefaultTextarea {

  protected $options;
  
  public function __construct($options) {
    parent::__construct($options);
    $this->options['cols'] = 70;
    $this->options['rows'] = 5;
  }

  static public function create($options) {
    $options['cols'] = 70;
    $options['rows'] = 5;
    return FormFields_DefaultTextarea::create($options);
  }
  
}
?>