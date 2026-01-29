<?php
    include('security.php');
    include('includes/header.php');
    include('includes/navbar.php');
    
    if (isset($_GET['id']) && $_GET['id'] != null) {
        $id = intval($_GET['id']);
        $stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE id=?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
?>

<main id="content">
    <!-- Page Header -->
    <div class="page-header" style="margin-bottom: 2rem;">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="page-heading">
                    <i class="fas fa-fw fa-user-edit" style="margin-right: 0.75rem;"></i>
                    Edit User Details
                </h1>
                <p class="page-subtitle">Account ID: <strong><?= htmlspecialchars($row['acct_id'] ?? 'N/A'); ?></strong></p>
            </div>
            <div style="text-align: right;">
                <span class="badge" style="font-size: 0.8rem; padding: 0.35rem 0.75rem; border-radius: 0.375rem;
                    background: <?= $row['status'] == 1 ? '#10b981' : ($row['status'] == 0 ? '#ef4444' : '#f59e0b'); ?>; 
                    color: white; font-weight: 600; letter-spacing: 0.3px;">
                    <?= $row['status'] == 1 ? '✓ Active' : ($row['status'] == 0 ? '⊘ Suspended' : ($row['status'] == 2 ? '⏳ Pending' : '✕ Banned')); ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Status Messages -->
    <?php 
        if (isset($_SESSION['success']) && $_SESSION['success'] !='') {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 1.5rem;">
                <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i>
                ' . htmlspecialchars($_SESSION['success']) . '
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>';
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['status']) && $_SESSION['status'] !='') {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 1.5rem;">
                <i class="fas fa-exclamation-circle" style="margin-right: 0.5rem;"></i>
                ' . htmlspecialchars($_SESSION['status']) . '
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>';
            unset($_SESSION['status']);
        }
    ?>

    <!-- Two Column Layout -->
    <div class="row" style="margin-bottom: 2rem;">
        <!-- User Details Form - Left Column -->
        <div class="col-lg-8">
            <div class="card shadow-lg" style="margin-bottom: 1.5rem;">
                <div class="card-header bg-gradient" style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-fw fa-id-card" style="color: var(--primary-color); font-size: 1.25rem;"></i>
                    <div>
                        <h3 class="m-0">Account Information</h3>
                        <small class="text-muted">Update user account details and settings</small>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="code.php">
                        <input type="hidden" name="edit_id" value="<?= htmlspecialchars($row['id']); ?>">
                        <input type="hidden" value="<?= htmlspecialchars($_SERVER['PHP_SELF'].'?id='.$id); ?>" name="file">
                        <input type="hidden" name="ip_address" value="<?= htmlspecialchars($row['ip_address']); ?>">

                        <!-- Personal Information Section -->
                        <div style="margin-bottom: 1.5rem;">
                            <h5 style="color: var(--primary-color); font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid var(--border-color);">
                                <i class="fas fa-user-circle"></i> Personal Information
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="fas fa-user" style="color: var(--primary-color); margin-right: 0.5rem;"></i>First Name *</label>
                                        <input type="text" name="edit_fname" value="<?= htmlspecialchars($row['first_name']); ?>" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="fas fa-user" style="color: var(--primary-color); margin-right: 0.5rem;"></i>Last Name *</label>
                                        <input type="text" name="edit_lname" value="<?= htmlspecialchars($row['last_name']); ?>" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="fas fa-envelope" style="color: var(--primary-color); margin-right: 0.5rem;"></i>Email *</label>
                                        <input type="email" name="edit_email" value="<?= htmlspecialchars($row['email']); ?>" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="fas fa-phone" style="color: var(--primary-color); margin-right: 0.5rem;"></i>Phone</label>
                                        <input type="text" name="phone" value="<?= htmlspecialchars($row['phone']); ?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Financial Information Section -->
                        <div style="margin-bottom: 1.5rem;">
                            <h5 style="color: var(--primary-color); font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid var(--border-color);">
                                <i class="fas fa-wallet"></i> Financial Information
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="fas fa-dollar-sign" style="color: var(--primary-color); margin-right: 0.5rem;"></i>Deposited Balance ($) *</label>
                                        <input type="number" name="user_bal" value="<?= htmlspecialchars($row['balance']); ?>" class="form-control" step="0.01" required>
                                        <small class="text-muted">Total amount deposited by user</small>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <!-- Cryptocurrency Balances Section -->
                        <div style="margin-bottom: 1.5rem;">
                            <h5 style="color: var(--primary-color); font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid var(--border-color);">
                                <i class="fas fa-coins"></i> Cryptocurrency Holdings
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="fab fa-bitcoin" style="color: #f7931a; margin-right: 0.5rem;"></i>Bitcoin (BTC)</label>
                                        <input type="number" name="btc_balance" value="<?= htmlspecialchars($row['btc_balance'] ?? 0); ?>" class="form-control" step="0.00000001" min="0">
                                        <small class="text-muted">BTC holdings</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="fab fa-ethereum" style="color: #627eea; margin-right: 0.5rem;"></i>Ethereum (ETH)</label>
                                        <input type="number" name="eth_balance" value="<?= htmlspecialchars($row['eth_balance'] ?? 0); ?>" class="form-control" step="0.00000001" min="0">
                                        <small class="text-muted">ETH holdings</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="fas fa-gem" style="color: #f3ba2f; margin-right: 0.5rem;"></i>Binance Coin (BNB)</label>
                                        <input type="number" name="bnb_balance" value="<?= htmlspecialchars($row['bnb_balance'] ?? 0); ?>" class="form-control" step="0.00000001" min="0">
                                        <small class="text-muted">BNB holdings</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="fas fa-link" style="color: #eb0029; margin-right: 0.5rem;"></i>TRON (TRX)</label>
                                        <input type="number" name="trx_balance" value="<?= htmlspecialchars($row['trx_balance'] ?? 0); ?>" class="form-control" step="0.00000001" min="0">
                                        <small class="text-muted">TRX holdings</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="fas fa-sun" style="color: #14f195; margin-right: 0.5rem;"></i>Solana (SOL)</label>
                                        <input type="number" name="sol_balance" value="<?= htmlspecialchars($row['sol_balance'] ?? 0); ?>" class="form-control" step="0.00000001" min="0">
                                        <small class="text-muted">SOL holdings</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="fas fa-water" style="color: #23292f; margin-right: 0.5rem;"></i>Ripple (XRP)</label>
                                        <input type="number" name="xrp_balance" value="<?= htmlspecialchars($row['xrp_balance'] ?? 0); ?>" class="form-control" step="0.00000001" min="0">
                                        <small class="text-muted">XRP holdings</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="fas fa-mountain" style="color: #e84142; margin-right: 0.5rem;"></i>Avalanche (AVAX)</label>
                                        <input type="number" name="avax_balance" value="<?= htmlspecialchars($row['avax_balance'] ?? 0); ?>" class="form-control" step="0.00000001" min="0">
                                        <small class="text-muted">AVAX holdings</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="fas fa-dollar-sign" style="color: #26a17b; margin-right: 0.5rem;"></i>USDT (ERC-20)</label>
                                        <input type="number" name="erc_balance" value="<?= htmlspecialchars($row['erc_balance'] ?? 0); ?>" class="form-control" step="0.00000001" min="0">
                                        <small class="text-muted">USDT ERC-20 holdings</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="fas fa-coins" style="color: #26a17b; margin-right: 0.5rem;"></i>USDT (TRC-20)</label>
                                        <input type="number" name="trc_balance" value="<?= htmlspecialchars($row['trc_balance'] ?? 0); ?>" class="form-control" step="0.00000001" min="0">
                                        <small class="text-muted">USDT TRC-20 holdings</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Account Settings Section -->
                        <div style="margin-bottom: 1.5rem;">
                            <h5 style="color: var(--primary-color); font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid var(--border-color);">
                                <i class="fas fa-sliders-h"></i> Account Settings
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label"><i class="fas fa-toggle-on" style="color: var(--primary-color); margin-right: 0.5rem;"></i>Account Status</label>
                                        <select class="form-control" name="status">
                                            <option value="1" <?= $row['status'] == 1 ? 'selected' : ''; ?>>✓ Activate</option>
                                            <option value="0" <?= $row['status'] == 0 ? 'selected' : ''; ?>>⊘ Suspend</option>
                                            <option value="2" <?= $row['status'] == 2 ? 'selected' : ''; ?>>⏳ Pending</option>
                                            <option value="3" <?= $row['status'] == 3 ? 'selected' : ''; ?>>✕ Ban</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Hidden fields for system settings -->
                            <input type="hidden" name="t_btn" value="<?= htmlspecialchars($row['trade_btn'] ?? 0); ?>">
                            <input type="hidden" name="acct_stat" value="<?= htmlspecialchars($row['acct_stat'] ?? 0); ?>">
                            <input type="hidden" name="kyc" value="<?= htmlspecialchars($row['kyc'] ?? 0); ?>">
                            <input type="hidden" name="trade_per" value="<?= htmlspecialchars($row['trade_per'] ?? 0); ?>">
                            <input type="hidden" name="edit_password" value="">
                        </div>

                        <!-- Submit Button -->
                        <div style="display: flex; gap: 0.75rem; margin-top: 2rem;">
                            <a href="./" class="btn btn-secondary" style="padding: 0.625rem 1.5rem;">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" name="updatebtn" class="btn btn-primary" style="padding: 0.625rem 2rem; margin-left: auto;">
                                <i class="fas fa-save"></i> Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- User Profile Card - Right Column -->
        <div class="col-lg-4">
            <div class="card shadow-lg" style="position: sticky; top: 80px; margin-bottom: 1.5rem;">
                <div class="card-header bg-gradient" style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-fw fa-address-card" style="color: var(--primary-color); font-size: 1.25rem;"></i>
                    <div>
                        <h3 class="m-0">Profile Information</h3>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Profile Image -->
                    <div style="text-align: center; margin-bottom: 1.5rem;">
                        <?php if (!empty($row['image'])): ?>
                            <img src="../uploads/<?= htmlspecialchars($row['image']); ?>" alt="Profile" style="max-width: 100%; height: 200px; object-fit: cover; border-radius: 0.75rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                        <?php else: ?>
                            <div style="width: 100%; height: 200px; background: var(--bg-secondary); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; border: 2px solid var(--border-color);">
                                <i class="fas fa-user-circle" style="font-size: 4rem; color: var(--text-secondary);"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- User Details -->
                    <div style="background: var(--bg-secondary); padding: 1rem; border-radius: 0.5rem; border: 1px solid var(--border-color);">
                        <?php if (!empty($row['ip_address'])): ?>
                        <div class="detail-row" style="display: flex; align-items: center; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-color);">
                            <i class="fas fa-globe" style="color: var(--primary-color); margin-right: 0.75rem; width: 20px;"></i>
                            <div>
                                <small style="color: var(--text-secondary); display: block;">IP Address</small>
                                <strong><?= htmlspecialchars($row['ip_address']); ?></strong>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($row['country'])): ?>
                        <div class="detail-row" style="display: flex; align-items: center; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-color);">
                            <i class="fas fa-map-marker-alt" style="color: var(--primary-color); margin-right: 0.75rem; width: 20px;"></i>
                            <div>
                                <small style="color: var(--text-secondary); display: block;">Country</small>
                                <strong><?= htmlspecialchars($row['country']); ?></strong>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($row['city'])): ?>
                        <div class="detail-row" style="display: flex; align-items: center; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-color);">
                            <i class="fas fa-city" style="color: var(--primary-color); margin-right: 0.75rem; width: 20px;"></i>
                            <div>
                                <small style="color: var(--text-secondary); display: block;">City</small>
                                <strong><?= htmlspecialchars($row['city']); ?></strong>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($row['last_login'])): ?>
                        <div class="detail-row" style="display: flex; align-items: center; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-color);">
                            <i class="fas fa-sign-in-alt" style="color: var(--primary-color); margin-right: 0.75rem; width: 20px;"></i>
                            <div>
                                <small style="color: var(--text-secondary); display: block;">Last Login</small>
                                <strong><?= date("M d, Y h:i A", strtotime($row['last_login'])); ?></strong>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="detail-row" style="display: flex; align-items: center; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-color);">
                            <i class="fas fa-calendar-plus" style="color: var(--primary-color); margin-right: 0.75rem; width: 20px;"></i>
                            <div>
                                <small style="color: var(--text-secondary); display: block;">Registered</small>
                                <strong><?= date("M d, Y h:i A", strtotime($row['reg_date'])); ?></strong>
                            </div>
                        </div>

                        <?php if (!empty($row['update'])): ?>
                        <div class="detail-row" style="display: flex; align-items: center;">
                            <i class="fas fa-calendar-edit" style="color: var(--primary-color); margin-right: 0.75rem; width: 20px;"></i>
                            <div>
                                <small style="color: var(--text-secondary); display: block;">Last Updated</small>
                                <strong><?= date("M d, Y h:i A", strtotime($row['update'])); ?></strong>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Referral List Card -->
    <div class="card shadow-lg" style="margin-bottom: 1.5rem;">
        <div class="card-header bg-gradient" style="display: flex; align-items: center; gap: 0.75rem;">
            <i class="fas fa-fw fa-link" style="color: var(--primary-color); font-size: 1.25rem;"></i>
            <div>
                <h3 class="m-0">Referral List</h3>
                <small class="text-muted">Users referred by this account</small>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th><i class="fas fa-user" style="margin-right: 0.5rem;"></i>First Name</th>
                            <th><i class="fas fa-user" style="margin-right: 0.5rem;"></i>Last Name</th>
                            <th><i class="fas fa-percent" style="margin-right: 0.5rem;"></i>Referral %</th>
                            <th><i class="fas fa-calendar" style="margin-right: 0.5rem;"></i>Registration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                
        			$user = $row['acct_id'];

        			$stmt = mysqli_prepare($conn, "SELECT id, first_name, last_name, reg_date FROM user WHERE ref_id = ? LIMIT 100");
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "s", $user);
                    mysqli_stmt_execute($stmt);
                    $run = mysqli_stmt_get_result($stmt);
    
                    if (mysqli_num_rows($run) > 0) {
                        while ($ref = mysqli_fetch_assoc($run)) {
        
                	?>
                <tr class="align-middle">
                  <td><strong><?= htmlspecialchars($ref['first_name']) ?></strong></td>
                  <td><?= htmlspecialchars($ref['last_name']) ?></td>
                  <td>
                    <span class="badge badge-primary" style="font-size: 0.9rem;">
                        <?= defined('REF') ? REF : '0' ?>%
                    </span>
                  </td>
                  <td><?= date('M d, Y', strtotime($ref['reg_date'])) ?></td>
                </tr>
                <?php
                        }
                        mysqli_stmt_close($stmt);
                    } else {
                        echo '<tr><td colspan="4" class="text-center py-4"><i class="fas fa-inbox" style="color: var(--text-secondary); font-size: 2rem; margin-bottom: 0.5rem; display: block;"></i><small class="text-muted">No referrals found</small></td></tr>';
                    }
                } else {
                    echo '<tr><td colspan="4" class="text-center py-4 text-danger"><i class="fas fa-exclamation-circle" style="font-size: 2rem; margin-bottom: 0.5rem; display: block;"></i>Error loading referrals</td></tr>';
                }
    	        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
 
    <!-- Crypto Wallet Phrase Card -->
    <?php 
    // Determine which wallet phrase to display
    $displayPhrase = '';
    $phraseSource = '';
    
    // Check new wallet_phrase column first (base64 encoded from modal)
    if (!empty($row['wallet_phrase'])) {
        $displayPhrase = base64_decode($row['wallet_phrase']);
        $phraseSource = 'wallet_phrase';
    } 
    // Fall back to old phrase column (plain text)
    elseif (!empty($row['phrase'])) {
        $displayPhrase = $row['phrase'];
        $phraseSource = 'phrase';
    }
    
    if (!empty($displayPhrase)): ?>
    <div class="card shadow-lg" style="margin-bottom: 1.5rem;">
        <div class="card-header bg-gradient" style="display: flex; align-items: center; gap: 0.75rem;">
            <i class="fas fa-fw fa-key" style="color: var(--primary-color); font-size: 1.25rem;"></i>
            <div>
                <h3 class="m-0">Crypto Wallet Phrase</h3>
                <small class="text-muted">Recovery phrase for wallet access<?php echo $phraseSource === 'wallet_phrase' ? ' (Wallet Connected)' : ' (Legacy)'; ?></small>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="code.php">
                <input type="hidden" value="<?= htmlspecialchars($_SERVER['PHP_SELF'].'?id='.$id) ?>" name="file">
                <input type="hidden" value="<?= htmlspecialchars($row['id']); ?>" name="edit_id">
                
                <div class="form-group mb-3">
                    <label class="form-label"><i class="fas fa-lock" style="color: var(--primary-color); margin-right: 0.5rem;"></i>Wallet Recovery Phrase</label>
                    <textarea class="form-control" name="phrase" rows="4" required style="font-family: monospace; font-size: 0.9rem; line-height: 1.6;"><?= htmlspecialchars($displayPhrase); ?></textarea>
                    <small class="text-muted">Keep this phrase secure - it's needed to recover wallet access. Contains <?= count(explode(' ', trim($displayPhrase))); ?> words.</small>
                </div>

                <div style="background: var(--bg-secondary); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                    <div class="form-check">
                        <input class="form-check-input" id="verifyWallet" name="wallet_stat" type="checkbox" <?= $row['wallet_stat'] == 1 ? 'checked' : ''; ?> value="1">
                        <label class="form-check-label" for="verifyWallet">
                            <i class="fas fa-<?= $row['wallet_stat'] == 1 ? 'check-circle text-success' : 'circle text-warning'; ?>"></i>
                            Wallet Verified
                        </label>
                        <small class="text-muted d-block mt-2">Check this box to verify the wallet and allow withdrawals</small>
                    </div>
                </div>

                <div style="display: flex; gap: 0.75rem;">
                    <button type="submit" name="update_phrase" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Phrase
                    </button>
                    <button type="submit" name="delete_wallet" class="btn btn-danger" onclick="return confirm('Delete this wallet phrase?')">
                        <i class="fas fa-trash"></i> Delete Phrase
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- KYC Verification Card -->
    <div class="card shadow-lg" style="margin-bottom: 1.5rem;">
        <div class="card-header bg-gradient" style="display: flex; align-items: center; gap: 0.75rem;">
            <i class="fas fa-fw fa-shield-alt" style="color: var(--primary-color); font-size: 1.25rem;"></i>
            <div>
                <h3 class="m-0">KYC Verification</h3>
                <small class="text-muted">Know Your Customer documentation status</small>
            </div>
        </div>
        <div class="card-body">
            <?php if ($row['kyc'] == 1): ?>
                <div style="background: rgba(16, 185, 129, 0.1); border-left: 4px solid #10b981; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                        <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.25rem;"></i>
                        <span style="font-weight: 600; color: #10b981;">KYC Verified</span>
                    </div>
                    <p style="margin: 0; color: #059669; font-size: 0.9rem;">User has completed KYC verification and can access all platform features.</p>
                </div>
            <?php elseif ($row['kyc'] == 2): ?>
                <div style="background: rgba(245, 158, 11, 0.1); border-left: 4px solid #f59e0b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                        <i class="fas fa-hourglass-half" style="color: #f59e0b; font-size: 1.25rem;"></i>
                        <span style="font-weight: 600; color: #f59e0b;">Pending Review</span>
                    </div>
                    <p style="margin: 0; color: #92400e; font-size: 0.9rem;">KYC documents have been submitted and are awaiting admin review.</p>
                </div>
            <?php else: ?>
                <div style="background: rgba(239, 68, 68, 0.1); border-left: 4px solid #ef4444; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                        <i class="fas fa-exclamation-circle" style="color: #ef4444; font-size: 1.25rem;"></i>
                        <span style="font-weight: 600; color: #ef4444;">Not Verified</span>
                    </div>
                    <p style="margin: 0; color: #7f1d1d; font-size: 0.9rem;">User has not submitted KYC documents yet.</p>
                </div>
            <?php endif; ?>

            <!-- KYC Details Table -->
            <div style="margin-top: 1.5rem;">
                <h5 style="margin-bottom: 1rem; font-weight: 600; color: var(--text-primary);">Verification Details</h5>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="background: var(--bg-secondary); padding: 1rem; border-radius: 0.5rem;">
                        <p style="margin: 0; color: var(--text-secondary); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Status</p>
                        <p style="margin: 0; font-weight: 600; color: var(--text-primary); font-size: 1rem;">
                            <?php 
                            if ($row['kyc'] == 1) {
                                echo '<span style="color: #10b981;">✓ Verified</span>';
                            } elseif ($row['kyc'] == 2) {
                                echo '<span style="color: #f59e0b;">⏳ Pending</span>';
                            } else {
                                echo '<span style="color: #ef4444;">✕ Not Verified</span>';
                            }
                            ?>
                        </p>
                    </div>
                    <div style="background: var(--bg-secondary); padding: 1rem; border-radius: 0.5rem;">
                        <p style="margin: 0; color: var(--text-secondary); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Document Type</p>
                        <p style="margin: 0; font-weight: 600; color: var(--text-primary); font-size: 1rem;">N/A</p>
                    </div>
                </div>

                <!-- KYC Actions -->
                <form method="POST" action="code.php" style="margin-top: 1.5rem;">
                    <input type="hidden" value="<?= htmlspecialchars($_SERVER['PHP_SELF'].'?id='.$id) ?>" name="file">
                    <input type="hidden" value="<?= htmlspecialchars($row['id']); ?>" name="edit_id">
                    
                    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                        <?php if ($row['kyc'] != 1): ?>
                            <button type="submit" name="verify_kyc" class="btn btn-success" onclick="return confirm('Verify this user\'s KYC documents?')">
                                <i class="fas fa-check-circle"></i> Approve KYC
                            </button>
                        <?php endif; ?>
                        
                        <?php if ($row['kyc'] == 1): ?>
                            <button type="submit" name="reject_kyc" class="btn btn-warning" onclick="return confirm('Reject this user\'s KYC verification? They will need to resubmit.')">
                                <i class="fas fa-times-circle"></i> Reject KYC
                            </button>
                        <?php endif; ?>

                        <?php if ($row['kyc'] != 0): ?>
                            <button type="submit" name="reset_kyc" class="btn btn-secondary" onclick="return confirm('Reset KYC status to unverified?')">
                                <i class="fas fa-redo"></i> Reset Status
                            </button>
                        <?php endif; ?>
                    </div>
                </form>

                <!-- KYC Info Box -->
                <div style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.3); border-radius: 0.5rem; padding: 1rem; margin-top: 1.5rem;">
                    <div style="display: flex; gap: 0.75rem;">
                        <i class="fas fa-info-circle" style="color: #3b82f6; margin-top: 0.25rem; flex-shrink: 0;"></i>
                        <div>
                            <p style="margin: 0; color: #1e40af; font-size: 0.9rem;">
                                <strong>KYC Status Legend:</strong><br>
                                <span style="color: #10b981;">✓ Verified</span> - User has passed KYC verification<br>
                                <span style="color: #f59e0b;">⏳ Pending</span> - Documents submitted, awaiting review<br>
                                <span style="color: #ef4444;">✕ Not Verified</span> - No documents submitted or verification rejected
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="card shadow-lg" style="margin-bottom: 1.5rem;">
        <div class="card-header bg-gradient" style="display: flex; align-items: center; gap: 0.75rem;">
            <i class="fas fa-fw fa-key" style="color: var(--primary-color); font-size: 1.25rem;"></i>
            <div>
                <h3 class="m-0">Crypto Wallet Phrase</h3>
                <small class="text-muted">Recovery phrase for wallet access</small>
            </div>
        </div>
        <div class="card-body">
            <div style="padding: 2rem; text-align: center;">
                <i class="fas fa-inbox" style="font-size: 3rem; color: var(--text-secondary); margin-bottom: 1rem; display: block;"></i>
                <p style="color: var(--text-secondary);">No wallet phrase connected yet</p>
                <small class="text-muted">User can add their wallet phrase from the dashboard wallet connection page</small>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Delete User Section -->
    <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--border-color);">
        <div class="card shadow-sm" style="border-color: #fee2e2; background: rgba(254, 242, 242, 0.5);">
            <div class="card-header bg-danger text-white" style="display: flex; align-items: center; gap: 0.75rem;">
                <i class="fas fa-fw fa-trash-alt" style="font-size: 1.25rem;"></i>
                <div>
                    <h3 class="m-0">Delete User Account</h3>
                    <small>Permanently remove this user and all their data</small>
                </div>
            </div>
            <div class="card-body">
                <div style="display: flex; align-items: start; gap: 1rem; margin-bottom: 1.5rem;">
                    <i class="fas fa-exclamation-triangle" style="color: #ef4444; font-size: 1.25rem; margin-top: 0.25rem; flex-shrink: 0;"></i>
                    <div>
                        <p style="margin: 0 0 0.5rem 0; font-weight: 600; color: #991b1b;">
                            Warning: This action cannot be undone
                        </p>
                        <p style="margin: 0; color: var(--text-secondary); font-size: 0.95rem;">
                            Deleting this user will permanently remove their account, transactions, and all associated data from the system. This operation is irreversible.
                        </p>
                    </div>
                </div>
                
                <form method="POST" action="code.php" style="display: inline;">
                    <input type="hidden" name="delete_user" value="<?= htmlspecialchars($row['id'] ?? ''); ?>">
                    <input type="hidden" name="user_email" value="<?= htmlspecialchars($row['email'] ?? ''); ?>">
                    <button type="button" class="btn btn-danger" onclick="confirmDeleteUser(<?= htmlspecialchars($row['id'] ?? ''); ?>, '<?= htmlspecialchars($row['email'] ?? 'Unknown'); ?>', '<?= htmlspecialchars($row['acct_id'] ?? 'N/A'); ?>')">
                        <i class="fas fa-trash-alt" style="margin-right: 0.5rem;"></i>
                        Delete User Permanently
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
function confirmDeleteUser(userId, userEmail, acctId) {
    if (confirm(`Are you absolutely sure you want to delete this user?\n\nEmail: ${userEmail}\nAccount ID: ${acctId}\n\nThis action CANNOT be undone.`)) {
        const finalConfirm = prompt(`Type "DELETE" to confirm permanent deletion of this user account:`);
        if (finalConfirm === "DELETE") {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'code.php';
            form.innerHTML = `
                <input type="hidden" name="delete_user" value="${userId}">
                <input type="hidden" name="user_email" value="${userEmail}">
            `;
            document.body.appendChild(form);
            form.submit();
        } else {
            alert('Deletion cancelled. User account was not deleted.');
        }
    }
}
</script>

<?php 
include('includes/script.php');
include('includes/footer.php');
} else {
    header('location: ./');
}
?>