<?php
include 'config/app.php';

$id_mahasiswa = (int)$_GET['id_mahasiswa'];

    if (delete_mahasiswa($id_mahasiswa) > 0){
        echo "<script>
                alert('Data Mahasiswa berhasil dihapus!');
                document.location.href = 'mahasiswa.php';
            </script>";
    } else {
        echo "<script>
                alert('Data Mahasiswa gagal dihapus!');
                document.location.href = 'mahasiswa.php';
            </script>";
    }

