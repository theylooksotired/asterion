<?php
/**
* @class HtmlSection
*
* This class represents a simple HTML section on a website.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class HtmlSection extends Db_Object {

    /**
    * Load an object using its code
    */
    static public function code($code) {
        return HtmlSection::readFirst(array('where'=>'code="'.$code.'"'));
    }

    /**
    * Show directly the content of a page just using its code
    */
    static public function show($code) {
        $html = HtmlSection::code($code);
        return $html->showUi('Section');
    }

}
?>