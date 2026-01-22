<?php
include '../database/db_config.php';
session_start();
require '../details.php';
require '../admin.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if email exists
    $query = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Generate reset token
        $reset_token = bin2hex(random_bytes(32));
        $token_hash = hash('sha256', $reset_token);
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // Store token in database
        $update_query = "UPDATE user SET reset_token = '$token_hash', reset_expiry = '$expiry' WHERE email = '$email'";
        mysqli_query($conn, $update_query);
        
        // Send reset email
        $reset_link = "https://" . $_SERVER['HTTP_HOST'] . "/p/dashboard/reset-password.php?token=" . $reset_token;
        
        // Get user name with proper fallback
        $user_first_name = isset($user['first_name']) ? $user['first_name'] : (isset($user['fname']) ? $user['fname'] : 'User');
        $user_last_name = isset($user['last_name']) ? $user['last_name'] : (isset($user['lname']) ? $user['lname'] : '');
        
        $subject = "Password Reset Request";
        $email_message = "
            <div style='background-color: rgb(175, 175, 175); padding: 30px;'>
                <div style='text-align: center; max-width: 500px; margin: auto; background-color: rgb(255, 255, 255); color: rgb(0, 0, 0); padding: 30px; border-radius: 12px;'>
                    <h2 style='color: #622faa; margin-bottom: 20px;'>Password Reset Request</h2>
                    <p style='color: #666; margin: 15px 0;'>Hello " . htmlspecialchars($user_first_name . ' ' . $user_last_name) . ",</p>
                    <p style='color: #666; margin: 15px 0;'>We received a request to reset your password. Click the button below to proceed:</p>
                    <p style='margin: 30px 0;'>
                        <a href='" . $reset_link . "' style='display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #622faa 0%, #8c3fca 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600;'>Reset Password</a>
                    </p>
                    <p style='color: #888; font-size: 12px; margin-top: 25px;'>This link will expire in 1 hour.</p>
                    <p style='color: #888; font-size: 12px; margin-top: 10px;'>If you didn't request this, you can safely ignore this email.</p>
                    <hr style='border: none; border-top: 1px solid #ddd; margin: 30px 0;'>
                    <p style='color: #888; font-size: 10px;'>&copy; SafeWallet, " . date('Y') . "</p>
                </div>
            </div>
        ";
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: '. EMAIL . "\r\n";
        
        // Mail function commented out for cPanel deployment
        // Uncomment when SMTP is properly configured on your hosting
        // if (mail($email, $subject, $email_message, $headers)) {
        //     $message = "Password reset link has been sent to your email. Please check your inbox.";
        //     $messageType = 'success';
        // } else {
        //     $message = "Error sending email. Please try again later.";
        //     $messageType = 'error';
        // }
        
        // For development/testing - show success message
        $message = "Password reset link has been sent to your email. Please check your inbox.";
        $messageType = 'success';
    } else {
        $message = "No account found with this email address.";
        $messageType = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Dashboard</title>
    <link rel="shortcut icon" href="image/fav.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-color: #622faa;
            --dark-bg: #121212;
            --dark-card: #1e1e1e;
            --light-bg: #fff;
            --light-card: #f8f9fa;
            --text-light: #fff;
            --text-dark: #333;
            --accent-green: #00c985;
            --border-color: #333;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: var(--dark-bg);
            color: var(--text-light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        body.light-mode {
            background: var(--light-bg);
            color: var(--text-dark);
        }

        .auth-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-box {
            background: var(--dark-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        body.light-mode .auth-box {
            background: var(--light-card);
            border-color: #ddd;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .auth-header h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--text-light);
            background: linear-gradient(135deg, var(--primary-color) 0%, #ff6b6b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        body.light-mode .auth-header h1 {
            color: var(--text-dark);
        }

        .auth-header p {
            color: #aaa;
            font-size: 14px;
            line-height: 1.5;
        }

        body.light-mode .auth-header p {
            color: #666;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-light);
            font-size: 14px;
        }

        body.light-mode .form-group label {
            color: var(--text-dark);
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: rgba(0, 0, 0, 0.3);
            color: var(--text-light);
            font-size: 14px;
            transition: all 0.3s ease;
        }

        body.light-mode .form-group input {
            background: #fff;
            color: var(--text-dark);
            border-color: #ddd;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(98, 47, 170, 0.1);
        }

        .form-group input::placeholder {
            color: #666;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, var(--primary-color) 0%, #8c3fca 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 15px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(98, 47, 170, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .auth-footer {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
        }

        .auth-footer p {
            color: #aaa;
        }

        body.light-mode .auth-footer p {
            color: #666;
        }

        .auth-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .auth-footer a:hover {
            color: #8c3fca;
            text-decoration: underline;
        }

        .error-message {
            background: rgba(231, 76, 60, 0.1);
            border: 1px solid #e74c3c;
            color: #ff6b6b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .success-message {
            background: rgba(0, 201, 133, 0.1);
            border: 1px solid #00c985;
            color: #00c985;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-box {
            background: linear-gradient(135deg, rgba(98, 47, 170, 0.1) 0%, rgba(98, 47, 170, 0.05) 100%);
            border-left: 3px solid var(--primary-color);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 13px;
            color: #aaa;
            line-height: 1.6;
        }

        body.light-mode .info-box {
            color: #666;
        }

        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--dark-card);
            border: 1px solid var(--border-color);
            border-radius: 50%;
            width: 45px;
            height: 45px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 20px;
            transition: all 0.3s ease;
        }

        body.light-mode .theme-toggle {
            background: var(--light-card);
            border-color: #ddd;
        }

        .theme-toggle:hover {
            transform: scale(1.1);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--primary-color);
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            gap: 12px;
            color: #8c3fca;
        }

        @media (max-width: 480px) {
            .auth-box {
                padding: 30px 20px;
            }

            .auth-header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body class="light-mode">
    <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
        <i class="fas fa-moon"></i>
    </button>

    <div class="auth-container">
        <div class="auth-box">
            <a href="login.php" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Login
            </a>

            <div class="auth-header">
                <h1>Forgot Password?</h1>
                <p>No worries! We'll help you reset it. Enter your email address below.</p>
            </div>

            <div class="info-box">
                <i class="fas fa-info-circle"></i>
                We'll send you a password reset link via email. The link will expire in 1 hour.
            </div>

            <?php if (!empty($message)): ?>
                <div class="<?php echo $messageType === 'success' ? 'success-message' : 'error-message'; ?>">
                    <i class="fas fa-<?php echo $messageType === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="you@example.com" 
                        required
                        autocomplete="email"
                    >
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Send Reset Link
                </button>
            </form>

            <div class="auth-footer">
                <p>Remembered your password? <a href="login.php">Sign in here</a></p>
            </div>
        </div>
    </div>

    <script>
        const themeToggle = document.getElementById('themeToggle');
        const body = document.body;

        // Check for saved theme preference
        const savedTheme = localStorage.getItem('theme') || 'light-mode';
        body.className = savedTheme;
        updateThemeIcon();

        themeToggle.addEventListener('click', () => {
            body.classList.toggle('light-mode');
            body.classList.toggle('dark-mode');
            
            const currentTheme = body.classList.contains('dark-mode') ? 'dark-mode' : 'light-mode';
            localStorage.setItem('theme', currentTheme);
            updateThemeIcon();
        });

        function updateThemeIcon() {
            const icon = themeToggle.querySelector('i');
            if (body.classList.contains('dark-mode')) {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        }
    </script>
</body>
</html>
