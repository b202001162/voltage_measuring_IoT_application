<?php
session_start();
require_once "config.php"; 
if(isset($_GET['value'])){
    $value = $_GET['value'];
    $sql = "INSERT INTO `demo`(`value`) VALUES ('$value')";
    $result = mysqli_query($conn, $sql);
}
else {
    $value = 5;
    $sql = "INSERT INTO `demo`(`value`) VALUES ('$value')";
    $result = mysqli_query($conn, $sql);
}
?>