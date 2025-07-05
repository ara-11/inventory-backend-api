<?php
// delete.php

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

// ✅ Secure session cookies BEFORE session_start
session_set_cookie_params([
  'lifetime' => 0,
  'path' => '/',
  'domain' => '',
  'secure' => true,
  'httponly' => true,
  'samesite' => 'None',
]);
session_start();

// ✅ CORS headers AFTER session_start
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

// ✅ Decode incoming JSON (as object)
$data = json_decode(file_get_contents("php://input"));

// ✅ Log for debugging (optional)
error_log("🗑️ DELETE REQUEST: " . print_r($data, true));

// ✅ Validate and delete
if (isset($data->id) && is_numeric($data->id)) {
  $id = intval($data->id);

  try {
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);

    $deleted = $stmt->rowCount();
    error_log("🧾 Deleted ID: $id | Rows affected: $deleted");

    if ($deleted > 0) {
      http_response_code(200);
      echo json_encode(["message" => "Product deleted successfully"]);
    } else {
      http_response_code(404);
      echo json_encode(["error" => "No product found with that ID"]);
    }

  } catch (PDOException $e) {
    error_log("❌ DB Error: " . $e->getMessage());
    echo json_encode(["error" => "Deletion failed: " . $e->getMessage()]);
  }

} else {
  http_response_code(400);
  echo json_encode(["error" => "Invalid ID"]);
}
?>
