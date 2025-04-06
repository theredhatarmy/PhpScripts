<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize form inputs
    $name    = htmlspecialchars(trim($_POST["name"]));
    $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST["message"]));

    // Validate inputs
    if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($message)) {
        $to      = "your_email@example.com"; // Change this to your email
        $subject = "New Contact Form Message from $name";
        $headers = "From: $name <$email>\r\nReply-To: $email\r\n";
        $body    = "Name: $name\nEmail: $email\n\nMessage:\n$message";

        if (mail($to, $subject, $body, $headers)) {
            echo "Message sent successfully!";
        } else {
            echo "Sorry, something went wrong.";
        }
    } else {
        echo "Please fill in all fields correctly.";
    }
}
?>
