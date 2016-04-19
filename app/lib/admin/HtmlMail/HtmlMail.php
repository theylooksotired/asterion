<?php
class HtmlMail extends Db_Object {

    public function __construct($VALUES=array()) {
        parent::__construct($VALUES);
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

    static public function insertConfig() {
        //Initialize the table with default values
        $htmlMails = HtmlMail::countResults();
        if ($htmlMails == 0) {
            //Mail for forgotten passwords
            $htmlMail = new HtmlMail();
            $mail_en = htmlentities('<p>Your temporary password is:</p>
                                    <p>#TEMP_PASSWORD</p>
                                    <p>&nbsp;</p>
                                    <p>Click here to recover it:</p>
                                    <p><a href="#UPDATE_PASSWORD_LINK" target="_blank">#UPDATE_PASSWORD_LINK</a></p>');
            $mail_fr = htmlentities('<p>Votre mot de passe temporaire est:</p>
                                    <p>#TEMP_PASSWORD</p>
                                    <p>&nbsp;</p>
                                    <p>Clickez ici pour récuperer votre compte:</p>
                                    <p><a href="#UPDATE_PASSWORD_LINK" target="_blank">#UPDATE_PASSWORD_LINK</a></p>');
            $mail_es = htmlentities('<p>Su password temporal es:</p>
                                    <p>#TEMP_PASSWORD</p>
                                    <p>&nbsp;</p>
                                    <p>Haga click en el enlace para recuperarlo:</p>
                                    <p><a href="#UPDATE_PASSWORD_LINK" target="_blank">#UPDATE_PASSWORD_LINK</a></p>');
            $htmlMail->insert(array('code'=>'passwordForgot',
                                    'idsAvailable'=>'#TEMP_PASSWORD, #UPDATE_PASSWORD_LINK',
                                    'title_en'=>'Password forgotten',
                                    'title_fr'=>'Mot de passe oubli&eacute;e',
                                    'title_es'=>'Contrase&ntilde;a olvidada',
                                    'subject_en'=>'Password forgotten',
                                    'subject_fr'=>'Mot de passe oubli&eacute;e',
                                    'subject_es'=>'Contrase&ntilde;a olvidada',
                                    'mail_en'=>$mail_en,
                                    'mail_fr'=>$mail_fr,
                                    'mail_es'=>$mail_es
                                    ));
        }
    }

}
?>