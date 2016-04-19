<?php
class FormFields_TextUnchangeable extends FormFields_Text {

  protected $options;
  
  public function __construct($options) {
    parent::__construct($options);
    $this->options['size'] = '95%';
    if (isset($this->options['value']) && $this->options['value']!='') {
      $this->options['disabled'] = true;
    }
  }

  static public function create($options) {
    $options['size'] = '95%';
    if (isset($options['value']) && $options['value']!='') {
      $options['disabled'] = true;
    }
    return FormFields_Default::create($options);
  }
  
}
?>