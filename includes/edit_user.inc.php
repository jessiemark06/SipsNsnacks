<?php
require_once "config_session.inc.php";
require_once "dbh.inc.php";


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_user"])) {

    $acc_id = $_POST["acc_id"];
    $fname = trim($_POST["fname"]);
    $mname = trim($_POST["mname"]);
    $lname = trim($_POST["lname"]);
    $addr  = trim($_POST["addr"]);
    $conum = trim($_POST["conum"]);
    $email = trim($_POST["email"]);
    $role  = $_POST["role"];
    $salary = $_POST["salary"];


    $errors_edit = [];

    if (empty($fname)) {
        $errors_edit["fname"] = "First name is required!";
    }
     if (empty($mname)) {
        $errors_edit["mname"] = "Middle name is required!";
    }

    if (empty($lname)) {
        $errors_edit["lname"] = "Last name is required!";
    }
    if (empty($addr)) {
        $errors_edit["addr"] = "Address is required!";
    }

    if (empty($email)) {
        $errors_edit["email"] = "Email is required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors_edit["email"] = "Invalid email format!";
    }
    if (!is_numeric($conum) || $conum < 0) {
        $errors_edit["conum"] = "Contact number must contain digits only!";
    }elseif (!empty($conum) && !preg_match("/^[0-9]{11}$/", $conum)) {
        $errors_edit["conum"] = "Contact number must be 11 digits!";
    }elseif (empty($conum)) {
        $errors_edit["conum"] = "Contact Number is required!";
    }

    if (empty($role) || !in_array($role, ['admin', 'staff'])) {
        $errors_edit["role"] = "Invalid role.";
    }

    if (!is_numeric($salary) || $salary < 0) {
        $errors_edit["salary"] = "Invalid salary input!";
    }

  
    if (!empty($errors_edit)) {
        $_SESSION["errors_edit"] = $errors_edit;
        $_SESSION["old_inputs_edit"] = $_POST;
        header("Location: ../edit_user.php?id=" . $acc_id);
        exit();
    }

  
    $stmt = $pdo->prepare("UPDATE acc_tbl SET fname = ?, mname = ?, lname = ?, addr = ?, conum = ?, email = ?, role = ?, salary = ? WHERE acc_id = ?");
    $updated = $stmt->execute([$fname, $mname, $lname, $addr, $conum, $email, $role, $salary, $acc_id]);

    if ($updated) {
        $_SESSION["message"] = "User updated successfully.";
        unset($_SESSION['old_inputs_edit']);
        unset($_SESSION['errors_edit']);
    } else {
        $_SESSION["error"] = "Failed to update user.";
    }

    header("Location: ../user_tab.php");
    exit();
} else {
    header("Location: ../user_tab.php");
    exit();
}