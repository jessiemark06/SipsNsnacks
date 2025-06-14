<?php 
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";

if (empty($_SESSION["logged_in"]) || $_SESSION["user_role"] !== "staff") {
    header("Location: index.php");
    exit();
}

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();

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
<body class="dd-flex flex-column" style="min-height: 100vh;">
    <!-- header -->
     <header style="background-color: #EAE4D5;" class="shadow-sm">
    <div class="d-flex align-items-center px-4 py-2">
        <a class="navbar-brand fw-bold d-flex align-items-center text-decoration-none text-dark" href="#">
            <img src="../assets/img/logo.png" alt="Logo" style="width: 70px; height: auto; margin-left: 50px; margin-right: 10px;">
            Sips'NSnacks
        </a>
    </div>
</header>



    <!-- sa loob ng div boi pinaghalo 'yung sidebar saka yung ididisplay mo sa page para di mabaliw -->
    <div class="d-flex flex-column flex-md-row flex-grow-1 ">
        <!-- sidebar man -->
        <div class="bg-dark text-white d-flex flex-column" style="width: 100%; max-width: 250px;">
            <div class="p-3 d-flex flex-column h-100">
                <h4 class="mb-4">Admin Panel</h4>
                <div class="d-grid gap-2">
                    <a href="staff_dashboard.php" class="btn btn-outline-light text-start">Order</a>
                </div>
                <div class="mt-auto pt-3">
                    <a href="../logout.php" class="btn btn-outline-light text-start w-100">Logout</a>
                </div>
            </div>
        </div>


    <div class="col-md-7">
        <div>
            <h4 class="d-flex align-items-center justify-content-center pt-3">Snacks</h4>
              <div class="d-flex flex-wrap justify-content-center">
                <?php foreach ($products as $item): ?>
                    <?php if ($item['category'] === 'Snack'): ?>
                        <div class="m-2">
                            <button 
                              type="button"
                                class="btn btn-outline-secondary d-flex flex-column justify-content-between align-items-center snack-btn"
                                data-name="<?= htmlspecialchars($item['name']) ?>"
                                data-price="<?= $item['price'] ?>"
                                style="width: 120px; height: 160px; padding: 10px;">
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
            <h4 class="d-flex align-items-center justify-content-center">Drinks</h4>
            <div class="d-flex flex-wrap justify-content-center">
                <?php foreach ($products as $item): ?>
                    <?php if ($item['category'] === 'Drink'): ?>
                        <div class="m-2">
                            <button 
                                type="button"
                                class="btn btn-outline-secondary d-flex flex-column justify-content-between align-items-center snack-btn"
                               
                                data-name="<?= htmlspecialchars($item['name']) ?>"
                                data-price="<?= $item['price'] ?>"
                                style="width: 120px; height: 160px; padding: 10px;">
                             
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
    
 
    <div class="col-md-3 pt-3 me-3">
        <h3>Order</h3>
        <?php if (!empty($cartError)): ?>
<div id="cartPopup" class="popup-message">
    <?= htmlspecialchars($cartError); ?>
</div>
<?php endif; ?>
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

        <form method="POST" action="order_items.php">
            <input type="hidden" name="cart" id="cart-data">
                    <a href="?clear=1" class="btn btn-warning mt-2">Clear Order</a>
            <button type="submit" class="btn btn-success mt-2">Complete Order</button>
        </form>

    </div>
</div>
 
<script>
    let cart = [];

    document.querySelectorAll('.snack-btn').forEach(button => {
        button.addEventListener('click', () => {
            const itemName = button.getAttribute('data-name');
            const itemPrice = parseFloat(button.getAttribute('data-price'));

            const existingItem = cart.find(item => item.name === itemName);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({ name: itemName, price: itemPrice, quantity: 1 });
            }

            updateCartDisplay();
        });
    });

  function updateCartDisplay() {
    const list = document.getElementById('cart-list');
    const totalEl = document.getElementById('total-price');
    list.innerHTML = '';

    let total = 0;

    if (cart.length === 0) {
        list.innerHTML = '<li class="list-group-item">No order</li>';
    } else {
        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;
 
            item.total = itemTotal;

            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';

            li.innerHTML = `
                <div>
                    <strong>${item.name}</strong><br>
                    ₱${item.price.toFixed(2)} x ${item.quantity} = ₱${itemTotal.toFixed(2)}
                </div>
                <div>
                    <button class="btn btn-sm btn-outline-secondary me-1" onclick="changeQuantity(${index}, -1)">−</button>
                    <button class="btn btn-sm btn-outline-secondary" onclick="changeQuantity(${index}, 1)">+</button>
                </div>
            `;

            list.appendChild(li);
        });
    }

    totalEl.textContent = total.toFixed(2);
    document.getElementById('cart-data').value = JSON.stringify(cart);
}

    function changeQuantity(index, delta) {
        cart[index].quantity += delta;
        if (cart[index].quantity <= 0) {
            cart.splice(index, 1);
        }
        updateCartDisplay();
    }

    function clearCart() {
        cart = [];
        updateCartDisplay();
    }
 
    updateCartDisplay();
</script>


</body>
</html>