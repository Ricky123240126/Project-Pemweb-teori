<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $username = trim($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role = 'admin'; 

    $cek_sql = "SELECT * FROM admin WHERE username = ?";
    $cek_stmt = $connection->prepare($cek_sql);
    $cek_stmt->bind_param("s", $username);
    $cek_stmt->execute();
    $cek_result = $cek_stmt->get_result();
    
    if ($cek_result->num_rows > 0) {
        echo "<script>alert('Username telah digunakan! Gunakan username lain'); window.location='register.php';</script>";
    } else {
        // Insert dengan prepared statement
        $insert_sql = "INSERT INTO admin (nama, username, password, role) VALUES (?, ?, ?, ?)";
        $insert_stmt = $connection->prepare($insert_sql);
        $insert_stmt->bind_param("ssss", $nama, $username, $password, $role);
        
        if ($insert_stmt->execute()) {
            echo "<script>alert('Register berhasil!'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Register gagal: " . $connection->error . "'); window.location='register.php';</script>";
        }
        $insert_stmt->close();
    }
    $cek_stmt->close();
}