<?php
session_start();
// membatasi halaman sebelum login
if (!isset($_SESSION['login'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            document.location.href = 'login.php';
        </script>";
}

$title = "Tambah Mahasiswa";
include 'layout/header.php';

if (isset($_POST['tambah'])) {
    if (create_mahasiswa($_POST) > 0) {
        echo "<script>
                alert('Data Mahasiswa berhasil ditambahkan!');
                document.location.href = 'mahasiswa.php';
            </script>";
    } else {
        echo "<script>
                alert('Data Mahasiswa gagal ditambahkan!');
                document.location.href = 'mahasiswa.php';
            </script>";
    }
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Mahasiswa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="mahasiswa.php">Home</a></li>
                        <li class="breadcrumb-item active">Tambah Mahasiswa</li>
                    </ol>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Form Tambah Mahasiswa</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="Nama" class="form-label">Nama Mahasiswa</label>
                                            <input type="text" class="form-control" id="Nama" name="Nama" placeholder="Nama Mahasiswa.." required>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-3 col-6">
                                                <label for="prodi" class="form-label">Program Studi</label>
                                                <select name="prodi" id="prodi" class="form-control" required>
                                                    <option value="">-- Pilih Program Studi --</option>
                                                    <option value="Teknik Informatika">Teknik Informatika</option>
                                                    <option value="Teknik Mesin">Teknik Mesin</option>
                                                    <option value="Teknik Listrik">Teknik Listrik</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-3 col-6">
                                                <label for="jk" class="form-label">Jenis Kelamin</label>
                                                <select name="jk" id="jk" class="form-control" required>
                                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                                    <option value="Laki-laki">Laki-laki</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="telepon" class="form-label">Telepon</label>
                                            <input type="number" class="form-control" id="telepon" name="telepon" placeholder="Telepon.." required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat.." required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email.." required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="foto" class="form-label">Foto</label>
                                            <input type="file" class="form-control" id="foto" name="foto" placeholder="Foto.." required
                                                onchange="previewImg()">
                                            <br>
                                            <a href="assets/img/<?= $mahasiswa['foto']; ?>" target="_blank">
                                                <img src="" alt="" class="img-thumbnail img-preview" width="100">
                                            </a>
                                        </div>
                                        <button type="submit" class="btn btn-primary float-end" name="tambah">Tambah</button>
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

        fileFoto.onload = function (e) {
            imgPreview.src = e.target.result;
        }
    }
</script>
<?php include 'layout/footer.php' ?>