<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";

if (empty($_SESSION["logged_in"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: index.php");
    exit();
}

$date = $_GET['date'] ?? date('Y-m-d');

$stmt = $pdo->prepare("SELECT id, total, created_at FROM orders WHERE DATE(created_at) = ?");
$stmt->execute([$date]);
$orders = $stmt->fetchAll();

$stmt2 = $pdo->query("SELECT COUNT(*) AS staff_count FROM acc_tbl");
$totalStaff = $stmt2->fetchColumn();
$totalSales = array_sum(array_column($orders, 'total'));
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
    <script src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
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
                    <a href="../logout.php" class="btn btn-outline-light text-start w-100">Logout</a>
                </div>
            </div>
        </div>


        <!-- Dito lalagay 'yung content boi which is 'yung report tab -->
           <div class="flex-grow-1 p-1" style="background-color: #ffffff;">


           <!-- cards dito -->
            <div class="container ">
                <div> <h3 class="mb-3 mt-3 col-md-6">Report Tab</h3></div>
            <div class="row">
                
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-left-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total Sales:</h5>
                        <p class="card-text fs-3 text-dark">₱ <?= number_format($totalSales, 2) ?></p>
                    </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-left-info">
                    <div class="card-body">
                        <h5 class="card-title">Number of Staff:</h5>
                        <p class="card-text fs-3 text-dark"><?= $totalStaff ?></p>
                    </div>
                    </div>
                </div>
            </div>
            </div>


            <div class="container bg-white ">

 
            <form method="GET" class="mt-2 d-flex justify-content-between align-items-center gap-2 flex-wrap">
                        <div> <h5 class="mb-2 text-center">Daily Sales</h5></div>
                    
                    <div class="d-flex align-items-center">
                <label for="date" class="form-label mb-2 me-2" style="white-space: nowrap;">Select Date:</label>
                <input type="date" id="date" name="date" value="<?= $date ?>" class="form-control mb-2 me-2" style="max-width: 200px;">
                <button type="submit" class="mb-2 btn btn-dark">View</button>
                </div>

                </form>

                <div class="table-responsive">
                <table class="table table-bordered table-striped shadow-sm" style="background-color: #ffffff">
                    <thead class="table-dark">
                        <tr>
                        <th>Order ID</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                        <?php
    
                            $stmtItems = $pdo->prepare("
                            SELECT p.name
                            FROM order_items oi
                            JOIN products p ON p.id = oi.product_id
                            WHERE oi.order_id = ?
                            ");
                            $stmtItems->execute([$order['id']]);
                            $items = $stmtItems->fetchAll(PDO::FETCH_COLUMN);  
                            $itemList = implode(', ', $items);
                        ?>
                        <tr>
                            <td>#<?= $order['id'] ?></td>
                            <td><?= htmlspecialchars($itemList) ?></td>
                            <td>₱<?= number_format($order['total'], 2) ?></td>
                            <td><?= date("h:i A", strtotime($order['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>
                    </div>         
    
 
                    </div>
                    </div>
            </div>

        </div>
</div>
</body>
</html>
