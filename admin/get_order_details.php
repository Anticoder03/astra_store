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
    exit('Order ID is required');
}

$order_id = mysqli_real_escape_string($conn, $_GET['id']);

// Get order details
$query = "SELECT o.*, u.first_name, u.last_name, u.email 
          FROM orders o 
          JOIN users u ON o.user_id = u.id 
          WHERE o.id = $order_id";
$result = mysqli_query($conn, $query);
$order = mysqli_fetch_assoc($result);

if (!$order) {
    header('HTTP/1.1 404 Not Found');
    exit('Order not found');
}

// Get order items
$items_query = "SELECT oi.*, p.name 
                FROM order_items oi 
                JOIN products p ON oi.product_id = p.id 
                WHERE oi.order_id = $order_id";
$items_result = mysqli_query($conn, $items_query);
$items = mysqli_fetch_all($items_result, MYSQLI_ASSOC);

$order['items'] = $items;

header('Content-Type: application/json');
echo json_encode($order); 