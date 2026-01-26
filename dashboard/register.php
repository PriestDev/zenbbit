<?php
include '../database/db_config.php';
session_start();
require '../details.php';
require '../admin.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    if (empty($username)) $errors[] = "Username is required";
    if (empty($email)) $errors[] = "Email is required";
    if (empty($password)) $errors[] = "Password is required";
    if ($password !== $confirm_password) $errors[] = "Passwords do not match";
    if (strlen($password) < 8) $errors[] = "Password must be at least 8 characters";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format";

    // Check if user exists
    if (empty($errors)) {
        $check_query = "SELECT * FROM user WHERE email = '$email' OR acct_id = '$username'";
        $check_result = mysqli_query($conn, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
            $errors[] = "Email or username already exists";
        }
    }

    // Create user if no errors
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
        // Use prepared statement to safely insert password hash without escaping it
        $insert_query = "INSERT INTO user (acct_id, email, password, reg_date) VALUES (?, ?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $insert_query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);
            
            if (mysqli_stmt_execute($stmt)) {
            // Send welcome email
            $subject = "Welcome to ". NAME ."!";
            $welcome_message = "
                <div style='background-color: rgb(175, 175, 175); padding: 30px;'>
                    <div style='text-align: center; max-width: 600px; margin: auto; background-color: rgb(255, 255, 255); color: rgb(0, 0, 0); padding: 40px; border-radius: 12px;'>
                        <div style='margin-bottom: 30px;'>
                            <h2 style='color: #622faa; margin: 0 0 10px 0; font-size: 32px;'>Welcome to ". NAME ."!</h2>
                            <p style='color: #666; margin: 0; font-size: 14px;'>Your secure cryptocurrency wallet</p>
                        </div>
                        
                        <div style='background: linear-gradient(135deg, rgba(98, 47, 170, 0.1) 0%, rgba(255, 107, 107, 0.1) 100%); padding: 25px; border-radius: 12px; margin: 30px 0; text-align: left;'>
                            <h3 style='color: #333; margin: 0 0 15px 0; font-size: 16px;'>Account Details</h3>
                            <p style='color: #666; margin: 8px 0; font-size: 14px;'><strong>Username:</strong> " . htmlspecialchars($username) . "</p>
                            <p style='color: #666; margin: 8px 0; font-size: 14px;'><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
                            <p style='color: #666; margin: 8px 0; font-size: 14px;'><strong>Joined:</strong> " . date('M d, Y') . "</p>
                        </div>
                        
                        <h3 style='color: #333; margin: 25px 0 15px 0; font-size: 16px; text-align: left;'>Getting Started</h3>
                        <div style='text-align: left; margin-bottom: 20px;'>
                            <ol style='color: #666; font-size: 13px; line-height: 1.8; padding-left: 20px;'>
                                <li style='margin-bottom: 10px;'><strong>Complete your profile</strong> - Add your personal details and verify your account</li>
                                <li style='margin-bottom: 10px;'><strong>Secure your account</strong> - Enable two-factor authentication for enhanced security</li>
                                <li style='margin-bottom: 10px;'><strong>Add funds</strong> - Deposit cryptocurrency to start trading</li>
                                <li style='margin-bottom: 10px;'><strong>Explore features</strong> - Browse our trading plans and investment options</li>
                            </ol>
                        </div>
                        
                        <p style='color: #666; margin: 25px 0 15px 0; font-size: 14px;'>
                            <a href='https://" . DOMAIN . "/p/dashboard/' style='display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #622faa 0%, #8c3fca 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600;'>Go to Dashboard</a>
                        </p>
                        
                        <hr style='border: none; border-top: 1px solid #ddd; margin: 30px 0;'>
                        
                        <div style='background: linear-gradient(135deg, rgba(0, 201, 133, 0.1) 0%, rgba(0, 201, 133, 0.05) 100%); padding: 15px; border-radius: 8px; border-left: 3px solid #00c985; text-align: left; margin-bottom: 20px;'>
                            <p style='color: #666; margin: 0; font-size: 12px;'><strong>Security Tip:</strong> Never share your account credentials with anyone. Our support team will never ask for your password.</p>
                        </div>
                        
                        <div style='text-align: center;'>
                            <p style='color: #999; font-size: 11px; margin: 15px 0 0 0;'>Questions? Visit our <a href='https://" . $_SERVER['HTTP_HOST'] . "' style='color: #622faa; text-decoration: none;'>Help Center</a></p>
                            <p style='color: #999; font-size: 10px; margin: 10px 0 0 0;'>&copy; SafeWallet, " . date('Y') . ". All rights reserved.</p>
                        </div>
                    </div>
                </div>
            ";
            
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type: text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From:'.NAME.' <'.EMAIL.'>' . "\r\n";
            
            // mail($email, $subject, $welcome_message, $headers);
            
            $success = "Account created successfully! Redirecting to login...";
            header("refresh:2;url=login.php");
            mysqli_stmt_close($stmt);
        } else {
            $errors[] = "Registration failed. Please try again.";
            mysqli_stmt_close($stmt);
        }
        } else {
            $errors[] = "Error preparing statement. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Dashboard</title>
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
            padding: 20px;
        }

        body.light-mode {
            background: var(--light-bg);
            color: var(--text-dark);
        }

        .auth-container {
            width: 100%;
            max-width: 500px;
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
        }

        body.light-mode .auth-header h1 {
            color: var(--text-dark);
        }

        .auth-header p {
            color: #aaa;
            font-size: 14px;
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
            color: #aaa;
        }

        .strength-bar {
            width: 100%;
            height: 4px;
            background: var(--border-color);
            border-radius: 2px;
            margin-top: 5px;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0;
            background: #ff4757;
            transition: all 0.3s ease;
        }

        .terms-checkbox {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            font-size: 13px;
            color: #aaa;
        }

        body.light-mode .terms-checkbox {
            color: #666;
        }

        .terms-checkbox input {
            margin-right: 8px;
            margin-top: 3px;
            cursor: pointer;
            width: auto;
            background: none;
            border: none;
            padding: 0;
        }

        .terms-checkbox a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .terms-checkbox a:hover {
            text-decoration: underline;
        }

        .btn-register {
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

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(98, 47, 170, 0.3);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .error-message,
        .error-list {
            background: rgba(231, 76, 60, 0.1);
            border: 1px solid #e74c3c;
            color: #ff6b6b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .error-list {
            list-style: none;
        }

        .error-list li {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .error-list li::before {
            content: '✕ ';
            margin-right: 8px;
            font-weight: bold;
        }

        .success-message {
            background: rgba(0, 201, 133, 0.1);
            border: 1px solid #00c985;
            color: #00c985;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
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
                <h1>Create Account</h1>
                <p>Join us and start your journey</p>
            </div>

            <?php if ($success): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <ul class="error-list">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <form method="POST" action="" id="registerForm">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Choose a username" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="you@example.com" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter a strong password" required>
                    <div class="password-strength">
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthFill"></div>
                        </div>
                        <span id="strengthText">Password strength: Weak</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                </div>

                <label class="terms-checkbox">
                    <input type="checkbox" name="terms" required>
                    I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                </label>

                <button type="submit" class="btn-register">Create Account</button>
            </form>

            <div class="auth-footer">
                <p>Already have an account? <a href="login.php">Sign in here</a></p>
            </div>
        </div>
    </div>

    <script>
        const themeToggle = document.getElementById('themeToggle');
        const body = document.body;
        const passwordInput = document.getElementById('password');
        const strengthFill = document.getElementById('strengthFill');
        const strengthText = document.getElementById('strengthText');

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

        // Password strength indicator
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            let strengthLabel = 'Weak';
            let color = '#ff4757';

            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;

            if (strength === 1) {
                strengthLabel = 'Weak';
                color = '#ff4757';
            } else if (strength === 2) {
                strengthLabel = 'Fair';
                color = '#ffa502';
            } else if (strength === 3) {
                strengthLabel = 'Good';
                color = '#00c985';
            } else if (strength === 4) {
                strengthLabel = 'Strong';
                color = '#00c985';
            }

            strengthFill.style.width = (strength * 25) + '%';
            strengthFill.style.background = color;
            strengthText.textContent = 'Password strength: ' + strengthLabel;
        });
    </script>
</body>
</html>
