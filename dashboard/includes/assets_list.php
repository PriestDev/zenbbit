<!-- Holdings/Assets List Component -->
<section style="padding: 0 0 4rem 0; margin-top: 0;">
    <style>
        .assets-container { padding: 20px 16px; }
        .assets-container h2 { font-size: 26px; font-weight: 700; margin: 0 0 20px 0; color: #1f2937; }
        body:not(.light-mode) .assets-container h2 { color: #f3f4f6; }
        .asset-item { display:flex; align-items:center; justify-content:space-between; padding:16px; margin-bottom:12px; background:#ffffff; border:1px solid #e5e7eb; border-radius:10px; cursor:pointer; transition:all 0.2s ease; }
        body:not(.light-mode) .asset-item { background:#1f2937; border-color:#374151; }
        .asset-item:hover { border-color:#622faa; box-shadow:0 4px 12px rgba(98,47,170,0.15); transform:translateY(-2px); }
        .asset-left { display:flex; align-items:center; gap:12px; flex:1; }
        .asset-icon { width:48px; height:48px; border-radius:8px; overflow:hidden; background:#f3f4f6; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        body:not(.light-mode) .asset-icon { background:#374151; }
        .asset-icon img { width:100%; height:100%; object-fit:cover; }
        .asset-info h3 { margin:0; font-size:16px; font-weight:600; color:#1f2937; }
        body:not(.light-mode) .asset-info h3 { color:#f3f4f6; }
        .asset-info p { margin:4px 0 0 0; font-size:13px; color:#6b7280; }
        body:not(.light-mode) .asset-info p { color:#d1d5db; }
        .asset-right { text-align:right; flex-shrink:0; }
        .asset-balance { font-size:16px; font-weight:700; color:#1f2937; }
        body:not(.light-mode) .asset-balance { color:#f3f4f6; }
        .asset-symbol { font-size:12px; color:#6b7280; margin-top:4px; }
        body:not(.light-mode) .asset-symbol { color:#d1d5db; }
        @media (max-width:768px) {
            .assets-container { padding:16px 12px; }
            .assets-container h2 { font-size:22px; margin-bottom:16px; }
            .asset-item { padding:14px 12px; margin-bottom:10px; }
            .asset-icon { width:44px; height:44px; }
            .asset-info h3 { font-size:15px; }
            .asset-info p { font-size:12px; }
            .asset-balance { font-size:15px; }
        }
    </style>

    <div class="assets-container">
        <h2>Your Holdings</h2>
        
        <?php
        // Clean implementation: fetch per-asset prices and per-user balances, then render
        // Define assets and mapping to CoinGecko IDs
        $assets_config = [
            ['symbol'=>'BTC','name'=>'Bitcoin','key'=>'btc_balance','coinid'=>'bitcoin','image'=>'uploads/1758392283_Bitcoin.png'],
            ['symbol'=>'ETH','name'=>'Ethereum','key'=>'eth_balance','coinid'=>'ethereum','image'=>'uploads/1758393392_eth.png'],
            ['symbol'=>'BNB','name'=>'Binance Coin','key'=>'bnb_balance','coinid'=>'binancecoin','image'=>'uploads/1758392904_bnb-binance.PNG'],
            ['symbol'=>'TRX','name'=>'TRON','key'=>'trx_balance','coinid'=>'tron','image'=>'uploads/1758393351_trx2.png'],
            ['symbol'=>'SOL','name'=>'Solana','key'=>'sol_balance','coinid'=>'solana','image'=>'uploads/1759140771_Solana.png'],
            ['symbol'=>'XRP','name'=>'Ripple','key'=>'xrp_balance','coinid'=>'ripple','image'=>'uploads/1759141201_xrp.png'],
            ['symbol'=>'AVAX','name'=>'Avalanche','key'=>'avax_balance','coinid'=>'avalanche-2','image'=>'uploads/1759141105_av.jpeg'],
            ['symbol'=>'USDT','name'=>'USDT (ERC-20)','key'=>'erc_balance','coinid'=>'tether','image'=>'uploads/1759140395_tether.png'],
            ['symbol'=>'USDT','name'=>'USDT (TRC-20)','key'=>'trc_balance','coinid'=>'tether','image'=>'uploads/1759331218_tether.png'],
        ];

        // Build unique coin id list for CoinGecko
        $coin_ids = array_unique(array_map(function($a){ return $a['coinid']; }, $assets_config));
        $coin_ids_str = implode(',', $coin_ids);

        // Fetch current prices (USD) and 24h change from CoinGecko
        // We'll store both `usd` and `change` (24h percent) for each coinid
        $prices = [];
        if (!empty($coin_ids_str)) {
            // include 24h change in the response
            $price_url = "https://api.coingecko.com/api/v3/simple/price?ids=" . urlencode($coin_ids_str) . "&vs_currencies=usd&include_24hr_change=true";
            $context = stream_context_create(['http'=>['timeout'=>5,'method'=>'GET','header'=>"User-Agent: Mozilla/5.0\r\n"]]);
            $response = @file_get_contents($price_url, false, $context);
            if ($response !== false) {
                $price_data = json_decode($response, true);
                if (is_array($price_data)) {
                    foreach ($price_data as $cid => $d) {
                        $prices[$cid] = [
                            'usd' => isset($d['usd']) ? floatval($d['usd']) : 0.0,
                            'change' => isset($d['usd_24h_change']) ? floatval($d['usd_24h_change']) : 0.0
                        ];
                    }
                }
            }
        }

        // Prepare lists
        $funded_assets = [];
        $empty_assets = [];

        $user_id = $_SESSION['user_id'] ?? null;
        if ($user_id && isset($conn)) {
            $balance_keys = implode(',', array_map(function($a){ return $a['key']; }, $assets_config));
            $stmt = $conn->prepare("SELECT $balance_keys FROM user WHERE acct_id = ?");
            if ($stmt) {
                $stmt->bind_param('s', $user_id);
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    if ($result && $result->num_rows > 0) {
                        $db_balances = $result->fetch_assoc();
                        foreach ($assets_config as $cfg) {
                            $balance = isset($db_balances[$cfg['key']]) ? floatval($db_balances[$cfg['key']]) : 0.0;
                            $price_info = $prices[$cfg['coinid']] ?? ['usd'=>0.0,'change'=>0.0];
                            $price = floatval($price_info['usd']);
                            $change = floatval($price_info['change']);
                            $usd = $price * $balance;
                            $asset_item = [
                                'symbol'=>$cfg['symbol'],
                                'name'=>$cfg['name'],
                                'balance'=>$balance,
                                'price'=>$price,
                                'change'=>$change,
                                'usd'=>$usd,
                                'image'=>$cfg['image'] ?? 'uploads/default.png'
                            ];
                            if ($balance > 0) $funded_assets[] = $asset_item; else $empty_assets[] = $asset_item;
                        }
                    }
                }
                $stmt->close();
            }
        }

        // Sort funded assets by balance descending
        usort($funded_assets, function($a,$b){ return $b['balance'] <=> $a['balance']; });

        // Render funded assets (show 24h percent change instead of USD total)
        if (count($funded_assets) > 0) {
            foreach ($funded_assets as $asset) {
                $display_name = htmlspecialchars($asset['name']);
                $symbol = htmlspecialchars($asset['symbol']);
                $balance_display = number_format($asset['balance'], 8);
                $price_display = $asset['price'] > 0 ? '$' . number_format($asset['price'], 2) : 'Price N/A';
                $change = isset($asset['change']) ? floatval($asset['change']) : 0.0;
                $change_display = ($change >= 0 ? '+' : '') . number_format($change, 2) . '%';
                $change_color = $change >= 0 ? '#10b981' : '#ef4444';
                $image = htmlspecialchars($asset['image']);
                // compute USD total for this asset (from server-side balance)
                $usd_value = isset($asset['usd']) ? $asset['usd'] : ($asset['price'] * $asset['balance']);
                $usd_display = $usd_value > 0 ? '$' . number_format($usd_value, 2) : '$0.00';

                echo '<div class="asset-item" onclick="window.location=\'view.php?coin=' . urlencode($asset['symbol']) . '\'">'
                    . '<div class="asset-left">'
                        . '<div class="asset-icon"><img src="' . $image . '" alt="' . $display_name . '"></div>'
                        . '<div class="asset-info"><h3>' . $display_name . '</h3>'
                        . '<p>' . $price_display . ' • <span style="color:' . $change_color . '">' . $change_display . '</span></p></div>'
                    . '</div>'
                    . '<div class="asset-right">'
                        . '<div class="asset-balance">' . $balance_display . '</div>'
                        . '<div class="asset-symbol">' . $usd_display . '</div>'
                    . '</div>'
                . '</div>';
            }
        }

        // Render empty assets (faded) — show percent change next to price
        if (count($empty_assets) > 0) {
            foreach ($empty_assets as $asset) {
                $display_name = htmlspecialchars($asset['name']);
                $symbol = htmlspecialchars($asset['symbol']);
                $price_display = $asset['price'] > 0 ? '$' . number_format($asset['price'], 2) : 'Price N/A';
                $change = isset($asset['change']) ? floatval($asset['change']) : 0.0;
                $change_display = ($change >= 0 ? '+' : '') . number_format($change, 2) . '%';
                $change_color = $change >= 0 ? '#10b981' : '#ef4444';
                $image = htmlspecialchars($asset['image']);

                // empty asset: balance is zero
                $balance_display = number_format(0, 8);
                $usd_display = '$0.00';
                echo '<div class="asset-item" style="opacity:0.6;" onclick="window.location=\'view.php?coin=' . urlencode($asset['symbol']) . '\'">'
                    . '<div class="asset-left">'
                        . '<div class="asset-icon"><img src="' . $image . '" alt="' . $display_name . '"></div>'
                        . '<div class="asset-info"><h3>' . $display_name . '</h3>'
                        . '<p>' . $price_display . ' • <span style="color:' . $change_color . '">' . $change_display . '</span></p></div>'
                    . '</div>'
                    . '<div class="asset-right">'
                        . '<div class="asset-balance">' . $balance_display . '</div>'
                        . '<div class="asset-symbol">' . $usd_display . '</div>'
                    . '</div>'
                . '</div>';
            }
        }
        ?>

    </div>
</section>
