<?php
include '../database/db_config.php';
session_start();

$message = '';
$messageType = '';
$token_valid = false;

// Check if token is provided
if (!isset($_GET['token'])) {
    $message = "Invalid or missing reset token.";
    $messageType = 'error';
} else {
    $reset_token = $_GET['token'];
    $token_hash = hash('sha256', $reset_token);
    
    // Verify token
    $query = "SELECT * FROM user WHERE reset_token = '$token_hash' AND reset_expiry > NOW()";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $token_valid = true;
        $user = mysqli_fetch_assoc($result);
    } else {
        $message = "Reset token is invalid or has expired. Please request a new one.";
        $messageType = 'error';
    }
}

// Handle password reset
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $token_valid) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate password
    if (strlen($password) < 8) {
        $message = "Password must be at least 8 characters long.";
        $messageType = 'error';
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match.";
        $messageType = 'error';
    } else {
        // Hash password
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        
        // Update password and clear reset token
        $update_query = "UPDATE user SET password = '$password_hash', reset_token = NULL, reset_expiry = NULL WHERE id = " . $user['id'];
        
        if (mysqli_query($conn, $update_query)) {
            $message = "Password has been reset successfully! You can now login with your new password.";
            $messageType = 'success';
            $token_valid = false; // Prevent form resubmission
        } else {
            $message = "Error updating password. Please try again.";
            $messageType = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Dashboard</title>
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

        .password-strength {
            margin-top: 8px;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .strength-bar {
            height: 4px;
            background: #ddd;
            border-radius: 2px;
            overflow: hidden;
            flex: 1;
        }

        .strength-indicator {
            height: 100%;
            width: 0%;
            background: #ff6b6b;
            transition: all 0.3s ease;
        }

        .strength-indicator.medium {
            width: 60%;
            background: #ffa500;
        }

        .strength-indicator.strong {
            width: 100%;
            background: #00c985;
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

        .btn-submit:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(98, 47, 170, 0.3);
        }

        .btn-submit:active:not(:disabled) {
            transform: translateY(0);
        }

        .btn-submit:disabled {
            opacity: 0.5;
            cursor: not-allowed;
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
            align-items: flex-start;
            gap: 10px;
            flex-direction: column;
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
            <div class="auth-header">
                <h1>Reset Password</h1>
                <p>Create a new password to secure your account</p>
            </div>

            <?php if (!empty($message)): ?>
                <div class="<?php echo $messageType === 'success' ? 'success-message' : 'error-message'; ?>">
                    <i class="fas fa-<?php echo $messageType === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                    <div>
                        <?php echo htmlspecialchars($message); ?>
                        <?php if ($messageType === 'success'): ?>
                            <a href="login.php" style="color: #00c985; text-decoration: underline; margin-top: 8px; display: inline-block;">Go to Login</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($token_valid): ?>
                <div class="info-box">
                    <i class="fas fa-lock"></i>
                    Make sure to use a strong password with at least 8 characters.
                </div>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Enter new password" 
                            required
                            minlength="8"
                            oninput="checkPasswordStrength()"
                        >
                        <div class="password-strength">
                            <span style="font-size: 11px;">Strength:</span>
                            <div class="strength-bar">
                                <div class="strength-indicator" id="strengthIndicator"></div>
                            </div>
                            <span id="strengthText" style="font-size: 11px; color: #ff6b6b;">Weak</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input 
                            type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            placeholder="Confirm new password" 
                            required
                            minlength="8"
                            oninput="checkPasswordMatch()"
                        >
                        <div id="passwordMatch" style="margin-top: 8px; font-size: 12px; display: none;">
                            <span id="matchText"></span>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit" id="submitBtn">
                        <i class="fas fa-key"></i> Reset Password
                    </button>
                </form>
            <?php endif; ?>

            <div class="auth-footer">
                <p><a href="login.php">Back to Login</a></p>
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

        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const indicator = document.getElementById('strengthIndicator');
            const text = document.getElementById('strengthText');
            
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (password.length >= 12) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[!@#$%^&*]/.test(password)) strength++;
            
            if (strength <= 2) {
                indicator.className = 'strength-indicator';
                text.textContent = 'Weak';
                text.style.color = '#ff6b6b';
            } else if (strength <= 3) {
                indicator.className = 'strength-indicator medium';
                text.textContent = 'Medium';
                text.style.color = '#ffa500';
            } else {
                indicator.className = 'strength-indicator strong';
                text.textContent = 'Strong';
                text.style.color = '#00c985';
            }
        }

        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('confirm_password').value;
            const matchDiv = document.getElementById('passwordMatch');
            const matchText = document.getElementById('matchText');
            
            if (confirm.length > 0) {
                matchDiv.style.display = 'block';
                if (password === confirm) {
                    matchText.textContent = '✓ Passwords match';
                    matchText.style.color = '#00c985';
                } else {
                    matchText.textContent = '✗ Passwords do not match';
                    matchText.style.color = '#ff6b6b';
                }
            } else {
                matchDiv.style.display = 'none';
            }
        }
    </script>
</body>
</html>
