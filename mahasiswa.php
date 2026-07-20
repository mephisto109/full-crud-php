<?php
session_start();
// membatasi halaman sebelum login
if (!isset($_SESSION['login'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            document.location.href = 'login.php';
        </script>";
}

// membatasi halaman berdasarkan user login
if ($_SESSION['level'] != 1 && $_SESSION['level'] != 3) {
    echo "<script>
            alert('Anda tidak memiliki akses ke halaman ini!');
            document.location.href = 'crud-modal.php';
        </script>";
    exit;
}

$title = "Daftar Mahasiswa";
include 'layout/header.php';



$data_mahasiswa = select("SELECT * FROM mahasiswa ORDER BY id_mahasiswa DESC");
?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar Mahasiswa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="mahasiswa.php">Home</a></li>
                        <li class="breadcrumb-item active">Mahasiswa</li>
                    </ol>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data mahasiswa</h3>
                                </div>
                                <div class="card-body">
                                    <a href="tambah-mahasiswa.php" class="btn btn-primary mb-3"><i class="fas fa-plus-circle"></i> Tambah</a>
                                    <a href="download-excel-mahasiswa.php" class="btn btn-success mb-3"><i class="fas fa-file-excel"></i> Download Excel</a>
                                    <a href="download-pdf-mahasiswa.php" class="btn btn-danger mb-3"><i class="fas fa-file-pdf"></i> Download PDF</a>
                                    
                                    <table class="table table-bordered table-striped" id="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">prodi</th>
                                                <th scope="col">Jenis Kelamin</th>
                                                <th scope="col">Telepon</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach ($data_mahasiswa as $mahasiswa) {
                                            ?>
                                                <tr>
                                                    <th scope="row"><?= $no++; ?></th>
                                                    <td><?= strip_tags($mahasiswa['nama']); ?></td>
                                                    <td><?= strip_tags($mahasiswa['prodi']); ?></td>
                                                    <td><?= strip_tags($mahasiswa['jk']); ?></td>
                                                    <td><?= strip_tags($mahasiswa['telepon']); ?></td>
                                                    
                                                    <td>
                                                        <a href="detail-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa']; ?>" class="btn btn-secondary">Detail</a>
                                                        <a href="ubah-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa']; ?>" class="btn btn-success">Edit</a>
                                                        <a href="hapus-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
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
        </div>
    </div>
</div>

<?php include 'layout/footer.php' ?>