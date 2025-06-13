<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";

if (empty($_SESSION["logged_in"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: index.php");
    exit();
}

if (!isset($_GET["id"])) {
    $_SESSION["error"] = "User ID is missing.";
    header("Location: admin_dashboard.php");
    exit();
}

$acc_id = $_GET["id"];
$stmt = $pdo->prepare("SELECT * FROM acc_tbl WHERE acc_id = ?");
$stmt->execute([$acc_id]);
$user = $stmt->fetch();

if (!$user) {
    $_SESSION["error"] = "User not found.";
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="../assets/bootstrap-5.0.2-dist/css/bootstrap.min.css">
</head>
<body style="background-color:rgb(250, 250, 250);">
 

<div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="container shadow-lg p-0" style="max-width: 600px; background: #292929; overflow-y: auto; border-radius: 5px;">
        <div class="p-4">
            <h2 class="mb-4 text-center" style="color: #EAE4D5;">Update User</h2>
            <form action="../includes/edit_user.inc.php" method="post">
                <input type="hidden" name="acc_id" value="<?= $user['acc_id'] ?>">

                <div class="row mb-2 mx-3">
                    <div class="col-sm-6">
                        <label class="form-label text-white">First Name</label>
                        <input type="text" name="fname" class="form-control" value="<?= htmlspecialchars($_SESSION['old_inputs_edit']['fname'] ?? $user['fname']) ?>" >
                        <?php if (isset($_SESSION['errors_edit']['fname'])): ?>
                            <span class="text-danger small"><?= htmlspecialchars($_SESSION['errors_edit']['fname']) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label text-white">Middle Name</label>
                        <input type="text" name="mname" class="form-control" value="<?= htmlspecialchars($_SESSION['old_inputs_edit']['mname'] ?? $user['mname']) ?>">
                        <?php if (isset($_SESSION['errors_edit']['mname'])): ?>
                            <span class="text-danger small"><?= htmlspecialchars($_SESSION['errors_edit']['mname']) ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mb-2 mx-3">
                    <div class="col-sm-6">
                        <label class="form-label text-white">Last Name</label>
                        <input type="text" name="lname" class="form-control" value="<?= htmlspecialchars($_SESSION['old_inputs_edit']['lname'] ?? $user['lname']) ?>" >
                        <?php if (isset($_SESSION['errors_edit']['lname'])): ?>
                            <span class="text-danger small"><?= htmlspecialchars($_SESSION['errors_edit']['lname']) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label text-white">Address</label>
                        <input type="text" name="addr" class="form-control" value="<?= htmlspecialchars($_SESSION['old_inputs_edit']['addr'] ?? $user['addr']) ?>">
                        <?php if (isset($_SESSION['errors_edit']['addr'])): ?>
                            <span class="text-danger small"><?= htmlspecialchars($_SESSION['errors_edit']['addr']) ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mb-2 mx-3">
                    <div class="col-sm-6">
                        <label class="form-label text-white">Contact Number</label>
                        <input type="text" name="conum" class="form-control" value="<?= htmlspecialchars($_SESSION['old_inputs_edit']['conum'] ?? $user['conum']) ?>">
                        <?php if (isset($_SESSION['errors_edit']['conum'])): ?>
                            <span class="text-danger small"><?= htmlspecialchars($_SESSION['errors_edit']['conum']) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label text-white">Email</label>
                        <input type="text" name="email" class="form-control" value="<?= htmlspecialchars($_SESSION['old_inputs_edit']['email'] ?? $user['email']) ?>" >
                        <?php if (isset($_SESSION['errors_edit']['email'])): ?>
                            <span class="text-danger small"><?= htmlspecialchars($_SESSION['errors_edit']['email']) ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mb-3 mx-3">
                    <div class="col-sm-6">
                        <label class="form-label text-white">Role</label>
                        <select name="role" class="form-select">
                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="staff" <?= $user['role'] === 'staff' ? 'selected' : '' ?>>Staff</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label text-white">Salary</label>
                        <input type="text" name="salary" class="form-control" value="<?= htmlspecialchars($_SESSION['old_inputs_edit']['salary'] ?? $user['salary']) ?>">
                        <?php if (isset($_SESSION['errors_edit']['salary'])): ?>
                            <span class="text-danger small"><?= htmlspecialchars($_SESSION['errors_edit']['salary']) ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb-1 d-flex justify-content-center">
                    <button type="submit" name="update_user" class="btn rounded-4 text-dark" style="background-color: #EAE4D5; width: 300px;">Update</button>
                </div>
                <div class="text-center mt-2">
                    <a href="user_tab.php" class="text-decoration-none" style="color: #EAE4D5">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
if (isset($_SESSION['errors_edit'])) {
    unset($_SESSION['errors_edit']);
}
if (isset($_SESSION['old_inputs_edit'])) {
    unset($_SESSION['old_inputs_edit']);
}
?>
</body>
</html>