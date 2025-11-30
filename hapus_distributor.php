<?php
include 'connect.php';
session_start();

$id = $_GET['id'];
$sql = "DELETE FROM distributor WHERE id_distributor = '$id'";
mysqli_query($connection,$sql);
header('location: distributor.php');
?>