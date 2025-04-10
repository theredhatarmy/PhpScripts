<?php
function checkPasswordStrength($password) {
    $strength = "Weak";

    if (strlen($password) >= 8) {
        $hasUpper  = preg_match('@[A-Z]@', $password);
        $hasLower  = preg_match('@[a-z]@', $password);
        $hasNumber = preg_match('@[0-9]@', $password);
        $hasSymbol = preg_match('@[^\w]@', $password);

        if ($hasUpper && $hasLower && $hasNumber && $hasSymbol) {
            $strength = "Strong";
        } elseif (($hasUpper || $hasLower) && $hasNumber) {
            $strength = "Medium";
        }
    }

    return $strength;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"] ?? '';
    $strength = checkPasswordStrength($password);
    echo "<h2>Server-side Strength: $strength</h2>";
    echo "<a href='javascript:history.back()'>Try again</a>";
}
?>
