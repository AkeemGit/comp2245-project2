<?php

session_start();
include "../config/db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$users = [];
try {
    $stmt = $pdo->query("SELECT id, firstname, lastname FROM users ORDER BY firstname, lastname");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $users = [];
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/aside.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/create-contact.css">
</head>

<body>
    <?php include "../includes/header.php"; ?>

    <div class="page-layout">
        <?php include "../includes/aside.php"; ?>

        <main class="main-info">

            <div class="contact-header">
                <div class="identity">
                    <div class="avatar-circle">
                        <img class="avatar-icon" src="../assets/images/profile.png" alt="Profile">
                    </div>

                    <div class="header-text">
                        <h2>Create New Contact</h2>
                        <p class="meta">Fill out the details below and click Save.</p>
                    </div>
                </div>

                <div class="action-button">
                    <a class="back-btn" href="dashboard.php" style="text-decoration:none; display:inline-flex; align-items:center;">
                        <i class="fa-solid fa-arrow-left"></i>&nbsp; Back
                    </a>
                </div>
            </div>

            <div id="formMessage" style="margin: 12px 0;"></div>

            <form id="newContactForm" autocomplete="off">

                <div class="info-box">
                    <div class="info-col">
                        <label for="name" id="title">Title</label>
                        <select name="title" required style="width:100%;">
                            <option value="">Select…</option>
                            <option>Mr</option>
                            <option>Mrs</option>
                            <option>Ms</option>
                            <option>Dr</option>
                            <option>Prof</option>
                        </select>

                        <label for="firstname" id="firstname">First Name</label>
                        <input type="text" name="firstname" required maxlength="50" style="width:100%;" />

                        <label for="email" id="email">Email</label>
                        <input type="email" name="email" required maxlength="100" style="width:100%;" />

                        <label for="company" id="company">Company</label>
                        <input type="text" name="company" required maxlength="100" style="width:100%;" />
                    </div>

                    <div class="info-col">
                        <label for="type" id="type">Type</label>
                        <select name="type" required style="width:100%;">
                            <option value="">Select…</option>
                            <option value="Sales Lead">Sales Lead</option>
                            <option value="Support">Support</option>
                        </select>

                        <label for="lastname" id="lastname">Last Name</label>
                        <input type="text" name="lastname" required maxlength="50" style="width:100%;" />

                        <label for="telephone" id="telephone">Telephone</label>
                        <input type="text" name="telephone" required maxlength="20" style="width:100%;" />

                        <label for="assigned_to" id="assigned_to">Assigned To</label>
                        <select name="assigned_to" required style="width:100%;">
                            <option value="">Select…</option>
                            <?php foreach ($users as $u): ?>
                                <option value="<?= (int)$u['id'] ?>">
                                    <?= htmlspecialchars($u['firstname'] . ' ' . $u['lastname']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="action-buttons" style="margin-top: 14px;">
                    <button type="submit" id="saveBtn" class="save-btn">
                        <i class="fa-solid fa-floppy-disk"></i> Save
                    </button>

                    <a href="dashboard.php" class="cancel-btn" style="text-decoration:none; display:inline-flex; align-items:center;">
                        Cancel
                    </a>
                </div>

            </form>

        </main>
    </div>

    <script src="../assets/js/contacts.js"></script>
</body>

</html>