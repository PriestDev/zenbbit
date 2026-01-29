/**
 * DEPOSIT PAGE MODULE - SIMPLIFIED
 * Handles:
 * - Wallet address display
 * - QR code generation for each method
 * - Copy to clipboard
 * - Form displays wallet info and receipt upload
 */

(function() {
    'use strict';

    // ================= WALLET CONFIGURATION ======================
    const walletAddresses = {
        btc: document.currentScript?.dataset?.btcAddress || 'NOT_CONFIGURED',
        usdt_trc: document.currentScript?.dataset?.trcAddress || 'NOT_CONFIGURED',
        usdt_erc: document.currentScript?.dataset?.ercAddress || 'NOT_CONFIGURED',
        eth: document.currentScript?.dataset?.ethAddress || 'NOT_CONFIGURED'
    };

    const walletLabels = {
        btc: 'Bitcoin (BTC)',
        usdt_trc: 'USDT - TRC20',
        usdt_erc: 'USDT - ERC20',
        eth: 'Ethereum (ETH)'
    };

    // ================= STATE MANAGEMENT ======================
    let currentMethod = null;
    let qrGenerationInProgress = false;
    let priceCache = {};  // Cache for asset prices
    let lastPriceFetchTime = 0;

    // ================= DOM ELEMENTS ======================
    const depositMethodSelect = document.getElementById('depositMethod');
    const walletCard = document.getElementById('walletCard');
    const receiptGroup = document.getElementById('receiptGroup');
    const walletAddressEl = document.getElementById('walletAddress');
    const copyWalletBtn = document.getElementById('copyWalletBtn');
    const paymentReceiptInput = document.getElementById('paymentReceipt');
    const depositForm = document.getElementById('depositForm');
    const depositAmountInput = document.getElementById('depositAmount');
    const assetValueDisplay = document.getElementById('assetValueDisplay');
    const assetPriceEl = document.getElementById('assetPrice');
    const cryptoValueDisplayEl = document.getElementById('cryptoValueDisplay');
    const assetSymbolEl = document.getElementById('assetSymbol');
    const cryptoAmountInput = document.getElementById('cryptoAmount');

    // Guard against missing DOM elements
    if (!depositMethodSelect || !depositForm) {
        console.warn('⚠️ Deposit form elements not found');
        return;
    }

    // ================= PRICE FETCHING AND CONVERSION ======================
    /**
     * Fetch current prices for crypto assets
     */
    async function fetchAssetPrices() {
        const now = Date.now();
        // Cache prices for 1 minute
        if (lastPriceFetchTime && (now - lastPriceFetchTime) < 60000 && Object.keys(priceCache).length > 0) {
            return priceCache;
        }

        try {
            const response = await fetch('https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum,tether&vs_currencies=usd');
            const prices = await response.json();
            priceCache = prices;
            lastPriceFetchTime = now;
            return prices;
        } catch (err) {
            console.error('Failed to fetch prices:', err);
            return priceCache; // Return cached if available
        }
    }

    /**
     * Update asset value display with current price and conversion
     */
    async function updateAssetValueDisplay() {
        const method = depositMethodSelect.value;
        const amount = parseFloat(depositAmountInput?.value || 0);

        if (!method || amount <= 0) {
            assetValueDisplay.style.display = 'none';
            return;
        }

        const priceMap = {
            'btc': { id: 'bitcoin', symbol: 'BTC', decimals: 8 },
            'eth': { id: 'ethereum', symbol: 'ETH', decimals: 8 },
            'usdt_trc': { id: 'tether', symbol: 'USDT', decimals: 6 },
            'usdt_erc': { id: 'tether', symbol: 'USDT', decimals: 6 }
        };

        const assetInfo = priceMap[method];
        if (!assetInfo) return;

        const prices = await fetchAssetPrices();
        const price = prices[assetInfo.id]?.usd;

        if (!price) {
            assetValueDisplay.style.display = 'none';
            return;
        }

        const cryptoAmount = amount / price;
        
        // Update display elements
        assetPriceEl.textContent = price.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        cryptoValueDisplayEl.textContent = cryptoAmount.toLocaleString('en-US', { minimumFractionDigits: assetInfo.decimals, maximumFractionDigits: assetInfo.decimals });
        assetSymbolEl.textContent = assetInfo.symbol;

        // Update hidden field
        cryptoAmountInput.value = cryptoAmount.toFixed(assetInfo.decimals);

        assetValueDisplay.style.display = 'block';
    }

    // ================= QR CODE GENERATION ======================
    /**
     * Generate image-based QR code for wallet address
     * Uses QR Server API to generate QR as PNG image
     * @param {string} address - Wallet address to encode
     */
    function generateQRCode(address) {
        const qrElement = document.getElementById('qrCode');

        // Skip if QR already exists for this address
        if (qrElement && qrElement.dataset.qrAddress === address) {
            console.log('✓ QR code already exists for this address');
            return;
        }

        // Prevent concurrent generation
        if (qrGenerationInProgress) {
            console.warn('⚠️ QR generation in progress, skipping duplicate');
            return;
        }

        qrGenerationInProgress = true;

        try {
            // Create fresh QR container
            const qrContainer = document.querySelector('.deposit-qr-container');
            if (!qrContainer) {
                console.warn('⚠️ QR container not found');
                return;
            }

            qrContainer.innerHTML = '';

            // Create image element for QR code
            const qrImg = document.createElement('img');
            qrImg.id = 'qrCode';
            qrImg.className = 'deposit-qr-image';
            qrImg.alt = 'QR Code for ' + address;
            qrImg.dataset.qrAddress = address;

            // Set QR code image source using QR Server API
            // Size: 120x120 (smaller), high error correction
            const qrApiUrl = `https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=${encodeURIComponent(address)}&ecc=H`;
            qrImg.src = qrApiUrl;

            qrImg.onerror = () => {
                console.error('❌ Failed to load QR code image');
                if (typeof iziToast !== 'undefined') {
                    iziToast.error({ title: 'Error', message: 'Failed to generate QR code' });
                }
            };

            qrImg.onload = () => {
                console.log('✓ QR image generated for:', address.substring(0, 10) + '...');
            };

            qrContainer.appendChild(qrImg);
        } catch (error) {
            console.error('❌ QR generation error:', error);
            if (typeof iziToast !== 'undefined') {
                iziToast.error({ title: 'Error', message: 'Failed to generate QR code' });
            }
        } finally {
            // Reset flag after generation completes
            setTimeout(() => {
                qrGenerationInProgress = false;
            }, 200);
        }
    }

    /**
     * Clear QR code from display
     */
    function clearQRCode() {
        const qrElement = document.getElementById('qrCode');
        if (qrElement) {
            qrElement.innerHTML = '';
            qrElement.dataset.qrAddress = '';
        }
    }

    // ================= EVENT HANDLERS ======================
    /**
     * Handle deposit method selection
     */
    if (depositMethodSelect) {
        depositMethodSelect.addEventListener('change', function() {
            const selectedMethod = this.value;

            // Hide wallet card if no method selected
            if (!selectedMethod) {
                walletCard.style.display = 'none';
                receiptGroup.style.display = 'none';
                if (paymentReceiptInput) paymentReceiptInput.required = false;
                currentMethod = null;
                clearQRCode();
                return;
            }

            // Skip if same method selected (avoid duplicate QR generation)
            if (selectedMethod === currentMethod) {
                return;
            }

            // Validate method exists
            if (!walletAddresses[selectedMethod]) {
                if (typeof iziToast !== 'undefined') {
                    iziToast.error({
                        title: 'Error',
                        message: 'Invalid payment method selected'
                    });
                }
                return;
            }

            const walletAddress = walletAddresses[selectedMethod];

            // Validate wallet address is configured
            if (!walletAddress || walletAddress === 'NOT_CONFIGURED' || walletAddress.trim() === '') {
                if (typeof iziToast !== 'undefined') {
                    iziToast.error({
                        title: 'Configuration Error',
                        message: 'Wallet address for ' + walletLabels[selectedMethod] + ' is not configured. Please contact support.'
                    });
                }
                walletCard.style.display = 'none';
                receiptGroup.style.display = 'none';
                currentMethod = null;
                clearQRCode();
                return;
            }

            // Update state
            currentMethod = selectedMethod;

            // Show wallet card and receipt upload
            walletCard.style.display = 'block';
            receiptGroup.style.display = 'block';
            if (paymentReceiptInput) paymentReceiptInput.required = true;

            // Update wallet address display
            walletAddressEl.textContent = walletAddress;

            // Generate QR code (once per address)
            generateQRCode(walletAddress);

            // Update asset value display
            updateAssetValueDisplay();
        });
    }

    /**
     * Update asset value when amount changes
     */
    if (depositAmountInput) {
        depositAmountInput.addEventListener('input', function() {
            updateAssetValueDisplay();
        });
    }

    /**
     * Copy wallet address to clipboard
     */
    if (copyWalletBtn) {
        copyWalletBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const walletAddress = walletAddressEl.textContent;

            if (!walletAddress) {
                if (typeof iziToast !== 'undefined') {
                    iziToast.warning({ title: 'Warning', message: 'No wallet address to copy' });
                }
                return;
            }

            // Try modern clipboard API first
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(walletAddress)
                    .then(() => {
                        const originalText = this.textContent;
                        this.textContent = 'Copied!';
                        setTimeout(() => {
                            this.textContent = originalText;
                        }, 2000);
                    })
                    .catch(() => {
                        fallbackCopy(walletAddress);
                    });
            } else {
                fallbackCopy(walletAddress);
            }
        });

        function fallbackCopy(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            try {
                document.execCommand('copy');
                const originalText = copyWalletBtn.textContent;
                copyWalletBtn.textContent = 'Copied!';
                setTimeout(() => {
                    copyWalletBtn.textContent = originalText;
                }, 2000);
            } catch (err) {
                if (typeof iziToast !== 'undefined') {
                    iziToast.error({ title: 'Error', message: 'Failed to copy address' });
                }
            }
            document.body.removeChild(textarea);
        }
    }

    /**
     * Handle form submission - convert USD to crypto amount before submit
     */
    if (depositForm) {
        depositForm.addEventListener('submit', async function(e) {
            const selectedMethod = depositMethodSelect.value;
            const usdAmount = document.getElementById('depositAmount')?.value;
            const receipt = paymentReceiptInput?.files[0];

            // Validation
            if (!selectedMethod) {
                e.preventDefault();
                alert('Please select a payment method');
                return;
            }

            if (!usdAmount || parseFloat(usdAmount) <= 0) {
                e.preventDefault();
                alert('Please enter a valid amount');
                return;
            }

            if (!receipt) {
                e.preventDefault();
                alert('Please upload payment receipt');
                return;
            }

            if (receipt.size > 5 * 1024 * 1024) {
                e.preventDefault();
                alert('Receipt file must be less than 5MB');
                return;
            }

            // Convert USD to crypto amount before submitting
            e.preventDefault();
            
            try {
                // Fetch current prices
                const priceUrl = `https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum,tether&vs_currencies=usd`;
                const response = await fetch(priceUrl);
                const prices = await response.json();
                
                // Map methods to price keys
                const priceMap = {
                    'btc': 'bitcoin',
                    'eth': 'ethereum',
                    'usdt_trc': 'tether',
                    'usdt_erc': 'tether'
                };
                
                const priceKey = priceMap[selectedMethod];
                if (!prices[priceKey] || !prices[priceKey].usd) {
                    throw new Error('Unable to fetch current price for ' + selectedMethod);
                }
                
                const cryptoPrice = prices[priceKey].usd;
                const cryptoAmount = parseFloat(usdAmount) / cryptoPrice;
                
                // Set the hidden crypto amount field
                document.getElementById('cryptoAmount').value = cryptoAmount.toFixed(8);
                
                // Now submit the form
                depositForm.submit();
                
            } catch (err) {
                console.error('Price conversion error:', err);
                alert('Failed to fetch current prices. Please try again.');
            }
        });
    }

    // ================= INITIALIZATION ======================
    console.log('✓ Deposit page module initialized', {
        walletAddresses: Object.keys(walletAddresses),
        formElement: depositForm ? 'found' : 'missing'
    });

})();
