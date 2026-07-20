<?php
require_once __DIR__ . '/database.php';
// fungsi menampilkan barang (read )
function select($query)
{
    global $db;
    $result = mysqli_query($db, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// fungsi menambahkan barang (create)
function create_barang($post)
{
    global $db;
    $nama = strip_tags($post['Nama']);
    $jumlah = strip_tags($post['Jumlah']);
    $harga = strip_tags($post['Harga']);
    $barcode = rand(100000, 999999);

    $query = "INSERT INTO barang (nama, jumlah, harga, barcode) VALUES ('$nama', '$jumlah', '$harga', '$barcode')";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

// fungsi mengubah barang (update)
function update_barang($post, $id_barang)
{
    global $db;
    $id_barang = strip_tags($post['id_barang']);
    $nama = strip_tags($post['Nama']);
    $jumlah = strip_tags($post['Jumlah']);
    $harga = strip_tags($post['Harga']);

    $query = "UPDATE barang SET nama = '$nama', jumlah = '$jumlah', harga = '$harga' WHERE id_barang = $id_barang";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

// fungsi menghapus barang (delete)
function delete_barang($id_barang)
{
    global $db;
    $query = "DELETE FROM barang WHERE id_barang = $id_barang";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

// fungsi menghapus mahasiswa (delete)
function delete_mahasiswa($id_mahasiswa)
{
    global $db;

    //ambil foto sesuai data yang di pilih
    $foto = select("SELECT * FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa")[0];
    unlink('assets/img/' . $foto['foto']);

    $query = "DELETE FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

// fungsi menghapus akun (delete)
function delete_akun($id_akun)
{
    global $db;
    $query = "DELETE FROM akun WHERE id_akun = $id_akun";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);

}

//fungsi menambahkan mahasiswa (create)
function create_mahasiswa($post)
{
    global $db;
    $nama = strip_tags($post['Nama']);
    $prodi = strip_tags($post['prodi']);
    $jk = strip_tags($post['jk']);
    $telepon = strip_tags($post['telepon']);
    $alamat = strip_tags($post['alamat']);
    $email = strip_tags($post['email']);
    $foto = upload_file();
    if (!$foto) {
        return false;
    }

    $query = "INSERT INTO mahasiswa (nama, prodi, jk, telepon, alamat, email, foto) VALUES ('$nama', '$prodi', '$jk', '$telepon', '$alamat', '$email', '$foto')";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

//fungsi mengupload file foto
function upload_file()
{
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];


    //cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    //cek format/extensi file
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                alert('Format file tidak valid!');
                document.location.href = 'mahasiswa.php';
            </script>";
        return false;
    }

    //cek jika ukurannya terlalu besar
    if ($ukuranFile > 2048000) {
        echo "<script>
                alert('Ukuran gambar terlalu besar!');
                document.location.href = 'mahasiswa.php';
            </script>";
        return false;
    }

    //ganesi nama file baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    //pindahkan file ke folder assets/img
    move_uploaded_file($tmpName, 'assets/img/' . $namaFileBaru);

    return $namaFileBaru;
}

//fungsi mengubah mahasiswa (update)
function update_mahasiswa($post, $id_mahasiswa)
{
    global $db;
    $nama = strip_tags($post['Nama']);
    $prodi = strip_tags($post['prodi']);
    $jk = strip_tags($post['jk']);
    $telepon = strip_tags($post['telepon']);
    $alamat = strip_tags($post['alamat']);
    $email = strip_tags($post['email']);
    $fotoLama = strip_tags($post['fotoLama']);
    // cek upload foto baru atau tidak
    if ($_FILES['foto']['error'] === 4) {
        $foto = $fotoLama;
    } else {
        $foto = upload_file();
        if (!$foto) {
            return false;
        }
    }

    $query = "UPDATE mahasiswa SET nama = '$nama', prodi = '$prodi', jk = '$jk', telepon = '$telepon', alamat = '$alamat', email = '$email', foto = '$foto' WHERE id_mahasiswa = $id_mahasiswa";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

// fungsi tambah akun
function create_akun($post)
{
    global $db;
    $nama = strip_tags($post['nama']);
    $username = strip_tags($post['username']);
    $email = strip_tags($post['email']);
    $password = strip_tags($post['password']);
    $level = strip_tags($post['level']);

    //cek username sudah ada atau belum
    $result = mysqli_query($db, "SELECT username FROM akun WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('Username sudah terdaftar!');
                document.location.href = 'crud-modal.php';
            </script>";
        return false;
    }

    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //tambahkan akun ke database
    mysqli_query($db, "INSERT INTO akun (nama, username, email, password, level) VALUES ('$nama', '$username', '$email', '$password', '$level')");
    return mysqli_affected_rows($db);
}

//fungsi mengubah mahasiswa (update)
function update_akun($post, $id_akun)
{
    global $db;
    $id_akun = strip_tags($post['id_akun']);
    $nama = strip_tags($post['nama']);
    $username = strip_tags($post['username']);
    $email = strip_tags($post['email']);
    $password = strip_tags($post['password']);
    $level = strip_tags($post['level']);

    //enkripsi password jika diisi
    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        // jika password kosong, ambil password lama
        $result = mysqli_query($db, "SELECT password FROM akun WHERE id_akun = $id_akun");
        $row = mysqli_fetch_assoc($result);
        $password = $row['password'];
    }

    $query = "UPDATE akun SET nama = '$nama', username = '$username', email = '$email', password = '$password', level = '$level' WHERE id_akun = $id_akun";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}