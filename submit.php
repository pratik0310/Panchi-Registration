<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $mobile_number = mysqli_real_escape_string($conn, $_POST['mobile_number']);
    $whatsapp_number = mysqli_real_escape_string($conn, $_POST['whatsapp_number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $age = intval($_POST['age']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $participants = intval($_POST['participants']);
    $family_members = mysqli_real_escape_string($conn, $_POST['family_members']);
    $emergency_name = mysqli_real_escape_string($conn, $_POST['emergency_name']);
    $emergency_phone = mysqli_real_escape_string($conn, $_POST['emergency_phone']);
    $medical_conditions = mysqli_real_escape_string($conn, $_POST['medical_conditions']);
    $expectations = mysqli_real_escape_string($conn, $_POST['expectations']);
    $declaration = isset($_POST['declaration']) ? 1 : 0;

    $errors = [];

    if (empty($full_name)) $errors[] = "Full name is required";
    if (!preg_match('/^[0-9]{10}$/', $mobile_number)) $errors[] = "Invalid mobile number";
    if (!preg_match('/^[0-9]{10}$/', $whatsapp_number)) $errors[] = "Invalid WhatsApp number";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email";
    if ($age < 1 || $age > 120) $errors[] = "Invalid age";
    if (empty($gender)) $errors[] = "Gender is required";
    if (empty($city)) $errors[] = "City is required";
    if ($participants < 1) $errors[] = "At least 1 participant required";
    if (empty($emergency_name)) $errors[] = "Emergency contact name is required";
    if (!preg_match('/^[0-9]{10}$/', $emergency_phone)) $errors[] = "Invalid emergency contact number";
    if (empty($expectations)) $errors[] = "Expectations are required";
    if (!$declaration) $errors[] = "Please accept the declaration";

    if (isset($_FILES['payment_screenshot']) && $_FILES['payment_screenshot']['error'] === 0) {
        $file = $_FILES['payment_screenshot'];
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        
        if (!in_array($file['type'], $allowed_types)) {
            $errors[] = "Only JPG, PNG, and GIF images are allowed";
        }
        if ($file['size'] > 5 * 1024 * 1024) {
            $errors[] = "File size must be less than 5MB";
        }
        
        if (empty($errors)) {
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $filename = time() . '_' . basename($file['name']);
            $target_path = $upload_dir . $filename;
            
            if (move_uploaded_file($file['tmp_name'], $target_path)) {
                $payment_screenshot = $target_path;
            } else {
                $errors[] = "Failed to upload file";
            }
        }
    } else {
        $errors[] = "Payment screenshot is required";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO registrations (
            full_name, mobile_number, whatsapp_number, email, age, gender, 
            city, participants, family_members, emergency_name, emergency_phone,
            medical_conditions, expectations, payment_screenshot, declaration
        ) VALUES (
            '$full_name', '$mobile_number', '$whatsapp_number', '$email', $age, '$gender',
            '$city', $participants, '$family_members', '$emergency_name', '$emergency_phone',
            '$medical_conditions', '$expectations', '$payment_screenshot', $declaration
        )";

        if (mysqli_query($conn, $sql)) {
            header('Location: thank-you.php?name=' . urlencode($full_name));
            exit();
        } else {
            $errors[] = "Database error: " . mysqli_error($conn);
        }
    }

    if (!empty($errors)) {
        $error_message = implode(', ', $errors);
        header('Location: index.php?error=' . urlencode($error_message));
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>