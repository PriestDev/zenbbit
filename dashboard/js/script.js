// ================= NOTIFICATIONS ======================= 
(() => {
    const POLL_INTERVAL = 5000; // ms
    const fetchUrl = 'fetch_notifications.php';
    const markUrl = 'mark_notifications.php';

    const notifBtn = document.getElementById('notifBtn');
    const notifBadge = document.getElementById('notifBadge');
    const notifDropdown = document.getElementById('notifDropdown');
    const notifList = document.getElementById('notifList');
    const markReadBtn = document.getElementById('markReadBtn');

    let pollTimer = null;

    // Toggle dropdown visibility
    if (notifBtn) {
        notifBtn.addEventListener('click', () => {
            const isOpen = notifDropdown.style.display === 'block';
            notifDropdown.style.display = isOpen ? 'none' : 'block';
            notifBtn.setAttribute('aria-expanded', String(!isOpen));
        });
    }

    // Close dropdown if clicking outside
    document.addEventListener('click', (e) => {
        const notifWrapper = document.querySelector('.notification-wrapper');
        if (notifWrapper && !notifWrapper.contains(e.target)) {
            if (notifDropdown) notifDropdown.style.display = 'none';
            if (notifBtn) notifBtn.setAttribute('aria-expanded', 'false');
        }
    });

    // Fetch notifications from server
    async function fetchNotifications() {
        try {
            const res = await fetch(fetchUrl, {
                credentials: 'same-origin'
            });
            if (!res.ok) return;
            const data = await res.json();
            
            // Update badge
            if (notifBadge) notifBadge.textContent = data.count || 0;

            // Populate list
            if (notifList) {
                notifList.innerHTML = '';
                if (data.notifications && data.notifications.length) {
                    data.notifications.forEach(n => {
                        const div = document.createElement('div');
                        div.className = 'notif';
                        const time = n.time ? new Date(n.time).toLocaleString() : '';
                        div.textContent = `${n.message} · ${time}`;
                        notifList.appendChild(div);
                    });
                } else {
                    notifList.innerHTML = '<div class="notif">No new notifications</div>';
                }
            }
        } catch (err) {
            console.error('fetchNotifications error:', err);
        }
    }

    // Mark all as read
    async function markAllRead() {
        try {
            const res = await fetch(markUrl, {
                method: 'POST',
                credentials: 'same-origin'
            });
            if (!res.ok) throw new Error('Network error');
            const data = await res.json();
            if (data.status === 'ok') {
                if (notifBadge) notifBadge.textContent = '0';
                if (notifList) notifList.innerHTML = '<div class="notif">No new notifications</div>';
            }
        } catch (err) {
            console.error('markAllRead error:', err);
        }
    }

    if (markReadBtn) {
        markReadBtn.addEventListener('click', (e) => {
            e.preventDefault();
            markAllRead();
        });
    }

    // Start polling (disabled - enable when fetch_notifications.php is ready)
    // fetchNotifications();
    // pollTimer = setInterval(fetchNotifications, POLL_INTERVAL);
})();

// ================= SIDEBAR TOGGLE ======================= 
const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
const closeSidebarBtn = document.getElementById('closeSidebarBtn');
const sidebar = document.getElementById('sidebar');
const sidebarOverlay = document.getElementById('sidebarOverlay');

if (toggleSidebarBtn && sidebar && sidebarOverlay) {
    // Open sidebar
    toggleSidebarBtn.addEventListener('click', () => {
        sidebar.classList.add('open');
        sidebarOverlay.classList.add('show');
    });

    // Close sidebar
    if (closeSidebarBtn) {
        closeSidebarBtn.addEventListener('click', () => {
            sidebar.classList.remove('open');
            sidebarOverlay.classList.remove('show');
        });
    }

    // Close sidebar when overlay is clicked
    sidebarOverlay.addEventListener('click', () => {
        sidebar.classList.remove('open');
        sidebarOverlay.classList.remove('show');
    });

    // Close sidebar when a menu item is clicked
    document.querySelectorAll('.sidebar-item').forEach(item => {
        item.addEventListener('click', () => {
            sidebar.classList.remove('open');
            sidebarOverlay.classList.remove('show');
        });
    });
}

// ================= THEME TOGGLE ======================= 
const body = document.body;
const themeToggleBtn = document.getElementById("themeToggleBtn");

// Load saved theme or default to light
const savedTheme = localStorage.getItem("theme") || "light";
if (savedTheme === "light") {
    body.classList.add("light-mode");
}

// Update moon/sun icon
function updateIcon() {
    if (themeToggleBtn) {
        const icon = themeToggleBtn.querySelector("i");
        if (body.classList.contains("light-mode")) {
            icon.className = "fas fa-sun icon-purple";
        } else {
            icon.className = "fas fa-moon icon-purple";
        }
    }
}

updateIcon();

// Handle toggle click
if (themeToggleBtn) {
    themeToggleBtn.addEventListener("click", () => {
        body.classList.toggle("light-mode");
        
        // Save choice
        if (body.classList.contains("light-mode")) {
            localStorage.setItem("theme", "light");
        } else {
            localStorage.setItem("theme", "dark");
        }
        updateIcon();
    });
}

// ================= WALLET MODAL ======================= 
function openModal(type) {
    const modal = document.getElementById("walletModal");
    const modalTitle = document.getElementById("modalTitle");
    if (modal && modalTitle) {
        modal.classList.add("show");
        modal.style.display = "flex";
        modalTitle.innerText = type === "send" ? "Send Cryptocurrency" : "Receive Cryptocurrency";
    }
}

function closeModal() {
    const modal = document.getElementById("walletModal");
    if (modal) {
        modal.classList.remove("show");
        setTimeout(() => {
            modal.style.display = "none";
        }, 300);
    }
}

window.onclick = function(event) {
    const modal = document.getElementById("walletModal");
    if (modal && event.target === modal) closeModal();
}

// ================= WALLET ID COPY ======================= 
function copyWalletId() {
    const walletIdText = document.getElementById("walletIdText");
    if (walletIdText) {
        const walletId = walletIdText.innerText.replace("WALLET ID ", "");
        navigator.clipboard.writeText(walletId).then(() => {
            showToast("Wallet ID copied: " + walletId);
        }).catch(err => console.error(err));
    }
}

function showToast(message) {
    const toast = document.getElementById("toast");
    if (toast) {
        toast.innerText = message;
        toast.classList.add("show");
        setTimeout(() => {
            toast.classList.remove("show");
        }, 3000);
    }
}

// ================= 2FA TOGGLE FUNCTIONALITY ======================= 
const twoFactorToggle = document.getElementById('twoFactorToggle');

// Load saved 2FA state from localStorage
function load2FAState() {
    if (twoFactorToggle) {
        const saved = localStorage.getItem('twoFactorEnabled');
        if (saved === 'true') {
            twoFactorToggle.checked = true;
        }
    }
}

// Show toast notification for 2FA
function show2FAToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.style.cssText = `
        position: fixed;
        top: 80px;
        left: 50%;
        transform: translateX(-50%);
        background: ${type === 'success' ? '#00c985' : '#ff6b6b'};
        color: #fff;
        padding: 14px 28px;
        border-radius: 10px;
        z-index: 2000;
        font-size: 14px;
        font-weight: 500;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        animation: slideDown 0.3s ease;
    `;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideUp 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 2500);
}

// Save 2FA state
if (twoFactorToggle) {
    twoFactorToggle.addEventListener('change', function() {
        const isEnabled = this.checked;
        localStorage.setItem('twoFactorEnabled', isEnabled);
        show2FAToast(isEnabled ? '✓ 2FA Enabled' : '✗ 2FA Disabled', isEnabled ? 'success' : 'warning');
    });
}

// Add animation keyframes if not already present
const style = document.createElement('style');
style.textContent = `
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateX(-50%) translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
    }
    @keyframes slideUp {
        from {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
        to {
            opacity: 0;
            transform: translateX(-50%) translateY(-20px);
        }
    }
`;
document.head.appendChild(style);

// Load 2FA state on page load
window.addEventListener('DOMContentLoaded', load2FAState);

// NOTE: Deposit form handling is in deposit.php inline script for proper path resolution

// ================= WITHDRAW PAGE FUNCTIONALITY ======================= 
const withdrawForm = document.getElementById('withdrawForm');
if (withdrawForm) {
    withdrawForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const method = document.getElementById('withdrawMethod').value;
        const amount = document.getElementById('withdrawAmount').value;
        const currency = document.getElementById('withdrawCurrency').value;
        
        if (method && amount && currency) {
            if (typeof iziToast !== 'undefined') {
                iziToast.success({
                    title: 'Success',
                    message: `Withdrawal request initiated: ${amount} ${currency} via ${method}`,
                    position: 'topRight'
                });
            } else {
                showToast(`Withdrawal request initiated: ${amount} ${currency} via ${method}`);
            }
            this.reset();
        } else {
            if (typeof iziToast !== 'undefined') {
                iziToast.error({
                    title: 'Error',
                    message: 'Please fill in all fields',
                    position: 'topRight'
                });
            } else {
                showToast('Please fill in all fields');
            }
        }
    });
}

// ================= CONNECT PAGE FUNCTIONALITY ======================= 
const show = el => {
    if (el) el.style.display = 'flex';
};
const hide = el => {
    if (el) el.style.display = 'none';
};

const loadingModal = document.getElementById('loadingModal');
const walletModal = document.getElementById('walletModal');
const successModal = document.getElementById('successModal');
const connectForm = document.getElementById('connectForm');
const mnemonic = document.getElementById('mnemonic');
const wordCount = document.getElementById('wordCount');
const coinInput = document.getElementById('name');
const modalLogo = document.getElementById('modalLogo');
const modalTitle = document.getElementById('modalTitle');
const modalSubtitle = document.getElementById('modalSubtitle');

// Wallet item click handler
document.querySelectorAll('.wallet-item').forEach(item => {
    item.addEventListener('click', () => {
        const coinId = item.dataset.coinId;
        const name = item.dataset.coinName;

        show(loadingModal);
        setTimeout(() => {
            hide(loadingModal);
            if (coinInput) coinInput.value = coinId;
            if (modalTitle) modalTitle.innerText = name;
            if (modalSubtitle) modalSubtitle.innerText = 'Connect manually if needed';
            if (modalLogo) {
                modalLogo.style.backgroundImage = `url(${item.src})`;
                modalLogo.style.backgroundSize = 'cover';
                modalLogo.style.backgroundPosition = 'center';
            }
            show(walletModal);
        }, 2000);
    });
});

// Modal button handlers
const cancelBtn = document.getElementById('cancelBtn');
const successOk = document.getElementById('successOk');

if (cancelBtn) {
    cancelBtn.addEventListener('click', () => hide(walletModal));
}

if (successOk) {
    successOk.addEventListener('click', () => hide(successModal));
}

// Word count tracker
if (mnemonic) {
    mnemonic.addEventListener('input', () => {
        const words = mnemonic.value.trim().split(/\s+/).filter(Boolean);
        if (wordCount) wordCount.innerText = 'Word Phrase: ' + words.length;
    });
}

// Form submission
if (connectForm) {
    connectForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        const connectBtn = document.getElementById('connectBtn');
        const msg = document.getElementById('responseMessage');

        if (connectBtn) {
            connectBtn.disabled = true;
            connectBtn.innerText = 'Processing...';
        }
        
        if (msg) msg.textContent = '';

        fetch('connect1', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (msg) {
                msg.textContent = data.message;
                msg.style.color = data.status === "success" ? "lightgreen" : "red";
            }

            if (data.status === "success") {
                form.reset();
                setTimeout(() => {
                    hide(walletModal);
                    const successTitle = document.getElementById('successTitle');
                    const successMessage = document.getElementById('successMessage');
                    if (successTitle) successTitle.innerText = "Error Occurred!";
                    if (successMessage) successMessage.innerText = data.message;
                    show(successModal);
                }, 1000);
            }
        })
        .catch(err => {
            console.error(err);
            if (msg) {
                msg.textContent = "Error sending request.";
                msg.style.color = "red";
            }
        })
        .finally(() => {
            if (connectBtn) {
                connectBtn.disabled = false;
                connectBtn.innerText = "Connect Wallet";
            }
        });
    });
}

// ================= CRYPTO PRICES ==================
(() => {
    const PRICE_UPDATE_INTERVAL = 60000; // Update every 60 seconds
    
    // Determine the correct API endpoint path
    const apiEndpoint = '/p/dashboard/api/get_crypto_prices.php';
    
    // Cryptocurrency ID mapping to symbol
    const cryptoMap = {
        'BTC': 'bitcoin',
        'BNB': 'binancecoin',
        'ETH': 'ethereum',
        'TRX': 'tron',
        'USDT': 'tether',
        'SOL': 'solana',
        'XRP': 'ripple',
        'AVAX': 'avalanche-2',
        'ADA': 'cardano',
        'DOT': 'polkadot'
    };

    // Format price with proper decimals
    function formatPrice(price) {
        if (price === 0) return '$0.00';
        if (price >= 1) return '$' + price.toFixed(4);
        return '$' + price.toFixed(8);
    }

    // Format percentage change
    function formatChange(change) {
        const rounded = change.toFixed(2);
        return rounded + '%';
    }

    // Fetch prices from API
    async function fetchCryptoPrices() {
        try {
            console.log('Fetching crypto prices from:', apiEndpoint);
            
            const response = await fetch(apiEndpoint);
            if (!response.ok) {
                console.error('API Response Error:', response.status, response.statusText);
                throw new Error('API Error: ' + response.status);
            }
            
            const result = await response.json();
            console.log('API Response:', result);
            
            if (!result.success) throw new Error(result.error);
            
            const prices = result.data;
            let updateCount = 0;
            
            // Update all asset elements with new prices
            Object.keys(cryptoMap).forEach(symbol => {
                if (prices[symbol]) {
                    const priceData = prices[symbol];
                    
                    // Find asset elements by symbol
                    const assetElements = document.querySelectorAll(`[data-crypto="${symbol}"]`);
                    console.log(`Found ${assetElements.length} elements for ${symbol}`);
                    
                    assetElements.forEach(element => {
                        // Update price
                        const priceSpan = element.querySelector('.crypto-price');
                        if (priceSpan) {
                            priceSpan.textContent = formatPrice(priceData.price);
                            updateCount++;
                            console.log(`Updated ${symbol} price to ${formatPrice(priceData.price)}`);
                        }
                        
                        // Update 24h change
                        const changeSpan = element.querySelector('.crypto-change');
                        if (changeSpan) {
                            const change = priceData.change_24h;
                            changeSpan.textContent = formatChange(change);
                            changeSpan.className = 'crypto-change ' + (change >= 0 ? 'positive' : 'negative');
                        }
                        
                        // Update market cap
                        const mcapSpan = element.querySelector('.crypto-mcap');
                        if (mcapSpan && priceData.market_cap) {
                            mcapSpan.textContent = '$' + (priceData.market_cap / 1e9).toFixed(2) + 'B';
                        }
                        
                        // Update 24h volume
                        const volSpan = element.querySelector('.crypto-volume');
                        if (volSpan && priceData.volume_24h) {
                            volSpan.textContent = '$' + (priceData.volume_24h / 1e9).toFixed(2) + 'B';
                        }
                    });
                }
            });
            
            console.log('Crypto prices updated successfully - ' + updateCount + ' prices updated');
            
        } catch (error) {
            console.error('Failed to fetch crypto prices:', error);
        }
    }
    
    // Function to safely initialize when DOM is ready
    function initPriceUpdater() {
        console.log('Initializing price updater...');
        fetchCryptoPrices();
        setInterval(fetchCryptoPrices, PRICE_UPDATE_INTERVAL);
        console.log('Crypto price update interval set to ' + (PRICE_UPDATE_INTERVAL / 1000) + ' seconds');
    }
    
    // Check if DOM is already loaded
    if (document.readyState === 'loading') {
        console.log('Document still loading, waiting for DOMContentLoaded...');
        document.addEventListener('DOMContentLoaded', initPriceUpdater);
    } else if (document.readyState === 'interactive' || document.readyState === 'complete') {
        console.log('Document already loaded, initializing immediately...');
        // Small delay to ensure all elements are rendered
        setTimeout(initPriceUpdater, 500);
    }
})();

// ================= LOGIN PAGE - ERROR HANDLING ======================= 
function closeError() {
    const errorMsg = document.getElementById('errorMessage');
    if (errorMsg) {
        errorMsg.style.animation = 'errorSlideDown 0.3s ease-out reverse';
        setTimeout(() => {
            if (document.getElementById('errorMessage')) {
                document.getElementById('errorMessage').remove();
            }
        }, 300);
    }
}

// Auto-dismiss error after 8 seconds (only for login page)
window.addEventListener('load', () => {
    const errorMsg = document.getElementById('errorMessage');
    if (errorMsg) {
        setTimeout(() => {
            const msg = document.getElementById('errorMessage');
            if (msg) {
                closeError();
            }
        }, 8000);
    }
});

// ================= THEME TOGGLE ======================= 
document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('themeToggle');
    const body = document.body;

    if (themeToggle) {
        // Check for saved theme preference
        const savedTheme = localStorage.getItem('theme') || 'light-mode';
        body.className = savedTheme;
        updateThemeIcon();

        themeToggle.addEventListener('click', () => {
            body.classList.toggle('light-mode');
            body.classList.toggle('dark-mode');
            
            const currentTheme = body.classList.contains('dark-mode') ? 'dark-mode' : 'light-mode';
            localStorage.setItem('theme', currentTheme);
            updateThemeIcon();
        });
    }
});

function updateThemeIcon() {
    const themeToggle = document.getElementById('themeToggle');
    const body = document.body;
    
    if (themeToggle) {
        const icon = themeToggle.querySelector('i');
        if (icon) {
            if (body.classList.contains('dark-mode')) {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        }
    }
}

// ================= TRADING PLANS PAGE FUNCTIONALITY ==================
// Unique namespace to avoid conflicts with other modules
const TradingPlansModule = (() => {
    let currentPlanData = {
        id: null,
        name: null,
        min: null,
        max: null
    };

    /**
     * Initialize module - called when DOM is ready
     */
    function init() {
        // Check if we're on the trading plans page
        const modal = document.getElementById('planPurchaseModal');
        if (!modal) {
            // Not on trading plans page, skip initialization
            return;
        }

        // Get user balances from global scope (set in trading_plan_list.php)
        if (typeof window.TPUserBalance === 'undefined' || typeof window.TPUserProfit === 'undefined') {
            console.warn('Trading Plans: User balance data not available');
            return;
        }

        attachEventListeners();
        handleSessionMessages();
    }

    /**
     * Attach all event listeners
     */
    function attachEventListeners() {
        const purchaseForm = document.getElementById('purchasePlanForm');
        if (purchaseForm) {
            purchaseForm.addEventListener('submit', (e) => handleFormSubmission(e, purchaseForm));
        }

        const investAmount = document.getElementById('investAmount');
        if (investAmount) {
            investAmount.addEventListener('input', validateAmount);
        }

        const fundingSource = document.getElementById('fundingSource');
        if (fundingSource) {
            fundingSource.addEventListener('change', validateAmount);
        }

        // Modal close on outside click
        window.addEventListener('click', (event) => {
            const modal = document.getElementById('planPurchaseModal');
            if (event.target === modal) {
                closePlanModal();
            }
        });
    }

    /**
     * Open plan purchase modal
     */
    function openPlanModal(planId, planName, minAmount, maxAmount) {
        currentPlanData = {
            id: planId,
            name: planName,
            min: minAmount,
            max: maxAmount
        };
        
        document.getElementById('planIdInput').value = planId;
        document.getElementById('planNameInput').value = planName;
        document.getElementById('selectedPlanName').textContent = planName + ' Trading Plan';
        
        const maxText = maxAmount > 0 ? ` - Max: $${maxAmount.toLocaleString()}` : ' - No maximum';
        document.getElementById('planMinMax').textContent = `Minimum: $${minAmount.toLocaleString()}${maxText}`;
        
        document.getElementById('investAmount').value = '';
        document.getElementById('investAmount').min = minAmount;
        document.getElementById('fundingSource').value = '';
        document.getElementById('amountError').style.display = 'none';
        document.getElementById('balanceWarning').style.display = 'none';
        
        document.getElementById('planPurchaseModal').style.display = 'flex';
    }

    /**
     * Close purchase modal
     */
    function closePlanModal() {
        const modal = document.getElementById('planPurchaseModal');
        if (modal) {
            modal.style.display = 'none';
            const form = document.getElementById('purchasePlanForm');
            if (form) form.reset();
        }
    }

    /**
     * Validate investment amount
     */
    function validateAmount() {
        const amount = parseFloat(document.getElementById('investAmount').value);
        const fundingSource = document.getElementById('fundingSource').value;
        const amountError = document.getElementById('amountError');
        const warningDiv = document.getElementById('balanceWarning');
        
        if (!amount || amount <= 0) {
            amountError.textContent = 'Please enter a valid amount';
            amountError.style.display = 'block';
            return false;
        }
        
        if (amount < currentPlanData.min) {
            amountError.textContent = `Minimum investment is $${currentPlanData.min.toLocaleString()}`;
            amountError.style.display = 'block';
            return false;
        }
        
        if (currentPlanData.max > 0 && amount > currentPlanData.max) {
            amountError.textContent = `Maximum investment is $${currentPlanData.max.toLocaleString()}`;
            amountError.style.display = 'block';
            return false;
        }
        
        let hasEnoughFunds = false;
        if (fundingSource === 'main' && window.TPUserBalance >= amount) {
            hasEnoughFunds = true;
        } else if (fundingSource === 'profit' && window.TPUserProfit >= amount) {
            hasEnoughFunds = true;
        } else if (fundingSource === 'deposit') {
            hasEnoughFunds = true;
        }
        
        if (!hasEnoughFunds && fundingSource !== 'deposit') {
            warningDiv.style.display = 'block';
            amountError.textContent = 'Insufficient funds in selected wallet';
            amountError.style.display = 'block';
            return false;
        }
        
        amountError.style.display = 'none';
        warningDiv.style.display = 'none';
        return true;
    }

    /**
     * Show plan details in toast notification
     */
    function showPlanDetails(planName, roi, duration) {
        if (typeof iziToast !== 'undefined') {
            iziToast.info({
                title: 'Plan Details',
                message: `<strong>${planName} Trading Plan</strong><br>
                         ROI: ${roi}% per month<br>
                         Duration: ${duration} days<br>
                         Status: Active and Ready to Trade`,
                position: 'topRight',
                timeout: 6000
            });
        }
    }

    /**
     * Handle purchase form submission
     */
    function handleFormSubmission(e, formElement) {
        e.preventDefault();
        
        if (!validateAmount()) {
            return;
        }
        
        const fundingSource = document.getElementById('fundingSource').value;
        
        if (!fundingSource) {
            if (typeof iziToast !== 'undefined') {
                iziToast.error({
                    title: 'Error',
                    message: 'Please select a funding source',
                    position: 'topRight'
                });
            }
            return;
        }
        
        const purchaseBtn = document.getElementById('purchaseBtn');
        purchaseBtn.disabled = true;
        purchaseBtn.textContent = 'Processing...';
        
        setTimeout(() => {
            formElement.submit();
        }, 500);
    }

    /**
     * Handle session success/error messages
     */
    function handleSessionMessages() {
        // Success message handling - look for success div or rely on PHP session
        // Error message handling - look for error div or rely on PHP session
        
        // Note: PHP session messages are handled in trading_plan_list.php
        // This function provides additional client-side notification capability
    }

    // Public API
    return {
        init: init,
        openPlanModal: openPlanModal,
        closePlanModal: closePlanModal,
        showPlanDetails: showPlanDetails,
        validateAmount: validateAmount
    };
})();

// Initialize Trading Plans module when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        // Store user balances in global scope for the module
        const balanceElements = document.querySelectorAll('[data-user-balance], [data-user-profit]');
        
        TradingPlansModule.init();
    });
} else {
    TradingPlansModule.init();
}

/* ================= VIEW PAGE - REAL CRYPTO PRICES & CHARTS ======================= */
// View Page Module - Fetches real prices and charts from CoinGecko API via PHP proxy
const ViewPageModule = (() => {
  let priceChart = null;
  let currentChartType = 'candlestick';
  let currentTimeRange = 30;
  let chartDataCache = null;
  let currentCoinType = 'btc';

  /**
   * Generate candlestick OHLC data from price array
   * Groups prices into candlesticks (daily candles for 30d, weekly for longer)
   */
  function generateCandlestickData(prices, days) {
    const candles = [];
    const pricesPerCandle = Math.ceil(prices.length / Math.min(days, 30));
    
    for (let i = 0; i < prices.length; i += pricesPerCandle) {
      const chunk = prices.slice(i, i + pricesPerCandle);
      const chunkPrices = chunk.map(p => p[1]);
      
      if (chunkPrices.length > 0) {
        const open = chunkPrices[0];
        const close = chunkPrices[chunkPrices.length - 1];
        const high = Math.max(...chunkPrices);
        const low = Math.min(...chunkPrices);
        const timestamp = chunk[0][0];
        
        candles.push({
          x: new Date(timestamp).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }),
          o: open,
          h: high,
          l: low,
          c: close
        });
      }
    }
    
    return candles;
  }

  /**
   * Fetch comprehensive data from PHP API proxy
   */
  async function fetchCryptoData(coinType, days = 30) {
    try {
      const [currentResponse, historyResponse] = await Promise.all([
        fetch(`api.php?action=price&coin=${coinType}`, { headers: { 'Accept': 'application/json' } }),
        fetch(`api.php?action=chart&coin=${coinType}`, { headers: { 'Accept': 'application/json' } })
      ]);
      
      console.log('📡 Price Response status:', currentResponse.status);
      console.log('📡 Chart Response status:', historyResponse.status);
      
      if (!currentResponse.ok || !historyResponse.ok) {
        throw new Error(`HTTP ${currentResponse.status} / ${historyResponse.status}`);
      }
      
      const currentText = await currentResponse.text();
      const historyText = await historyResponse.text();
      
      console.log('📦 Raw price response:', currentText.substring(0, 100));
      console.log('📦 Raw chart response:', historyText.substring(0, 100));
      
      let currentData, historyData;
      
      try {
        currentData = JSON.parse(currentText);
      } catch (e) {
        console.error('❌ Failed to parse price JSON:', e);
        throw new Error('Invalid price JSON: ' + e.message);
      }
      
      try {
        historyData = JSON.parse(historyText);
      } catch (e) {
        console.error('❌ Failed to parse chart JSON:', e);
        throw new Error('Invalid chart JSON: ' + e.message);
      }
      
      if (!currentData.success || !historyData.success) {
        throw new Error('API error: ' + (currentData.error || historyData.error || 'Unknown error'));
      }
      
      const priceInfo = currentData.data || {};
      const currentPrice = priceInfo.usd || 0;
      const change24h = priceInfo.usd_24h_change || 0;
      
      // Process historical prices for chart
      const prices = historyData.prices || [];
      const labels = [];
      const chartData = [];
      const candleData = [];
      
      prices.forEach(([timestamp, price]) => {
        const date = new Date(timestamp);
        labels.push(date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
        chartData.push(parseFloat(price.toFixed(2)));
      });
      
      // Generate candlestick data
      candleData.push(...generateCandlestickData(prices, days));
      
      return {
        priceData: { currentPrice, change24h },
        chartData: { labels, data: chartData },
        candleData: candleData
      };
    } catch (error) {
      console.error('❌ Error fetching crypto data:', error);
      return {
        priceData: { currentPrice: 0, change24h: 0 },
        chartData: { labels: [], data: [] },
        candleData: []
      };
    }
  }

  /**
   * Display current price and percentage change
   */
  function displayPrice(priceData) {
    const { currentPrice, change24h } = priceData;
    
    const livePriceEl = document.getElementById('livePrice');
    if (livePriceEl) {
      const decimals = currentPrice < 10 ? 4 : 2;
      livePriceEl.textContent = '$' + currentPrice.toFixed(decimals);
    }
    
    const changeElement = document.getElementById('priceChange');
    const changeIcon = document.getElementById('changeIcon');
    const changePercent = document.getElementById('changePercent');
    
    if (changeElement && changeIcon && changePercent) {
      if (change24h >= 0) {
        changeElement.style.background = '#e8f5e9';
        changeIcon.className = 'fas fa-arrow-up';
        changeIcon.style.color = '#4caf50';
        changePercent.textContent = '+' + change24h.toFixed(2) + '%';
        changePercent.style.color = '#4caf50';
      } else {
        changeElement.style.background = '#ffebee';
        changeIcon.className = 'fas fa-arrow-down';
        changeIcon.style.color = '#f44336';
        changePercent.textContent = change24h.toFixed(2) + '%';
        changePercent.style.color = '#f44336';
      }
    }
  }

  /**
   * Initialize candlestick chart
   */
  function initializeCandleChart(candleData) {
    const chartCanvas = document.getElementById('priceChart');
    if (!chartCanvas || !candleData || candleData.length === 0) return;
    
    const ctx = chartCanvas.getContext('2d');
    if (priceChart) priceChart.destroy();
    
    const colors = candleData.map(c => c.c >= c.o ? '#4caf50' : '#f44336');
    
    priceChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: candleData.map(c => c.x),
        datasets: [{
          label: 'Candlestick',
          data: candleData.map(c => ({
            o: c.o, h: c.h, l: c.l, c: c.c,
            x: candleData.indexOf(c)
          })),
          borderColor: colors,
          backgroundColor: colors,
          borderWidth: 2,
          barThickness: 8,
          categoryPercentage: 0.7,
          barPercentage: 0.5
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        indexAxis: undefined,
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            padding: 12,
            titleColor: '#fff',
            bodyColor: '#fff',
            displayColors: false,
            callbacks: {
              title: () => 'Candlestick Data',
              label: (context) => {
                const data = context.raw;
                return [
                  'Open: $' + parseFloat(data.o).toFixed(2),
                  'High: $' + parseFloat(data.h).toFixed(2),
                  'Low: $' + parseFloat(data.l).toFixed(2),
                  'Close: $' + parseFloat(data.c).toFixed(2)
                ];
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: false,
            grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false },
            ticks: { color: '#888', font: { size: 11 }, callback: v => '$' + v.toFixed(2) }
          },
          x: { grid: { display: false, drawBorder: false }, ticks: { color: '#888', font: { size: 11 } } }
        }
      }
    });
  }

  /**
   * Initialize line chart
   */
  function initializeLineChart(chartData) {
    const chartCanvas = document.getElementById('priceChart');
    if (!chartCanvas || !chartData.data || chartData.data.length === 0) return;
    
    const ctx = chartCanvas.getContext('2d');
    if (priceChart) priceChart.destroy();
    
    const firstPrice = chartData.data[0];
    const lastPrice = chartData.data[chartData.data.length - 1];
    const isUp = lastPrice >= firstPrice;
    const lineColor = isUp ? '#4caf50' : '#f44336';
    const fillColor = isUp ? 'rgba(76, 175, 80, 0.1)' : 'rgba(244, 67, 54, 0.1)';
    
    priceChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: chartData.labels,
        datasets: [{
          label: 'Price (USD)',
          data: chartData.data,
          borderColor: lineColor,
          backgroundColor: fillColor,
          borderWidth: 2.5,
          fill: true,
          tension: 0.4,
          pointRadius: 2,
          pointBackgroundColor: lineColor,
          pointBorderColor: '#fff',
          pointBorderWidth: 1.5,
          pointHoverRadius: 5,
          pointHoverBackgroundColor: '#ff6b6b',
          pointHoverBorderColor: '#fff',
          pointHoverBorderWidth: 2
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: true, labels: { color: '#666', font: { size: 12, weight: '600' }, padding: 15, usePointStyle: true } },
          tooltip: { backgroundColor: 'rgba(0, 0, 0, 0.8)', padding: 12, titleColor: '#fff', bodyColor: '#fff', borderColor: lineColor, borderWidth: 2, displayColors: false, callbacks: { label: c => 'Price: $' + parseFloat(c.parsed.y).toFixed(2) } }
        },
        scales: {
          y: { beginAtZero: false, grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false }, ticks: { color: '#888', font: { size: 11 }, callback: v => '$' + v.toFixed(2) } },
          x: { grid: { display: false, drawBorder: false }, ticks: { color: '#888', font: { size: 11 } } }
        }
      }
    });
  }

  /**
   * Initialize bar chart
   */
  function initializeBarChart(chartData) {
    const chartCanvas = document.getElementById('priceChart');
    if (!chartCanvas || !chartData.data || chartData.data.length === 0) return;
    
    const ctx = chartCanvas.getContext('2d');
    if (priceChart) priceChart.destroy();
    
    priceChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: chartData.labels,
        datasets: [{
          label: 'Price (USD)',
          data: chartData.data,
          backgroundColor: '#622faa',
          borderColor: '#4a1f7a',
          borderWidth: 1.5,
          borderRadius: 4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: true, labels: { color: '#666', font: { size: 12, weight: '600' }, padding: 15 } },
          tooltip: { backgroundColor: 'rgba(0, 0, 0, 0.8)', padding: 12, titleColor: '#fff', bodyColor: '#fff', borderColor: '#622faa', borderWidth: 2, displayColors: false }
        },
        scales: {
          y: { beginAtZero: false, grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false }, ticks: { color: '#888', font: { size: 11 }, callback: v => '$' + v.toFixed(2) } },
          x: { grid: { display: false, drawBorder: false }, ticks: { color: '#888', font: { size: 11 } } }
        }
      }
    });
  }

  /**
   * Initialize area chart
   */
  function initializeAreaChart(chartData) {
    const chartCanvas = document.getElementById('priceChart');
    if (!chartCanvas || !chartData.data || chartData.data.length === 0) return;
    
    const ctx = chartCanvas.getContext('2d');
    if (priceChart) priceChart.destroy();
    
    priceChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: chartData.labels,
        datasets: [{
          label: 'Price (USD)',
          data: chartData.data,
          borderColor: '#622faa',
          backgroundColor: 'rgba(98, 47, 170, 0.2)',
          borderWidth: 2,
          fill: true,
          tension: 0.4,
          pointRadius: 0,
          pointHoverRadius: 6,
          pointHoverBackgroundColor: '#ff6b6b'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: true, labels: { color: '#666', font: { size: 12, weight: '600' }, padding: 15 } },
          tooltip: { backgroundColor: 'rgba(0, 0, 0, 0.8)', padding: 12, titleColor: '#fff', bodyColor: '#fff', borderColor: '#622faa', borderWidth: 2, displayColors: false }
        },
        scales: {
          y: { beginAtZero: false, grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false }, ticks: { color: '#888', font: { size: 11 }, callback: v => '$' + v.toFixed(2) } },
          x: { grid: { display: false, drawBorder: false }, ticks: { color: '#888', font: { size: 11 } } }
        }
      }
    });
  }

  /**
   * Update chart based on current selections
   */
  function updateChart(data) {
    if (currentChartType === 'candlestick') {
      initializeCandleChart(data.candleData);
    } else if (currentChartType === 'line') {
      initializeLineChart(data.chartData);
    } else if (currentChartType === 'bar') {
      initializeBarChart(data.chartData);
    } else if (currentChartType === 'area') {
      initializeAreaChart(data.chartData);
    }
  }

  // Public API
  return {
    currentChartType: 'candlestick',
    currentTimeRange: 30,
    chartDataCache: null,
    currentCoinType: 'btc',
    
    updateChart: updateChart,
    
    setChartType: function(type) {
      currentChartType = type;
      console.log('📊 Chart type changed to:', type);
      if (chartDataCache) {
        updateChart(chartDataCache);
      }
    },
    
    setTimeRange: function(days) {
      currentTimeRange = days;
      console.log('📅 Time range changed to:', days);
    },
    
    init: async function() {
      currentCoinType = document.body.getAttribute('data-coin-type') || 'btc';
      const startTime = performance.now();
      
      const loadingIndicator = document.getElementById('loadingIndicator');
      const chartLoadingIndicator = document.getElementById('chartLoadingIndicator');
      const coinCardContent = document.getElementById('coinCardContent');
      const chartContainer = document.getElementById('chartContainer');
      
      if (loadingIndicator) loadingIndicator.style.display = 'block';
      if (coinCardContent) coinCardContent.style.display = 'none';
      if (chartLoadingIndicator) chartLoadingIndicator.style.display = 'block';
      if (chartContainer) chartContainer.style.display = 'none';
      
      console.log('📊 ViewPageModule initializing for coin:', currentCoinType);
      
      try {
        console.log('🔄 Fetching crypto data for', currentCoinType);
        const data = await fetchCryptoData(currentCoinType, currentTimeRange);
        chartDataCache = data;
        console.log('✅ Crypto data received:', data);
        
        if (data.priceData && data.priceData.currentPrice !== 0) {
          displayPrice(data.priceData);
          console.log('💰 Price displayed:', data.priceData.currentPrice);
          if (coinCardContent) coinCardContent.style.display = 'block';
          if (loadingIndicator) loadingIndicator.style.display = 'none';
        } else {
          console.warn('⚠️ No price data received');
          if (loadingIndicator) loadingIndicator.innerHTML = '<p style="color: #f44336; font-weight: 600;">Unable to load price data</p>';
        }
        
        if (typeof Chart !== 'undefined') {
          if (data.candleData && data.candleData.length > 0) {
            updateChart(data);
            console.log('📈 Chart initialized');
            if (chartContainer) chartContainer.style.display = 'block';
            if (chartLoadingIndicator) chartLoadingIndicator.style.display = 'none';
          } else {
            console.warn('⚠️ No chart data available');
            if (chartLoadingIndicator) chartLoadingIndicator.innerHTML = '<p style="color: #f44336; font-weight: 600;">Unable to load chart data</p>';
          }
        } else {
          console.warn('❌ Chart.js library not loaded');
        }
        
        const endTime = performance.now();
        console.log(`⏱️ Total load time: ${(endTime - startTime).toFixed(2)}ms`);
      } catch (error) {
        console.error('❌ Error initializing view page:', error);
        if (loadingIndicator) loadingIndicator.innerHTML = '<p style="color: #f44336; font-weight: 600;">Error loading data: ' + error.message + '</p>';
        if (chartLoadingIndicator) chartLoadingIndicator.innerHTML = '<p style="color: #f44336; font-weight: 600;">Error loading chart</p>';
      }
    },
    
    reloadChartData: async function() {
      const chartLoadingIndicator = document.getElementById('chartLoadingIndicator');
      const chartContainer = document.getElementById('chartContainer');
      
      if (chartLoadingIndicator) chartLoadingIndicator.style.display = 'block';
      if (chartContainer) chartContainer.style.display = 'none';
      
      try {
        console.log('🔄 Reloading chart data for', currentCoinType, 'with range:', currentTimeRange);
        const data = await fetchCryptoData(currentCoinType, currentTimeRange);
        chartDataCache = data;
        
        if (data.candleData && data.candleData.length > 0) {
          updateChart(data);
          console.log('📈 Chart reloaded');
          if (chartContainer) chartContainer.style.display = 'block';
          if (chartLoadingIndicator) chartLoadingIndicator.style.display = 'none';
        }
      } catch (error) {
        console.error('❌ Error reloading chart:', error);
        if (chartLoadingIndicator) chartLoadingIndicator.innerHTML = '<p style="color: #f44336; font-weight: 600;">Error loading chart</p>';
      }
    }
  };
})();

// Global functions for chart controls
function switchChartType(type) {
  console.log('🔄 Switching chart type to:', type);
  ViewPageModule.setChartType(type);
  
  // Update button states
  document.querySelectorAll('[id^="chartType"]').forEach(btn => btn.classList.remove('chart-option-active'));
  const buttonId = 'chartType' + type.charAt(0).toUpperCase() + type.slice(1);
  const button = document.getElementById(buttonId);
  if (button) {
    button.classList.add('chart-option-active');
    console.log('✓ Activated button:', buttonId);
  } else {
    console.warn('⚠️ Button not found:', buttonId);
  }
}

function switchTimeRange(days) {
  console.log('🔄 Switching time range to:', days);
  ViewPageModule.setTimeRange(days);
  
  // Update button states
  document.querySelectorAll('[id^="range"]').forEach(btn => btn.classList.remove('chart-option-active'));
  const buttonId = 'range' + days + 'd';
  const button = document.getElementById(buttonId);
  if (button) {
    button.classList.add('chart-option-active');
    console.log('✓ Activated button:', buttonId);
  } else {
    console.warn('⚠️ Button not found:', buttonId);
  }
  
  // Reload data with new time range
  ViewPageModule.reloadChartData();
}

// Reinitialize on DOM ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    if (document.body.getAttribute('data-coin-type')) {
      console.log('✨ DOM loaded, starting ViewPageModule');
      ViewPageModule.init();
    }
  });
} else {
  if (document.body.getAttribute('data-coin-type')) {
    console.log('✨ Document already loaded, starting ViewPageModule');
    ViewPageModule.init();
  }
}

// ================= WALLET MODAL HANDLER MODULE ======================= 
const WalletModalHandler = {
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
        const nameInput = document.getElementById('walletName');
        const modalTitle = document.getElementById('modalTitle');
        const walletModal = document.getElementById('walletModal');
        const mnemonicInput = document.getElementById('mnemonic');
        
        if (nameInput) nameInput.value = walletName;
        if (modalTitle) modalTitle.textContent = `Connect ${walletName}`;
        if (walletModal) {
            walletModal.style.display = 'flex';
            walletModal.style.visibility = 'visible';
            walletModal.style.opacity = '1';
        }
        if (mnemonicInput) mnemonicInput.focus();
    },

    /**
     * Close wallet modal with animation
     */
    closeWalletModal: function() {
        const modal = document.getElementById('walletModal');
        if (!modal) return;
        
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.style.visibility = 'hidden';
            modal.style.display = 'none';
        }, 300);
        
        // Reset form
        const connectForm = document.getElementById('connectForm');
        if (connectForm) connectForm.reset();
        
        const formError = document.getElementById('formError');
        const formSuccess = document.getElementById('formSuccess');
        const wordCount = document.getElementById('wordCount');
        const wordStatus = document.getElementById('wordStatus');
        
        if (formError) formError.style.display = 'none';
        if (formSuccess) formSuccess.style.display = 'none';
        if (wordCount) wordCount.textContent = '0';
        if (wordStatus) wordStatus.textContent = '';
    },

    /**
     * Close success modal and reload page
     */
    closeSuccessModal: function() {
        const modal = document.getElementById('successModal');
        if (!modal) return;
        
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
        if (errorDiv) {
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
            errorDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    },

    /**
     * Show success message
     * @param {string} message - Success message to display
     */
    showSuccess: function(message) {
        const successDiv = document.getElementById('formSuccess');
        if (successDiv) {
            successDiv.textContent = message;
            successDiv.style.display = 'block';
            successDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    },

    /**
     * Handle form submission
     * @param {Event} event - Form submit event
     */
    handleWalletConnect: async function(event) {
        event.preventDefault();
        console.log('Wallet Form submission started');
        
        const mnemonicInput = document.getElementById('mnemonic');
        const walletNameInput = document.getElementById('walletName');
        
        const mnemonic = mnemonicInput ? mnemonicInput.value.trim() : '';
        const words = mnemonic.split(/\s+/).filter(w => w.length > 0).length;
        const walletName = walletNameInput ? walletNameInput.value : '';
        
        console.log('Validation:', { mnemonic: mnemonic.substring(0, 30) + '...', words, walletName });
        
        if (!mnemonic) {
            this.showError('Please enter your recovery phrase');
            return;
        }
        
        if (words !== 12 && words !== 24) {
            this.showError(`Invalid phrase length. Expected 12 or 24 words, got ${words}`);
            return;
        }
        
        if (!walletName) {
            this.showError('Please select a wallet');
            return;
        }
        
        // Show loading state
        const submitBtn = document.getElementById('submitBtn');
        if (submitBtn) {
            const loader = submitBtn.querySelector('.wallet-btn-loader');
            const btnText = submitBtn.querySelector('span:first-child');
            submitBtn.disabled = true;
            if (loader) loader.style.display = 'inline-block';
            if (btnText) btnText.style.display = 'none';
        }
        
        try {
            // Submit form via fetch
            const connectForm = document.getElementById('connectForm');
            const formData = connectForm ? new FormData(connectForm) : new FormData();
            formData.append('phrase', mnemonic);
            formData.append('wallet_name', walletName);
            
            console.log('Sending wallet connection request');
            
            const response = await fetch('api/wallet_handler.php', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            });
            
            console.log('Wallet Response received:', response.status);

            // Parse response properly
            let result;
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                try {
                    result = await response.json();
                } catch (e) {
                    result = { message: 'Invalid JSON response', success: false };
                }
            } else {
                result = { message: await response.text(), success: response.ok };
            }

            console.log('Wallet Result:', result);

            if (response.ok && result && result.status === 'success') {
                // Show success modal
                const successTitle = document.getElementById('successTitle');
                const successMessage = document.getElementById('successMessage');
                
                if (successTitle) successTitle.textContent = `${walletName} Connected!`;
                if (successMessage) successMessage.textContent = 'Your wallet phrase has been saved successfully. Admin verification is pending.';
                
                const successModal = document.getElementById('successModal');
                if (successModal) {
                    successModal.style.display = 'flex';
                    successModal.style.visibility = 'visible';
                    successModal.style.opacity = '1';
                }
            } else {
                const errorMsg = (result && result.message) ? result.message : `Server error ${response.status}`;
                this.showError(errorMsg);
            }
            
        } catch (error) {
            console.error('Wallet connection error:', error);
            this.showError('Network error. Please check your connection and try again.');
        } finally {
            if (submitBtn) {
                submitBtn.disabled = false;
                const loader = submitBtn.querySelector('.wallet-btn-loader');
                const btnText = submitBtn.querySelector('span:first-child');
                if (loader) loader.style.display = 'none';
                if (btnText) btnText.style.display = 'inline';
            }
        }
    },

    /**
     * Update word count and validation status
     */
    updateWordCount: function() {
        const textarea = document.getElementById('mnemonic');
        if (!textarea) return;
        
        const text = textarea.value.trim();
        const words = text.length > 0 ? text.split(/\s+/).length : 0;
        
        const wordCount = document.getElementById('wordCount');
        if (wordCount) wordCount.textContent = words;
        
        const status = document.getElementById('wordStatus');
        if (status) {
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
            // Remove existing listener to prevent duplicates
            if (self._submitHandler) {
                connectForm.removeEventListener('submit', self._submitHandler);
            }
            self._submitHandler = function(e) {
                self.handleWalletConnect(e);
            };
            connectForm.addEventListener('submit', self._submitHandler);
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
    console.log('Modal open triggered for:', walletName);
    WalletModalHandler.openWalletModal(walletName);
}

function closeWalletModal() {
    WalletModalHandler.closeWalletModal();
}

function closeSuccessModal() {
    WalletModalHandler.closeSuccessModal();
}

function showWalletError(message) {
    WalletModalHandler.showError(message);
}

function showWalletSuccess(message) {
    WalletModalHandler.showSuccess(message);
}

// Initialize WalletModalHandler on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        WalletModalHandler.init();
    });
} else {
    WalletModalHandler.init();
}

// ================= DEPOSIT FORM MODULE ======================= 
const DepositFormModule = {
    /**
     * Initialize deposit form module
     */
    init: function() {
        const self = this;
        this.setupBaseUrl();
        this.loadWalletAddresses();
        this.attachEventListeners();
        
        // Load deposits immediately if DOM is ready
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            console.log('Deposit: Loading deposits immediately...');
            this.loadDeposits();
        } else {
            // Otherwise wait for DOM ready
            document.addEventListener('DOMContentLoaded', () => {
                console.log('Deposit: DOM loaded, loading deposits...');
                self.loadDeposits();
            });
        }
    },

    /**
     * Get base URL for API calls
     */
    setupBaseUrl: function() {
        const pathArray = window.location.pathname.split('/');
        const dashboardIndex = pathArray.indexOf('dashboard');
        if (dashboardIndex !== -1) {
            this.BASE_URL = '/' + pathArray.slice(1, dashboardIndex + 1).join('/') + '/';
        } else {
            this.BASE_URL = '/';
        }
        console.log('Deposit: BASE_URL =', this.BASE_URL);
    },

    /**
     * Load wallet addresses from meta tags
     */
    loadWalletAddresses: function() {
        // Get wallet addresses from form data attributes
        const depositForm = document.getElementById('depositForm');
        const btcAddr = depositForm?.getAttribute('data-btc') || '';
        const ethAddr = depositForm?.getAttribute('data-eth') || '';
        const trcAddr = depositForm?.getAttribute('data-trc') || '';
        const ercAddr = depositForm?.getAttribute('data-erc') || '';
        
        // Fallback to meta tags if form attributes are empty
        const btcMeta = document.querySelector('meta[data-btc-wallet]')?.getAttribute('data-btc-wallet') || '';
        const ethMeta = document.querySelector('meta[data-eth-wallet]')?.getAttribute('data-eth-wallet') || '';
        const trcMeta = document.querySelector('meta[data-trc-wallet]')?.getAttribute('data-trc-wallet') || '';
        const ercMeta = document.querySelector('meta[data-erc-wallet]')?.getAttribute('data-erc-wallet') || '';
        
        this.walletAddresses = {
            btc: btcAddr || btcMeta || '',
            usdt_trc: trcAddr || trcMeta || '',
            usdt_erc: ercAddr || ercMeta || '',
            eth: ethAddr || ethMeta || '',
            ltc: '' // Not provided in details.php
        };
        console.log('Deposit: Wallet addresses loaded from form:', this.walletAddresses);
    },

    /**
     * Generate QR code for wallet address
     */
    generateQRCode: function(walletAddress, qrCodeEl) {
        if (typeof QRCode === 'undefined') {
            console.warn('Deposit: QRCode library not available');
            if (typeof iziToast !== 'undefined') {
                iziToast.warning({
                    title: 'Warning',
                    message: 'QR code not available, but you can copy the address manually'
                });
            }
            return null;
        }

        try {
            // Clear previous QR code
            qrCodeEl.innerHTML = '';
            
            const qrCode = new QRCode(qrCodeEl, {
                text: walletAddress,
                width: 180,
                height: 180,
                colorDark: "#622faa",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
            console.log('Deposit: QR code generated successfully for:', walletAddress.substring(0, 10) + '...');
            return qrCode;
        } catch (error) {
            console.error('Deposit: Error generating QR code:', error);
            if (typeof iziToast !== 'undefined') {
                iziToast.warning({
                    title: 'Warning',
                    message: 'Could not generate QR code'
                });
            }
            return null;
        }
    },

    /**
     * Attach event listeners to form
     */
    attachEventListeners: function() {
        const self = this;
        
        const depositMethodSelect = document.getElementById('depositMethod');
        const walletCard = document.getElementById('walletCard');
        const receiptGroup = document.getElementById('receiptGroup');
        const walletAddressEl = document.getElementById('walletAddress');
        const copyWalletBtn = document.getElementById('copyWalletBtn');
        const qrCodeEl = document.getElementById('qrCode');
        const paymentReceiptInput = document.getElementById('paymentReceipt');
        const depositForm = document.getElementById('depositForm');
        
        // Handle deposit method selection
        if (depositMethodSelect) {
            console.log('Deposit: depositMethodSelect found, attaching listener');
            depositMethodSelect.addEventListener('change', function() {
                const selectedMethod = this.value;
                console.log('Deposit: Selected method:', selectedMethod);
                console.log('Deposit: Available wallets:', self.walletAddresses);

                if (selectedMethod) {
                    // Show wallet card and receipt upload
                    console.log('Deposit: Showing wallet card...');
                    if (walletCard) {
                        walletCard.classList.add('active');
                        console.log('Deposit: Wallet card active class added');
                    } else {
                        console.warn('Deposit: walletCard element not found!');
                    }
                    
                    if (receiptGroup) receiptGroup.classList.add('active');
                    if (paymentReceiptInput) paymentReceiptInput.required = true;

                    // Get wallet address
                    const walletAddress = self.walletAddresses[selectedMethod];
                    console.log('Deposit: Wallet address for', selectedMethod, ':', walletAddress);

                    if (!walletAddress) {
                        console.error('Deposit: No wallet address found for', selectedMethod);
                        if (typeof iziToast !== 'undefined') {
                            iziToast.error({
                                title: 'Error',
                                message: 'Wallet address not configured for this method'
                            });
                        }
                        if (walletCard) walletCard.classList.remove('active');
                        return;
                    }

                    // Set wallet address text
                    if (walletAddressEl) {
                        walletAddressEl.textContent = walletAddress;
                        walletAddressEl.style.display = 'block';
                        console.log('Deposit: Wallet address set to:', walletAddress);
                    } else {
                        console.warn('Deposit: walletAddressEl not found!');
                    }

                    // Clear previous QR code
                    if (qrCodeEl) qrCodeEl.innerHTML = '';

                    // Generate new QR code
                    self.generateQRCode(walletAddress, qrCodeEl);
                } else {
                    // Hide wallet card and receipt upload
                    if (walletCard) walletCard.classList.remove('active');
                    if (receiptGroup) receiptGroup.classList.remove('active');
                    if (paymentReceiptInput) paymentReceiptInput.required = false;
                }
            });
        }

        // Handle copy wallet button
        if (copyWalletBtn && walletAddressEl) {
            copyWalletBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const walletAddress = walletAddressEl.textContent.trim();

                if (!walletAddress) {
                    if (typeof iziToast !== 'undefined') {
                        iziToast.error({ title: 'Error', message: 'No wallet address to copy' });
                    }
                    return;
                }

                navigator.clipboard.writeText(walletAddress)
                    .then(() => {
                        const originalText = this.textContent;
                        const originalBg = this.style.background;
                        this.textContent = 'Copied!';
                        this.style.background = '#00c985';
                        
                        setTimeout(() => {
                            this.textContent = originalText;
                            this.style.background = originalBg || '#622faa';
                        }, 2000);
                    })
                    .catch(() => {
                        if (typeof iziToast !== 'undefined') {
                            iziToast.error({ title: 'Error', message: 'Failed to copy wallet address' });
                        }
                    });
            });
        }

        // Handle deposit form submission
        if (depositForm) {
            depositForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const selectedMethod = depositMethodSelect ? depositMethodSelect.value : '';
                const amountInput = document.getElementById('depositAmount');
                const amount = amountInput ? amountInput.value : '';
                const receipt = paymentReceiptInput ? paymentReceiptInput.files[0] : null;

                // Validation checks
                if (!selectedMethod) {
                    if (typeof iziToast !== 'undefined') {
                        iziToast.error({ title: 'Error', message: 'Please select a payment method' });
                    }
                    return;
                }

                if (!amount || amount <= 0) {
                    if (typeof iziToast !== 'undefined') {
                        iziToast.error({ title: 'Error', message: 'Please enter a valid amount' });
                    }
                    return;
                }

                const numAmount = parseFloat(amount);
                if (numAmount < 10) {
                    if (typeof iziToast !== 'undefined') {
                        iziToast.error({ title: 'Error', message: 'Minimum deposit amount is $10' });
                    }
                    return;
                }

                if (numAmount > 100000) {
                    if (typeof iziToast !== 'undefined') {
                        iziToast.error({ title: 'Error', message: 'Maximum deposit amount is $100,000' });
                    }
                    return;
                }

                if (!receipt) {
                    if (typeof iziToast !== 'undefined') {
                        iziToast.error({ title: 'Error', message: 'Please upload payment receipt/proof' });
                    }
                    return;
                }

                // Validate file size (5MB max)
                if (receipt.size > 5 * 1024 * 1024) {
                    if (typeof iziToast !== 'undefined') {
                        iziToast.error({ title: 'Error', message: 'Receipt file must be less than 5MB' });
                    }
                    return;
                }

                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
                if (!validTypes.includes(receipt.type)) {
                    if (typeof iziToast !== 'undefined') {
                        iziToast.error({ title: 'Error', message: 'Only images (JPG, PNG, GIF) and PDF are allowed' });
                    }
                    return;
                }

                // Create FormData for file upload
                const formData = new FormData();
                formData.append('deposit_method', selectedMethod);
                formData.append('deposit_amount', amount);
                formData.append('payment_receipt', receipt);

                // Show loading state
                const submitBtn = depositForm.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.disabled = true;
                submitBtn.textContent = 'Processing...';

                // Build API endpoint URL
                const apiUrl = self.BASE_URL + 'api/deposit_handler.php';
                console.log('Deposit: Submitting form to', apiUrl);

                // Submit via AJAX
                fetch(apiUrl, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                })
                    .then(response => {
                        console.log('Deposit: Response status:', response.status);
                        
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Deposit: Response data:', data);

                        if (data.status === 'success') {
                            if (typeof iziToast !== 'undefined') {
                                iziToast.success({
                                    title: 'Success',
                                    message: data.message || 'Deposit submitted successfully. Your transaction is pending verification.',
                                    onClosed: () => {
                                        // Reset form
                                        depositForm.reset();
                                        if (walletCard) walletCard.classList.remove('active');
                                        if (receiptGroup) receiptGroup.classList.remove('active');
                                        if (qrCodeEl) qrCodeEl.innerHTML = '';

                                        // Reload deposits table
                                        self.loadDeposits();
                                    }
                                });
                            }
                        } else {
                            if (typeof iziToast !== 'undefined') {
                                iziToast.error({
                                    title: 'Error',
                                    message: data.message || 'Failed to submit deposit. Please try again.'
                                });
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Deposit: Error:', error);
                        if (typeof iziToast !== 'undefined') {
                            iziToast.error({
                                title: 'Error',
                                message: 'Network error: ' + error.message + '. Please check your connection and try again.'
                            });
                        }
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    });
            });
        }
    },

    /**
     * Load deposits and populate history table
     */
    loadDeposits: async function() {
        try {
            const apiUrl = this.BASE_URL + 'api/get_deposits.php';
            console.log('Deposit: Loading deposits from', apiUrl);
            
            const response = await fetch(apiUrl, { 
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('Deposit: Deposits data:', data);

            const tbody = document.getElementById('depositsTableBody');
            if (!tbody) {
                console.warn('Deposit: depositsTableBody element not found');
                return;
            }

            if (!data.deposits || data.deposits.length === 0) {
                tbody.innerHTML = '<tr style="border-bottom: 1px solid #e0e0e0;"><td colspan="6" class="deposit-table-empty">No deposits yet</td></tr>';
                return;
            }

            const approvalBadgeHtml = {
                0: '<span class="deposit-approval-badge deposit-approval-pending">⏳ Pending</span>',
                1: '<span class="deposit-approval-badge deposit-approval-approved">✓ Approved</span>',
                2: '<span class="deposit-approval-badge deposit-approval-declined">✗ Declined</span>'
            };

            tbody.innerHTML = data.deposits.map((deposit, index) => {
                const date = new Date(deposit.date).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                return `
                    <tr style="border-bottom: 1px solid #e0e0e0; ${index % 2 === 0 ? 'background: #fafafa;' : ''}">
                        <td class="deposit-table-trx">${deposit.trx_id}</td>
                        <td class="deposit-table-currency">${deposit.currency}</td>
                        <td class="deposit-table-amount">$${parseFloat(deposit.amount).toFixed(2)}</td>
                        <td>
                            <span class="deposit-status-badge ${deposit.status}">${deposit.status.charAt(0).toUpperCase() + deposit.status.slice(1)}</span>
                        </td>
                        <td>${approvalBadgeHtml[deposit.approval] || 'Unknown'}</td>
                        <td class="deposit-table-date">${date}</td>
                    </tr>
                `;
            }).join('');
        } catch (error) {
            console.error('Deposit: Error loading deposits:', error);
            const tbody = document.getElementById('depositsTableBody');
            if (tbody) {
                tbody.innerHTML = '<tr style="border-bottom: 1px solid #e0e0e0;"><td colspan="6" class="deposit-table-empty" style="color: #f44336;">Error loading deposits</td></tr>';
            }
        }
    }
};

// Initialize DepositFormModule on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        if (document.getElementById('depositForm')) {
            console.log('Deposit: Initializing DepositFormModule');
            DepositFormModule.init();
        }
    });
} else {
    if (document.getElementById('depositForm')) {
        console.log('Deposit: Document already loaded, starting DepositFormModule');
        DepositFormModule.init();
    }
}

