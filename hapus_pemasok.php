<?php
include 'connect.php';
session_start();

$id = $_GET['id'];
$sql = "DELETE FROM pemasok WHERE id_pemasok = '$id'";
mysqli_query($connection,$sql);
header('location: pemasok.php');
?>