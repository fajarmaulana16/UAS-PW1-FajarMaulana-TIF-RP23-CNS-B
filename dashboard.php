<?php
session_start();
if (!isset($_SESSION["login"])) { header("Location: login.php"); exit; }
require 'config/config.php';

// Ambil data user
$user_id = $_SESSION["user_id"];
$user = query("SELECT * FROM users WHERE id = $user_id")[0];

// Ambil pesanan user
$orders = query("SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 5");

// Hitung total pesanan
$total_orders = count(query("SELECT id FROM orders WHERE user_id = $user_id"));

// Hitung total pengeluaran
$total_spent = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total) as total FROM orders WHERE user_id = $user_id"))['total'] ?? 0;

// Ambil tanggal pesanan pertama
$first_order = mysqli_fetch_assoc(mysqli_query($conn, "SELECT MIN(created_at) as first_order FROM orders WHERE user_id = $user_id"))['first_order'] ?? date('Y-m-d');
$member_since = date('M Y', strtotime($first_order));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Toko Sepatu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
            opacity: 0.1;
            z-index: -1;
        }
        .navbar {
            background: rgba(0, 0, 0, 0.9) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 2px 20px rgba(0,0,0,0.3);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            background: linear-gradient(45deg, #ff6b6b, #feca57);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.95);
        }
        .card:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }
        .stats-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: rotate(45deg);
            transition: all 0.6s;
        }
        .stats-card:hover::before {
            animation: shimmer 1.5s ease-in-out;
        }
        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }
        .stats-card .card-body {
            position: relative;
            z-index: 2;
        }
        .table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .table thead th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            font-weight: 600;
        }
        .table tbody tr:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: scale(1.01);
            transition: all 0.2s ease;
        }
        .btn {
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        .btn:hover::before {
            left: 100%;
        }
        .btn-primary {
            background: linear-gradient(45deg, #ff6b6b, #feca57);
            border: none;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.6);
        }
        .btn-outline-primary {
            border: 2px solid #667eea;
            color: #667eea;
            background: transparent;
        }
        .btn-outline-primary:hover {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border-color: transparent;
            color: white;
        }
        .footer {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            padding: 30px 0;
            margin-top: 50px;
            position: relative;
        }
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(45deg, #ff6b6b, #feca57);
        }
        h1 {
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .badge {
            border-radius: 20px;
            padding: 5px 15px;
        }
        .card-header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border: none;
            font-weight: 600;
        }
        .alert {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            border-radius: 10px;
        }
        .dropdown-item:hover {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="home.php">
            <i class="bi bi-shop me-2"></i>Sneaker Hub
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">
                        <i class="bi bi-cart"></i> Keranjang
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        Halo, <?= $_SESSION["user"]; ?>!
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5" data-aos="fade-up">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4" data-aos="zoom-in" data-aos-delay="200">Dashboard Saya</h1>
            <p class="text-muted" data-aos="fade-up" data-aos-delay="400">Selamat datang kembali, <?= $user['username']; ?>! Berikut adalah ringkasan aktivitas Anda.</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card stats-card text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-uppercase mb-1">Total Pesanan</h6>
                            <h2 class="mb-0"><?= $total_orders; ?></h2>
                        </div>
                        <i class="bi bi-receipt fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card stats-card text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-uppercase mb-1">Total Pengeluaran</h6>
                            <h2 class="mb-0">Rp <?= number_format($total_spent); ?></h2>
                        </div>
                        <i class="bi bi-cash fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
            <div class="card stats-card text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-uppercase mb-1">Member Sejak</h6>
                            <h5 class="mb-0"><?= $member_since; ?></h5>
                        </div>
                        <i class="bi bi-calendar fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4" data-aos="fade-up" data-aos-delay="400">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Pesanan Terbaru</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($orders)): ?>
                        <div class="text-center py-5" data-aos="fade-in">
                            <i class="bi bi-cart-x fs-1 text-muted mb-3"></i>
                            <p class="text-muted fs-5">Belum ada pesanan.</p>
                            <a href="home.php" class="btn btn-primary">Mulai Belanja</a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID Pesanan</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                    <tr data-aos="fade-left" data-aos-delay="100">
                                        <td>#<?= $order['id']; ?></td>
                                        <td><?= date('d M Y', strtotime($order['created_at'])); ?></td>
                                        <td>Rp <?= number_format($order['total']); ?></td>
                                        <td>
                                            <span class="badge bg-success">Selesai</span>
                                        </td>
                                        <td>
                                            <a href="receipt.php?id=<?= $order['id']; ?>" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4" data-aos="fade-up" data-aos-delay="500">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-question-circle fs-1 text-primary mb-3"></i>
                    <h5>Butuh Bantuan?</h5>
                    <p class="text-muted">Jika Anda memiliki pertanyaan tentang pesanan atau produk, hubungi kami.</p>
                    <a href="home.php" class="btn btn-primary">Lanjut Belanja</a>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container text-center">
        <p>&copy; 2024 Sneaker Hub. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({
    duration: 800,
    once: true,
    offset: 100
});
</script>
</body>
</html></content>
<parameter name="filePath">c:\xampp\htdocs\toko_sepatu\dashboard.php