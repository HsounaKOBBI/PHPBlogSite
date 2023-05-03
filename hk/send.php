<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\EXCEPTION;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(isset($_POST['send'])){
    $mail = new PHPMailer(true);
    $mail->WordWrap     = 50;
    $mail -> SMTPDebug = 1;
    $mail->isSMTP();
    $mail->HOST='smtp.gmail.com';
    $mail->SMTPAuth=true;
    $mail->username='h.kobbi.12@gmail.com';
    $mail->Password='qugsxtbdmnveujqa';
    $mail->SMTPSecure='ssl';
    $mail->SMTPSecure = false;
$mail->SMTPAutoTLS = false;
    $mail->Port = 587;
   

    $mail->setFrom('h.kobbi.12@gmail.com');
    $mail->addAddress($_POST["email"]);

    $mail->isHTML(true);
    $mail->Subject= $_POST['subject'];
    $mail->Body= $_POST["description"];
    $mail->send();

    echo 
    "
    <script>
    alert('sent successfully');
    document.location.href='contact.php';
    </script>
    ";



}

?>