<?php
session_start();
include('../database/connect.php');

if (isset($_POST['add']) || isset($_POST['subtract'])) {
    $product_id = $_POST['product_id'];
    $new_quantity = $_POST['new_quantity'];

    if ($new_quantity < 0) {
        $new_quantity = 0;
    }

    // Perbarui kuantitas dalam tabel cart_table
    $user_id = $_SESSION['user_id'];
    $sql = "UPDATE cart_table SET quantity = $new_quantity WHERE user_id = $user_id AND product_id = $product_id";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error updating quantity: " . mysqli_error($conn));
    }

    // Redirect back to the cart page or display a success message
    header('Location: cart.php'); // Ganti 'cart.php' dengan halaman keranjang Anda
    exit;
}
