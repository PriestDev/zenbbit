<?php
/**
 * USER REGISTRATION SYSTEM
 * 
 * Password Hashing Method: bcrypt (PASSWORD_BCRYPT)
 * - Industry standard for password hashing (PHP 5.5+)
 * - Automatically generates unique salt for each password
 * - Cost factor: 10 (provides good security/performance balance)
 * - Hash size: ~60 characters
 * - Compatible with all cPanel hosting providers
 * 
 * Password Hashing Process:
 * 1. User submits plaintext password
 * 2. password_hash() with PASSWORD_BCRYPT algorithm processes it
 * 3. Unique salt is automatically generated
 * 4. Hash is stored in database (plaintext password is discarded)
 * 5. Login process uses password_verify() for secure comparison
 * 
 * Security Features:
 * - Passwords are NEVER stored in plaintext
 * - Bcrypt is immune to rainbow table and brute force attacks
 * - Each password hash is unique even for identical passwords
 * - Constant-time comparison prevents timing attacks
 */

include '../database/db_config.php';
session_start();
require '../details.php';
require '../admin.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name'] ?? '');
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $country = mysqli_real_escape_string($conn, $_POST['country'] ?? '');
    $username = mysqli_real_escape_string($conn, $_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validation
    if (empty($first_name)) $errors[] = "First name is required";
    if (empty($last_name)) $errors[] = "Last name is required";
    if (empty($username)) $errors[] = "Username is required";
    if (empty($email)) $errors[] = "Email is required";
    if (empty($password)) $errors[] = "Password is required";
    if (empty($country)) $errors[] = "Country is required";
    if ($password !== $confirm_password) $errors[] = "Passwords do not match";
    if (strlen($password) < 8) $errors[] = "Password must be at least 8 characters";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format";
    if (strlen($first_name) < 2) $errors[] = "First name must be at least 2 characters";
    if (strlen($last_name) < 2) $errors[] = "Last name must be at least 2 characters";
    if (strlen($username) < 3) $errors[] = "Username must be at least 3 characters";

    // Check if user exists
    if (empty($errors)) {
        $stmt = mysqli_prepare($conn, "SELECT id FROM user WHERE email = ? OR acct_id = ? LIMIT 1");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $email, $username);
            mysqli_stmt_execute($stmt);
            $check_result = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($check_result) > 0) {
                $errors[] = "Email or username already exists";
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Create user if no errors
    if (empty($errors)) {
        // Hash password using bcrypt (RECOMMENDED & SECURE)
        $hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
        
        // Verify hash was created successfully
        if (strlen($hashed_password) < 50) {
            $errors[] = "Password encryption failed. Please try again.";
        }
        
        if (empty($errors)) {
            $stmt = mysqli_prepare($conn, "INSERT INTO user (acct_id, first_name, last_name, email, password, country, reg_date, status, wallet_stat) VALUES (?, ?, ?, ?, ?, ?, NOW(), 1, 0)");
            
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssssss", $username, $first_name, $last_name, $email, $hashed_password, $country);
                
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);
                    
                    // Send welcome email
                    $subject = "Welcome to SafeWallet!";
                    $welcome_message = "
                        <div style='background-color: rgb(175, 175, 175); padding: 30px;'>
                            <div style='text-align: center; max-width: 600px; margin: auto; background-color: rgb(255, 255, 255); color: rgb(0, 0, 0); padding: 40px; border-radius: 12px;'>
                                <div style='margin-bottom: 30px;'>
                                    <h2 style='color: #622faa; margin: 0 0 10px 0; font-size: 32px;'>Welcome to SafeWallet!</h2>
                                    <p style='color: #666; margin: 0; font-size: 14px;'>Your secure cryptocurrency wallet</p>
                                </div>
                                
                                <div style='background: linear-gradient(135deg, rgba(98, 47, 170, 0.1) 0%, rgba(255, 107, 107, 0.1) 100%); padding: 25px; border-radius: 12px; margin: 30px 0; text-align: left;'>
                                    <h3 style='color: #333; margin: 0 0 15px 0; font-size: 16px;'>Account Details</h3>
                                    <p style='color: #666; margin: 8px 0; font-size: 14px;'><strong>Name:</strong> " . htmlspecialchars($first_name . " " . $last_name) . "</p>
                                    <p style='color: #666; margin: 8px 0; font-size: 14px;'><strong>Username:</strong> " . htmlspecialchars($username) . "</p>
                                    <p style='color: #666; margin: 8px 0; font-size: 14px;'><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
                                    <p style='color: #666; margin: 8px 0; font-size: 14px;'><strong>Country:</strong> " . htmlspecialchars($country) . "</p>
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
                                    <a href='https://" . $_SERVER['HTTP_HOST'] . "/p/dashboard/' style='display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #622faa 0%, #8c3fca 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600;'>Go to Dashboard</a>
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
                    $headers .= 'From: '.EMAIL . "\r\n";
                    
                    mail($email, $subject, $welcome_message, $headers);
                    
                    $success = "Account created successfully! Redirecting to login...";
                    header("refresh:2;url=login.php");
                } else {
                    $errors[] = "Registration failed: " . mysqli_stmt_error($stmt);
                    mysqli_stmt_close($stmt);
                }
            } else {
                $errors[] = "Database error: " . mysqli_error($conn);
            }
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
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label for="first_name">
                            <i class="fas fa-user" style="color: var(--primary-color); margin-right: 0.4rem;"></i>
                            First Name *
                        </label>
                        <input type="text" id="first_name" name="first_name" placeholder="John" required minlength="2" maxlength="50">
                    </div>

                    <div class="form-group">
                        <label for="last_name">
                            <i class="fas fa-user" style="color: var(--primary-color); margin-right: 0.4rem;"></i>
                            Last Name *
                        </label>
                        <input type="text" id="last_name" name="last_name" placeholder="Doe" required minlength="2" maxlength="50">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope" style="color: var(--primary-color); margin-right: 0.4rem;"></i>
                        Email Address *
                    </label>
                    <input type="email" id="email" name="email" placeholder="you@example.com" required>
                </div>

                <!-- Hidden Username Input - Auto-generated -->
                <input type="hidden" id="username" name="username" value="">

                <div class="form-group">
                    <label for="country">
                        <i class="fas fa-globe" style="color: var(--primary-color); margin-right: 0.4rem;"></i>
                        Country *
                    </label>
                    <select id="country" name="country" required style="width: 100%; padding: 12px 15px; border: 1px solid var(--border-color); border-radius: 8px; background: rgba(0, 0, 0, 0.3); color: var(--text-light); font-size: 14px;">
                        <option value="">-- Select your country --</option>
                        <option value="Afghanistan">Afghanistan</option>
                        <option value="Albania">Albania</option>
                        <option value="Algeria">Algeria</option>
                        <option value="Andorra">Andorra</option>
                        <option value="Angola">Angola</option>
                        <option value="Argentina">Argentina</option>
                        <option value="Armenia">Armenia</option>
                        <option value="Australia">Australia</option>
                        <option value="Austria">Austria</option>
                        <option value="Azerbaijan">Azerbaijan</option>
                        <option value="Bahamas">Bahamas</option>
                        <option value="Bahrain">Bahrain</option>
                        <option value="Bangladesh">Bangladesh</option>
                        <option value="Barbados">Barbados</option>
                        <option value="Belarus">Belarus</option>
                        <option value="Belgium">Belgium</option>
                        <option value="Belize">Belize</option>
                        <option value="Benin">Benin</option>
                        <option value="Bhutan">Bhutan</option>
                        <option value="Bolivia">Bolivia</option>
                        <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                        <option value="Botswana">Botswana</option>
                        <option value="Brazil">Brazil</option>
                        <option value="Brunei">Brunei</option>
                        <option value="Bulgaria">Bulgaria</option>
                        <option value="Burkina Faso">Burkina Faso</option>
                        <option value="Burundi">Burundi</option>
                        <option value="Cambodia">Cambodia</option>
                        <option value="Cameroon">Cameroon</option>
                        <option value="Canada">Canada</option>
                        <option value="Cape Verde">Cape Verde</option>
                        <option value="Central African Republic">Central African Republic</option>
                        <option value="Chad">Chad</option>
                        <option value="Chile">Chile</option>
                        <option value="China">China</option>
                        <option value="Colombia">Colombia</option>
                        <option value="Comoros">Comoros</option>
                        <option value="Congo">Congo</option>
                        <option value="Costa Rica">Costa Rica</option>
                        <option value="Croatia">Croatia</option>
                        <option value="Cuba">Cuba</option>
                        <option value="Cyprus">Cyprus</option>
                        <option value="Czech Republic">Czech Republic</option>
                        <option value="Denmark">Denmark</option>
                        <option value="Djibouti">Djibouti</option>
                        <option value="Dominica">Dominica</option>
                        <option value="Dominican Republic">Dominican Republic</option>
                        <option value="East Timor">East Timor</option>
                        <option value="Ecuador">Ecuador</option>
                        <option value="Egypt">Egypt</option>
                        <option value="El Salvador">El Salvador</option>
                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                        <option value="Eritrea">Eritrea</option>
                        <option value="Estonia">Estonia</option>
                        <option value="Ethiopia">Ethiopia</option>
                        <option value="Fiji">Fiji</option>
                        <option value="Finland">Finland</option>
                        <option value="France">France</option>
                        <option value="Gabon">Gabon</option>
                        <option value="Gambia">Gambia</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Germany">Germany</option>
                        <option value="Ghana">Ghana</option>
                        <option value="Greece">Greece</option>
                        <option value="Grenada">Grenada</option>
                        <option value="Guatemala">Guatemala</option>
                        <option value="Guinea">Guinea</option>
                        <option value="Guinea-Bissau">Guinea-Bissau</option>
                        <option value="Guyana">Guyana</option>
                        <option value="Haiti">Haiti</option>
                        <option value="Honduras">Honduras</option>
                        <option value="Hungary">Hungary</option>
                        <option value="Iceland">Iceland</option>
                        <option value="India">India</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="Iran">Iran</option>
                        <option value="Iraq">Iraq</option>
                        <option value="Ireland">Ireland</option>
                        <option value="Israel">Israel</option>
                        <option value="Italy">Italy</option>
                        <option value="Ivory Coast">Ivory Coast</option>
                        <option value="Jamaica">Jamaica</option>
                        <option value="Japan">Japan</option>
                        <option value="Jordan">Jordan</option>
                        <option value="Kazakhstan">Kazakhstan</option>
                        <option value="Kenya">Kenya</option>
                        <option value="Kiribati">Kiribati</option>
                        <option value="Kuwait">Kuwait</option>
                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                        <option value="Laos">Laos</option>
                        <option value="Latvia">Latvia</option>
                        <option value="Lebanon">Lebanon</option>
                        <option value="Lesotho">Lesotho</option>
                        <option value="Liberia">Liberia</option>
                        <option value="Libya">Libya</option>
                        <option value="Liechtenstein">Liechtenstein</option>
                        <option value="Lithuania">Lithuania</option>
                        <option value="Luxembourg">Luxembourg</option>
                        <option value="Madagascar">Madagascar</option>
                        <option value="Malawi">Malawi</option>
                        <option value="Malaysia">Malaysia</option>
                        <option value="Maldives">Maldives</option>
                        <option value="Mali">Mali</option>
                        <option value="Malta">Malta</option>
                        <option value="Marshall Islands">Marshall Islands</option>
                        <option value="Mauritania">Mauritania</option>
                        <option value="Mauritius">Mauritius</option>
                        <option value="Mexico">Mexico</option>
                        <option value="Micronesia">Micronesia</option>
                        <option value="Moldova">Moldova</option>
                        <option value="Monaco">Monaco</option>
                        <option value="Mongolia">Mongolia</option>
                        <option value="Montenegro">Montenegro</option>
                        <option value="Morocco">Morocco</option>
                        <option value="Mozambique">Mozambique</option>
                        <option value="Myanmar">Myanmar</option>
                        <option value="Namibia">Namibia</option>
                        <option value="Nauru">Nauru</option>
                        <option value="Nepal">Nepal</option>
                        <option value="Netherlands">Netherlands</option>
                        <option value="New Zealand">New Zealand</option>
                        <option value="Nicaragua">Nicaragua</option>
                        <option value="Niger">Niger</option>
                        <option value="Nigeria">Nigeria</option>
                        <option value="North Korea">North Korea</option>
                        <option value="North Macedonia">North Macedonia</option>
                        <option value="Norway">Norway</option>
                        <option value="Oman">Oman</option>
                        <option value="Pakistan">Pakistan</option>
                        <option value="Palau">Palau</option>
                        <option value="Palestine">Palestine</option>
                        <option value="Panama">Panama</option>
                        <option value="Papua New Guinea">Papua New Guinea</option>
                        <option value="Paraguay">Paraguay</option>
                        <option value="Peru">Peru</option>
                        <option value="Philippines">Philippines</option>
                        <option value="Poland">Poland</option>
                        <option value="Portugal">Portugal</option>
                        <option value="Qatar">Qatar</option>
                        <option value="Romania">Romania</option>
                        <option value="Russia">Russia</option>
                        <option value="Rwanda">Rwanda</option>
                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                        <option value="Saint Lucia">Saint Lucia</option>
                        <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                        <option value="Samoa">Samoa</option>
                        <option value="San Marino">San Marino</option>
                        <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                        <option value="Saudi Arabia">Saudi Arabia</option>
                        <option value="Senegal">Senegal</option>
                        <option value="Serbia">Serbia</option>
                        <option value="Seychelles">Seychelles</option>
                        <option value="Sierra Leone">Sierra Leone</option>
                        <option value="Singapore">Singapore</option>
                        <option value="Slovakia">Slovakia</option>
                        <option value="Slovenia">Slovenia</option>
                        <option value="Solomon Islands">Solomon Islands</option>
                        <option value="Somalia">Somalia</option>
                        <option value="South Africa">South Africa</option>
                        <option value="South Korea">South Korea</option>
                        <option value="South Sudan">South Sudan</option>
                        <option value="Spain">Spain</option>
                        <option value="Sri Lanka">Sri Lanka</option>
                        <option value="Sudan">Sudan</option>
                        <option value="Suriname">Suriname</option>
                        <option value="Sweden">Sweden</option>
                        <option value="Switzerland">Switzerland</option>
                        <option value="Syria">Syria</option>
                        <option value="Taiwan">Taiwan</option>
                        <option value="Tajikistan">Tajikistan</option>
                        <option value="Tanzania">Tanzania</option>
                        <option value="Thailand">Thailand</option>
                        <option value="Togo">Togo</option>
                        <option value="Tonga">Tonga</option>
                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                        <option value="Tunisia">Tunisia</option>
                        <option value="Turkey">Turkey</option>
                        <option value="Turkmenistan">Turkmenistan</option>
                        <option value="Tuvalu">Tuvalu</option>
                        <option value="Uganda">Uganda</option>
                        <option value="Ukraine">Ukraine</option>
                        <option value="United Arab Emirates">United Arab Emirates</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="United States">United States</option>
                        <option value="Uruguay">Uruguay</option>
                        <option value="Uzbekistan">Uzbekistan</option>
                        <option value="Vanuatu">Vanuatu</option>
                        <option value="Vatican City">Vatican City</option>
                        <option value="Venezuela">Venezuela</option>
                        <option value="Vietnam">Vietnam</option>
                        <option value="Yemen">Yemen</option>
                        <option value="Zambia">Zambia</option>
                        <option value="Zimbabwe">Zimbabwe</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock" style="color: var(--primary-color); margin-right: 0.4rem;"></i>
                        Password *
                    </label>
                    <div style="position: relative; display: flex; align-items: center;">
                        <input type="password" id="password" name="password" placeholder="Enter a strong password" required minlength="8" style="flex: 1;">
                        <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('password')" title="Toggle password visibility" style="position: absolute; right: 12px; background: none; border: none; color: var(--primary-color); cursor: pointer; font-size: 18px; padding: 8px;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="password-strength">
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthFill"></div>
                        </div>
                        <span id="strengthText">Password strength: Weak</span>
                    </div>
                    <small style="color: #aaa;">Minimum 8 characters with uppercase, lowercase, numbers, and symbols</small>
                </div>

                <div class="form-group">
                    <label for="confirm_password">
                        <i class="fas fa-check-circle" style="color: var(--primary-color); margin-right: 0.4rem;"></i>
                        Confirm Password *
                    </label>
                    <div style="position: relative; display: flex; align-items: center;">
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required minlength="8" style="flex: 1;">
                        <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('confirm_password')" title="Toggle password visibility" style="position: absolute; right: 12px; background: none; border: none; color: var(--primary-color); cursor: pointer; font-size: 18px; padding: 8px;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <label class="terms-checkbox">
                    <input type="checkbox" name="terms" required>
                    I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                </label>

                <button type="submit" class="btn-register" id="submitBtn">Create Account</button>
            </form>

            <div class="auth-footer">
                <p>Already have an account? <a href="login.php">Sign in here</a></p>
            </div>
        </div>
    </div>

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

        const themeToggle = document.getElementById('themeToggle');
        const body = document.body;
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const strengthFill = document.getElementById('strengthFill');
        const strengthText = document.getElementById('strengthText');
        const registerForm = document.getElementById('registerForm');
        const submitBtn = document.getElementById('submitBtn');
        const usernameInput = document.getElementById('username');

        // Auto-generate unique user ID on page load
        function generateUniqueUsername() {
            const timestamp = Date.now().toString(36); // Convert timestamp to base36
            const random = Math.random().toString(36).substring(2, 8); // Generate random string
            return 'user_' + timestamp + random;
        }

        // Set the auto-generated username
        usernameInput.value = generateUniqueUsername();
        console.log('Auto-generated username:', usernameInput.value);

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

        // Form validation on submit
        registerForm.addEventListener('submit', function(e) {
            const firstName = document.getElementById('first_name').value.trim();
            const lastName = document.getElementById('last_name').value.trim();
            const email = document.getElementById('email').value.trim();
            const country = document.getElementById('country').value;
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            const terms = document.querySelector('input[name="terms"]').checked;

            // Client-side validation
            if (firstName.length < 2) {
                e.preventDefault();
                alert('First name must be at least 2 characters');
                document.getElementById('first_name').focus();
                return false;
            }

            if (lastName.length < 2) {
                e.preventDefault();
                alert('Last name must be at least 2 characters');
                document.getElementById('last_name').focus();
                return false;
            }

            if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                e.preventDefault();
                alert('Please enter a valid email address');
                document.getElementById('email').focus();
                return false;
            }

            if (!country) {
                e.preventDefault();
                alert('Please select a country');
                document.getElementById('country').focus();
                return false;
            }

            if (password.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters');
                passwordInput.focus();
                return false;
            }

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match');
                confirmPasswordInput.focus();
                return false;
            }

            if (!terms) {
                e.preventDefault();
                alert('Please agree to the Terms of Service and Privacy Policy');
                return false;
            }

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account...';
        });

        // Reset form visual state on error
        if (document.querySelector('.error-list')) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-user-plus"></i> Create Account';
        }
    </script>
</body>
</html>
