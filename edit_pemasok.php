<?php
include 'connect.php';
session_start();

$id = $_GET['id'];
$sql = "SELECT * FROM pemasok WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $update_nama = $_POST['pemasokU'];
    $update_alamat = $_POST['alamatU'];
    
    $sql = "UPDATE pemasok SET nama_pemasok=?, alamat_pemasok=? WHERE id=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssi", $update_nama, $update_alamat, $id);
    if ($stmt->execute()) {
        echo "<script>alert('Berhasil update data pemasok!'); window.location='pemasok.php';</script>";
    } else {
        echo "<script>alert('gagal update data pemasok!'); window.location='edit_pemasok.php';</script>";
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
                <h3>Edit data pemasok </h3>
                <hr />
                <form method="post">
                    <div class="form-group mb-2">
                        <label for="exampleInputNominal1">Nama pemasok:</label>
                        <input type="text" class="form-control" name="pemasokU" id="exampleInputPemasok1" value="<?= $data['nama_pemasok']; ?>">
                    </div>
                    <div class="form-group mb-2">
                        <label for="exampleInputNominal1">alamat pemasok:</label>
                        <input type="text" class="form-control" name="alamatU" id="exampleInputAlamat1" value="<?= $data['alamat_pemasok']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Konfirmasi</button>
                    <a href="pemasok.php" class="btn btn-outline-primary btn-sm w-100 mt-3">
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