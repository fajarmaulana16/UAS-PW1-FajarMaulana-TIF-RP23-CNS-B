<?php
require '../config/config.php';
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Orders_" . date('d-m-Y') . ".xls");

$orders = query("SELECT orders.*, users.username FROM orders JOIN users ON orders.user_id = users.id ORDER BY orders.created_at DESC");
?>
<table border="1">
    <tr>
        <th colspan="5">LAPORAN PESANAN TOKO SEPATU - Sneaker Hub</th>
    </tr>
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Total</th>
        <th>Status</th>
        <th>Tanggal</th>
    </tr>
    <?php $totalPendapatan = 0; foreach($orders as $o): $totalPendapatan += $o['total']; ?>
    <tr>
        <td><?= $o['id']; ?></td>
        <td><?= $o['username']; ?></td>
        <td>Rp <?= number_format($o['total']); ?></td>
        <td><?= ucfirst($o['status']); ?></td>
        <td><?= date('d-m-Y H:i', strtotime($o['created_at'])); ?></td>
    </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="2" style="text-align: right; font-weight: bold;">Total Pendapatan:</td>
        <td colspan="3" style="font-weight: bold;">Rp <?= number_format($totalPendapatan); ?></td>
    </tr>
</table>