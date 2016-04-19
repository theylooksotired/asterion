<?php

class HtmlSectionAdmin_Ui extends Ui{

  protected $object;

  public function __construct (HtmlSectionAdmin & $object) {
    $this->object = $object;
  }

  public function renderPage() {
    return '<div class="pageSimple">
          '.$this->object->get('section').'
        </div>';
  }

}

?>