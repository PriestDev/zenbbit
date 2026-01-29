<?php
include 'includes/dashboard_init.php';
$pageTitle = 'Coin Details';
$includeIziToast = true;
include 'includes/head.php';

// Get coin type from URL parameter (supports both ?coin=btc and ?id=5)
$coinType = isset($_GET['coin']) ? htmlspecialchars($_GET['coin']) : 'btc';

// Map of ID to coin type for backward compatibility with assets_list.php
$idToCoinMap = [
    '5' => 'btc',
    '6' => 'bnb',
    '8' => 'eth',
    '9' => 'trx',
    '13' => 'erc',
    '15' => 'sol',
    '16' => 'xrp',
    '17' => 'avax',
    '18' => 'trc'
];

// If ID is provided, convert to coin type
if (isset($_GET['id']) && isset($idToCoinMap[$_GET['id']])) {
    $coinType = $idToCoinMap[$_GET['id']];
}

// Map coin types to labels and wallet addresses
$coinInfo = [
    'btc' => [
        'label' => 'Bitcoin',
        'symbol' => 'BTC',
        'address' => BTC,
        'icon' => 'uploads/1758392283_Bitcoin.png',
        'db_column' => 'btc_balance'
    ],
    'bnb' => [
        'label' => 'Binance Coin',
        'symbol' => 'BNB',
        'address' => 'Binance wallet address not configured',
        'icon' => 'uploads/1758392904_bnb-binance.PNG',
        'db_column' => 'bnb_balance'
    ],
    'eth' => [
        'label' => 'Ethereum',
        'symbol' => 'ETH',
        'address' => ETH,
        'icon' => 'uploads/1758393392_eth.png',
        'db_column' => 'eth_balance'
    ],
    'trx' => [
        'label' => 'TRON',
        'symbol' => 'TRX',
        'address' => TRC,
        'icon' => 'uploads/1758393351_trx2.png',
        'db_column' => 'trx_balance'
    ],
    'erc' => [
        'label' => 'USDT (ERC20)',
        'symbol' => 'USDT-ERC20',
        'address' => ERC,
        'icon' => 'uploads/1759140395_tether.png',
        'db_column' => 'erc_balance'
    ],
    'sol' => [
        'label' => 'Solana',
        'symbol' => 'SOL',
        'address' => 'Solana wallet address not configured',
        'icon' => 'uploads/1759140771_Solana.png',
        'db_column' => 'sol_balance'
    ],
    'xrp' => [
        'label' => 'Ripple',
        'symbol' => 'XRP',
        'address' => 'Ripple wallet address not configured',
        'icon' => 'uploads/1759141201_xrp.png',
        'db_column' => 'xrp_balance'
    ],
    'avax' => [
        'label' => 'Avalanche',
        'symbol' => 'AVAX',
        'address' => 'Avalanche wallet address not configured',
        'icon' => 'uploads/1759141105_av.jpeg',
        'db_column' => 'avax_balance'
    ],
    'trc' => [
        'label' => 'USDT (TRC20)',
        'symbol' => 'USDT-TRC20',
        'address' => TRC,
        'icon' => 'uploads/1759331218_tether.png',
        'db_column' => 'trc_balance'
    ]
];

// Get current coin data or default to BTC
$current = isset($coinInfo[$coinType]) ? $coinInfo[$coinType] : $coinInfo['btc'];

// Fetch user's balance for this specific coin from database
$userBalance = 0;
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $user_acct_id = $_SESSION['user_id'];
    $db_column = $current['db_column'];
    
    // Query to fetch specific balance column (safe because db_column comes from controlled array)
    $stmt = $conn->prepare(
        "SELECT btc_balance, eth_balance, bnb_balance, trx_balance, sol_balance, xrp_balance, avax_balance, erc_balance, trc_balance
         FROM user WHERE acct_id = ?"
    );
    
    if ($stmt) {
        $stmt->bind_param("s", $user_acct_id);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            // Get the balance value using the dynamic column name
            if ($row && isset($row[$db_column])) {
                $userBalance = floatval($row[$db_column]);
            }
        } else {
            error_log("Balance fetch error for {$db_column}: " . $stmt->error);
        }
        $stmt->close();
    } else {
        error_log("Statement prepare error: " . $conn->error);
    }
}

// Fetch live price for current coin from CoinGecko API
$currentPrice = 0;
$priceChangePercent = 0;
try {
    // Map coin types to CoinGecko IDs
    $coinToCoinGeckoMap = [
        'btc' => 'bitcoin',
        'eth' => 'ethereum',
        'bnb' => 'binancecoin',
        'trx' => 'tron',
        'sol' => 'solana',
        'xrp' => 'ripple',
        'avax' => 'avalanche-2',
        'erc' => 'tether',
        'trc' => 'tether'
    ];
    
    $coingecko_id = $coinToCoinGeckoMap[$coinType] ?? 'bitcoin';
    $price_url = "https://api.coingecko.com/api/v3/simple/price?ids=" . urlencode($coingecko_id) . "&vs_currencies=usd&include_market_cap=false&include_24hr_change=true";
    
    // Fetch with timeout
    $context = stream_context_create([
        'http' => [
            'timeout' => 5,
            'method' => 'GET',
            'header' => "User-Agent: Mozilla/5.0\r\n"
        ]
    ]);
    
    $response = @file_get_contents($price_url, false, $context);
    
    if ($response !== false) {
        $price_data = json_decode($response, true);
        
        if ($price_data && isset($price_data[$coingecko_id])) {
            $currentPrice = floatval($price_data[$coingecko_id]['usd'] ?? 0);
            $priceChangePercent = floatval($price_data[$coingecko_id]['usd_24h_change'] ?? 0);
        }
    }
} catch (Exception $e) {
    error_log("CoinGecko API error for {$coinType}: " . $e->getMessage());
}

// Fetch user transactions from database
$userTransactions = [];
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $user_acct_id = $_SESSION['user_id'];
    
    // Query transactions for this user filtered by current asset
    $trans_query = "SELECT id, name, type, status, amt, asset, create_date FROM transaction WHERE name = ? AND asset = ? ORDER BY create_date DESC LIMIT 20";
    $stmt = $conn->prepare($trans_query);
    
    if ($stmt) {
        $stmt->bind_param("ss", $user_acct_id, $coinType);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $userTransactions[] = [
                    'id' => $row['id'],
                    'type' => strtolower($row['type']),
                    'amount' => floatval($row['amt']),
                    'status' => $row['status'],
                    'date' => $row['create_date'],
                    'asset' => htmlspecialchars($row['asset'])
                ];
            }
        } else {
            error_log("Transaction fetch error: " . $stmt->error);
        }
        $stmt->close();
    }
}
?>

<body class="light-mode dashboard-body" data-coin-type="<?php echo $coinType; ?>">
  <!-- Sidebar Component -->
  <?php include 'includes/sidebar.php'; ?>

  <!-- Top Navbar Component -->
  <?php include 'includes/header.php'; ?>

  <!-- Main Content -->
  <main style="padding-bottom: 6rem; margin-top: 6rem;">
    <section class="view-main-section mb-5">
      
      <!-- Back Button -->
      <a href="./" class="view-back-link">
        <i class="fas fa-chevron-left"></i> Back to Dashboard
      </a>

      <!-- Coin Card -->
      <div class="card view-coin-card">
        <!-- Loading Indicator -->
        <div id="loadingIndicator" style="display: none; text-align: center; padding: 20px;">
          <div style="display: inline-block; width: 40px; height: 40px; border: 4px solid #f3f3f3; border-top: 4px solid #622faa; border-radius: 50%; animation: spin 1s linear infinite;"></div>
          <p style="color: #888; margin-top: 10px; font-size: 14px;">Loading market data...</p>
          <style>
            @keyframes spin {
              0% { transform: rotate(0deg); }
              100% { transform: rotate(360deg); }
            }
          </style>
        </div>

        <div class="view-coin-card-content" id="coinCardContent">
          <div class="view-coin-icon">
            <img src="<?php echo $current['icon']; ?>" alt="<?php echo $current['label']; ?>">
          </div>
          <h2 class="view-coin-title"><?php echo $current['label']; ?></h2>
          <p class="view-coin-symbol"><?php echo $current['symbol']; ?></p>
          
          <p class="view-coin-balance">
            Balance: <strong><?php echo number_format($userBalance, 8); ?> <?php echo substr($current['symbol'], 0, 3); ?></strong>
          </p>

          <!-- Portfolio Value in USD -->
          <p class="view-coin-usd-value" style="margin-top: 10px; color: #622faa; font-size: 18px; font-weight: 700;">
            Wallet Value: <strong>$<?php echo number_format(($userBalance * $currentPrice), 2); ?></strong>
          </p>

          <!-- Live Price Display (Blended) -->
          <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(0,0,0,0.1);">
            <p style="color: #888; margin: 0 0 12px 0; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Current Price</p>
            <div style="display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 8px;">
              <h3 id="livePrice" style="margin: 0; color: #622faa; font-size: 28px; font-weight: 700;">$<?php echo number_format($currentPrice, 2); ?></h3>
              <div id="priceChange" style="display: flex; align-items: center; gap: 6px; padding: 6px 10px; background: <?php echo ($priceChangePercent >= 0) ? '#e8f5e9' : '#ffebee'; ?>; border-radius: 6px;">
                <i id="changeIcon" class="fas fa-arrow-<?php echo ($priceChangePercent >= 0) ? 'up' : 'down'; ?>" style="color: <?php echo ($priceChangePercent >= 0) ? '#4caf50' : '#f44336'; ?>; font-size: 12px;"></i>
                <span id="changePercent" style="color: <?php echo ($priceChangePercent >= 0) ? '#4caf50' : '#f44336'; ?>; font-weight: 600; font-size: 12px;"><?php echo ($priceChangePercent >= 0 ? '+' : '') . number_format($priceChangePercent, 2); ?>%</span>
              </div>
            </div>
            <p style="color: #999; margin: 0; font-size: 11px;">24h Change</p>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="view-actions-container">
        <a href="deposit.php" class="view-action-button" style="text-decoration: none;">
          <i class="fas fa-arrow-down"></i> Receive
        </a>

        <a href="withdraw.php" class="view-action-button" style="text-decoration: none;">
          <i class="fas fa-arrow-up"></i> Send
        </a>

        <a href="buy.php" class="view-action-button" style="text-decoration: none;">
          <i class="fas fa-credit-card"></i> Buy
        </a>
      </div>

      <!-- Price Chart Section -->
      <div class="card view-chart-card">
        <h3 class="view-chart-title">
          <i class="fas fa-chart-line"></i>Price Chart
        </h3>

        <!-- Chart Controls -->
        <div style="display: flex; gap: 15px; flex-wrap: wrap; margin-bottom: 20px; padding: 15px; background: #f9f9f9; border-radius: 8px;">
          <!-- Chart Type Selector -->
          <div>
            <label style="font-size: 12px; font-weight: 600; color: #666; text-transform: uppercase; display: block; margin-bottom: 8px;">Chart Type</label>
            <div style="display: flex; gap: 8px;">
              <button id="chartTypeCandle" class="chart-option-btn chart-option-active" onclick="switchChartType('candlestick')" title="Candlestick Chart">
                <i class="fas fa-bars"></i> Candles
              </button>
              <button id="chartTypeLine" class="chart-option-btn" onclick="switchChartType('line')" title="Line Chart">
                <i class="fas fa-chart-line"></i> Line
              </button>
              <button id="chartTypeBar" class="chart-option-btn" onclick="switchChartType('bar')" title="Bar Chart">
                <i class="fas fa-chart-bar"></i> Bar
              </button>
              <button id="chartTypeArea" class="chart-option-btn" onclick="switchChartType('area')" title="Area Chart">
                <i class="fas fa-fill"></i> Area
              </button>
            </div>
          </div>

          <!-- Time Range Selector -->
          <div>
            <label style="font-size: 12px; font-weight: 600; color: #666; text-transform: uppercase; display: block; margin-bottom: 8px;">Time Range</label>
            <div style="display: flex; gap: 8px;">
              <button id="range7d" class="chart-option-btn" onclick="switchTimeRange(7)" title="7 Days">7D</button>
              <button id="range14d" class="chart-option-btn" onclick="switchTimeRange(14)" title="14 Days">14D</button>
              <button id="range30d" class="chart-option-btn chart-option-active" onclick="switchTimeRange(30)" title="30 Days">30D</button>
            </div>
          </div>
        </div>

        <style>
          .chart-option-btn {
            padding: 8px 12px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            color: #666;
            transition: all 0.2s ease;
          }
          .chart-option-btn:hover {
            background: #f0f0f0;
            border-color: #622faa;
          }
          .chart-option-active {
            background: #622faa;
            color: white;
            border-color: #622faa;
          }
        </style>

        <!-- Loading Indicator -->
        <div id="chartLoadingIndicator" style="display: none; text-align: center; padding: 40px 20px;">
          <div style="display: inline-block; width: 40px; height: 40px; border: 4px solid #f3f3f3; border-top: 4px solid #622faa; border-radius: 50%; animation: spin 1s linear infinite;"></div>
          <p style="color: #888; margin-top: 10px;">Loading chart...</p>
        </div>

        <!-- Chart Container -->
        <div class="view-chart-container" id="chartContainer" style="display: none;">
          <canvas id="priceChart"></canvas>
        </div>
      </div>

      <!-- Transactions Section -->
      <div class="card view-transactions-card">
        <h3 class="view-transactions-title">
          <i class="fas fa-history"></i><?php echo $current['symbol']; ?> Transaction History
        </h3>

        <!-- Desktop Table View -->
        <div class="view-transactions-desktop" style="overflow-x: auto;">
          <table class="view-transactions-table">
            <thead>
              <tr>
                <th>Type</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if (!empty($userTransactions)) {
                    foreach ($userTransactions as $transaction) {
                        $isDeposit = $transaction['type'] === 'deposit';
                        $typeIcon = $isDeposit ? 'fa-plus-circle text-success' : 'fa-minus-circle text-danger';
                        $typeLabel = $isDeposit ? 'Deposit' : 'Withdrawal';
                        $amount = number_format($transaction['amount'], 8);
                        $status = htmlspecialchars($transaction['status']);
                        $date = date('M d, Y H:i', strtotime($transaction['date']));
                        
                        echo '
                        <tr>
                            <td><i class="fas '.$typeIcon.'"></i> '.$typeLabel.'</td>
                            <td><strong>'.$amount.' '.$current['symbol'].'</strong></td>
                            <td><span class="transaction-status-badge" style="padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: 600; '.($isDeposit ? 'background: #e8f5e9; color: #2e7d32;' : 'background: #ffebee; color: #c62828;').'">'.ucfirst($status).'</span></td>
                            <td><small>'.$date.'</small></td>
                        </tr>';
                    }
                } else {
                    echo '
                    <tr>
                        <td colspan="4" class="view-transactions-empty">
                            <i class="fas fa-inbox"></i> No '.$current['symbol'].' transactions yet
                        </td>
                    </tr>';
                }
              ?>
            </tbody>
          </table>
        </div>

        <!-- Mobile Card View -->
        <div class="view-transactions-mobile">
          <?php
            if (!empty($userTransactions)) {
                foreach ($userTransactions as $transaction) {
                    $isDeposit = $transaction['type'] === 'deposit';
                    $typeIcon = $isDeposit ? 'fa-plus-circle' : 'fa-minus-circle';
                    $typeColor = $isDeposit ? '#4caf50' : '#f44336';
                    $typeLabel = $isDeposit ? 'Deposit' : 'Withdrawal';
                    $amount = number_format($transaction['amount'], 8);
                    $status = htmlspecialchars($transaction['status']);
                    $date = date('M d, Y H:i', strtotime($transaction['date']));
                    
                    echo '
                    <div class="transaction-card-mobile">
                        <div class="transaction-card-header">
                            <div class="transaction-card-type">
                                <i class="fas '.$typeIcon.'" style="color: '.$typeColor.'; font-size: 18px;"></i>
                                <span class="transaction-label">'.$typeLabel.'</span>
                            </div>
                            <div class="transaction-card-amount">
                                <strong style="color: '.$typeColor.'; font-size: 16px;">'.$amount.'</strong>
                                <small style="display: block; color: #999;">'.$current['symbol'].'</small>
                            </div>
                        </div>
                        <div class="transaction-card-footer">
                            <span class="transaction-status-badge-mobile" style="background: '.($isDeposit ? '#e8f5e9' : '#ffebee').'; color: '.($isDeposit ? '#2e7d32' : '#c62828').';">'.ucfirst($status).'</span>
                            <small style="color: #999;">'.$date.'</small>
                        </div>
                    </div>';
                }
            } else {
                echo '
                <div style="text-align: center; padding: 30px 20px; color: #999;">
                    <i class="fas fa-inbox" style="font-size: 32px; margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                    <p>No '.$current['symbol'].' transactions yet</p>
                </div>';
            }
          ?>
        </div>
      </div>

    </section>
  </main>

  <!-- Footer Component -->
  <?php include 'includes/footer.php'; ?>

  <!-- QR Code Library (for future use) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

  <!-- Chart.js Library -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

  <!-- Dashboard Scripts -->
  <script src="js/script.js"></script>

</body>
</html>

</body>
</html>
