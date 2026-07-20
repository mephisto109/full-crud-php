<?php
session_start();
// membatasi halaman sebelum login
if (!isset($_SESSION['login'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            document.location.href = 'login.php';
        </script>";
}

$title = "Data Akun";

include 'layout/header.php';

$data_akun = select("SELECT * FROM akun ORDER BY id_akun DESC");

//tampil data berdasarkan user login
$id_akun = $_SESSION['id_akun'];
$data_bylogin = select("SELECT * FROM akun WHERE id_akun = $id_akun");

//jika tombol tambah di tekan jalankan script dibawah ini
if (isset($_POST['tambah'])) {
    if (create_akun($_POST) > 0) {
        echo "<script>
                alert('Data Akun berhasil ditambahkan!');
                document.location.href = 'crud-modal.php';
            </script>";
    } else {
        echo "<script>
                alert('Data Akun gagal ditambahkan!');
                document.location.href = 'crud-modal.php';
            </script>";
    }
}
if (isset($_POST['ubah'])) {
    if (update_akun($_POST, $id_akun) > 0) {
        echo "<script>
                alert('Data Akun berhasil diubahkan!');
                document.location.href = 'crud-modal.php';
            </script>";
    } else {
        echo "<script>
                alert('Data Akun gagal diubahkan!');
                document.location.href = 'crud-modal.php';
            </script>";
    }
}

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Akun</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="crud-modal.php">Home</a></li>
                        <li class="breadcrumb-item active">Data Akun</li>
                    </ol>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Daftar akun pengguna</h3>
                                </div>
                                <div class="card-body">
                                    <?php if ($_SESSION['level'] == 1): ?>
                                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                                            data-target="#modalTambah"><i class="fas fa-plus"></i> Tambah Akun </button>
                                    <?php endif; ?>

                                    <table class="table table-bordered table-striped" id="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Username</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Password</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;
                                            if ($_SESSION['level'] == 1): ?>
                                                <?php foreach ($data_akun as $akun): ?>
                                                    <tr>
                                                        <th scope="row"><?= $no++; ?></th>
                                                        <td><?= $akun['nama']; ?></td>
                                                        <td><?= $akun['username']; ?></td>
                                                        <td><?= $akun['email']; ?></td>
                                                        <td>Password Ter-enkripsi</td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                                data-target="#modalUbah<?= $akun['id_akun']; ?>">
                                                                Edit
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                                data-target="#modalHapus<?= $akun['id_akun']; ?>">
                                                                Hapus
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <?php foreach ($data_bylogin as $akun): ?>
                                                    <tr>
                                                        <th scope="row"><?= $no++; ?></th>
                                                        <td><?= $akun['nama']; ?></td>
                                                        <td><?= $akun['username']; ?></td>
                                                        <td><?= $akun['email']; ?></td>
                                                        <td>Password Ter-enkripsi</td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                                data-target="#modalUbah<?= $akun['id_akun']; ?>">
                                                                Edit
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
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

<!-- Modal tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTambahLabel">Tambah Akun</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div>
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div>
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div>
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div>
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="mb-3">
                        <label for="level" class="form-label">Level</label>
                        <select class="form-control" id="level" name="level" required>
                            <option value="">Pilih Level</option>
                            <option value="1" <?= $akun['level'] == '1' ? 'selected' : '' ?>>Admin</option>
                            <option value="2" <?= $akun['level'] == '2' ? 'selected' : '' ?>>Operator Barang</option>
                            <option value="3" <?= $akun['level'] == '3' ? 'selected' : '' ?>>Operator Mahasiswa</option>
                        </select>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- modal hapus -->
<?php foreach ($data_akun as $akun): ?>
    <div class="modal fade" id="modalHapus<?= $akun['id_akun']; ?>" tabindex="-1" aria-labelledby="modalTambahLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTambahLabel">Hapus Akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <p>Apakah Anda yakin ingin menghapus akun <?= $akun['nama']; ?>?</p>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <a href="hapus-akun.php?id_akun=<?= $akun['id_akun']; ?>" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- modal ubah -->
<?php foreach ($data_akun as $akun): ?>

    <div class="modal fade" id="modalUbah<?= $akun['id_akun']; ?>" tabindex="-1" aria-labelledby="modalUbahLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalUbahLabel">Ubah Akun <?= $akun['nama']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <input type="hidden" name="id_akun" value="<?= $akun['id_akun']; ?>">
                        <div>
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= $akun['nama']; ?>"
                                required>
                        </div>
                        <div>
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="<?= $akun['username']; ?>" required>
                        </div>
                        <div>
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $akun['email']; ?>"
                                required>
                        </div>
                        <div>
                            <label for="password" class="form-label">Password <small>(Kosongkan jika tidak ingin
                                    mengubah)</small></label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>

                        <?php if ($_SESSION['level'] == 1): ?>
                            <div class="mb-3">
                                <label for="level">Level</label>
                                <select name="level" id="level" class="form-control" required>
                                    <?php $level = $akun['level']; ?>
                                    <option value="1" <?= $level == '1' ? 'selected' : null ?>>Admin</option>
                                    <option value="2" <?= $level == '2' ? 'selected' : null ?>>Operator Barang</option>
                                    <option value="3" <?= $level == '3' ? 'selected' : null ?>>Operator Mahasiswa</option>
                                </select>
                            </div>
                        <?php else: ?>
                            <input type="hidden" name="level" value="<?= $akun['level']; ?>">
                        <?php endif; ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
                </div>
                </form>
            </div>
        </div>
    </div>

<?php endforeach; ?>

<?php include 'layout/footer.php' ?>