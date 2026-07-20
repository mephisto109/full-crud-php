<?php
session_start();
include 'config/app.php';

//chek apakah tombol login ditekan
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    //cek username
    $result = mysqli_query($db, "SELECT * FROM akun WHERE username = '$username'");

    //cek username
    if (mysqli_num_rows($result) === 1) {
        //cek password
        $row = mysqli_fetch_assoc($result);
        $storedPassword = $row['password'];

        if (password_verify($password, $storedPassword)) {
            //set session
            $_SESSION['login'] = true;
            $_SESSION['id_akun'] = $row['id_akun'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['level'] = $row['level'];
            echo "<script>
                alert('Login berhasil!');
                document.location.href = 'index.php';
            </script>";
        } elseif ($storedPassword === $password) {
            //fallback untuk akun lama yang password-nya masih plaintext
            $newPasswordHash = password_hash($password, PASSWORD_DEFAULT);
            mysqli_query($db, "UPDATE akun SET password = '$newPasswordHash' WHERE id_akun = " . $row['id_akun']);

            $_SESSION['login'] = true;
            $_SESSION['id_akun'] = $row['id_akun'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['level'] = $row['level'];
            echo "<script>
                alert('Login berhasil!');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Password salah!');
                document.location.href = 'login.php';
            </script>";
        }
    } else {
        echo "<script>
                alert('Username tidak ditemukan!');
                document.location.href = 'login.php';
            </script>";
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.104.2">
    <title>Signin Template · Bootstrap v5.2</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sign-in/">


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">



    <link href="/docs/5.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Favicons -->
    <link rel="icon" href="assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#712cf9">

    <link href="assets/css/signin.css" rel="stylesheet">
</head>

<body class="text-center">

    <main class="form-signin w-100 m-auto">
        <form action="" method="POST">
            <img class="mb-4" src="assets/img/bootstrap-logo.svg" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Admin Login</h1>

            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="Username" name="username" required>
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required>
                <label for="floatingPassword">Password</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit" name="login">Login</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2017–2022</p>
        </form>
    </main>


</body>

</html>