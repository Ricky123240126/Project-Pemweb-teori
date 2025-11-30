<?php
include 'connect.php';
session_start();

$id = $_GET['id'];
$sql = "DELETE FROM barang WHERE id_barang = '$id'";
mysqli_query($connection,$sql);
header('location: daftar_barang.php');
?>