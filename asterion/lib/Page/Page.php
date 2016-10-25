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
        $where = '';
        foreach (Lang::langs() as $lang) {
            $where .= 'linkCode_'.$lang.'="'.$code.'" OR ';
        }
        $where = substr($where, 0, -4);
        return Page::readFirst(array('where'=>$where));
    }

    /**
    * Show directly the content of a page just using its code
    */
    static public function show($code) {
        $page = Page::code($code);
        return $page->showUi('Complete');
    }
}
?>