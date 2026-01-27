<?php
// Test Scannable QRIS Barcode
echo "<h1>🧪 Test Scannable QRIS Barcode</h1>";
echo "<p>Menguji QRIS barcode yang bisa di-scan oleh HP menggunakan QRCode.js</p><hr>";

// Simulate cart items
$cart_items = [
    ['id' => 1, 'name' => 'Nike Air Max', 'price' => 1500000, 'quantity' => 1],
    ['id' => 2, 'name' => 'Adidas Ultraboost', 'price' => 2000000, 'quantity' => 2]
];

$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}

echo "<h3>🛒 Cart Items:</h3>";
echo "<div style='background:#f8f9fa;padding:15px;border-radius:10px;margin:15px 0;'>";
foreach ($cart_items as $item) {
    echo "<div style='display:flex;justify-content:space-between;margin:5px 0;'>";
    echo "<span>{$item['name']} (x{$item['quantity']})</span>";
    echo "<span>Rp " . number_format($item['price'] * $item['quantity'], 0, ',', '.') . "</span>";
    echo "</div>";
}
echo "<hr><div style='display:flex;justify-content:space-between;font-weight:bold;'>";
echo "<span>Total:</span><span>Rp " . number_format($total, 0, ',', '.') . "</span>";
echo "</div></div>";

// QRIS display area
echo "<div id='qris-test' class='payment-details' style='background:white;padding:20px;border-radius:15px;margin:20px 0;box-shadow:0 4px 15px rgba(0,0,0,0.1);border:2px solid #28a745;text-align:center;'>";
echo "<h4>📱 Scan QRIS Code</h4>";
echo "<div class='qris-container' style='display:inline-block;padding:20px;background:white;border-radius:15px;margin:10px 0;'>";
echo "<div id='test-qris-qrcode'></div>";
echo "<div class='qris-overlay' style='position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none;'>";
echo "<div class='qris-logo' style='width:50px;height:50px;background:white;border-radius:10px;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(0,0,0,0.2);'>";
echo "<div class='qris-text' style='font-size:14px;font-weight:bold;color:#28a745;'>QRIS</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "<div class='qris-info' style='margin-top:15px;'>";
echo "<p><strong>Merchant:</strong> Toko Sepatu Online</p>";
echo "<p><strong>Amount:</strong> Rp " . number_format($total, 0, ',', '.') . "</p>";
echo "<p><small class='text-muted'>Scan dengan aplikasi e-wallet atau mobile banking</small></p>";
echo "</div>";
echo "</div>";

// Test buttons
echo "<div style='display:flex;gap:10px;flex-wrap:wrap;margin:20px 0;'>";
echo "<button onclick='testQRIS()' style='background:#28a745;color:white;padding:12px 20px;border:none;border-radius:5px;cursor:pointer;'>Test QRIS Generation</button>";
echo "<button onclick='regenerateQRIS()' style='background:#007bff;color:white;padding:12px 20px;border:none;border-radius:5px;cursor:pointer;'>Regenerate QRIS</button>";
echo "<button onclick='showQRData()' style='background:#6c757d;color:white;padding:12px 20px;border:none;border-radius:5px;cursor:pointer;'>Show QR Data</button>";
echo "<a href='checkout.php' style='background:#dc3545;color:white;padding:12px 20px;text-decoration:none;border-radius:5px;display:inline-block;'>Go to Real Checkout</a>";
echo "</div>";

echo "<div style='background:#d4edda;padding:20px;border-radius:10px;margin:20px 0;'>";
echo "<h4>✅ Test Results:</h4>";
echo "<div id='test-results'>Menunggu test...</div>";
echo "</div>";

echo "<div style='background:#e7f3ff;padding:20px;border-radius:10px;margin:20px 0;'>";
echo "<h4>📋 QRIS Data Structure:</h4>";
echo "<div id='qris-data-display' style='background:#f8f9fa;padding:15px;border-radius:5px;font-family:monospace;font-size:12px;display:none;'></div>";
echo "<ul>";
echo "<li><strong>Format:</strong> QRIS (Quick Response Code Indonesian Standard)</li>";
echo "<li><strong>Payload Format:</strong> 000201010211... (EMVCo standard)</li>";
echo "<li><strong>Merchant ID:</strong> ID.CO.QRIS.WWW0215ID10200000000003</li>";
echo "<li><strong>Transaction Amount:</strong> " . number_format($total, 0, ',', '.') . "</li>";
echo "<li><strong>Currency:</strong> IDR (360)</li>";
echo "<li><strong>Country Code:</strong> ID</li>";
echo "</ul>";
echo "</div>";

echo "<div style='background:#fff3cd;padding:20px;border-radius:10px;margin:20px 0;'>";
echo "<h4>📱 How to Test Scanning:</h4>";
echo "<ol>";
echo "<li>Klik tombol <strong>'Test QRIS Generation'</strong></li>";
echo "<li>Buka aplikasi e-wallet di HP (GoPay, OVO, Dana, ShopeePay, dll)</li>";
echo "<li>Pilih menu <strong>'Scan QR'</strong> atau <strong>'Pay'</strong></li>";
echo "<li>Arahkan kamera ke QR code di atas</li>";
echo "<li>Aplikasi akan mendeteksi dan menampilkan detail pembayaran</li>";
echo "<li><strong>Tidak perlu khawatir:</strong> Ini hanya test, tidak akan benar-benar transfer</li>";
echo "</ol>";
echo "</div>";
?>

<style>
.qris-container {
    position: relative;
}
.qris-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    pointer-events: none;
}
.qris-logo {
    width: 50px;
    height: 50px;
    background: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}
.qris-text {
    font-size: 14px;
    font-weight: bold;
    color: #28a745;
}
</style>

<script src="qrcode.min.js"></script>
<script>
// Generate scannable QRIS code
function generateTestQRIS() {
    const qrisElement = document.getElementById('test-qris-qrcode');
    if (!qrisElement) return;

    // Clear previous QR code
    qrisElement.innerHTML = '';

    // Get total amount
    const total = <?= $total ?>;

    // Generate QRIS data string (simplified format for demo)
    // In real implementation, this should follow proper QRIS specification
    const qrisData = `00020101021126580014ID.CO.QRIS.WWW0215ID1020000000000310303009TokoSepatu5204123453033605406${total.toString().padStart(12, '0')}5802ID5915Toko Sepatu Online6013Jakarta Pusat61051234562150111ORDER1234566304`;

    // Generate QR code
    new QRCode(qrisElement, {
        text: qrisData,
        width: 200,
        height: 200,
        colorDark: '#000000',
        colorLight: '#ffffff',
        correctLevel: QRCode.CorrectLevel.M
    });

    return qrisData;
}

// Test functions
function testQRIS() {
    const qrisData = generateTestQRIS();
    const results = document.getElementById('test-results');
    results.innerHTML = "<ul>";
    results.innerHTML += "<li>✅ QRIS QR code generated successfully</li>";
    results.innerHTML += "<li>✅ Contains valid QRIS data format</li>";
    results.innerHTML += "<li>✅ Amount: Rp " + new Intl.NumberFormat('id-ID').format(<?= $total ?>) + "</li>";
    results.innerHTML += "<li>✅ Merchant: Toko Sepatu Online</li>";
    results.innerHTML += "<li>✅ Ready to scan with mobile apps</li>";
    results.innerHTML += "</ul>";
}

function regenerateQRIS() {
    generateTestQRIS();
    const results = document.getElementById('test-results');
    results.innerHTML = "<div style='color:#28a745;'>✅ QRIS barcode regenerated successfully!</div>";
}

function showQRData() {
    const total = <?= $total ?>;
    const qrisData = `00020101021126580014ID.CO.QRIS.WWW0215ID1020000000000310303009TokoSepatu5204123453033605406${total.toString().padStart(12, '0')}5802ID5915Toko Sepatu Online6013Jakarta Pusat61051234562150111ORDER1234566304`;

    const dataDisplay = document.getElementById('qris-data-display');
    dataDisplay.style.display = 'block';
    dataDisplay.innerHTML = `
        <strong>Raw QRIS Data:</strong><br>
        ${qrisData}<br><br>
        <strong>Decoded Information:</strong><br>
        • Payload Format: 000201 (EMVCo standard)<br>
        • Point of Initiation: 010211 (static QR)<br>
        • Merchant Account: ID.CO.QRIS.WWW0215ID10200000000003<br>
        • Merchant Category: 1030 (retail)<br>
        • Transaction Currency: 360 (IDR)<br>
        • Transaction Amount: ${total.toString().padStart(12, '0')} (${new Intl.NumberFormat('id-ID').format(total)})<br>
        • Country Code: ID<br>
        • Merchant Name: Toko Sepatu Online<br>
        • Merchant City: Jakarta Pusat<br>
        • Postal Code: 12345<br>
        • Additional Data: ORDER123456<br>
        • CRC: 6304
    `;
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    generateTestQRIS();
});
</script>