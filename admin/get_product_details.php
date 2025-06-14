<?php
session_start();
include '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('HTTP/1.1 403 Forbidden');
    exit('Unauthorized');
}

if (!isset($_GET['id'])) {
    header('HTTP/1.1 400 Bad Request');
    exit('Product ID is required');
}

$product_id = mysqli_real_escape_string($conn, $_GET['id']);

// Get product details
$query = "SELECT * FROM products WHERE id = $product_id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    header('HTTP/1.1 404 Not Found');
    exit('Product not found');
}

header('Content-Type: application/json');
echo json_encode($product); 