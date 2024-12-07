<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$auth_role = $_SESSION['role'];
$auth_username = $_SESSION['username'];
?>
