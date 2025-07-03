<?php
/*
$host = "localhost";
$db_name = "inventory_system_db";
$username = "root";
$password = "";

*/

/*

$host = "sql112.infinityfree.com";
$db_name = "if0_39318008_inventory_system_db";
$username = "if0_39318008";
$password = "HKOtjowzFJcnQ";


try {
  $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  exit();
}
*/

$host = "dpg-d1j3ct2dbo4c73c33crg-a.oregon-postgres.render.com";
$db_name = "inventory_db_jcjd";
$username = "inventory_db_jcjd_user";
$password = "pTgrg6UPpMrsbDy2gnlpKHR5yHnAp62k";

try {
  $conn = new PDO("pgsql:host=$host;port=5432;dbname=$db_name", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  exit();
}
?>
