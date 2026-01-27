<?php
// Test QRIS Centering
echo "<h1>🧪 Test QRIS Centering</h1>";
echo "<p>Menguji apakah QRIS sudah terpusat di tengah kotak</p><hr>";

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
echo "<h4>📱 QRIS Centering Test</h4>";
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
echo "<p><small class='text-muted'>QR code harus terpusat di tengah kotak</small></p>";
echo "</div>";
echo "</div>";

// Test buttons
echo "<div style='display:flex;gap:10px;flex-wrap:wrap;margin:20px 0;'>";
echo "<button onclick='testQRIS()' style='background:#28a745;color:white;padding:12px 20px;border:none;border-radius:5px;cursor:pointer;'>Test QRIS Generation</button>";
echo "<button onclick='regenerateQRIS()' style='background:#007bff;color:white;padding:12px 20px;border:none;border-radius:5px;cursor:pointer;'>Regenerate QRIS</button>";
echo "<a href='checkout.php' style='background:#dc3545;color:white;padding:12px 20px;text-decoration:none;border-radius:5px;display:inline-block;'>Go to Checkout</a>";
echo "</div>";

echo "<div style='background:#d4edda;padding:20px;border-radius:10px;margin:20px 0;'>";
echo "<h4>✅ Centering Features:</h4>";
echo "<ul>";
echo "<li>✅ <strong>Flexbox centering</strong> - Container menggunakan flexbox</li>";
echo "<li>✅ <strong>Horizontal centering</strong> - justify-content: center</li>";
echo "<li>✅ <strong>Vertical centering</strong> - align-items: center</li>";
echo "<li>✅ <strong>Canvas centering</strong> - QR code canvas terpusat</li>";
echo "<li>✅ <strong>Minimum dimensions</strong> - Container memiliki ukuran minimum</li>";
echo "<li>✅ <strong>Responsive design</strong> - Tetap terpusat di semua ukuran</li>";
echo "</ul>";
echo "</div>";

echo "<div style='background:#e7f3ff;padding:20px;border-radius:10px;margin:20px 0;'>";
echo "<h4>🎨 CSS Implementation:</h4>";
echo "<pre style='background:#f8f9fa;padding:15px;border-radius:5px;overflow-x:auto;font-size:12px;'>";
echo ".qris-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    position: relative;
    border: 2px solid #28a745;
    min-width: 240px;
    min-height: 240px;
}

#qris-qrcode {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 auto;
}

#qris-qrcode canvas {
    display: block;
    margin: 0 auto;
}";
echo "</pre>";
echo "</div>";
?>

<style>
.qris-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    position: relative;
    border: 2px solid #28a745;
    min-width: 240px;
    min-height: 240px;
}
#test-qris-qrcode {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 auto;
}
#test-qris-qrcode canvas {
    display: block;
    margin: 0 auto;
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
// Generate test QRIS
function generateTestQRIS() {
    const qrisElement = document.getElementById('test-qris-qrcode');
    if (!qrisElement) return;

    // Clear previous QR code
    qrisElement.innerHTML = '';

    // Get total amount
    const total = <?= $total ?>;

    // Generate QRIS data string
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
}

// Test functions
function testQRIS() {
    generateTestQRIS();
    console.log('✅ QRIS generated and centered');
}

function regenerateQRIS() {
    generateTestQRIS();
    console.log('✅ QRIS regenerated');
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    generateTestQRIS();
});
</script>