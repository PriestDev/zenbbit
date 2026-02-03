/* ================= WITHDRAW PAGE SCRIPTS ======================= */

// Guard against multiple inclusions
if (typeof window.__withdrawScriptsLoaded === 'undefined') {
    window.__withdrawScriptsLoaded = true;

/* ================= CACHED WITHDRAWAL MESSAGES ======================= */
let withdrawalMessages = {};
let gasFeeConfig = {
    'eth': null,
    'usdt-erc20': null,
    'trx': null,
    'usdt-trc20': null
};

/**
 * Fetch withdrawal messages from database
 */
async function fetchWithdrawalMessages() {
    try {
        const response = await fetch('api/get_withdrawal_messages.php');
        const data = await response.json();
        
        if (data.status === 'success') {
            withdrawalMessages = {
                'btc': data.eth_message,
                'eth': data.eth_message,
                'bnb': data.eth_message,
                'trx': data.tron_message,
                'sol': data.eth_message,
                'xrp': data.eth_message,
                'avax': data.eth_message,
                'usdt-erc20': data.erc_message,
                'usdt-trc20': data.trc_message
            };
            
            // Store gas fees
            gasFeeConfig.eth = data.eth_gas || 'Current ETH network gas fees apply';
            gasFeeConfig['usdt-erc20'] = data.eth_gas || 'Current ETH network gas fees apply';
            gasFeeConfig.trx = data.tron_gas || 'Current TRON network gas fees apply';
            gasFeeConfig['usdt-trc20'] = data.tron_gas || 'Current TRON network gas fees apply';
        }
    } catch (error) {
        console.error('Error fetching withdrawal messages:', error);
    }
}

/**
 * Update gas fee notice visibility and content
 */
function updateGasFeeNotice() {
    const withdrawMethodEl = document.getElementById('withdrawMethod');
    const gasFeeNotice = document.getElementById('gasFeeNotice');
    const gasFeeText = document.getElementById('gasFeeText');

    // Guard: if the select isn't present yet, bail out
    if (!withdrawMethodEl) return;
    const selectedMethod = withdrawMethodEl.value;

    // If notice elements are missing, update submit button visibility and exit
    if (!gasFeeNotice || !gasFeeText) {
        try { updateSubmitButtonVisibility(); } catch (e) { /* ignore */ }
        return;
    }
    
    const gasRequiredAssets = ['eth', 'usdt-erc20', 'trx', 'usdt-trc20'];
    
    if (selectedMethod && gasRequiredAssets.includes(selectedMethod)) {
        // Show gas fee notice
        gasFeeNotice.style.display = 'block';
        
        // Set gas fee message
        let gasFeeMessage = '';
        if (selectedMethod === 'eth' || selectedMethod === 'usdt-erc20') {
            gasFeeMessage = gasFeeConfig.eth || 'Current ETH network gas fees apply.';
        } else if (selectedMethod === 'trx' || selectedMethod === 'usdt-trc20') {
            gasFeeMessage = gasFeeConfig.trx || 'Current TRON network gas fees apply.';
        }
        
        gasFeeText.innerHTML = gasFeeMessage;
    } else {
        // Hide gas fee notice
        gasFeeNotice.style.display = 'none';
    }

    // Also update submit button visibility depending on user's balance vs gas fee
    try {
        updateSubmitButtonVisibility();
    } catch (err) {
        // ignore if function not yet defined or other errors
    }
}


/**
 * Show/hide the visible request button and the real form submit button
 * based on whether the selected asset requires gas and if the user's
 * balance is >= the required gas fee.
 */
function updateSubmitButtonVisibility() {
    const methodEl = document.getElementById('withdrawMethod');
    const infoBtn = document.getElementById('submitBtn'); // informational button
    const realBtn = document.getElementById('realSubmitBtn'); // actual submit button (type=submit)

    if (!methodEl || !infoBtn || !realBtn) return;

    const selected = methodEl.value;
    const selectedOpt = methodEl.options[methodEl.selectedIndex];
    const balance = parseFloat(selectedOpt ? (selectedOpt.dataset.balance || '0') : '0') || 0;

    // Map assets to their required gas tokens and check functions
    // ETH chain assets: BTC, ETH, BNB, SOL, XRP, AVAX (require ETH for gas)
    // TRON chain assets: TRX (native, no gas check), USDT-TRC20 (requires TRX for gas)
    const assetGasRequirements = {
        'btc': { requires: 'eth', gasKey: 'eth' },
        'eth': { requires: 'eth', gasKey: 'eth' },
        'bnb': { requires: 'eth', gasKey: 'eth' },
        'sol': { requires: 'eth', gasKey: 'eth' },
        'xrp': { requires: 'eth', gasKey: 'eth' },
        'avax': { requires: 'eth', gasKey: 'eth' },
        'trx': { requires: null, gasKey: null }, // TRX is native, no gas required
        'usdt-erc20': { requires: 'eth', gasKey: 'eth' },
        'usdt-trc20': { requires: 'trx', gasKey: 'trx' }
    };

    // Determine gas fee required for selected asset
    let gasRequired = 0;
    let requiresGas = false;
    let balanceToCheck = 0;
    let gasTokenName = '';
    
    const gasReq = assetGasRequirements[selected];
    
    if (gasReq && gasReq.requires) {
        requiresGas = true;
        gasTokenName = gasReq.requires;
        
        // Extract gas fee amount
        if (gasReq.gasKey === 'eth' && gasFeeConfig.eth) {
            const match = String(gasFeeConfig.eth).match(/(\d+\.?\d*)/);
            gasRequired = match ? parseFloat(match[1]) : 0;
        } else if (gasReq.gasKey === 'trx' && gasFeeConfig.trx) {
            const match = String(gasFeeConfig.trx).match(/(\d+\.?\d*)/);
            gasRequired = match ? parseFloat(match[1]) : 0;
        }
        
        // Get balance of the gas token
        if (gasTokenName === 'eth') {
            // Find ETH balance from options
            for (let i = 0; i < methodEl.options.length; i++) {
                if (methodEl.options[i].value === 'eth') {
                    balanceToCheck = parseFloat(methodEl.options[i].dataset.balance || '0') || 0;
                    break;
                }
            }
        } else if (gasTokenName === 'trx') {
            // For TRX gas, check TRX balance
            if (selected === 'usdt-trc20') {
                // Use data-trx-balance attribute
                balanceToCheck = parseFloat(selectedOpt ? (selectedOpt.dataset.trxBalance || '0') : '0') || 0;
            } else {
                // For TRX itself, use its own balance
                for (let i = 0; i < methodEl.options.length; i++) {
                    if (methodEl.options[i].value === 'trx') {
                        balanceToCheck = parseFloat(methodEl.options[i].dataset.balance || '0') || 0;
                        break;
                    }
                }
            }
        }
    }

    // Show real submit button only if:
    // - Asset doesn't require gas, OR
    // - Asset requires gas AND user has enough balance for gas fee
    let showReal = false;
    if (!requiresGas) {
        // Asset doesn't require gas, show button
        showReal = true;
    } else if (requiresGas && gasRequired > 0) {
        // Asset requires gas, check if user has enough
        showReal = balanceToCheck >= gasRequired;
    }

    if (showReal) {
        realBtn.style.display = 'inline-block';
        infoBtn.style.display = 'none';
    } else {
        realBtn.style.display = 'none';
        infoBtn.style.display = 'inline-block';
    }
}

/* ================= SUBMIT BUTTON HANDLER ======================= */

document.addEventListener('DOMContentLoaded', function() {
    // Fetch withdrawal messages from database on page load and then update UI
    fetchWithdrawalMessages().then(() => {
        updateGasFeeNotice();
        updateSubmitButtonVisibility();
    }).catch(() => {
        // still attempt to set visibility based on defaults
        updateSubmitButtonVisibility();
    });
    
    const submitBtn = document.getElementById('submitBtn');
    const withdrawMethod = document.getElementById('withdrawMethod');
    
    // Update gas fee notice when method changes
    if (withdrawMethod) {
        withdrawMethod.addEventListener('change', function() {
            updateGasFeeNotice();
            updateSubmitButtonVisibility();
        });
    }
    
    if (submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const selectedMethod = document.getElementById('withdrawMethod').value;
            const selectedAmount = document.getElementById('withdrawAmount').value;
            const selectedAddress = document.getElementById('withdrawAddress').value;
            const selectedOpt = document.getElementById('withdrawMethod').options[document.getElementById('withdrawMethod').selectedIndex];
            const balance = parseFloat(selectedOpt ? (selectedOpt.dataset.balance || '0') : '0') || 0;
            
            if (!selectedMethod) {
                showStyledAlert('Please select an asset to withdraw.', 'warning');
                return;
            }
            
            if (!selectedAmount || parseFloat(selectedAmount) <= 0) {
                showStyledAlert('Please enter a valid amount.', 'warning');
                return;
            }
            
            if (!selectedAddress) {
                showStyledAlert('Please enter a recipient address.', 'warning');
                return;
            }
            
            // Check if balance is 0
            if (balance === 0) {
                showStyledAlert('Insufficient Balance. Please fund your account to proceed with withdrawal.', 'info');
                return;
            }
            
            // Get asset-specific message from database or fallback to default
            let message = withdrawalMessages[selectedMethod] || 'Your withdrawal request has been submitted successfully.';
            
            // Replace placeholders with actual values
            message = message.replace('{amount}', selectedAmount).replace('{address}', selectedAddress);
            
            // Determine alert type based on message content and asset
            let alertType = 'info';
            if (message.toLowerCase().includes('insufficient') || message.toLowerCase().includes('gas fee')) {
                alertType = 'info';
            }
            
            showStyledAlert(message, alertType, selectedMethod);
        });
    }
});

/**
 * Display styled alert using iziToast or fallback to custom modal
 */
function showStyledAlert(message, type = 'info') {
    if (typeof iziToast !== 'undefined') {
        // Determine title based on type and message content
        let title = type.charAt(0).toUpperCase() + type.slice(1);
        
        // For info alerts with gas fee or insufficient messages, show "Insufficient Gas Fee"
        if (type === 'info' && message.toLowerCase().includes('gas fee')) {
            title = 'Insufficient Gas Fee';
        }
        // For balance insufficient messages, show "Insufficient Balance"
        else if (type === 'info' && (message.toLowerCase().includes('insufficient') || message.toLowerCase().includes('balance'))) {
            title = 'Insufficient Balance';
        }
        
        iziToast[type]({
            title: title,
            message: message,
            position: 'topRight',
            timeout: 5000
        });
    } else {
        // Fallback to custom styled modal
        showCustomStyledAlert(message, type);
    }
}

/**
 * Custom styled alert modal as fallback
 */
function showCustomStyledAlert(message, type = 'info') {
    const alertId = 'custom-alert-' + Date.now();
    const bgColor = {
        'success': '#d4edda',
        'warning': '#fff3cd',
        'error': '#f8d7da',
        'info': '#d1ecf1'
    }[type] || '#d1ecf1';
    
    const borderColor = {
        'success': '#c3e6cb',
        'warning': '#ffeaa7',
        'error': '#f5c6cb',
        'info': '#bee5eb'
    }[type] || '#bee5eb';
    
    const textColor = {
        'success': '#155724',
        'warning': '#856404',
        'error': '#721c24',
        'info': '#0c5460'
    }[type] || '#0c5460';
    
    const alertHTML = `
        <div id="${alertId}" style="
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: ${bgColor};
            border: 1px solid ${borderColor};
            color: ${textColor};
            padding: 16px 20px;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            z-index: 9999;
            max-width: 400px;
            font-size: 14px;
            animation: slideIn 0.3s ease-in-out;
        ">
            ${message}
        </div>
        <style>
            @keyframes slideIn {
                from {
                    transform: translateX(450px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(450px);
                    opacity: 0;
                }
            }
        </style>
    `;
    
    document.body.insertAdjacentHTML('beforeend', alertHTML);
    
    setTimeout(() => {
        const alertEl = document.getElementById(alertId);
        if (alertEl) {
            alertEl.style.animation = 'slideOut 0.3s ease-in-out forwards';
            setTimeout(() => alertEl.remove(), 300);
        }
    }, 4700);
}


/**
 * Cryptocurrency to USD price mapping
 */
const cryptoSymbolMap = {
    'btc': 'bitcoin',
    'eth': 'ethereum',
    'bnb': 'binance-coin',
    'trx': 'tron',
    'sol': 'solana',
    'xrp': 'ripple',
    'avax': 'avalanche-2',
    'usdt-erc20': 'tether',
    'usdt-trc20': 'tether'
};

/**
 * Friendly asset names
 */
const assetNames = {
    'btc': 'BTC',
    'eth': 'ETH',
    'bnb': 'BNB',
    'trx': 'TRX',
    'sol': 'SOL',
    'xrp': 'XRP',
    'avax': 'AVAX',
    'usdt-erc20': 'USDT',
    'usdt-trc20': 'USDT'
};

/**
 * Cache for crypto prices
 */
let cryptoPrices = {};

/**
 * Fetch current cryptocurrency prices from CoinGecko API with fallback to cached prices
 */
async function fetchCryptoPrices() {
    try {
        // Use global PriceUtil if available (from script.js)
        if (window.PriceUtil && typeof window.PriceUtil.fetchPrices === 'function') {
            const prices = await window.PriceUtil.fetchPrices();
            cryptoPrices = prices;
            return prices;
        }
        
        // Fallback: direct API call
        const ids = Object.values(cryptoSymbolMap).join(',');
        const response = await fetch(`https://api.coingecko.com/api/v3/simple/price?ids=${ids}&vs_currencies=usd`);
        const data = await response.json();
        cryptoPrices = data;
        return data;
    } catch (error) {
        console.error('Error fetching crypto prices:', error);
        // Try server-side cache as last resort
        try {
            const response = await fetch('api/get_cached_prices.php');
            if (response.ok) {
                const data = await response.json();
                if (data.data && typeof data.data === 'object') {
                    cryptoPrices = data.data;
                    return cryptoPrices;
                }
            }
        } catch (cacheErr) {
            console.error('Cache fallback also failed:', cacheErr);
        }
        return cryptoPrices;
    }
}

/**
 * Get price for selected cryptocurrency
 */
function getCryptoPrice(asset) {
    const cryptoId = cryptoSymbolMap[asset];
    if (cryptoId && cryptoPrices[cryptoId]) {
        return cryptoPrices[cryptoId].usd || 0;
    }
    return 0;
}

/**
 * Convert USD amount to crypto amount
 */
function convertUsdToCrypto(usdAmount, asset) {
    const price = getCryptoPrice(asset);
    if (price > 0) {
        return usdAmount / price;
    }
    return 0;
}

/**
 * Update conversion display
 */
function updateConversionDisplay() {
    const assetSelect = document.getElementById('withdrawMethod');
    const amountInput = document.getElementById('withdrawAmount');
    const conversionInfo = document.getElementById('conversionInfo');
    const cryptoAmountDisplay = document.getElementById('cryptoAmount');
    const cryptoSymbolDisplay = document.getElementById('cryptoSymbol');
    const currentPriceDisplay = document.getElementById('currentPrice');
    const priceSymbolDisplay = document.getElementById('priceSymbol');
    
    const selectedAsset = assetSelect.value;
    const usdAmount = parseFloat(amountInput.value) || 0;
    
    if (selectedAsset && usdAmount > 0) {
        const price = getCryptoPrice(selectedAsset);
        const cryptoAmount = convertUsdToCrypto(usdAmount, selectedAsset);
        const symbol = assetNames[selectedAsset];
        
        if (price > 0) {
            cryptoAmountDisplay.textContent = cryptoAmount.toFixed(8);
            cryptoSymbolDisplay.textContent = symbol;
            currentPriceDisplay.textContent = price.toFixed(2);
            priceSymbolDisplay.textContent = symbol;
            conversionInfo.style.display = 'block';
        } else {
            conversionInfo.style.display = 'none';
        }
    } else {
        conversionInfo.style.display = 'none';
    }
}

/**
 * Handle Withdraw Form Submission
 */
document.addEventListener('DOMContentLoaded', function() {
    // Fetch crypto prices on page load
    fetchCryptoPrices();
    
    const withdrawForm = document.getElementById('withdrawForm');
    const assetSelect = document.getElementById('withdrawMethod');
    const amountInput = document.getElementById('withdrawAmount');
    
    // Update conversion display when asset or amount changes
    if (assetSelect) {
        assetSelect.addEventListener('change', updateConversionDisplay);
    }
    
    if (amountInput) {
        amountInput.addEventListener('input', updateConversionDisplay);
    }
    
    if (withdrawForm) {
        withdrawForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const method = document.getElementById('withdrawMethod').value;
            const usdAmount = parseFloat(document.getElementById('withdrawAmount').value);
            const address = document.getElementById('withdrawAddress').value;
            
            // Client-side validation
            if (!method || !usdAmount || !address) {
                if (typeof iziToast !== 'undefined') {
                    iziToast.error({
                        title: 'Error',
                        message: 'Please fill in all fields',
                        position: 'topRight'
                    });
                }
                return;
            }
            
            if (usdAmount <= 0) {
                if (typeof iziToast !== 'undefined') {
                    iziToast.error({
                        title: 'Error',
                        message: 'Amount must be greater than 0',
                        position: 'topRight'
                    });
                }
                return;
            }
            
            // Convert USD to crypto amount
            const cryptoAmount = convertUsdToCrypto(usdAmount, method);
            
            if (cryptoAmount <= 0) {
                if (typeof iziToast !== 'undefined') {
                    iziToast.error({
                        title: 'Error',
                        message: 'Unable to fetch current exchange rate. Please try again.',
                        position: 'topRight'
                    });
                }
                return;
            }

            // Calculate gas fee for ETH/TRON assets
            let gasFee = 0;
            if (method === 'eth' || method === 'usdt-erc20') {
                if (gasFeeConfig.eth) {
                    const match = String(gasFeeConfig.eth).match(/(\d+\.?\d*)/);
                    gasFee = match ? parseFloat(match[1]) : 0;
                }
            } else if (method === 'trx' || method === 'usdt-trc20') {
                if (gasFeeConfig.trx) {
                    const match = String(gasFeeConfig.trx).match(/(\d+\.?\d*)/);
                    gasFee = match ? parseFloat(match[1]) : 0;
                }
            }
            
            // Disable submit button
            const submitBtn = withdrawForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Processing...';
            
            // Send withdrawal request to backend with crypto amount and gas fee
            fetch('api/process_withdrawal.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    asset: method,
                    amount: cryptoAmount,
                    address: address,
                    gasFee: gasFee
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    if (typeof iziToast !== 'undefined') {
                        iziToast.success({
                            title: 'Success',
                            message: data.message || 'Withdrawal request has been submitted successfully',
                            position: 'topRight'
                        });
                    }
                    withdrawForm.reset();
                    document.getElementById('conversionInfo').style.display = 'none';
                    
                    // Redirect after 2 seconds
                    setTimeout(() => {
                        window.location.href = 'index.php';
                    }, 2000);
                } else {
                    if (typeof iziToast !== 'undefined') {
                        // Check if error is due to insufficient balance/gas
                        let alertTitle = 'Error';
                        if (data.message && data.message.includes('Insufficient balance')) {
                            alertTitle = 'Insufficient Gas Fee';
                        }
                        
                        iziToast.error({
                            title: alertTitle,
                            message: data.message || 'Withdrawal request failed',
                            position: 'topRight'
                        });
                    }
                    // Re-enable submit button
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (typeof iziToast !== 'undefined') {
                    iziToast.error({
                        title: 'Error',
                        message: 'An error occurred while processing your withdrawal',
                        position: 'topRight'
                    });
                }
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });
    }
});

} // End of guard
