<?php

namespace Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


class Mail {
    public $mail;

    function __construct()
    {
        $conf = getConf('mail');

        $this->mail = new PHPMailer(true);
        $this->mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $this->mail->isSMTP();                                            //Send using SMTP
        $this->mail->Host       = $conf['Host'];                     //Set the SMTP server to send through
        $this->mail->SMTPAuth   = $conf['SMTPAuth'];                                   //Enable SMTP authentication
        $this->mail->Username   = $conf['Username'];                     //SMTP username
        $this->mail->Password   = $conf['Password'];                               //SMTP password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $this->mail->Port       = $conf['Port'];
        $this->mail->CharSet = $conf['CharSet'];

    }


    // DEMO FUNCTION
    function testSend(){
        //Recipients
        
        $this->mail->setFrom('hoangvananhnghia@hoimetruyen.com', 'Nghiadz');

        $this->mail->addAddress('hoangvananhnghia@gmail.com', 'John Doe');

        //Content
        $this->mail->isHTML(true);                                  //Set email format to HTML
        $this->mail->Subject = 'Xin chàoo';
        $this->mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if (!$this->mail->send()) {
            echo 'Mailer Error: ' . $this->mail->ErrorInfo;
        } else {
            echo 'Message sent!';
        }
    }
}