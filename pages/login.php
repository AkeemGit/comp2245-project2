<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="../assets/css/header.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="center-wrapper">
        <div class="login-container">

            <h1>Login</h1>
            <form id="loginForm" method="POST">
                <div id="loginError" class="error-message"></div>
                <input type="email" name="email" placeholder=" Email address">
                <input type="password" name="password" placeholder=" Password">
                <button type="submit" class="login-btn">Login</button>
            </form>
        </div>

    </div>

    <div>
        <p class="copyright">Copyright © 2025 Dolphin CRM</p>
    </div>

    <script src="../assets/js/login.js"></script>

</body>

</html>