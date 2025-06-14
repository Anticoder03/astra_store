<?php
session_start();
include '../includes/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('HTTP/1.1 403 Forbidden');
    exit('Unauthorized');
}

if (!isset($_GET['id'])) {
    header('HTTP/1.1 400 Bad Request');
    exit('Message ID is required');
}

$message_id = mysqli_real_escape_string($conn, $_GET['id']);

// Get message details
$query = "SELECT * FROM messages WHERE id = $message_id";
$result = mysqli_query($conn, $query);
$message = mysqli_fetch_assoc($result);

if (!$message) {
    header('HTTP/1.1 404 Not Found');
    exit('Message not found');
}

// Mark message as read
mysqli_query($conn, "UPDATE messages SET is_read = 1 WHERE id = $message_id");

header('Content-Type: application/json');
echo json_encode($message); 