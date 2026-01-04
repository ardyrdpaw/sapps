<?php
// layout_header.php: Header and sidebar for Support Apps BKPSDM
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}
// determine current script for active menu
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Apps BKPSDM</title>
    <link rel="icon" href="/favicon.ico">
    <link rel="icon" href="assets/images/logo.png" type="image/png">
    <link rel="shortcut icon" href="assets/images/logo.png" type="image/png">
    <link rel="apple-touch-icon" href="assets/images/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/custom.js"></script>
</head>
<body>
<header class="topbar bg-white shadow-sm py-2">
  <div class="container-fluid d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-3">
      <button class="btn btn-sm btn-light d-md-none" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">☰</button>
      <button id="sidebarCollapseBtn" class="btn btn-sm btn-light d-none d-md-inline" title="Toggle sidebar" aria-pressed="false">≡</button>
      <div class="brand d-flex align-items-center gap-2">
        <img src="assets/images/logo.png" alt="logo" style="height:34px; width:auto;">
        <strong class="brand-label">Support Apps BKPSDM</strong>
      </div>
    </div>
    <div class="topbar-actions d-flex align-items-center gap-2">
      <button class="btn btn-sm btn-light" title="Toggle theme">☾</button>
      <button class="btn btn-sm btn-light" title="Search">🔍</button>
      <div class="dropdown">
        <a class="btn btn-sm btn-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Super Admin</a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </div>
</header>
<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-2 col-lg-2 d-md-block bg-dark sidebar collapse">
      <div class="sidebar-inner p-3 text-white">
        <div class="mb-4">
          <h5 class="m-0">Main Menu</h5>
        </div>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link text-white <?php echo $current_page === 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php"><i class="bi bi-house"></i> <span class="menu-label ms-1">Home</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white <?php echo $current_page === 'cat.php' ? 'active' : '' ?>" href="cat.php"><i class="bi bi-list-check"></i> <span class="menu-label ms-1">CAT</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white <?php echo $current_page === 'signage.php' ? 'active' : '' ?>" href="signage.php"><i class="bi bi-display"></i> <span class="menu-label ms-1">Signage</span></a>
          </li>
          <?php if ($_SESSION['role'] === 'admin'): ?>
          <li class="nav-item">
            <a class="nav-link text-white <?php echo $current_page === 'user.php' ? 'active' : '' ?>" href="user.php"><i class="bi bi-people"></i> <span class="menu-label ms-1">Users</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white <?php echo $current_page === 'user_access.php' ? 'active' : '' ?> ms-3" href="user_access.php"><i class="bi bi-shield-lock"></i> <span class="menu-label ms-1">Akses</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white <?php echo $current_page === 'menus.php' ? 'active' : '' ?> ms-3" href="menus.php"><i class="bi bi-list"></i> <span class="menu-label ms-1">Manage Menus</span></a>
          </li>
          <?php endif; ?>
          <li class="nav-item mt-3">
            <a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-right"></i> <span class="menu-label ms-1">Logout</span></a>
          </li>
        </ul>
      </div>
    </nav>
    <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
