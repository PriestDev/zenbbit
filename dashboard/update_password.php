<?php 
include 'includes/dashboard_init.php';
$pageTitle = 'Change Password'; 
include 'includes/head.php'; 

// Get user data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM user WHERE acct_id = '$user_id'";
$run = mysqli_query($conn, $sql);
$user_data = mysqli_fetch_assoc($run);

$message = '';
$messageType = '';

// Handle password change
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate inputs
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $message = "All fields are required.";
        $messageType = 'error';
    } elseif (strlen($new_password) < 8) {
        $message = "New password must be at least 8 characters long.";
        $messageType = 'error';
    } elseif ($new_password !== $confirm_password) {
        $message = "New passwords do not match.";
        $messageType = 'error';
    } else {
        // Verify current password
        if (password_verify($current_password, $user_data['password'])) {
            // Hash new password
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            
            // Update password
            $update_sql = "UPDATE user SET password = '$hashed_password', `update` = NOW() WHERE acct_id = '$user_id'";
            
            if (mysqli_query($conn, $update_sql)) {
                $message = "Password changed successfully! You will be redirected to login in 3 seconds.";
                $messageType = 'success';
                header("refresh:3;url=logout.php");
            } else {
                $message = "Error updating password. Please try again.";
                $messageType = 'error';
            }
        } else {
            $message = "Current password is incorrect.";
            $messageType = 'error';
        }
    }
}
?>
<body class="light-mode dashboard-body">
    <!-- Include Components -->
    <?php include 'includes/sidebar.php'; ?>
    <?php include 'includes/header.php'; ?>

    <!-- Main Content -->
    <main style="padding-bottom: 6rem;">
        <section class="hom mb-5" style="margin-top: 6rem; margin-bottom: 8rem; width: 100%; max-width: 700px; margin-left: auto; margin-right: auto; padding: 0 20px;">
            <div class="card settings-card" style="padding: 40px 30px;">
                <!-- Header -->
                <div class="wallet-inf" style="margin-bottom: 2.5rem;">
                    <div>
                        <h2 class="settings-title">Change Password</h2>
                        <p class="settings-subtitle">Update your password to keep your account secure</p>
                    </div>
                </div>

                <!-- Info Box -->
                <div style="background: linear-gradient(135deg, rgba(98, 47, 170, 0.1) 0%, rgba(98, 47, 170, 0.05) 100%); border-left: 3px solid #622faa; padding: 15px; border-radius: 8px; margin-bottom: 25px; font-size: 13px; color: #666; line-height: 1.6;">
                    <i class="fas fa-lock"></i> For your security, use a strong password with at least 8 characters including numbers and symbols.
                </div>

                <!-- Message -->
                <?php if (!empty($message)): ?>
                    <div style="background: <?php echo $messageType === 'success' ? 'rgba(0, 201, 133, 0.1)' : 'rgba(231, 76, 60, 0.1)'; ?>; border: 1px solid <?php echo $messageType === 'success' ? '#00c985' : '#e74c3c'; ?>; color: <?php echo $messageType === 'success' ? '#00c985' : '#ff6b6b'; ?>; padding: 12px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-<?php echo $messageType === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                        <span><?php echo htmlspecialchars($message); ?></span>
                    </div>
                <?php endif; ?>

                <!-- Form -->
                <form method="POST" action="">
                    <div class="settings-section">
                        <h5 class="settings-section-title">Password Details</h5>
                        
                        <!-- Current Password -->
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input 
                                type="password" 
                                id="current_password" 
                                name="current_password" 
                                placeholder="Enter your current password"
                                required
                            >
                        </div>

                        <!-- New Password -->
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input 
                                type="password" 
                                id="new_password" 
                                name="new_password" 
                                placeholder="Enter new password"
                                minlength="8"
                                required
                                oninput="checkPasswordStrength()"
                            >
                            <div style="margin-top: 8px;">
                                <div style="height: 4px; background: #ddd; border-radius: 2px; overflow: hidden;">
                                    <div id="strengthIndicator" style="height: 100%; width: 0%; background: #ff6b6b; transition: all 0.3s ease;"></div>
                                </div>
                                <div style="margin-top: 6px; display: flex; justify-content: space-between;">
                                    <span style="font-size: 11px; color: #999;">Strength:</span>
                                    <span id="strengthText" style="font-size: 11px; color: #ff6b6b; font-weight: 600;">Weak</span>
                                </div>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <input 
                                type="password" 
                                id="confirm_password" 
                                name="confirm_password" 
                                placeholder="Confirm new password"
                                minlength="8"
                                required
                                oninput="checkPasswordMatch()"
                            >
                            <div id="passwordMatch" style="margin-top: 8px; font-size: 12px; display: none;">
                                <span id="matchText"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Password Requirements -->
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 2rem;">
                        <p style="margin: 0 0 10px 0; font-size: 12px; font-weight: 600; color: #333;">Password Requirements:</p>
                        <ul style="margin: 0; padding-left: 20px; font-size: 12px; color: #666;">
                            <li>At least 8 characters long</li>
                            <li>Contains uppercase letters (A-Z)</li>
                            <li>Contains lowercase letters (a-z)</li>
                            <li>Contains numbers (0-9)</li>
                            <li>Contains special characters (!@#$%^&*)</li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 12px; margin-top: 2rem;">
                        <button type="submit" class="btn-primary" style="flex: 1;">
                            <i class="fas fa-key"></i> Change Password
                        </button>
                        <a href="settings.php" style="flex: 1; padding: 12px; background: transparent; color: #622faa; border: 2px solid #622faa; border-radius: 6px; text-align: center; text-decoration: none; font-weight: 600; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 8px;" onmouseover="this.style.background='rgba(98, 47, 170, 0.05)'" onmouseout="this.style.background='transparent'">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <!-- Footer Navigation -->
    <?php include 'includes/footer.php'; ?>

    <!-- External Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>

    <script>
        function checkPasswordStrength() {
            const password = document.getElementById('new_password').value;
            const indicator = document.getElementById('strengthIndicator');
            const text = document.getElementById('strengthText');
            
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (password.length >= 12) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[!@#$%^&*]/.test(password)) strength++;
            
            if (strength <= 2) {
                indicator.style.width = '33%';
                indicator.style.background = '#ff6b6b';
                text.textContent = 'Weak';
                text.style.color = '#ff6b6b';
            } else if (strength <= 3) {
                indicator.style.width = '66%';
                indicator.style.background = '#ffa500';
                text.textContent = 'Medium';
                text.style.color = '#ffa500';
            } else {
                indicator.style.width = '100%';
                indicator.style.background = '#00c985';
                text.textContent = 'Strong';
                text.style.color = '#00c985';
            }
        }

        function checkPasswordMatch() {
            const password = document.getElementById('new_password').value;
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
