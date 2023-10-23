<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    header('location: ../loginAndRegister/login.php');
    exit;
}
//  else {
//     // $id = $_SESSION['user_id'];
// }

include '../database/connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            padding-top: 80px;
        }
    </style>
</head>


<nav class="navbar navbar-expand-lg fixed-top bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="../index.php">Cafetarian</a>
    </div>
</nav>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 ">
                <?php
                $sql = "SELECT * FROM access_table WHERE id = $_SESSION[user_id]";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                echo '<h3 class="">Nama Lengkap: ' . $row['first_name'] . ' ' . $row['last_name'] . '</h3>';
                echo '<h3>Username: ' . $row['username'] . '</h3>';
                ?>
                <a href="../logout/logout.php" class="btn btn-danger mb-1">Logout</a>

            </div>
            <div class="col-12 col-md-6 ">
                <?php
                // untuk memperlihatkan kategori menu dan menu itemnya
                $sql_show_category = "SELECT DISTINCT kategori_menu FROM data_makanan ORDER BY kategori_menu ASC";
                $result_show_category = mysqli_query($conn, $sql_show_category);

                $menuItemsByCategory = [];

                while ($category = mysqli_fetch_assoc($result_show_category)) {
                    $categoryName = $category['kategori_menu'];
                    $sql_show_category_item = "SELECT nama_menu FROM data_makanan WHERE kategori_menu = '$categoryName' ORDER BY nama_menu ASC";
                    $result_show_category_item = mysqli_query($conn, $sql_show_category_item);
                    $menuItems = [];
                    while ($menuItem = mysqli_fetch_assoc($result_show_category_item)) {
                        $menuItems[] = $menuItem['nama_menu'];
                    }
                    $menuItemsByCategory[$categoryName] = $menuItems;
                }
                ?>
                <!-- <h3 class="mt-4">Kategori Menu</h3> -->
                <div class="row">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Nama Menu</th>
                                <th>Jumlah Item</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($menuItemsByCategory as $category => $menuItems) :
                            ?>
                                <tr>
                                    <td><?= $category ?></td>
                                    <td><?= !empty($menuItems) ? implode(', ', $menuItems) : 'Isi Kosong' ?></td>
                                    <td><?= count($menuItems) ?></td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <a href="admin_insert.php" class="btn btn-dark mb-1">Tambah Menu</a>
        </div>
        <!-- <a href="../index.php" class="btn btn-primary mb-1">Homepage</a> -->
        <!-- <h3 class="mt-3">Semua Menu</h3> -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th>Gambar Menu</th>
                    <th>Deskripsi Menu</th>
                    <th>Harga Menu</th>
                    <th>Kategori Menu</th>
                    <th>Edit</th>
                    <!-- <th>Delete</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM data_makanan ORDER BY id_menu DESC";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    foreach ($result as $row) :
                ?>
                        <tr>
                            <td><?= $row['nama_menu'] ?></td>
                            <td>
                                <img src="uploads/<?= $row['gambar_menu'] ?>" width="200" height="150" style="object-fit: cover;">
                            </td>
                            <td class="col-md-6"><?= $row['deskripsi_menu'] ?></td>
                            <td>Rp <?= number_format($row['harga_menu'], 0, ',', '.') ?></td>
                            <td><?= $row['kategori_menu'] ?></td>
                            <td>
                                <div class="row mx-1 mb-1">
                                    <a href="admin_edit.php?id=<?= $row['id_menu'] ?>" class="btn btn-warning text-light btn-block mb-1">Edit</a>
                                    <a href="admin_delete.php?id=<?= $row['id_menu'] ?>" class="btn btn-danger btn-block">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php
                    endforeach;
                } else {
                    ?>
                    <tr>
                        <td colspan="6">Isi Kosong</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>

        </table>
    </div>
</body>

</html>