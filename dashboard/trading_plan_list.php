<?php
$pageTitle = 'Trading Plans';
$includeIziToast = true;
include 'includes/head.php';

// Fetch all available plans from database
$plans_query = "SELECT id, name, min, max, per, duration, status FROM plan WHERE status = 1 ORDER BY min ASC";
$plans_result = mysqli_query($conn, $plans_query);
$plans = [];
if ($plans_result && mysqli_num_rows($plans_result) > 0) {
    while ($plan = mysqli_fetch_assoc($plans_result)) {
        $plans[] = $plan;
    }
}

// Fetch user's active trades/plans
$user_id = $_SESSION['user_id'];
$user_esc = mysqli_real_escape_string($conn, $user_id);
$active_trades_query = "SELECT t.id, p.name, t.amount, t.status, t.profit, t.create_date, t.end_date 
                        FROM trade t 
                        JOIN plan p ON p.name = t.pair 
                        WHERE t.user = '$user_esc' AND t.status IN (1, 2) 
                        ORDER BY t.create_date DESC LIMIT 10";
$active_trades_result = mysqli_query($conn, $active_trades_query);
$active_trades = [];
if ($active_trades_result && mysqli_num_rows($active_trades_result) > 0) {
    while ($trade = mysqli_fetch_assoc($active_trades_result)) {
        $active_trades[] = $trade;
    }
}

// Calculate progress percentage for trades
function calculate_progress($create_date, $end_date) {
    $start = strtotime($create_date);
    $end = strtotime($end_date);
    $now = time();
    
    $total = $end - $start;
    $elapsed = $now - $start;
    
    if ($total <= 0) return 0;
    $progress = ($elapsed / $total) * 100;
    return min(100, max(0, $progress));
}

// Get status badge for trade
function get_status_badge($status) {
    if ($status == 1) return '<span class="status-active">● Active</span>';
    if ($status == 2) return '<span class="status-active">● Completed</span>';
    return '<span class="status-inactive">● Pending</span>';
}
?>
<body class="light-mode dashboard-body">

  <!-- Sidebar Component -->
  <?php include 'includes/sidebar.php'; ?>

  <!-- Top Navbar Component -->
  <?php include 'includes/header.php'; ?>

  <section class="hom" style="margin-top:6rem; width:100%;">
    <div class="card">
      <div class="wallet-inf">
        <h2>Trading Plans</h2>
         <p style="color: #aaa; font-size: 13px;">Choose a plan that fits your investment goals</p>
      </div>
    </div>
  </section>

<!-- Plan Purchase Modal -->
<div id="planPurchaseModal" class="modal">
  <div class="modal-content" style="width: 95%; max-width: 500px;">
    <span class="close-btn" onclick="TradingPlansModule.closePlanModal()">&times;</span>
    <h2 style="margin-bottom: 20px;">Purchase Plan</h2>
    
    <form id="purchasePlanForm" method="POST" action="code.php">
      <input type="hidden" name="plan" value="1">
      <input type="hidden" id="planIdInput" name="plan_id" value="">
      <input type="hidden" id="planNameInput" name="plan_name" value="">
      
      <div class="form-group" style="margin-bottom: 15px;">
        <label style="font-weight: 600; color: #fff; display: block; margin-bottom: 8px;">Selected Plan</label>
        <p id="selectedPlanName" style="background: #0d1117; padding: 12px; border-radius: 6px; color: #e0e0e0; margin: 0;">-</p>
      </div>
      
      <div class="form-group" style="margin-bottom: 15px;">
        <label style="font-weight: 600; color: #fff; display: block; margin-bottom: 8px;">Investment Amount</label>
        <input type="number" id="investAmount" name="invest_amount" placeholder="Enter investment amount" 
               step="0.01" min="0" style="width: 100%; padding: 12px; background: #0d1117; border: 1px solid #333; 
               border-radius: 6px; color: #e0e0e0;" required>
        <small id="amountError" style="color: #ff6b6b; display: none; margin-top: 5px;"></small>
        <small id="planMinMax" style="color: #aaa; display: block; margin-top: 5px;"></small>
      </div>
      
      <div class="form-group" style="margin-bottom: 15px;">
        <label style="font-weight: 600; color: #fff; display: block; margin-bottom: 8px;">Funding Source</label>
        <select id="fundingSource" name="gateway_data" style="width: 100%; padding: 12px; background: #0d1117; 
                border: 1px solid #333; border-radius: 6px; color: #e0e0e0;" required>
          <option value="">-- Select Wallet --</option>
          <option value="main">Main Balance: $<?php echo number_format(bal, 2); ?></option>
          <option value="profit">Profit Balance: $<?php echo number_format(profit, 2); ?></option>
          <option value="deposit">Deposit Now</option>
        </select>
      </div>
      
      <div id="balanceWarning" style="background: rgba(255, 107, 107, 0.1); border: 1px solid #ff6b6b; 
           color: #ff6b6b; padding: 12px; border-radius: 6px; margin-bottom: 15px; display: none; font-size: 13px;">
        ⚠️ Insufficient funds in selected wallet
      </div>
      
      <button type="submit" class="btn-primary" id="purchaseBtn" style="width: 100%; padding: 12px; 
              background: linear-gradient(135deg, #622faa 0%, #8c3fca 100%); color: #fff; border: none; 
              border-radius: 6px; cursor: pointer; font-weight: 600;">Purchase Plan</button>
      <button type="button" onclick="TradingPlansModule.closePlanModal()" style="width: 100%; padding: 12px; background: #333; 
              color: #fff; border: none; border-radius: 6px; cursor: pointer; margin-top: 10px;">Cancel</button>
    </form>
  </div>
</div>

<section class="plans-container">
  <?php if (count($plans) > 0): ?>
    <?php foreach ($plans as $plan): ?>
  <!-- Dynamic Trading Plan -->
  <div class="plan-item">
    <div class="plan-header">
      <div style="flex: 1;">
        <div class="plan-name"><?php echo htmlspecialchars($plan['name']); ?> Trading</div>
        <div class="plan-meta">Min: $<?php echo number_format($plan['min'], 0); ?> | ROI: <?php echo $plan['per']; ?>% monthly</div>
      </div>
      <div class="plan-status">
        <?php 
          if ($plan['status'] == 1) {
            echo 'Available';
          } else {
            echo 'Inactive';
          }
        ?>
      </div>
    </div>
    <div class="plan-features">
      <div><i class="fas fa-check"></i> Auto trading enabled</div>
      <div><i class="fas fa-check"></i> Risk management</div>
      <div><i class="fas fa-check"></i> 24/7 monitoring</div>
      <div><i class="fas fa-check"></i> Email support</div>
      <?php if ($plan['max'] > 0): ?>
        <div><i class="fas fa-check"></i> Max: $<?php echo number_format($plan['max'], 0); ?></div>
      <?php else: ?>
        <div><i class="fas fa-check"></i> No maximum limit</div>
      <?php endif; ?>
    </div>
    <div class="plan-buttons">
      <button type="button" class="plan-btn plan-purchase-btn" onclick="TradingPlansModule.openPlanModal(<?php echo $plan['id']; ?>, '<?php echo htmlspecialchars($plan['name']); ?>', <?php echo $plan['min']; ?>, <?php echo $plan['max']; ?>)">
        Purchase
      </button>
      <button type="button" class="plan-btn plan-btn-secondary plan-details-btn" onclick="TradingPlansModule.showPlanDetails('<?php echo htmlspecialchars($plan['name']); ?>', <?php echo $plan['per']; ?>, <?php echo $plan['duration']; ?>)">
        Details
      </button>
    </div>
  </div>
    <?php endforeach; ?>
  <?php else: ?>
  <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #aaa;">
    <p>No trading plans available at this time.</p>
  </div>
  <?php endif; ?>
</section>

<!-- Active Plans Table -->
<section class="active-plans-section">
  <h3>Active Plans</h3>
  <?php if (count($active_trades) > 0): ?>
  <table class="plans-table">
    <thead>
      <tr>
        <th>Plan Name</th>
        <th>Investment</th>
        <th>Status</th>
        <th>Progress</th>
        <th>ROI</th>
        <th>Start Date</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($active_trades as $trade): ?>
      <tr>
        <td><strong><?php echo htmlspecialchars($trade['name']); ?> Trading</strong></td>
        <td>$<?php echo number_format($trade['amount'], 2); ?></td>
        <td><?php echo get_status_badge($trade['status']); ?></td>
        <td>
          <?php 
            $progress = calculate_progress($trade['create_date'], $trade['end_date']);
            $progress_int = (int)$progress;
          ?>
          <div class="progress-bar">
            <div class="progress-fill" style="width: <?php echo $progress_int; ?>%;"></div>
          </div>
          <small style="color: #aaa;"><?php echo $progress_int; ?>% Complete</small>
        </td>
        <td style="color: #00c985; font-weight: 600;">$<?php echo number_format($trade['profit'], 2); ?></td>
        <td><?php echo date('M d, Y', strtotime($trade['create_date'])); ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?>
  <div style="text-align: center; padding: 40px; color: #aaa;">
    <p>No active trading plans yet. Purchase a plan to get started!</p>
  </div>
  <?php endif; ?>
</section>

  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>

<!-- Initialize User Balance for Trading Plans Module -->
<script>
  // Pass user balance data to the Trading Plans module
  window.TPUserBalance = <?php echo json_encode(bal); ?>;
  window.TPUserProfit = <?php echo json_encode(profit); ?>;
</script>

</body>

</html>
