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
        'icon' => 'uploads/1758392283_Bitcoin.png'
    ],
    'bnb' => [
        'label' => 'Binance Coin',
        'symbol' => 'BNB',
        'address' => 'Binance wallet address not configured',
        'icon' => 'uploads/1758392904_bnb-binance.PNG'
    ],
    'eth' => [
        'label' => 'Ethereum',
        'symbol' => 'ETH',
        'address' => ETH,
        'icon' => 'uploads/1758393392_eth.png'
    ],
    'trx' => [
        'label' => 'TRON',
        'symbol' => 'TRX',
        'address' => TRC,
        'icon' => 'uploads/1758393351_trx2.png'
    ],
    'erc' => [
        'label' => 'USDT (ERC20)',
        'symbol' => 'USDT-ERC20',
        'address' => ERC,
        'icon' => 'uploads/1759140395_tether.png'
    ],
    'sol' => [
        'label' => 'Solana',
        'symbol' => 'SOL',
        'address' => 'Solana wallet address not configured',
        'icon' => 'uploads/1759140771_Solana.png'
    ],
    'xrp' => [
        'label' => 'Ripple',
        'symbol' => 'XRP',
        'address' => 'Ripple wallet address not configured',
        'icon' => 'uploads/1759141201_xrp.png'
    ],
    'avax' => [
        'label' => 'Avalanche',
        'symbol' => 'AVAX',
        'address' => 'Avalanche wallet address not configured',
        'icon' => 'uploads/1759141105_av.jpeg'
    ],
    'trc' => [
        'label' => 'USDT (TRC20)',
        'symbol' => 'USDT-TRC20',
        'address' => TRC,
        'icon' => 'uploads/1759331218_tether.png'
    ]
];

// Get current coin data or default to BTC
$current = isset($coinInfo[$coinType]) ? $coinInfo[$coinType] : $coinInfo['btc'];
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
            Balance: <strong>0.000 <?php echo substr($current['symbol'], 0, 3); ?></strong>
          </p>

          <!-- Live Price Display (Blended) -->
          <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(0,0,0,0.1);">
            <p style="color: #888; margin: 0 0 12px 0; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Current Price</p>
            <div style="display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 8px;">
              <h3 id="livePrice" style="margin: 0; color: #622faa; font-size: 28px; font-weight: 700;">$0.00</h3>
              <div id="priceChange" style="display: flex; align-items: center; gap: 6px; padding: 6px 10px; background: #e8f5e9; border-radius: 6px;">
                <i id="changeIcon" class="fas fa-arrow-up" style="color: #4caf50; font-size: 12px;"></i>
                <span id="changePercent" style="color: #4caf50; font-weight: 600; font-size: 12px;">+0.00%</span>
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

        <button type="button" class="view-action-button" onclick="iziToast.info({title: 'Coming Soon', message: 'Send functionality coming soon'})">
          <i class="fas fa-arrow-up"></i> Send
        </button>

        <button type="button" class="view-action-button" onclick="iziToast.info({title: 'Coming Soon', message: 'Buy functionality coming soon'})">
          <i class="fas fa-credit-card"></i> Buy
        </button>
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
          <i class="fas fa-history"></i>Transaction History
        </h3>

        <div style="overflow-x: auto;">
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
              <tr>
                <td colspan="4" class="view-transactions-empty">
                  <i class="fas fa-inbox"></i> No transactions yet
                </td>
              </tr>
            </tbody>
          </table>
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
