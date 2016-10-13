<?php
/**
* @class Menu
*
* This class represents a menu item.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Menu extends Db_Object {

	/**
    * Load an object using its code
    */
    static public function code($code) {
        return Menu::readFirst(array('where'=>'code="'.$code.'"'));
    }

    /**
    * Show directly the content of a page just using its code
    */
    static public function show($code) {
        $page = Menu::code($code);
        return $page->showUi('Complete');
    }

}
?>