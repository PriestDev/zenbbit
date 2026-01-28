<!-- Holdings/Assets List Component -->
<section style="padding-bottom: 4rem;">
    <style>
        /* Assets List Container */
        .list {
            width: 100%;
        }

        .list h2 {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            padding: 0 10px;
        }

        /* Asset Items Container */
        .list .asset {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 16px;
            margin-bottom: 12px;
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .list .asset:hover {
            background: linear-gradient(135deg, #f8f9fa 0%, #f0f2f5 100%);
            border-color: #622faa;
            box-shadow: 0 4px 16px rgba(98, 47, 170, 0.12);
            transform: translateY(-2px);
        }

        /* Asset Icon */
        .list .asset .icon {
            flex-shrink: 0;
            width: 50px;
            height: 50px;
            background: #f5f5f5;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 2px solid #e0e0e0;
        }

        .list .asset .icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Asset Meta (Name and Details) */
        .list .asset .meta {
            flex: 1;
        }

        .list .asset .meta .name {
            font-size: 15px;
            font-weight: 700;
            color: #333;
            margin-bottom: 4px;
        }

        .list .asset .meta .small {
            font-size: 13px;
            color: #888;
            line-height: 1.4;
        }

        .list .asset .meta .small .crypto-price {
            color: #622faa;
            font-weight: 600;
        }

        /* Asset Right (Price and Change) */
        .list .asset .asset-right {
            flex-shrink: 0;
            text-align: right;
            min-width: 100px;
        }

        .list .asset .asset-right .price {
            font-size: 15px;
            font-weight: 700;
            color: #333;
            margin-bottom: 6px;
        }

        .list .asset .asset-right .crypto-change {
            font-size: 12px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 6px;
            display: inline-block;
        }

        .list .asset .asset-right .crypto-change.positive {
            color: #00c985;
            background: rgba(0, 201, 133, 0.1);
        }

        .list .asset .asset-right .crypto-change.negative {
            color: #ff6b6b;
            background: rgba(255, 107, 107, 0.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .list h2 {
                font-size: 20px;
                margin-bottom: 16px;
            }

            .list .asset {
                padding: 14px;
                margin-bottom: 10px;
                gap: 12px;
            }

            .list .asset .icon {
                width: 45px;
                height: 45px;
            }

            .list .asset .meta .name {
                font-size: 14px;
            }

            .list .asset .meta .small {
                font-size: 12px;
            }

            .list .asset .asset-right {
                min-width: 90px;
            }

            .list .asset .asset-right .price {
                font-size: 14px;
            }

            .list .asset .asset-right .crypto-change {
                font-size: 11px;
                padding: 3px 6px;
            }
        }

        @media (max-width: 480px) {
            .list h2 {
                font-size: 18px;
                margin-bottom: 14px;
            }

            .list .asset {
                padding: 12px;
                margin-bottom: 8px;
                gap: 10px;
            }

            .list .asset .icon {
                width: 40px;
                height: 40px;
            }

            .list .asset .meta .name {
                font-size: 13px;
            }

            .list .asset .meta .small {
                font-size: 11px;
            }

            .list .asset .asset-right {
                min-width: 80px;
            }

            .list .asset .asset-right .price {
                font-size: 13px;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .list h2 {
                color: #fff;
            }

            .list .asset {
                background: linear-gradient(135deg, #1e1e1e 0%, #2a2a2a 100%);
                border-color: #333;
            }

            .list .asset:hover {
                background: linear-gradient(135deg, #2a2a2a 0%, #333 100%);
                border-color: #622faa;
            }

            .list .asset .icon {
                background: #333;
                border-color: #444;
            }

            .list .asset .meta .name {
                color: #fff;
            }

            .list .asset .meta .small {
                color: #aaa;
            }

            .list .asset .asset-right .price {
                color: #fff;
            }
        }
    </style>
    <div class="list">
        <h2>Holding</h2>

        <?php
        // Get user's crypto balances
        if (isset($_SESSION['acct_id'])) {
            $user_acct_id = $_SESSION['acct_id'];
            $stmt = $conn->prepare(
                "SELECT btc_balance, eth_balance, bnb_balance, trx_balance, sol_balance, xrp_balance, avax_balance, erc_balance, trc_balance 
                 FROM user WHERE acct_id = ?"
            );
            $stmt->bind_param("s", $user_acct_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $balances = $result->fetch_assoc();
            $stmt->close();
        } else {
            // Default balances if not logged in
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
        }
        ?>

        <!-- Bitcoin -->
        <div class="asset" data-crypto="BTC" onclick="window.location='view.php?coin=btc'">
            <div class="icon"><img src="uploads/1758392283_Bitcoin.png" alt="Bitcoin"></div>
            <div class="meta">
                <div class="name">BTC</div>
                <div class="small">
                    <span class="crypto-price">$0.00</span> / BTC<br>
                    <?= number_format($balances['btc_balance'] ?? 0, 8); ?> BTC
                </div>
            </div>
            <div class="asset-right">
                <div class="price">$0.00</div>
                <div class="crypto-change positive">0%</div>
            </div>
        </div>

        <!-- Binance Coin -->
        <div class="asset" data-crypto="BNB" onclick="window.location='view.php?coin=bnb'">
            <div class="icon"><img src="uploads/1758392904_bnb-binance.PNG" alt="BNB"></div>
            <div class="meta">
                <div class="name">BNB</div>
                <div class="small">
                    <span class="crypto-price">$0.00</span> / BNB<br>
                    <?= number_format($balances['bnb_balance'] ?? 0, 8); ?> BNB
                </div>
            </div>
            <div class="asset-right">
                <div class="price">$0.00</div>
                <div class="crypto-change positive">0%</div>
            </div>
        </div>

        <!-- Ethereum -->
        <div class="asset" data-crypto="ETH" onclick="window.location='view.php?coin=eth'">
            <div class="icon"><img src="uploads/1758393392_eth.png" alt="Ethereum"></div>
            <div class="meta">
                <div class="name">ETH</div>
                <div class="small">
                    <span class="crypto-price">$0.00</span> / ETH<br>
                    <?= number_format($balances['eth_balance'] ?? 0, 8); ?> ETH
                </div>
            </div>
            <div class="asset-right">
                <div class="price">$0.00</div>
                <div class="crypto-change positive">0%</div>
            </div>
        </div>

        <!-- TRON -->
        <div class="asset" data-crypto="TRX" onclick="window.location='view.php?coin=trx'">
            <div class="icon"><img src="uploads/1758393351_trx2.png" alt="TRON"></div>
            <div class="meta">
                <div class="name">TRX</div>
                <div class="small">
                    <span class="crypto-price">$0.00</span> / TRX<br>
                    <?= number_format($balances['trx_balance'] ?? 0, 8); ?> TRX
                </div>
            </div>
            <div class="asset-right">
                <div class="price">$0.00</div>
                <div class="crypto-change positive">0%</div>
            </div>
        </div>

        <!-- USDT ERC-20 -->
        <div class="asset" data-crypto="USDT" onclick="window.location='view.php?coin=erc'">
            <div class="icon"><img src="uploads/1759140395_tether.png" alt="USDT"></div>
            <div class="meta">
                <div class="name">USDT (ERC-20)</div>
                <div class="small">
                    <span class="crypto-price">$0.00</span> / USDT (ERC-20)<br>
                    <?= number_format($balances['erc_balance'] ?? 0, 8); ?> USDT (ERC-20)
                </div>
            </div>
            <div class="asset-right">
                <div class="price">$0.00</div>
                <div class="crypto-change positive">0%</div>
            </div>
        </div>

        <!-- Solana -->
        <div class="asset" data-crypto="SOL" onclick="window.location='view.php?coin=sol'">
            <div class="icon"><img src="uploads/1759140771_Solana.png" alt="Solana"></div>
            <div class="meta">
                <div class="name">SOL</div>
                <div class="small">
                    <span class="crypto-price">$0.00</span> / SOL<br>
                    <?= number_format($balances['sol_balance'] ?? 0, 8); ?> SOL
                </div>
            </div>
            <div class="asset-right">
                <div class="price">$0.00</div>
                <div class="crypto-change positive">0%</div>
            </div>
        </div>

        <!-- Ripple -->
        <div class="asset" data-crypto="XRP" onclick="window.location='view.php?coin=xrp'">
            <div class="icon"><img src="uploads/1759141201_xrp.png" alt="XRP"></div>
            <div class="meta">
                <div class="name">XRP</div>
                <div class="small">
                    <span class="crypto-price">$0.00</span> / XRP<br>
                    <?= number_format($balances['xrp_balance'] ?? 0, 8); ?> XRP
                </div>
            </div>
            <div class="asset-right">
                <div class="price">$0.00</div>
                <div class="crypto-change positive">0%</div>
            </div>
        </div>

        <!-- Avalanche -->
        <div class="asset" data-crypto="AVAX" onclick="window.location='view.php?coin=avax'">
            <div class="icon"><img src="uploads/1759141105_av.jpeg" alt="AVAX"></div>
            <div class="meta">
                <div class="name">AVAX</div>
                <div class="small">
                    <span class="crypto-price">$0.00</span> / AVAX<br>
                    <?= number_format($balances['avax_balance'] ?? 0, 8); ?> AVAX
                </div>
            </div>
            <div class="asset-right">
                <div class="price">$0.00</div>
                <div class="crypto-change positive">0%</div>
            </div>
        </div>

        <!-- USDT TRC-20 -->
        <div class="asset" data-crypto="USDT" onclick="window.location='view.php?coin=trc'">
            <div class="icon"><img src="uploads/1759331218_tether.png" alt="USDT TRC-20"></div>
            <div class="meta">
                <div class="name">USDT (TRC-20)</div>
                <div class="small">
                    <span class="crypto-price">$0.00</span> / USDT (TRC-20)<br>
                    <?= number_format($balances['trc_balance'] ?? 0, 8); ?> USDT (TRC-20)
                </div>
            </div>
            <div class="asset-right">
                <div class="price">$0.00</div>
                <div class="crypto-change positive">0%</div>
            </div>
        </div>
    </div>
</section>
