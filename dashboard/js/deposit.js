/**
 * =============================================
 * DEPOSIT PAGE MODULE
 * =============================================
 * Handles:
 * - Wallet address configuration and display
 * - QR code generation (single per address, no duplicates)
 * - Payment method selection and validation
 * - Form submission and receipt upload
 * - Copy to clipboard functionality
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
     * Generate QR code for wallet address - prevents duplicates
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
            // Create fresh QR element
            const newQrEl = document.createElement('div');
            newQrEl.id = 'qrCode';
            newQrEl.className = 'deposit-qr-element';
            newQrEl.style.padding = '10px';
            newQrEl.style.background = '#fff';
            newQrEl.style.borderRadius = '8px';
            newQrEl.dataset.qrAddress = address; // Track address for deduplication

            // Replace old element
            const qrContainer = document.querySelector('.deposit-qr-container');
            if (qrElement && qrElement.parentNode) {
                qrElement.parentNode.replaceChild(newQrEl, qrElement);
            } else if (qrContainer) {
                qrContainer.innerHTML = '';
                qrContainer.appendChild(newQrEl);
            }

            // Generate QR code
            if (typeof QRCode !== 'undefined') {
                new QRCode(newQrEl, {
                    text: address,
                    width: 150,
                    height: 150,
                    colorDark: '#622faa',
                    colorLight: '#ffffff',
                    correctLevel: QRCode.CorrectLevel.H
                });
                console.log('✓ QR code generated for:', address.substring(0, 10) + '...');
            } else {
                console.error('❌ QRCode library not loaded');
                if (typeof iziToast !== 'undefined') {
                    iziToast.error({ title: 'Error', message: 'QR code library not available' });
                }
            }
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
     * Handle form submission
     */
    if (depositForm) {
        depositForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const selectedMethod = depositMethodSelect.value;
            const amount = document.getElementById('depositAmount')?.value;
            const receipt = paymentReceiptInput?.files[0];
            const walletAddress = walletAddressEl.textContent;

            // Validation
            if (!selectedMethod) {
                if (typeof iziToast !== 'undefined') {
                    iziToast.error({ title: 'Error', message: 'Please select a payment method' });
                }
                return;
            }

            if (!amount || parseFloat(amount) <= 0) {
                if (typeof iziToast !== 'undefined') {
                    iziToast.error({ title: 'Error', message: 'Please enter a valid amount' });
                }
                return;
            }

            if (!receipt) {
                if (typeof iziToast !== 'undefined') {
                    iziToast.error({ title: 'Error', message: 'Please upload payment receipt' });
                }
                return;
            }

            if (!walletAddress || walletAddress === 'NOT_CONFIGURED') {
                if (typeof iziToast !== 'undefined') {
                    iziToast.error({ title: 'Error', message: 'Wallet address is not configured' });
                }
                return;
            }

            // Validate file size (max 5MB)
            if (receipt.size > 5 * 1024 * 1024) {
                if (typeof iziToast !== 'undefined') {
                    iziToast.error({ title: 'Error', message: 'Receipt file must be less than 5MB' });
                }
                return;
            }

            // Submit deposit
            submitDeposit(selectedMethod, amount, receipt, walletAddress);
        });
    }

    /**
     * Submit deposit via AJAX
     */
    function submitDeposit(method, amount, receipt, address) {
        const formData = new FormData();
        formData.append('action', 'deposit');
        formData.append('deposit_method', method);
        formData.append('deposit_amount', amount);
        formData.append('wallet_address', address);
        formData.append('payment_receipt', receipt);

        fetch('code.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (typeof iziToast !== 'undefined') {
                        iziToast.success({
                            title: 'Success',
                            message: 'Deposit submitted successfully. Your transaction is pending verification.',
                            onClosed: () => {
                                depositForm.reset();
                                walletCard.style.display = 'none';
                                receiptGroup.style.display = 'none';
                                clearQRCode();
                                currentMethod = null;
                            }
                        });
                    }
                } else {
                    if (typeof iziToast !== 'undefined') {
                        iziToast.error({
                            title: 'Error',
                            message: data.message || 'Failed to submit deposit'
                        });
                    }
                }
            })
            .catch(error => {
                console.error('❌ Deposit submission error:', error);
                if (typeof iziToast !== 'undefined') {
                    iziToast.error({
                        title: 'Error',
                        message: 'An error occurred. Please try again.'
                    });
                }
            });
    }

    // ================= INITIALIZATION ======================
    console.log('✓ Deposit page module initialized', {
        walletAddresses: Object.keys(walletAddresses),
        formElement: depositForm ? 'found' : 'missing'
    });

})();
