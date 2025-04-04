<?php
date_default_timezone_set('Africa/Nairobi');

// M-Pesa API Credentials
$consumerKey = "YOUR_CONSUMER_KEY"; 
$consumerSecret = "YOUR_CONSUMER_SECRET";

// M-Pesa Shortcode & Passkey
$BusinessShortCode = "YOUR_SHORTCODE";
$PassKey = "YOUR_PASSKEY";

// Transaction Details
$phoneNumber = "2547XXXXXXXX"; // Customer's Phone Number (Format: 2547XXXXXXXX)
$amount = "1"; // Amount to be paid
$callbackUrl = "https://yourdomain.com/callback.php"; // Your callback URL

// Generate Timestamp
$timestamp = date("YmdHis");

// Generate Password
$password = base64_encode($BusinessShortCode . $PassKey . $timestamp);

// Generate Access Token
$tokenUrl = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
$stkPushUrl = "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";

// cURL request to get access token
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $tokenUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Basic " . base64_encode("$consumerKey:$consumerSecret")]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = json_decode(curl_exec($ch));
curl_close($ch);

$accessToken = $response->access_token;

// STK Push Request Data
$requestData = [
    "BusinessShortCode" => $BusinessShortCode,
    "Password" => $password,
    "Timestamp" => $timestamp,
    "TransactionType" => "CustomerPayBillOnline",
    "Amount" => $amount,
    "PartyA" => $phoneNumber,
    "PartyB" => $BusinessShortCode,
    "PhoneNumber" => $phoneNumber,
    "CallBackURL" => $callbackUrl,
    "AccountReference" => "TestPayment",
    "TransactionDesc" => "Payment for Order"
];

// Send STK Push Request
$ch = curl_init($stkPushUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $accessToken", "Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Display Response
echo $response;
?>
