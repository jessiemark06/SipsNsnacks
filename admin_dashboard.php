<?php
require_once "includes/config_session.inc.php";

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
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<h1>Customer Home</h1>
<p>Welcome, <?= htmlspecialchars($_SESSION["user_email"]) ?></p>
<a href="logout.php">Logout</a>
</body>
</html>