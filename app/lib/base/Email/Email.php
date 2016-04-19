<?php
class Email {

    static public function send($mailTo, $subject, $htmlMail, $replyTo='') {
        //Format headers to send an email
        $replyTo = ($replyTo=='') ? Params::param('email') : $replyTo;
        $headers = 'MIME-Version: 1.0'."\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
        $headers .= 'From: "'.Params::param('titlePage').'" <'.Params::param('email').'>'."\r\n";
        $headers .= 'Reply-To: '.$replyTo.''."\r\n";
        $headers .= 'X-Mailer: PHP/'.phpversion();
        return @mail($mailTo, html_entity_decode($subject), utf8_decode($htmlMail), $headers);
    }
    
}
?>