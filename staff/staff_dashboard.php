<?php 
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";

if (empty($_SESSION["logged_in"]) || $_SESSION["user_role"] !== "staff") {
    header("Location: index.php");
    exit();
}

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();

if (isset($_GET['clear']) && $_GET['clear'] == 1) {
    unset($_SESSION['cart']);
    header("Location: staff_dashboard.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();

    if ($row && $row['image']) {
        header("Content-Type: image/jpeg");  
        echo $row['image'];
        exit;
    }
}
 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>POS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../assets/bootstrap-5.0.2-dist/css/bootstrap.min.css" />
    <script src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="p-4">
    <section class="mt-5 pt-5">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #EAE4D5">

    <div class="container" >
      <a class="navbar-brand fw-bold" href="staff_dashboard.php"><img class="navbar-brand" src="../assets/img/logo.png" style="width: 70px; height: auto;">Sips'NSnacks</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto"> 
          <li class="nav-item "><a class="nav-link text-dark" href="../logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
    <h1 class="mb-3">POS</h1>
    <p>Welcome, <?= htmlspecialchars($_SESSION["user_email"]) ?></p>

  <div class="row">

    <div class="col-md-7">
        <div>
            <h4>Snacks</h4>
            <div class="d-flex flex-wrap">
                <?php foreach ($products as $item): ?>
                    <?php if ($item['category'] === 'Snack'): ?>
                        <div class="m-2">
                            <button 
                                type="button"
                                  class="btn btn-outline-secondary d-flex flex-column justify-content-between align-items-center snack-btn"
                                    data-name="<?= htmlspecialchars($item['name']) ?>"
                                    style="width: 120px; height: 160px; padding: 10px;"
                            >
                                 <img src="?id=<?= $item['id'] ?>" 
                                             alt="<?= htmlspecialchars($item['name']) ?>" 
                                    style="width: 80px; height: 80px; object-fit: cover; margin-bottom: 5px;">
                                <span style="text-align: center; font-size: 0.9rem;">
                                    <?= htmlspecialchars($item['name']) ?><br>₱<?= number_format($item['price'], 2) ?>
                                </span>
                            </button>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <hr style="margin: 30px 0;">

        <div>
            <h4>Drinks</h4>
            <div class="d-flex flex-wrap">
                <?php foreach ($products as $item): ?>
                    <?php if ($item['category'] === 'Drink'): ?>
                        <div class="m-2">
                            <button 
                                type="button"
                                class="btn btn-outline-primary d-flex flex-column justify-content-between align-items-center snack-btn"
                                data-name="<?= htmlspecialchars($item['name']) ?>"
                                style="width: 120px; height: 160px; padding: 10px;"
                            >
                                <img src="?id=<?= $item['id'] ?>" 
                                             alt="<?= htmlspecialchars($item['name']) ?>" 
                                    style="width: 80px; height: 80px; object-fit: cover; margin-bottom: 5px;">
                                <span style="text-align: center; font-size: 0.9rem;">
                                    <?= htmlspecialchars($item['name']) ?><br>₱<?= number_format($item['price'], 2) ?>
                                </span>
                            </button>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
 
    <div class="col-md-5">
        <h3>Order</h3>
        <ul class="list-group" id="cart-list">
            <?php
            $total = 0;
            if (!empty($_SESSION["cart"])) {
                foreach ($_SESSION["cart"] as $item) {
                    foreach ($products as $product) {
                        if ($product["name"] === $item) {
                            echo "<li class='list-group-item'>{$product['name']} - ₱" . number_format($product['price'], 2) . "</li>";
                            $total += $product["price"];
                        }
                    }
                }
            } else {
                echo "<li class='list-group-item'>No order</li>";
            }
            ?>
        </ul>
        <h4 class="mt-3">Total: ₱<span id="total-price"><?= number_format($total, 2) ?></span></h4>
        <a href="?clear=1" class="btn btn-warning mt-2">Clear Order</a>
    </div>
</div>

</section>
</body>
</html>