<?php
// Debug QRIS Implementation
echo "<h1>🔍 Debug QRIS Implementation</h1>";
echo "<p>Debugging QRIS barcode generation dan JavaScript errors</p><hr>";

// Test PHP variables
$total = 150000; // Test total
echo "<h3>📊 PHP Variables Test:</h3>";
echo "<div style='background:#f8f9fa;padding:15px;border-radius:5px;margin:10px 0;'>";
echo "<p><strong>Total Amount:</strong> Rp " . number_format($total, 0, ',', '.') . "</p>";
echo "<p><strong>Total for JS:</strong> <span id='js-total'>Loading...</span></p>";
echo "</div>";

// Test QRIS data generation
echo "<h3>📋 QRIS Data Generation Test:</h3>";
echo "<div style='background:#e7f3ff;padding:15px;border-radius:5px;margin:10px 0;'>";
$qrisData = `00020101021126580014ID.CO.QRIS.WWW0215ID1020000000000310303009TokoSepatu5204123453033605406${str_pad($total, 12, '0', STR_PAD_LEFT)}5802ID5915Toko Sepatu Online6013Jakarta Pusat61051234562150111ORDER1234566304`;
echo "<p><strong>Raw QRIS Data:</strong></p>";
echo "<code style='word-break: break-all; background: white; padding: 10px; border-radius: 5px; display: block; margin: 10px 0;'>{$qrisData}</code>";
echo "</div>";

// Test QR code container
echo "<h3>🎨 QR Code Container Test:</h3>";
echo "<div style='text-align: center; margin: 20px 0;'>";
echo "<div id='debug-qris-container' style='display: inline-block; padding: 20px; background: white; border: 2px solid #28a745; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);'>";
echo "<div id='debug-qris-qrcode'></div>";
echo "<div class='qris-overlay' style='position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none;'>";
echo "<div class='qris-logo' style='width:40px;height:40px;background:white;border-radius:8px;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(0,0,0,0.2);'>";
echo "<div class='qris-text' style='font-size:12px;font-weight:bold;color:#28a745;'>QRIS</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";

// Console log area
echo "<h3>📝 Console Logs:</h3>";
echo "<div id='console-logs' style='background:#f8f9fa;padding:15px;border-radius:5px;margin:10px 0;max-height:200px;overflow-y:auto;font-family:monospace;font-size:12px;'></div>";

// Test buttons
echo "<div style='display:flex;gap:10px;flex-wrap:wrap;margin:20px 0;'>";
echo "<button onclick='testQRISGeneration()' style='background:#28a745;color:white;padding:12px 20px;border:none;border-radius:5px;cursor:pointer;'>Test QRIS Generation</button>";
echo "<button onclick='clearLogs()' style='background:#6c757d;color:white;padding:12px 20px;border:none;border-radius:5px;cursor:pointer;'>Clear Logs</button>";
echo "<button onclick='checkJSLibrary()' style='background:#007bff;color:white;padding:12px 20px;border:none;border-radius:5px;cursor:pointer;'>Check JS Library</button>";
echo "<a href='checkout.php' style='background:#dc3545;color:white;padding:12px 20px;text-decoration:none;border-radius:5px;display:inline-block;'>Go to Checkout</a>";
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
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}
.qris-text {
    font-size: 12px;
    font-weight: bold;
    color: #28a745;
}
</style>

<script src="qrcode.min.js"></script>
<script>
// Custom console.log to display in page
const originalLog = console.log;
const originalError = console.error;
const logsElement = document.getElementById('console-logs');

function addLog(message, type = 'log') {
    const timestamp = new Date().toLocaleTimeString();
    const logEntry = document.createElement('div');
    logEntry.style.color = type === 'error' ? '#dc3545' : type === 'success' ? '#28a745' : '#000';
    logEntry.innerHTML = `[${timestamp}] ${message}`;
    logsElement.appendChild(logEntry);
    logsElement.scrollTop = logsElement.scrollHeight;
}

console.log = function(...args) {
    originalLog.apply(console, args);
    addLog(args.join(' '), 'log');
};

console.error = function(...args) {
    originalError.apply(console, args);
    addLog(args.join(' '), 'error');
};

// Test functions
function testQRISGeneration() {
    console.log('🧪 Starting QRIS generation test...');

    try {
        // Clear previous QR code
        document.getElementById('debug-qris-qrcode').innerHTML = '';

        // Get total amount
        const total = <?= $total ?>;
        document.getElementById('js-total').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);

        console.log('✅ Total amount:', total);

        // Generate QRIS data string
        const qrisData = `00020101021126580014ID.CO.QRIS.WWW0215ID1020000000000310303009TokoSepatu5204123453033605406${total.toString().padStart(12, '0')}5802ID5915Toko Sepatu Online6013Jakarta Pusat61051234562150111ORDER1234566304`;

        console.log('✅ QRIS data generated:', qrisData.substring(0, 50) + '...');

        // Generate QR code
        new QRCode(document.getElementById('debug-qris-qrcode'), {
            text: qrisData,
            width: 200,
            height: 200,
            colorDark: '#000000',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.M
        });

        console.log('✅ QR code generated successfully');

    } catch (error) {
        console.error('❌ QRIS generation failed:', error.message);
    }
}

function clearLogs() {
    logsElement.innerHTML = '';
}

function checkJSLibrary() {
    console.log('🔍 Checking QRCode.js library...');

    if (typeof QRCode !== 'undefined') {
        console.log('✅ QRCode library loaded successfully');
        console.log('✅ QRCode version info:', QRCode);
    } else {
        console.error('❌ QRCode library not found');
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Debug page loaded');
    checkJSLibrary();
});
</script>