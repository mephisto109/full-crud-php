<?php
session_start();
// membatasi halaman sebelum login
if (!isset($_SESSION['login'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            document.location.href = 'login.php';
        </script>";
}

$title = "Kirim Email";
include 'layout/header.php';  
require 'email-proses.php';                                  

?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kirim Email</h1>
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
                                    <h3 class="card-title">Kirim Email</h3>
                                </div>
                                <div class="card-body">
                                    <form action="" method="post">
                                        <div class="mb-3">
                                            <label for="email penerima" class="form-label">Email Penerima</label>
                                            <input type="text" class="form-control" id="email penerima"
                                                name="email penerima" placeholder="Email penerima..." required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="subject" class="form-label">Subject</label>
                                            <input type="text" class="form-control" id="subject" name="subject"
                                                placeholder="Subject..." required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="pesan" class="form-label">Pesan</label>
                                            <textarea name="pesan" id="pesan" cols="30" rows="10"
                                                class="form-control"></textarea>
                                        </div>

                                        <button type="submit" name="kirim" class="btn btn-primary"
                                            style="float: right;">Kirim</button>
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
<script>
window.addEventListener("pageshow", function(event) {
    if (event.persisted) {
        window.location.reload();
    }
});
</script>

<?php include 'layout/footer.php' ?>