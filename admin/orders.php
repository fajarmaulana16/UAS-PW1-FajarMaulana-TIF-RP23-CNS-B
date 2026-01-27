<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["role"] != "admin") { header("Location: ../login.php"); exit; }
require '../config/config.php';

$orders = query("SELECT orders.*, users.username FROM orders JOIN users ON orders.user_id = users.id ORDER BY orders.created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pesanan - Toko Sepatu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #212529; color: white; }
        .nav-link { color: rgba(255,255,255,.75); }
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
                    <a class="nav-link mb-2 rounded" href="produk.php">
                        <i class="bi bi-box-seam me-2"></i> Data Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-2 rounded" href="tambah_produk.php">
                        <i class="bi bi-plus-circle me-2"></i> Tambah Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active mb-2 rounded" href="orders.php">
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
                <li class="nav-item">
                    <a class="nav-link mb-2 rounded" href="laporan_pdf_lengkap.php" target="_blank">
                        <i class="bi bi-file-earmark-pdf me-2"></i> Laporan PDF Lengkap
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-2 rounded" href="laporan_excel_lengkap.php">
                        <i class="bi bi-file-earmark-excel me-2"></i> Laporan Excel Lengkap
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
                <h1 class="h2">Data Pesanan</h1>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $o): ?>
                        <tr>
                            <td><?= $o['id']; ?></td>
                            <td><?= $o['username']; ?></td>
                            <td>Rp <?= number_format($o['total']); ?></td>
                            <td>
                                <span class="badge bg-<?= $o['status'] == 'completed' ? 'success' : 'warning'; ?>">
                                    <?= ucfirst($o['status']); ?>
                                </span>
                            </td>
                            <td><?= date('d-m-Y H:i', strtotime($o['created_at'])); ?></td>
                            <td>
                                <a href="view_order.php?id=<?= $o['id']; ?>" class="btn btn-info btn-sm">Detail</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>