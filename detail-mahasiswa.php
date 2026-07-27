<?php
session_start();
// membatasi halaman sebelum login
if (!isset($_SESSION['login'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            document.location.href = 'login.php';
        </script>";
}

$title = "Detail Mahasiswa";
include 'layout/header.php';



$id_mahasiswa = (int)$_GET['id_mahasiswa'];

$mahasiswa = select("SELECT * FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa")[0];
?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data <?= $mahasiswa['nama']; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="mahasiswa.php">Home</a></li>
                        <li class="breadcrumb-item active">Detail Mahasiswa</li>
                    </ol>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Detail mahasiswa</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <th>Nama</th>
                                            <td>: <?= strip_tags($mahasiswa['nama']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Prodi</th>
                                            <td>: <?= strip_tags($mahasiswa['prodi']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Kelamin</th>
                                            <td>: <?= strip_tags($mahasiswa['jk']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Telepon</th>
                                            <td>: <?= strip_tags($mahasiswa['telepon']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>: <?= strip_tags($mahasiswa['alamat']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>: <?= strip_tags($mahasiswa['email']); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Foto</th>
                                            <td>
                                                <a href="assets/img/<?= $mahasiswa['foto']; ?>" target="_blank">
                                                    <img src="assets/img/<?= $mahasiswa['foto']; ?>" alt="Foto <?= $mahasiswa['nama']; ?>" width="100">
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <a href="mahasiswa.php" class="btn btn-secondary float-end">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<script>
window.addEventListener("pageshow", function(event) {
    if (event.persisted) {
        window.location.reload();
    }
});
</script>

<?php include 'layout/footer.php' ?>