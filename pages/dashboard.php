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
                    <button class="filter-btn active" data-filter="all">All</button>
                    <button class="filter-btn" data-filter="sales">Sales Lead</button>
                    <button class="filter-btn" data-filter="support">Support</button>
                    <button class="filter-btn" data-filter="assigned">Assigned to me</button>
                </div>
            </div>

        </main>
    </div>

</body>

</html>