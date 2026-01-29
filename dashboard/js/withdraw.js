/* ================= WITHDRAW PAGE SCRIPTS ======================= */

// Guard against multiple inclusions
if (typeof window.__withdrawScriptsLoaded === 'undefined') {
    window.__withdrawScriptsLoaded = true;

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
