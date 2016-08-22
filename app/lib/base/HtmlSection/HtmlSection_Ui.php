<?php
/**
* @class HtmlSectionUi
*
* This class manages the UI for the HtmlSection objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class HtmlSection_Ui extends Ui{

    public function __construct (HtmlSection & $object) {
        $this->object = $object;
    }

    public function renderPage() {
        return '<div class="pageSimple">'.$this->object->get('section').'</div>';
    }

}

?>