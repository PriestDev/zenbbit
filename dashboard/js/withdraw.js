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
    const selectedMethod = document.getElementById('withdrawMethod').value;
    const gasFeeNotice = document.getElementById('gasFeeNotice');
    const gasFeeText = document.getElementById('gasFeeText');
    
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

    // Determine gas fee for selected asset
    let gasRequired = 0;
    if (selected === 'eth' || selected === 'usdt-erc20') {
        gasRequired = parseFloat(gasFeeConfig.eth) || 0;
    } else if (selected === 'trx' || selected === 'usdt-trc20') {
        gasRequired = parseFloat(gasFeeConfig.trx) || 0;
    } else {
        gasRequired = 0;
    }

    // If no gas required for this asset, show the informational button
    // (per design: BTC and non-gas assets display the 'Request Withdrawal' info button).
    let showReal = false;
    if (gasRequired > 0) {
        showReal = balance >= gasRequired;
    } else {
        showReal = false;
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
            
            // Get asset-specific message from database or fallback to default
            let message = withdrawalMessages[selectedMethod] || 'Your withdrawal request has been submitted successfully.';
            
            // Replace placeholders with actual values
            message = message.replace('{amount}', selectedAmount).replace('{address}', selectedAddress);
            
            showStyledAlert(message, 'success');
        });
    }
});

/**
 * Display styled alert using iziToast or fallback to custom modal
 */
function showStyledAlert(message, type = 'info') {
    if (typeof iziToast !== 'undefined') {
        iziToast[type]({
            title: type.charAt(0).toUpperCase() + type.slice(1),
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
 * Fetch current cryptocurrency prices from CoinGecko API
 */
async function fetchCryptoPrices() {
    try {
        const ids = Object.values(cryptoSymbolMap).join(',');
        const response = await fetch(`https://api.coingecko.com/api/v3/simple/price?ids=${ids}&vs_currencies=usd`);
        const data = await response.json();
        cryptoPrices = data;
        return data;
    } catch (error) {
        console.error('Error fetching crypto prices:', error);
        return null;
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
            
            // Disable submit button
            const submitBtn = withdrawForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Processing...';
            
            // Send withdrawal request to backend with crypto amount
            fetch('api/process_withdrawal.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    asset: method,
                    amount: cryptoAmount,
                    address: address
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
                        iziToast.error({
                            title: 'Error',
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
