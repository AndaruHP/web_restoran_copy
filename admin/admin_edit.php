<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    header('location: ../user/user_dashboard.php');
    exit;
}

include('../database/connect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM data_makanan WHERE id_menu = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    // var_dump($row);
}

if (isset($_POST['update_button'])) {
    $id_menu = $_POST['id_menu'];
    $nama_menu = htmlspecialchars($_POST['nama_menu']);
    $foto_menu = $_FILES['foto_menu']['name'];
    $foto_menu_lama = $_POST['gambarLama'];
    $deskripsi_menu = htmlspecialchars($_POST['deskripsi_menu']);
    $harga_menu = htmlspecialchars($_POST['harga_menu']);
    $kategori_menu = $_POST['kategori_menu'];
    $uploads_dir = 'uploads/';

    if ($_FILES['foto_menu']['error'] === 4) {
        $foto_menu = $foto_menu_lama;
    }

    if (empty($nama_menu) || empty($deskripsi_menu) || empty($harga_menu) || empty($kategori_menu)) {
        $errorAlert = true;
        $error_message = "Semua data harus diisi";
    } else {
        move_uploaded_file($_FILES['foto_menu']['tmp_name'], $uploads_dir . $foto_menu);

        $sql = "UPDATE data_makanan SET nama_menu = '$nama_menu', gambar_menu = '$foto_menu', deskripsi_menu = '$deskripsi_menu', harga_menu = '$harga_menu', kategori_menu = '$kategori_menu' WHERE id_menu = $id_menu";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            header('location: admin_dashboard.php');
        } else {
            echo 'Error: ' . mysqli_error($conn);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-3 col-6">
        <div class="card p-3">
            <h3>Edit Data</h3>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_menu" value="<?= $row['id_menu'] ?>">
                <input type="hidden" name="gambarLama" value="<?= $row['gambar_menu'] ?>">
                <div class="form-group">
                    <label for="nama_menu">Nama Menu:</label>
                    <input type="text" class="form-control" name="nama_menu" value="<?= $row['nama_menu'] ?>">
                </div>
                <div class="form-group row">
                    <label for="foto_menu" class="col-sm-2 col-form-label">Gambar Menu:</label>
                    <div class="col-sm-4">
                        <img src="uploads/<?= $row['gambar_menu'] ?>" class="img-thumbnail" alt="Gambar Menu" width="200">
                        <p>Recent photos: <?= $row['gambar_menu'] ?></p>
                    </div>
                    <input type="file" class="form-control-file" name="foto_menu">
                </div>
                <div class="form-group">
                    <label for="deskripsi_menu">Deskripsi Menu:</label>
                    <textarea class="form-control" name="deskripsi_menu" rows="3"><?php echo $row['deskripsi_menu'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="harga_menu">Harga Menu:</label>
                    <input type="number" class="form-control" name="harga_menu" value="<?= $row['harga_menu'] ?>">
                </div>
                <div class="form-group">
                    <label for="kategori_menu">Kategori Menu:</label>
                    <select class="form-control" name="kategori_menu">
                        <option value="Appetizer" <?= $row['kategori_menu'] === 'Appetizer' ? 'selected' : '' ?>>Appetizer</option>
                        <option value="Beverages" <?= $row['kategori_menu'] === 'Beverages' ? 'selected' : '' ?>>Beverages</option>
                        <option value="Main Course" <?= $row['kategori_menu'] === 'Main Course' ? 'selected' : '' ?>>Main Course</option>
                        <option value="Dessert" <?= $row['kategori_menu'] === 'Dessert' ? 'selected' : '' ?>>Dessert</option>
                        <option value="Side Dish" <?= $row['kategori_menu'] === 'Side Dish' ? 'selected' : '' ?>>Side Dish</option>
                    </select>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <button type="submit" class="btn btn-primary" name="update_button">Insert Data</button>
                    </div>
                    <div class="col">
                        <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>