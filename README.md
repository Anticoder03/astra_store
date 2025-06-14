# E-Commerce Website

A modern e-commerce website built with PHP, MySQL, and Tailwind CSS.

## Features

### Customer Features
- User registration and authentication
- Product browsing by categories
- Product search functionality
- Shopping cart management
- Secure checkout process
- Order tracking
- User profile management
- Contact form

### Admin Features
- Secure admin login
- Dashboard with key metrics
- Product management (Add, Edit, Delete)
- Category management
- Order management
- User management
- Message management
- Stock management

## Screenshots

### Customer Interface
- [Home Page](screenshots/home.png)
- [Product Listing](screenshots/products.png)
- [Product Details](screenshots/product-details.png)
- [Shopping Cart](screenshots/cart.png)
- [Checkout](screenshots/checkout.png)
- [User Profile](screenshots/profile.png)

### Admin Interface
- [Admin Dashboard](screenshots/admin/dashboard.png)
- [Product Management](screenshots/admin/products.png)
- [Order Management](screenshots/admin/orders.png)
- [User Management](screenshots/admin/users.png)
- [Category Management](screenshots/admin/categories.png)

## Installation

1. Clone the repository:
```bash
git clone  https://github.com/Anticoder03/astra_store.git
```

2. Set up your web server (e.g., XAMPP) and place the files in the appropriate directory.

3. Create a MySQL database and import the database schema:
```sql
CREATE DATABASE ecommerce;
USE ecommerce;
-- Import the database.sql file
```

4. Configure the database connection:
- Open `includes/config.php`
- Update the database credentials:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_NAME', 'ecommerce');
```

5. Set up the required directories:
```bash
mkdir assets/images
mkdir assets/images/products
mkdir assets/images/categories
```

6. Set appropriate permissions:
```bash
chmod 755 assets/images
chmod 755 assets/images/products
chmod 755 assets/images/categories
```

## Directory Structure

```
ecommerce/
├── admin/
│   ├── index.php
│   ├── login.php
│   ├── products.php
│   ├── orders.php
│   ├── users.php
│   └── messages.php
├── assets/
│   ├── images/
│   │   ├── products/
│   │   ├── categories/
│   │   └── default.jpg
│   └── css/
├── includes/
│   ├── config.php
│   ├── header.php
│   ├── footer.php
│   └── functions.php
├── index.php
├── products.php
├── categories.php
├── cart.php
├── checkout.php
├── profile.php
└── contact.php
```

## Default Admin Credentials

- Username: admin
- Password: admin123

**Note:** Please change these credentials after first login.

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- mod_rewrite enabled (for Apache)

## Security Features

- Password hashing
- SQL injection prevention
- XSS protection
- CSRF protection
- Secure file upload handling
- Input validation and sanitization

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, email [ap5381545@gmail.com] or create an issue in the repository. 