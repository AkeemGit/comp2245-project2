<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

if (!isset($_POST['contact_id'], $_POST['comment']) || empty(trim($_POST['comment']))) {
    die("Invalid note submission.");
}

$contact_id = intval($_POST['contact_id']);
$comment = trim($_POST['comment']);


if (!$contact_id) {
    die("Invalid contact ID.");
}

if ($comment === '') {
    die("Comment cannot be empty.");
}

$comment = strip_tags($comment);



$created_by = $_SESSION['user_id'];


$stmt = $pdo->prepare("
    INSERT INTO notes (contact_id, comment, created_by, created_at)
    VALUES (:contact_id, :comment, :created_by, NOW())");

$stmt->execute([
    ':contact_id' => $contact_id,
    ':comment' => $comment,
    ':created_by' => $created_by,
]);


$updateContact = $pdo->prepare("
    UPDATE contacts
    SET updated_at = NOW()
    WHERE id = :contact_id
");

$updateContact->execute([':contact_id' => $contact_id]);


$noteStmt = $pdo->prepare("
    SELECT n.*, u.firstname, u.lastname
    FROM notes n
    JOIN users u ON u.id = n.created_by
    WHERE n.contact_id = ?
    ORDER BY n.created_at DESC
");
$noteStmt->execute([$contact_id]);
$notes = $noteStmt->fetchAll(PDO::FETCH_ASSOC);



$contactStmt = $pdo->prepare("SELECT updated_at FROM contacts WHERE id = ?");
$contactStmt->execute([$contact_id]);
$updatedContact = $contactStmt->fetch(PDO::FETCH_ASSOC);
$updatedDate = date('F j, Y', strtotime($updatedContact['updated_at']));


$notesHTML = '';
foreach ($notes as $note) {
    $notesHTML .= "<div class='note'>
            <strong>" . htmlspecialchars($note['firstname'] . " " . $note['lastname']) . "</strong>
            <p>" . htmlspecialchars($note['comment']) . "</p>
            <small>" . htmlspecialchars(date('F j, Y', strtotime($note['created_at']))) . "</small>
          </div>";
}

header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'notesHTML' => $notesHTML,
    'updatedDate' => $updatedDate
]);
