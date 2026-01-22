<?php $pageTitle = 'Account Blocked'; include 'includes/head.php'; ?>
<body class="light-mode" style="background: #f5f5f5;">

  <!-- Main Content -->
  <main style="padding-bottom: 6rem; min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <section style="width: 100%; max-width: 800px; padding: 0 20px;">
      <div class="card" style="padding: 60px 40px; border-radius: 16px; background: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); text-align: center;">
        
        <!-- Icon Section -->
        <div style="margin-bottom: 2rem;">
          <div style="width: 100px; height: 100px; margin: 0 auto 20px; background: linear-gradient(135deg, rgba(255, 59, 59, 0.2) 0%, rgba(255, 107, 107, 0.1) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-lock" style="font-size: 48px; color: #ff3b3b;"></i>
          </div>
        </div>

        <!-- Header -->
        <h1 style="font-size: 36px; font-weight: 700; margin: 0 0 10px 0; color: #333;">Account Blocked</h1>
        <p style="color: #888; font-size: 16px; margin: 0 0 2rem 0; line-height: 1.6;">Your account has been temporarily blocked due to security reasons.</p>

        <!-- Details Section -->
        <div style="background: linear-gradient(135deg, rgba(255, 59, 59, 0.1) 0%, rgba(255, 107, 107, 0.05) 100%); padding: 25px; border-radius: 12px; border-left: 3px solid #ff3b3b; margin-bottom: 2rem; text-align: left;">
          <h3 style="color: #333; font-size: 16px; margin: 0 0 15px 0; font-weight: 600;">Why is my account blocked?</h3>
          <ul style="margin: 0; padding-left: 20px; color: #666; line-height: 1.8;">
            <li>Suspicious login attempts</li>
            <li>Unusual account activity detected</li>
            <li>Security policy violation</li>
            <li>Administrator action</li>
            <li>Account verification pending</li>
          </ul>
        </div>

        <!-- Action Buttons -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 2rem;">
          <!-- Contact Support Button -->
          <a href="mailto:support@example.com?subject=Account%20Blocked%20Appeal" style="text-decoration: none;">
            <button style="width: 100%; padding: 14px 20px; background: linear-gradient(135deg, #622faa 0%, #ff6b6b 100%); color: #fff; border: none; border-radius: 10px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 16px rgba(98, 47, 170, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
              <i class="fas fa-envelope" style="margin-right: 8px;"></i>Contact Support
            </button>
          </a>
          
          <!-- Logout Button -->
          <form method="POST" action="logout.php" style="width: 100%;">
            <button type="submit" style="width: 100%; padding: 14px 20px; background: transparent; color: #622faa; border: 2px solid #622faa; border-radius: 10px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='rgba(98, 47, 170, 0.05)'" onmouseout="this.style.background='transparent'">
              <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i>Logout
            </button>
          </form>
        </div>

        <!-- Info Box -->
        <div style="background: #f9f9f9; padding: 20px; border-radius: 12px; border-left: 3px solid #622faa; margin-bottom: 1rem;">
          <p style="color: #666; font-size: 13px; margin: 0; line-height: 1.6;">
            <strong>What to do next:</strong> Please reach out to our support team with details about your account. We'll review your case and help restore access as quickly as possible. Your account security is our top priority.
          </p>
        </div>

        <!-- Support Info -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-top: 2rem;">
          <div style="padding: 15px; background: #f9f9f9; border-radius: 10px; border-left: 3px solid #00c985;">
            <p style="margin: 0 0 8px 0; font-weight: 600; color: #333; font-size: 13px;">📧 Email Support</p>
            <p style="margin: 0; color: #888; font-size: 12px;">support@example.com</p>
          </div>
          <div style="padding: 15px; background: #f9f9f9; border-radius: 10px; border-left: 3px solid #ff6b6b;">
            <p style="margin: 0 0 8px 0; font-weight: 600; color: #333; font-size: 13px;">💬 Live Chat</p>
            <p style="margin: 0; color: #888; font-size: 12px;">Available 24/7</p>
          </div>
          <div style="padding: 15px; background: #f9f9f9; border-radius: 10px; border-left: 3px solid #622faa;">
            <p style="margin: 0 0 8px 0; font-weight: 600; color: #333; font-size: 13px;">📱 Phone</p>
            <p style="margin: 0; color: #888; font-size: 12px;">+1 (555) 123-4567</p>
          </div>
        </div>

        <!-- Footer Note -->
        <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #e0e0e0;">
          <p style="color: #888; font-size: 12px; margin: 0;">
            If you believe this is a mistake, please contact our support team immediately. We're here to help!
          </p>
        </div>
      </div>
    </section>
  </main>

  <!-- External Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
