<?php
// Define recipient email
$to = "recipient@example.com"; 

// Email subject
$subject = "Test Email from PHP Script";

// Capture current date and time
$date = date("Y-m-d H:i:s");

// Email content with HTML formatting
$message = "
<html>
<head>
    <title>Test Email</title>
</head>
<body>
    <h2>Server Email Test</h2>
    <p>This is a test email sent from a PHP script.</p>
    <p><strong>Timestamp:</strong> $date</p>
    <hr>
    <p style='color:blue;'>This is an automated message. Please do not reply.</p>
</body>
</html>
";

// Set headers
$headers = "From: Sender Name <sender@example.com>\r\n";
$headers .= "Reply-To: sender@example.com\r\n";
$headers .= "CC: cc_recipient@example.com\r\n"; // Optional CC recipient
$headers .= "BCC: bcc_recipient@example.com\r\n"; // Optional BCC recipient
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n"; // Enable HTML email

// Attempt to send the email
if (mail($to, $subject, $message, $headers)) {
    echo "✅ Email sent successfully to $to on $date";
} else {
    echo "❌ Failed to send email. Check server email settings.";
}
?>
