<?php
// logout.php

// 🔐 Secure session cookie setup
session_set_cookie_params([
  'lifetime' => 0,
  'path' => '/',
  'domain' => '',
  'secure' => true,
  'httponly' => true,
  'samesite' => 'None',
]);
session_start();

// ✅ CORS headers
header("Access-Control-Allow-Origin: https://ara-11.github.io");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");
header("X-Content-Type-Options: nosniff");

// ✅ Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit();
}

// ✅ Unset session variables
$_SESSION = [];

// ✅ Destroy session
if (session_id()) {
  session_destroy();
}

// ✅ Delete session cookie on client
$cookieParams = session_get_cookie_params();
setcookie(
  session_name(),
  '',
  [
    'expires' => time() - 3600, // Expire it in the past
    'path' => $cookieParams['path'],
    'domain' => '',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'None',
  ]
);

// ✅ Response
echo json_encode(["message" => "Logged out successfully"]);
