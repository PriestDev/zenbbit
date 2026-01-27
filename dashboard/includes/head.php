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
  <!-- iziToast (optional) -->
  <?php if (isset($includeIziToast) && $includeIziToast): ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
  <?php endif; ?>
  <!-- Merged Dashboard Styles -->
  <link rel="stylesheet" href="css/style.css">
</head>

