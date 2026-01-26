<?php 
include('security.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<main id="content">
    <!-- Page Heading -->
    <h1 class="page-heading">Admin Accounts</h1>

    <!-- Status Messages -->
    <?php 
        if (isset($_SESSION['success']) && $_SESSION['success'] != '') {
            echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success']) . '</div>';
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
            echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['status']) . '</div>';
            unset($_SESSION['status']);
        }
    ?>

    <!-- Create Admin Modal -->
    <div id="adminModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border: none; border-radius: 0.75rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
                <div class="modal-header" style="border-bottom: 1px solid var(--border-color); padding: 1.5rem;">
                    <div>
                        <h5 class="modal-title">
                            <i class="fas fa-fw fa-user-plus" style="color: var(--primary-color); margin-right: 0.5rem;"></i>
                            Create Admin Account
                        </h5>
                        <p style="color: var(--text-secondary); font-size: 0.875rem; margin: 0.25rem 0 0 1.75rem;">
                            Add a new administrator to the platform
                        </p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="code.php" method="POST" id="createAdminForm">
                    <div class="modal-body" style="padding: 1.5rem;">
                        <div class="alert alert-info" role="alert" style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                            <i class="fas fa-info-circle"></i>
                            <div>
                                <strong>Required Fields:</strong> All fields marked with <span style="color: #ef4444;">*</span> must be completed.
                            </div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="username" class="form-label">
                                <i class="fas fa-fw fa-user" style="color: var(--primary-color); margin-right: 0.375rem;"></i>
                                Username <span style="color: #ef4444;">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="username"
                                name="username" 
                                class="form-control" 
                                placeholder="e.g., john_admin" 
                                required
                                minlength="3"
                                maxlength="50"
                                style="border-radius: 0.5rem; padding: 0.625rem 0.875rem; font-size: 0.95rem;"
                            >
                            <small class="form-text text-muted">Username must be 3-50 characters</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-fw fa-envelope" style="color: var(--primary-color); margin-right: 0.375rem;"></i>
                                Email Address <span style="color: #ef4444;">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email"
                                name="email" 
                                class="form-control" 
                                placeholder="e.g., admin@example.com" 
                                required
                                style="border-radius: 0.5rem; padding: 0.625rem 0.875rem; font-size: 0.95rem;"
                            >
                            <small class="form-text text-muted">Must be a valid email address</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-fw fa-lock" style="color: var(--primary-color); margin-right: 0.375rem;"></i>
                                Password <span style="color: #ef4444;">*</span>
                            </label>
                            <div class="input-group" style="border-radius: 0.5rem; overflow: hidden;">
                                <input 
                                    type="password" 
                                    id="password"
                                    name="password" 
                                    class="form-control" 
                                    placeholder="Enter a secure password" 
                                    required
                                    minlength="6"
                                    style="border-radius: 0.5rem 0 0 0.5rem; padding: 0.625rem 0.875rem; font-size: 0.95rem;"
                                >
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password')" style="border-radius: 0 0.5rem 0.5rem 0;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="form-text text-muted">Must be at least 6 characters</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="cpassword" class="form-label">
                                <i class="fas fa-fw fa-check-circle" style="color: var(--primary-color); margin-right: 0.375rem;"></i>
                                Confirm Password <span style="color: #ef4444;">*</span>
                            </label>
                            <div class="input-group" style="border-radius: 0.5rem; overflow: hidden;">
                                <input 
                                    type="password" 
                                    id="cpassword"
                                    name="cpassword" 
                                    class="form-control" 
                                    placeholder="Re-enter your password" 
                                    required
                                    minlength="6"
                                    style="border-radius: 0.5rem 0 0 0.5rem; padding: 0.625rem 0.875rem; font-size: 0.95rem;"
                                >
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('cpassword')" style="border-radius: 0 0.5rem 0.5rem 0;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="form-text text-muted">Passwords must match</small>
                        </div>

                        <input type="hidden" name="usertype" value="sub admin">
                    </div>

                    <div class="modal-footer" style="border-top: 1px solid var(--border-color); padding: 1.25rem 1.5rem; background-color: var(--bg-secondary);">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 0.5rem 1.25rem;">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="submit" name="register" class="btn btn-primary" id="submitBtn" style="padding: 0.5rem 1.5rem;">
                            <i class="fas fa-plus"></i> Create Admin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Admin List Card -->
    <div class="card">
        <div class="card-header d-flex justify-between align-center">
            <h3 class="m-0">
                <i class="fas fa-fw fa-shield-alt" style="margin-right: 0.5rem;"></i>
                Administrator Accounts
            </h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adminModal">
                <i class="fas fa-plus"></i> New Admin
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Registered</th>
                            <th>Last Updated</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $stmt = mysqli_prepare($conn, "SELECT id, user_name, email, status, reg_date, update_date, usertype FROM admin ORDER BY id DESC");
                        if ($stmt) {
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $status_badge = ($row['status'] == 1) 
                                        ? '<span class="badge badge-approved">ACTIVE</span>'
                                        : '<span class="badge badge-pending">INACTIVE</span>';
                                    
                                    $type_label = ($row['usertype'] == 1) 
                                        ? '<span style="background: #3b82f6; color: white; padding: 0.375rem 0.75rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Super Admin</span>'
                                        : '<span style="background: #10b981; color: white; padding: 0.375rem 0.75rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Sub Admin</span>';

                                    $user_name = htmlspecialchars($row['user_name']);
                                    $email = htmlspecialchars($row['email']);
                                    $id = (int)$row['id'];
                                    $reg_date = date('Y-m-d H:i', strtotime($row['reg_date']));
                                    $update_date = date('Y-m-d H:i', strtotime($row['update_date']));
                        ?>
                        <tr>
                            <td><strong><?php echo $id; ?></strong></td>
                            <td><?php echo $user_name; ?></td>
                            <td><?php echo $email; ?></td>
                            <td><?php echo $status_badge; ?></td>
                            <td><?php echo $reg_date; ?></td>
                            <td><?php echo $update_date; ?></td>
                            <td><?php echo $type_label; ?></td>
                            <td>
                                <?php if ($row['usertype'] != 1) { ?>
                                    <form method="POST" action="code.php" style="display: inline;">
                                        <input type="hidden" name="edit_id" value="<?php echo $id; ?>">
                                        <button type="submit" name="edit_btn" class="btn btn-sm btn-secondary" title="Edit admin">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                    </form>
                                    <form method="POST" action="code.php" style="display: inline;">
                                        <input type="hidden" name="delete_admin" value="<?php echo $id; ?>">
                                        <button type="submit" name="delete_btn" class="btn btn-sm btn-danger" title="Delete admin" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                <?php } else { ?>
                                    <span class="badge" style="background: #9ca3af; color: white; padding: 0.375rem 0.75rem; border-radius: 0.25rem;">Protected</span>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                                }
                            } else {
                                echo '<tr><td colspan="8" class="text-center text-muted">No admin accounts found</td></tr>';
                            }
                            mysqli_stmt_close($stmt);
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
// Toggle password visibility
function togglePasswordVisibility(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = event.target.closest('button').querySelector('i');
    
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

// Form validation and submission
document.getElementById('createAdminForm')?.addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const cpassword = document.getElementById('cpassword').value;
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    
    // Validate passwords match
    if (password !== cpassword) {
        e.preventDefault();
        alert('Passwords do not match. Please try again.');
        document.getElementById('cpassword').focus();
        return false;
    }
    
    // Validate password length
    if (password.length < 6) {
        e.preventDefault();
        alert('Password must be at least 6 characters long.');
        document.getElementById('password').focus();
        return false;
    }
    
    // Validate username length
    if (username.length < 3) {
        e.preventDefault();
        alert('Username must be at least 3 characters long.');
        document.getElementById('username').focus();
        return false;
    }
    
    // Validate email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Please enter a valid email address.');
        document.getElementById('email').focus();
        return false;
    }
    
    // Show loading state on submit button
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating...';
    
    // Reset button after 3 seconds if form doesn't redirect
    setTimeout(() => {
        if (!document.hidden) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    }, 3000);
});

// Reset form when modal is closed
document.getElementById('adminModal')?.addEventListener('hidden.bs.modal', function() {
    document.getElementById('createAdminForm').reset();
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = false;
    submitBtn.innerHTML = '<i class="fas fa-plus"></i> Create Admin';
});

// Auto-dismiss alerts after 5 seconds
document.querySelectorAll('.alert').forEach(alert => {
    setTimeout(() => {
        alert.style.opacity = '0';
        alert.style.transition = 'opacity 0.3s ease';
        setTimeout(() => alert.remove(), 300);
    }, 5000);
});
</script>

<?php 
include('includes/script.php');
include('includes/footer.php');
?>