<?php
$client_key = 'YOUR_CLIENT_KEY';
$client_secret = 'YOUR_CLIENT_SECRET';
$redirect_uri = 'http://localhost/html/LiveMabar/tiktok-callback.php';
$code = $_GET['code'];

// Step: Get access token
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://open.tiktokapis.com/v2/oauth/token/");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
  "client_key" => $client_key,
  "client_secret" => $client_secret,
  "code" => $code,
  "grant_type" => "authorization_code",
  "redirect_uri" => $redirect_uri
]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$data = json_decode($response, true);
curl_close($ch);

$access_token = $data['data']['access_token'];

// Step: Get user info
$ch = curl_init("https://open.tiktokapis.com/v2/user/info/");
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $access_token"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$user_info = json_decode($response, true);
curl_close($ch);

// Cek data dan arahkan ke profile
$username = $user_info['data']['user']['display_name'];
header("Location: profile.php?username=" . urlencode($username));
?>
