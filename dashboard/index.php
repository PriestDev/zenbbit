<?php 
include 'includes/dashboard_init.php';
$pageTitle = 'Dashboard'; 
include 'includes/head.php'; 
?>
<body class="light-mode dashboard-body">
    <!-- Include Components -->
    <?php include 'includes/sidebar.php'; ?>
    <?php include 'includes/header.php'; ?>

    <!-- Main Content -->
    <main style="padding-bottom: 6rem;">
        <!-- Wallet Card Section -->
        <section class="dashboard-home mb-5">
            <div class="dashboard-card">
                <!-- Header Section with User Info -->
                <div class="dashboard-wallet-header">
                    <div>
                        <h2 class="dashboard-welcome-title">Welcome, <?php echo htmlspecialchars($fname . ' ' . $lname); ?></h2>
                        <p class="dashboard-welcome-subtitle">Manage your wallet and portfolio</p>
                    </div>
                    <div class="dashboard-account-id">
                        <div id="toast" class="toast">Account ID copied!</div>
                        <div class="dashboard-account-box">
                            <small class="dashboard-label">ACCOUNT ID</small>
                            <div class="dashboard-account-content">
                                <span id="walletIdText" class="dashboard-account-text"><?php echo htmlspecialchars($acct_id); ?></span>
                                <i class="fa-solid fa-copy dashboard-copy-icon" onclick="copyWalletId()"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Stats Summary Section -->
                <div class="dashboard-stats-grid">
                    <div class="dashboard-stat-item">
                        <p class="dashboard-stat-label">Email</p>
                        <p class="dashboard-stat-value"><?php echo htmlspecialchars($email); ?></p>
                    </div>
                    <div class="dashboard-stat-item">
                        <p class="dashboard-stat-label">Country</p>
                        <p class="dashboard-stat-value"><?php echo htmlspecialchars($country ?: 'Not Set'); ?></p>
                    </div>
                    <div class="dashboard-stat-item">
                        <p class="dashboard-stat-label">Status</p>
                        <p class="dashboard-stat-value"><?php echo (isset($status) && $status == 1) ? '✅ Verified' : '⏳ Pending'; ?></p>
                    </div>
                    <div class="dashboard-stat-item">
                        <p class="dashboard-stat-label">Member Since</p>
                        <p class="dashboard-stat-value"><?php echo date('M d, Y', strtotime($reg_date)); ?></p>
                    </div>
                </div>

                <!-- Balance Section -->
                <div class="dashboard-balance-section">
                    <p class="dashboard-balance-label">Total Balance (USD)</p>
                    <?php
                    require_once 'includes/crypto_prices.php';
                    
                    // Asset balances mapped to asset codes
                    $assets = [
                        'btc' => $btc_balance ?? 0,
                        'eth' => $eth_balance ?? 0,
                        'bnb' => $bnb_balance ?? 0,
                        'trx' => $trx_balance ?? 0,
                        'sol' => $sol_balance ?? 0,
                        'xrp' => $xrp_balance ?? 0,
                        'avax' => $avax_balance ?? 0,
                        'erc' => $erc_balance ?? 0,
                        'trc' => $trc_balance ?? 0
                    ];
                    
                    // Fetch current prices
                    $prices = get_crypto_prices();
                    
                    // Calculate total USD value
                    $total_usd = 0;
                    foreach ($assets as $asset_code => $amount) {
                        $amount = floatval($amount);
                        if ($amount > 0) {
                            $total_usd += get_asset_usd_value($asset_code, $amount, $prices);
                        }
                    }
                    
                    // Convert total USD to BTC
                    $total_btc_equiv = 0;
                    if (isset($prices['bitcoin']['usd']) && $prices['bitcoin']['usd'] > 0) {
                        $btc_price = floatval($prices['bitcoin']['usd']);
                        $total_btc_equiv = $total_usd / $btc_price;
                    }
                    ?>
                    <div class="dashboard-balance-amount">$<?php echo number_format($total_usd, 2); ?></div>
                    <p class="dashboard-balance-crypto">≈ <?php echo number_format($total_btc_equiv, 8); ?> BTC</p>
                </div>

                <!-- Actions Section -->
                <div class="dashboard-actions-section">
                    <p class="dashboard-actions-title">Quick Actions</p>
                    <div class="dashboard-actions-grid">
                        <div class="dashboard-action-btn" onclick="openModal('send')">
                            <i class="fas fa-arrow-up"></i>
                            <p>Send</p>
                        </div>
                        <div class="dashboard-action-btn" onclick="openModal('receive')">
                            <i class="fas fa-arrow-down"></i>
                            <p>Receive</p>
                        </div>
                        <a href="buy.php" class="dashboard-action-link">
                            <div class="dashboard-action-btn">
                                <i class="fas fa-credit-card"></i>
                                <p>Buy</p>
                            </div>
                        </a>
                        <a href="connect.php" class="dashboard-action-link">
                            <div class="dashboard-action-btn">
                                <i class="fas fa-link"></i>
                                <p>Connect</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Holdings Section (Asset List) -->
        <?php include 'includes/assets_list.php'; ?>

        <!-- Wallet Modal -->
        <?php include 'includes/wallet_modal.php'; ?>
    </main>

    <!-- Footer Navigation -->
    <?php include 'includes/footer.php'; ?>

    <!-- External Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    
    <!-- Custom Dashboard Scripts -->
    <script src="js/script.js"></script>
</body>
</html>