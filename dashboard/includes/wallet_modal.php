<!-- Wallet Modal Component -->
<div id="walletModal" class="wallet-modal-overlay">
    <div class="wallet-modal-wrapper">
        <div class="wallet-modal-header">
            <div class="wallet-modal-header-content">
                <h2 id="modalTitle" class="wallet-modal-title">
                    <i class="fas fa-wallet" style="margin-right: 10px; opacity: 0.7;"></i>
                    Select Cryptocurrency
                </h2>
                <p class="wallet-modal-subtitle">Choose a coin to deposit or manage</p>
            </div>
            <button class="wallet-modal-close-btn" onclick="closeModal()" title="Close Modal" aria-label="Close modal">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="wallet-modal-body">
            <div class="wallet-assets-list" role="list">
                <!-- Bitcoin -->
                <div class="wallet-asset-row" onclick="navigateToCoin('btc', 5)" role="listitem" tabindex="0">
                    <div class="wallet-asset-icon-wrapper">
                        <div class="wallet-asset-icon-bg btc-gradient">
                            <svg class="crypto-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 4C9 4 7 6 7 9C7 12 9 13 11 13H14C15 13 16 12 16 11V10C16 9 15 8 14 8H11M9 13V18C9 19 10 20 11 20H14C16 20 17 19 17 17V16C17 15 16 14 14 14H11" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="11" stroke="white" stroke-width="2"/></svg>
                        </div>
                    </div>
                    <div class="wallet-asset-balance" id="btc-small">0.00000 BTC</div>
                </div>

                <!-- Ethereum -->
                <div class="wallet-asset-row" onclick="navigateToCoin('eth', 8)" role="listitem" tabindex="0">
                    <div class="wallet-asset-icon-wrapper">
                        <div class="wallet-asset-icon-bg eth-gradient">
                            <svg class="crypto-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><polygon points="12,2 22,13 12,18 2,13" fill="white" stroke="white" stroke-width="1.5"/><polygon points="12,18 22,13 12,24 2,13" fill="white" stroke="white" stroke-width="1.5" opacity="0.7"/></svg>
                        </div>
                    </div>
                    <div class="wallet-asset-balance" id="eth-small">0.00000 ETH</div>
                </div>

                <!-- Binance Coin -->
                <div class="wallet-asset-row" onclick="navigateToCoin('bnb', 6)" role="listitem" tabindex="0">
                    <div class="wallet-asset-icon-wrapper">
                        <div class="wallet-asset-icon-bg bnb-gradient">
                            <svg class="crypto-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="4" width="16" height="16" rx="3" fill="white"/><rect x="6" y="6" width="12" height="12" rx="2" fill="white" opacity="0.8"/><circle cx="12" cy="12" r="3" fill="white" opacity="0.6"/></svg>
                        </div>
                    </div>
                    <div class="wallet-asset-balance" id="bnb-small">0.00000 BNB</div>
                </div>

                <!-- TRON -->
                <div class="wallet-asset-row" onclick="navigateToCoin('trx', 9)" role="listitem" tabindex="0">
                    <div class="wallet-asset-icon-wrapper">
                        <div class="wallet-asset-icon-bg trx-gradient">
                            <svg class="crypto-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><polygon points="12,3 20,8 20,16 12,21 4,16 4,8" fill="white" stroke="white" stroke-width="1.5" stroke-linejoin="round"/><line x1="12" y1="3" x2="12" y2="21" stroke="white" stroke-width="1.5"/></svg>
                        </div>
                    </div>
                    <div class="wallet-asset-balance" id="trx-small">0.00000 TRX</div>
                </div>

                <!-- Solana -->
                <div class="wallet-asset-row" onclick="navigateToCoin('sol', 15)" role="listitem" tabindex="0">
                    <div class="wallet-asset-icon-wrapper">
                        <div class="wallet-asset-icon-bg sol-gradient">
                            <svg class="crypto-icon" viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg"><path d="M5 8L8 5M16 19L19 16M5 16L8 19M19 8L16 5M12 2L20 12L12 22L4 12Z" fill="none" stroke="white" stroke-width="1.5" stroke-linejoin="round"/></svg>
                        </div>
                    </div>
                    <div class="wallet-asset-balance" id="sol-small">0.00000 SOL</div>
                </div>

                <!-- Ripple -->
                <div class="wallet-asset-row" onclick="navigateToCoin('xrp', 16)" role="listitem" tabindex="0">
                    <div class="wallet-asset-icon-wrapper">
                        <div class="wallet-asset-icon-bg xrp-gradient">
                            <svg class="crypto-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="7" cy="12" r="2.5" fill="white"/><circle cx="12" cy="7" r="2.5" fill="white"/><circle cx="17" cy="12" r="2.5" fill="white"/><circle cx="12" cy="17" r="2.5" fill="white"/><path d="M8.5 11L10.5 8.5M13.5 8.5L15.5 11M15.5 13L13.5 15.5M10.5 15.5L8.5 13" stroke="white" stroke-width="1.5" stroke-linecap="round"/></svg>
                        </div>
                    </div>
                    <div class="wallet-asset-balance" id="xrp-small">0.00000 XRP</div>
                </div>

                <!-- Avalanche -->
                <div class="wallet-asset-row" onclick="navigateToCoin('avax', 17)" role="listitem" tabindex="0">
                    <div class="wallet-asset-icon-wrapper">
                        <div class="wallet-asset-icon-bg avax-gradient">
                            <svg class="crypto-icon" viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg"><polygon points="12,2 20,14 14,14 14,22 10,22 10,14 4,14"/></svg>
                        </div>
                    </div>
                    <div class="wallet-asset-balance" id="avax-small">0.00000 AVAX</div>
                </div>

                <!-- USDT ERC-20 -->
                <div class="wallet-asset-row" onclick="navigateToCoin('erc', 13)" role="listitem" tabindex="0">
                    <div class="wallet-asset-icon-wrapper">
                        <div class="wallet-asset-icon-bg usdt-gradient">
                            <svg class="crypto-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" fill="white" opacity="0.3" stroke="white" stroke-width="1.5"/><path d="M11 8H13L15 10V14L13 16H11L9 14V10L11 8Z" fill="white" stroke="white" stroke-width="0.5"/><line x1="12" y1="10" x2="12" y2="14" stroke="white" stroke-width="1.5"/></svg>
                        </div>
                    </div>
                    <div class="wallet-asset-balance" id="erc-small">0.00000 USDT</div>
                </div>

                <!-- USDT TRC-20 -->
                <div class="wallet-asset-row" onclick="navigateToCoin('trc', 18)" role="listitem" tabindex="0">
                    <div class="wallet-asset-icon-wrapper">
                        <div class="wallet-asset-icon-bg usdt-gradient">
                            <svg class="crypto-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" fill="white" opacity="0.3" stroke="white" stroke-width="1.5"/><path d="M11 8H13L15 10V14L13 16H11L9 14V10L11 8Z" fill="white" stroke="white" stroke-width="0.5"/><line x1="12" y1="10" x2="12" y2="14" stroke="white" stroke-width="1.5"/></svg>
                        </div>
                    </div>
                    <div class="wallet-asset-balance" id="trc-small">0.00000 USDT</div>
                </div>
            </div>
        </div>

        <div class="wallet-modal-footer">
            <button class="wallet-modal-close-bottom" onclick="closeModal()" aria-label="Close modal">
                <i class="fas fa-times-circle"></i>
                <span>Close</span>
            </button>
        </div>
    </div>
</div>

<script>
// Load cryptocurrency icons library
if (!document.getElementById('crypto-icons-cdn')) {
    const link = document.createElement('link');
    link.id = 'crypto-icons-cdn';
    link.rel = 'stylesheet';
    link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/all.min.css';
    document.head.appendChild(link);
}

// ========== WALLET MODAL STYLING ========== 
// Inject professional styles for wallet modal
if (!document.getElementById('wallet-modal-styles')) {
    const style = document.createElement('style');
    style.id = 'wallet-modal-styles';
    style.textContent = `
    /* Wallet Modal Overlay */
    #walletModal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        z-index: 2000;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }

    #walletModal.show {
        display: flex;
    }

    /* Modal Wrapper */
    .wallet-modal-wrapper {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        width: 100%;
        max-width: 520px;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        animation: slideUp 0.3s ease-out;
        overflow: hidden;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Modal Header */
    .wallet-modal-header {
        padding: 24px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        background: linear-gradient(135deg, #ffffff 0%, #f5f7fa 100%);
        flex-shrink: 0;
    }

    .wallet-modal-header-content {
        flex: 1;
        padding-right: 16px;
    }

    .wallet-modal-title {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        color: #1a1a1a;
        display: flex;
        align-items: center;
    }

    .wallet-modal-subtitle {
        margin: 8px 0 0 0;
        font-size: 14px;
        color: #666;
        font-weight: 400;
    }

    .wallet-modal-close-btn {
        background: none;
        border: none;
        font-size: 24px;
        color: #999;
        cursor: pointer;
        padding: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        flex-shrink: 0;
        width: 40px;
        height: 40px;
    }

    .wallet-modal-close-btn:hover {
        color: #f24949;
        transform: rotate(90deg);
        background: #fff5f5;
        border-radius: 8px;
    }

    /* Modal Body */
    .wallet-modal-body {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 16px;
    }

    .wallet-assets-list {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
    }

    /* Asset Row */
    .wallet-asset-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 12px 16px;
        background: #ffffff;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
        position: relative;
        overflow: visible;
        min-height: 64px;
    }

    .wallet-asset-row::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, #2563eb, transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .wallet-asset-row:hover,
    .wallet-asset-row:focus {
        border-color: #2563eb;
        background: linear-gradient(135deg, #ffffff 0%, #f0f7ff 100%);
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.15);
        transform: translateX(4px);
        outline: none;
    }

    .wallet-asset-row:hover::before {
        opacity: 1;
    }

    /* Icon Wrapper */
    .wallet-asset-icon-wrapper {
        flex-shrink: 0;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .wallet-asset-icon-bg {
        width: 100%;
        height: 100%;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }

    .crypto-icon {
        width: 100%;
        height: 100%;
        max-width: 28px;
        max-height: 28px;
        object-fit: contain;
    }

    .wallet-asset-row:hover .wallet-asset-icon-bg {
        transform: scale(1.15);
    }

    /* Gradient Classes */
    .btc-gradient { background: linear-gradient(135deg, #f7931a 0%, #d19400 100%); }
    .eth-gradient { background: linear-gradient(135deg, #627eea 0%, #764ce9 100%); }
    .bnb-gradient { background: linear-gradient(135deg, #f3ba2f 0%, #daa520 100%); }
    .trx-gradient { background: linear-gradient(135deg, #eb0029 0%, #a60020 100%); }
    .sol-gradient { background: linear-gradient(135deg, #14f195 0%, #00d4aa 100%); }
    .xrp-gradient { background: linear-gradient(135deg, #23292f 0%, #3a4349 100%); }
    .avax-gradient { background: linear-gradient(135deg, #e84142 0%, #a61b1e 100%); }
    .usdt-gradient { background: linear-gradient(135deg, #26a17b 0%, #1f8168 100%); }

    /* Asset Balance */
    .wallet-asset-balance {
        font-size: 14px;
        font-weight: 600;
        color: #1a1a1a;
        margin: 0;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .wallet-asset-row:hover .wallet-asset-arrow {
        color: #2563eb;
        transform: translateX(4px);
    }

    /* Modal Footer */
    .wallet-modal-footer {
        padding: 16px 24px 24px;
        border-top: 1px solid #e9ecef;
        display: flex;
        gap: 12px;
    }

    .wallet-modal-close-bottom {
        flex: 1;
        padding: 12px 20px;
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .wallet-modal-close-bottom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(79, 70, 229, 0.3);
    }

    .wallet-modal-close-bottom:active {
        transform: translateY(0);
    }    padding: 0;
        }

        .wallet-modal-header {
            padding: 20px 16px;
        }

        .wallet-modal-title {
            font-size: 18px;
        }

        .wallet-modal-body {
            padding: 12px;
        }

        .wallet-assets-list {
            gap: 10px;
        }

        .wallet-asset-row {
            padding: 12px 14px;
            min-height: 74px;
            gap: 12px;
        }

        .wallet-asset-icon-wrapper {
            width: 48px;
            height: 48px;
        }

        .wallet-asset-icon-bg {
            font-size: 24px;
        }

        .wallet-asset-name {
            font-size: 15px;
        }

        .wallet-asset-code {
            font-size: 10px;
        }

        .wallet-asset-price {
            font-size: 14px;
        }

        .wallet-modal-footer {
            padding: 12px 16px 20px;
        }

        .wallet-modal-close-btn {
            width: 36px;
            height: 36px;
        }

        .wallet-asset-balance {
            font-size: 13px;
        }
    }

    /* Firefox Scrollbar */
    .wallet-modal-body {
        scrollbar-width: thin;
        scrollbar-color: #d1d5db transparent;
    }

    /* Scrollbar Styling */
    .wallet-modal-body::-webkit-scrollbar {
        width: 6px;
    }

    .wallet-modal-body::-webkit-scrollbar-track {
        background: transparent;
    }

    .wallet-modal-body::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 3px;
    }

    .wallet-modal-body::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
    `;
    document.head.appendChild(style);
}

// Navigate to coin view page
function navigateToCoin(coinType, coinId) {
    const url = 'view.php?coin=' + encodeURIComponent(coinType);
    console.log('🔗 Navigating to:', url);
    window.location.href = url;
}
    
        // Add keyboard support for rows
        const rows = modal.querySelectorAll('.wallet-asset-row');
        rows.forEach(row => {
            row.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    row.click();
                }
            });
        });
    
// Close modal function
function closeModal() {
    const modal = document.getElementById('walletModal');
    if (modal) {
        modal.classList.remove('show');
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }
}

// Open modal function (if needed from outside)
function openWalletModal() {
    const modal = document.getElementById('walletModal');
    if (modal) {
        modal.style.display = 'flex';
        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
    }
}

// Close modal when clicking overlay
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('walletModal');
    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
    }
});

// Load live prices for wallet modal (updates balance display)
function loadWalletModalPrices() {
    // Function no longer needed - balance is fetched separately
    // This can be kept for future enhancement if price data needs to be displayed
}

// Load prices on modal load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadWalletModalPrices);
} else {
    loadWalletModalPrices();
}
</script>
