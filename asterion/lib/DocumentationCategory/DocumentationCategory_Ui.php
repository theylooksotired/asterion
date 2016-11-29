<?php
/**
* @class DocumentationCategoryUi
*
* This class manages the UI for the DocumentationCategory objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class DocumentationCategory_Ui extends Ui{

	public function renderPublic() {
		$items = new ListObjects('Documentation', array('where'=>'idDocumentationCategory="'.$this->object->id().'"',
													'ord'=>'ord'));
		return $items->showList();
	}

}
?>