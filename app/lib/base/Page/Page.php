<?php
/**
* @class Page
*
* This class represents a simple page on a website.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Page extends Db_Object {

	/**
    * Load an object using its code
    */
    static public function code($code) {
        return Page::readFirst(array('where'=>'code="'.$code.'"'));
    }

    /**
    * Show directly the content of a page just using its code
    */
    static public function show($code) {
        $page = Page::code($code);
        return $page->showUi('Page');
    }
}
?>