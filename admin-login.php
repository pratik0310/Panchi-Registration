<?php
require_once 'config.php';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin-dashboard.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM admins WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $email;
        header('Location: admin-dashboard.php');
        exit();
    } else {
        $error = 'Invalid email or password!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Panchi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* ===== ADMIN LOGIN - CUSTOM STYLES ===== */
        
        /* Login Card Logo */
        .login-logo {
            max-width: 120px;
            width: 100%;
            height: auto;
            border-radius: 50%;
            display: inline-block;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .login-logo-fallback {
            font-size: 60px;
            color: #b8860b;
            display: none;
        }

        .login-logo:not([style*="display: none"]) + .login-logo-fallback {
            display: none;
        }

        .login-logo[style*="display: none"] {
            display: none !important;
        }

        .login-logo[style*="display: none"] + .login-logo-fallback {
            display: block;
        }

        /* Login Header */
        .login-header .brand-name {
            font-size: 24px;
            font-weight: 700;
            color: #b8860b;
        }

        .login-header .brand-sub {
            font-size: 14px;
            color: #888;
            margin-top: 2px;
        }

        /* Login Icon */
        .login-header .login-icon {
            font-size: 40px;
            color: #b8860b;
            display: block;
            margin-bottom: 5px;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-logo {
                max-width: 90px;
            }
            .login-logo-fallback {
                font-size: 50px;
            }
            .login-header .brand-name {
                font-size: 20px;
            }
            .login-header .brand-sub {
                font-size: 12px;
            }
        }

        @media (max-width: 320px) {
            .login-logo {
                max-width: 70px;
            }
            .login-logo-fallback {
                font-size: 40px;
            }
            .login-header .brand-name {
                font-size: 18px;
            }
        }
    </style>
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
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <!-- Panchi Logo -->
                <div class="logo-container">
                    <img src="logo.png" alt="Panchi" class="login-logo" onerror="this.style.display='none'">
                    <span class="login-logo-fallback">🕊️</span>
                </div>
                
                <div class="login-icon"></div>
                <h1>Admin Login</h1>
                <!-- <div class="brand-name">Panchi</div>
                <div class="brand-sub">Volunteer Management</div> -->
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" placeholder="admin@panchi.com" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>
            
            <div class="login-footer">
                <i class="fas fa-heart"></i> Panchi &bull; Service with Devotion
            </div>
        </div>
    </div>

    <script>
        // ===== PRELOADER =====
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            setTimeout(function() {
                preloader.classList.add('hide');
            }, 800);
        });

        setTimeout(function() {
            const preloader = document.getElementById('preloader');
            if (preloader && !preloader.classList.contains('hide')) {
                preloader.classList.add('hide');
            }
        }, 5000);
    </script>
</body>
</html>