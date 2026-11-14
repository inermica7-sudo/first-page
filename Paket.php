<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/phpmailer/Exception.php';
require __DIR__ . '/phpmailer/PHPMailer.php';
require __DIR__ . '/phpmailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ime = isset($_POST["ime"]) ? htmlspecialchars($_POST["ime"]) : '';
    $email = isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : '';
    $poruka = isset($_POST["zelje"]) ? htmlspecialchars($_POST["zelje"]) : '';

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'mail.plesnaoblacimakonjic.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kontakt@plesnaoblacimakonjic.com';
        $mail->Password = 'TestMail123!er'; // Unesi stvarnu lozinku
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('kontakt@plesnaoblacimakonjic.com', 'Ples na oblacima');
        $mail->addAddress('prvipleskonjic@gmail.com');
        $mail->addReplyTo($email, $ime);

        $mail->Subject = "Upit za paket sa web stranice";
        $mail->Body =
            "Nova poruka u vezi paketa:\n\n" .
            "Ime: $ime\n" .
            "Email: $email\n\n" .
            "Poruka:\n$poruka";

        $mail->send();
        echo "Hvala, vaša poruka je uspješno poslana.";
        // header('Location: hvala.html'); // po želji redirect
    } catch (Exception $e) {
        echo "Greška prilikom slanja: " . $mail->ErrorInfo;
    }
}
