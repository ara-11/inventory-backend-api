<?php
// delete.php

// ✅ CORS Headers
header("Access-Control-Allow-Origin: https://ara-11.github.io");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json");
header("X-Content-Type-Options: nosniff");


// ✅ Preflight check
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit();
}

include 'db.php';

// ✅ Decode the incoming JSON
//$data = json_decode(file_get_contents("php://input"), true); // decode as array

// ✅ Decode the incoming JSON as an object
$data = json_decode(file_get_contents("php://input")); // ← no second argument

// ✅ Log raw incoming data
error_log("🗑️ DELETE REQUEST: " . print_r($data, true));

// ✅ Extract and validate ID
//if (isset($data['id']) && is_numeric($data['id'])) {

// ✅ Extract and validate ID (object access)
if (isset($data->id) && is_numeric($data->id)) {
  $id = intval($data->id);  // ✅ Object-style access

  try {
    // ✅ PostgreSQL-safe delete with positional placeholder
    // ✅ Replace $1 with ?
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");// I debugged you for almost 2 days!!!! ikaw lang pala yung culprit
    $stmt->execute([$id]); //can you check this line

    $deleted = $stmt->rowCount();
    error_log("🧾 Deleted ID: $id | Rows affected: $deleted");

    if ($deleted > 0) {
      http_response_code(200); // ✅ optional, but clear
      echo json_encode(["message" => "Product deleted successfully"]);
    } else {
      http_response_code(404); // ⛔ not found
      echo json_encode(["error" => "No product found with that ID"]);
    }

  } catch (PDOException $e) {
    error_log("❌ DB Error: " . $e->getMessage());
    echo json_encode(["error" => "Deletion failed: " . $e->getMessage()]);
  }

} else {
  echo json_encode(["error" => "Invalid ID"]);
}
?>
