<?php
session_start();
// membatasi halaman sebelum login
if (!isset($_SESSION['login'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            document.location.href = 'login.php';
        </script>";
    exit;    
}

// membatasi halaman berdasarkan user login
if ($_SESSION['level'] != 1 && $_SESSION['level'] != 2) {
    echo "<script>
            alert('Anda tidak memiliki akses ke halaman ini!');
            document.location.href = 'crud-modal.php';
        </script>";
    exit;
}

$title = "Data Barang";

include 'layout/header.php';

$data_barang = select("SELECT * FROM barang ORDER BY id_barang DESC");
?>

<div class="container mt-5">
    <h1>Data Barang</h1>
    <hr>
    <a href="tambah-barang.php" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Tambah Barang</a>
    <table class="table table-bordered table-striped" id="table">
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
            $no = 1;
            foreach ($data_barang as $barang) {
            ?>
            <tr>
                <th scope="row"><?= $no++; ?></th>
                <td><?= $barang['nama']; ?></td>
                <td><?= $barang['jumlah']; ?></td>
                <td>Rp. <?= number_format($barang['harga'], 0, ',', '.'); ?></td>
                <td class="text-center">
                    <img alt="barcode" src="barcode.php?codetype=code128&size=15&text=<?= $barang['barcode']; ?>&print=true" />
                </td>
                <td><?= date('d/m/y | H:i:s', strtotime($barang['tanggal'])); ?></td>
                <td>
                    <a href="ubah-barang.php?id_barang=<?= $barang['id_barang']; ?>" class="btn btn-success">Edit</a>
                    <a href="hapus-barang.php?id_barang=<?= $barang['id_barang']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php
            } ?>
        </tbody>
    </table>
</div>

<?php include 'layout/footer.php' ?>