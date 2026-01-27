<?php
// Add payment_method column to orders table
require 'config/config.php';

$result = mysqli_query($conn, 'DESCRIBE orders');
$has_payment_method = false;

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['Field'] == 'payment_method') {
        $has_payment_method = true;
        break;
    }
}

if (!$has_payment_method) {
    $alter_query = "ALTER TABLE orders ADD COLUMN payment_method VARCHAR(50) DEFAULT 'bank' AFTER total";
    if (mysqli_query($conn, $alter_query)) {
        echo "<div style='background:#d4edda;color:#155724;padding:15px;border-radius:5px;margin:20px;'>";
        echo "<h4>✅ Kolom payment_method berhasil ditambahkan ke tabel orders</h4>";
        echo "</div>";
    } else {
        echo "<div style='background:#f8d7da;color:#721c24;padding:15px;border-radius:5px;margin:20px;'>";
        echo "<h4>❌ Gagal menambahkan kolom payment_method</h4>";
        echo "<p>Error: " . mysqli_error($conn) . "</p>";
        echo "</div>";
    }
} else {
    echo "<div style='background:#cce5ff;color:#004085;padding:15px;border-radius:5px;margin:20px;'>";
    echo "<h4>ℹ️ Kolom payment_method sudah ada di tabel orders</h4>";
    echo "</div>";
}

mysqli_close($conn);
?>