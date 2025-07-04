<?php
// update.php
header("Access-Control-Allow-Origin: https://ara-11.github.io");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json");
header("X-Content-Type-Options: nosniff");
/*
include 'db.php';

$data = json_decode(file_get_contents("php://input"));

if(isset($data->id) && isset($data->name) && isset($data->quantity) && isset($data->price)) {
  $stmt = $conn->prepare("UPDATE products SET name=?, quantity=?, price=? WHERE id=?");
  $stmt->execute([$data->name, $data->quantity, $data->price, $data->id]);

  echo json_encode(["message" => "Product updated successfully"]);
} else {
  echo json_encode(["message" => "Invalid data"]);
}
 */
include 'db.php';

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id) && isset($data->name) && isset($data->quantity) && isset($data->price)) {
  try {
    $stmt = $conn->prepare("UPDATE products SET name = ?, quantity = ?, price = ? WHERE id = ?");
    $stmt->execute([$data->name, $data->quantity, $data->price, $data->id]);

    echo json_encode(["message" => "Product updated successfully"]);
  } catch (PDOException $e) {
    echo json_encode(["error" => "Failed to update product: " . $e->getMessage()]);
  }
} else {
  echo json_encode(["error" => "Invalid data"]);
}
?>
