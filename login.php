<?php
// login.php
// 🔒 Ensure secure session cookie settings
session_set_cookie_params([
  'lifetime' => 0,
  'path' => '/',
  'domain' => '', // let PHP auto-set
  'secure' => true,
  'httponly' => true,
  'samesite' => 'None', // ⛔ MUST BE EXACTLY 'None'
]);
session_start();

// ✅ Handle preflight request immediately
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: https://ara-11.github.io");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("X-Content-Type-Options: nosniff");
    http_response_code(200);
    exit();
}


ini_set('session.cookie_samesite', 'None');
ini_set('session.cookie_secure', '1');

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: https://ara-11.github.io");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("X-Content-Type-Options: nosniff");

include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
error_log("🔥 Login POST received: " . file_get_contents("php://input"));
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
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
