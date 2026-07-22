<?php
use PHPMailer\PHPMailer\PHPMailer;

// Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);

// Server settings
$mail->SMTPDebug = 2;                                     // Enable verbose debug output
$mail->isSMTP();                                            // Send using SMTP
$mail->Host = 'smtp.gmail.com';                       // Set the SMTP server to send through
$mail->SMTPAuth = true;                                   // Enable SMTP authentication
$mail->Username = 'bouganvilleee@gmail.com';             // SMTP username
$mail->Password = 'jozi khqb jisg uasz';                     // SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           // Enable implicit TLS encryption
$mail->Port = 465;

if (isset($_POST['kirim'])) {
    // Recipients
    $mail->setFrom('bouganvilleee@gmail.com', 'Rahma Khoyrul');
    $mail->addAddress($_POST['email_penerima']);           // penerima
    $mail->addReplyTo('tbouganvilleee@gmail.com', 'Rahma Khoyrul');

    $mail->Subject = $_POST['subject'];
    $mail->Body = $_POST['pesan'];

    if ($mail->send()) {
        echo "<script>
            alert('Email Berhasil Dikirimkan');
            document.location.href = 'email.php';
            </script>";
    } else {
        echo "<script>
            alert('Email Gagal Dikirimkan');
            document.location.href = 'email.php';
            </script>";
    }
    exit();
}