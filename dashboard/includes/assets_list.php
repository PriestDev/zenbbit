<!-- Holdings/Assets List Component -->
<section style="padding-bottom: 4rem;">
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
