<?php
require '../config/config.php';

// Ambil data produk
$produk = query("SELECT * FROM produk");

// Ambil data orders
$orders = query("SELECT orders.*, users.username FROM orders JOIN users ON orders.user_id = users.id ORDER BY orders.created_at DESC");

// Hitung total pendapatan
$totalPendapatan = 0;
foreach ($orders as $o) {
    $totalPendapatan += $o['total'];
}

// Hitung total produk
$totalProduk = count($produk);
$totalOrders = count($orders);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Lengkap - Toko Sepatu</title>
    <style>
        @media print { .no-print { display: none; } }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
        .header { text-align: center; margin-bottom: 20px; }
        .section { margin-bottom: 40px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN LENGKAP TOKO SEPATU</h2>
        <p>Sneaker Hub - Toko Sepatu Online</p>
        <p>Dicetak pada: <?= date('d-m-Y H:i:s'); ?></p>
    </div>

    <div class="section">
        <h3>Ringkasan</h3>
        <p>Total Produk: <?= $totalProduk; ?></p>
        <p>Total Pesanan: <?= $totalOrders; ?></p>
        <p>Total Pendapatan: Rp <?= number_format($totalPendapatan); ?></p>
    </div>

    <div class="section">
        <h3>Data Produk</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Merk</th>
                <th>Harga</th>
                <th>Stok</th>
            </tr>
            <?php foreach($produk as $p): ?>
            <tr>
                <td><?= $p['id']; ?></td>
                <td><?= $p['nama']; ?></td>
                <td><?= $p['merk']; ?></td>
                <td>Rp <?= number_format($p['harga']); ?></td>
                <td><?= $p['stok']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="section">
        <h3>Data Pesanan</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
            <?php foreach($orders as $o): ?>
            <tr>
                <td><?= $o['id']; ?></td>
                <td><?= $o['username']; ?></td>
                <td>Rp <?= number_format($o['total']); ?></td>
                <td><?= ucfirst($o['status']); ?></td>
                <td><?= date('d-m-Y H:i', strtotime($o['created_at'])); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <br>
    <button class="no-print" onclick="window.print()">Cetak ke PDF</button>
</body>
</html>