<?php include 'includes/dashboard_init.php'; $pageTitle = 'Deposit'; $includeIziToast = true; include 'includes/head.php'; ?>
<body class="light-mode dashboard-body">
  <!-- Sidebar Component -->
  <?php include 'includes/sidebar.php'; ?>

  <!-- Top Navbar Component -->
  <?php include 'includes/header.php'; ?>
  <!-- Main Deposit Content -->
  <main style="padding-bottom: 6rem;">
    <section class="hom mb-5" style="margin-top: 6rem; margin-bottom: 8rem; width: 100%; max-width: 900px; margin-left: auto; margin-right: auto; padding: 0 20px;">
      <div class="card" style="padding: 40px 30px; border-radius: 16px; background: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
        <!-- Header Section with Gradient -->
        <div class="wallet-inf" style="margin-bottom: 3rem;">
          <div>
            <h2 style="font-size: 32px; font-weight: 700; margin: 0; background: linear-gradient(135deg, #622faa 0%, #ff6b6b 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Deposit Funds</h2>
            <p style="color: #888; margin-top: 8px; font-size: 14px;">Add funds to your account securely</p>
          </div>
        </div>

        <!-- Info Box Section -->
        <div style="background: linear-gradient(135deg, rgba(98, 47, 170, 0.1) 0%, rgba(255, 107, 107, 0.1) 100%); padding: 20px; border-radius: 12px; border-left: 3px solid #622faa; margin-bottom: 3rem;">
          <p style="color: #888; margin: 0 0 8px 0; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Quick Info</p>
          <p style="color: #333; margin: 0; font-size: 14px;">Choose your preferred deposit method and enter the amount to proceed with your deposit.</p>
        </div>

        <form id="depositForm">
          <!-- Deposit Method Group -->
          <div class="form-group" style="margin-bottom: 2rem;">
            <label for="depositMethod" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 14px;">Select Payment Method</label>
            <select id="depositMethod" required style="width: 100%; padding: 12px 16px; border: 2px solid #e0e0e0; border-radius: 10px; background: #fff; color: #333; font-size: 14px; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.borderColor='#622faa'" onmouseout="this.style.borderColor='#e0e0e0'" onfocus="this.style.borderColor='#622faa'" onblur="this.style.borderColor='#e0e0e0'">
              <option value="">-- Select Payment Method --</option>
              <option value="btc">Bitcoin (BTC)</option>
              <option value="usdt_trc">USDT - TRC20</option>
              <option value="usdt_erc">USDT - ERC20</option>
              <option value="eth">Ethereum (ETH)</option>
            </select>
          </div>

          <!-- Amount Group -->
          <div class="form-group" style="margin-bottom: 2rem;">
            <label for="depositAmount" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 14px;">Amount (USD)</label>
            <input type="number" id="depositAmount" placeholder="Enter amount" step="0.01" min="0" required style="width: 100%; padding: 12px 16px; border: 2px solid #e0e0e0; border-radius: 10px; background: #fff; color: #333; font-size: 14px; transition: all 0.3s; box-sizing: border-box;" onfocus="this.style.borderColor='#622faa'" onblur="this.style.borderColor='#e0e0e0'">
          </div>

          <!-- Wallet Info Card (Hidden by default) -->
          <div id="walletCard" style="display: none; margin-bottom: 2rem; padding: 20px; background: linear-gradient(135deg, rgba(98, 47, 170, 0.05) 0%, rgba(255, 107, 107, 0.05) 100%); border: 2px solid #e0e0e0; border-radius: 12px;">
            <h3 style="color: #333; margin: 0 0 15px 0; font-size: 16px; font-weight: 600;">Wallet Address</h3>
            
            <!-- QR Code -->
            <div style="display: flex; justify-content: center; margin-bottom: 15px;">
              <div id="qrCode" style="padding: 10px; background: #fff; border-radius: 8px;"></div>
            </div>

            <!-- Wallet Address Display -->
            <div style="background: #fff; padding: 12px; border-radius: 8px; margin-bottom: 12px; border: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center;">
              <code id="walletAddress" style="color: #622faa; font-size: 12px; word-break: break-all; flex: 1;"></code>
              <button type="button" id="copyWalletBtn" style="background: #622faa; color: #fff; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; margin-left: 10px; white-space: nowrap; font-size: 12px; font-weight: 600;">Copy</button>
            </div>

            <p style="color: #888; font-size: 12px; margin: 0;">Send the specified amount to the wallet address above. Your deposit will be processed after payment verification.</p>
          </div>

          <!-- Payment Receipt Upload -->
          <div id="receiptGroup" style="display: none; margin-bottom: 2rem;">
            <label for="paymentReceipt" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 14px;">Upload Payment Receipt/Proof</label>
            <input type="file" id="paymentReceipt" name="paymentReceipt" accept="image/*,.pdf" required style="width: 100%; padding: 12px 16px; border: 2px solid #e0e0e0; border-radius: 10px; background: #fff; color: #333; font-size: 14px; transition: all 0.3s; box-sizing: border-box; cursor: pointer;" onfocus="this.style.borderColor='#622faa'" onblur="this.style.borderColor='#e0e0e0'">
            <small style="color: #888; margin-top: 5px; display: block;">Accepted: Images (JPG, PNG, GIF) or PDF. Max 5MB</small>
          </div>

          <!-- Submit Button with Hover Effect -->
          <button type="submit" style="width: 100%; padding: 14px 20px; background: linear-gradient(135deg, #622faa 0%, #ff6b6b 100%); color: #fff; border: none; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s; margin-top: 1rem;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 16px rgba(98, 47, 170, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">Proceed with Deposit</button>
        </form>

        <!-- Additional Info Section -->
        <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #e0e0e0;">
          <p style="color: #888; font-size: 12px; text-transform: uppercase; letter-spacing: 0.8px; margin: 0 0 1rem 0; font-weight: 600;">Why Choose Our Deposit Methods?</p>
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px;">
            <div style="padding: 15px; background: #f9f9f9; border-radius: 10px; border-left: 3px solid #00c985;">
              <p style="margin: 0 0 8px 0; font-weight: 600; color: #333; font-size: 13px;">🔒 Secure</p>
              <p style="margin: 0; color: #888; font-size: 12px;">Encrypted and safe transactions</p>
            </div>
            <div style="padding: 15px; background: #f9f9f9; border-radius: 10px; border-left: 3px solid #ff6b6b;">
              <p style="margin: 0 0 8px 0; font-weight: 600; color: #333; font-size: 13px;">⚡ Fast</p>
              <p style="margin: 0; color: #888; font-size: 12px;">Instant deposit processing</p>
            </div>
            <div style="padding: 15px; background: #f9f9f9; border-radius: 10px; border-left: 3px solid #622faa;">
              <p style="margin: 0 0 8px 0; font-weight: 600; color: #333; font-size: 13px;">💰 Low Fees</p>
              <p style="margin: 0; color: #888; font-size: 12px;">Competitive deposit fees</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- Footer Component -->
  <?php include 'includes/footer.php'; ?>

  <!-- Jivo Live Chat - Disabled due to tracking prevention issues -->
  <!-- <script src="//code.jivosite.com/widget/Tyy2Bc4Zz5" async></script> -->

  <!-- QR Code Library -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

  <!-- External Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Dashboard Scripts -->
  <script src="js/script.js"></script>

  <!-- Deposit Page JavaScript -->
  <script>
    // Wallet addresses configuration
    const walletAddresses = {
      btc: '<?php echo (defined("BTC") && !empty(BTC)) ? BTC : "NOT_CONFIGURED"; ?>',
      usdt_trc: '<?php echo (defined("TRC") && !empty(TRC)) ? TRC : "NOT_CONFIGURED"; ?>',
      usdt_erc: '<?php echo (defined("ERC") && !empty(ERC)) ? ERC : "NOT_CONFIGURED"; ?>',
      eth: '<?php echo (defined("ETH") && !empty(ETH)) ? ETH : "NOT_CONFIGURED"; ?>'
    };

    const walletLabels = {
      btc: 'Bitcoin (BTC)',
      usdt_trc: 'USDT - TRC20',
      usdt_erc: 'USDT - ERC20',
      eth: 'Ethereum (ETH)'
    };

    // DOM Elements
    const depositMethodSelect = document.getElementById('depositMethod');
    const walletCard = document.getElementById('walletCard');
    const receiptGroup = document.getElementById('receiptGroup');
    const walletAddressEl = document.getElementById('walletAddress');
    const copyWalletBtn = document.getElementById('copyWalletBtn');
    const qrCodeEl = document.getElementById('qrCode');
    const paymentReceiptInput = document.getElementById('paymentReceipt');
    const depositForm = document.getElementById('depositForm');

    let currentQR = null;
    let currentMethod = null;
    let qrGenerationInProgress = false;

    /**
     * Generate QR code for wallet address - absolutely no duplicates
     */
    function generateQRCode(address) {
      // Get current QR element
      let qrElement = document.getElementById('qrCode');
      
      // Check if we already have a valid QR code for this exact address
      if (qrElement && qrElement.dataset.qrAddress === address) {
        console.warn('⚠️ QR code already exists for this address, skipping');
        return;
      }
      
      // Prevent any concurrent generation
      if (qrGenerationInProgress) {
        console.warn('⚠️ QR generation already in progress, skipping duplicate');
        return;
      }
      
      // Set flag IMMEDIATELY
      qrGenerationInProgress = true;
      
      try {
        // Create completely fresh QR element
        const newQrEl = document.createElement('div');
        newQrEl.id = 'qrCode';
        newQrEl.style.padding = '10px';
        newQrEl.style.background = '#fff';
        newQrEl.style.borderRadius = '8px';
        newQrEl.dataset.qrAddress = address; // Track what address this QR is for
        
        // Replace old element with new blank one
        if (qrElement && qrElement.parentNode) {
          qrElement.parentNode.replaceChild(newQrEl, qrElement);
        }
        
        // Generate QR ONCE on the fresh element
        new QRCode(newQrEl, {
          text: address,
          width: 150,
          height: 150,
          colorDark: "#622faa",
          colorLight: "#ffffff",
          correctLevel: QRCode.CorrectLevel.H
        });
        
        console.log('✓ Single QR Code generated for:', address.substring(0, 10) + '...');
      } catch (error) {
        console.error('❌ Error generating QR code:', error);
        iziToast.error({ title: 'Error', message: 'Failed to generate QR code' });
      } finally {
        // Reset flag after generation complete
        setTimeout(() => {
          qrGenerationInProgress = false;
        }, 200);
      }
    }

    /**
     * Handle deposit method selection
     */
    depositMethodSelect.addEventListener('change', function() {
      const selectedMethod = this.value;
      
      // Ignore if already generating or same method selected
      if (!selectedMethod || selectedMethod === currentMethod) {
        if (!selectedMethod) {
          walletCard.style.display = 'none';
          receiptGroup.style.display = 'none';
          paymentReceiptInput.required = false;
          currentMethod = null;
        }
        return;
      }

      // Check if method is valid
      if (!walletAddresses[selectedMethod]) {
        iziToast.error({ 
          title: 'Error', 
          message: 'Invalid payment method selected'
        });
        return;
      }

      const walletAddress = walletAddresses[selectedMethod];

      // Validate wallet address is configured
      if (!walletAddress || walletAddress === 'NOT_CONFIGURED' || walletAddress.trim() === '') {
        iziToast.error({ 
          title: 'Configuration Error', 
          message: 'Wallet address for ' + walletLabels[selectedMethod] + ' is not configured. Please contact support.'
        });
        walletCard.style.display = 'none';
        receiptGroup.style.display = 'none';
        currentMethod = null;
        return;
      }

      // Update state FIRST
      currentMethod = selectedMethod;
      
      // Show wallet card and receipt upload
      walletCard.style.display = 'block';
      receiptGroup.style.display = 'block';
      paymentReceiptInput.required = true;
      
      // Update wallet address display
      walletAddressEl.textContent = walletAddress;
      
      // Generate QR code ONLY once per address (with tracking)
      generateQRCode(walletAddress);
    });

    /**
     * Copy wallet address to clipboard
     */
    copyWalletBtn.addEventListener('click', function(e) {
      e.preventDefault();
      const walletAddress = walletAddressEl.textContent;
      
      if (!walletAddress) {
        iziToast.warning({ title: 'Warning', message: 'No wallet address to copy' });
        return;
      }
      
      // Use StorageUtil wrapper to avoid tracking prevention warnings
      if (typeof StorageUtil !== 'undefined' && StorageUtil.safeCopy) {
        StorageUtil.safeCopy(walletAddress);
        const originalText = this.textContent;
        this.textContent = 'Copied!';
        setTimeout(() => {
          this.textContent = originalText;
        }, 2000);
      } else {
        // Fallback to native clipboard API
        navigator.clipboard.writeText(walletAddress).then(() => {
          const originalText = this.textContent;
          this.textContent = 'Copied!';
          setTimeout(() => {
            this.textContent = originalText;
          }, 2000);
        }).catch(() => {
          iziToast.error({ title: 'Error', message: 'Failed to copy wallet address' });
        });
      }
    });

    /**
     * Handle form submission
     */
    depositForm.addEventListener('submit', function(e) {
      e.preventDefault();

      const selectedMethod = depositMethodSelect.value;
      const amount = document.getElementById('depositAmount').value;
      const receipt = paymentReceiptInput.files[0];
      const walletAddress = walletAddressEl.textContent;

      // Validation
      if (!selectedMethod) {
        iziToast.error({ title: 'Error', message: 'Please select a payment method' });
        return;
      }

      if (!amount || parseFloat(amount) <= 0) {
        iziToast.error({ title: 'Error', message: 'Please enter a valid amount' });
        return;
      }

      if (!receipt) {
        iziToast.error({ title: 'Error', message: 'Please upload payment receipt' });
        return;
      }

      if (!walletAddress || walletAddress === 'NOT_CONFIGURED') {
        iziToast.error({ title: 'Error', message: 'Wallet address is not configured' });
        return;
      }

      // Validate file size (max 5MB)
      if (receipt.size > 5 * 1024 * 1024) {
        iziToast.error({ title: 'Error', message: 'Receipt file must be less than 5MB' });
        return;
      }

      // Create FormData for file upload
      const formData = new FormData();
      formData.append('action', 'deposit');
      formData.append('deposit_method', selectedMethod);
      formData.append('deposit_amount', amount);
      formData.append('wallet_address', walletAddress);
      formData.append('payment_receipt', receipt);

      // Submit via AJAX
      fetch('code.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          iziToast.success({ 
            title: 'Success', 
            message: 'Deposit submitted successfully. Your transaction is pending verification.',
            onClosed: () => {
              // Reset form
              depositForm.reset();
              walletCard.style.display = 'none';
              receiptGroup.style.display = 'none';
              clearQRCode();
              currentMethod = null;
            }
          });
        } else {
          iziToast.error({ title: 'Error', message: data.message || 'Failed to submit deposit' });
        }
      })
      .catch(error => {
        console.error('Deposit Error:', error);
        iziToast.error({ title: 'Error', message: 'An error occurred. Please try again.' });
      });
    });

    // Initialize
    console.log('Deposit: Page initialized with wallet addresses:', walletAddresses);
  </script>

</body>
</html>
