<?php
//delete.php

header("Access-Control-Allow-Origin: https://ara-11.github.io");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json");

include 'db.php';

$data = json_decode(file_get_contents("php://input"));
// Debug log (optional for Render logs)
error_log("🗑️ DELETE REQUEST: " . print_r($data, true));//Moved the error_log() after $data is set

if (isset($data->id)) {
  try {
     // ✅ PostgreSQL-style placeholder
    $stmt = $conn->prepare("DELETE FROM products WHERE id = $1");
    $stmt->execute([$data->id]);

    echo json_encode(["message" => "Product deleted successfully"]);
  } catch (PDOException $e) {
    echo json_encode(["error" => "Deletion failed: " . $e->getMessage()]);
  }
} else {
  echo json_encode(["message" => "Invalid ID"]);
}
/*
include 'db.php';

$data = json_decode(file_get_contents("php://input"));

if(isset($data->id)) {
  $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
  $stmt->execute([$data->id]);

  echo json_encode(["message" => "Product deleted successfully"]);
} else {
  echo json_encode(["message" => "Invalid ID"]);
}
*/
?>
