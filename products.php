<?php
$page_title = "Products - Astra Store";
include 'includes/header.php';
include 'includes/config.php';

// Get category filter
$category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Build query
$query = "SELECT p.*, c.name as category_name 
          FROM products p 
          LEFT JOIN categories c ON p.category_id = c.id 
          WHERE 1=1";

if ($category_id > 0) {
    $query .= " AND p.category_id = $category_id";
}

if (!empty($search)) {
    $query .= " AND (p.name LIKE '%$search%' OR p.description LIKE '%$search%')";
}

$query .= " ORDER BY p.created_at DESC";

$result = mysqli_query($conn, $query);
?>

<!-- Hero Section -->
<section class="pt-24 pb-12 bg-indigo-600">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 slide-up">Our Products</h1>
            <p class="text-xl text-indigo-100 slide-up delay-200">Discover our amazing collection</p>
        </div>
    </div>
</section>

<!-- Search and Filter Section -->
<section class="py-8 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <!-- Search Form -->
            <form action="" method="GET" class="w-full md:w-1/3">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           placeholder="Search products..." 
                           value="<?php echo htmlspecialchars($search); ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent">
                    <button type="submit" class="absolute right-2 top-2 text-gray-400 hover:text-indigo-600">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <!-- Category Filter -->
            <div class="w-full md:w-1/3">
                <select name="category" 
                        onchange="window.location.href='products.php?category='+this.value"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent">
                    <option value="0">All Categories</option>
                    <?php
                    $cat_query = "SELECT * FROM categories ORDER BY name";
                    $cat_result = mysqli_query($conn, $cat_query);
                    while ($cat = mysqli_fetch_assoc($cat_result)) {
                        $selected = ($category_id == $cat['id']) ? 'selected' : '';
                        echo "<option value='{$cat['id']}' {$selected}>{$cat['name']}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
</section>

<!-- Products Grid -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($product = mysqli_fetch_assoc($result)) {
                    $price = $product['sale_price'] ? $product['sale_price'] : $product['price'];
                    $discount = $product['sale_price'] ? round((($product['price'] - $product['sale_price']) / $product['price']) * 100) : 0;
                    ?>
                    <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                        <?php if ($discount > 0): ?>
                            <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded-full text-sm">
                                -<?php echo $discount; ?>%
                            </div>
                        <?php endif; ?>
                        
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                             alt="<?php echo htmlspecialchars($product['name']); ?>" 
                             class="w-full h-48 object-cover">
                        
                        <div class="p-4">
                            <div class="text-sm text-gray-500 mb-1">
                                <?php echo htmlspecialchars($product['category_name']); ?>
                            </div>
                            
                            <h3 class="text-lg font-semibold mb-2">
                                <?php echo htmlspecialchars($product['name']); ?>
                            </h3>
                            
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <?php if ($product['sale_price']): ?>
                                        <span class="text-gray-500 line-through mr-2">
                                            $<?php echo number_format($product['price'], 2); ?>
                                        </span>
                                    <?php endif; ?>
                                    <span class="text-indigo-600 font-bold">
                                        $<?php echo number_format($price, 2); ?>
                                    </span>
                                </div>
                                
                                <div class="text-sm text-gray-500">
                                    Stock: <?php echo $product['stock']; ?>
                                </div>
                            </div>
                            
                            <button class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition"
                                    onclick="addToCart(<?php echo $product['id']; ?>)">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="col-span-4 text-center py-8">
                        <p class="text-gray-500">No products found.</p>
                      </div>';
            }
            ?>
        </div>
    </div>
</section>

<!-- AJAX Script for Add to Cart -->
<script>
function addToCart(productId) {
    $.ajax({
        url: 'includes/cart_actions.php',
        type: 'POST',
        data: {
            action: 'add',
            product_id: productId
        },
        success: function(response) {
            const data = JSON.parse(response);
            if (data.success) {
                // Show success message
                alert('Product added to cart!');
            } else {
                // Show error message
                alert(data.message || 'Error adding product to cart');
            }
        },
        error: function() {
            alert('Error connecting to server');
        }
    });
}
</script>

<?php include 'includes/footer.php'; ?> 