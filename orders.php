<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Get user's orders with total items and amount
$query = "SELECT o.*, 
          COUNT(oi.id) as total_items,
          SUM(oi.quantity * oi.price) as total_amount
          FROM orders o
          LEFT JOIN order_items oi ON o.id = oi.order_id
          WHERE o.user_id = $user_id
          GROUP BY o.id
          ORDER BY o.created_at DESC";
$result = mysqli_query($conn, $query);
$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

$page_title = "My Orders";
include 'includes/header.php';
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">My Orders</h1>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?php 
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php 
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <?php if (empty($orders)): ?>
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <p class="text-gray-600">You haven't placed any orders yet.</p>
            <a href="shop.php" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                Start Shopping
            </a>
        </div>
    <?php else: ?>
        <div class="space-y-6">
            <?php foreach ($orders as $order): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h2 class="text-xl font-semibold">Order #<?php echo $order['id']; ?></h2>
                                <p class="text-gray-600">
                                    Placed on <?php echo date('F j, Y', strtotime($order['created_at'])); ?>
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                    <?php echo $order['status'] == 'completed' ? 'bg-green-100 text-green-800' : 
                                        ($order['status'] == 'processing' ? 'bg-blue-100 text-blue-800' : 
                                        'bg-yellow-100 text-yellow-800'); ?>">
                                    <?php echo ucfirst($order['status']); ?>
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Total Items</h3>
                                <p class="mt-1"><?php echo $order['total_items']; ?></p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Total Amount</h3>
                                <p class="mt-1">$<?php echo number_format($order['total_amount'], 2); ?></p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Shipping Address</h3>
                                <p class="mt-1"><?php echo htmlspecialchars($order['shipping_address']); ?></p>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <h3 class="text-lg font-semibold mb-2">Order Items</h3>
                            <?php
                            $items_query = "SELECT oi.*, p.name, p.image_url as image 
                                          FROM order_items oi 
                                          JOIN products p ON oi.product_id = p.id 
                                          WHERE oi.order_id = {$order['id']}";
                            $items_result = mysqli_query($conn, $items_query);
                            $items = mysqli_fetch_all($items_result, MYSQLI_ASSOC);
                            ?>
                            <div class="space-y-4">
                                <?php foreach ($items as $item): ?>
                                    <div class="flex items-center space-x-4">
                                        <img src="<?php echo getImagePath($item['image']); ?>" 
                                             alt="<?php echo htmlspecialchars($item['name']); ?>"
                                             class="w-16 h-16 object-cover rounded"
                                             onerror="this.src='assets/images/default.jpg'">
                                        <div class="flex-1">
                                            <h4 class="font-medium"><?php echo htmlspecialchars($item['name']); ?></h4>
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
                        </div>

                        <?php if ($order['notes']): ?>
                            <div class="border-t mt-4 pt-4">
                                <h3 class="text-sm font-medium text-gray-500">Order Notes</h3>
                                <p class="mt-1 text-gray-600"><?php echo htmlspecialchars($order['notes']); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?> 