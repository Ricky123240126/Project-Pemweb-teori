<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT pengiriman.*, barang.nama_barang, distributor.nama_distributor 
        FROM pengiriman 
        JOIN barang ON pengiriman.id_barang = barang.id_barang 
        JOIN distributor ON pengiriman.id_distributor = distributor.id_distributor";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql .= " WHERE barang.nama_barang LIKE '%$search%' OR distributor.nama_distributor LIKE '%$search%'";
}

$sql .= " ORDER BY tanggal_pengiriman DESC";

$result = mysqli_query($connection, $sql);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Pengiriman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .dropdown {
            margin-left: 700px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-info mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Inventory System</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="pemasok.php">Daftar Pemasok</a></li>
                    <li class="nav-item"><a class="nav-link" href="daftar_barang.php">Detail Barang</a></li>
                    <li class="nav-item"><a class="nav-link active" href="pengiriman.php">Pengiriman</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>Data Pengiriman ke Distributor</h2>

        <form action="" method="GET" class="mb-3 d-flex gap-2 w-50">
            <input type="text" name="search" class="form-control" placeholder="Cari Barang / Distributor..."
                value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="pengiriman.php" class="btn btn-secondary">Reset</a>
        </form>

        <a href="tambah_pengiriman.php" class="btn btn-success mb-3">+ Buat Pengiriman Baru</a>

        <table class="table table-hover table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID Pengiriman</th>
                    <th>ID Barang</th>
                    <th>Nama Barang</th>
                    <th>Tanggal Kirim</th>
                    <th>Jumlah</th>
                    <th>Tujuan Distributor</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= $row['id_pengiriman']; ?></td>
                        <td><?= $row['id_barang']; ?></td>
                        <td><?= $row['nama_barang']; ?></td>
                        <td><?= $row['tanggal_pengiriman']; ?></td>
                        <td><?= $row['jumlah_pengiriman']; ?></td>
                        <td><?= $row['nama_distributor']; ?></td>
                        <td>
                            <a href="edit_pengiriman.php?id=<?= $row['id_pengiriman']; ?>"
                                class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus_pengiriman.php?id=<?= $row['id_pengiriman']; ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Batalkan pengiriman ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
                <?php if (mysqli_num_rows($result) == 0): ?>
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data pengiriman.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>