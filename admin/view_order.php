<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["role"] != "admin") { header("Location: ../login.php"); exit; }
require '../config/config.php';

$order_id = $_GET["id"];
$order = query("SELECT orders.*, users.username FROM orders JOIN users ON orders.user_id = users.id WHERE orders.id = $order_id")[0];
$order_items = query("SELECT order_items.*, produk.nama FROM order_items JOIN produk ON order_items.produk_id = produk.id WHERE order_items.order_id = $order_id");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Toko Sepatu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Detail Pesanan #<?= $order['id']; ?></h2>
    <p><strong>User:</strong> <?= $order['username']; ?></p>
    <p><strong>Total:</strong> Rp <?= number_format($order['total']); ?></p>
    <p><strong>Status:</strong> <?= ucfirst($order['status']); ?></p>
    <p><strong>Tanggal:</strong> <?= date('d-m-Y H:i', strtotime($order['created_at'])); ?></p>
    <table class="table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order_items as $item): ?>
            <tr>
                <td><?= $item['nama']; ?></td>
                <td><?= $item['jumlah']; ?></td>
                <td>Rp <?= number_format($item['harga']); ?></td>
                <td>Rp <?= number_format($item['harga'] * $item['jumlah']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="orders.php" class="btn btn-secondary">Kembali</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>