<!-- Wallet Modal Component -->
<div id="walletModal" class="modal">
    <div class="modal-content" style="background-color: #0000007c">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h3 id="modalTitle">Select Coin</h3>
        
        <div class="container py-3">
            <div class="crypto-section">CRYPTO</div>

            <!-- Bitcoin -->
            <div class="coin-item" style="cursor: pointer;" onclick="navigateToCoin('btc', 5)">
                <div class="icon">
                    <img src="uploads/1758392283_Bitcoin.png" alt="Bitcoin">
                </div>
                <div class="meta" style="text-align: left;">
                    <div class="name">BTC</div>
                    <div class="small" id="btc-small">
                        Loading price...<br>
                        0.00000 BTC <span style="color:gray;">($0.00)</span>
                    </div>
                </div>
                <div class="asset-right">
                    <div class="price" id="btc-price">$0.00</div>
                    <div class="change positive" id="btc-change">0%</div>
                </div>
            </div>

            <!-- Binance Coin -->
            <div class="coin-item" style="cursor: pointer;" onclick="navigateToCoin('bnb', 6)">
                <div class="icon">
                    <img src="uploads/1758392904_bnb-binance.PNG" alt="BNB">
                </div>
                <div class="meta" style="text-align: left;">
                    <div class="name">BNB</div>
                    <div class="small" id="bnb-small">
                        Loading price...<br>
                        0.00000 BNB <span style="color:gray;">($0.00)</span>
                    </div>
                </div>
                <div class="asset-right">
                    <div class="price" id="bnb-price">$0.00</div>
                    <div class="change positive" id="bnb-change">0%</div>
                </div>
            </div>

            <!-- Ethereum -->
            <div class="coin-item" style="cursor: pointer;" onclick="navigateToCoin('eth', 8)">
                <div class="icon">
                    <img src="uploads/1758393392_eth.png" alt="Ethereum">
                </div>
                <div class="meta" style="text-align: left;">
                    <div class="name">ETH</div>
                    <div class="small" id="eth-small">
                        Loading price...<br>
                        0.00000 ETH <span style="color:gray;">($0.00)</span>
                    </div>
                </div>
                <div class="asset-right">
                    <div class="price" id="eth-price">$0.00</div>
                    <div class="change positive" id="eth-change">0%</div>
                </div>
            </div>

            <!-- TRON -->
            <div class="coin-item" style="cursor: pointer;" onclick="navigateToCoin('trx', 9)">
                <div class="icon">
                    <img src="uploads/1758393351_trx2.png" alt="TRON">
                </div>
                <div class="meta" style="text-align: left;">
                    <div class="name">TRX</div>
                    <div class="small" id="trx-small">
                        Loading price...<br>
                        0.00000 TRX <span style="color:gray;">($0.00)</span>
                    </div>
                </div>
                <div class="asset-right">
                    <div class="price" id="trx-price">$0.00</div>
                    <div class="change positive" id="trx-change">0%</div>
                </div>
            </div>

            <!-- USDT ERC-20 -->
            <div class="coin-item" style="cursor: pointer;" onclick="navigateToCoin('erc', 13)">
                <div class="icon">
                    <img src="uploads/1759140395_tether.png" alt="USDT">
                </div>
                <div class="meta" style="text-align: left;">
                    <div class="name">USDT (ERC-20)</div>
                    <div class="small" id="erc-small">
                        Loading price...<br>
                        0.00000 USDT (ERC-20) <span style="color:gray;">($0.00)</span>
                    </div>
                </div>
                <div class="asset-right">
                    <div class="price" id="erc-price">$0.00</div>
                    <div class="change positive" id="erc-change">0%</div>
                </div>
            </div>

            <!-- Solana -->
            <div class="coin-item" style="cursor: pointer;" onclick="navigateToCoin('sol', 15)">
                <div class="icon">
                    <img src="uploads/1759140771_Solana.png" alt="Solana">
                </div>
                <div class="meta" style="text-align: left;">
                    <div class="name">SOL</div>
                    <div class="small" id="sol-small">
                        Loading price...<br>
                        0.00000 SOL <span style="color:gray;">($0.00)</span>
                    </div>
                </div>
                <div class="asset-right">
                    <div class="price" id="sol-price">$0.00</div>
                    <div class="change positive" id="sol-change">0%</div>
                </div>
            </div>

            <!-- Ripple -->
            <div class="coin-item" style="cursor: pointer;" onclick="navigateToCoin('xrp', 16)">
                <div class="icon">
                    <img src="uploads/1759141201_xrp.png" alt="XRP">
                </div>
                <div class="meta" style="text-align: left;">
                    <div class="name">XRP</div>
                    <div class="small" id="xrp-small">
                        Loading price...<br>
                        0.00000 XRP <span style="color:gray;">($0.00)</span>
                    </div>
                </div>
                <div class="asset-right">
                    <div class="price" id="xrp-price">$0.00</div>
                    <div class="change positive" id="xrp-change">0%</div>
                </div>
            </div>

            <!-- Avalanche -->
            <div class="coin-item" style="cursor: pointer;" onclick="navigateToCoin('avax', 17)">
                <div class="icon">
                    <img src="uploads/1759141105_av.jpeg" alt="AVAX">
                </div>
                <div class="meta" style="text-align: left;">
                    <div class="name">AVAX</div>
                    <div class="small" id="avax-small">
                        Loading price...<br>
                        0.00000 AVAX <span style="color:gray;">($0.00)</span>
                    </div>
                </div>
                <div class="asset-right">
                    <div class="price" id="avax-price">$0.00</div>
                    <div class="change positive" id="avax-change">0%</div>
                </div>
            </div>

            <!-- USDT TRC-20 -->
            <div class="coin-item" style="cursor: pointer;" onclick="navigateToCoin('trc', 18)">
                <div class="icon">
                    <img src="uploads/1759331218_tether.png" alt="USDT TRC-20">
                </div>
                <div class="meta" style="text-align: left;">
                    <div class="name">USDT (TRC-20)</div>
                    <div class="small" id="trc-small">
                        Loading price...<br>
                        0.00000 USDT (TRC-20) <span style="color:gray;">($0.00)</span>
                    </div>
                </div>
                <div class="asset-right">
                    <div class="price" id="trc-price">$0.00</div>
                    <div class="change positive" id="trc-change">0%</div>
                </div>
            </div>
        </div>

        <div class="close-bottom" onclick="closeModal()">Close</div>
    </div>
</div>

<script>
// Navigate to coin view page
function navigateToCoin(coinType, coinId) {
    // Use coin type parameter as primary, fallback to ID
    const url = 'view.php?coin=' + encodeURIComponent(coinType);
    console.log('🔗 Navigating to:', url);
    window.location.href = url;
}

// Load live prices for wallet modal
function loadWalletModalPrices() {
    const coins = ['btc', 'bnb', 'eth', 'trx', 'erc', 'sol', 'xrp', 'avax', 'trc'];
    
    coins.forEach(coin => {
        fetch('api.php?action=price&coin=' + coin)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data) {
                    const price = data.data.usd || 0;
                    const change = data.data.usd_24h_change || 0;
                    const decimals = price < 10 ? 4 : 2;
                    
                    // Update price display
                    const priceEl = document.getElementById(coin + '-price');
                    if (priceEl) {
                        priceEl.textContent = '$' + price.toFixed(decimals);
                    }
                    
                    // Update change display
                    const changeEl = document.getElementById(coin + '-change');
                    if (changeEl) {
                        changeEl.textContent = (change >= 0 ? '+' : '') + change.toFixed(2) + '%';
                        changeEl.className = change >= 0 ? 'change positive' : 'change negative';
                        changeEl.style.color = change >= 0 ? '#4caf50' : '#f44336';
                    }
                }
            })
            .catch(err => console.warn('Could not load price for ' + coin, err));
    });
}

// Load prices when modal is shown
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadWalletModalPrices);
} else {
    loadWalletModalPrices();
}
</script>
