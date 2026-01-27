<?php
require '../config/config.php';
$orders = query("SELECT orders.*, users.username FROM orders JOIN users ON orders.user_id = users.id ORDER BY orders.created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan PDF Orders</title>
    <style>
        @media print { .no-print { display: none; } }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PESANAN TOKO SEPATU</h2>
        <p>Sneaker Hub - Toko Sepatu Online</p>
        <p>Dicetak pada: <?= date('d-m-Y H:i:s'); ?></p>
    </div>
    <table>
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
    <br>
    <button class="no-print" onclick="window.print()">Cetak ke PDF</button>
</body>
</html>