<?php
// add.php

// ✅ Handle preflight OPTIONS request early
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: https://ara-11.github.io");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Credentials: true");
    header("X-Content-Type-Options: nosniff");
    http_response_code(200);
    exit();
}

// ✅ Set secure session cookie settings BEFORE session_start
session_set_cookie_params([
  'lifetime' => 0,
  'path' => '/',
  'domain' => '',
  'secure' => true,
  'httponly' => true,
  'samesite' => 'None',
]);
session_start();

// ✅ CORS Headers AFTER session_start
header("Access-Control-Allow-Origin: https://ara-11.github.io");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
header("X-Content-Type-Options: nosniff");

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  http_response_code(403);
  echo json_encode(["error" => "Unauthorized"]);
  exit();
}

include 'db.php';

$data = json_decode(file_get_contents("php://input"));

// ✅ Log for Render debugging
error_log("Incoming POST data: " . print_r($data, true));

// ✅ Validate & insert
if (isset($data->name) && isset($data->quantity) && isset($data->price)) {
  try {
    $stmt = $conn->prepare("INSERT INTO products (name, quantity, price) VALUES (?, ?, ?)");
    $stmt->execute([$data->name, $data->quantity, $data->price]);

    echo json_encode(["message" => "Product added successfully"]);
  } catch (PDOException $e) {
    echo json_encode(["message" => "Error: " . $e->getMessage()]);
  }
} else {
  echo json_encode(["message" => "Invalid data"]);
}
?>
