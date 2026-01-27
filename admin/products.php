<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit;
}

require '../config/config.php';

$sepatu = query("SELECT * FROM produk");

// Logika hapus (Delete)
if (isset($_GET["hapus"])) {
    $id = $_GET["hapus"];
    mysqli_query($conn, "DELETE FROM produk WHERE id = $id");
    header("Location: products.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk - Toko Sepatu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar {
            min-height: 100vh;
            background: #212529;
            color: white;
        }
        .nav-link {
            color: rgba(255,255,255,.75);
        }
        .nav-link:hover { color: white; background: #343a40; }
        .nav-link.active { color: white; background: #0d6efd; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse p-3">
            <h4 class="text-center mb-4">Sneaker Hub</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link mb-2 rounded" href="index.php">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active mb-2 rounded" href="products.php">
                        <i class="bi bi-box-seam me-2"></i> Data Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-2 rounded" href="tambah_produk.php">
                        <i class="bi bi-plus-circle me-2"></i> Tambah Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-2 rounded" href="orders.php">
                        <i class="bi bi-receipt me-2"></i> Data Pesanan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-2 rounded" href="laporan_pdf.php" target="_blank">
                        <i class="bi bi-file-earmark-pdf me-2"></i> Laporan PDF
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-2 rounded" href="laporan_excel.php">
                        <i class="bi bi-file-earmark-excel me-2"></i> Laporan Excel
                    </a>
                </li>
                <hr>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="../logout.php">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Data Produk</h1>
                <a href="tambah_produk.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Produk
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Merk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($sepatu as $s) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td>
                                <?php if ($s['foto']): ?>
                                    <?php if (filter_var($s['foto'], FILTER_VALIDATE_URL)): ?>
                                        <!-- URL Image -->
                                        <img src="<?= $s['foto']; ?>" width="50" height="50" class="rounded" alt="Product Image">
                                    <?php elseif (file_exists('../assets/img/' . $s['foto'])): ?>
                                        <!-- Local File -->
                                        <img src="../assets/img/<?= $s['foto']; ?>" width="50" height="50" class="rounded" alt="Product Image">
                                    <?php else: ?>
                                        <span class="text-muted">No image</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted">No image</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $s["nama"]; ?></td>
                            <td><?= $s["merk"]; ?></td>
                            <td>Rp <?= number_format($s["harga"]); ?></td>
                            <td><?= $s["stok"]; ?></td>
                            <td>
                                <a href="edit.php?id=<?= $s['id']; ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="products.php?hapus=<?= $s['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php if (empty($sepatu)): ?>
            <div class="alert alert-info mt-3">
                Belum ada produk. <a href="tambah_produk.php">Tambah produk pertama</a>
            </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>