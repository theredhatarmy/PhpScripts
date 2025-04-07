function getAccessToken($consumerKey, $consumerSecret) {
    $credentials = base64_encode("$consumerKey:$consumerSecret");

    $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
    $headers = [
        "Authorization: Basic $credentials"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response);
    return $result->access_token ?? null;
}
