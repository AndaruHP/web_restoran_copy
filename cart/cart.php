<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location: ../loginAndRegister/login.php');
    exit;
}

include('../database/connect.php');
$user_id = $_SESSION['user_id'];


if (isset($_POST['checkout'])) {
    $sql = "SELECT dm.*, ct.quantity FROM data_makanan dm LEFT JOIN cart_table ct ON dm.id_menu = ct.product_id WHERE ct.user_id = $user_id";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error: " . mysqli_error($conn));
    }

    $cart = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($cart as $item) {
        if ($item['quantity'] > 0) {
            $menuName = $item['nama_menu'];
            $quantity = $item['quantity'];
            $productPrice = $item['harga_menu'] * $quantity;

            $insertHistoryQuery = "INSERT INTO history_user (id_user, nama_menu, quantity, total_price) VALUES ('$user_id', '$menuName', '$quantity', '$productPrice')";
            $insertHistoryResult = mysqli_query($conn, $insertHistoryQuery);

            if (!$insertHistoryResult) {
                die("Error: " . mysqli_error($conn));
            }
        }
    }
    $deleteCartQuery = "DELETE FROM cart_table WHERE user_id = $user_id";
    $deleteCartResult = mysqli_query($conn, $deleteCartQuery);

    if (!$deleteCartResult) {
        die("Error: " . mysqli_error($conn));
    }

    header('Location: ../index.php');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            padding-top: 40px;
        }
    </style>
</head>

<nav class="navbar navbar-expand-lg fixed-top bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="../index.php">
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
                    echo '<a class="nav-link navbar-btn" href="../bridge/bridge.php">Account</a>';
                    echo '</li>';
                    echo '<li class="nav-item">';
                    echo '</li>';
                } else {
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link navbar-btn" href="../loginAndRegister/login.php">Login</a>';
                    echo '</li>';
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link navbar-btn" href="../loginAndRegister/register.php">Register</a>';
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-body">

                        <?php


                        // Create an SQL query that joins the two tables
                        $sql = "SELECT dm.*, ct.quantity FROM data_makanan dm LEFT JOIN cart_table ct ON dm.id_menu = ct.product_id WHERE ct.user_id = $user_id";
                        $result = mysqli_query($conn, $sql);

                        if (!$result) {
                            die("Error: " . mysqli_error($conn));
                        }

                        // Fetch the data
                        $cart = mysqli_fetch_all($result, MYSQLI_ASSOC);

                        // Loop through the combined data
                        $totalprice = 0;
                        $_SESSION['totalprice'] = $totalprice;

                        foreach ($cart as $item) {
                            if ($item['quantity'] > 0) {
                        ?>
                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <img src='../admin/uploads/<?= $item['gambar_menu'] ?>' width='200' height='150' style='object-fit: cover;'>
                                    </div>
                                    <div class="col-md-5">
                                        <h4>Product Name: <?= $item['nama_menu'] ?></h4>
                                        <p>Product Price: Rp <?= number_format($item['harga_menu'] * $item['quantity'], 0, ',', '.') ?></p>
                                        <div class="row">
                                            <div class="col">
                                                <form method='post' action='update_quantity.php'>
                                                    <input type='hidden' name='product_id' value='<?= $item['id_menu'] ?>'>
                                                    <input type='hidden' name='new_quantity' value='<?= ($item['quantity'] + 1) ?>'>
                                                    <input type='submit' name='add' value='+'>
                                                </form>
                                            </div>
                                            <div class="col">
                                                <p>Quantity: <?= $item['quantity'] ?></p>
                                            </div>
                                            <div class="col">
                                                <form method='post' action='update_quantity.php'>
                                                    <input type='hidden' name='product_id' value='<?= $item['id_menu'] ?>'>
                                                    <input type='hidden' name='new_quantity' value='<?= ($item['quantity'] - 1) ?>'>
                                                    <input type='submit' name='subtract' value='-'>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                                $productprice = $item['harga_menu'] * $item['quantity'];
                                $totalprice += $productprice;
                            }
                        }
                        // Checkout button
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-9">
                            <h4>Total Price: Rp <?= number_format($_SESSION['totalprice'], 0, ',', '.') ?></h4>
                        </div>
                        <div class="col-md-3">
                            <form action="" method="post">
                                <input type="submit" name="checkout" value="Checkout" class="btn btn-success">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>