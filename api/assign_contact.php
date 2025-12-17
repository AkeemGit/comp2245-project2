<?php
session_start();
header('Content-Type: application/json');
include "../config/db_connect.php";

// Get logged-in user ID
$assigned_user_id = $_SESSION['user_id'] ?? 0;

// Get contact ID from POST
$contact_id = (int)($_POST['contact_id'] ?? 0);

if ($contact_id <= 0) {
  echo json_encode(['success' => false, 'error' => 'Invalid contact ID']);
  exit;
}

if ($assigned_user_id <= 0) {
  echo json_encode(['success' => false, 'error' => 'User not logged in']);
  exit;
}

// Check if contact exists
$contactStmt = $pdo->prepare("SELECT id FROM contacts WHERE id = ?");
$contactStmt->execute([$contact_id]);
$contact = $contactStmt->fetch(PDO::FETCH_ASSOC);

if (!$contact) {
  echo json_encode(['success' => false, 'error' => 'Contact not found']);
  exit;
}

// Update contact's assigned_to field
$updateStmt = $pdo->prepare("UPDATE contacts SET assigned_to = ?, updated_at = NOW() WHERE id = ?");
$updateStmt->execute([$assigned_user_id, $contact_id]);

// Fetch assigned user's name
$userStmt = $pdo->prepare("SELECT firstname, lastname FROM users WHERE id = ?");
$userStmt->execute([$assigned_user_id]);
$user = $userStmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
  echo json_encode([
    'success' => true,
    'assigned_name' => $user['firstname'] . ' ' . $user['lastname']
  ]);
} else {
  echo json_encode(['success' => false, 'error' => 'Assigned user not found']);
}

exit;
