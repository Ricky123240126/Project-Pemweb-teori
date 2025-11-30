<?php
include 'connect.php';
session_start();

// Cek Login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM pengiriman WHERE id_pengiriman = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()) {
        header('location: pengiriman.php');
    } else {
        echo "<script>alert('Gagal menghapus!'); window.location='pengiriman.php';</script>";
    }
} else {
    header('location: pengiriman.php');
}
?>