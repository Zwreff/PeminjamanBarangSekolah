<?php
session_start();
require_once("database.php");

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location: login.php?msg=belum_login");
    exit();
}


if (isset($_SESSION['role']) && $_SESSION['role'] == "admin") {
    header("location: admin.php");
    exit();
}


require_once('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kode_barang'])) {
    $kode_barang = mysqli_real_escape_string($dbconnect, $_POST['kode_barang']);

    $barangInfo = tampilanBarangById($kode_barang);

    if ($barangInfo) {
        $currentStock = $barangInfo['jumlah'];

        if ($currentStock > 0) {
       
            mysqli_autocommit($dbconnect, false);

            $newStock = $currentStock - 1;
            $updateStockQuery = "UPDATE barang SET jumlah = '$newStock' WHERE kode_barang = '$kode_barang'";

            if (mysqli_query($dbconnect, $updateStockQuery)) {
                mysqli_commit($dbconnect);
                echo "Stock reduced successfully.";
            } else {

                mysqli_rollback($dbconnect);
                echo "Error updating stock: " . mysqli_error($dbconnect);
            }


            mysqli_autocommit($dbconnect, true);
        } else {
            echo "Not enough stock available.";
        }
    } else {
        echo "Item not found.";
    }
} else {
    echo "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style0.css" />
    <title>Peminjaman Barang</title>
</head>
<body>
<div class="box">
    <div style="text-align: right;">
        <?php

        if (isset($_SESSION['user_data'])) {
            $user_data = $_SESSION['user_data'];

            
            echo '<a type="submit" style="border: none;
            outline: none;
            background: #ff90bc;
            cursor: pointer;
            border-radius: 6px;
            font-weight: 600;
            width: auto;
            margin-bottom: 10px;
            text-decoration: none;
            display: inline-block;" href="#" onclick="confirmLogout()">Logout</a>
        ';
        } else {

          
            echo '<a type="submit" style="border: none;
            outline: none;
            background: #ff90bc;
            cursor: pointer;
            border-radius: 6px;
            font-weight: 600;
            width: auto;
            margin-bottom: 10px;
            text-decoration: none;
            display: inline-block;" href="#" onclick="confirmLogout()">Logout</a>
        ';
        }
        ?>
    </div>
    <div class="box">
        <h2>List Barang</h2>

        <?php
    
        $barangList = tampilanBarang();
        ?>

        <?php if (!empty($barangList)) : ?>
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>ID Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Merk</th>
                        <th>Jumlah Stok</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($barangList as $barang) : ?>
                        <tr>
                            <td><?= $barang['kode_barang'] ?></td>
                            <td><?= $barang['nama_brg'] ?></td>
                            <td><?= $barang['kategori'] ?></td>
                            <td><?= $barang['merk'] ?></td>
                            <td><?= $barang['jumlah'] ?></td>
                            <td>
                              
                                <button class="pinjam-btn" onclick="pinjamBarang(<?= $barang['kode_barang'] ?>)">Pinjam</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        <?php else : ?>
            <p>No items found.</p>
        <?php endif; ?>
    </div>
    <img src="img\skrs.png" alt="Person Image" class="person-image" />
</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
function pinjamBarang(kode_barang) {
    $.ajax({
        type: "POST",
        url: "pinjam_barang.php",
        data: { kode_barang: kode_barang },
        success: function(response) {
            alert(response); 
            location.reload(); 
        },
        error: function(error) {
            alert("Error: " + error.responseText);
        }
    });
}
function confirmLogout() {
        var confirmLogout = confirm("Apakah anda yakin ingin logout?");
        
        if (confirmLogout) {
            window.location.href = "logout.php";
        }
    }
</script>
</html>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
