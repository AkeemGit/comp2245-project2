<?php include "../includes/header.php"; ?>

<!-- </?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?> -->

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
    <link rel="stylesheet" href="../assets/css/contacts-table.css">
</head>

<body>

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
                    <button data-filter="all" class="filter-link active">All</button>
                    <button data-filter="sales" class="filter-link">Sales Lead</button>
                    <button data-filter="support" class="filter-link">Support</button>
                    <button data-filter="assigned" class="filter-link">Assigned to me</button>
                </div>
            </div>

            <div class="contacts-table-container" id="contacts-container">
                <p>Loading...</p>
            </div>

        </main>
    </div>

    <script src="../assets/js/dashboard.js"></script>

</body>

</html>