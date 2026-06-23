<?php
$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Volunteer';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Volunteers of Vitthal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="thankyou-container">
        <div class="thankyou-card">
            <div class="thankyou-icon"><img src="logo.png" alt="Panchi" height="150px" width="350px"></div>
            <h1>Registration Successful!</h1>
            <h2>Thank You, <?php echo $name; ?>! 🙏</h2>
            <p>You are now registered as a volunteer for <strong>Volunteers of Vitthal</strong>.</p>
            <p>We will contact you shortly with more details.</p>
            
            <div class="thankyou-message">
                <i class="fas fa-quote-left"></i>
                "Let's teach our children that true devotion includes service."
                <i class="fas fa-quote-right"></i>
            </div>
            
            <div class="thankyou-actions">
                <a href="index.php" class="btn-home">
                    <i class="fas fa-home"></i> Register Another
                </a>
            </div>
            
            <div class="thankyou-footer">
                <i class="fas fa-heart"></i> Volunteers of Vitthal &bull; Service with Devotion
            </div>
        </div>
    </div>
</body>
</html>