<?php
include 'db.php';

try {
  $sql = "CREATE TABLE IF NOT EXISTS products (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    quantity INTEGER NOT NULL,
    price NUMERIC(10, 2) NOT NULL
  )";

  $conn->exec($sql);
  echo "✅ Table 'products' created successfully.";
} catch (PDOException $e) {
  echo "❌ Error creating table: " . $e->getMessage();
}
?>
