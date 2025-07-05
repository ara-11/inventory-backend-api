<?php
// login.php

// ✅ Set secure session cookie params BEFORE session_start
session_set_cookie_params([
  'lifetime' => 0,
  'path' => '/',
  'domain' => '', // Let PHP auto-detect
  'secure' => true,
  'httponly' => true,
  'samesite' => 'None',
]);
session_start();

// ✅ Handle preflight OPTIONS request first
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: https://ara-11.github.io");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("X-Content-Type-Options: nosniff");
    http_response_code(200);
    exit();
}

// ✅ Now send CORS and content headers (AFTER session_start)
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: https://ara-11.github.io");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("X-Content-Type-Options: nosniff");

include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];

        // ✅ Explicitly resend the cookie (Render sometimes requires this)
        $cookieParams = session_get_cookie_params();
        setcookie(
            session_name(),
            session_id(),
            [
                'expires' => time() + 3600,
                'path' => $cookieParams["path"],
                'domain' => '',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'None',
            ]
        );

        echo json_encode(["success" => true, "message" => "Login successful"]);
    } else {
        http_response_code(401);
        echo json_encode(["error" => "Invalid credentials"]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Server error: " . $e->getMessage()]);
}
?>
