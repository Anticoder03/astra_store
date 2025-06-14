<?php
session_start();
include '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Handle message actions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message_id']) && isset($_POST['action'])) {
    $message_id = mysqli_real_escape_string($conn, $_POST['message_id']);
    $action = mysqli_real_escape_string($conn, $_POST['action']);
    
    if ($action == 'delete') {
        mysqli_query($conn, "DELETE FROM messages WHERE id = $message_id");
    } elseif ($action == 'mark_read') {
        mysqli_query($conn, "UPDATE messages SET is_read = 1 WHERE id = $message_id");
    }
    
    header('Location: messages.php');
    exit();
}

// Get all messages
$query = "SELECT * FROM messages ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
$messages = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Messages - Admin</title>
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
                <a href="users.php" class="block py-2.5 px-4 hover:bg-gray-700">
                    <i class="fas fa-users mr-2"></i> Users
                </a>
                <a href="messages.php" class="block py-2.5 px-4 bg-gray-900">
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
                <h1 class="text-3xl font-bold">Manage Messages</h1>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($messages as $message): ?>
                                <tr class="<?php echo !$message['is_read'] ? 'bg-blue-50' : ''; ?>">
                                    <td class="px-6 py-4">
                                        <?php if (!$message['is_read']): ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                New
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo htmlspecialchars($message['name']); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo htmlspecialchars($message['email']); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo htmlspecialchars($message['subject']); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo date('M j, Y', strtotime($message['created_at'])); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-3">
                                            <?php if (!$message['is_read']): ?>
                                                <form method="POST" class="inline-block">
                                                    <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                                                    <input type="hidden" name="action" value="mark_read">
                                                    <button type="submit" class="text-blue-600 hover:text-blue-800">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <button onclick="viewMessage(<?php echo $message['id']; ?>)" 
                                                    class="text-green-600 hover:text-green-800">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <form method="POST" class="inline-block" 
                                                  onsubmit="return confirm('Are you sure you want to delete this message?');">
                                                <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
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

    <!-- Message View Modal -->
    <div id="messageModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Message Details</h3>
                <div id="messageDetails" class="mt-2 px-7 py-3">
                    <!-- Message details will be loaded here -->
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
        function viewMessage(messageId) {
            const modal = document.getElementById('messageModal');
            const details = document.getElementById('messageDetails');
            
            // Fetch message details
            fetch(`get_message_details.php?id=${messageId}`)
                .then(response => response.json())
                .then(data => {
                    details.innerHTML = `
                        <div class="text-left">
                            <p><strong>From:</strong> ${data.name} (${data.email})</p>
                            <p><strong>Subject:</strong> ${data.subject}</p>
                            <p><strong>Date:</strong> ${new Date(data.created_at).toLocaleDateString()}</p>
                            <div class="mt-4">
                                <h4 class="font-semibold">Message:</h4>
                                <p class="mt-2 text-gray-600">${data.message}</p>
                            </div>
                        </div>
                    `;
                    modal.classList.remove('hidden');
                });
        }

        document.getElementById('closeModal').addEventListener('click', () => {
            document.getElementById('messageModal').classList.add('hidden');
        });
    </script>
</body>
</html> 