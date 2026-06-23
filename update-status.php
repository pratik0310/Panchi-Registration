<?php
require_once 'config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin-login.php');
    exit();
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);
    
    $sql = "UPDATE registrations SET status = '$status' WHERE id = $id";
    mysqli_query($conn, $sql);
}

header('Location: admin-dashboard.php');
exit();
?>