<?php
class Page_Ui_Html extends Ui {

    public function __construct (Page & $object) {
        $this->object = $object;
    }
    
    public function renderPage() {
        return '<div class="pageComplete">
                    '.html_entity_decode($this->object->get('page')).'
                    <div class="clearer"></div>
                </div>';
    }

}
?>