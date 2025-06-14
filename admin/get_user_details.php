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
    exit('User ID is required');
}

$user_id = mysqli_real_escape_string($conn, $_GET['id']);

// Get user details
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    header('HTTP/1.1 404 Not Found');
    exit('User not found');
}

// Get user's recent orders
$orders_query = "SELECT id, status, created_at FROM orders WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 5";
$orders_result = mysqli_query($conn, $orders_query);
$orders = mysqli_fetch_all($orders_result, MYSQLI_ASSOC);

$user['orders'] = $orders;

header('Content-Type: application/json');
echo json_encode($user); 