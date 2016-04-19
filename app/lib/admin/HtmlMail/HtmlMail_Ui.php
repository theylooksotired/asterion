<?php

class HtmlMail_Ui extends Ui{

  protected $object;

  public function __construct (HtmlMail & $object) {
    $this->object = $object;
  }

  public function renderMail($options=array()) {
    //Render an email using values in the form #VALUE and a template
    $values = (isset($options['values']) && is_array($options['values'])) ? $options['values'] : array();
    if (isset($options['template'])) {
      $template = HtmlMailTemplate::code($options['template']);
    } else {
      $template = HtmlMailTemplate::code('basic');
    }
    $content = $this->object->get('mail');
    foreach ($values as $key=>$value) {
      $content = str_replace('#'.$key, $value, $content);
    }
    return $template->showUi('Template', array('values'=>array('CONTENT'=>$content)));
  }

}

?>