<?php
// Test Enhanced Payment Methods - Bank Selection & QRIS Barcode
echo "<h1>🧪 Test Enhanced Payment Methods</h1>";
echo "<p>Testing fitur pilihan bank (7 bank) dan QRIS barcode</p><hr>";

// Connect to database
require 'config/config.php';

// Check if selected_bank column exists
$result = mysqli_query($conn, 'DESCRIBE orders');
$has_selected_bank = false;

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['Field'] == 'selected_bank') {
        $has_selected_bank = true;
        break;
    }
}

echo "<h3>📋 Database Check:</h3>";
if ($has_selected_bank) {
    echo "<div style='background:#d4edda;color:#155724;padding:15px;border-radius:5px;margin:10px 0;'>";
    echo "<h4>✅ Kolom selected_bank tersedia</h4>";
    echo "</div>";
} else {
    echo "<div style='background:#f8d7da;color:#721c24;padding:15px;border-radius:5px;margin:10px 0;'>";
    echo "<h4>❌ Kolom selected_bank tidak ditemukan</h4>";
    echo "<p>Jalankan <code>add_bank_column.php</code> terlebih dahulu</p>";
    echo "</div>";
}

// Test bank data
$bank_test_data = [
    'bca' => ['name' => 'Bank BCA', 'account' => '1234567890'],
    'mandiri' => ['name' => 'Bank Mandiri', 'account' => '8876543210'],
    'bni' => ['name' => 'Bank BNI', 'account' => '1122334455'],
    'bri' => ['name' => 'Bank BRI', 'account' => '5566778899'],
    'cimb' => ['name' => 'CIMB Niaga', 'account' => '9988776655'],
    'danamon' => ['name' => 'Danamon', 'account' => '4433221100'],
    'permata' => ['name' => 'Permata Bank', 'account' => '7788990011']
];

echo "<h3>🏦 Bank Options Available:</h3>";
echo "<div style='background:#e7f3ff;padding:15px;border-radius:5px;margin:10px 0;'>";
echo "<div class='row'>";
foreach ($bank_test_data as $code => $bank) {
    echo "<div class='col-md-6 mb-2'>";
    echo "<strong>{$bank['name']}</strong><br>";
    echo "<small>No. Rek: {$bank['account']}</small>";
    echo "</div>";
}
echo "</div>";
echo "</div>";

// Check recent orders with bank selection
$orders_with_bank = mysqli_query($conn, "SELECT id, payment_method, selected_bank, total FROM orders WHERE payment_method IS NOT NULL AND selected_bank IS NOT NULL ORDER BY id DESC LIMIT 5");

echo "<h3>📦 Recent Orders with Bank Selection:</h3>";
if (mysqli_num_rows($orders_with_bank) > 0) {
    echo "<div style='background:#d1ecf1;padding:15px;border-radius:5px;margin:10px 0;'>";
    echo "<table class='table table-sm'>";
    echo "<thead><tr><th>Order ID</th><th>Payment Method</th><th>Selected Bank</th><th>Total</th></tr></thead>";
    echo "<tbody>";
    while ($order = mysqli_fetch_assoc($orders_with_bank)) {
        $bank_name = $bank_test_data[$order['selected_bank']]['name'] ?? ucfirst($order['selected_bank']);
        echo "<tr>";
        echo "<td>#{$order['id']}</td>";
        echo "<td>{$order['payment_method']}</td>";
        echo "<td>{$bank_name}</td>";
        echo "<td>Rp " . number_format($order['total']) . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
    echo "</div>";
} else {
    echo "<div style='background:#fff3cd;padding:15px;border-radius:5px;margin:10px 0;'>";
    echo "<h4>ℹ️ Belum ada order dengan pilihan bank</h4>";
    echo "<p>Silakan lakukan checkout dengan memilih bank untuk test fitur ini</p>";
    echo "</div>";
}

echo "<hr>";
echo "<h3>🔗 Test Links:</h3>";
echo "<div style='display:flex;gap:10px;flex-wrap:wrap;margin:15px 0;'>";
echo "<a href='checkout.php' style='background:#007bff;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;' target='_blank'>Test Checkout</a>";
echo "<a href='add_bank_column.php' style='background:#28a745;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;' target='_blank'>Add Bank Column</a>";
echo "<a href='home.php' style='background:#6c757d;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;' target='_blank'>Home</a>";
echo "</div>";

echo "<div style='background:#e7f3ff;padding:20px;border-radius:10px;margin:20px 0;'>";
echo "<h4>💡 Cara Testing:</h4>";
echo "<ol>";
echo "<li>Buka halaman <code>checkout.php</code></li>";
echo "<li>Pilih metode pembayaran <strong>Bank Transfer</strong></li>";
echo "<li>Pilih salah satu dari <strong>7 bank</strong> yang tersedia</li>";
echo "<li>Lihat informasi rekening berubah sesuai bank yang dipilih</li>";
echo "<li>Atau pilih <strong>QRIS</strong> untuk melihat barcode</li>";
echo "<li>Lakukan checkout dan periksa receipt</li>";
echo "</ol>";
echo "</div>";

echo "<div style='background:#f8f9fa;padding:20px;border-radius:10px;margin:20px 0;'>";
echo "<h4>🎨 QRIS Barcode Features:</h4>";
echo "<ul>";
echo "<li>✅ Corner positioning squares (3x3)</li>";
echo "<li>✅ Center alignment square</li>";
echo "<li>✅ Random data pattern generation</li>";
echo "<li>✅ QRIS standard styling</li>";
echo "<li>✅ Responsive design</li>";
echo "</ul>";
echo "</div>";

mysqli_close($conn);
?>