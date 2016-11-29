<?php
/**
* @class DocumentationUi
*
* This class manages the UI for the Documentation objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Documentation_Ui extends Ui{

	public function renderPublic() {
		return '<div class="itemPublic">
					'.$this->object->link().'
				</div>';
	}

	public function renderComplete() {
		return '<div class="itemComplete">
					<div class="pageComplete">
						'.$this->object->get('description').'
					</div>
				</div>';
	}

}
?>