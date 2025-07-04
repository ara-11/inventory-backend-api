<?php
//delete.php

header("Access-Control-Allow-Origin: https://ara-11.github.io");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json");

include 'db.php';

$data = json_decode(file_get_contents("php://input"));

$id = isset($data->id) ? intval($data->id) : null;
// Debug log (optional for Render logs)
error_log("🗑️ DELETE REQUEST: " . print_r($data, true));//Moved the error_log() after $data is set

if ($id) {
  try {
    $stmt = $conn->prepare("DELETE FROM products WHERE id = $1");
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
      echo json_encode(["message" => "Product deleted successfully"]);
    } else {
      echo json_encode(["error" => "No product found with that ID"]);
    }
  } catch (PDOException $e) {
    echo json_encode(["error" => "Deletion failed: " . $e->getMessage()]);
  }
} else {
  echo json_encode(["error" => "Invalid ID"]);
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
