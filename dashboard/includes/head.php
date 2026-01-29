<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php
  // Include security & authentication
  include 'security.php';

  // Include details first to get FAV variable
  include '../details.php';
  ?>
  <link rel="shortcut icon" href="../uploads/<?= FAV ?>" type="image/x-icon">
  <link rel="apple-touch-icon" sizes="48x48" href="../uploads/<?= FAV ?>"/>
  <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Dashboard'; ?></title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <!-- Toast Notifications (inline CSS, no external CDN) -->
  <style>
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
    }
    .toast-message {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        animation: slideIn 0.3s ease;
        min-width: 300px;
    }
    .toast-message.success {
        border-left: 4px solid #4caf50;
        background: #f1f8f6;
        color: #2e7d32;
    }
    .toast-message.error {
        border-left: 4px solid #f44336;
        background: #fdeaea;
        color: #c62828;
    }
    .toast-message.info {
        border-left: 4px solid #2196f3;
        background: #e3f2fd;
        color: #1565c0;
    }
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
  </style>
  <!-- Merged Dashboard Styles -->
  <link rel="stylesheet" href="css/style.css">
  <!-- Additional Page-Specific Styles -->
  <?php if (isset($additionalCSS) && is_array($additionalCSS)): ?>
    <?php foreach ($additionalCSS as $css): ?>
      <link rel="stylesheet" href="<?= htmlspecialchars($css); ?>">
    <?php endforeach; ?>
  <?php endif; ?>
</head>

