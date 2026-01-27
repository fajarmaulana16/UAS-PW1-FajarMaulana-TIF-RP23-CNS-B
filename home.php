<?php
session_start();
require 'config/config.php';
$produk = query("SELECT * FROM produk");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Sneaker Hub - Toko Sepatu Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 120px 0;
            position: relative;
            overflow: hidden;
        }
        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .hero p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }
        .btn-custom {
            background: linear-gradient(45deg, #ff6b6b, #feca57);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
        }
        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }
        .card-img-top {
            transition: transform 0.3s ease;
        }
        .card:hover .card-img-top {
            transform: scale(1.1);
        }
        .navbar {
            background: #000 !important;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .footer {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            padding: 40px 0;
        }
        .social-icons a {
            color: white;
            margin: 0 10px;
            font-size: 1.5rem;
            transition: color 0.3s ease;
        }
        .social-icons a:hover {
            color: #ff6b6b;
        }
        .product-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ff6b6b;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="bi bi-shop me-2"></i>Sneaker Hub
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </li>
                <?php if (isset($_SESSION["login"])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="#produk">Produk</a>
                </li>
                <?php if (isset($_SESSION["login"])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">
                        <i class="bi bi-cart"></i> Keranjang
                    </a>
                </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <?php if (isset($_SESSION["login"])): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        Halo, <?= $_SESSION["user"]; ?>!
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>


<section class="hero" data-aos="fade-in">
    <div class="container text-center">
        <h1 class="display-4 fw-bold" data-aos="zoom-in" data-aos-delay="200">Temukan Sepatu Impianmu</h1>
        <p class="lead" data-aos="fade-up" data-aos-delay="400">Koleksi sepatu terbaik dari berbagai merk terkemuka</p>
        <a href="#produk" class="btn btn-light btn-lg btn-custom" data-aos="fade-up" data-aos-delay="600">Lihat Koleksi</a>
    </div>
</section>

<section id="produk" class="py-5">
    <div class="container">
        <h2 class="text-center mb-5" data-aos="fade-up">Koleksi Sepatu Kami</h2>
        <div class="row">
            <?php foreach ($produk as $p) : ?>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 shadow position-relative">
                    <div class="product-badge">Hot</div>
                    <img src="<?= filter_var($p['foto'], FILTER_VALIDATE_URL) ? $p['foto'] : 'assets/img/' . $p['foto']; ?>" class="card-img-top" alt="<?= $p['nama']; ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= $p['nama']; ?></h5>
                        <p class="card-text text-muted">Merk: <?= $p['merk']; ?></p>
                        <p class="card-text fw-bold text-primary">Rp <?= number_format($p['harga']); ?></p>
                        <p class="card-text">Stok: <?= $p['stok']; ?></p>
                        <?php if (isset($_SESSION["login"])): ?>
                        <button onclick="addToCart(<?= $p['id']; ?>)" class="btn btn-primary mt-auto btn-custom">Tambah ke Keranjang</button>
                        <?php else: ?>
                        <button class="btn btn-primary mt-auto btn-custom" disabled>Login untuk Beli</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<footer class="footer">
    <div class="container text-center">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h5>Sneaker Hub</h5>
                <p>Toko sepatu online terpercaya dengan koleksi terbaik dari berbagai merk.</p>
            </div>
            <div class="col-md-4 mb-3">
                <h5>Link Cepat</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white text-decoration-none">Tentang Kami</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Kontak</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Kebijakan Privasi</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-3">
                <h5>Ikuti Kami</h5>
                <div class="social-icons">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-twitter"></i></a>
                    <a href="#"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
        </div>
        <hr class="my-4">
        <p>&copy; Fajar Maulana TIF RP23 CNS-B.
        </p>
    </div>
</footer>

</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({
    duration: 800,
    once: true
});
function addToCart(id) {
    fetch('add_to_cart.php?id=' + id)
        .then(response => response.text())
        .then(data => {
            if (data === 'success') {
                // Tampilkan alert keren
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed';
                alertDiv.style.top = '20px';
                alertDiv.style.right = '20px';
                alertDiv.style.zIndex = '9999';
                alertDiv.style.borderRadius = '10px';
                alertDiv.style.boxShadow = '0 5px 15px rgba(0,0,0,0.2)';
                alertDiv.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>Produk berhasil ditambahkan ke keranjang! <button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
                document.body.appendChild(alertDiv);
                setTimeout(() => alertDiv.remove(), 3000);
            } else {
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger alert-dismissible fade show position-fixed';
                alertDiv.style.top = '20px';
                alertDiv.style.right = '20px';
                alertDiv.style.zIndex = '9999';
                alertDiv.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i>Gagal menambah ke keranjang: ' + data + ' <button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
                document.body.appendChild(alertDiv);
                setTimeout(() => alertDiv.remove(), 3000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger alert-dismissible fade show position-fixed';
            alertDiv.style.top = '20px';
            alertDiv.style.right = '20px';
            alertDiv.style.zIndex = '9999';
            alertDiv.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i>Terjadi kesalahan jaringan. <button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
            document.body.appendChild(alertDiv);
            setTimeout(() => alertDiv.remove(), 3000);
        });
}

// Smooth scroll untuk anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
</script>
</body>
</html>