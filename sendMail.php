<?php
// Email recipient
$to = "recipient@example.com"; 

// Email subject
$subject = "Test Email from Server";

// Email body
$message = "This is a test email sent from a PHP script.";

// Headers
$headers = "From: sender@example.com\r\n";
$headers .= "Reply-To: sender@example.com\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send email
if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully to $to";
} else {
    echo "Failed to send email.";
}
?>
