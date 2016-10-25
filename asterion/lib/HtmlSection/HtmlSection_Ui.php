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

	/**
	* Render a section.
	*/
    public function renderSection() {
        return '<div class="pageComplete">'.$this->object->get('section').'</div>';
    }

}

?>