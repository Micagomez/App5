<?php
session_start();
if (isset($_SESSION) && isset($_SESSION['rol'])) {
    if ($_SESSION['rol'] != '3') {
        echo '<script type="text/javascript">';
        echo 'window.location.href="../views/login.php";';
        echo '</script>';
        exit();
    }
} else {
    echo '<script type="text/javascript">';
    echo 'window.location.href="../views/login.php";';
    echo '</script>';
    exit();
}
var_dump($_SESSION);
?>