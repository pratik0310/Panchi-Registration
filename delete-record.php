<?php
require_once 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin-login.php');
    exit();
}

// Check if ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // First, get the record to delete the screenshot file
    $select_sql = "SELECT payment_screenshot FROM registrations WHERE id = $id";
    $select_result = mysqli_query($conn, $select_sql);
    
    if ($select_result && mysqli_num_rows($select_result) > 0) {
        $row = mysqli_fetch_assoc($select_result);
        $screenshot_path = $row['payment_screenshot'];
        
        // Delete the screenshot file from server
        if (!empty($screenshot_path) && file_exists($screenshot_path)) {
            unlink($screenshot_path);
        }
    }
    
    // Delete the record from database
    $delete_sql = "DELETE FROM registrations WHERE id = $id";
    
    if (mysqli_query($conn, $delete_sql)) {
        // Redirect back with success message
        header('Location: admin-dashboard.php?deleted=1');
        exit();
    } else {
        // Redirect back with error message
        header('Location: admin-dashboard.php?error=delete_failed');
        exit();
    }
} else {
    // Invalid ID
    header('Location: admin-dashboard.php');
    exit();
}
?>