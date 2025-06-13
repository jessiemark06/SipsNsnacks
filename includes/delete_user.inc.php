<?php
require_once "config_session.inc.php";
require_once "dbh.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_id"])) {
    if (empty($_SESSION["logged_in"]) || $_SESSION["user_role"] !== "admin") {
        header("Location: ../index.php");
        exit();
    }

    $deleteId = $_POST["delete_id"];

    try {
        $stmt = $pdo->prepare("DELETE FROM acc_tbl WHERE acc_id = :id");
        $stmt->bindParam(":id", $deleteId, PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION["message"] = "User deleted successfully.";
    } catch (PDOException $e) {
        $_SESSION["error"] = "Failed to delete user: " . $e->getMessage();
    }

    header("Location: ../user_tab.php");
    exit();
} else {
    header("Location: ../user_tab.php");
    exit();
}

?>