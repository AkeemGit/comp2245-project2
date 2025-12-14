<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="../assets/css/header.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="center-wrapper">
        <div class="login-container">
            
            <h1>Login</h1>
            <form id="loginForm" method="POST">
                <input type="email" name="email" placeholder=" Email address" required>
                <input type="password" name="password" placeholder=" Password" required>
                <button type="submit" class="login-btn">Login</button>
            </form>
        </div>

    </div>

    <div>
    <p class="copyright">Copyright © 2025 Dolphin CRM</p>
    </div>

    <script src="assets\js\login.js"></script>
    
</body>

</html>