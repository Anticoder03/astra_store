<?php
session_start();
include 'includes/config.php';

// Get category ID from URL
$category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get all categories with product counts
$categories_query = "SELECT c.*, COUNT(p.id) as product_count 
                    FROM categories c 
                    LEFT JOIN products p ON c.id = p.category_id 
                    GROUP BY c.id";
$categories_result = mysqli_query($conn, $categories_query);
$categories = mysqli_fetch_all($categories_result, MYSQLI_ASSOC);

// If specific category is selected
if ($category_id > 0) {
    // Get category details
    $category_query = "SELECT * FROM categories WHERE id = $category_id";
    $category_result = mysqli_query($conn, $category_query);
    $category = mysqli_fetch_assoc($category_result);

    if (!$category) {
        header('Location: categories.php');
        exit();
    }

    // Get products in this category
    $products_query = "SELECT * FROM products WHERE category_id = $category_id ORDER BY created_at DESC";
    $products_result = mysqli_query($conn, $products_query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($category) ? $category['name'] : 'All Categories'; ?> - E-Commerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <?php include 'includes/header.php'; ?>

    <div class="container mx-auto px-4 py-8">
        <?php if (isset($category)): ?>
            <!-- Category Products View -->
            <h1 class="text-3xl font-bold mb-8"><?php echo $category['name']; ?></h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php while ($product = mysqli_fetch_assoc($products_result)): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="<?php echo $product['image_url']; ?>" 
                             alt="<?php echo $product['name']; ?>" 
                             class="w-full h-48 object-cover"
                             onerror="this.src='assets/images/default.jpg'">
                        <div class="p-4">
                            <h2 class="text-xl font-semibold mb-2"><?php echo $product['name']; ?></h2>
                            <p class="text-gray-600 mb-4"><?php echo substr($product['description'], 0, 100); ?>...</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-blue-600">$<?php echo number_format($product['price'], 2); ?></span>
                                <a href="product.php?id=<?php echo $product['id']; ?>" 
                                   class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <?php if (mysqli_num_rows($products_result) == 0): ?>
                <div class="text-center py-8">
                    <p class="text-gray-600">No products found in this category.</p>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <!-- All Categories View -->
            <h1 class="text-3xl font-bold mb-8">Browse Categories</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($categories as $cat): ?>
                    <a href="?id=<?php echo $cat['id']; ?>" 
                       class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <img src="<?php echo $cat['image_url']; ?>" 
                             alt="<?php echo $cat['name']; ?>"
                             class="w-full h-48 object-cover"
                             onerror="this.src='assets/images/default.jpg'">
                        <div class="p-4">
                            <h3 class="text-xl font-semibold mb-2"><?php echo $cat['name']; ?></h3>
                            <p class="text-gray-600 mb-2"><?php echo $cat['description']; ?></p>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500"><?php echo $cat['product_count']; ?> Products</span>
                                <span class="text-blue-600">Browse →</span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html> 