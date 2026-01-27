<?php
// Add selected_bank column to orders table
require 'config/config.php';

$result = mysqli_query($conn, 'DESCRIBE orders');
$has_selected_bank = false;

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['Field'] == 'selected_bank') {
        $has_selected_bank = true;
        break;
    }
}

if (!$has_selected_bank) {
    $alter_query = "ALTER TABLE orders ADD COLUMN selected_bank VARCHAR(20) DEFAULT NULL AFTER payment_method";
    if (mysqli_query($conn, $alter_query)) {
        echo "<div style='background:#d4edda;color:#155724;padding:15px;border-radius:5px;margin:20px;'>";
        echo "<h4>✅ Kolom selected_bank berhasil ditambahkan ke tabel orders</h4>";
        echo "</div>";
    } else {
        echo "<div style='background:#f8d7da;color:#721c24;padding:15px;border-radius:5px;margin:20px;'>";
        echo "<h4>❌ Gagal menambahkan kolom selected_bank</h4>";
        echo "<p>Error: " . mysqli_error($conn) . "</p>";
        echo "</div>";
    }
} else {
    echo "<div style='background:#cce5ff;color:#004085;padding:15px;border-radius:5px;margin:20px;'>";
    echo "<h4>ℹ️ Kolom selected_bank sudah ada di tabel orders</h4>";
    echo "</div>";
}

mysqli_close($conn);
?>