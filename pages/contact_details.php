<?php
require '../config/db_connect.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$contact_id = intval($_GET['id']);


$stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
$stmt->execute([$contact_id]);
$contact = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$contact) {
    die("Contact not found.");
}


$noteStmt = $pdo->prepare("
    SELECT notes.*, users.firstname AS author_first, users.lastname AS author_last
    FROM notes
    JOIN users ON users.id = notes.created_by
    WHERE notes.contact_id = ?
    ORDER BY notes.created_at DESC
");
$noteStmt->execute([$contact_id]);
$notes = $noteStmt->fetchAll(PDO::FETCH_ASSOC);


$assigned_user = null;
if ($contact['assigned_to']) {
    $userStmt = $pdo->prepare("SELECT firstname, lastname FROM users WHERE id = ?");
    $userStmt->execute([$contact['assigned_to']]);
    $assigned_user = $userStmt->fetch(PDO::FETCH_ASSOC);
}


$created_user = null;
if ($contact['created_by']) {
    $createdUserStmt = $pdo->prepare("SELECT firstname, lastname FROM users WHERE id = ?");
    $createdUserStmt->execute([$contact['created_by']]);
    $created_user = $createdUserStmt->fetch(PDO::FETCH_ASSOC);
}
?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Details - <?php echo htmlspecialchars($contact['title'] . " " . $contact['firstname'] . " " . $contact['lastname']); ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/aside.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/view-contact.css">
</head>

<body>
    <?php include "../includes/header.php"; ?>

    <div class="page-layout">
        <?php include "../includes/aside.php"; ?>
        <main class="main-info">
            <div class="contact-header">
                <div class="contact-header-left">
                    <div class="identity">
                        <div class="avatar-circle">
                            <img class="avatar-icon" src="../assets/images/profile.png" alt="Profile">
                        </div>

                        <div class="identity-text">
                            <h2><?php echo htmlspecialchars($contact['title'] . " " . $contact['firstname'] . " " . $contact['lastname']); ?></h2>
                            <p class="meta">Created on <?php echo htmlspecialchars(date('F j, Y', strtotime($contact['created_at']))) . " by " . htmlspecialchars($created_user['firstname'] . " " . $created_user['lastname']); ?><br></p>
                            <p class="meta">Updated on <?php echo htmlspecialchars(date('F j, Y', strtotime($contact['updated_at']))); ?></p>
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <button class="assign-btn" id="assignBtn" data-contact-id="<?php echo $contact_id; ?>">
                        <i class="fa-solid fa-hand"></i> Assign to Me
                    </button>

                    <button class="switch-btn" id="switchBtn" data-contact-id="<?php echo $contact_id; ?>">
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        <?php echo ($contact['type'] === 'Sales Lead') ? 'Switch to Support' : 'Switch to Sales Lead'; ?>
                    </button>
                </div>
            </div>
            <div class="info-box">
                <div class="info-col">
                    <p><strong>Email</strong><br><?php echo htmlspecialchars($contact['email']); ?></p>
                    <p><strong>Company</strong><br><?php echo htmlspecialchars($contact['company']); ?></p>
                </div>

                <div class="info-col">
                    <p><strong>Telephone</strong><br><?php echo htmlspecialchars($contact['telephone']); ?></p>
                    <p><strong>Assigned To</strong><br>
                        <span id="assigned-user">
                            <?php
                            echo $assigned_user
                                ? htmlspecialchars($assigned_user['firstname'] . " " . $assigned_user['lastname'])
                                : "Unassigned";
                            ?>
                        </span>
                    </p>
                </div>
            </div>

            <div class="notes-section">
                <h3>Notes</h3>
                <br>
                <hr><br>

                <div id="notes-list">
                    <?php foreach ($notes as $note): ?>
                        <div class="note">
                            <strong><?php echo htmlspecialchars($note['author_first'] . " " . $note['author_last']); ?></strong>
                            <p><?php echo htmlspecialchars($note['comment']); ?></p>
                            <small><?php echo htmlspecialchars(date('F j, Y', strtotime($note['created_at']))); ?></small>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="note-header">
                    <p style="margin-bottom: 10px;"> Add a note about <?php echo htmlspecialchars($contact['firstname']); ?></p>
                    <form class="add-note-box" action="../actions/add_note.php" method="POST">
                        <textarea name="comment" rows="4" placeholder="Enter details here" class="comment" required></textarea>
                        <input type="hidden" name="contact_id" value="<?php echo $contact_id; ?>">
                        <button type="submit" class="add-note-button">Add Note</button>
                    </form>
                </div>

            </div>

        </main>
    </div>
</body>
<script src="../assets/js/notes.js"></script>
<script src="../assets/js/contact-details.js"></script>

</html>