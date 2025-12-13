<?php
session_start();
include "../config/db_connect.php";

$allowed_filters = ['all', 'sales', 'support', 'assigned'];
$filter = isset($_GET['filter']) && in_array($_GET['filter'], $allowed_filters)
    ? $_GET['filter']
    : 'all';

try {
    if ($filter == 'sales') {
        $stmt = $pdo->prepare("SELECT id, title, firstname, lastname, email, company, type FROM contacts WHERE type = 'Sales Lead'");
    } else if ($filter == 'support') {
        $stmt = $pdo->prepare("SELECT id, title, firstname, lastname, email, company, type FROM contacts WHERE type = 'Support'");
    } else if ($filter == 'assigned') {
        if (isset($_SESSION['user_id'])) {
            $stmt = $pdo->prepare("SELECT id, title, firstname, lastname, email, company, type FROM contacts WHERE assigned_to = :user_id");
            $stmt->execute([':user_id' => $_SESSION['user_id']]);
        } else {
            $stmt = $pdo->prepare("SELECT id, title, firstname, lastname, email, company, type FROM contacts");
            $stmt->execute();
        }
    } else {
        $stmt = $pdo->prepare("SELECT id, title, firstname, lastname, email, company, type FROM contacts");
    }

    $stmt->execute();
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "data" => $contacts
    ]);
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "error" => "Unable to load contacts."
    ]);
}
