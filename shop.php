<?php
$page_title = "Shop - Astra Store";
include 'includes/header.php';
include 'includes/config.php';

// Get filter parameters
$category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$min_price = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? (float)$_GET['max_price'] : 999999;
$sort = isset($_GET['sort']) ? mysqli_real_escape_string($conn, $_GET['sort']) : 'newest';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 12;
$search_term = isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '';

// Get categories for filter
$categories_query = "SELECT * FROM categories ORDER BY name";
$categories_result = mysqli_query($conn, $categories_query);
?>

<div class="bg-gray-100 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-indigo-600 text-white py-16">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold mb-4">Shop Our Products</h1>
            <p class="text-lg">Discover our wide range of products at great prices</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Search Bar -->
        <div class="mb-8">
            <form id="searchForm" class="max-w-2xl mx-auto">
                <div class="relative">
                    <input type="text" 
                           name="q" 
                           value="<?php echo $search_term; ?>"
                           placeholder="Search products..." 
                           class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                           autocomplete="off">
                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
            </form>
        </div>

        <div class="flex flex-col md:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="w-full md:w-64 bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Filters</h2>
                
                <form id="filterForm" class="space-y-6">
                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select name="category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="0">All Categories</option>
                            <?php while ($category = mysqli_fetch_assoc($categories_result)): ?>
                                <option value="<?php echo $category['id']; ?>" <?php echo $category_id == $category['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Price Range Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" name="min_price" placeholder="Min" value="<?php echo $min_price; ?>"
                                   class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <input type="number" name="max_price" placeholder="Max" value="<?php echo $max_price; ?>"
                                   class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Sort Options -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                        <select name="sort" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="newest" <?php echo $sort == 'newest' ? 'selected' : ''; ?>>Newest</option>
                            <option value="price_low" <?php echo $sort == 'price_low' ? 'selected' : ''; ?>>Price: Low to High</option>
                            <option value="price_high" <?php echo $sort == 'price_high' ? 'selected' : ''; ?>>Price: High to Low</option>
                            <option value="name" <?php echo $sort == 'name' ? 'selected' : ''; ?>>Name: A to Z</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition">
                        Apply Filters
                    </button>
                </form>
            </div>

            <!-- Products Grid -->
            <div class="flex-1">
                <div id="productsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Products will be loaded here via AJAX -->
                </div>

                <!-- Pagination -->
                <div id="pagination" class="mt-8 flex justify-center">
                    <!-- Pagination will be loaded here via AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let searchTimeout;

function loadProducts(page = 1) {
    const filterForm = document.getElementById('filterForm');
    const searchForm = document.getElementById('searchForm');
    const formData = new FormData(filterForm);
    const searchData = new FormData(searchForm);
    
    // Merge search data with filter data
    for (let [key, value] of searchData.entries()) {
        formData.append(key, value);
    }
    
    formData.append('page', page);
    const queryString = new URLSearchParams(formData).toString();
    
    fetch(`includes/search_results.php?${queryString}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('productsGrid').innerHTML = html;
            updatePagination(page);
        });
}

function updatePagination(currentPage) {
    // Pagination logic is handled in search_results.php
}

// Load initial products
document.addEventListener('DOMContentLoaded', () => {
    loadProducts();

    // Handle filter form submission
    document.getElementById('filterForm').addEventListener('submit', (e) => {
        e.preventDefault();
        loadProducts();
    });

    // Handle search input with debounce
    const searchInput = document.querySelector('input[name="q"]');
    searchInput.addEventListener('input', (e) => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadProducts();
        }, 500); // 500ms debounce
    });
});

// Add to cart function
function addToCart(productId) {
    fetch('includes/cart_actions.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=add&product_id=${productId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart count in header
            const cartCount = document.getElementById('cartCount');
            if (cartCount) {
                cartCount.textContent = data.cart_count;
            }
            
            // Show success message
            alert(data.message);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while adding to cart');
    });
}
</script>

<?php include 'includes/footer.php'; ?> 