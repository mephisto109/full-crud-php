<?php
session_start();

// Membatasi halaman sebelum login
if (!isset($_SESSION['login'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            document.location.href = 'login.php';
        </script>";
    exit;
}

// Membatasi halaman berdasarkan user login
if ($_SESSION['level'] != 1 && $_SESSION['level'] != 2) {
    echo "<script>
            alert('Anda tidak memiliki akses ke halaman ini!');
            document.location.href = 'crud-modal.php';
        </script>";
    exit;
}

$title_rahma = "Data Barang";

// Include header cukup SEKALI di sini, setelah semua validasi lolos
include 'layout/header.php';

$data_barang_rahma = select("SELECT * FROM barang ORDER BY id_barang DESC");
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">DataTable dengan Fitur Lengkap</h3>
                                    <a href="tambah-barang.php" class="btn btn-primary btn-sm float-right"><i class="fas fa-plus-circle"></i> Tambah Data</a>
                                </div>
                                <div class="card-body">
                                    <!-- ID tabel disesuaikan ke 'table' agar JavaScript DataTables di footer.php berjalan sempurna -->
                                    <table id="table" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Jumlah</th>
                                                <th scope="col">Harga</th>
                                                <th scope="col">Barcode</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no_rahma = 1;
                                            foreach ($data_barang_rahma as $barang_rahma) {
                                                ?>
                                                <tr>
                                                    <th scope="row"><?= $no_rahma++; ?></th>
                                                    <td><?= $barang_rahma['nama']; ?></td>
                                                    <td><?= $barang_rahma['jumlah']; ?></td>
                                                    <td>Rp. <?= number_format($barang_rahma['harga'], 0, ',', '.'); ?></td>
                                                    <td class="text-center">
                                                        <img alt="barcode"
                                                            src="barcode.php?codetype=code128&size=15&text=<?= $barang_rahma['barcode']; ?>&print=true" />
                                                    </td>
                                                    <td><?= date('d/m/y | H:i:s', strtotime($barang_rahma['tanggal'])); ?></td>
                                                    <td>
                                                        <a href="ubah-barang.php?id_barang=<?= $barang_rahma['id_barang']; ?>"
                                                            class="btn btn-success">Edit</a>
                                                        <a href="hapus-barang.php?id_barang=<?= $barang_rahma['id_barang']; ?>"
                                                            class="btn btn-danger"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                                    </td>
                                                </tr>
                                                <?php
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
</div>
<!-- /.content-wrapper -->

<?php include 'layout/footer.php' ?>
