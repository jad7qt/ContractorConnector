<?php
ob_start();
session_start();

if (!isset($_SESSION['UserID']) || !isset($_SESSION['Username'])) {
    header("Location: /login.php");
    exit();
}
?>