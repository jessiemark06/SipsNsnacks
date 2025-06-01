<?php 
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";

if (empty($_SESSION["logged_in"]) || $_SESSION["user_role"] !== "customer") {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['product'] ?? '';

    foreach ($products as $product) {
        if ($product['name'] === $productName) {
            $_SESSION['cart'][] = $product['name'];
            break;
        }
    }

    $cartHtml = '';
    $total = 0;

    if (!empty($_SESSION["cart"])) {
        foreach ($_SESSION["cart"] as $item) {
            foreach ($products as $product) {
                if ($product["name"] === $item) {
                    $cartHtml .= "<li class='list-group-item'>{$product['name']} - ₱" . number_format($product['price'], 2) . "</li>";
                    $total += $product["price"];
                }
            }
        }
    } else {
        $cartHtml = "<li class='list-group-item'>No order</li>";
    }

    header('Content-Type: application/json');
    echo json_encode([
        'cartHtml' => $cartHtml,
        'total' => number_format($total, 2)
    ]);
    exit();
}
 
http_response_code(405);
echo json_encode(['error' => 'Method not allowed']);
exit();
