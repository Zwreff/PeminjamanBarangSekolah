<?php
require_once('database.php');
session_start();

if (isset($_POST['masuk'])) {
    $nis = $_POST['nis'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $nama = $_POST['nama'];
    $inputdata = "INSERT INTO users (nis, username, password, nama) VALUES ('$nis', '$username', '$password', '$nama')";

    if (inputdata($inputdata)) {
        $_SESSION['username'] = $username;
        $_SESSION['status'] = "login";
        header("location: login.php");
        exit();
    } else {
        header("location: signup.php?msg=gagal");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Signup</title>
    <link rel="stylesheet" href="css/styles.css" />
</head>

<body>
    <div class="box">
        <form autocomplete="off" action="signup.php" method="POST">
            <h2>Sign up</h2>
            <div class="inputBox">
                <input type="text" name="nis" required="required" />
                <span>NIS</span>
                <i></i>
            </div>
            <div class="inputBox">
                <input type="text" name="nama" required="required" />
                <span>Nama</span>
                <i></i>
            </div>

            <div class="inputBox">
                <input type="text" name="username" required="required" />
                <span>Username</span>
                <i></i>
            </div>
            <div class="inputBox">
                <input type="password" name="password" required="required" />
                <span>Password</span>
                <i></i>
            </div>

        
            <input type="submit" name="masuk" value="Create Account" />
        </form>
    </div>
    <img src="img\icon.png" alt="Person Image" class="person-image2" />
</body>
</html>
