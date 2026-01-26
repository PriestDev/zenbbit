<?php 
session_start();
require('../details.php');
require('../database/db_config.php');
require('code.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo NAME ?? 'Admin'; ?> - Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            width: 100%;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #622faa 0%, #8b5fbf 100%);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.4s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: linear-gradient(135deg, #622faa 0%, #8b5fbf 100%);
            padding: 40px 20px;
            text-align: center;
            color: white;
        }

        .logo-section {
            margin-bottom: 20px;
        }

        .logo-section img {
            max-width: 100px;
            height: auto;
            border-radius: 8px;
            background: rgba(255,255,255,0.1);
            padding: 10px;
        }

        .placeholder-logo {
            width: 100px;
            height: 100px;
            background: rgba(255,255,255,0.2);
            border-radius: 8px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
        }

        .app-name {
            font-size: 16px;
            font-weight: 600;
            margin-top: 10px;
            letter-spacing: 0.5px;
        }

        .login-title {
            font-size: 24px;
            font-weight: 700;
            margin-top: 15px;
            margin-bottom: 0;
        }

        .login-body {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f9fafb;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: #622faa;
            background: white;
            box-shadow: 0 0 0 3px rgba(98, 47, 170, 0.1);
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #622faa 0%, #4a2180 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(98, 47, 170, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert {
            margin-bottom: 20px;
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Header Section -->
            <div class="login-header">
                <div class="logo-section">
                    <?php 
                        if (!empty($LOGO)) {
                            echo '<img src="../uploads/' . htmlspecialchars($LOGO) . '" alt="Logo">';
                        } else {
                            echo '<div class="placeholder-logo">🔐</div>';
                        }
                    ?>
                </div>
                <p class="app-name"><?php echo htmlspecialchars($NAME ?? 'Admin Panel'); ?></p>
                <h1 class="login-title">Admin Login</h1>
            </div>

            <!-- Login Form -->
            <div class="login-body">
                <?php 
                    if (isset($_SESSION['success'])) {
                        echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success']) . '</div>';
                        unset($_SESSION['success']);
                    }
                    if (isset($_SESSION['status'])) {
                        echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['status']) . '</div>';
                        unset($_SESSION['status']);
                    }
                ?>

                <form method="POST" action="code.php" style="display: block;">
                    <!-- CSRF Token for security -->
                    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                    
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input 
                            type="text" 
                            id="username"
                            name="username" 
                            class="form-control" 
                            placeholder="Enter your username"
                            required
                            autocomplete="off"
                            autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input 
                            type="password" 
                            id="password"
                            name="password" 
                            class="form-control" 
                            placeholder="Enter your password"
                            required
                            autocomplete="off">
                    </div>

                    <button type="submit" name="login_btn" class="btn-login">
                        Sign In
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>