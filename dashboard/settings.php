<?php $pageTitle = 'Settings'; include 'includes/head.php'; ?>
<body class="light-mode dashboard-body">
    <!-- Include Components -->
    <?php include 'includes/sidebar.php'; ?>
    <?php include 'includes/header.php'; ?>

    <!-- Main Content -->
    <main style="padding-bottom: 6rem;">
        <!-- Settings Card Section -->
        <section class="hom mb-5" style="margin-top: 6rem; margin-bottom: 8rem; width: 100%; max-width: 700px; margin-left: auto; margin-right: auto; padding: 0 20px;">
            <div class="card settings-card" style="padding: 40px 30px;">
                <div class="wallet-inf" style="margin-bottom: 2.5rem;">
                    <div>
                        <h2 class="settings-title">Account Settings</h2>
                        <p class="settings-subtitle">Manage your profile and security preferences</p>
                    </div>
                </div>

                <!-- Profile Settings -->
                <div class="settings-section">
                    <h5 class="settings-section-title">Profile</h5>
                    <div class="settings-card-item">
                        <a href="update_profile.php" class="settings-link">
                            <i class="fas fa-user-edit"></i> 
                            <span>Edit Profile</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="settings-section">
                    <h5 class="settings-section-title">Security</h5>
                    <div class="settings-card-item">
                        <a href="update_password.php" class="settings-link">
                            <i class="fas fa-key"></i> 
                            <span>Change Password</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                    <!-- <div class="settings-card-item toggle-item">
                        <div class="toggle-content">
                            <p class="toggle-title"><i class="fas fa-shield-alt"></i>2-Step Verification</p>
                            <small class="toggle-desc">Enhanced account protection</small>
                        </div>
                        <label class="switch">
                            <input type="checkbox" id="twoFactorToggle">
                            <span class="slider"></span>
                        </label>
                    </div> -->
                </div>

                <!-- Actions -->
                
            </div>
        </section>
    </main>

    <style>
    </style>

    <!-- Footer Navigation -->
    <?php include 'includes/footer.php'; ?>

    <!-- External Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Merged Dashboard Scripts -->
    <script src="js/script.js"></script>
</body>
</html>
