<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate input
    if (strlen($new_password) < 6) {
        $error = "New password must be at least 6 characters long";
    } elseif ($new_password !== $confirm_password) {
        $error = "New passwords do not match";
    } else {
        // Get current user data
        $query = "SELECT password FROM users WHERE id = $user_id";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);

        // Verify current password
        if (password_verify($current_password, $user['password'])) {
            // Hash new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update password
            $query = "UPDATE users SET password = '$hashed_password' WHERE id = $user_id";
            if (mysqli_query($conn, $query)) {
                $success = "Password updated successfully";
            } else {
                $error = "Failed to update password";
            }
        } else {
            $error = "Current password is incorrect";
        }
    }
}

// Redirect back to profile page with message
$_SESSION['password_message'] = $error ?: $success;
$_SESSION['password_message_type'] = $error ? 'error' : 'success';
header('Location: profile.php');
exit();
?> 