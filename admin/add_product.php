<?php
session_start();
include '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Handle image upload
    $image_url = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../assets/images/products/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;
        
        // Check if image file is a actual image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_url = 'assets/images/products/' . $new_filename;
            }
        }
    }
    
    // Insert product into database
    $query = "INSERT INTO products (name, category_id, price, stock, description, image_url) 
              VALUES ('$name', '$category_id', '$price', '$stock', '$description', '$image_url')";
    
    if (mysqli_query($conn, $query)) {
        header('Location: products.php');
        exit();
    } else {
        $_SESSION['error'] = "Error adding product: " . mysqli_error($conn);
        header('Location: products.php');
        exit();
    }
} else {
    header('Location: products.php');
    exit();
} 