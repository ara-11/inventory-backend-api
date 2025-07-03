<?php
//delete.php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json");
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
include 'db.php';

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id)) {
  try {
    $stmt = $conn->prepare("DELETE FROM products WHERE id = $1");
    $stmt->execute([$data->id]);

    echo json_encode(["message" => "Product deleted successfully"]);
  } catch (PDOException $e) {
    echo json_encode(["error" => "Deletion failed: " . $e->getMessage()]);
  }
} else {
  echo json_encode(["message" => "Invalid ID"]);
}
?>
