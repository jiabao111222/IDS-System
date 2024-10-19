<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include Composer's autoload file
require 'vendor/autoload.php';

// Define the function to send an email
function sendEmailToAdmin($ip, $fail_count, $time) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                            // Use SMTP
        $mail->Host = 'smtp.gmail.com';             // Set SMTP server address
        $mail->SMTPAuth = true;                     // Enable SMTP authentication
        $mail->Username = 'dongman20031220@gmail.com'; // SMTP username
        $mail->Password = 'rjygtkpnnabwcexk';       // Use an app-specific password instead of the main password
        $mail->SMTPSecure = 'tls';                  // Enable TLS encryption
        $mail->Port = 587;                          // TCP port number

        // Recipients
        $mail->setFrom('dongman20031220@gmail.com', 'IDS Security Team');
        $mail->addAddress('i22022602@student.newinti.edu.my', 'Dear User'); // Add a recipient

        // Content
        $mail->isHTML(true);                        // Set email format to HTML
        $mail->Subject = 'Security Alert !';
        $mail->Body    = '<h1>Security Alert: Multiple Failed Login Attempts</h1>' .
        '<p>The IP address <strong>' . htmlspecialchars($ip) . '</strong> has failed to log in <strong>' . htmlspecialchars($fail_count) . '</strong> times.</p>' .
        '<p>The most recent failed attempt occurred at <strong>' . htmlspecialchars($time) . '</strong>.</p>' .
        '<p>Please review the logs and take necessary action if required.</p>' .
        '<p>Best regards, <br> Your Security System</p>';

        $mail->send();
        echo 'Mail sent successfully.';
    } catch (Exception $e) {
        echo "Mail could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>
