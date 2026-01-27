<?php
/**
 * LOGIN AUTHENTICATION SYSTEM
 * 
 * Password Hashing Method: bcrypt (PASSWORD_BCRYPT)
 * - Industry standard for password hashing
 * - Provides built-in salt generation and cost factor
 * - Immune to rainbow table attacks
 * - Compatible with all cPanel hosting providers
 * - PHP version required: 5.5+ (available in cPanel default installations)
 * 
 * Verification Flow:
 * 1. User enters email and password
 * 2. Email is used to fetch hashed password from database
 * 3. password_verify() performs constant-time comparison
 * 4. Bcrypt algorithm internally handles salt and comparison
 * 
 * Backward Compatibility:
 * - Also supports legacy MD5/SHA1/plaintext passwords
 * - Automatically falls back to older methods if bcrypt fails
 * - Allows gradual migration of legacy accounts
 */

include '../database/db_config.php';
session_start();
require '../details.php';
require '../admin.php';

// Function to decrypt password (if encrypted)
function decrypt_password($encrypted_password) {
    // If password is stored as plain text, just return it
    if (strlen($encrypted_password) < 50) {
        return $encrypted_password;
    }
    
    // Try to decrypt if it looks like a hash
    // For bcrypt hashes or direct comparison
    return $encrypted_password;
}

// Function to verify password - tries multiple methods
// PRIMARY METHOD: password_verify() with bcrypt (recommended, cPanel compatible)
// FALLBACK METHODS: Support for legacy password storage formats
function verify_user_password($input_password, $db_password) {
    // Method 1: bcrypt comparison (PRIORITY - for new registrations)
    // password_verify() is the PHP standard for bcrypt verification
    // Uses constant-time comparison to prevent timing attacks
    // Works on all cPanel servers with PHP 5.5+
    if (password_verify($input_password, $db_password)) {
        return true;
    }
    
    // Method 2: Plain text comparison (for legacy accounts)
    if ($input_password === $db_password) {
        return true;
    }
    
    // Method 3: md5 comparison (if stored as md5)
    if (md5($input_password) === $db_password) {
        return true;
    }
    
    // Method 4: sha1 comparison (if stored as sha1)
    if (sha1($input_password) === $db_password) {
        return true;
    }
    
    return false;
}

// Function to get user's IP address
function get_user_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// Function to get location from IP address
function get_location_from_ip($ip_address) {
    try {
        $response = @file_get_contents("https://ipapi.co/$ip_address/json/");
        if ($response !== false) {
            $data = json_decode($response, true);
            return isset($data['country_name']) ? $data['country_name'] : 'Unknown';
        }
    } catch (Exception $e) {
        // Silently fail and return Unknown
    }
    return 'Unknown';
}

// Function to send login notification email
function send_login_email($email, $username, $ip_address, $is_new_ip = false) {
    $user_agent = htmlspecialchars($_SERVER['HTTP_USER_AGENT']);
    $location = get_location_from_ip($ip_address);
    
    if ($is_new_ip) {
        $title = "New Login from Different Location";
        $alert = "<p style='color: #ff6b6b; font-weight: 600; margin: 15px 0;'>⚠️ We detected a login from a new location!</p>";
        $action = "<p style='color: #666; margin: 15px 0;'><a href='https://" . $_SERVER['HTTP_HOST'] . "/p/dashboard/security.php' style='color: #622faa; text-decoration: none; font-weight: 600;'>Review account security</a></p>";
    } else {
        $title = "Login Successful";
        $alert = "<p style='color: #00c985; font-weight: 600; margin: 15px 0;'>✓ Login successful</p>";
        $action = "";
    }
    
    $subject = "Login Notification - " . NAME;
    $message = "
        <div style='background-color: rgb(175, 175, 175); padding: 30px;'>
            <div style='text-align: center; max-width: 500px; margin: auto; background-color: rgb(255, 255, 255); color: rgb(0, 0, 0); padding: 30px; border-radius: 12px;'>
                <h2 style='color: #622faa; margin-bottom: 15px;'>$title</h2>
                
                $alert
                
                <div style='background: linear-gradient(135deg, rgba(98, 47, 170, 0.1) 0%, rgba(98, 47, 170, 0.05) 100%); padding: 20px; border-radius: 10px; text-align: left; margin: 20px 0;'>
                    <p style='color: #666; margin: 8px 0; font-size: 14px;'><strong>Account:</strong> " . htmlspecialchars($username) . "</p>
                    <p style='color: #666; margin: 8px 0; font-size: 14px;'><strong>IP Address:</strong> " . htmlspecialchars($ip_address) . "</p>
                    <p style='color: #666; margin: 8px 0; font-size: 14px;'><strong>Location:</strong> $location</p>
                    <p style='color: #666; margin: 8px 0; font-size: 14px;'><strong>Device:</strong> " . htmlspecialchars(substr($user_agent, 0, 60)) . "...</p>
                    <p style='color: #666; margin: 8px 0; font-size: 14px;'><strong>Time:</strong> " . date('M d, Y H:i:s') . "</p>
                </div>
                
                $action
                
                <div style='background: #f9f9f9; padding: 15px; border-radius: 8px; border-left: 3px solid #ffa500; margin: 20px 0; text-align: left;'>
                    <p style='color: #666; margin: 0; font-size: 12px;'>
                        <strong>Security Tip:</strong> If this wasn't you, change your password immediately and contact our support team.
                    </p>
                </div>
                
                <hr style='border: none; border-top: 1px solid #ddd; margin: 25px 0;'>
                <p style='color: #888; font-size: 10px;'>&copy; " . NAME . ", " . date('Y') . "</p>
            </div>
        </div>
    ";
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: ' . EMAIL . "\r\n";
    
    // Uncomment line below when uploading to hosting with SMTP configured
    mail($email, $subject, $message, $headers);
}

// Get error from session and clear it
$error = '';
if (isset($_SESSION['login_error'])) {
    $error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $current_ip = get_user_ip();

    $query = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Validate password with database password
        if (verify_user_password($password, $user['password'])) {
            // Check if IP is different from previous IP (try both column names)
            $previous_ip = isset($user['ip']) ? $user['ip'] : (isset($user['ip_address']) ? $user['ip_address'] : null);
            $is_new_ip = ($previous_ip && $previous_ip !== $current_ip);
            
            // Send login email notification if new IP
            send_login_email($email, $user['acct_id'], $current_ip, $is_new_ip);
            
            // Update user IP address (try both column names)
            if (array_key_exists('ip', $user)) {
                $update_query = "UPDATE user SET ip = '$current_ip', `update` = NOW() WHERE id = " . $user['id'];
            } else {
                $update_query = "UPDATE user SET ip_address = '$current_ip', `update` = NOW() WHERE id = " . $user['id'];
            }
            mysqli_query($conn, $update_query);
            
            // Set session variables - USER-specific sessions
            $_SESSION['user_id'] = $user['acct_id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_account_id'] = $user['acct_id'];
            $_SESSION['session_type'] = 'user'; // Track session type
            $_SESSION['last_activity'] = time();
            
            header('Location: ./');
            exit();
        } else {
            $_SESSION['login_error'] = "Invalid email or password";
            header('Location: login.php');
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Invalid email or password";
        header('Location: login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dashboard</title>
    <link rel="shortcut icon" href="image/fav.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="light-mode">
    <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
        <i class="fas fa-moon"></i>
    </button>

    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-header">
                <h1>Welcome Back</h1>
                <p>Sign in to your account to continue</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="error-message" id="errorMessage">
                    <span><i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?></span>
                    <span class="error-close" onclick="closeError()">&times;</span>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="you@example.com" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div style="position: relative; display: flex; align-items: center;">
                        <input type="password" id="password" name="password" placeholder="Enter your password" required style="flex: 1;">
                        <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('password')" title="Toggle password visibility" style="position: absolute; right: 12px; background: none; border: none; color: #622faa; cursor: pointer; font-size: 18px; padding: 8px;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="remember-forgot">
                    <label>
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    <a href="forgot-password.php">Forgot password?</a>
                </div>

                <button type="submit" class="btn-login">Sign In</button>
            </form>

            <div class="auth-footer">
                <p>Don't have an account? <a href="register.php">Create one now</a></p>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
    <script>
        // Toggle password visibility
        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            const button = event.target.closest('button');
            const icon = button.querySelector('i');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
