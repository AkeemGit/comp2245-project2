<?php
session_start();

include '../config/db_connect.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    $data = $_POST;
}

if (!isset($data['email']) || !isset($data['password'])) {
    echo json_encode(["status" => "error", "message" => "Email and password required."]);
    exit;
}

$email = trim($data['email']);
$password = trim($data['password']);

if (empty($email) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Email and password cannot be empty."]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["status" => "error", "message" => "Invalid email format."]);
    exit;
}

$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":email", $email);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($result) === 1) {
    $user = $result[0];

    if (password_verify($password, $user['password'])) {
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];

        echo json_encode(["status" => "success"]);
        exit;
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid password."]);
        exit;
    }
} else {
    echo json_encode(["status" => "error", "message" => "User not found."]);
    exit;
}
