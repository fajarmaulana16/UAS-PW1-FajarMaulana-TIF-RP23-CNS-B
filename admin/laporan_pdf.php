<?php
require '../config/config.php';
$produk = query("SELECT * FROM produk");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan PDF - Stok Toko Sepatu</title>
    <style>
        @media print {
            .no-print { display: none; }
            body { font-family: Arial, sans-serif; }
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN STOK TOKO SEPATU</h2>
        <p>Sneaker Hub - Toko Sepatu Online</p>
        <p>Dicetak pada: <?= date('d-m-Y H:i:s'); ?></p>
    </div>
    <table>
        <tr>
            <th>No</th>
            <th>Nama Sepatu</th>
            <th>Merk</th>
            <th>Harga</th>
            <th>Stok</th>
        </tr>
        <?php $i = 1; $totalStok = 0; foreach($produk as $p) : $totalStok += $p['stok']; ?>
        <tr>
            <td><?= $i++; ?></td>
            <td><?= $p['nama']; ?></td>
            <td><?= $p['merk']; ?></td>
            <td>Rp <?= number_format($p['harga']); ?></td>
            <td><?= $p['stok']; ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="4" style="text-align: right; font-weight: bold;">Total Stok:</td>
            <td style="font-weight: bold;"><?= $totalStok; ?></td>
        </tr>
    </table>
    <br>
    <button class="no-print" onclick="window.print()">Cetak ke PDF</button>
</body>
</html>