<?php
session_start();
include '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Handle user status updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id']) && isset($_POST['action'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $action = mysqli_real_escape_string($conn, $_POST['action']);
    
    if ($action == 'delete') {
        mysqli_query($conn, "DELETE FROM users WHERE id = $user_id");
    } elseif ($action == 'toggle_status') {
        mysqli_query($conn, "UPDATE users SET is_active = NOT is_active WHERE id = $user_id");
    }
    
    header('Location: users.php');
    exit();
}

// Get all users
$query = "SELECT * FROM users ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin</title>
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
                <a href="orders.php" class="block py-2.5 px-4 hover:bg-gray-700">
                    <i class="fas fa-shopping-cart mr-2"></i> Orders
                </a>
                <a href="users.php" class="block py-2.5 px-4 bg-gray-900">
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
                <h1 class="text-3xl font-bold">Manage Users</h1>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Joined</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="px-6 py-4"><?php echo $user['id']; ?></td>
                                    <td class="px-6 py-4">
                                        <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo htmlspecialchars($user['email']); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo htmlspecialchars($user['phone']); ?>
                                    </td>
                                    <!-- <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            <?php echo $user['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                            <?php echo $user['is_active'] ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    </td> -->
                                    <td class="px-6 py-4">
                                        <?php echo date('M j, Y', strtotime($user['created_at'])); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-3">
                                            <form method="POST" class="inline-block">
                                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                <input type="hidden" name="action" value="toggle_status">
                                                <button type="submit" class="text-blue-600 hover:text-blue-800">
                                                    <i class="fas fa-power-off"></i>
                                                </button>
                                            </form>
                                            <button onclick="viewUserDetails(<?php echo $user['id']; ?>)" 
                                                    class="text-green-600 hover:text-green-800">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <form method="POST" class="inline-block" 
                                                  onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                <input type="hidden" name="action" value="delete">
                                                <button type="submit" class="text-red-600 hover:text-red-800">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- User Details Modal -->
    <div id="userModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">User Details</h3>
                <div id="userDetails" class="mt-2 px-7 py-3">
                    <!-- User details will be loaded here -->
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
        function viewUserDetails(userId) {
            const modal = document.getElementById('userModal');
            const details = document.getElementById('userDetails');
            
            // Fetch user details
            fetch(`get_user_details.php?id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    details.innerHTML = `
                        <div class="text-left">
                            <p><strong>ID:</strong> ${data.id}</p>
                            <p><strong>Name:</strong> ${data.first_name} ${data.last_name}</p>
                            <p><strong>Email:</strong> ${data.email}</p>
                            <p><strong>Phone:</strong> ${data.phone}</p>
                            <p><strong>Address:</strong> ${data.address}</p>
                            <p><strong>Status:</strong> ${data.is_active ? 'Active' : 'Inactive'}</p>
                            <p><strong>Joined:</strong> ${new Date(data.created_at).toLocaleDateString()}</p>
                            <div class="mt-4">
                                <h4 class="font-semibold">Recent Orders:</h4>
                                ${data.orders.map(order => `
                                    <div class="mt-2">
                                        <p>Order #${order.id} - ${order.status} - ${new Date(order.created_at).toLocaleDateString()}</p>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    `;
                    modal.classList.remove('hidden');
                });
        }

        document.getElementById('closeModal').addEventListener('click', () => {
            document.getElementById('userModal').classList.add('hidden');
        });
    </script>
</body>
</html> 