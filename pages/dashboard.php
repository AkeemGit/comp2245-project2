<?php

include "../config/db_connect.php";

$allowed_filters = ['all', 'sales', 'support', 'assigned'];
$filter = isset($_GET['filter']) && in_array($_GET['filter'], $allowed_filters) ? $_GET['filter'] : 'all';

try {
    if ($filter == 'sales') {
        $stmt = $pdo->prepare("SELECT title, firstname, lastname, email, company, type FROM contacts WHERE type = :type");
        $stmt->execute([':type' => 'Sales Lead']);
    } else if ($filter == 'support') {
        $stmt = $pdo->prepare("SELECT title, firstname, lastname, email, company, type FROM contacts WHERE type = :type");
        $stmt->execute([':type' => 'Support']);
    } else if ($filter == 'assigned') {
        if (isset($_SESSION['user_id'])) {
            $stmt = $pdo->prepare("SELECT title, firstname, lastname, email, company, type FROM contacts WHERE assigned_to = :user_id");
            $stmt->execute([':user_id' => $_SESSION['user_id']]);
        } else {
            $stmt = $pdo->prepare("SELECT title, firstname, lastname, email, company, type FROM contacts");
            $stmt->execute();
        }
    } else {
        $stmt = $pdo->prepare("SELECT title, firstname, lastname, email, company, type FROM contacts");
        $stmt->execute();
    }

    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $contacts = [];
    $error_message = "Unable to load contacts. Please try again later.";
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/aside.css">
    <link rel="stylesheet" href="../assets/css/header.css">
</head>

<body>
    <?php include "../includes/header.php"; ?>

    <div class="container">
        <?php include "../includes/aside.php"; ?>

        <main class="main-content">
            <div class="dashboard-toolbar">
                <h1 class="toolbar-title">Dashboard</h1>

                <button class="add-contact-btn" onclick="window.location.href='new-contact.php'">
                    <i class="fa-solid fa-plus"></i> Add Contact
                </button>
            </div>

            <div class="filter-section">
                <span class="filter-label">Filter By:</span>
                <div class="filter-options">
                    <a href="dashboard.php?filter=all" class="filter-link <?php echo $filter == 'all' ? 'active' : ''; ?>">All</a>
                    <a href="dashboard.php?filter=sales" class="filter-link <?php echo $filter == 'sales' ? 'active' : ''; ?>">Sales Lead</a>
                    <a href="dashboard.php?filter=support" class="filter-link <?php echo $filter == 'support' ? 'active' : ''; ?>">Support</a>
                    <a href="dashboard.php?filter=assigned" class="filter-link <?php echo $filter == 'assigned' ? 'active' : ''; ?>">Assigned to me</a>
                </div>
            </div>

        </main>
    </div>

</body>

</html>