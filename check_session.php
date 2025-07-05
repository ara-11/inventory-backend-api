<?php

session_start();
if (!isset($_SESSION['user_id'])) {
  http_response_code(403); // Forbidden
  echo json_encode(["error" => "Unauthorized"]);
  exit();
}

// ✅ Headers for frontend access
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: https://ara-11.github.io");
header("Access-Control-Allow-Credentials: true");

// ✅ Check if user is logged in
if (isset($_SESSION['user_id'])) {
  echo json_encode(["loggedIn" => true]);
} else {
  http_response_code(401);
  echo json_encode(["error" => "Not logged in"]);
}
