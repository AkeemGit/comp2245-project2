<?php
require '../config/db_connect.php';
session_start();


if (isset($_SESSION['user_id']) && (!isset($_SESSION['role']) || !$_SESSION['role'])) {
    $roleStmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
    $roleStmt->execute([$_SESSION['user_id']]);
    $roleRow = $roleStmt->fetch(PDO::FETCH_ASSOC);
    if ($roleRow) {
        $_SESSION['role'] = $roleRow['role'];
    }
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

$stmt = $pdo->prepare("SELECT firstname, lastname, email, role, date_registered FROM users ORDER BY date_registered DESC");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<?php include "../includes/header.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/aside.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/users.css">


</head>

<body>
    <div class="container">
        <?php include "../includes/aside.php"; ?>
        <main class="main-content">
            <div class="toolbar-dashboard">
                <h1 class="toolbar-title">Users</h1>
                <button class="add-users-btn" onclick="window.location.href='create_users.php'">
                    <i class="fa-solid fa-plus"></i> Add User
                </button>
            </div>
            <div class="content-box">
                <div class="users-table-container">
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created</th>

                            </tr>


                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['firstname']) . " " . htmlspecialchars($user['lastname']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= htmlspecialchars($user['role']) ?></td>
                                    <td><?= htmlspecialchars(date("Y-m-d  H:i", strtotime($user['date_registered']))) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

</html>