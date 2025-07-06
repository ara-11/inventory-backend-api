<?php
$password = "admin123"; // change this if you want a different password
$hashed = password_hash($password, PASSWORD_DEFAULT);

echo "✅ Hashed Password for '$password':<br>";
echo "<code>$hashed</code>";
?>
