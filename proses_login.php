<?php
include 'connect.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM admin WHERE username=?";
    $stmt = $connection->prepare($sql);
    
    if (!$stmt) {
        die("Prepare failed: " . $connection->error);
    }
    
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $verify_result = password_verify($password, $user['password']);

        if ($verify_result) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Password salah!'); window.location='login.php';</script>";
        }
    } else {
            echo "<script>alert('username tidak ditemukan!'); window.location='login.php';</script>";
    }
} 
?>