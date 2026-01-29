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
                    <div class="dashboard-balance-amount">$<?php echo number_format($total_bal, 2); ?></div>
                    <p class="dashboard-balance-crypto">≈ <?php echo number_format($total_btc, 8); ?> BTC</p>
                    
                    <!-- Individual Asset Balances -->
                    <div class="dashboard-assets-breakdown">
                        <?php
                        // Define all available assets with their properties
                        $assets = [
                            'btc_balance' => ['name' => 'Bitcoin', 'symbol' => 'BTC', 'decimals' => 8],
                            'eth_balance' => ['name' => 'Ethereum', 'symbol' => 'ETH', 'decimals' => 8],
                            'bnb_balance' => ['name' => 'Binance Coin', 'symbol' => 'BNB', 'decimals' => 8],
                            'trx_balance' => ['name' => 'TRON', 'symbol' => 'TRX', 'decimals' => 8],
                            'sol_balance' => ['name' => 'Solana', 'symbol' => 'SOL', 'decimals' => 8],
                            'xrp_balance' => ['name' => 'Ripple', 'symbol' => 'XRP', 'decimals' => 8],
                            'avax_balance' => ['name' => 'Avalanche', 'symbol' => 'AVAX', 'decimals' => 8],
                            'erc_balance' => ['name' => 'ERC Token', 'symbol' => 'ERC', 'decimals' => 8],
                            'trc_balance' => ['name' => 'TRC Token', 'symbol' => 'TRC', 'decimals' => 8]
                        ];
                        
                        // Display each asset if balance > 0
                        foreach ($assets as $column => $asset_info) {
                            if (isset($$column) && $$column > 0) {
                                $balance = $$column;
                                $formatted_balance = number_format($balance, $asset_info['decimals']);
                                $symbol = $asset_info['symbol'];
                                $name = $asset_info['name'];
                                echo '<div class="asset-balance-item">';
                                echo '<span class="asset-name">' . htmlspecialchars($name) . ':</span>';
                                echo '<span class="asset-balance">' . $formatted_balance . ' ' . htmlspecialchars($symbol) . '</span>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
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