<?php
class UserTypeMenu_Ui extends Ui{

	protected $object;

	public function __construct (UserTypeMenu & $object) {
		$this->object = $object;
	}

	public function renderMenu() {
		//Render the menu item
		return '<div class="menuSideItem menuSideItem-'.$this->object->get('type').'">
					<a href="'.url($this->object->get('action'), true).'">'.$this->object->get('name').'</a>
				</div>';
	}
	
}
?>