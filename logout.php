<?php 
session_start();

$user = $_GET['user'];
if ($user === "user") {
    unset($_SESSION['user_name'], $_SESSION['user_time_stamp'], $_SESSION['user_loggedin']);
    header("Location: ./usrLogIn.php"); //redirect to index.php
}
if($user === "admin"){
    unset($_SESSION['admin_name'], $_SESSION['admin_time_stamp'], $_SESSION['admin_loggedin']);
    header("Location: ./admin/login.php"); //redirect to index.php
}
exit;
?>