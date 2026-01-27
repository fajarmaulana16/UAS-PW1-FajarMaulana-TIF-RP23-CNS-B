<?php
// Test Enhanced QRIS Barcode
echo "<h1>🧪 Test Enhanced QRIS Barcode</h1>";
echo "<p>Testing QRIS barcode yang lebih realistis dengan canvas</p><hr>";

// Test QRIS display
echo "<h3>📱 QRIS Barcode Preview:</h3>";
echo "<div style='text-align:center;margin:20px 0;'>";
echo "<div class='qris-container' style='display:inline-block;padding:20px;background:white;border-radius:15px;box-shadow:0 4px 15px rgba(0,0,0,0.1);border:2px solid #28a745;'>";
echo "<canvas id='test-qris-canvas' width='200' height='200' style='border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,0.1);'></canvas>";
echo "<div class='qris-overlay' style='position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none;'>";
echo "<div class='qris-logo' style='width:40px;height:40px;background:white;border-radius:8px;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(0,0,0,0.2);'>";
echo "<div class='qris-text' style='font-size:12px;font-weight:bold;color:#28a745;'>QRIS</div>";
echo "</div>";
echo "</div>";
echo "<div class='qris-text mt-2'>";
echo "<small class='text-muted'>QRIS - Quick Response Code Indonesian Standard</small>";
echo "</div>";
echo "</div>";
echo "</div>";

echo "<div style='background:#e7f3ff;padding:20px;border-radius:10px;margin:20px 0;'>";
echo "<h4>🎨 QRIS Barcode Features:</h4>";
echo "<ul>";
echo "<li>✅ <strong>Canvas-based rendering</strong> - Lebih smooth dan crisp</li>";
echo "<li>✅ <strong>Positioner patterns</strong> - 3 squares di sudut seperti QR code asli</li>";
echo "<li>✅ <strong>Alignment pattern</strong> - Square di tengah untuk alignment</li>";
echo "<li>✅ <strong>Timing patterns</strong> - Garis horizontal dan vertikal</li>";
echo "<li>✅ <strong>Data modules</strong> - Pola data yang terstruktur</li>";
echo "<li>✅ <strong>QRIS logo overlay</strong> - Logo QRIS di tengah</li>";
echo "<li>✅ <strong>Professional styling</strong> - Border hijau dan shadow</li>";
echo "</ul>";
echo "</div>";

echo "<h3>🔗 Test Links:</h3>";
echo "<div style='display:flex;gap:10px;flex-wrap:wrap;margin:15px 0;'>";
echo "<a href='checkout.php' style='background:#007bff;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;' target='_blank'>Test Checkout QRIS</a>";
echo "<a href='test_enhanced_payment.php' style='background:#28a745;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;' target='_blank'>Payment Test</a>";
echo "<a href='home.php' style='background:#6c757d;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;' target='_blank'>Home</a>";
echo "</div>";

echo "<div style='background:#fff3cd;padding:20px;border-radius:10px;margin:20px 0;'>";
echo "<h4>📋 Technical Details:</h4>";
echo "<ul>";
echo "<li><strong>Size:</strong> 21x21 modules (standard QR code)</li>";
echo "<li><strong>Rendering:</strong> HTML5 Canvas API</li>";
echo "<li><strong>Pattern:</strong> Positioner + alignment + timing + data</li>";
echo "<li><strong>Logo:</strong> QRIS text overlay di center</li>";
echo "<li><strong>Border:</strong> Green (#28a745) to match QRIS branding</li>";
echo "</ul>";
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
    transform: translate(-50%, -50%);
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

<script>
// Generate test QRIS barcode
function generateTestQRIS() {
    const canvas = document.getElementById('test-qris-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const size = 200;
    const moduleSize = size / 21; // Standard QR code is 21x21 modules

    // Clear canvas
    ctx.fillStyle = 'white';
    ctx.fillRect(0, 0, size, size);

    // Generate QR code pattern
    for (let y = 0; y < 21; y++) {
        for (let x = 0; x < 21; x++) {
            // Positioner patterns (corners)
            let isBlack = false;

            // Top-left positioner
            if ((x <= 6 && y <= 6) || (x >= 14 && y <= 6) || (x <= 6 && y >= 14)) {
                if ((x <= 6 && y <= 6) && (x >= 2 && x <= 4 && y >= 2 && y <= 4)) {
                    isBlack = (x + y) % 2 === 0;
                } else if (x <= 6 && y <= 6) {
                    isBlack = true;
                } else if (x >= 14 && y <= 6) {
                    isBlack = (x === 18 || y === 2 || y === 3 || y === 4);
                } else if (x <= 6 && y >= 14) {
                    isBlack = (y === 18 || x === 2 || x === 3 || x === 4);
                }
            }
            // Center alignment pattern
            else if (x >= 9 && x <= 11 && y >= 9 && y <= 11) {
                isBlack = true;
            }
            // Data area - create a more realistic pattern
            else {
                // Create some structure that looks like QR data
                const dataPattern = (x * 17 + y * 23 + x * y * 7) % 29;
                isBlack = dataPattern < 14; // Roughly 50% black modules
            }

            if (isBlack) {
                ctx.fillStyle = 'black';
                ctx.fillRect(x * moduleSize, y * moduleSize, moduleSize, moduleSize);
            }
        }
    }

    // Add timing patterns
    ctx.fillStyle = 'black';
    for (let i = 8; i <= 12; i++) {
        if (i !== 10) { // Skip alignment pattern intersection
            ctx.fillRect(6 * moduleSize, i * moduleSize, moduleSize, moduleSize);
            ctx.fillRect(i * moduleSize, 6 * moduleSize, moduleSize, moduleSize);
        }
    }

    // Add some random data modules to make it look more realistic
    for (let i = 0; i < 50; i++) {
        const x = Math.floor(Math.random() * 21);
        const y = Math.floor(Math.random() * 21);

        // Don't overwrite positioner patterns
        if (!((x <= 6 && y <= 6) || (x >= 14 && y <= 6) || (x <= 6 && y >= 14) ||
              (x >= 9 && x <= 11 && y >= 9 && y <= 11))) {
            ctx.fillStyle = Math.random() > 0.5 ? 'black' : 'white';
            ctx.fillRect(x * moduleSize, y * moduleSize, moduleSize, moduleSize);
        }
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    generateTestQRIS();
});
</script>