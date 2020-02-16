<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require $_SERVER['DOCUMENT_ROOT'].'/plugins/vendor/autoload.php';
class Mailer{
    var $message;
    var $kind;
    var $fromName;
    var $to;
    var $toName;
    var $subj;
    var $replyTo;
    var $replyToName;
    var $mailer;
    var $design;
    var $response;
    var $errormsg;

    function __construct($msg,$kind,$fromName,$to,$toName,$subj,$replyTo,$replyToName){
        $this->message = $msg;
        $this->kind = $kind;
        $this->fromName = $fromName;
        $this->to = $to;
        $this->toName = $toName;
        $this->subj = $subj;
        $this->replyTo = $replyTo;
        $this->replyToName = $replyToName;
        $this->mailer = new PHPMailer(true);
        $this->createMailer();
        $this->createMail();
        $answer = $this->sendMail();
    }

    function createMailer(){
        $this->mailer->SMTPDebug=0;
        $this->mailer->isSMTP();
        $this->mailer->Host = 'mail.ident-it.be';
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'jens@ident-it.be';
        $this->mailer->Password = 'pT3uSLvCnGCV';
        $this->mailer->SMTPSecure = 'ssl';
        $this->mailer->Port = 465;
        $this->mailer->setFrom('jens@ident-it.be',$this->fromName);
        $this->mailer->addAddress($this->to,$this->toName);
        $this->mailer->addReplyTo($this->replyTo, $this->replyToName);
    }

    function createMail(){
        $kind = $this->kind;
        $this->design = file_get_contents($_SERVER['DOCUMENT_ROOT']."/mail/template/".$kind."/layout.html");
        $this->design = str_replace('{{%message%}}',$this->message,$this->design);
        $this->design = str_replace('{{%email%}}',$this->to,$this->design);
        $this->design = str_replace('{{%subject%}}',$this->subj,$this->design);
        $this->mailer->isHTML(true);
        $this->mailer->Subject = $this->subj;
        $this->mailer->Body = $this->design;
    }

    function sendMail(){
        try {   
            $this->mailer->send();
            $this->response = 200;
        } catch (Exception $e) {
           $this->response =  400;
           $this->errormsg = $e->getMessage();
        }
    }
}
?>