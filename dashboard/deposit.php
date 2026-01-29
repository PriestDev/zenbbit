<?php include 'includes/dashboard_init.php'; $pageTitle = 'Deposit'; $includeIziToast = true; include 'includes/head.php'; ?>
<link rel="stylesheet" href="css/deposit.css">
<body class="light-mode dashboard-body deposit-body">
  <!-- Sidebar Component -->
  <?php include 'includes/sidebar.php'; ?>

  <!-- Top Navbar Component -->
  <?php include 'includes/header.php'; ?>
  <!-- Main Deposit Content -->
  <main class="deposit-main">
    <section class="deposit-section hom mb-5">
      <!-- Status Messages -->
      <?php 
        if (isset($_SESSION['deposit_success']) && $_SESSION['deposit_success']) {
            echo '<div class="alert alert-success" style="margin: 20px;">' . htmlspecialchars($_SESSION['deposit_success']) . '</div>';
            unset($_SESSION['deposit_success']);
        }
        if (isset($_SESSION['deposit_error']) && $_SESSION['deposit_error']) {
            echo '<div class="alert alert-danger" style="margin: 20px;">' . htmlspecialchars($_SESSION['deposit_error']) . '</div>';
            unset($_SESSION['deposit_error']);
        }
      ?>
      
      <div class="card deposit-card">
        <!-- Header Section with Gradient -->
        <div class="wallet-inf deposit-header">
          <div>
            <h2 class="deposit-title">Deposit Funds</h2>
            <p class="deposit-subtitle">Add funds to your account securely</p>
          </div>
        </div>

        <!-- Info Box Section -->
        <div class="deposit-info-box">
          <p class="deposit-info-label">Quick Info</p>
          <p class="deposit-info-text">Choose your preferred deposit method and enter the amount to proceed with your deposit.</p>
        </div>

        <form id="depositForm" class="deposit-form" method="POST" action="api/process_deposit.php" enctype="multipart/form-data">
          <!-- Deposit Method Group -->
          <div class="form-group deposit-form-group">
            <label for="depositMethod" class="deposit-form-label">Select Payment Method</label>
            <select id="depositMethod" name="deposit_method" required class="deposit-form-select">
              <option value="">-- Select Payment Method --</option>
              <option value="btc">Bitcoin (BTC)</option>
              <option value="usdt_trc">USDT - TRC20</option>
              <option value="usdt_erc">USDT - ERC20</option>
              <option value="eth">Ethereum (ETH)</option>
            </select>
          </div>

          <!-- Amount Group -->
          <div class="form-group deposit-form-group">
            <label for="depositAmount" class="deposit-form-label">Amount (USD)</label>
            <input type="number" id="depositAmount" name="deposit_amount" class="deposit-form-input" placeholder="Enter amount" step="0.01" min="0" required>
          </div>

          <!-- Wallet Info Card (Hidden by default) -->
          <div id="walletCard" class="deposit-wallet-card" style="display: none;">
            <h3 class="deposit-wallet-title">Wallet Address</h3>
            
            <!-- QR Code -->
            <div class="deposit-qr-container">
              <div id="qrCode"></div>
            </div>

            <!-- Wallet Address Display -->
            <div class="deposit-address-display">
              <code id="walletAddress" class="deposit-address-code"></code>
              <button type="button" id="copyWalletBtn" class="deposit-copy-btn">Copy</button>
            </div>

            <p class="deposit-address-help">Send the specified amount to the wallet address above. Your deposit will be processed after payment verification.</p>
          </div>

          <!-- Payment Receipt Upload -->
          <div id="receiptGroup" class="deposit-receipt-group" style="display: none;">
            <label for="paymentReceipt" class="deposit-form-label">Upload Payment Receipt/Proof</label>
            <input type="file" id="paymentReceipt" name="payment_receipt" class="deposit-form-input" accept="image/*,.pdf" required>
            <small class="deposit-form-help">Accepted: Images (JPG, PNG, GIF) or PDF. Max 5MB</small>
          </div>

          <!-- Submit Button with Hover Effect -->
          <button type="submit" class="deposit-submit-btn">Proceed with Deposit</button>
        </form>

        <!-- Additional Info Section -->
        <div class="deposit-additional-info">
          <p class="deposit-additional-title">Why Choose Our Deposit Methods?</p>
          <div class="deposit-features-grid">
            <div class="deposit-feature-card secure">
              <p class="deposit-feature-icon">🔒 Secure</p>
              <p class="deposit-feature-text">Encrypted and safe transactions</p>
            </div>
            <div class="deposit-feature-card fast">
              <p class="deposit-feature-icon">⚡ Fast</p>
              <p class="deposit-feature-text">Instant deposit processing</p>
            </div>
            <div class="deposit-feature-card fees">
              <p class="deposit-feature-icon">💰 Low Fees</p>
              <p class="deposit-feature-text">Competitive deposit fees</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- Footer Component -->
  <?php include 'includes/footer.php'; ?>

  <!-- Jivo Live Chat - Disabled due to tracking prevention issues -->
  <!-- <script src="//code.jivosite.com/widget/Tyy2Bc4Zz5" async></script> -->

  <!-- External Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Toast Notification System -->
  <script src="js/toast.js"></script>

  <!-- Dashboard Scripts -->
  <script src="js/script.js"></script>

  <!-- Deposit Page Module with Wallet Configuration -->
  <script 
    src="js/deposit.js" 
    data-btc-address="<?php echo (defined("BTC") && !empty(BTC)) ? BTC : "NOT_CONFIGURED"; ?>"
    data-trc-address="<?php echo (defined("TRC") && !empty(TRC)) ? TRC : "NOT_CONFIGURED"; ?>"
    data-erc-address="<?php echo (defined("ERC") && !empty(ERC)) ? ERC : "NOT_CONFIGURED"; ?>"
    data-eth-address="<?php echo (defined("ETH") && !empty(ETH)) ? ETH : "NOT_CONFIGURED"; ?>">
  </script>

</body>
</html>
