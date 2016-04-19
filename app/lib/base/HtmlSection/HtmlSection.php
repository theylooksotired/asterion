<?php
class HtmlSection extends Db_Object {

    public function __construct($values=array()) {
        parent::__construct($values);
    }

    static public function code($code) {
        return HtmlSection::readFirst(array('where'=>'code="'.$code.'"'));
    }

    static public function show($code) {
        $html = HtmlSection::code($code);
        return $html->showUi('Page');
    }

}
?>