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

    // ================= DOM ELEMENTS ======================
    const depositMethodSelect = document.getElementById('depositMethod');
    const walletCard = document.getElementById('walletCard');
    const receiptGroup = document.getElementById('receiptGroup');
    const walletAddressEl = document.getElementById('walletAddress');
    const copyWalletBtn = document.getElementById('copyWalletBtn');
    const paymentReceiptInput = document.getElementById('paymentReceipt');
    const depositForm = document.getElementById('depositForm');

    // Guard against missing DOM elements
    if (!depositMethodSelect || !depositForm) {
        console.warn('⚠️ Deposit form elements not found');
        return;
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
     * Handle form submission - let form submit naturally via POST
     */
    if (depositForm) {
        depositForm.addEventListener('submit', function(e) {
            // Allow traditional form submission
            // Just validate that wallet and receipt are selected
            const selectedMethod = depositMethodSelect.value;
            const amount = document.getElementById('depositAmount')?.value;
            const receipt = paymentReceiptInput?.files[0];

            // Validation
            if (!selectedMethod) {
                e.preventDefault();
                alert('Please select a payment method');
                return;
            }

            if (!amount || parseFloat(amount) <= 0) {
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

            // Allow form to submit naturally
        });
    }

    // ================= INITIALIZATION ======================
    console.log('✓ Deposit page module initialized', {
        walletAddresses: Object.keys(walletAddresses),
        formElement: depositForm ? 'found' : 'missing'
    });

})();
