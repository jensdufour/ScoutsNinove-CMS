<?php 
require $_SERVER['DOCUMENT_ROOT'].'/mail/sendMail.php';
$name = $_POST['naam'];
$email = $_POST['email'];
$subject = $_POST['onderwerp'];
$message = $_POST['bericht'];
$message = "<h1>Nieuw bericht van het contactformulier</h1><p><b>Onderwerp:</b> $subject <br><b>Verstuurd door:</b> $name -  $email<br><b>Bericht:</b><br>$message</p>";
$recipient = $_POST['ontvanger'];
$mailer = new Mailer($message,"contactform","$name contact website",$recipient,$recipient,$subject,$email,$name);
if($mailer->response == 200){
    echo "<script>window.location.replace('/contact.html');</script>";
    //Mail versturen gelukt
}else{
    echo "<script>window.location.replace('/contact.html');</script>";
    //Mail versturen mislukt
}
?>