<?php 
include 'includes/dashboard_init.php';
$pageTitle = 'Cryptocurrency Guide';
$includeIziToast = true;
include 'includes/head.php';
?>

<body class="light-mode dashboard-body">

  <!-- Sidebar Component -->
  <?php include 'includes/sidebar.php'; ?>

  <!-- Top Navbar Component -->
  <?php include 'includes/header.php'; ?>

  <!-- Main Content -->
  <main style="padding-bottom: 6rem; margin-top: 6rem;">
    <section class="hom mb-5" style="max-width: 900px; margin-left: auto; margin-right: auto; padding: 0 20px;">
      
      <!-- Back Button -->
      <div style="margin-bottom: 20px;">
        <a href="index.php" style="display: inline-flex; align-items: center; gap: 8px; color: #622faa; text-decoration: none; font-weight: 600;">
          <i class="fas fa-chevron-left"></i> Back to Dashboard
        </a>
      </div>

      <!-- Video Card -->
      <div class="card" style="padding: 30px; border-radius: 16px; background: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); margin-bottom: 2rem;">
        <h2 style="color: #333; margin: 0 0 10px 0; font-size: 28px; font-weight: 700;">
          <i class="fas fa-play-circle" style="color: #622faa; margin-right: 10px;"></i>
          Cryptocurrency Guide
        </h2>
        <p style="color: #888; margin: 0 0 20px 0; font-size: 14px;">
          Learn everything you need to know about buying and managing cryptocurrency
        </p>

        <!-- YouTube Video -->
        <div style="position: relative; width: 100%; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 12px;">
          <iframe 
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none; border-radius: 12px;"
            width="560" 
            height="315" 
            src="https://www.youtube.com/embed/Gxz0k1iybXc?si=ft7QAnoeVdbmMUGL" 
            title="YouTube video player" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
            referrerpolicy="strict-origin-when-cross-origin" 
            allowfullscreen>
          </iframe>
        </div>
      </div>

      <!-- Information Card -->
      <div class="card" style="padding: 30px; border-radius: 16px; background: linear-gradient(135deg, rgba(98, 47, 170, 0.05) 0%, rgba(255, 107, 107, 0.05) 100%); border: 2px solid #e0e0e0;">
        <h3 style="color: #333; margin: 0 0 15px 0; font-size: 18px; font-weight: 600;">
          <i class="fas fa-lightbulb" style="color: #622faa; margin-right: 8px;"></i>
          Tips
        </h3>
        <ul style="color: #555; margin: 0; padding-left: 20px; line-height: 1.8;">
          <li>Always use secure and verified platforms</li>
          <li>Enable two-factor authentication (2FA) for security</li>
          <li>Start with small amounts to test the process</li>
          <li>Keep your private keys safe and secure</li>
          <li>Never share your recovery phrases or passwords</li>
        </ul>
      </div>

    </section>
  </main>

  <!-- Footer Component -->
  <?php include 'includes/footer.php'; ?>

</body>
</html>
