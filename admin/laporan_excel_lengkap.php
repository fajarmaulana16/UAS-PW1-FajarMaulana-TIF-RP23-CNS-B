<?php
require '../config/config.php';
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Lengkap_" . date('d-m-Y') . ".xls");

// Ambil data produk
$produk = query("SELECT * FROM produk");

// Ambil data orders
$orders = query("SELECT orders.*, users.username FROM orders JOIN users ON orders.user_id = users.id ORDER BY orders.created_at DESC");

// Hitung total
$totalPendapatan = 0;
foreach ($orders as $o) {
    $totalPendapatan += $o['total'];
}
$totalProduk = count($produk);
$totalOrders = count($orders);
?>
<table border="1">
    <tr>
        <th colspan="5">LAPORAN LENGKAP TOKO SEPATU - Sneaker Hub</th>
    </tr>
    <tr>
        <td colspan="2">Total Produk:</td>
        <td colspan="3"><?= $totalProduk; ?></td>
    </tr>
    <tr>
        <td colspan="2">Total Pesanan:</td>
        <td colspan="3"><?= $totalOrders; ?></td>
    </tr>
    <tr>
        <td colspan="2">Total Pendapatan:</td>
        <td colspan="3">Rp <?= number_format($totalPendapatan); ?></td>
    </tr>
    <tr>
        <th colspan="5">Data Produk</th>
    </tr>
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
    <tr>
        <th colspan="5">Data Pesanan</th>
    </tr>
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