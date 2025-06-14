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
![Screenshot 2025-06-14 230126](https://github.com/user-attachments/assets/4a99cfd2-7337-45d6-afb2-b815be460945)
![Screenshot 2025-06-14 230116](https://github.com/user-attachments/assets/1330f594-9184-4bd2-8aec-92583e3ca330)
![Screenshot 2025-06-14 230749](https://github.com/user-attachments/assets/99975e59-b63e-456b-aafd-69e7527ec0ff)
![Screenshot 2025-06-14 230740](https://github.com/user-attachments/assets/05378676-2560-4433-bb47-1904c3af5213)
![Screenshot 2025-06-14 230427](https://github.com/user-attachments/assets/04bfe1a3-3cc0-4911-bb03-c1c01791da4c)
![Screenshot 2025-06-14 230253](https://github.com/user-attachments/assets/de94447f-c24a-4bc6-89bb-52cd4a18756e)
![Screenshot 2025-06-14 230243](https://github.com/user-attachments/assets/73aeb7e2-5c30-4d7f-a0f8-7516257e6897)
![Screenshot 2025-06-14 230235](https://github.com/user-attachments/assets/297c5e0e-51ba-4a27-b0df-d03da81895bd)
![Screenshot 2025-06-14 230230](https://github.com/user-attachments/assets/a5344588-21d8-4c53-b267-9ec6f3db2851)
![Screenshot 2025-06-14 230216](https://github.com/user-attachments/assets/43f623bb-b1bc-44ae-890c-e1ab3d3fea5c)
![Screenshot 2025-06-14 230208](https://github.com/user-attachments/assets/ea40ad6b-2248-4531-a759-a5bdadd24de5)
![Screenshot 2025-06-14 230201](https://github.com/user-attachments/assets/edc5b91e-c7fa-4f6d-ac20-e9a10c740e0e)
![Screenshot 2025-06-14 230155](https://github.com/user-attachments/assets/b0cf5ee3-ce04-4dd9-8cbe-bdddc12b3fc5)
![Screenshot 2025-06-14 230146](https://github.com/user-attachments/assets/86651fe7-df48-42e5-ba73-5a4a5cef56fe)
![Screenshot 2025-06-14 230133](https://github.com/user-attachments/assets/6c853ec2-5df4-443b-9e10-8c9484dd0746)


### Admin Interface

![Screenshot 2025-06-14 230053](https://github.com/user-attachments/assets/80cf4992-6231-461d-bcea-b7b2c00c8c66)
![Screenshot 2025-06-14 230045](https://github.com/user-attachments/assets/3f931e50-c206-49ed-9637-2344cd89686a)
![Screenshot 2025-06-14 230037](https://github.com/user-attachments/assets/6502d7a6-b117-464b-98d5-5ac184b0090e)
![Screenshot 2025-06-14 230026](https://github.com/user-attachments/assets/a2a03ef7-d0f5-4aa5-ba0a-62afe23f47a0)
![Screenshot 2025-06-14 230016](https://github.com/user-attachments/assets/46eded4a-1077-4c37-8575-798d36b22c91)
![Screenshot 2025-06-14 230102](https://github.com/user-attachments/assets/ccfba9ba-e38a-4222-8594-4012ff09610b)

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
astra_store/
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
