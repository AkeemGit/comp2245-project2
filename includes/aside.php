<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$role = $_SESSION['role'] ?? null;

if (!$role && isset($_SESSION['user_id'])) {
    require '../config/db_connect.php';
    $stmt = $pdo->prepare('SELECT role FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row && isset($row['role'])) {
        $role = $row['role'];
        $_SESSION['role'] = $role;
    }
}
?>

<aside class="sidebar">
    <nav class="sidebar-menu">
        <a href="../pages/dashboard.php" class="menu-item">
            <i class="fa-solid fa-house icon"></i>
            <span class="text">Home</span>
        </a>

        <a href="../pages/new-contact.php" class="menu-item">
            <i class="fa-solid fa-user-plus icon"></i>
            <span class="text">New Contact</span>
        </a>

        <?php if ($role === 'admin'): ?>
            <a href="../pages/users.php" class="menu-item">
                <i class="fa-solid fa-users icon"></i>
                <span class="text">Users</span>
            </a>
        <?php endif; ?>

        <hr class="sidebar-divider">

        <a href="../pages/logout.php" class="menu-item logout">
            <i class="fa-solid fa-right-from-bracket icon"></i>
            <span class="text">Logout</span>
        </a>
    </nav>
</aside>