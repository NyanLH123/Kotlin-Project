<?php
header("Content-Type: application/json");
require_once "db_connect.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "Only POST request is allowed"
    ]);
    exit;
}

$login = trim($_POST['login'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($login === '' || $password === '') {
    http_response_code(422);
    echo json_encode([
        "success" => false,
        "message" => "Username/email and password are required"
    ]);
    exit;
}

$stmt = $conn->prepare("SELECT id, firstname, lastname, username, email, password FROM users WHERE username = ? OR email = ? LIMIT 1");
$stmt->bind_param("ss", $login, $login);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(401);
    echo json_encode([
        "success" => false,
        "message" => "User not found"
    ]);
    exit;
}

$user = $result->fetch_assoc();

if (!password_verify($password, $user['password'])) {
    http_response_code(401);
    echo json_encode([
        "success" => false,
        "message" => "Incorrect password"
    ]);
    exit;
}

unset($user['password']);

http_response_code(200);
echo json_encode([
    "success" => true,
    "message" => "Login successful",
    "user" => $user
]);
?>