<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteers of Vitthal - Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo"><img src="logo.png" alt="Panchi" height="200px" width="500px"></div>
            <h1>Volunteers of <span>Vitthal</span></h1>
            <p class="subtitle">"Let's teach our children that true devotion includes service."</p>
            <div class="tagline">
                <i class="fas fa-hands-helping"></i> Register Now to Join the Movement
            </div>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <form action="submit.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>1. Full Name <span class="required">*</span></label>
                <input type="text" name="full_name" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label>2. Mobile Number <span class="required">*</span></label>
                <input type="tel" name="mobile_number" placeholder="10-digit mobile number" pattern="[0-9]{10}" required>
            </div>

            <div class="form-group">
                <label>3. WhatsApp Number <span class="required">*</span></label>
                <input type="tel" name="whatsapp_number" placeholder="10-digit WhatsApp number" pattern="[0-9]{10}" required>
            </div>

            <div class="form-group">
                <label>4. Email ID <span class="required">*</span></label>
                <input type="email" name="email" placeholder="your@email.com" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>5. Age <span class="required">*</span></label>
                    <input type="number" name="age" placeholder="Your age" min="1" max="120" required>
                </div>
                <div class="form-group">
                    <label>6. Gender <span class="required">*</span></label>
                    <select name="gender" required>
                        <option value="">Select</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                        <option value="Prefer not to say">Prefer not to say</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>7. City / Area <span class="required">*</span></label>
                <input type="text" name="city" placeholder="Your city or locality" required>
            </div>

            <div class="form-group">
                <label>8. Number of Participants <span class="required">*</span></label>
                <input type="number" name="participants" placeholder="How many people are joining?" min="1" required>
            </div>

            <div class="form-group">
                <label>9. Names of Additional Family Members <span class="hint">(if any)</span></label>
                <input type="text" name="family_members" placeholder="Names of others joining with you">
            </div>

            <div class="form-group">
                <label>10. Emergency Contact Name <span class="required">*</span></label>
                <input type="text" name="emergency_name" placeholder="Full name of emergency contact" required>
            </div>

            <div class="form-group">
                <label>11. Emergency Contact Number <span class="required">*</span></label>
                <input type="tel" name="emergency_phone" placeholder="10-digit emergency number" pattern="[0-9]{10}" required>
            </div>

            <div class="form-group">
                <label>12. Medical Conditions <span class="hint">(if any)</span></label>
                <input type="text" name="medical_conditions" placeholder="Any medical conditions we should know about">
            </div>

            <div class="form-group">
                <label>13. How did you hear about this event? What are your expectations? <span class="required">*</span></label>
                <textarea name="expectations" placeholder="Tell us how you found us and what you hope to gain from this experience..." required></textarea>
            </div>

            <div class="form-group">
                <label>14. UPI Payment Screenshot Upload <span class="required">*</span></label>
                <input type="file" name="payment_screenshot" accept="image/*" required>
                <p class="hint-text"><i class="fas fa-info-circle"></i> Please upload a clear screenshot of your UPI payment (Max 5MB)</p>
            </div>

            <div class="declaration">
                <label>
                    <input type="checkbox" name="declaration" value="1" required>
                    <span>
                        <strong>Declaration:</strong> I understand this is a <span class="highlight">volunteer activity</span>
                        and registration fees are <span class="highlight">non-refundable</span>.
                        I also acknowledge that <span class="highlight">photographs will be captured</span>
                        for social media usage.
                    </span>
                </label>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-hand-holding-heart"></i> Register Now
            </button>
        </form>

        <div class="footer">
            <i class="fas fa-heart"></i> Volunteers of Vitthal &bull; Service with Devotion
        </div>
    </div>
</body>
</html>