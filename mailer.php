<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require("vendor/autoload.php");

function mailer($to, $subject, $body)
{
    $mail = new PHPMailer();

    try {
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Host = "smtp-mail.outlook.com";
        $mail->Port = 587;
        $mail->Username = "Mouhssine.Lakhili@imie-paris.fr";
        $mail->Password = "";
        $mail->SetFrom("Mouhssine.Lakhili@imie-paris.fr", "Mouhssine");
        $mail->Subject = "Test Email (PHPMailer)";
        $mail->Body = "Hello! c'est Mouhssine, je suis en train de test mon PHPMailer";
        $mail->AddAddress("mlakhili89@gmail.com");

        $mail->send();
    } catch (Exception $e) {
        echo "error: $e";
    }
}