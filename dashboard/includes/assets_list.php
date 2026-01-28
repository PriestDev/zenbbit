<!-- Holdings/Assets List Component -->
<section style="padding: 0 0 4rem 0; margin-top: 0;">
    <style>
        /* ============================================================
           ASSETS LIST - RESPONSIVE STYLING WITH DAY/NIGHT SUPPORT
           ============================================================ */

        /* CSS Variables for Theme Support */
        /* DEFAULT: LIGHT MODE */
        :root,
        body.light-mode {
            /* Background Gradients */
            --asset-bg: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            --asset-hover-bg: linear-gradient(135deg, #f8f9fa 0%, #f0f2f5 100%);
            
            /* Text Colors */
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            
            /* Borders & Backgrounds */
            --border-color: #e5e7eb;
            --icon-bg: #f3f4f6;
            --icon-border: #d1d5db;
            
            /* Brand Colors */
            --brand-color: #622faa;
            --brand-light: rgba(98, 47, 170, 0.1);
            --brand-dark: rgba(98, 47, 170, 0.2);
            --brand-shadow: rgba(98, 47, 170, 0.12);
            
            /* Status Colors */
            --success-color: #10b981;
            --success-light: rgba(16, 185, 129, 0.1);
            --error-color: #ef4444;
            --error-light: rgba(239, 68, 68, 0.1);
        }

        /* DARK MODE: Override when body doesn't have light-mode class */
        body:not(.light-mode) {
            --asset-bg: linear-gradient(135deg, #1f2937 0%, #111827 100%) !important;
            --asset-hover-bg: linear-gradient(135deg, #374151 0%, #1f2937 100%) !important;
            --text-primary: #f3f4f6 !important;
            --text-secondary: #d1d5db !important;
            --border-color: #374151 !important;
            --icon-bg: #374151 !important;
            --icon-border: #4b5563 !important;
            --brand-light: rgba(98, 47, 170, 0.2) !important;
            --brand-dark: rgba(98, 47, 170, 0.3) !important;
            --success-light: rgba(16, 185, 129, 0.2) !important;
            --error-light: rgba(239, 68, 68, 0.2) !important;
        }

        /* ========== CONTAINER & HEADER ========== */
        .list {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
            padding: 20px 16px 0 16px;
            transition: all 0.3s ease;
        }

        .list h2 {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-primary);
            margin: 0 0 24px 0;
            padding: 0 0;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .list h2::before {
            content: '';
            width: 4px;
            height: 28px;
            background: var(--brand-color);
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .list:hover h2::before {
            height: 32px;
        }

        /* ========== ASSET CARD STYLING ========== */
        .list .asset {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 18px 20px;
            margin-bottom: 14px;
            background: var(--asset-bg);
            border: 2px solid var(--border-color);
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04), 
                        inset 0 1px 0 rgba(255, 255, 255, 0.5);
            position: relative;
            overflow: hidden;
        }

        .list .asset::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s ease;
            pointer-events: none;
        }

        .list .asset:hover::before {
            left: 100%;
        }

        .list .asset:hover {
            background: var(--asset-hover-bg);
            border-color: var(--brand-color);
            box-shadow: 0 12px 24px var(--brand-shadow),
                        inset 0 1px 0 rgba(255, 255, 255, 0.5);
            transform: translateY(-4px);
        }

        .list .asset:active {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px var(--brand-shadow),
                        inset 0 1px 0 rgba(255, 255, 255, 0.5);
        }

        /* ========== ICON STYLING ========== */
        .list .asset .icon {
            flex-shrink: 0;
            width: 56px;
            height: 56px;
            background: var(--icon-bg);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 2px solid var(--icon-border);
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
            position: relative;
        }

        .list .asset .icon::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.3), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .list .asset:hover .icon {
            border-color: var(--brand-color);
            box-shadow: 0 6px 14px var(--brand-shadow),
                        inset 0 1px 0 rgba(255, 255, 255, 0.3);
            transform: scale(1.05) rotate(2deg);
        }

        .list .asset:hover .icon::after {
            opacity: 1;
        }

        .list .asset .icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .list .asset:hover .icon img {
            transform: scale(1.08);
        }

        /* ========== META INFORMATION ========== */
        .list .asset .meta {
            flex: 1;
            min-width: 0;
        }

        .list .asset .meta .name {
            font-size: 16px;
            font-weight: 800;
            letter-spacing: -0.3px;
            color: var(--text-primary);
            margin: 0 0 6px 0;
            transition: all 0.3s ease;
        }

        .list .asset:hover .meta .name {
            color: var(--brand-color);
        }

        .list .asset .meta .small {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
            transition: color 0.3s ease;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .list .asset .meta .small .crypto-price {
            color: var(--brand-color);
            font-weight: 700;
            font-size: 14px;
        }

        /* ========== ASSET RIGHT (PRICE & CHANGE) ========== */
        .list .asset .asset-right {
            flex-shrink: 0;
            text-align: right;
            min-width: 110px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            align-items: flex-end;
        }

        .list .asset .asset-right .price {
            font-size: 16px;
            font-weight: 800;
            letter-spacing: -0.3px;
            color: var(--text-primary);
            transition: all 0.3s ease;
            line-height: 1;
        }

        .list .asset:hover .asset-right .price {
            color: var(--brand-color);
            font-size: 17px;
        }

        .list .asset .asset-right .crypto-change {
            font-size: 12px;
            font-weight: 700;
            padding: 8px 12px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 1px solid;
            backdrop-filter: blur(10px);
        }

        .list .asset .asset-right .crypto-change.positive {
            color: var(--success-color);
            background: var(--success-light);
            border-color: rgba(16, 185, 129, 0.3);
        }

        .list .asset .asset-right .crypto-change.positive:hover {
            background: rgba(16, 185, 129, 0.2);
            border-color: var(--success-color);
        }

        .list .asset .asset-right .crypto-change.negative {
            color: var(--error-color);
            background: var(--error-light);
            border-color: rgba(239, 68, 68, 0.3);
        }

        .list .asset .asset-right .crypto-change.negative:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: var(--error-color);
        }

        /* ========== TABLET RESPONSIVE (768px - 1024px) ========== */
        @media (max-width: 1024px) and (min-width: 769px) {
            .list h2 {
                font-size: 24px;
                margin-bottom: 22px;
                padding: 0 12px;
            }

            .list .asset {
                padding: 16px 18px;
                margin-bottom: 12px;
                gap: 14px;
            }

            .list .asset .icon {
                width: 52px;
                height: 52px;
            }

            .list .asset .meta .name {
                font-size: 15px;
            }

            .list .asset .meta .small {
                font-size: 12px;
            }

            .list .asset .asset-right {
                min-width: 100px;
            }

            .list .asset .asset-right .price {
                font-size: 15px;
            }

            .list .asset .asset-right .crypto-change {
                font-size: 11px;
                padding: 7px 10px;
            }
        }

        /* ========== MEDIUM TABLET (768px) ========== */
        @media (max-width: 768px) {
            .list h2 {
                font-size: 22px;
                margin-bottom: 20px;
                padding: 0 12px;
            }

            .list h2::before {
                width: 3px;
                height: 22px;
            }

            .list .asset {
                padding: 15px 16px;
                margin-bottom: 11px;
                gap: 13px;
                border-radius: 12px;
            }

            .list .asset .icon {
                width: 48px;
                height: 48px;
            }

            .list .asset .meta .name {
                font-size: 14px;
            }

            .list .asset .meta .small {
                font-size: 12px;
            }

            .list .asset .asset-right {
                min-width: 95px;
            }

            .list .asset .asset-right .price {
                font-size: 14px;
            }

            .list .asset .asset-right .crypto-change {
                font-size: 10px;
                padding: 6px 9px;
            }
        }

        /* ========== SMALL MOBILE (480px - 767px) ========== */
        @media (max-width: 767px) and (min-width: 481px) {
            .list h2 {
                font-size: 20px;
                margin-bottom: 18px;
                padding: 0 10px;
            }

            .list h2::before {
                height: 20px;
            }

            .list .asset {
                padding: 13px 14px;
                margin-bottom: 10px;
                gap: 11px;
                border-radius: 11px;
            }

            .list .asset .icon {
                width: 44px;
                height: 44px;
            }

            .list .asset .meta .name {
                font-size: 13px;
            }

            .list .asset .meta .small {
                font-size: 11px;
                gap: 1px;
            }

            .list .asset .asset-right {
                min-width: 85px;
            }

            .list .asset .asset-right .price {
                font-size: 13px;
            }

            .list .asset .asset-right .crypto-change {
                font-size: 9px;
                padding: 5px 8px;
            }
        }

        /* ========== EXTRA SMALL MOBILE (< 480px) ========== */
        @media (max-width: 480px) {
            .list h2 {
                font-size: 18px;
                margin-bottom: 16px;
                padding: 0 8px;
            }

            .list h2::before {
                width: 3px;
                height: 18px;
            }

            .list .asset {
                padding: 12px 12px;
                margin-bottom: 9px;
                gap: 10px;
                border-radius: 10px;
            }

            .list .asset:hover {
                transform: translateY(-2px);
            }

            .list .asset .icon {
                width: 40px;
                height: 40px;
                min-width: 40px;
                border-radius: 10px;
            }

            .list .asset .meta {
                min-width: 0;
            }

            .list .asset .meta .name {
                font-size: 13px;
                margin-bottom: 3px;
            }

            .list .asset .meta .small {
                font-size: 10px;
                gap: 1px;
            }

            .list .asset .asset-right {
                min-width: 70px;
                gap: 4px;
            }

            .list .asset .asset-right .price {
                font-size: 12px;
            }

            .list .asset .asset-right .crypto-change {
                font-size: 9px;
                padding: 4px 7px;
                border-radius: 6px;
            }
        }

        /* ========== ULTRA SMALL MOBILE (< 360px) ========== */
        @media (max-width: 360px) {
            .list h2 {
                font-size: 16px;
                margin-bottom: 14px;
                padding: 0 6px;
            }

            .list .asset {
                padding: 10px 10px;
                margin-bottom: 8px;
                gap: 8px;
            }

            .list .asset .icon {
                width: 36px;
                height: 36px;
            }

            .list .asset .meta .name {
                font-size: 12px;
            }

            .list .asset .meta .small {
                font-size: 9px;
            }

            .list .asset .asset-right {
                min-width: 60px;
            }

            .list .asset .asset-right .price {
                font-size: 11px;
            }

            .list .asset .asset-right .crypto-change {
                font-size: 8px;
                padding: 3px 5px;
            }
        }

        /* ========== ANIMATIONS & TRANSITIONS ========== */
        @media (prefers-reduced-motion: no-preference) {
            .list .asset {
                animation: fadeInSlideUp 0.5s ease-out backwards;
            }

            .list .asset:nth-child(1) { animation-delay: 0.05s; }
            .list .asset:nth-child(2) { animation-delay: 0.1s; }
            .list .asset:nth-child(3) { animation-delay: 0.15s; }
            .list .asset:nth-child(4) { animation-delay: 0.2s; }
            .list .asset:nth-child(5) { animation-delay: 0.25s; }
            .list .asset:nth-child(6) { animation-delay: 0.3s; }
            .list .asset:nth-child(7) { animation-delay: 0.35s; }
            .list .asset:nth-child(8) { animation-delay: 0.4s; }
            .list .asset:nth-child(9) { animation-delay: 0.45s; }

            @keyframes fadeInSlideUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                    filter: blur(2px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                    filter: blur(0);
                }
            }
        }

        /* ========== ACCESSIBILITY & TOUCH ========== */
        @media (hover: none) and (pointer: coarse) {
            .list .asset {
                padding: 16px 18px;
            }

            .list .asset .icon {
                width: 52px;
                height: 52px;
            }

            .list .asset:active {
                transform: translateY(-2px);
            }
        }

        /* ========== LANDSCAPE MODE ========== */
        @media (max-height: 600px) and (orientation: landscape) {
            .list h2 {
                margin-bottom: 14px;
                font-size: 20px;
            }

            .list .asset {
                padding: 12px 14px;
                margin-bottom: 8px;
            }

            .list .asset .icon {
                width: 40px;
                height: 40px;
            }
        }

        /* ========== PRINT STYLES ========== */
        @media print {
            .list .asset {
                page-break-inside: avoid;
                box-shadow: none;
            }

            .list .asset:hover {
                transform: none;
            }
        }
    </style>
    <div class="list">
        <h2>Holding</h2>

        <?php
        // Get user's crypto balances from database
        $balances = [
            'btc_balance' => 0,
            'eth_balance' => 0,
            'bnb_balance' => 0,
            'trx_balance' => 0,
            'sol_balance' => 0,
            'xrp_balance' => 0,
            'avax_balance' => 0,
            'erc_balance' => 0,
            'trc_balance' => 0
        ];

        // Initialize prices array with default 0 values
        $prices = [
            'btc_price' => 0,
            'eth_price' => 0,
            'bnb_price' => 0,
            'trx_price' => 0,
            'sol_price' => 0,
            'xrp_price' => 0,
            'avax_price' => 0,
            'erc_price' => 0,
            'trc_price' => 0
        ];

        // Fetch live prices from CoinGecko API
        try {
            $crypto_ids = 'bitcoin,ethereum,binancecoin,tron,solana,ripple,avalanche-2,tether';
            $price_url = "https://api.coingecko.com/api/v3/simple/price?ids=" . urlencode($crypto_ids) . "&vs_currencies=usd&include_market_cap=false";
            
            // Use file_get_contents with stream context for timeout
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
                
                if ($price_data && is_array($price_data)) {
                    // Map CoinGecko IDs to our price keys
                    $prices['btc_price'] = (float)($price_data['bitcoin']['usd'] ?? 0);
                    $prices['eth_price'] = (float)($price_data['ethereum']['usd'] ?? 0);
                    $prices['bnb_price'] = (float)($price_data['binancecoin']['usd'] ?? 0);
                    $prices['trx_price'] = (float)($price_data['tron']['usd'] ?? 0);
                    $prices['sol_price'] = (float)($price_data['solana']['usd'] ?? 0);
                    $prices['xrp_price'] = (float)($price_data['ripple']['usd'] ?? 0);
                    $prices['avax_price'] = (float)($price_data['avalanche-2']['usd'] ?? 0);
                    // USDT price is always approximately $1
                    $prices['erc_price'] = (float)($price_data['tether']['usd'] ?? 1);
                    $prices['trc_price'] = (float)($price_data['tether']['usd'] ?? 1);
                }
            }
        } catch (Exception $e) {
            error_log("CoinGecko API error: " . $e->getMessage());
        }

        // Fetch balances from database if user is logged in
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            $user_acct_id = $_SESSION['user_id'];
            
            // Query to fetch balances only (prices are not stored in database)
            $stmt = $conn->prepare(
                "SELECT btc_balance, eth_balance, bnb_balance, trx_balance, sol_balance, xrp_balance, avax_balance, erc_balance, trc_balance
                 FROM user WHERE acct_id = ?"
            );
            
            if ($stmt) {
                $stmt->bind_param("s", $user_acct_id);
                
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    $db_balances = $result->fetch_assoc();
                    
                    // Merge database balances with actual database values
                    if ($db_balances && is_array($db_balances)) {
                        // Directly merge all fetched values (including 0s and non-null values)
                        foreach ($db_balances as $key => $value) {
                            if (isset($balances[$key]) && $value !== null) {
                                $balances[$key] = floatval($value);
                            }
                        }
                    }
                } else {
                    error_log("Balance fetch error: " . $stmt->error);
                }
                $stmt->close();
            } else {
                error_log("Balance statement error: " . $conn->error);
            }
        }
        
        // Ensure all balance values are numeric and properly formatted
        foreach ($balances as $key => $value) {
            $balances[$key] = floatval($balances[$key] ?? 0);
        }
        
        // Ensure all price values are numeric
        foreach ($prices as $key => $value) {
            $prices[$key] = floatval($prices[$key] ?? 0);
        }
        ?>

        <!-- Bitcoin -->
        <div class="asset" data-crypto="BTC" onclick="window.location='view.php?coin=btc'">
            <div class="icon"><img src="uploads/1758392283_Bitcoin.png" alt="Bitcoin"></div>
            <div class="meta">
                <div class="name">BTC</div>
                <div class="small">
                    <span class="crypto-price">$<?= number_format($prices['btc_price'] ?? 0, 2); ?></span> / BTC<br>
                    <?= number_format($balances['btc_balance'] ?? 0, 8); ?> BTC
                </div>
            </div>
            <div class="asset-right">
                <div class="price">$<?= number_format(($balances['btc_balance'] ?? 0) * ($prices['btc_price'] ?? 0), 2); ?></div>
                <div class="crypto-change positive">0%</div>
            </div>
        </div>

        <!-- Binance Coin -->
        <div class="asset" data-crypto="BNB" onclick="window.location='view.php?coin=bnb'">
            <div class="icon"><img src="uploads/1758392904_bnb-binance.PNG" alt="BNB"></div>
            <div class="meta">
                <div class="name">BNB</div>
                <div class="small">
                    <span class="crypto-price">$<?= number_format($prices['bnb_price'] ?? 0, 2); ?></span> / BNB<br>
                    <?= number_format($balances['bnb_balance'] ?? 0, 8); ?> BNB
                </div>
            </div>
            <div class="asset-right">
                <div class="price">$<?= number_format(($balances['bnb_balance'] ?? 0) * ($prices['bnb_price'] ?? 0), 2); ?></div>
                <div class="crypto-change positive">0%</div>
            </div>
        </div>

        <!-- Ethereum -->
        <div class="asset" data-crypto="ETH" onclick="window.location='view.php?coin=eth'">
            <div class="icon"><img src="uploads/1758393392_eth.png" alt="Ethereum"></div>
            <div class="meta">
                <div class="name">ETH</div>
                <div class="small">
                    <span class="crypto-price">$<?= number_format($prices['eth_price'] ?? 0, 2); ?></span> / ETH<br>
                    <?= number_format($balances['eth_balance'] ?? 0, 8); ?> ETH
                </div>
            </div>
            <div class="asset-right">
                <div class="price">$<?= number_format(($balances['eth_balance'] ?? 0) * ($prices['eth_price'] ?? 0), 2); ?></div>
                <div class="crypto-change positive">0%</div>
            </div>
        </div>

        <!-- TRON -->
        <div class="asset" data-crypto="TRX" onclick="window.location='view.php?coin=trx'">
            <div class="icon"><img src="uploads/1758393351_trx2.png" alt="TRON"></div>
            <div class="meta">
                <div class="name">TRX</div>
                <div class="small">
                    <span class="crypto-price">$<?= number_format($prices['trx_price'] ?? 0, 2); ?></span> / TRX<br>
                    <?= number_format($balances['trx_balance'] ?? 0, 8); ?> TRX
                </div>
            </div>
            <div class="asset-right">
                <div class="price">$<?= number_format(($balances['trx_balance'] ?? 0) * ($prices['trx_price'] ?? 0), 2); ?></div>
                <div class="crypto-change positive">0%</div>
            </div>
        </div>

        <!-- USDT ERC-20 -->
        <div class="asset" data-crypto="USDT" onclick="window.location='view.php?coin=erc'">
            <div class="icon"><img src="uploads/1759140395_tether.png" alt="USDT"></div>
            <div class="meta">
                <div class="name">USDT (ERC-20)</div>
                <div class="small">
                    <span class="crypto-price">$<?= number_format($prices['erc_price'] ?? 0, 2); ?></span> / USDT (ERC-20)<br>
                    <?= number_format($balances['erc_balance'] ?? 0, 8); ?> USDT (ERC-20)
                </div>
            </div>
            <div class="asset-right">
                <div class="price">$<?= number_format(($balances['erc_balance'] ?? 0) * ($prices['erc_price'] ?? 0), 2); ?></div>
                <div class="crypto-change positive">0%</div>
            </div>
        </div>

        <!-- Solana -->
        <div class="asset" data-crypto="SOL" onclick="window.location='view.php?coin=sol'">
            <div class="icon"><img src="uploads/1759140771_Solana.png" alt="Solana"></div>
            <div class="meta">
                <div class="name">SOL</div>
                <div class="small">
                    <span class="crypto-price">$<?= number_format($prices['sol_price'] ?? 0, 2); ?></span> / SOL<br>
                    <?= number_format($balances['sol_balance'] ?? 0, 8); ?> SOL
                </div>
            </div>
            <div class="asset-right">
                <div class="price">$<?= number_format(($balances['sol_balance'] ?? 0) * ($prices['sol_price'] ?? 0), 2); ?></div>
                <div class="crypto-change positive">0%</div>
            </div>
        </div>

        <!-- Ripple -->
        <div class="asset" data-crypto="XRP" onclick="window.location='view.php?coin=xrp'">
            <div class="icon"><img src="uploads/1759141201_xrp.png" alt="XRP"></div>
            <div class="meta">
                <div class="name">XRP</div>
                <div class="small">
                    <span class="crypto-price">$<?= number_format($prices['xrp_price'] ?? 0, 2); ?></span> / XRP<br>
                    <?= number_format($balances['xrp_balance'] ?? 0, 8); ?> XRP
                </div>
            </div>
            <div class="asset-right">
                <div class="price">$<?= number_format(($balances['xrp_balance'] ?? 0) * ($prices['xrp_price'] ?? 0), 2); ?></div>
                <div class="crypto-change positive">0%</div>
            </div>
        </div>

        <!-- Avalanche -->
        <div class="asset" data-crypto="AVAX" onclick="window.location='view.php?coin=avax'">
            <div class="icon"><img src="uploads/1759141105_av.jpeg" alt="AVAX"></div>
            <div class="meta">
                <div class="name">AVAX</div>
                <div class="small">
                    <span class="crypto-price">$<?= number_format($prices['avax_price'] ?? 0, 2); ?></span> / AVAX<br>
                    <?= number_format($balances['avax_balance'] ?? 0, 8); ?> AVAX
                </div>
            </div>
            <div class="asset-right">
                <div class="price">$<?= number_format(($balances['avax_balance'] ?? 0) * ($prices['avax_price'] ?? 0), 2); ?></div>
                <div class="crypto-change positive">0%</div>
            </div>
        </div>

        <!-- USDT TRC-20 -->
        <div class="asset" data-crypto="USDT" onclick="window.location='view.php?coin=trc'">
            <div class="icon"><img src="uploads/1759331218_tether.png" alt="USDT TRC-20"></div>
            <div class="meta">
                <div class="name">USDT (TRC-20)</div>
                <div class="small">
                    <span class="crypto-price">$<?= number_format($prices['trc_price'] ?? 0, 2); ?></span> / USDT (TRC-20)<br>
                    <?= number_format($balances['trc_balance'] ?? 0, 8); ?> USDT (TRC-20)
                </div>
            </div>
            <div class="asset-right">
                <div class="price">$<?= number_format(($balances['trc_balance'] ?? 0) * ($prices['trc_price'] ?? 0), 2); ?></div>
                <div class="crypto-change positive">0%</div>
            </div>
        </div>
    </div>
</section>
