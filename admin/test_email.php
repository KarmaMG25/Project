<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // SMTP server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'your@gmail.com';         // 🔁 replace
    $mail->Password   = 'your_app_password';      // 🔁 use app password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Email content
    $mail->setFrom('your@gmail.com', 'Angus & Coote');
    $mail->addAddress('recipient@example.com', 'Test User');  // 🔁 replace

    $mail->isHTML(true);
    $mail->Subject = 'Test Email from PHPMailer';
    $mail->Body    = '🎉 Hello! This is a <strong>test email</strong> from your Angus & Coote system.';

    $mail->send();
    echo '✅ Message sent successfully.';
} catch (Exception $e) {
    echo "❌ Message could not be sent. Error: {$mail->ErrorInfo}";
}
