<?php
session_start();
include('database/connect.php');

if (isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['user_id'])) {
        header('location: loginAndRegister/login.php');
    } else {
        $id_produk = $_POST['id_produk'];
        $id_user = $_POST['id_user'];

        $check_query = "SELECT * FROM cart_table WHERE product_id = '$id_produk' AND user_id = '$id_user'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $update_query = "UPDATE cart_table SET quantity = quantity + 1 WHERE product_id = '$id_produk' AND user_id = '$id_user'";
            $update_result = mysqli_query($conn, $update_query);
            // if ($update_result) {
            //     echo "<script>alert('Jumlah produk dalam keranjang berhasil diperbarui')</script>";
            // } else {
            //     echo "<script>alert('Gagal memperbarui jumlah produk dalam keranjang')</script>";
            // }
        } else {
            $insert_query = "INSERT INTO cart_table (product_id, user_id, quantity) VALUES ('$id_produk', '$id_user', 1)";
            $insert_result = mysqli_query($conn, $insert_query);
            // if ($insert_result) {
            //     echo "<script>alert('Produk berhasil ditambahkan ke keranjang')</script>";
            // } else {
            //     echo "<script>alert('Gagal menambahkan produk ke keranjang')</script>";
            // }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafetarian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            padding-top: 80px;
        }
    </style>
</head>

<nav class="navbar navbar-expand-lg fixed-top bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="#">
            Cafetarian
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php
                if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] != 0 || $_SESSION['user_id'] != 1)) {
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link navbar-btn" href="bridge/bridge.php">Account</a>';
                    echo '</li>';
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link navbar-btn" href="cart/cart.php">Cart</a>';
                    echo '</li>';
                } else {
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link navbar-btn" href="cart/cart.php">Cart</a>';
                    echo '</li>';
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link navbar-btn" href="loginAndRegister/login.php">Login</a>';
                    echo '</li>';
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link navbar-btn" href="loginAndRegister/register.php">Register</a>';
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center mb-4">
                    <h3>Our Menus</h3>
                    <div class="btn-group">
                        <a href="?category=" class="btn btn-secondary ">All</a>
                        <a href="?category=Appetizer" class="btn btn-secondary">Appetizer</a>
                        <a href="?category=Side Dish" class="btn btn-secondary">Side Dish</a>
                        <a href="?category=Beverages" class="btn btn-secondary">Beverages</a>
                        <a href="?category=Main Course" class="btn btn-secondary">Main Course</a>
                        <a href="?category=Dessert" class="btn btn-secondary">Dessert</a>
                    </div>
                </div>
            </div>
            <?php
            $categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';

            $sql = "SELECT * FROM data_makanan";
            if (!empty($categoryFilter)) {
                $sql = "SELECT * FROM data_makanan WHERE kategori_menu = '$categoryFilter'";
            }

            $result = mysqli_query($conn, $sql);
            $userid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : -1;
            foreach ($result as $key) : ?>
                <div class="col-4">
                    <div class="card mb-2">
                        <img src="admin/uploads/<?= $key['gambar_menu'] ?>" class="card-img-top" alt="<?= $key['gambar_menu'] ?>" width="200" height="350" style="object-fit: cover;">
                        <div class="row">
                            <div class="col">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $key['nama_menu'] ?></h5>
                                    <p class="card-text">Rp<?= number_format($key['harga_menu'], 0, ',', '.') ?></p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card-body">
                                    <form action="" method="post">
                                        <div class="">
                                            <button class="btn btn-primary" type="submit" name="add_to_cart">Tambah</button>
                                            <input type="hidden" name="id_produk" value="<?= $key['id_menu'] ?>">
                                            <input type="hidden" name="id_user" value="<?= $userid ?>">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <?= $key['deskripsi_menu'] ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>



</body>

</html>