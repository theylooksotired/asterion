<?php
class FormFields_TextEmail extends FormFields_Text {

  protected $options;
  
  public function __construct($options) {
    parent::__construct($options);
    $this->options['size'] = 30;
  }

  static public function create($options) {
    $options['size'] = 30;
    return FormFields_Default::create($options);
  }

}
?>