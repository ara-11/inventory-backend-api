<?php
// read.php

// ✅ Handle preflight OPTIONS request first
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  header("Access-Control-Allow-Origin: https://ara-11.github.io");
  header("Access-Control-Allow-Headers: Content-Type");
  header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
  header("Access-Control-Allow-Credentials: true");
  header("X-Content-Type-Options: nosniff");
  http_response_code(200);
  exit();
}

// 🔒 Secure session cookie BEFORE session_start
session_set_cookie_params([
  'lifetime' => 0,
  'path' => '/',
  'domain' => '',
  'secure' => true,
  'httponly' => true,
  'samesite' => 'None',
]);
session_start();

// ✅ CORS and Content Headers
header("Access-Control-Allow-Origin: https://ara-11.github.io");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
header("X-Content-Type-Options: nosniff");

// ✅ Session Check
if (!isset($_SESSION['user_id'])) {
  http_response_code(403);
  echo json_encode(["error" => "Unauthorized"]);
  exit();
}

include 'db.php';

try {
  $stmt = $conn->prepare("SELECT * FROM products ORDER BY id DESC");
  $stmt->execute();

  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($products);
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(["error" => "Failed to fetch products: " . $e->getMessage()]);
}
?>
