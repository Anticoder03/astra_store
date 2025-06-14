<?php
session_start();
include '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Get statistics
$stats = [
    'total_orders' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders"))['count'],
    'total_users' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"))['count'],
    'total_products' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM products"))['count'],
    'total_messages' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM messages"))['count'],
    'recent_orders' => mysqli_fetch_all(mysqli_query($conn, "SELECT o.*, u.first_name, u.last_name 
        FROM orders o 
        JOIN users u ON o.user_id = u.id 
        ORDER BY o.created_at DESC LIMIT 5"), MYSQLI_ASSOC),
    'recent_messages' => mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM messages 
        ORDER BY created_at DESC LIMIT 5"), MYSQLI_ASSOC)
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white">
            <div class="p-4">
                <h2 class="text-2xl font-semibold">Admin Panel</h2>
            </div>
            <nav class="mt-4">
                <a href="index.php" class="block py-2.5 px-4 bg-gray-900">
                    <i class="fas fa-home mr-2"></i> Dashboard
                </a>
                <a href="orders.php" class="block py-2.5 px-4 hover:bg-gray-700">
                    <i class="fas fa-shopping-cart mr-2"></i> Orders
                </a>
                <a href="users.php" class="block py-2.5 px-4 hover:bg-gray-700">
                    <i class="fas fa-users mr-2"></i> Users
                </a>
                <a href="messages.php" class="block py-2.5 px-4 hover:bg-gray-700">
                    <i class="fas fa-envelope mr-2"></i> Messages
                </a>
                <a href="products.php" class="block py-2.5 px-4 hover:bg-gray-700">
                    <i class="fas fa-box mr-2"></i> Products
                </a>
                <a href="logout.php" class="block py-2.5 px-4 hover:bg-gray-700">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold">Dashboard</h1>
                <p class="text-gray-600">Welcome back, <?php echo htmlspecialchars($_SESSION['admin_name']); ?>!</p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-shopping-cart text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-gray-500 text-sm">Total Orders</h3>
                            <p class="text-2xl font-semibold"><?php echo $stats['total_orders']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-gray-500 text-sm">Total Users</h3>
                            <p class="text-2xl font-semibold"><?php echo $stats['total_users']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-box text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-gray-500 text-sm">Total Products</h3>
                            <p class="text-2xl font-semibold"><?php echo $stats['total_products']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-envelope text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-gray-500 text-sm">Total Messages</h3>
                            <p class="text-2xl font-semibold"><?php echo $stats['total_messages']; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold mb-4">Recent Orders</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($stats['recent_orders'] as $order): ?>
                                <tr>
                                    <td class="px-6 py-4">#<?php echo $order['id']; ?></td>
                                    <td class="px-6 py-4">
                                        <?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            <?php echo $order['status'] == 'completed' ? 'bg-green-100 text-green-800' : 
                                                ($order['status'] == 'processing' ? 'bg-blue-100 text-blue-800' : 
                                                'bg-yellow-100 text-yellow-800'); ?>">
                                            <?php echo ucfirst($order['status']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo date('M j, Y', strtotime($order['created_at'])); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Messages -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Recent Messages</h2>
                <div class="space-y-4">
                    <?php foreach ($stats['recent_messages'] as $message): ?>
                        <div class="border-b pb-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium"><?php echo htmlspecialchars($message['name']); ?></h3>
                                    <p class="text-sm text-gray-500"><?php echo htmlspecialchars($message['email']); ?></p>
                                </div>
                                <span class="text-sm text-gray-500">
                                    <?php echo date('M j, Y', strtotime($message['created_at'])); ?>
                                </span>
                            </div>
                            <p class="mt-2 text-gray-600"><?php echo htmlspecialchars($message['message']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 