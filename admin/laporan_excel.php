<?php
require '../config/config.php';
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Stok_Sepatu_" . date('d-m-Y') . ".xls");

$produk = query("SELECT * FROM produk");
?>
<table border="1">
    <tr>
        <th colspan="5">LAPORAN STOK TOKO SEPATU - Sneaker Hub</th>
    </tr>
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