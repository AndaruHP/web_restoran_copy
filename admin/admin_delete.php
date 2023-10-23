<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    header('location: ../user/user_dashboard.php');
    exit;
}

include('../database/connect.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h3>Delete Menu</h3>

        <?php
        // Check if the item ID is provided
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            // Display the item details here
            $sql = "SELECT * FROM data_makanan WHERE id_menu = $id";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                // sebenernya kurang suka kalo nulis html di php, tapi yaudah lah
                echo '<p>Are you sure you want to delete this menu item?</p>';
                echo '<p><strong>Nama Menu:</strong> ' . $row['nama_menu'] . '</p>';
                echo '<p><strong>Kategori Menu:</strong> ' . $row['kategori_menu'] . '</p>';
                echo '<p><strong>Harga Menu:</strong> ' . $row['harga_menu'] . '</p>';
                echo '<form method="post" action="admin_delete.php?id=' . $id . '">';
                echo '<input type="submit" name="delete" class="btn btn-danger" value="Delete">';
                echo '</form>';
                if (isset($_POST['delete'])) {
                    $sql_delete = "DELETE FROM data_makanan WHERE id_menu = $id";
                    $result_delete = mysqli_query($conn, $sql_delete);
                    if ($result_delete) {
                        header('location: admin_dashboard.php');
                    } else {
                        echo 'Error: ' . mysqli_error($conn);
                    }
                }
                echo '<a href="admin_dashboard.php" class="btn btn-primary">Cancel</a>';
            } else {
                // ini juga gak guna
                echo '<p>Menu item not found.</p>';
            }
        } else {
            // gak guna juga tapi gpp
            echo '<p>Item ID not provided.</p>';
        }
        ?>
    </div>
</body>

</html>