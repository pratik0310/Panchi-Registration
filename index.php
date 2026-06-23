<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panchi - Volunteer Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- ===== PRELOADER ===== -->
    <div id="preloader">
        <div class="preloader-content">
            <img src="logo.png" alt="Panchi" class="preloader-logo" onerror="this.style.display='none'">
            <span class="preloader-fallback" style="display: none;">🕊️</span>
            <h2 class="preloader-brand">Volunteers of <span>Vitthal</span></h2>
            <p class="preloader-tagline">Service with Devotion</p>
            <div class="preloader-spinner">
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>
        </div>
    </div>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="container">
        <div class="header">
            <!-- Company Logo -->
            <div class="logo-container">
                <img src="logo.png" alt="Panchi" class="company-logo" onerror="this.style.display='none'">
                <div class="logo-fallback">🕊️</div>
            </div>
            
            <h1>Volunteers of <span>Vitthal</span></h1>
            <p class="subtitle">"Let's teach our children that true devotion includes service."</p>
            <div class="tagline">
                <i class="fas fa-hands-helping"></i> Register Now to Join the Movement
            </div>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <form action="submit.php" method="POST" enctype="multipart/form-data" id="registrationForm">
            <!-- Progress Steps -->
            <div class="progress-steps" id="progressSteps">
                <div class="step active" data-step="1">
                    <span class="step-number">1</span>
                    <span class="step-label">Personal</span>
                </div>
                <div class="step" data-step="2">
                    <span class="step-number">2</span>
                    <span class="step-label">Contact</span>
                </div>
                <div class="step" data-step="3">
                    <span class="step-number">3</span>
                    <span class="step-label">Event</span>
                </div>
                <div class="step" data-step="4">
                    <span class="step-number">4</span>
                    <span class="step-label">Payment</span>
                </div>
            </div>

            <!-- Section 1: Personal Information -->
            <div class="form-section collapsible" data-section="1">
                <div class="section-header" onclick="toggleSection(this)">
                    <h3 class="section-title">
                        <i class="fas fa-user"></i> Personal Information
                        <span class="section-toggle">
                            <i class="fas fa-chevron-up"></i>
                        </span>
                    </h3>
                </div>
                <div class="section-content">
                    <div class="form-group">
                        <label>1. Full Name <span class="required">*</span></label>
                        <input type="text" name="full_name" placeholder="Enter your full name" required>
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
                </div>
            </div>

            <!-- Section 2: Contact Information -->
            <div class="form-section collapsible" data-section="2">
                <div class="section-header" onclick="toggleSection(this)">
                    <h3 class="section-title">
                        <i class="fas fa-phone"></i> Contact Information
                        <span class="section-toggle">
                            <i class="fas fa-chevron-up"></i>
                        </span>
                    </h3>
                </div>
                <div class="section-content">
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

                    <div class="form-group">
                        <label>7. City / Area <span class="required">*</span></label>
                        <input type="text" name="city" placeholder="Your city or locality" required>
                    </div>
                </div>
            </div>

            <!-- Section 3: Event Details -->
            <div class="form-section collapsible" data-section="3">
                <div class="section-header" onclick="toggleSection(this)">
                    <h3 class="section-title">
                        <i class="fas fa-users"></i> Event & Emergency Details
                        <span class="section-toggle">
                            <i class="fas fa-chevron-up"></i>
                        </span>
                    </h3>
                </div>
                <div class="section-content">
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
                </div>
            </div>

            <!-- Section 4: Payment -->
            <div class="form-section collapsible" data-section="4">
                <div class="section-header" onclick="toggleSection(this)">
                    <h3 class="section-title">
                        <i class="fas fa-upload"></i> Payment & Confirmation
                        <span class="section-toggle">
                            <i class="fas fa-chevron-up"></i>
                        </span>
                    </h3>
                </div>
                <div class="section-content">
                    <div class="form-group">
                        <label>14. UPI Payment Screenshot Upload <span class="required">*</span></label>
                        <div class="file-upload-wrapper">
                            <input type="file" name="payment_screenshot" accept="image/*" required id="fileInput">
                            <div class="file-upload-box" id="fileUploadBox">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Click or drag to upload payment screenshot</p>
                                <span class="file-format">JPG, PNG, GIF (Max 5MB)</span>
                            </div>
                        </div>
                        <p class="hint-text"><i class="fas fa-info-circle"></i> Please upload a clear screenshot of your UPI payment</p>
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
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-hand-holding-heart"></i> Register Now
            </button>
        </form>

        <div class="footer">
            <i class="fas fa-heart"></i> Panchi &bull; Service with Devotion
        </div>
    </div>

    <script>
        // ===== PRELOADER =====
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            setTimeout(function() {
                preloader.classList.add('hide');
            }, 1000);
        });

        // Fallback: Hide preloader after 5 seconds
        setTimeout(function() {
            const preloader = document.getElementById('preloader');
            if (preloader && !preloader.classList.contains('hide')) {
                preloader.classList.add('hide');
            }
        }, 5000);

        // ===== TOGGLE SECTIONS =====
        function toggleSection(header) {
            const section = header.closest('.form-section');
            const content = section.querySelector('.section-content');
            const toggle = section.querySelector('.section-toggle i');
            
            if (window.innerWidth <= 768) {
                const allSections = document.querySelectorAll('.form-section');
                allSections.forEach(s => {
                    if (s !== section && s.classList.contains('active')) {
                        s.classList.remove('active');
                        s.querySelector('.section-content').style.display = 'none';
                        s.querySelector('.section-toggle i').className = 'fas fa-chevron-down';
                    }
                });
            }
            
            section.classList.toggle('active');
            
            if (section.classList.contains('active')) {
                content.style.display = 'block';
                toggle.className = 'fas fa-chevron-up';
            } else {
                content.style.display = 'none';
                toggle.className = 'fas fa-chevron-down';
            }
        }

        // ===== AUTO COLLAPSE ON MOBILE =====
        function handleResponsiveCollapse() {
            const sections = document.querySelectorAll('.form-section');
            const isMobile = window.innerWidth <= 768;
            
            sections.forEach((section, index) => {
                const content = section.querySelector('.section-content');
                const toggle = section.querySelector('.section-toggle i');
                
                if (isMobile) {
                    if (index === 0) {
                        section.classList.add('active');
                        content.style.display = 'block';
                        toggle.className = 'fas fa-chevron-up';
                    } else {
                        section.classList.remove('active');
                        content.style.display = 'none';
                        toggle.className = 'fas fa-chevron-down';
                    }
                } else {
                    section.classList.add('active');
                    content.style.display = 'block';
                    toggle.className = 'fas fa-chevron-up';
                }
            });
        }

        // ===== FILE UPLOAD PREVIEW =====
        document.getElementById('fileInput')?.addEventListener('change', function(e) {
            const file = this.files[0];
            const box = document.getElementById('fileUploadBox');
            
            if (file) {
                box.innerHTML = `
                    <i class="fas fa-check-circle" style="color: #28a745;"></i>
                    <p style="color: #28a745; font-weight: 600;">${file.name}</p>
                    <span class="file-format">${(file.size / 1024).toFixed(1)} KB uploaded</span>
                `;
                box.style.borderColor = '#28a745';
                box.style.background = '#f0fff4';
            }
        });

        // ===== RUN ON LOAD & RESIZE =====
        window.addEventListener('load', handleResponsiveCollapse);
        window.addEventListener('resize', handleResponsiveCollapse);

        // ===== PROGRESS STEPS UPDATE =====
        document.querySelectorAll('.form-section').forEach(section => {
            const observer = new MutationObserver(() => {
                updateProgress();
            });
            observer.observe(section, { attributes: true, attributeFilter: ['class'] });
        });

        function updateProgress() {
            const sections = document.querySelectorAll('.form-section');
            const steps = document.querySelectorAll('.step');
            let filled = 0;
            
            sections.forEach(section => {
                const inputs = section.querySelectorAll('input, select, textarea');
                let allFilled = true;
                inputs.forEach(input => {
                    if (input.hasAttribute('required') && !input.value.trim()) {
                        allFilled = false;
                    }
                });
                if (allFilled) filled++;
            });
            
            steps.forEach((step, index) => {
                step.classList.remove('active', 'completed');
                if (index < filled) {
                    step.classList.add('completed');
                } else if (index === filled) {
                    step.classList.add('active');
                }
            });
        }

        // ===== SCROLL TO TOP ON SECTION TOGGLE =====
        document.querySelectorAll('.section-header').forEach(header => {
            header.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    const section = this.closest('.form-section');
                    const rect = section.getBoundingClientRect();
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    window.scrollTo({ top: scrollTop + rect.top - 20, behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>