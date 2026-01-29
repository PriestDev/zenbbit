<?php 
include 'includes/dashboard_init.php'; 
$pageTitle = 'Withdraw'; 

// Include external CSS
$additionalCSS = ['css/withdraw.css'];

include 'includes/head.php'; 

// Fetch user assets from database
$userAssets = [];
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $user_acct_id = $_SESSION['user_id'];
    $stmt = $conn->prepare(
        "SELECT btc_balance, eth_balance, bnb_balance, trx_balance, sol_balance, xrp_balance, avax_balance, erc_balance, trc_balance
         FROM user WHERE acct_id = ?"
    );
    
    if ($stmt) {
        $stmt->bind_param("s", $user_acct_id);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            if ($row) {
                // Map of database columns to asset info
                $assetMap = [
                    'btc_balance' => ['name' => 'Bitcoin', 'symbol' => 'BTC'],
                    'eth_balance' => ['name' => 'Ethereum', 'symbol' => 'ETH'],
                    'bnb_balance' => ['name' => 'Binance Coin', 'symbol' => 'BNB'],
                    'trx_balance' => ['name' => 'TRON', 'symbol' => 'TRX'],
                    'sol_balance' => ['name' => 'Solana', 'symbol' => 'SOL'],
                    'xrp_balance' => ['name' => 'Ripple', 'symbol' => 'XRP'],
                    'avax_balance' => ['name' => 'Avalanche', 'symbol' => 'AVAX'],
                    'erc_balance' => ['name' => 'USDT (ERC20)', 'symbol' => 'USDT-ERC20'],
                    'trc_balance' => ['name' => 'USDT (TRC20)', 'symbol' => 'USDT-TRC20']
                ];
                
                // Build asset list with balances
                foreach ($assetMap as $column => $info) {
                    $balance = floatval($row[$column] ?? 0);
                    $userAssets[] = [
                        'value' => strtolower($info['symbol']),
                        'name' => $info['name'],
                        'symbol' => $info['symbol'],
                        'balance' => $balance
                    ];
                }
            }
        }
        $stmt->close();
    }
}
?>
<body class="light-mode dashboard-body">

  <!-- Sidebar Component -->
  <?php include 'includes/sidebar.php'; ?>

  <!-- Top Navbar Component -->
  <?php include 'includes/header.php'; ?>

<main>
  <section class="withdraw-main-section">
    <div class="withdraw-card">
      <div class="withdraw-header">
        <h2 class="settings-title">Withdraw Funds</h2>
        <p class="settings-subtitle">Request a withdrawal from your account</p>
      </div>
    
      <form id="withdrawForm">
        <div class="form-group">
          <label for="withdrawMethod">Select Asset to Withdraw</label>
          <select id="withdrawMethod" required>
            <option value="">-- Choose Asset --</option>
            <?php
              if (!empty($userAssets)) {
                  foreach ($userAssets as $asset) {
                      $balance = number_format($asset['balance'], 8);
                      echo '<option value="' . htmlspecialchars($asset['value']) . '">' . htmlspecialchars($asset['name']) . ' (' . htmlspecialchars($asset['symbol']) . ') - Balance: ' . $balance . '</option>';
                  }
              } else {
                  echo '<option value="">No assets available</option>';
              }
            ?>
          </select>
        </div>

        <div class="form-group">
          <label for="withdrawAmount">Amount (USD $)</label>
          <input type="number" id="withdrawAmount" placeholder="Enter amount in USD (e.g., 100)" step="0.01" min="0" required>
          <small class="amount-helper">Enter dollar amount - automatically converts to crypto</small>
          <div id="conversionInfo" class="conversion-info" style="display: none;">
            <p>You will receive: <strong id="cryptoAmount">0.00</strong> <span id="cryptoSymbol">BTC</span></p>
            <p class="price-info">Current price: $<span id="currentPrice">0.00</span> per <span id="priceSymbol">BTC</span></p>
          </div>
        </div>

        <div class="form-group">
          <label for="withdrawAddress">Recipient Address/Account</label>
          <input type="text" id="withdrawAddress" placeholder="Enter wallet address" required>
        </div>

        <button type="submit" class="btn-primary">Request Withdrawal</button>
      </form>
    </div>
  </section>
</main>

  <!-- External Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Toast Notification System -->
  <script src="js/toast.js"></script>

  <!-- Dashboard Scripts -->
  <script src="js/script.js"></script>

  <!-- Withdraw Page Script -->
  <script src="js/withdraw.js"></script>

  <!-- Footer Component -->
  <?php include 'includes/footer.php'; ?>

</body>
</html>
