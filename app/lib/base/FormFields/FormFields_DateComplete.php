<?php
class FormFields_DateComplete extends FormFields_DefaultDate {

  protected $options;
  
  public function __construct($options) {
    parent::__construct($options);
    $this->options['view'] = 'complete';
  }

  static public function create($options) {
    $options['view'] = 'complete';
    return FormFields_DefaultDate::create($options);
  }
  
}
?>