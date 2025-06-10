<?php
require_once "includes/config_session.inc.php";
require_once "includes/dbh.inc.php";

if (empty($_SESSION["logged_in"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</head>

<body style="margin:0">
<div class="d-flex flex-column" style="min-height: 100vh;">
    <!-- header -->
    <header style="background-color: #EAE4D5;">
        <div class="d-flex align-items-center px-4 py-2">
            <a class="navbar-brand fw-bold d-flex align-items-center text-decoration-none text-dark" href="#">
                <img src="assets/img/logo.png" alt="Logo" style="width: 70px; height: auto; margin-left: 50px; margin-right: 10px;">
                Sips'NSnacks
            </a>
        </div>
    </header>

    <!-- sa loob ng div boi pinaghalo 'yung sidebar saka yung ididisplay mo sa page para di mabaliw -->
    <div class="d-flex flex-column flex-md-row flex-grow-1">
        <!-- sidebar man -->
        <div class="bg-dark text-white d-flex flex-column" style="width: 100%; max-width: 250px;">
            <div class="p-3 d-flex flex-column h-100">
                <h4 class="mb-4">Admin Panel</h4>
                <div class="d-grid gap-2">
                    <a href="admin_dashboard.php" class="btn btn-outline-light text-start">Report Tab</a>
                    <a href="user_tab.php" class="btn btn-outline-light text-start">User Management</a>
                </div>
                <div class="mt-auto pt-3">
                    <a href="logout.php" class="btn btn-outline-light text-start w-100">Logout</a>
                </div>
            </div>
        </div>

        <!-- Dito lalagay 'yung content boi which is 'yung report tab -->
        <div class="flex-grow-1 p-3">
            
        </div>

    </div>
</div>
</body>
</html>
