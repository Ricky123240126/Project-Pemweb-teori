<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT barang.*, pemasok.nama_pemasok 
        FROM barang 
        JOIN pemasok ON barang.id_pemasok = pemasok.id_pemasok";

$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql .= " WHERE barang.nama_barang LIKE '%$search%' OR pemasok.nama_pemasok LIKE '%$search%'";
}
$result = mysqli_query($connection, $sql);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Pemasok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .dropdown {
            margin-left: 700px;
        }
        body {
            background-color: linear-gradient(135deg, #667eea 0%, #764ba2 100%);

        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-info">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Pengelola inventori</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="distributor.php">Daftar Distributor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pemasok.php">Daftar Pemasok</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="barang.php">Detail Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pengiriman.php">Pengiriman</a>
                    </li>
                    <div class="dropdown">
                        <button
                            class="btn btn-link text-white text-decoration-none dropdown-toggle d-flex align-items-center"
                            data-bs-toggle="dropdown">
                            <span class="fw-medium"><?php echo htmlspecialchars($_SESSION['role']); ?></span>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2"
                            style="border-radius: 12px;">
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item py-2 text-danger" href="logout.php">
                                    <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="delete_akun.php"
                                    onclick="return confirm('Yakin mau hapus akun? Semua data akan hilang!');">
                                    <i class="bi bi-trash me-2"></i>Hapus Akun
                                </a>
                            </li>
                        </ul>
                    </div>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container p-5 my-5 border ">
        <h2>Daftar Barang</h2>

        <form action="" method="GET" class="mb-3 d-flex gap-2">
            <input type="text" name="search" class="form-control w-25" placeholder="Cari barang..."
                value="<?php echo $search; ?>">
            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="daftar_barang.php" class="btn btn-secondary">Reset</a>
        </form>

        <a href="tambah_barang.php" class="btn btn-success mb-3">+ Tambah Barang</a>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID Barang</th>
                    <th>ID Pemasok</th>
                    <th>Nama Barang</th>
                    <th>Nama Pemasok</th>
                    <th>Jumlah Barang</th>
                    <th>Tanggal Diterima</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= $row['id_barang']; ?></td>
                        <td><?= $row['id_pemasok']; ?></td>
                        <td><?= $row['nama_barang']; ?></td>
                        <td><?= $row['nama_pemasok']; ?></td>
                        <td><?= $row['jumlah_barang']; ?></td>
                        <td><?= $row['tanggal_diterima']; ?></td>
                        <td>
                            <a href="edit_barang.php?id=<?= $row['id_barang']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus_barang.php?id=<?= $row['id_barang']; ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin hapus?');">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>