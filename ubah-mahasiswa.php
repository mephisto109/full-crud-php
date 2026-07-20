<?php
session_start();
// membatasi halaman sebelum login
if (!isset($_SESSION['login'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            document.location.href = 'login.php';
        </script>";
}

$title = "ubah Mahasiswa";
include 'layout/header.php';

if (isset($_POST['ubah'])) {
    if (update_mahasiswa($_POST, $id_mahasiswa) > 0) {
        echo "<script>
                alert('Data Mahasiswa berhasil diubahkan!');
                document.location.href = 'mahasiswa.php';
            </script>";
    } else {
        echo "<script>
                alert('Data Mahasiswa gagal diubahkan!');
                document.location.href = 'mahasiswa.php';
            </script>";
    }
}

$id_mahasiswa = (int)$_GET['id_mahasiswa'];
$mahasiswa = select("SELECT * FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa")[0];
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Ubah Mahasiswa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="mahasiswa.php">Home</a></li>
                        <li class="breadcrumb-item active">Ubah Mahasiswa</li>
                    </ol>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Form Ubah Mahasiswa</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <input type="hidden" name="id_mahasiswa" value="<?= $mahasiswa['id_mahasiswa']; ?>">
                                        <input type="hidden" name="fotoLama" value="<?= $mahasiswa['foto']; ?>">
                                        
                                        <div class="mb-3">
                                            <label for="Nama" class="form-label">Nama Mahasiswa</label>
                                            <input type="text" class="form-control" id="Nama" name="Nama" placeholder="Nama Mahasiswa.." required value="<?php echo $mahasiswa['nama']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-3 col-6">
                                                <label for="prodi" class="form-label">Program Studi</label>
                                                <select name="prodi" id="prodi" class="form-control" required>
                                                    <option value="">-- Pilih Program Studi --</option>
                                                    <option value="Teknik Informatika" <?php echo ($mahasiswa['prodi'] == 'Teknik Informatika') ? 'selected' : ''; ?>>Teknik Informatika</option>
                                                    <option value="Teknik Mesin" <?php echo ($mahasiswa['prodi'] == 'Teknik Mesin') ? 'selected' : ''; ?>>Teknik Mesin</option>
                                                    <option value="Teknik Listrik" <?php echo ($mahasiswa['prodi'] == 'Teknik Listrik') ? 'selected' : ''; ?>>Teknik Listrik</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-3 col-6">
                                                <label for="jk" class="form-label">Jenis Kelamin</label>
                                                <select name="jk" id="jk" class="form-control" required>
                                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                                    <option value="Laki-laki" <?php echo ($mahasiswa['jk'] == 'Laki-laki') ? 'selected' : null ?>>Laki-laki</option>
                                                    <option value="Perempuan" <?php echo ($mahasiswa['jk'] == 'Perempuan') ? 'selected' : null ?>>Perempuan</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="telepon" class="form-label">Telepon</label>
                                            <input type="number" class="form-control" id="telepon" name="telepon" placeholder="Telepon.." required value="<?php echo $mahasiswa['telepon']; ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat.." required><?php echo $mahasiswa['alamat']; ?></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email.." required value="<?php echo $mahasiswa['email']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="foto" class="form-label">Foto</label>
                                            <input type="file" class="form-control" id="foto" name="foto" placeholder="Foto.." required onchange="previewImg()">
                                            <br>
                                            <a href="assets/img/<?= $mahasiswa['foto']; ?>" target="_blank">
                                                <img src="assets/img/<?= $mahasiswa['foto']; ?>" alt="foto" class="img-thumbnail img-preview" width="100">
                                            </a>
                                        </div>
                                        <button type="submit" class="btn btn-primary float-end" name="ubah">Ubah</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!-- preview gambar -->
<script>
    function previewImg() {
        const foto = document.querySelector('#foto');
        const imgPreview = document.querySelector('.img-preview');

        const fileFoto = new FileReader();
        fileFoto.readAsDataURL(foto.files[0]);

        fileFoto.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }
</script>

<?php include 'layout/footer.php' ?>