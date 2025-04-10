<?php
function checkPasswordStrength($password) {
    $strength = "Weak";

    if (s

    return $strength;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"] ?? '';
    $strength = checkPasswordStrength($password);
    echo "<h2>Server-side Strength: $strength</h2>";
    echo "<a href='javascript:history.back()'>Try again</a>";
}
?>
