<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../image/fav.png" type="image/x-icon">
  <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Dashboard'; ?></title>
  
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <!-- iziToast (optional) -->
  <?php if (isset($includeIziToast) && $includeIziToast): ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
  <?php endif; ?>
  <!-- Merged Dashboard Styles -->
  <link rel="stylesheet" href="css/style.css">
</head>

<?php
// Security already handled by dashboard_init.php (called before head.php)
// This prevents duplicate includes
?>
