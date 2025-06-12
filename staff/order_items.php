<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['cart'])) {
    $cart = json_decode($_POST['cart'], true);

    if (!is_array($cart) || empty($cart)) {
        die("Cart is empty.");
    }

    $orderTotal = 0;
 
    foreach ($cart as $item) {
        if (isset($item['price'], $item['quantity'])) {
            $orderTotal += $item['price'] * $item['quantity'];
        }
    }
 
    $stmt = $pdo->prepare("INSERT INTO orders (total, created_at) VALUES (?, NOW())");
    $stmt->execute([$orderTotal]);
    $orderId = $pdo->lastInsertId();
 
    $insertItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, price, quantity) VALUES (?, ?, ?, ?)");

    foreach ($cart as $item) {
        if (!isset($item['name'], $item['price'], $item['quantity'])) {
            continue;  
        }

        $stmt = $pdo->prepare("SELECT id FROM products WHERE name = ?");
        $stmt->execute([$item['name']]);
        $product = $stmt->fetch();

        if ($product) {
            $insertItem->execute([
                $orderId,
                $product['id'],
                $item['price'],
                $item['quantity']
            ]);
        }
    }

    unset($_SESSION['cart']);
    header("Location: staff_dashboard.php?success=1");
    exit();
}
?>
