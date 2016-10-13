<?php
/**
* @class MenuUi
*
* This class manages the UI for the Menu objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Menu_Ui extends Ui{

	/**
	* Render a menu and its items.
	*/
	public function renderComplete($options=array()) {
		$subMenu = (isset($options['subMenu'])) ? $options['subMenu'] : false;
		$html = '';
		$items = MenuItem::readList(array('where'=>'idMenu="'.$this->object->id().'"', 'order'=>'ord'));
		foreach ($items as $item) {
			$info = explode('_', $item->get('link'));
			$link = '';
			switch ($info[0]) {
				case 'homePage':
					$link = '<a href="'.url().'">'.__('homePage').'</a>';
				break;
				case 'list':
					if (isset($info[1])) {
						$objectName = $info[1];
						$object = new $objectName;
						$itemsIns = $object->readList();
						$link = '';
						foreach ($itemsIns as $itemIns) {
							$link .= '<div class="menuItem menuItem-'.$info[0].'">'.$itemIns->link().'</div>';
						}
					}
				break;
				case 'public':
					if (isset($info[1])) {
						$objectName = $info[1];
						$object = new $objectName();
						$link = $object->linkList();
					}
				break;
				case 'item':
					if (isset($info[2])) {
						$objectName = $info[1];
						$object = new $objectName();
						$object = $object->readObject($info[2]);
						$link = $object->link();
					}
				break;
				case 'external':
					$externalLink = $item->get('externalLink');
					if ($externalLink!='') {
						$link = '<a href="'.$externalLink.'">'.$item->get('label').'</a>';
					} else {
						$link = '<span>'.$item->get('label').'</span>';
					}
				break;
			}
			$subMenuHtml = '';
			$subMenuObject = Menu::read($item->get('idSubMenu'));
			if ($subMenuObject->id()!='') {
				$subMenuHtml = '<div class="submenu submenu-'.$subMenuObject->className.'">
									'.$subMenuObject->showUi('Complete', array('subMenu'=>true)).'
								</div>';
			}
			$html .= ($info[0]!='list') ? '<div class="menuItem menuItem-'.$info[0].'">'.$link.$subMenuHtml.'</div>' : $link.$subMenuHtml;
		}
        return ($subMenu) ? $html : '<nav class="menu menu-'.$this->object->get('code').'">'.$html.'</nav>';
    }

}
?>