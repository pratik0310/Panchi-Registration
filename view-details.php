<?php
require_once 'config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin-login.php');
    exit();
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM registrations WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    header('Location: admin-dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Details - Volunteers of Vitthal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="details-container">
        <div class="details-card">
            <h2><i class="fas fa-user"></i> Registration Details</h2>
            
            <div class="details-grid">
                <div class="detail-item">
                    <strong>Full Name:</strong> <?php echo htmlspecialchars($row['full_name']); ?>
                </div>
                <div class="detail-item">
                    <strong>Mobile Number:</strong> <?php echo $row['mobile_number']; ?>
                </div>
                <div class="detail-item">
                    <strong>WhatsApp Number:</strong> <?php echo $row['whatsapp_number']; ?>
                </div>
                <div class="detail-item">
                    <strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?>
                </div>
                <div class="detail-item">
                    <strong>Age:</strong> <?php echo $row['age']; ?>
                </div>
                <div class="detail-item">
                    <strong>Gender:</strong> <?php echo $row['gender']; ?>
                </div>
                <div class="detail-item">
                    <strong>City:</strong> <?php echo htmlspecialchars($row['city']); ?>
                </div>
                <div class="detail-item">
                    <strong>Participants:</strong> <?php echo $row['participants']; ?>
                </div>
                <div class="detail-item">
                    <strong>Family Members:</strong> <?php echo htmlspecialchars($row['family_members']) ?: 'None'; ?>
                </div>
                <div class="detail-item">
                    <strong>Emergency Contact:</strong> <?php echo htmlspecialchars($row['emergency_name']); ?>
                </div>
                <div class="detail-item">
                    <strong>Emergency Phone:</strong> <?php echo $row['emergency_phone']; ?>
                </div>
                <div class="detail-item">
                    <strong>Medical Conditions:</strong> <?php echo htmlspecialchars($row['medical_conditions']) ?: 'None'; ?>
                </div>
                <div class="detail-item">
                    <strong>Expectations:</strong> <?php echo htmlspecialchars($row['expectations']); ?>
                </div>
                <div class="detail-item">
                    <strong>Status:</strong> <?php echo ucfirst($row['status']); ?>
                </div>
                <div class="detail-item">
                    <strong>Registered On:</strong> <?php echo date('d M Y, h:i A', strtotime($row['created_at'])); ?>
                </div>
                <div class="detail-item">
                    <strong>Payment Screenshot:</strong>
                    <a href="<?php echo $row['payment_screenshot']; ?>" target="_blank" class="screenshot-link">
                        <i class="fas fa-image"></i> View Screenshot
                    </a>
                </div>
            </div>
            
            <div style="margin-top: 25px; text-align: center;">
                <a href="admin-dashboard.php" class="btn-home" style="display: inline-block; text-decoration: none;">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</body>
</html>