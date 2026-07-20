<?php
session_start();
// membatasi halaman sebelum login
if (!isset($_SESSION['login'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            document.location.href = 'login.php';
        </script>";
}

$title = "Tambah Barang";
include 'layout/header.php';



if (isset($_POST['tambah'])) {
    if (create_barang($_POST) > 0) {
        echo "<script>
                alert('Data Barang berhasil ditambahkan!');
                document.location.href = 'index.php';
            </script>";
    } else {
        echo "<script>
                alert('Data Barang gagal ditambahkan!');
                document.location.href = 'index.php';
            </script>";
    }
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Barang</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Tambah Barang</li>
                    </ol>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Form Tambah Barang</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="">
                                        <div class="mb-3">
                                            <label for="Nama" class="form-label">Nama Barang</label>
                                            <input type="text" class="form-control" id="Nama" name="Nama" placeholder="Nama Barang.." required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="Jumlah" class="form-label">Jumlah</label>
                                            <input type="number" class="form-control" id="Jumlah" name="Jumlah" placeholder="Jumlah Barang.." required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="Harga" class="form-label">Harga Barang</label>
                                            <input type="number" class="form-control" id="Harga" name="Harga" placeholder="Harga Barang.." required>
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

<?php include 'layout/footer.php' ?>