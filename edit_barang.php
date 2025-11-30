<?php
include 'connect.php';
session_start();


if (!isset($_SESSION['username'])) {
    header('location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: daftar_barang.php');
    exit();
}

$id_barang = $_GET['id'];
$sql = "SELECT * FROM barang WHERE id_barang = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param('i', $id_barang);
$stmt->execute();
$result = $stmt->get_result();
$data_barang = $result->fetch_assoc();

if (!$data_barang) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='daftar_barang.php';</script>";
    exit();
}

$query_pemasok = "SELECT * FROM pemasok ORDER BY nama_pemasok ASC";
$result_pemasok = mysqli_query($connection, $query_pemasok);


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nama_barang = $_POST['nama_barang'];
    $jumlah_barang = $_POST['jumlah_barang'];
    $tanggal_diterima = $_POST['tanggal_diterima'];
    $id_pemasok = $_POST['id_pemasok'];

    $sql_update = "UPDATE barang SET nama_barang=?, jumlah_barang=?, tanggal_diterima=?, id_pemasok=? WHERE id_barang=?";

    $stmt_update = $connection->prepare($sql_update);
    $stmt_update->bind_param("sisii", $nama_barang, $jumlah_barang, $tanggal_diterima, $id_pemasok, $id_barang);

    if ($stmt_update->execute()) {
        echo "<script>alert('Berhasil update data barang!'); window.location='daftar_barang.php';</script>";
    } else {
        echo "<script>alert('Gagal update! Error: " . $stmt_update->error . "'); window.location='edit_barang.php?id=$id_barang';</script>";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .back {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            width: 100%;
            position: absolute;
            top: 0;
            bottom: 0;
        }

        .div-center {
            width: 600px;
            padding: 30px;
            background-color: #fff;
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            margin: auto;
            height: fit-content;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <div class="back">
        <div class="div-center">
            <h3 class="mb-4">Edit Data Barang</h3>
            <form method="post">

                <div class="mb-3">
                    <label class="form-label">Nama Barang:</label>
                    <input type="text" class="form-control" name="nama_barang"
                        value="<?php echo $data_barang['nama_barang']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Barang:</label>
                    <input type="number" class="form-control" name="jumlah_barang"
                        value="<?php echo $data_barang['jumlah_barang']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Diterima:</label>
                    <input type="date" class="form-control" name="tanggal_diterima"
                        value="<?php echo $data_barang['tanggal_diterima']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Pemasok:</label>
                    <select class="form-select" name="id_pemasok" required>
                        <option value="">-- Pilih Pemasok --</option>
                        <?php while ($p = mysqli_fetch_assoc($result_pemasok)) {
                            $selected = ($p['id_pemasok'] == $data_barang['id_pemasok']) ? 'selected' : '';
                            ?>
                            <option value="<?= $p['id_pemasok'] ?>" <?= $selected ?>>
                                <?= $p['nama_pemasok'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary fw-bold">Simpan Perubahan</button>
                    <a href="daftar_barang.php" class="btn btn-outline-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>