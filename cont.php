<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input
    $name = htmlspecialchars(strip_tags(trim($_POST["name"])));
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(strip_tags(trim($_POST["message"])));

    // Validate fields
    if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($message)) {
        $to = "your_email@example.com"; // Change to your email
        $subject = "New Contact Form Submission from $name";
        $headers = "From: $email\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8";

        // Email content
        $email_body = "You have received a new message from your website contact form:\n\n";
        $email_body .= "Name: $name\n";
        $email_body .= "Email: $email\n\n";
        $email_body .= "Message:\n$message\n";

        // Send email
        if (mail($to, $subject, $email_body, $headers)) {
            echo "Message sent successfully!";
        } else {
            echo "Message sending failed!";
        }
    } else {
        echo "Please fill all fields correctly.";
    }
} else {
    echo "Invalid request.";
}
?>
