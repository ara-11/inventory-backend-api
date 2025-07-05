<?php
//check_session.php
// 🔒 Ensure secure session cookie settings
session_set_cookie_params([
  'lifetime' => 0,
  'path' => '/',
  'domain' => '', // let PHP auto-set
  'secure' => true,
  'httponly' => true,
  'samesite' => 'None', // ⛔ MUST BE EXACTLY 'None'
]);
session_start();

ini_set('session.cookie_samesite', 'None');
ini_set('session.cookie_secure', '1');


// ✅ Headers for frontend access
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: https://ara-11.github.io");
header("Access-Control-Allow-Credentials: true");


if (!isset($_SESSION['user_id'])) {
  http_response_code(403); // Forbidden
  echo json_encode(["error" => "Unauthorized"]);
  exit();
}
// ✅ Check if user is logged in
if (isset($_SESSION['user_id'])) {
  echo json_encode(["loggedIn" => true]);
} else {
  http_response_code(401);
  echo json_encode(["error" => "Not logged in"]);
}
