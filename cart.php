<?php
session_start();
$page_title = "Shopping Cart - Astra Store";
include 'includes/header.php';
include 'includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = 'cart.php';
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Get cart items
$query = "SELECT c.*, p.name, p.price, p.sale_price, p.image_url, p.stock 
          FROM cart c 
          JOIN products p ON c.product_id = p.id 
          WHERE c.user_id = $user_id";
$result = mysqli_query($conn, $query);

$total = 0;
$items = [];
while ($item = mysqli_fetch_assoc($result)) {
    $price = $item['sale_price'] ? $item['sale_price'] : $item['price'];
    $subtotal = $price * $item['quantity'];
    $total += $subtotal;
    $items[] = $item;
}
?>

<div class="bg-gray-100 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

        <?php if (empty($items)): ?>
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <p class="text-gray-500 mb-4">Your cart is empty</p>
                <a href="shop.php" class="inline-block bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                    Continue Shopping
                </a>
            </div>
        <?php else: ?>
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Cart Items -->
                <div class="lg:w-2/3">
                    <div class="bg-white rounded-lg shadow-md">
                        <?php foreach ($items as $item): 
                            $price = $item['sale_price'] ? $item['sale_price'] : $item['price'];
                            $subtotal = $price * $item['quantity'];
                        ?>
                            <div class="p-6 border-b last:border-b-0">
                                <div class="flex items-center">
                                    <img src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                                         alt="<?php echo htmlspecialchars($item['name']); ?>"
                                         class="w-24 h-24 object-cover rounded">
                                    
                                    <div class="ml-6 flex-1">
                                        <h3 class="text-lg font-semibold">
                                            <?php echo htmlspecialchars($item['name']); ?>
                                        </h3>
                                        
                                        <div class="mt-2 flex items-center justify-between">
                                            <div class="flex items-center">
                                                <button onclick="updateQuantity(<?php echo $item['id']; ?>, 'decrease')"
                                                        class="px-2 py-1 border rounded hover:bg-gray-100">-</button>
                                                
                                                <span class="mx-4"><?php echo $item['quantity']; ?></span>
                                                
                                                <button onclick="updateQuantity(<?php echo $item['id']; ?>, 'increase')"
                                                        class="px-2 py-1 border rounded hover:bg-gray-100">+</button>
                                            </div>
                                            
                                            <div class="text-right">
                                                <?php if ($item['sale_price']): ?>
                                                    <span class="text-gray-500 line-through">
                                                        $<?php echo number_format($item['price'], 2); ?>
                                                    </span>
                                                <?php endif; ?>
                                                
                                                <span class="text-lg font-semibold text-indigo-600">
                                                    $<?php echo number_format($subtotal, 2); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <button onclick="removeItem(<?php echo $item['id']; ?>)"
                                            class="ml-6 text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:w-1/3">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-lg font-semibold mb-4">Order Summary</h2>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>$<?php echo number_format($total, 2); ?></span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span>Shipping</span>
                                <span>Free</span>
                            </div>
                            
                            <div class="border-t pt-4">
                                <div class="flex justify-between font-semibold">
                                    <span>Total</span>
                                    <span>$<?php echo number_format($total, 2); ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <button onclick="checkout()"
                                class="w-full mt-6 bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition">
                            Proceed to Checkout
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function updateQuantity(cartId, action) {
    fetch('includes/cart_actions.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=update&cart_id=${cartId}&type=${action}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the cart');
    });
}

function removeItem(cartId) {
    if (confirm('Are you sure you want to remove this item?')) {
        fetch('includes/cart_actions.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=remove&cart_id=${cartId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while removing the item');
        });
    }
}

function checkout() {
    window.location.href = 'checkout.php';
}
</script>

<?php include 'includes/footer.php'; ?> 