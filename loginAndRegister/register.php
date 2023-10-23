<?php
session_start();
if (isset($_SESSION['user_login'])) {
    if ($_SESSION['role'] == 0) {
        header('location: ../admin/admin_dashboard.php');
        // exit;
    } else {
        header('location: ../user/user_dashboard.php');
        // exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="../index.php">Cafetarian</a>
    </div>
</nav>

<body>
    <div class="container col-4 mt-3">
        <div class="card">
            <div class="card-body">
                <?php
                // cek kalo semua data sudah masuk atau belum
                if (isset($_POST['submit_register'])) {
                    $first_name = $_POST['first_name'];
                    $last_name = $_POST['last_name'];
                    $birth_date = $_POST['birth_date'];
                    $gender_type = $_POST['gender_type'];
                    $username = $_POST['username'];
                    $passwordBefore = $_POST['password'];
                    $password = password_hash($passwordBefore, PASSWORD_DEFAULT);

                    // alert bakalan keluar kalo ada yang belum diisi atau tidak sesuai dengan format
                    $error_message = array();
                    if (empty($first_name) or empty($last_name) or empty($birth_date) or empty($gender_type) or empty($username) or empty($passwordBefore)) {
                        array_push($error_message, "Semua data harus diisi");
                    }

                    require_once('../database/connect.php');
                    // cek apakah username sudah ada atau belum
                    $sql = "SELECT * FROM access_table WHERE username = '$username'";
                    $result = mysqli_query($conn, $sql);
                    $rowCount = mysqli_num_rows($result);
                    if ($rowCount > 0) {
                        array_push($error_message, "Username sudah ada");
                    }

                    // munculin alert
                    if (count($error_message) > 0) {
                        // ini kalo ada yang error
                        foreach ($error_message as $error) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    } else {
                        $sql = "INSERT INTO access_table (first_name, last_name, gender_type, birth_date, username, password, role)
                VALUES ('$first_name', '$last_name', '$gender_type', '$birth_date', '$username', '$password', 1)";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            echo "<div class='alert alert-success'>Register berhasil</div>";
                        } else {
                            echo "<div class='alert alert-danger'>Register gagal</div>";
                        }
                    }
                }
                ?>
                <h2 class="fw-bold">Register</h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="first_name">Nama Depan</label>
                        <input type="text" class="form-control" name="first_name">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Nama Belakang</label>
                        <input type="text" class="form-control" name="last_name">
                    </div>
                    <div class="form-group">
                        <label for="gender_type">Gender</label>
                        <select name="gender_type" class="form-control">
                            <option value="m">Male</option>
                            <option value="f">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="birth_date">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="birth_date">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="form-btn mt-2">
                        <input type="submit" class="btn btn-primary" value="Register" name="submit_register">
                    </div>
                </form>
                <div class="mt-2">
                    <p>Already registered? <a href="login.php">Login</a></p>
                    <p>Back to homepage <a href="../index.php">Homepage</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>