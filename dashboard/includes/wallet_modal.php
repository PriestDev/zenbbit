<!-- Wallet Modal Component -->
<div id="walletModal" class="wallet-modal-overlay">
    <div class="wallet-modal-wrapper">
        <div class="wallet-modal-header">
            <div class="wallet-modal-header-content">
                <h2 id="modalTitle" class="wallet-modal-title">Select Coin</h2>
                <p class="wallet-modal-subtitle">Choose a cryptocurrency to proceed</p>
            </div>
            <button class="wallet-modal-close-btn" onclick="closeModal()" title="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="wallet-modal-body">
            <div class="wallet-coins-container">
                <div class="wallet-coins-section-title">CRYPTOCURRENCIES</div>

                <!-- Bitcoin -->
                <div class="wallet-coin-item" onclick="navigateToCoin('btc', 5)">
                    <div class="wallet-coin-icon">
                        <img src="uploads/1758392283_Bitcoin.png" alt="Bitcoin">
                    </div>
                    <div class="wallet-coin-info">
                        <div class="wallet-coin-name">BTC</div>
                        <div class="wallet-coin-description" id="btc-small">Loading...</div>
                    </div>
                    <div class="wallet-coin-price-section">
                        <div class="wallet-coin-price" id="btc-price">$0.00</div>
                        <div class="wallet-coin-change positive" id="btc-change">0%</div>
                    </div>
                </div>

                <!-- Ethereum -->
                <div class="wallet-coin-item" onclick="navigateToCoin('eth', 8)">
                    <div class="wallet-coin-icon">
                        <img src="uploads/1758393392_eth.png" alt="Ethereum">
                    </div>
                    <div class="wallet-coin-info">
                        <div class="wallet-coin-name">ETH</div>
                        <div class="wallet-coin-description" id="eth-small">Loading...</div>
                    </div>
                    <div class="wallet-coin-price-section">
                        <div class="wallet-coin-price" id="eth-price">$0.00</div>
                        <div class="wallet-coin-change positive" id="eth-change">0%</div>
                    </div>
                </div>

                <!-- Binance Coin -->
                <div class="wallet-coin-item" onclick="navigateToCoin('bnb', 6)">
                    <div class="wallet-coin-icon">
                        <img src="uploads/1758392904_bnb-binance.PNG" alt="BNB">
                    </div>
                    <div class="wallet-coin-info">
                        <div class="wallet-coin-name">BNB</div>
                        <div class="wallet-coin-description" id="bnb-small">Loading...</div>
                    </div>
                    <div class="wallet-coin-price-section">
                        <div class="wallet-coin-price" id="bnb-price">$0.00</div>
                        <div class="wallet-coin-change positive" id="bnb-change">0%</div>
                    </div>
                </div>

                <!-- TRON -->
                <div class="wallet-coin-item" onclick="navigateToCoin('trx', 9)">
                    <div class="wallet-coin-icon">
                        <img src="uploads/1758393351_trx2.png" alt="TRON">
                    </div>
                    <div class="wallet-coin-info">
                        <div class="wallet-coin-name">TRX</div>
                        <div class="wallet-coin-description" id="trx-small">Loading...</div>
                    </div>
                    <div class="wallet-coin-price-section">
                        <div class="wallet-coin-price" id="trx-price">$0.00</div>
                        <div class="wallet-coin-change positive" id="trx-change">0%</div>
                    </div>
                </div>

                <!-- Solana -->
                <div class="wallet-coin-item" onclick="navigateToCoin('sol', 15)">
                    <div class="wallet-coin-icon">
                        <img src="uploads/1759140771_Solana.png" alt="Solana">
                    </div>
                    <div class="wallet-coin-info">
                        <div class="wallet-coin-name">SOL</div>
                        <div class="wallet-coin-description" id="sol-small">Loading...</div>
                    </div>
                    <div class="wallet-coin-price-section">
                        <div class="wallet-coin-price" id="sol-price">$0.00</div>
                        <div class="wallet-coin-change positive" id="sol-change">0%</div>
                    </div>
                </div>

                <!-- Ripple -->
                <div class="wallet-coin-item" onclick="navigateToCoin('xrp', 16)">
                    <div class="wallet-coin-icon">
                        <img src="uploads/1759141201_xrp.png" alt="XRP">
                    </div>
                    <div class="wallet-coin-info">
                        <div class="wallet-coin-name">XRP</div>
                        <div class="wallet-coin-description" id="xrp-small">Loading...</div>
                    </div>
                    <div class="wallet-coin-price-section">
                        <div class="wallet-coin-price" id="xrp-price">$0.00</div>
                        <div class="wallet-coin-change positive" id="xrp-change">0%</div>
                    </div>
                </div>

                <!-- Avalanche -->
                <div class="wallet-coin-item" onclick="navigateToCoin('avax', 17)">
                    <div class="wallet-coin-icon">
                        <img src="uploads/1759141105_av.jpeg" alt="AVAX">
                    </div>
                    <div class="wallet-coin-info">
                        <div class="wallet-coin-name">AVAX</div>
                        <div class="wallet-coin-description" id="avax-small">Loading...</div>
                    </div>
                    <div class="wallet-coin-price-section">
                        <div class="wallet-coin-price" id="avax-price">$0.00</div>
                        <div class="wallet-coin-change positive" id="avax-change">0%</div>
                    </div>
                </div>

                <!-- USDT ERC-20 -->
                <div class="wallet-coin-item" onclick="navigateToCoin('erc', 13)">
                    <div class="wallet-coin-icon">
                        <img src="uploads/1759140395_tether.png" alt="USDT">
                    </div>
                    <div class="wallet-coin-info">
                        <div class="wallet-coin-name">USDT (ERC-20)</div>
                        <div class="wallet-coin-description" id="erc-small">Loading...</div>
                    </div>
                    <div class="wallet-coin-price-section">
                        <div class="wallet-coin-price" id="erc-price">$0.00</div>
                        <div class="wallet-coin-change positive" id="erc-change">0%</div>
                    </div>
                </div>

                <!-- USDT TRC-20 -->
                <div class="wallet-coin-item" onclick="navigateToCoin('trc', 18)">
                    <div class="wallet-coin-icon">
                        <img src="uploads/1759331218_tether.png" alt="USDT TRC-20">
                    </div>
                    <div class="wallet-coin-info">
                        <div class="wallet-coin-name">USDT (TRC-20)</div>
                        <div class="wallet-coin-description" id="trc-small">Loading...</div>
                    </div>
                    <div class="wallet-coin-price-section">
                        <div class="wallet-coin-price" id="trc-price">$0.00</div>
                        <div class="wallet-coin-change positive" id="trc-change">0%</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="wallet-modal-footer">
            <button class="wallet-modal-close-bottom" onclick="closeModal()">
                <i class="fas fa-times-circle"></i> Close
            </button>
        </div>
    </div>
</div>

<script>
// Navigate to coin view page
function navigateToCoin(coinType, coinId) {
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
                        changeEl.className = change >= 0 ? 'wallet-coin-change positive' : 'wallet-coin-change negative';
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
