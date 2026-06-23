<?php
require_once 'config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin-login.php');
    exit();
}

// Set headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="registrations_' . date('Y-m-d') . '.csv"');

$output = fopen('php://output', 'w');

// Add CSV headers
fputcsv($output, [
    'ID', 'Full Name', 'Mobile', 'WhatsApp', 'Email', 'Age', 'Gender', 
    'City', 'Participants', 'Family Members', 'Emergency Contact', 
    'Emergency Phone', 'Medical Conditions', 'Expectations', 
    'Status', 'Registered On'
]);

// Fetch data
$sql = "SELECT * FROM registrations ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, [
        $row['id'],
        $row['full_name'],
        $row['mobile_number'],
        $row['whatsapp_number'],
        $row['email'],
        $row['age'],
        $row['gender'],
        $row['city'],
        $row['participants'],
        $row['family_members'],
        $row['emergency_name'],
        $row['emergency_phone'],
        $row['medical_conditions'],
        $row['expectations'],
        $row['status'],
        $row['created_at']
    ]);
}

fclose($output);
exit();
?>