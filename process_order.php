<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Get cart items
$query = "SELECT c.*, p.name, p.price, p.stock 
          FROM cart c 
          JOIN products p ON c.product_id = p.id 
          WHERE c.user_id = $user_id";
$result = mysqli_query($conn, $query);
$cart_items = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (empty($cart_items)) {
    $_SESSION['error'] = "Your cart is empty";
    header('Location: cart.php');
    exit();
}

// Validate stock
foreach ($cart_items as $item) {
    if ($item['quantity'] > $item['stock']) {
        $_SESSION['error'] = "Insufficient stock for {$item['name']}";
        header('Location: cart.php');
        exit();
    }
}

// Start transaction
mysqli_begin_transaction($conn);

try {
    // Create order
    $shipping_address = mysqli_real_escape_string($conn, $_POST['shipping_address']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);
    
    $query = "INSERT INTO orders (user_id, shipping_address, payment_method, notes, status, created_at) 
              VALUES ($user_id, '$shipping_address', '$payment_method', '$notes', 'pending', NOW())";
    mysqli_query($conn, $query);
    $order_id = mysqli_insert_id($conn);

    // Add order items and update stock
    foreach ($cart_items as $item) {
        // Add order item
        $query = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                  VALUES ($order_id, {$item['product_id']}, {$item['quantity']}, {$item['price']})";
        mysqli_query($conn, $query);

        // Update stock
        $new_stock = $item['stock'] - $item['quantity'];
        $query = "UPDATE products SET stock = $new_stock WHERE id = {$item['product_id']}";
        mysqli_query($conn, $query);
    }

    // Clear cart
    $query = "DELETE FROM cart WHERE user_id = $user_id";
    mysqli_query($conn, $query);

    // Commit transaction
    mysqli_commit($conn);

    $_SESSION['success'] = "Order placed successfully! Order #$order_id";
    header('Location: orders.php');
    exit();

} catch (Exception $e) {
    // Rollback transaction on error
    mysqli_rollback($conn);
    $_SESSION['error'] = "Failed to place order. Please try again.";
    header('Location: checkout.php');
    exit();
}
?> 