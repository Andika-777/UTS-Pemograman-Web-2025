<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$current = basename($_SERVER['PHP_SELF']);
?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-cogs"></i>
    </div>
    <div class="sidebar-brand-text mx-3">My Style Admin</div>
  </a>
  <hr class="sidebar-divider my-0">

  <li class="nav-item <?= $current === 'index.php' ? 'active' : '' ?>">
    <a class="nav-link" href="index.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>
  <hr class="sidebar-divider">
  <div class="sidebar-heading">Data Master</div>
  <li class="nav-item <?= in_array($current, ['produk_data.php','produk_tambah.php','produk_ubah.php']) ? 'active' : '' ?>">
    <a class="nav-link" href="produk_data.php">
      <i class="fas fa-fw fa-box"></i>
      <span>Produk</span>
    </a>
  </li>
  <li class="nav-item <?= in_array($current, ['kategori_data.php','kategori_tambah.php','kategori_ubah.php']) ? 'active' : '' ?>">
    <a class="nav-link" href="kategori_data.php">
      <i class="fas fa-fw fa-tags"></i>
      <span>Kategori</span>
    </a>
  </li>
  <li class="nav-item <?= in_array($current, ['pembeli_data.php','pembeli_tambah.php','pembeli_ubah.php']) ? 'active' : '' ?>">
    <a class="nav-link" href="pembeli_data.php">
      <i class="fas fa-fw fa-users"></i>
      <span>Pembeli</span>
    </a>
  </li>
  <li class="nav-item <?= in_array($current, ['penjualan_data.php','penjualan_tambah.php','penjualan_ubah.php']) ? 'active' : '' ?>">
    <a class="nav-link" href="penjualan_data.php">
      <i class="fas fa-fw fa-receipt"></i>
      <span>Penjualan</span>
    </a>
  </li>
  <hr class="sidebar-divider d-none d-md-block">
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
</ul>
<div id="content-wrapper" class="d-flex flex-column">
  <div id="content">
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
             aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
              <?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '' ?>
            </span>
            <img class="img-profile rounded-circle" src="img/undraw_profile.svg" alt="profile">
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Logout
            </a>
          </div>
        </li>
      </ul>
    </nav>
