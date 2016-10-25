<?php
/**
* @class PageUi
*
* This class manages the UI for the Page objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Page_Ui extends Ui {

    /**
	* Render a entire page.
	*/
	public function renderComplete() {
        return '<div class="pageComplete">'.html_entity_decode($this->object->get('page')).'</div>';
    }

}
?>