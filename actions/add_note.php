<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

if (!isset($_POST['contact_id'], $_POST['comment']) || empty(trim($_POST['comment']))) {
    die("Invalid note submission.");
}

$contact_id = intval($_POST['contact_id']);
$comment = trim($_POST['comment']);

// Checks if contact ID is valid and if comment is empty 
if(!$contact_id){
    die("Invalid contact ID.");
}

if($comment === ''){
    die("Comment cannot be empty.");
}

$comment = strip_tags($comment);

// if(!isset($_SESSION['user_id'])) {
//     die("User not logged in.");
// }

// Use default user ID for now (change this value as needed)
$created_by = 1;

// Insert Note 
$stmt = $pdo->prepare("
    INSERT INTO notes (contact_id, comment, created_by, created_at)
    VALUES (:contact_id, :comment, :created_by, NOW())");

$stmt->execute([
    ':contact_id' => $contact_id,
    ':comment' => $comment,
    ':created_by' => $created_by,
]);

// Update the contact's updated_at timestamp
$updateContact = $pdo->prepare("
    UPDATE contacts
    SET updated_at = NOW()
    WHERE id = :contact_id
");

$updateContact->execute([':contact_id' => $contact_id]);

// Fetch updated notes
$noteStmt = $pdo->prepare("
    SELECT n.*, u.firstname, u.lastname
    FROM notes n
    JOIN users u ON u.id = n.created_by
    WHERE n.contact_id = ?
    ORDER BY n.created_at DESC
");
$noteStmt->execute([$contact_id]);
$notes = $noteStmt->fetchAll(PDO::FETCH_ASSOC);


// Fetch updated contact to get new updated_at timestamp
$contactStmt = $pdo->prepare("SELECT updated_at FROM contacts WHERE id = ?");
$contactStmt->execute([$contact_id]);
$updatedContact = $contactStmt->fetch(PDO::FETCH_ASSOC);
$updatedDate = date('F j, Y', strtotime($updatedContact['updated_at']));

// Build notes HTML
$notesHTML = '';
foreach ($notes as $note) {
    $notesHTML .= "<div class='note'>
            <strong>" . htmlspecialchars($note['firstname'] . " " . $note['lastname']) . "</strong>
            <p>" . htmlspecialchars($note['comment']) . "</p>
            <small>" . htmlspecialchars(date('F j, Y', strtotime($note['created_at']))) . "</small>
          </div>";
}

// Return JSON with notes HTML and updated date
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'notesHTML' => $notesHTML,
    'updatedDate' => $updatedDate
]);
?>