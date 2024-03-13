<?php
session_start();
require_once("database.php");

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location: login.php?msg=belum_login");
    exit();
}


$query = "SELECT * FROM transaksi";
$result = mysqli_query($dbconnect, $query);


if ($result) {
    $borrowers = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    echo "Error fetching borrowers: " . mysqli_error($dbconnect);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="css/style0.css" />
</head>

    <div class ="legot">
    <a type="submit" style="border: none;
    outline: none;
    background: #ff90bc;
    cursor: pointer;
    border-radius: 6px;
    font-weight: 600;
    width: auto;
    margin-bottom: 10px;
    text-decoration: none;
    display: inline-block;" href="#" onclick="confirmLogout()">Logout</a>

</div>


<body>

    <div class="box">
        <h2>List Peminjam</h2>

        <?php if (!empty($borrowers)) : ?>
            <table>
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Kode Barang</th>
                        <th>NIS</th>
                        <th>Tanggal Pinjam</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
    <?php foreach ($borrowers as $borrower) : ?>
        <tr>
            <td><?= $borrower['id_transaksi'] ?></td>
            <td><?= $borrower['kode_barang'] ?></td>
            <td><?= $borrower['nis'] ?></td>
            <td><?= $borrower['tanggal_pinjam'] ?></td>
            <td>
                <button class="pinjam-btn" onclick="kembalikanBarang(<?= $borrower['id_transaksi'] ?>)">Kembalikan</button>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
            </table>
        <?php else : ?>
            <p>No borrowers found.</p>
        <?php endif; ?>
        
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
                              
                            <button class="pinjam-btn" onclick="editStock(<?= $barang['kode_barang'] ?>)">Edit</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        <?php else : ?>
            <p>No items found.</p>
        <?php endif; ?>
    </div>
    <div class="box">
        <h2>List Pengguna</h2>

        <?php
      
        $queryUsers = "SELECT * FROM users";
        $resultUsers = mysqli_query($dbconnect, $queryUsers);

      
        if ($resultUsers) {
            $usersList = mysqli_fetch_all($resultUsers, MYSQLI_ASSOC);
        } else {
            echo "Error fetching users: " . mysqli_error($dbconnect);
            exit();
        }
        ?>

<?php if (!empty($usersList)) : ?>
    <table>
        <thead>
            <tr>
                <th>ID Login</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Username</th>
                <th>Role</th>
                <th>Action</th> 
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usersList as $user) : ?>
                <tr>
                    <td><?= $user['id_login'] ?></td>
                    <td><?= $user['nis'] ?></td>
                    <td><?= $user['nama'] ?></td>
                    <td><?= $user['status'] ?></td>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['role'] ?></td>
                    <td>
                       
                        <button class="pinjam-btn" onclick="hapusUser(<?= $user['id_login'] ?>)">Hapus</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>No users found.</p>
<?php endif; ?>
    </div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    function editStock(kode_barang) {
        var amount = prompt("Masukkan data untuk menambahkan stock | (-) untuk mengurangi:");
        if (amount != null && amount != "") {
           
            $.ajax({
                url: "update_stock.php",
                type: "POST",
                data: {
                    kode_barang: kode_barang,
                    amount: amount
                },
                success: function(response) {
          
                    alert(response);
                   
                },
                error: function(xhr, status, error) {
               
                    console.error(xhr.responseText);
                }
            });
        }
    }
    function hapusUser(id_login) {
      
        var confirmDelete = confirm("Apakah Anda yakin ingin menghapus user?");

        if (confirmDelete) {

            $.ajax({
                url: "hapus_user.php",
                type: "POST",
                data: {
                    id_login: id_login
                },
                success: function(response) {

                    alert(response);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    }
    function kembalikanBarang(id_transaksi) {
        var confirmReturn = confirm("Apakah Anda yakin ingin mengembalikan barang?");

        if (confirmReturn) {
            $.ajax({
                url: "kembali_barang.php", 
                type: "POST",
                data: {
                    id_transaksi: id_transaksi
                },
                success: function(response) {
                    alert(response);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    }
    function confirmLogout() {
        var confirmLogout = confirm("Apakah anda yakin ingin logout?");
        
        if (confirmLogout) {
            window.location.href = "logout.php";
        }
    }
</script>
</html>
