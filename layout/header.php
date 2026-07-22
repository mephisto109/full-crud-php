<?php
include 'config/app.php';

// Menentukan nama halaman yang aktif untuk efek class 'active' di menu
$current_page_rahma = basename($_SERVER['PHP_SELF']);
$barang_pages_rahma = ['index.php', 'tambah-barang.php', 'ubah-barang.php', 'hapus-barang.php'];
$mahasiswa_pages_rahma = ['mahasiswa.php'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title_rahma) ? $title_rahma : 'Dashboard'; ?></title>

    <!-- DataTables -->
    <link rel="stylesheet" href="assets-template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets-template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="assets-template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets-template/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="assets-template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="assets-template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="assets-template/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets-template/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="assets-template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="assets-template/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="assets-template/plugins/summernote/summernote-bs4.min.css">

    <!-- jQuery -->
    <script src="assets-template/plugins/jquery/jquery.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="assets-template/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60"
                width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index.php" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index.php" class="brand-link">
                <img src="assets-template/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">CRUD PHP</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="assets-template/dist/img/user2-160x160.jpg" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <!-- Menampilkan nama akun yang sedang login -->
                        <a href="#" class="d-block"><?= isset($_SESSION['nama']) ? $_SESSION['nama'] : 'User'; ?></a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-header">Daftar Menu</li>

                        <!-- Menu Data Barang (Akses: Level 1 & 2) -->
                        <?php if (isset($_SESSION['level']) && ($_SESSION['level'] == 1 || $_SESSION['level'] == 2)): ?>
                            <li class="nav-item">
                                <a href="index.php"
                                    class="nav-link <?= in_array($current_page_rahma, $barang_pages_rahma) ? 'active' : ''; ?>">
                                    <i class="nav-icon fas fa-box"></i>
                                    <p>Data Barang</p>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- Menu Data Mahasiswa (Akses: Level 1 & 3) -->
                        <?php if (isset($_SESSION['level']) && ($_SESSION['level'] == 1 || $_SESSION['level'] == 3)): ?>
                            <li class="nav-item">
                                <a href="mahasiswa.php"
                                    class="nav-link <?= in_array($current_page_rahma, $mahasiswa_pages_rahma) ? 'active' : ''; ?>">
                                    <i class="nav-icon fas fa-user-graduate"></i>
                                    <p>Data Mahasiswa</p>
                                </a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item">
                            <a href="pegawai.php" class="nav-link ">
                                <i class="nav-icon fas fa-user-cog"></i>
                                <p>Data Pegawai (Realtime)</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="email.php" class="nav-link ">
                                <i class="nav-icon fas fa-user-cog"></i>
                                <p>Kirim Email (PHPmailer)</p>
                            </a>
                        </li>

                        <!-- Menu Data Akun / Modal -->
                        <li class="nav-item">
                            <a href="crud-modal.php"
                                class="nav-link <?= $current_page_rahma == 'crud-modal.php' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-user-cog"></i>
                                <p>Data Akun</p>
                            </a>
                        </li>

                        <!-- Menu Logout -->
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link" onclick="return confirm('Yakin ingin keluar?')">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>