<?php
class HtmlMail extends Db_Object {

    public function __construct($values=array()) {
        parent::__construct($values);
    }

    static public function code($code) {
        //Return the object using it's code
        return HtmlMail::readFirst(array('where'=>'code="'.$code.'"'));
    }

    static public function send($email, $code, $values=array(), $template='basic') {
        //Send an email formatted with a template
        $htmlMail = HtmlMail::code($code);
        Email::send($email, $htmlMail->get('subject'), $htmlMail->showUi('Mail', array('values'=>$values, 'template'=>$template)), $htmlMail->get('replyTo'));
    }

}
?>