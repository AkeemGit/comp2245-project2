<?php

/* CODE FOR SERVER ON SHAKYR'S MACHINE

$host = "localhost";
$port = "8889";
$db   = "dolphin_crm";
$user = "root";
$pass = "root";

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}
*/

// CODE FOR EVERYONE ELSE'S SERVER. 
session_start();
header('Content-Type: application/json');
include "../config/db_connect.php";

if (!isset($_SESSION['user_id'])) {
  echo json_encode(['success' => false, 'error' => 'Unauthorized']);
  exit;
}

$current_user_id = (int)$_SESSION['user_id'];

$contact_id = (int)($_POST['contact_id'] ?? 0);
if ($contact_id <= 0) {
  echo json_encode(['success' => false, 'error' => 'Invalid contact id']);
  exit;
}

$stmt = $pdo->prepare("UPDATE contacts SET assigned_to = ?, updated_at = NOW() WHERE id = ?");
$stmt->execute([$current_user_id, $contact_id]);

echo json_encode(['success' => true]);