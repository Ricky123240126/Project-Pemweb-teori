<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $barang = $_POST['barang'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];
    $pemasok = $_POST['pemasok'];

    $sql = "INSERT INTO pemasok (nama_barang, jumlah_barang, tanggal_diterima, nama_pemasok VALUES (?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('sids', $barang, $jumlah, $tanggal, $pemasok);

    if($stmt->execute()){
        echo "<script>alert('Berhasil menambah data barang!'); window.location='daftar_barang.php';</script>";
    } else {
        echo "<script>alert('Gagal menambah data barang!'); window.location='tambah_barang.php';</script>";
        
    } 
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>tambah pemasok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        .back {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            width: 100%;
            position: absolute;
            top: 0;
            bottom: 0;
        }

        .div-center {
            width: 800px;
            height: 400px;
            background-color: #fff;
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            margin: auto;
            max-width: 100%;
            max-height: 100%;
            overflow: auto;
            padding: 1em 2em;
            border-bottom: 2px solid #ccc;
            display: table;
        }

        div.content {
            display: table-cell;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="back">
        <div class="div-center">
            <div class="content">
                <h3>Input data Barang</h3>
                <hr />
                <form method="post">
                    <div class="form-group mb-2">
                        <label for="exampleInputBarang1">Nama Barang:</label>
                        <input type="text" class="form-control" name="barang" id="exampleInputBarang1">
                    </div>
                    <div class="form-group mb-2">
                        <label for="exampleInputJumlah1">Jumlah Barang:</label>
                        <input type="number" class="form-control" name="jumlah" id="exampleInputJumlah1">
                    </div>
                    <div class="form-group mb-2">
                        <label for="exampleInputPemasok1">Tanggal diterima:</label>
                        <input type="date" class="form-control" name="tanggal" id="exampleInputTanggal1">
                    </div>
                    <div class="form-group mb-2">
                        <label for="exampleInputAlamat1">Nama pemasok:</label>
                        <input type="text" class="form-control" name="pemasok" id="exampleInputPemasok1">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Konfirmasi</button>
                    <a href="daftar_barang.php" class="btn btn-outline-primary btn-sm w-100 mt-3">
                        <i class="bi bi-pencil me-1"></i> kembali
                    </a>
                </form>
            </div>
            </span>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"></script>
</body>

</html>