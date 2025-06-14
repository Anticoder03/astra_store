<?php
include 'config.php';

$search_term = isset($_GET['term']) ? mysqli_real_escape_string($conn, $_GET['term']) : '';
$category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';

if (strlen($search_term) >= 2) {
    $query = "SELECT p.*, c.name as category_name 
              FROM products p 
              LEFT JOIN categories c ON p.category_id = c.id 
              WHERE (p.name LIKE '%$search_term%' OR p.description LIKE '%$search_term%')";
    
    if (!empty($category)) {
        $query .= " AND c.slug = '$category'";
    }
    
    $query .= " LIMIT 5";
    
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        echo '<div class="p-4">';
        while ($product = mysqli_fetch_assoc($result)) {
            $price = $product['sale_price'] ? $product['sale_price'] : $product['price'];
            ?>
            <a href="products.php?id=<?php echo $product['id']; ?>" 
               class="flex items-center space-x-4 p-2 hover:bg-gray-100 rounded-lg">
                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                     alt="<?php echo htmlspecialchars($product['name']); ?>" 
                     class="w-16 h-16 object-cover rounded">
                
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-gray-900">
                        <?php echo htmlspecialchars($product['name']); ?>
                    </h4>
                    <p class="text-xs text-gray-500">
                        <?php echo htmlspecialchars($product['category_name']); ?>
                    </p>
                </div>
                
                <div class="text-sm font-semibold text-indigo-600">
                    $<?php echo number_format($price, 2); ?>
                </div>
            </a>
            <?php
        }
        echo '</div>';
    } else {
        echo '<div class="p-4 text-center text-gray-500">No products found</div>';
    }
}
?> 