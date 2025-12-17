<?php


session_start();
header('Content-Type: application/json');
include "../config/db_connect.php";


$contact_id = (int)($_POST['contact_id'] ?? 0);
if ($contact_id <= 0) {
  echo json_encode(['success' => false, 'error' => 'Invalid contact id']);
  exit;
}

$stmt = $pdo->prepare("SELECT type FROM contacts WHERE id = ?");
$stmt->execute([$contact_id]);
$row = $stmt->fetch();

if (!$row) {
  echo json_encode(['success' => false, 'error' => 'Contact not found']);
  exit;
}

$newType = ($row['type'] === 'Sales Lead') ? 'Support' : 'Sales Lead';

$upd = $pdo->prepare("UPDATE contacts SET type = ?, updated_at = NOW() WHERE id = ?");
$upd->execute([$newType, $contact_id]);

echo json_encode(['success' => true, 'type' => $newType]);
