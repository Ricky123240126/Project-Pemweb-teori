<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('location: login.php');
    exit();
}


$data_barang = mysqli_query($connection, "SELECT * FROM barang ORDER BY nama_barang ASC");


$data_distributor = mysqli_query($connection, "SELECT * FROM distributor ORDER BY nama_distributor ASC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tgl = $_POST['tanggal'];
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];
    $id_distributor = $_POST['id_distributor'];

    $sql = "INSERT INTO pengiriman (tanggal_pengiriman, jumlah_barang, id_barang, id_distributor) VALUES (?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    
    $stmt->bind_param('siii', $tgl, $jumlah, $id_barang, $id_distributor);

    if($stmt->execute()){
        echo "<script>alert('Pengiriman berhasil dicatat!'); window.location='pengiriman.php';</script>";
    } else {
        echo "<script>alert('Gagal! Error: " . $stmt->error . "'); window.location='tambah_pengiriman.php';</script>";
    } 
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Pengiriman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .back { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); width: 100%; position: absolute; top: 0; bottom: 0; }
        .div-center { width: 600px; padding: 20px; background-color: #fff; position: absolute; left: 0; right: 0; top: 0; bottom: 0; margin: auto; height: fit-content; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="back">
        <div class="div-center">
            <h3>Input Pengiriman Baru</h3>
            <hr />
            <form method="post">
                <div class="mb-3">
                    <label>Tanggal Pengiriman:</label>
                    <input type="date" class="form-control" name="tanggal" required>
                </div>
                
                <div class="mb-3">
                    <label>Barang yang dikirim:</label>
                    <select class="form-select" name="id_barang" required>
                        <option value="">-- Pilih Barang --</option>
                        <?php while($b = mysqli_fetch_assoc($data_barang)) { ?>
                            <option value="<?= $b['id_barang'] ?>">
                                <?= $b['nama_barang'] ?> (Stok: <?= $b['jumlah_barang'] ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Jumlah dikirim:</label>
                    <input type="number" class="form-control" name="jumlah" required>
                </div>

                <div class="mb-3">
                    <label>Tujuan Distributor:</label>
                    <select class="form-select" name="id_distributor" required>
                        <option value="">-- Pilih Distributor --</option>
                        <?php while($d = mysqli_fetch_assoc($data_distributor)) { ?>
                            <option value="<?= $d['id_distributor'] ?>">
                                <?= $d['nama_distributor'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold mt-3">Simpan Data</button>
                <a href="pengiriman.php" class="btn btn-outline-primary btn-sm w-100 mt-2">Kembali</a>
            </form>
        </div>
    </div>
</body>
</html>