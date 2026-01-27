<?php
// Test Checkout Payment Methods
echo "<h1>🧪 Test Checkout - Payment Methods</h1>";
echo "<p>Testing fitur metode pembayaran Bank Transfer dan QRIS</p><hr>";

// Connect to database
require 'config/config.php';

// Check if payment_method column exists
$result = mysqli_query($conn, 'DESCRIBE orders');
$has_payment_method = false;

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['Field'] == 'payment_method') {
        $has_payment_method = true;
        break;
    }
}

echo "<h3>📋 Database Check:</h3>";
if ($has_payment_method) {
    echo "<div style='background:#d4edda;color:#155724;padding:15px;border-radius:5px;margin:10px 0;'>";
    echo "<h4>✅ Kolom payment_method tersedia</h4>";
    echo "</div>";
} else {
    echo "<div style='background:#f8d7da;color:#721c24;padding:15px;border-radius:5px;margin:10px 0;'>";
    echo "<h4>❌ Kolom payment_method tidak ditemukan</h4>";
    echo "<p>Jalankan <code>add_payment_column.php</code> terlebih dahulu</p>";
    echo "</div>";
}

// Check if there are any orders with payment methods
$orders_with_payment = mysqli_query($conn, "SELECT id, payment_method, total FROM orders WHERE payment_method IS NOT NULL ORDER BY id DESC LIMIT 5");

echo "<h3>📦 Recent Orders with Payment Methods:</h3>";
if (mysqli_num_rows($orders_with_payment) > 0) {
    echo "<div style='background:#d1ecf1;padding:15px;border-radius:5px;margin:10px 0;'>";
    echo "<table class='table table-sm'>";
    echo "<thead><tr><th>Order ID</th><th>Payment Method</th><th>Total</th></tr></thead>";
    echo "<tbody>";
    while ($order = mysqli_fetch_assoc($orders_with_payment)) {
        $method_icon = '';
        if ($order['payment_method'] == 'bank_transfer') {
            $method_icon = '🏦';
        } elseif ($order['payment_method'] == 'qris') {
            $method_icon = '📱';
        }
        echo "<tr>";
        echo "<td>#{$order['id']}</td>";
        echo "<td>{$method_icon} " . ucfirst(str_replace('_', ' ', $order['payment_method'])) . "</td>";
        echo "<td>Rp " . number_format($order['total']) . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
    echo "</div>";
} else {
    echo "<div style='background:#fff3cd;padding:15px;border-radius:5px;margin:10px 0;'>";
    echo "<h4>ℹ️ Belum ada order dengan metode pembayaran</h4>";
    echo "<p>Silakan lakukan checkout untuk test fitur ini</p>";
    echo "</div>";
}

echo "<hr>";
echo "<h3>🔗 Test Links:</h3>";
echo "<div style='display:flex;gap:10px;flex-wrap:wrap;margin:15px 0;'>";
echo "<a href='checkout.php' style='background:#007bff;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;' target='_blank'>Test Checkout</a>";
echo "<a href='add_payment_column.php' style='background:#28a745;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;' target='_blank'>Add Payment Column</a>";
echo "<a href='home.php' style='background:#6c757d;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;' target='_blank'>Home</a>";
echo "</div>";

echo "<div style='background:#e7f3ff;padding:20px;border-radius:10px;margin:20px 0;'>";
echo "<h4>💡 Cara Testing:</h4>";
echo "<ol>";
echo "<li>Buka halaman <code>checkout.php</code></li>";
echo "<li>Isi form checkout (nama, alamat, telepon)</li>";
echo "<li>Pilih metode pembayaran: <strong>Bank Transfer</strong> atau <strong>QRIS</strong></li>";
echo "<li>Klik <strong>Konfirmasi Pesanan</strong></li>";
echo "<li>Periksa halaman receipt untuk melihat informasi pembayaran</li>";
echo "</ol>";
echo "</div>";

mysqli_close($conn);
?>