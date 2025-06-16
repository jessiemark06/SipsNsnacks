<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";

if (empty($_SESSION["logged_in"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: index.php");
    exit();
}

$currentAdminId = $_SESSION["user_id"];
$stmt = $pdo->prepare("SELECT * FROM acc_tbl WHERE acc_id != ?");
$stmt->execute([$currentAdminId]);
$users = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <link rel="stylesheet" href="../assets/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="../    assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</head>

<body style="margin:0">
<div class="d-flex flex-column" style="min-height: 100vh;">
    
<header style="background-color: #EAE4D5;" class="shadow-sm">
    <div class="d-flex align-items-center px-4 py-2">
        <a class="navbar-brand fw-bold d-flex align-items-center text-decoration-none text-dark" href="#">
            <img src="../assets/img/logo.png" alt="Logo" style="width: 70px; height: auto; margin-left: 50px; margin-right: 10px;">
            Sips'NSnacks
        </a>
    </div>
</header>


   
    <div class="d-flex flex-column flex-md-row flex-grow-1">
     
        <div class="bg-dark text-white d-flex flex-column" style="width: 100%; max-width: 250px;">
            <div class="p-3 d-flex flex-column h-100">
                <h4 class="mb-4">Admin Panel</h4>
                <div class="d-grid gap-2">
                    <a href="admin_dashboard.php" class="btn btn-outline-light text-start">Report Tab</a>
                    <a href="user_tab.php" class="btn btn-outline-light text-start">User Management</a>
                </div>
                <div class="mt-auto pt-3">
                    <a href="../logout.php" class="btn btn-outline-light text-start w-100">Logout</a>
                </div>
            </div>
        </div>

        
        <div class="flex-grow-1 p-3" style="background-color: #ffffff;">
            <h3 class="mb-4">User Management</h3>

            <?php if (isset($_SESSION["message"])): ?>
                <div class="alert alert-success"><?= $_SESSION["message"]; unset($_SESSION["message"]); ?></div>
            <?php elseif (isset($_SESSION["error"])): ?>
                <div class="alert alert-danger"><?= $_SESSION["error"]; unset($_SESSION["error"]); ?></div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered table-striped shadow-sm" style="background-color: #ffffff">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Address</th>
                            <th>Contact Number</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Salary</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['acc_id']) ?></td>
                                <td><?= htmlspecialchars($user['fname'] . ' ' . $user['mname'] . ' ' . $user['lname']) ?></td>
                                <td><?= htmlspecialchars($user['addr']) ?></td>
                                <td><?= htmlspecialchars($user['conum']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= htmlspecialchars($user['role']) ?></td>
                                <td>₱<?= htmlspecialchars(number_format((float)$user['salary'], 2)) ?></td>
                                <td class="d-flex gap-1">
                                    <a href="edit_user.php?id=<?= $user['acc_id'] ?>" class="btn btn-sm btn-dark">Edit</a>

                                     <form action="../includes/delete_user.inc.php" method="post" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            <input type="hidden" name="delete_id" value="<?= $user['acc_id'] ?>">
                                             <button type="submit" name="delete_user" class="btn btn-sm btn-danger">Delete</button>
                                      </form>
                                    </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
