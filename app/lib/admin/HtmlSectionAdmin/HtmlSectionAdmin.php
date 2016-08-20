<?php
class HtmlSectionAdmin extends Db_Object {

    public function __construct($values=array()) {
        parent::__construct($values);
    }

    static public function code($code) {
        //Return the object using it's code
        return HtmlSectionAdmin::readFirst(array('where'=>'code="'.$code.'"'));
    }

    static public function show($code) {
        //Show the object using it's code
        $html = HtmlSectionAdmin::code($code);
        return $html->showUi('Page');
    }

}
?>