<?php
class Page extends Db_Object {

    public function __construct($VALUES=array()) {
        parent::__construct($VALUES);
    }
    
    public function getBasicInfo() {
        return $this->get('title');
    }

    static public function code($code) {
        return Page::readFirst(array('where'=>'code="'.$code.'"'));
    }

    static public function show($code) {
        $page = Page::code($code);
        return $page->showUi('Page');
    }
}
?>