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

                    <!-- KYC Documents Section -->
                    <div class="settings-section">
                        <h5 class="settings-section-title">KYC Documentation</h5>
                        <p style="color: #666; font-size: 0.9rem; margin-bottom: 1.5rem;">
                            <i class="fas fa-info-circle" style="margin-right: 5px;"></i>
                            Upload your identity documents to verify your account
                        </p>

                        <div style="background: linear-gradient(135deg, rgba(98, 47, 170, 0.05) 0%, rgba(98, 47, 170, 0.02) 100%); border: 2px dashed #622faa; border-radius: 12px; padding: 30px; text-align: center; cursor: pointer; transition: all 0.3s ease; margin-bottom: 20px;" id="kycDropZone" onmouseover="this.style.borderColor='#7d3fb5'; this.style.background='linear-gradient(135deg, rgba(98, 47, 170, 0.1) 0%, rgba(98, 47, 170, 0.05) 100%)'" onmouseout="this.style.borderColor='#622faa'; this.style.background='linear-gradient(135deg, rgba(98, 47, 170, 0.05) 0%, rgba(98, 47, 170, 0.02) 100%)'">
                            <input type="file" id="kycFile" multiple accept=".pdf,.jpg,.jpeg,.png,.docx,.doc" style="display: none;">
                            <div onclick="document.getElementById('kycFile').click();" style="cursor: pointer;">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 2.5rem; color: #622faa; margin-bottom: 1rem; display: block;"></i>
                                <p style="margin: 0.5rem 0; font-weight: 600; color: #333;">
                                    Click to upload or drag and drop
                                </p>
                                <p style="margin: 0; color: #999; font-size: 0.85rem;">
                                    PDF, JPG, PNG, DOC, DOCX (Max 10MB each)
                                </p>
                            </div>
                        </div>

                        <div id="kycFileList" style="margin-bottom: 1.5rem;">
                            <!-- Uploaded files will appear here -->
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <div class="form-group">
                                <label for="kyc_type">Document Type</label>
                                <select id="kyc_type" name="kyc_type" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem;">
                                    <option value="">Select Document Type</option>
                                    <option value="passport">Passport</option>
                                    <option value="drivers_license">Driver's License</option>
                                    <option value="national_id">National ID Card</option>
                                    <option value="utility_bill">Utility Bill</option>
                                    <option value="bank_statement">Bank Statement</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kyc_issue_date">Issue Date</label>
                                <input 
                                    type="date" 
                                    id="kyc_issue_date" 
                                    name="kyc_issue_date"
                                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem;"
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="kyc_notes">Additional Notes</label>
                            <textarea 
                                id="kyc_notes" 
                                name="kyc_notes" 
                                rows="3"
                                placeholder="Add any additional information about your documents..."
                                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem; font-family: inherit; resize: vertical;"
                            ></textarea>
                        </div>

                        <div style="background: rgba(255, 193, 7, 0.1); border: 1px solid rgba(255, 193, 7, 0.3); border-radius: 8px; padding: 12px; margin-bottom: 15px; display: flex; gap: 10px; align-items: flex-start;">
                            <i class="fas fa-shield-alt" style="color: #FFC107; margin-top: 2px;"></i>
                            <p style="margin: 0; color: #666; font-size: 0.9rem;">
                                Your documents are securely stored and will be reviewed by our verification team within 24-48 hours.
                            </p>
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

    <script>
        // KYC Document Upload Handler
        const kycDropZone = document.getElementById('kycDropZone');
        const kycFile = document.getElementById('kycFile');
        const kycFileList = document.getElementById('kycFileList');
        const uploadedFiles = [];

        // Handle file input change
        kycFile.addEventListener('change', function(e) {
            handleFiles(e.target.files);
        });

        // Handle drag and drop
        kycDropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.style.borderColor = '#7d3fb5';
            this.style.background = 'linear-gradient(135deg, rgba(98, 47, 170, 0.15) 0%, rgba(98, 47, 170, 0.1) 100%)';
        });

        kycDropZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.style.borderColor = '#622faa';
            this.style.background = 'linear-gradient(135deg, rgba(98, 47, 170, 0.05) 0%, rgba(98, 47, 170, 0.02) 100%)';
        });

        kycDropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.style.borderColor = '#622faa';
            this.style.background = 'linear-gradient(135deg, rgba(98, 47, 170, 0.05) 0%, rgba(98, 47, 170, 0.02) 100%)';
            handleFiles(e.dataTransfer.files);
        });

        function handleFiles(files) {
            const maxSize = 10 * 1024 * 1024; // 10MB
            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

            for (let file of files) {
                // Validate file size
                if (file.size > maxSize) {
                    alert(`File "${file.name}" is too large (max 10MB)`);
                    continue;
                }

                // Validate file type
                if (!allowedTypes.includes(file.type) && !file.name.match(/\.(pdf|jpg|jpeg|png|doc|docx)$/i)) {
                    alert(`File "${file.name}" has an invalid type`);
                    continue;
                }

                uploadedFiles.push(file);
            }

            displayFiles();
        }

        function displayFiles() {
            kycFileList.innerHTML = '';

            if (uploadedFiles.length === 0) {
                return;
            }

            const fileListHTML = uploadedFiles.map((file, index) => `
                <div style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 8px; padding: 12px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                    <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                        <i class="fas fa-file" style="color: #622faa; font-size: 1.5rem;"></i>
                        <div style="flex: 1;">
                            <p style="margin: 0; font-weight: 500; color: #333;">${file.name}</p>
                            <p style="margin: 0; color: #999; font-size: 0.85rem;">${(file.size / 1024).toFixed(2)} KB</p>
                        </div>
                    </div>
                    <button type="button" onclick="removeFile(${index})" style="background: #ff6b6b; color: white; border: none; border-radius: 6px; padding: 6px 12px; cursor: pointer; font-size: 0.9rem; transition: background 0.3s ease;" onmouseover="this.style.background='#ff5252'" onmouseout="this.style.background='#ff6b6b'">
                        <i class="fas fa-trash-alt"></i> Remove
                    </button>
                </div>
            `).join('');

            kycFileList.innerHTML = fileListHTML;
        }

        function removeFile(index) {
            uploadedFiles.splice(index, 1);
            displayFiles();
        }

        // Handle form submission for KYC
        document.querySelector('form').addEventListener('submit', function(e) {
            if (uploadedFiles.length > 0) {
                // Prevent default form submission to handle file upload
                e.preventDefault();
                uploadKYCDocuments();
            }
        });

        function uploadKYCDocuments() {
            if (uploadedFiles.length === 0) {
                // If no files, submit regular form
                document.querySelector('form').submit();
                return;
            }

            const formData = new FormData();
            uploadedFiles.forEach(file => {
                formData.append('kyc_files[]', file);
            });
            formData.append('kyc_type', document.getElementById('kyc_type').value);
            formData.append('kyc_issue_date', document.getElementById('kyc_issue_date').value);
            formData.append('kyc_notes', document.getElementById('kyc_notes').value);

            // You can add AJAX upload here later
            console.log('Files ready for upload:', uploadedFiles);
            console.log('KYC Type:', document.getElementById('kyc_type').value);
            
            // For now, just log the files and submit the regular form
            document.querySelector('form').submit();
        }
    </script>
</body>
</html>
