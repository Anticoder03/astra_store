<?php
session_start();
include '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    mysqli_query($conn, "UPDATE orders SET status = '$status' WHERE id = $order_id");
    header('Location: orders.php');
    exit();
}

// Get all orders with user details
$query = "SELECT o.*, u.first_name, u.last_name, u.email 
          FROM orders o 
          JOIN users u ON o.user_id = u.id 
          ORDER BY o.created_at DESC";
$result = mysqli_query($conn, $query);
$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Admin</title>
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
                <a href="index.php" class="block py-2.5 px-4 hover:bg-gray-700">
                    <i class="fas fa-home mr-2"></i> Dashboard
                </a>
                <a href="orders.php" class="block py-2.5 px-4 bg-gray-900">
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
                <h1 class="text-3xl font-bold">Manage Orders</h1>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td class="px-6 py-4">#<?php echo $order['id']; ?></td>
                                    <td class="px-6 py-4">
                                        <?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo htmlspecialchars($order['email']); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <form method="POST" class="inline-block">
                                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                            <select name="status" onchange="this.form.submit()" 
                                                    class="rounded-md border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500
                                                    <?php echo $order['status'] == 'completed' ? 'bg-green-100 text-green-800' : 
                                                        ($order['status'] == 'processing' ? 'bg-blue-100 text-blue-800' : 
                                                        'bg-yellow-100 text-yellow-800'); ?>">
                                                <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                <option value="processing" <?php echo $order['status'] == 'processing' ? 'selected' : ''; ?>>Processing</option>
                                                <option value="completed" <?php echo $order['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                                <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo date('M j, Y', strtotime($order['created_at'])); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button onclick="viewOrderDetails(<?php echo $order['id']; ?>)" 
                                                class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div id="orderModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Order Details</h3>
                <div id="orderDetails" class="mt-2 px-7 py-3">
                    <!-- Order details will be loaded here -->
                </div>
                <div class="items-center px-4 py-3">
                    <button id="closeModal" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewOrderDetails(orderId) {
            const modal = document.getElementById('orderModal');
            const details = document.getElementById('orderDetails');
            
            // Fetch order details
            fetch(`get_order_details.php?id=${orderId}`)
                .then(response => response.json())
                .then(data => {
                    details.innerHTML = `
                        <div class="text-left">
                            <p><strong>Order ID:</strong> #${data.id}</p>
                            <p><strong>Customer:</strong> ${data.first_name} ${data.last_name}</p>
                            <p><strong>Email:</strong> ${data.email}</p>
                            <p><strong>Status:</strong> ${data.status}</p>
                            <p><strong>Date:</strong> ${new Date(data.created_at).toLocaleDateString()}</p>
                            <p><strong>Shipping Address:</strong> ${data.shipping_address}</p>
                            <p><strong>Notes:</strong> ${data.notes || 'None'}</p>
                            <div class="mt-4">
                                <h4 class="font-semibold">Items:</h4>
                                ${data.items.map(item => `
                                    <div class="mt-2">
                                        <p>${item.name} - Quantity: ${item.quantity} - Price: $${item.price}</p>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    `;
                    modal.classList.remove('hidden');
                });
        }

        document.getElementById('closeModal').addEventListener('click', () => {
            document.getElementById('orderModal').classList.add('hidden');
        });
    </script>
</body>
</html> 