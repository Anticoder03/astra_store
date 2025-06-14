<?php
session_start();
include 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Please login to manage your cart'
    ]);
    exit();
}

$user_id = $_SESSION['user_id'];
$action = $_POST['action'] ?? '';

switch ($action) {
    case 'add':
        $product_id = (int)$_POST['product_id'];
        
        // Check if product exists and has stock
        $query = "SELECT * FROM products WHERE id = $product_id AND stock > 0";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);
            
            // Check if product already in cart
            $query = "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id";
            $result = mysqli_query($conn, $query);
            
            if (mysqli_num_rows($result) > 0) {
                // Update quantity if product exists
                $cart_item = mysqli_fetch_assoc($result);
                $new_quantity = $cart_item['quantity'] + 1;
                
                if ($new_quantity <= $product['stock']) {
                    $query = "UPDATE cart SET quantity = $new_quantity WHERE id = {$cart_item['id']}";
                    mysqli_query($conn, $query);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Not enough stock available'
                    ]);
                    exit();
                }
            } else {
                // Add new item to cart
                $query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)";
                mysqli_query($conn, $query);
            }
            
            // Get updated cart count
            $query = "SELECT SUM(quantity) as count FROM cart WHERE user_id = $user_id";
            $result = mysqli_query($conn, $query);
            $cart_count = mysqli_fetch_assoc($result)['count'] ?? 0;
            
            echo json_encode([
                'success' => true,
                'message' => 'Product added to cart',
                'cart_count' => $cart_count
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Product not available'
            ]);
        }
        break;
        
    case 'update':
        $cart_id = (int)$_POST['cart_id'];
        $type = $_POST['type'];
        
        // Get current cart item
        $query = "SELECT c.*, p.stock 
                 FROM cart c 
                 JOIN products p ON c.product_id = p.id 
                 WHERE c.id = $cart_id AND c.user_id = $user_id";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) > 0) {
            $cart_item = mysqli_fetch_assoc($result);
            $new_quantity = $cart_item['quantity'];
            
            if ($type === 'increase') {
                $new_quantity++;
                if ($new_quantity > $cart_item['stock']) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Not enough stock available'
                    ]);
                    exit();
                }
            } else {
                $new_quantity--;
                if ($new_quantity < 1) {
                    // Remove item if quantity becomes 0
                    $query = "DELETE FROM cart WHERE id = $cart_id";
                    mysqli_query($conn, $query);
                    
                    echo json_encode([
                        'success' => true,
                        'message' => 'Item removed from cart'
                    ]);
                    exit();
                }
            }
            
            $query = "UPDATE cart SET quantity = $new_quantity WHERE id = $cart_id";
            mysqli_query($conn, $query);
            
            echo json_encode([
                'success' => true,
                'message' => 'Cart updated'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Cart item not found'
            ]);
        }
        break;
        
    case 'remove':
        $cart_id = (int)$_POST['cart_id'];
        
        $query = "DELETE FROM cart WHERE id = $cart_id AND user_id = $user_id";
        mysqli_query($conn, $query);
        
        echo json_encode([
            'success' => true,
            'message' => 'Item removed from cart'
        ]);
        break;
        
    default:
        echo json_encode([
            'success' => false,
            'message' => 'Invalid action'
        ]);
}
?> 