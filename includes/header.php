<?php
if (!isset($page_title)) {
    $page_title = "Astra Store";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="index.php" class="text-2xl font-bold text-blue-600">Astra Store</a>
                    </div>
                    <div class="hidden md:flex space-x-8">
                        <a href="index.php" class="text-gray-600 hover:text-blue-600">Home</a>
                        <a href="shop.php" class="text-gray-600 hover:text-blue-600">Shop</a>
                        <a href="categories.php" class="text-gray-600 hover:text-blue-600">Categories</a>
                        <a href="about.php" class="text-gray-600 hover:text-blue-600">About</a>
                        <a href="contact.php" class="text-gray-600 hover:text-blue-600">Contact</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <?php
                    include 'config.php';
                    $cart_count = 0;
                    if (isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];
                        $query = "SELECT SUM(quantity) as count FROM cart WHERE user_id = $user_id";
                        $result = mysqli_query($conn, $query);
                        if ($result) {
                            $row = mysqli_fetch_assoc($result);
                            $cart_count = $row['count'] ?? 0;
                        }
                    }
                    ?>
                    <a href="cart.php" class="text-gray-600 hover:text-blue-600 relative">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <?php if ($cart_count > 0): ?>
                            <span class="absolute -top-2 -right-2 bg-blue-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                <?php echo $cart_count; ?>
                            </span>
                        <?php endif; ?>
                    </a>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    @click.away="open = false"
                                    class="flex items-center space-x-2 text-gray-600 hover:text-blue-600 focus:outline-none">
                                <i class="fas fa-user-circle text-xl"></i>
                                <span class="hidden md:inline"><?php echo $_SESSION['email']; ?></span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                
                                <a href="profile.php" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i>
                                    Profile
                                </a>
                                
                                <a href="orders.php" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-shopping-bag mr-2"></i>
                                    Orders
                                </a>
                                
                                <div class="border-t border-gray-100 my-1"></div>
                                
                                <a href="logout.php" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>
                                    Logout
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="text-gray-600 hover:text-blue-600">Sign In</a>
                        <a href="register.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="index.php" class="block px-3 py-2 text-gray-600 hover:text-blue-600">Home</a>
            <a href="shop.php" class="block px-3 py-2 text-gray-600 hover:text-blue-600">Shop</a>
            <a href="categories.php" class="block px-3 py-2 text-gray-600 hover:text-blue-600">Categories</a>
            <a href="about.php" class="block px-3 py-2 text-gray-600 hover:text-blue-600">About</a>
            <a href="contact.php" class="block px-3 py-2 text-gray-600 hover:text-blue-600">Contact</a>
        </div>
    </div>

    <main class="container mx-auto px-4 py-8">
    <script>
    // Toggle user menu
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');
    
    if (userMenuButton && userMenu) {
        userMenuButton.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });

        // Close menu when clicking outside
        document.addEventListener('click', (event) => {
            if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    }
    </script>
</body>
</html> 