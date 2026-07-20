<?php
include 'config/app.php';

$id_akun = (int)$_GET['id_akun'];

    if (delete_akun($id_akun) > 0){
        echo "<script>
                alert('Data akun berhasil dihapus!');
                document.location.href = 'crud-modal.php';
            </script>";
    } else {
        echo "<script>
                alert('Data akun gagal dihapus!');
                document.location.href = 'crud-modal.php';
            </script>";
    }

?>