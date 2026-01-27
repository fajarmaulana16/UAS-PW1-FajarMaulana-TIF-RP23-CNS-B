<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'config/config.php';

$user_id = $_SESSION["user_id"];
$cart = query("SELECT cart.*, produk.nama, produk.harga, produk.foto FROM cart JOIN produk ON cart.produk_id = produk.id WHERE cart.user_id = $user_id");

// Update jumlah
if (isset($_POST["update"])) {
    $cart_id = $_POST["cart_id"];
    $jumlah = $_POST["jumlah"];
    mysqli_query($conn, "UPDATE cart SET jumlah = $jumlah WHERE id = $cart_id");
    header("Location: cart.php");
}

// Hapus dari cart
if (isset($_GET["hapus"])) {
    $cart_id = $_GET["hapus"];
    mysqli_query($conn, "DELETE FROM cart WHERE id = $cart_id");
    header("Location: cart.php");
}

// Hitung total
$total = 0;
foreach ($cart as $c) {
    $total += $c['harga'] * $c['jumlah'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Toko Sepatu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="home.php">
            <i class="bi bi-shop me-2"></i>Sneaker Hub
        </a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="home.php">Home</a>
            <a class="nav-link active" href="cart.php">Keranjang</a>
            <a class="nav-link" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2>Keranjang Belanja</h2>
    <?php if (empty($cart)): ?>
        <p>Keranjang kosong. <a href="home.php">Belanja sekarang</a></p>
    <?php else: ?>
    <div class="row">
        <div class="col-md-8">
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $c): ?>
                    <tr>
                        <td>
                            <img src="assets/img/<?= $c['foto']; ?>" width="50" class="me-2">
                            <?= $c['nama']; ?>
                        </td>
                        <td>Rp <?= number_format($c['harga']); ?></td>
                        <td>
                            <form action="" method="post" class="d-inline">
                                <input type="hidden" name="cart_id" value="<?= $c['id']; ?>">
                                <input type="number" name="jumlah" value="<?= $c['jumlah']; ?>" min="1" class="form-control d-inline" style="width: 80px;">
                                <button type="submit" name="update" class="btn btn-sm btn-secondary">Update</button>
                            </form>
                        </td>
                        <td>Rp <?= number_format($c['harga'] * $c['jumlah']); ?></td>
                        <td><a href="cart.php?hapus=<?= $c['id']; ?>" class="btn btn-danger btn-sm">Hapus</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>Total: Rp <?= number_format($total); ?></h5>
                    <a href="checkout.php" class="btn btn-success w-100">Checkout</a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>