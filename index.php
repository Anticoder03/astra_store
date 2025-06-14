<?php
$page_title = "Astra Store - Modern Shopping Experience";
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="pt-16">
    <div class="relative h-[600px] overflow-hidden">
        <div class="hero-slider">
            <div class="slide active">
                <img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Hero 1" class="w-full h-[600px] object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center">
                    <div class="max-w-7xl mx-auto px-4 text-white">
                        <h1 class="text-5xl font-bold mb-4 slide-up">Welcome to Astra Store</h1>
                        <p class="text-xl mb-8 slide-up delay-200">Discover the latest trends in fashion and lifestyle</p>
                        <a href="shop.php" class="bg-indigo-600 text-white px-8 py-3 rounded-full hover:bg-indigo-700 transition slide-up delay-400">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Categories -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Shop by Category</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="category-card group">
                <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Electronics" class="w-full h-64 object-cover rounded-lg">
                <div class="mt-4 text-center">
                    <h3 class="text-xl font-semibold">Electronics</h3>
                    <p class="text-gray-600">Latest gadgets and devices</p>
                </div>
            </div>
            <div class="category-card group">
                <img src="https://images.unsplash.com/photo-1560343090-f0409e92791a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Fashion" class="w-full h-64 object-cover rounded-lg">
                <div class="mt-4 text-center">
                    <h3 class="text-xl font-semibold">Fashion</h3>
                    <p class="text-gray-600">Trendy clothing and accessories</p>
                </div>
            </div>
            <div class="category-card group">
                <img src="https://images.unsplash.com/photo-1556228453-efd6c1ff04f6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Home & Living" class="w-full h-64 object-cover rounded-lg">
                <div class="mt-4 text-center">
                    <h3 class="text-xl font-semibold">Home & Living</h3>
                    <p class="text-gray-600">Make your home beautiful</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Featured Products</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Product Card 1 -->
            <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Product 1" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">Wireless Headphones</h3>
                    <p class="text-gray-600">$199.99</p>
                    <button class="mt-4 w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition">Add to Cart</button>
                </div>
            </div>
            <!-- Product Card 2 -->
            <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                <img src="https://images.unsplash.com/photo-1546868871-7041f2a55e12?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Product 2" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">Smart Watch</h3>
                    <p class="text-gray-600">$299.99</p>
                    <button class="mt-4 w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition">Add to Cart</button>
                </div>
            </div>
            <!-- Product Card 3 -->
            <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Product 3" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">Running Shoes</h3>
                    <p class="text-gray-600">$89.99</p>
                    <button class="mt-4 w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition">Add to Cart</button>
                </div>
            </div>
            <!-- Product Card 4 -->
            <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Product 4" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">Camera Lens</h3>
                    <p class="text-gray-600">$149.99</p>
                    <button class="mt-4 w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition">Add to Cart</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-16 bg-indigo-600">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Subscribe to Our Newsletter</h2>
        <p class="text-indigo-100 mb-8">Get the latest updates on new products and special offers</p>
        <form action="includes/subscribe.php" method="POST" class="max-w-md mx-auto">
            <div class="flex gap-4">
                <input type="email" name="email" placeholder="Enter your email" class="flex-1 px-4 py-3 rounded-lg focus:outline-none" required>
                <button type="submit" class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">Subscribe</button>
            </div>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?> 