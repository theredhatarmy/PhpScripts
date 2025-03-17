<?php
session_start();

// Generate a random 6-character string
$captchaText = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZ23456789"), 0, 6);
$_SESSION['captcha'] = $captchaText; // Store in session

// Create an image
$width = 150;
$height = 50;
$image = imagecreate($width, $height);

// Colors
$bgColor = imagecolorallocate($image, 255, 255, 255); // White background
$textColor = imagecolorallocate($image, 0, 0, 0); // Black text
$lineColor = imagecolorallocate($image, 64, 64, 64); // Grey noise lines

// Add random lines for noise
for ($i = 0; $i < 5; $i++) {
    imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $lineColor);
}

// Add the CAPTCHA text
imagettftext($image, 20, rand(-10, 10), 20, 35, $textColor, __DIR__ . '/arial.ttf', $captchaText);

// Output image
header("Content-type: image/png");
imagepng($image);
imagedestroy($image);
?>
