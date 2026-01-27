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
            <div class="wallet-assets-list">
                <!-- Bitcoin -->
                <div class="wallet-asset-row" onclick="navigateToCoin('btc', 5)">
                    <div class="wallet-asset-icon-wrapper">
                        <img src="uploads/1758392283_Bitcoin.png" alt="Bitcoin" class="wallet-asset-icon">
                    </div>
                    <div class="wallet-asset-info">
                        <div class="wallet-asset-name">BTC</div>
                        <div class="wallet-asset-details" id="btc-small">0.00000 BTC</div>
                    </div>
                    <div class="wallet-asset-value">
                        <div class="wallet-asset-price" id="btc-price">$0.00</div>
                        <div class="wallet-asset-change positive" id="btc-change">0%</div>
                    </div>
                </div>

                <!-- Ethereum -->
                <div class="wallet-asset-row" onclick="navigateToCoin('eth', 8)">
                    <div class="wallet-asset-icon-wrapper">
                        <img src="uploads/1758393392_eth.png" alt="Ethereum" class="wallet-asset-icon">
                    </div>
                    <div class="wallet-asset-info">
                        <div class="wallet-asset-name">ETH</div>
                        <div class="wallet-asset-details" id="eth-small">0.00000 ETH</div>
                    </div>
                    <div class="wallet-asset-value">
                        <div class="wallet-asset-price" id="eth-price">$0.00</div>
                        <div class="wallet-asset-change positive" id="eth-change">0%</div>
                    </div>
                </div>

                <!-- Binance Coin -->
                <div class="wallet-asset-row" onclick="navigateToCoin('bnb', 6)">
                    <div class="wallet-asset-icon-wrapper">
                        <img src="uploads/1758392904_bnb-binance.PNG" alt="BNB" class="wallet-asset-icon">
                    </div>
                    <div class="wallet-asset-info">
                        <div class="wallet-asset-name">BNB</div>
                        <div class="wallet-asset-details" id="bnb-small">0.00000 BNB</div>
                    </div>
                    <div class="wallet-asset-value">
                        <div class="wallet-asset-price" id="bnb-price">$0.00</div>
                        <div class="wallet-asset-change positive" id="bnb-change">0%</div>
                    </div>
                </div>

                <!-- TRON -->
                <div class="wallet-asset-row" onclick="navigateToCoin('trx', 9)">
                    <div class="wallet-asset-icon-wrapper">
                        <img src="uploads/1758393351_trx2.png" alt="TRON" class="wallet-asset-icon">
                    </div>
                    <div class="wallet-asset-info">
                        <div class="wallet-asset-name">TRX</div>
                        <div class="wallet-asset-details" id="trx-small">0.00000 TRX</div>
                    </div>
                    <div class="wallet-asset-value">
                        <div class="wallet-asset-price" id="trx-price">$0.00</div>
                        <div class="wallet-asset-change positive" id="trx-change">0%</div>
                    </div>
                </div>

                <!-- Solana -->
                <div class="wallet-asset-row" onclick="navigateToCoin('sol', 15)">
                    <div class="wallet-asset-icon-wrapper">
                        <img src="uploads/1759140771_Solana.png" alt="Solana" class="wallet-asset-icon">
                    </div>
                    <div class="wallet-asset-info">
                        <div class="wallet-asset-name">SOL</div>
                        <div class="wallet-asset-details" id="sol-small">0.00000 SOL</div>
                    </div>
                    <div class="wallet-asset-value">
                        <div class="wallet-asset-price" id="sol-price">$0.00</div>
                        <div class="wallet-asset-change positive" id="sol-change">0%</div>
                    </div>
                </div>

                <!-- Ripple -->
                <div class="wallet-asset-row" onclick="navigateToCoin('xrp', 16)">
                    <div class="wallet-asset-icon-wrapper">
                        <img src="uploads/1759141201_xrp.png" alt="XRP" class="wallet-asset-icon">
                    </div>
                    <div class="wallet-asset-info">
                        <div class="wallet-asset-name">XRP</div>
                        <div class="wallet-asset-details" id="xrp-small">0.00000 XRP</div>
                    </div>
                    <div class="wallet-asset-value">
                        <div class="wallet-asset-price" id="xrp-price">$0.00</div>
                        <div class="wallet-asset-change positive" id="xrp-change">0%</div>
                    </div>
                </div>

                <!-- Avalanche -->
                <div class="wallet-asset-row" onclick="navigateToCoin('avax', 17)">
                    <div class="wallet-asset-icon-wrapper">
                        <img src="uploads/1759141105_av.jpeg" alt="AVAX" class="wallet-asset-icon">
                    </div>
                    <div class="wallet-asset-info">
                        <div class="wallet-asset-name">AVAX</div>
                        <div class="wallet-asset-details" id="avax-small">0.00000 AVAX</div>
                    </div>
                    <div class="wallet-asset-value">
                        <div class="wallet-asset-price" id="avax-price">$0.00</div>
                        <div class="wallet-asset-change positive" id="avax-change">0%</div>
                    </div>
                </div>

                <!-- USDT ERC-20 -->
                <div class="wallet-asset-row" onclick="navigateToCoin('erc', 13)">
                    <div class="wallet-asset-icon-wrapper">
                        <img src="uploads/1759140395_tether.png" alt="USDT" class="wallet-asset-icon">
                    </div>
                    <div class="wallet-asset-info">
                        <div class="wallet-asset-name">USDT (ERC-20)</div>
                        <div class="wallet-asset-details" id="erc-small">0.00000 USDT</div>
                    </div>
                    <div class="wallet-asset-value">
                        <div class="wallet-asset-price" id="erc-price">$0.00</div>
                        <div class="wallet-asset-change positive" id="erc-change">0%</div>
                    </div>
                </div>

                <!-- USDT TRC-20 -->
                <div class="wallet-asset-row" onclick="navigateToCoin('trc', 18)">
                    <div class="wallet-asset-icon-wrapper">
                        <img src="uploads/1759331218_tether.png" alt="USDT TRC-20" class="wallet-asset-icon">
                    </div>
                    <div class="wallet-asset-info">
                        <div class="wallet-asset-name">USDT (TRC-20)</div>
                        <div class="wallet-asset-details" id="trc-small">0.00000 USDT</div>
                    </div>
                    <div class="wallet-asset-value">
                        <div class="wallet-asset-price" id="trc-price">$0.00</div>
                        <div class="wallet-asset-change positive" id="trc-change">0%</div>
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
                        changeEl.className = change >= 0 ? 'wallet-asset-change positive' : 'wallet-asset-change negative';
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
