<?php
require_once '../includes/dbh.inc.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();

    if ($row && $row['image']) {
        header("Content-Type: image/jpeg"); // Change this if needed
        echo $row['image'];
        exit;
    }
}

http_response_code(404);
echo "Image not found.";
