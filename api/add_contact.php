<?php

session_start();
header('Content-Type: application/json');
include "../config/db_connect.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

function clean($v)
{
    return trim((string)$v);
}


$title       = clean($_POST['title'] ?? '');
$firstname   = clean($_POST['firstname'] ?? '');
$lastname    = clean($_POST['lastname'] ?? '');
$email       = clean($_POST['email'] ?? '');
$telephone   = clean($_POST['telephone'] ?? '');
$company     = clean($_POST['company'] ?? '');
$type        = clean($_POST['type'] ?? '');
$assigned_to = (int)($_POST['assigned_to'] ?? 0);
$created_by = (int)$_SESSION['user_id'];


$errors = [];
if ($title === '') $errors[] = "Title is required";
if ($firstname === '') $errors[] = "First name is required";
if ($lastname === '') $errors[] = "Last name is required";
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
if ($telephone === '') $errors[] = "Telephone is required";
if ($company === '') $errors[] = "Company is required";
if ($type !== 'Sales Lead' && $type !== 'Support') $errors[] = "Type must be Sales Lead or Support";
if ($assigned_to <= 0) $errors[] = "Assigned To is required";

if (!empty($errors)) {
    echo json_encode(['success' => false, 'error' => implode(". ", $errors)]);
    exit;
}

try {
    $sql = "INSERT INTO contacts
        (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by, created_at, updated_at)
        VALUES
        (:title, :firstname, :lastname, :email, :telephone, :company, :type, :assigned_to, :created_by, NOW(), NOW())";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':title' => $title,
        ':firstname' => $firstname,
        ':lastname' => $lastname,
        ':email' => $email,
        ':telephone' => $telephone,
        ':company' => $company,
        ':type' => $type,
        ':assigned_to' => $assigned_to,
        ':created_by' => $created_by
    ]);

    echo json_encode(['success' => true, 'contact_id' => (int)$pdo->lastInsertId()]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Could not save contact']);
}
