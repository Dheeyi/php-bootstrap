<?php
session_start();

if (isset($_GET['logout']) || !isset($_SESSION['user'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("Location: login.php");
    exit;
}
