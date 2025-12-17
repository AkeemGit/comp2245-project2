<?php
require '../config/db_connect.php';

$errors = [];
$passed = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $role = trim($_POST['role'] ?? '');

    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($role)) {
        $errors[] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "This email format is invalid.";
    } else {

        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = " The email that you provided already exists.";
        }
    }
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare(" INSERT INTO users (firstname, lastname, email, password, role, date) VALUES (?, ?, ?, ?, ?, ) ");
        if ($stmt->execute([$firstname, $lastname, $email, $hashedPassword, $role])) {
            $passed = " Successful creation of user.";
        } else {
            $errors[] = " OOPS! Creation of user resulted in an error.";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title> New User </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/aside.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/create_users.css">
</head>

<body>
    <?php include "../includes/header.php"; ?>

    <div class="layout">
        <?php include "../includes/aside.php"; ?>

        <div class="main-content">
            <div class="page-header">
                <h2> New User </h2>
            </div>

            <div class="form-card">

                <?php if (!empty($errors)): ?>
                    <div class="error-messages">
                        <?php foreach ($errors as $error): ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ($passed): ?>
                    <div class="success-message">
                        <p><?php echo htmlspecialchars($passed); ?></p>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                        <div>
                        <label for="firstname">First Name:</label>
                        <input type="text" id="firstname" name="firstname" required>
                        </div>

                        <div>
                        <label for="lastname">Last Name:</label>
                        <input type="text" id="lastname" name="lastname" required>
                        </div>

                        <div>
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                        </div>

                        <div>
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                        </div>

                        <div class="full-width">
                        <label for="role">Role:</label>
                        <select id="role" name="role" required>
                        
                        <option value="Admin">Admin</option>
                        <option value="Member">Member</option>
                        </select>
                        </div>

                        <div class="button-container">
                        <button type="submit">Save</button>
                        </div>
                </form>
            </div>
            </main>