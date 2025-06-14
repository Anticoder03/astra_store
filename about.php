<?php
$page_title = "About Us - Astra Store";
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="pt-24 pb-12 bg-indigo-600">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 slide-up">About Astra Store</h1>
            <p class="text-xl text-indigo-100 slide-up delay-200">Your Trusted Shopping Destination</p>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <h2 class="text-3xl font-bold text-gray-900">Our Story</h2>
                <p class="text-gray-600 leading-relaxed">
                    Founded in 2024, Astra Store has grown from a small startup to one of the leading e-commerce platforms. 
                    Our journey began with a simple mission: to provide customers with a seamless shopping experience and 
                    access to quality products at competitive prices.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Today, we serve millions of customers worldwide, offering a vast selection of products across various 
                    categories, from electronics to fashion, home goods, and more.
                </p>
            </div>
            <div class="relative">
                <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" 
                     alt="Our Store" 
                     class="rounded-lg shadow-xl">
            </div>
        </div>
    </div>
</section>

<!-- Our Values Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Our Values</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-lg shadow-md">
                <div class="text-indigo-600 text-4xl mb-4">
                    <i class="fas fa-heart"></i>
                </div>
                <h3 class="text-xl font-semibold mb-4">Customer First</h3>
                <p class="text-gray-600">
                    We prioritize our customers' needs and satisfaction above everything else, ensuring the best shopping experience.
                </p>
            </div>
            <div class="bg-white p-8 rounded-lg shadow-md">
                <div class="text-indigo-600 text-4xl mb-4">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="text-xl font-semibold mb-4">Quality Assurance</h3>
                <p class="text-gray-600">
                    Every product in our store undergoes rigorous quality checks to ensure the highest standards.
                </p>
            </div>
            <div class="bg-white p-8 rounded-lg shadow-md">
                <div class="text-indigo-600 text-4xl mb-4">
                    <i class="fas fa-leaf"></i>
                </div>
                <h3 class="text-xl font-semibold mb-4">Sustainability</h3>
                <p class="text-gray-600">
                    We are committed to sustainable practices and reducing our environmental footprint.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Meet Our Team</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" 
                     alt="Team Member" 
                     class="w-48 h-48 rounded-full mx-auto mb-4 object-cover">
                <h3 class="text-xl font-semibold">John Doe</h3>
                <p class="text-gray-600">CEO & Founder</p>
            </div>
            <div class="text-center">
                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" 
                     alt="Team Member" 
                     class="w-48 h-48 rounded-full mx-auto mb-4 object-cover">
                <h3 class="text-xl font-semibold">Jane Smith</h3>
                <p class="text-gray-600">Operations Manager</p>
            </div>
            <div class="text-center">
                <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" 
                     alt="Team Member" 
                     class="w-48 h-48 rounded-full mx-auto mb-4 object-cover">
                <h3 class="text-xl font-semibold">Mike Johnson</h3>
                <p class="text-gray-600">Marketing Director</p>
            </div>
            <div class="text-center">
                <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" 
                     alt="Team Member" 
                     class="w-48 h-48 rounded-full mx-auto mb-4 object-cover">
                <h3 class="text-xl font-semibold">Sarah Williams</h3>
                <p class="text-gray-600">Customer Support Lead</p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-indigo-600 text-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold mb-2">1M+</div>
                <p class="text-indigo-100">Happy Customers</p>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">50K+</div>
                <p class="text-indigo-100">Products</p>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">24/7</div>
                <p class="text-indigo-100">Customer Support</p>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">100+</div>
                <p class="text-indigo-100">Countries Served</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?> 