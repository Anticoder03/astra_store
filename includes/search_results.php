<?php
include 'config.php';

// Get search parameters
$search_term = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';
$category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$min_price = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? (float)$_GET['max_price'] : 999999;
$sort = isset($_GET['sort']) ? mysqli_real_escape_string($conn, $_GET['sort']) : 'newest';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 12;

// Build query
$query = "SELECT p.*, c.name as category_name 
          FROM products p 
          LEFT JOIN categories c ON p.category_id = c.id 
          WHERE 1=1";

if (!empty($search_term)) {
    $query .= " AND (p.name LIKE '%$search_term%' OR p.description LIKE '%$search_term%')";
}

if ($category_id > 0) {
    $query .= " AND p.category_id = $category_id";
}

$query .= " AND (p.price BETWEEN $min_price AND $max_price)";

// Add sorting
switch ($sort) {
    case 'price_low':
        $query .= " ORDER BY p.price ASC";
        break;
    case 'price_high':
        $query .= " ORDER BY p.price DESC";
        break;
    case 'name':
        $query .= " ORDER BY p.name ASC";
        break;
    default:
        $query .= " ORDER BY p.created_at DESC";
}

// Get total count for pagination
$count_query = str_replace("SELECT p.*, c.name as category_name", "SELECT COUNT(*) as total", $query);
$count_result = mysqli_query($conn, $count_query);
$total_products = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_products / $per_page);

// Add pagination
$offset = ($page - 1) * $per_page;
$query .= " LIMIT $offset, $per_page";

$result = mysqli_query($conn, $query);

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

    // Generate pagination HTML
    if ($total_pages > 1) {
        echo '<div class="col-span-full mt-8 flex justify-center space-x-2">';
        
        // Previous button
        if ($page > 1) {
            echo '<button onclick="loadProducts(' . ($page - 1) . ')" class="px-4 py-2 bg-white border rounded hover:bg-gray-50">Previous</button>';
        }
        
        // Page numbers
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo '<button class="px-4 py-2 bg-indigo-600 text-white rounded">' . $i . '</button>';
            } else {
                echo '<button onclick="loadProducts(' . $i . ')" class="px-4 py-2 bg-white border rounded hover:bg-gray-50">' . $i . '</button>';
            }
        }
        
        // Next button
        if ($page < $total_pages) {
            echo '<button onclick="loadProducts(' . ($page + 1) . ')" class="px-4 py-2 bg-white border rounded hover:bg-gray-50">Next</button>';
        }
        
        echo '</div>';
    }
} else {
    echo '<div class="col-span-4 text-center py-8">
            <p class="text-gray-500">No products found matching your criteria.</p>
          </div>';
}
?> 