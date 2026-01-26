<?php 
include 'includes/dashboard_init.php';
$pageTitle = 'Edit Profile'; 
include 'includes/head.php'; 

// Get user data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM user WHERE acct_id = '$user_id'";
$run = mysqli_query($conn, $sql);
$user_data = mysqli_fetch_assoc($run);

$message = '';
$messageType = '';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = mysqli_real_escape_string($conn, $_POST['first_name']);
    $lname = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $zip = mysqli_real_escape_string($conn, $_POST['zip']);
    
    // Validate inputs
    if (empty($fname) || empty($lname) || empty($email)) {
        $message = "First name, last name, and email are required.";
        $messageType = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email address.";
        $messageType = 'error';
    } else {
        // Check if email is already used by another user
        $email_check = "SELECT id FROM user WHERE email = '$email' AND id != " . $user_data['id'];
        $result = mysqli_query($conn, $email_check);
        
        if (mysqli_num_rows($result) > 0) {
            $message = "This email is already in use by another account.";
            $messageType = 'error';
        } else {
            // Update user profile
            $update_sql = "UPDATE user SET 
                first_name = '$fname',
                last_name = '$lname',
                email = '$email',
                phone = '$phone',
                country = '$country',
                state = '$state',
                city = '$city',
                address = '$address',
                zip = '$zip',
                `update` = NOW()
                WHERE acct_id = '$user_id'";
            
            if (mysqli_query($conn, $update_sql)) {
                $message = "Profile updated successfully!";
                $messageType = 'success';
                // Refresh user data
                $run = mysqli_query($conn, $sql);
                $user_data = mysqli_fetch_assoc($run);
            } else {
                $message = "Error updating profile. Please try again.";
                $messageType = 'error';
            }
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
                        <h2 class="settings-title">Edit Profile</h2>
                        <p class="settings-subtitle">Update your profile information</p>
                    </div>
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
                    <!-- Name Section -->
                    <div class="settings-section">
                        <h5 class="settings-section-title">Personal Information</h5>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input 
                                    type="text" 
                                    id="first_name" 
                                    name="first_name" 
                                    value="<?php echo htmlspecialchars($user_data['first_name']); ?>"
                                    required
                                >
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input 
                                    type="text" 
                                    id="last_name" 
                                    name="last_name" 
                                    value="<?php echo htmlspecialchars($user_data['last_name']); ?>"
                                    required
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="<?php echo htmlspecialchars($user_data['email']); ?>"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                value="<?php echo htmlspecialchars($user_data['phone'] ?? ''); ?>"
                                placeholder="+1 (555) 123-4567"
                            >
                        </div>
                    </div>

                    <!-- Address Section -->
                    <div class="settings-section">
                        <h5 class="settings-section-title">Address</h5>
                        
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input 
                                type="text" 
                                id="country" 
                                name="country" 
                                value="<?php echo htmlspecialchars($user_data['country'] ?? ''); ?>"
                                placeholder="United States"
                            >
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <div class="form-group">
                                <label for="state">State/Province</label>
                                <input 
                                    type="text" 
                                    id="state" 
                                    name="state" 
                                    value="<?php echo htmlspecialchars($user_data['state'] ?? ''); ?>"
                                    placeholder="California"
                                >
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input 
                                    type="text" 
                                    id="city" 
                                    name="city" 
                                    value="<?php echo htmlspecialchars($user_data['city'] ?? ''); ?>"
                                    placeholder="San Francisco"
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">Street Address</label>
                            <input 
                                type="text" 
                                id="address" 
                                name="address" 
                                value="<?php echo htmlspecialchars($user_data['address'] ?? ''); ?>"
                                placeholder="123 Main Street"
                            >
                        </div>

                        <div class="form-group">
                            <label for="zip">ZIP/Postal Code</label>
                            <input 
                                type="text" 
                                id="zip" 
                                name="zip" 
                                value="<?php echo htmlspecialchars($user_data['zip'] ?? ''); ?>"
                                placeholder="94105"
                            >
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 12px; margin-top: 2rem;">
                        <button type="submit" class="btn-primary" style="flex: 1;">
                            <i class="fas fa-save"></i> Save Changes
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
</body>
</html>
