<?php
// update.php

// ✅ Preflight OPTIONS request must be handled FIRST
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  header("Access-Control-Allow-Origin: https://ara-11.github.io");
  header("Access-Control-Allow-Headers: Content-Type");
  header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
  header("Access-Control-Allow-Credentials: true");
  header("X-Content-Type-Options: nosniff");
  http_response_code(200);
  exit();
}

// 🔒 Set secure session cookie settings BEFORE session_start
session_set_cookie_params([
  'lifetime' => 0,
  'path' => '/',
  'domain' => '',
  'secure' => true,
  'httponly' => true,
  'samesite' => 'None',
]);
session_start();

// ✅ Set CORS and content headers AFTER session_start
header("Access-Control-Allow-Origin: https://ara-11.github.io");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
header("X-Content-Type-Options: nosniff");

// ✅ Session check
if (!isset($_SESSION['user_id'])) {
  http_response_code(403); // Forbidden
  echo json_encode(["error" => "Unauthorized"]);
  exit();
}

include 'db.php';

$data = json_decode(file_get_contents("php://input"));

// ✅ Validate input
if (isset($data->id) && isset($data->name) && isset($data->quantity) && isset($data->price)) {
  try {
    $stmt = $conn->prepare("UPDATE products SET name = ?, quantity = ?, price = ? WHERE id = ?");
    $stmt->execute([$data->name, $data->quantity, $data->price, $data->id]);

    echo json_encode(["message" => "Product updated successfully"]);
  } catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to update product: " . $e->getMessage()]);
  }
} else {
  http_response_code(400);
  echo json_encode(["error" => "Invalid data"]);
}
?>
