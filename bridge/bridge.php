<?php
// jadi ketika pencet profile
// user bakal divalidasi dia itu admin atau bukan
// kalau admin, bakal diarahkan ke admin_dashboard.php
// kalau bukan admin, bakal diarahkan ke user_dashboard.php

session_start();
if (isset($_SESSION['user_login'])) {
    if ($_SESSION['role'] == 0) {
        header('location: ../admin/admin_dashboard.php');
        // exit;
    } else {
        header('location: ../user/user_dashboard.php');
        // exit;
    }
} else {
    header('location: ../loginAndRegister/login.php');
    // exit;
}
