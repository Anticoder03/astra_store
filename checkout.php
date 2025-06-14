<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Get user information
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Get cart items with product details
$query = "SELECT c.*, p.name, p.price, p.stock, p.image_url as image 
          FROM cart c 
          JOIN products p ON c.product_id = p.id 
          WHERE c.user_id = $user_id";
$result = mysqli_query($conn, $query);
$cart_items = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Calculate totals
$subtotal = 0;
$shipping = 10; // Fixed shipping cost
foreach ($cart_items as $item) {
    $subtotal += $item['quantity'] * $item['price'];
}
$total = $subtotal + $shipping;

$page_title = "Checkout";
include 'includes/header.php';
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Checkout</h1>

    <?php if (empty($cart_items)): ?>
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <p class="text-gray-600">Your cart is empty.</p>
            <a href="shop.php" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                Continue Shopping
            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Order Summary -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                    <div class="space-y-4">
                        <?php foreach ($cart_items as $item): ?>
                            <div class="flex items-center space-x-4">
                                <img src="<?php echo getImagePath($item['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($item['name']); ?>"
                                     class="w-16 h-16 object-cover rounded"
                                     onerror="this.src='assets/images/default.jpg'">
                                <div class="flex-1">
                                    <h3 class="font-medium"><?php echo htmlspecialchars($item['name']); ?></h3>
                                    <p class="text-sm text-gray-600">
                                        Quantity: <?php echo $item['quantity']; ?> × 
                                        $<?php echo number_format($item['price'], 2); ?>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">
                                        $<?php echo number_format($item['quantity'] * $item['price'], 2); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="border-t mt-4 pt-4">
                        <div class="flex justify-between mb-2">
                            <span>Subtotal</span>
                            <span>$<?php echo number_format($subtotal, 2); ?></span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span>Shipping</span>
                            <span>$<?php echo number_format($shipping, 2); ?></span>
                        </div>
                        <div class="flex justify-between font-semibold text-lg">
                            <span>Total</span>
                            <span>$<?php echo number_format($total, 2); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Shipping Information</h2>
                    <form action="process_order.php" method="POST" id="checkout-form">
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">First Name</label>
                                    <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Last Name</label>
                                    <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Shipping Address</label>
                                <textarea name="shipping_address" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                          required><?php echo htmlspecialchars($user['address']); ?></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                                <select name="payment_method"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        required>
                                    <option value="credit_card">Credit Card</option>
                                    <option value="paypal">PayPal</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Order Notes (Optional)</label>
                                <textarea name="notes" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                            </div>

                            <button type="submit"
                                    class="w-full bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Place Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
document.getElementById('checkout-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Here you would typically integrate with a payment gateway
    // For now, we'll just submit the form
    this.submit();
});
</script>

<?php include 'includes/footer.php'; ?> 