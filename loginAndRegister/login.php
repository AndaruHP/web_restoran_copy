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

if (isset($_POST['submit_login'])) {
    require "captcha.php"; // Pastikan file captcha.php ada
    $PHPCAP = new Captcha(); // Inisialisasi objek Captcha

    $username = $_POST['username'];
    $password = $_POST['password'];
    require_once('../database/connect.php'); // Pastikan file connect.php ada

    // SQL Injection
    $sql = "SELECT * FROM access_table WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_login = $result->fetch_assoc();
    $user_id = $user_login['id'];

    if (!$user_login) {
        echo "<div class='alert alert-danger'>Username tidak ditemukan</div>";
    } else {
        // Verifikasi password
        if (password_verify($password, $user_login["password"])) {
            // Verifikasi captcha
            $captchaInput = $_POST['captcha'];
            if (!$PHPCAP->verify($captchaInput)) {
                echo "<div class='alert alert-danger'>Captcha tidak sesuai</div>";
            } else {
                // Captcha benar, set session dan arahkan ke halaman berikutnya
                $_SESSION['user_login'] = true;
                if ($user_login['role'] == 0) {
                    $_SESSION['role'] = 0;
                    $_SESSION['user_id'] = $user_id;
                    header('location: ../bridge/bridge.php');
                    exit;
                } else {
                    $_SESSION['role'] = 1;
                    $_SESSION['user_id'] = $user_id;
                    header('location: ../bridge/bridge.php');
                    exit;
                }
            }
        } else {
            echo "<div class='alert alert-danger'>Password salah</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
    <div class="container col-4">
        <div class="card">
            <div class="card-body">
                <h2 class="fw-bold">Log in</h2>
                <form action="" method="post">
                    <div class="form-outline">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username">
                    </div>
                    <div class="form-outline">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm that you're a human</label>
                    </div>
                    <div class="form-group">
                        <?php
                        include('./captcha.php');
                        $PHPCAP->prime();
                        $PHPCAP->draw();
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Complete the Captcha</label>
                    </div>
                    <div class="form-group col-4">
                        <input type="text" name="captcha" class="form-control" required>
                    </div>
                    <div class="form-btn mt-2">
                        <input type="submit" class="btn btn-primary" value="Login" name="submit_login">
                    </div>
                </form>
                <div class="mt-2">
                    <p>Not registered yet? <a href="register.php">Register</a></p>
                    <p>Back to homepage <a href="../index.php">Homepage</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
