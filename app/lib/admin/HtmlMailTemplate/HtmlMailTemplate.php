<?php
class HtmlMailTemplate extends Db_Object {

    public function __construct($values=array()) {
        parent::__construct($values);
    }

    static public function code($code) {
        //Return the object using it's code
        return HtmlMailTemplate::readFirst(array('where'=>'code="'.$code.'"'));
    }

}
?>