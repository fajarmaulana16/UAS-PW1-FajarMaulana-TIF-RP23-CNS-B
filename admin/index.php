<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["role"] != "admin") { header("Location: ../login.php"); exit; }
require '../config/config.php';

// Ambil statistik
$resProduk = mysqli_query($conn, "SELECT COUNT(*) as total FROM produk");
$countP = mysqli_fetch_assoc($resProduk);

$resOrders = mysqli_query($conn, "SELECT COUNT(*) as total FROM orders");
$countO = mysqli_fetch_assoc($resOrders);

$totalPendapatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total) as total FROM orders"))['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Toko Sepatu</title>
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
                    <a class="nav-link active mb-2 rounded" href="index.php">
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
                <li class="nav-item">
                    <a class="nav-link mb-2 rounded" href="laporan_pdf_orders.php" target="_blank">
                        <i class="bi bi-file-earmark-pdf me-2"></i> Laporan PDF Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-2 rounded" href="laporan_excel_orders.php">
                        <i class="bi bi-file-earmark-excel me-2"></i> Laporan Excel Orders
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
                <h1 class="h2">Dashboard Overview</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <span class="badge bg-dark p-2">Halo, <?= $_SESSION["user"]; ?>!</span>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 bg-primary text-white">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title text-uppercase mb-1">Total Produk</h6>
                                    <h2 class="mb-0"><?= $countP['total']; ?></h2>
                                </div>
                                <i class="bi bi-bag-check fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 bg-success text-white">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title text-uppercase mb-1">Total Pesanan</h6>
                                    <h2 class="mb-0"><?= $countO['total']; ?></h2>
                                </div>
                                <i class="bi bi-receipt fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 bg-warning text-white">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title text-uppercase mb-1">Total Pendapatan</h6>
                                    <h2 class="mb-0">Rp <?= number_format($totalPendapatan); ?></h2>
                                </div>
                                <i class="bi bi-cash fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="p-5 mb-4 bg-white rounded-3 border shadow-sm">
                        <div class="container-fluid py-5">
                            <h1 class="display-5 fw-bold">Selamat Datang di Sistem Admin</h1>
                            <p class="col-md-8 fs-4">Gunakan panel navigasi di sebelah kiri untuk mengelola stok sepatu, melihat pesanan, atau mengunduh laporan dalam format PDF dan Excel.</p>
                            <a href="produk.php" class="btn btn-primary btn-lg">Kelola Produk Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>