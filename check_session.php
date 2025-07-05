<?php
// check_session.php

// ✅ Set secure cookie params BEFORE session_start
session_set_cookie_params([
  'lifetime' => 0,
  'path' => '/',
  'domain' => '', // Let PHP set automatically
  'secure' => true,
  'httponly' => true,
  'samesite' => 'None',
]);
session_start();

// ✅ CORS headers
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: https://ara-11.github.io");
header("Access-Control-Allow-Credentials: true");

// ✅ Session check
if (!isset($_SESSION['user_id'])) {
  http_response_code(403); // Forbidden
  echo json_encode(["error" => "Unauthorized"]);
  exit();
}

// ✅ Already logged in
echo json_encode(["loggedIn" => true]);
?>
