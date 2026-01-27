<?php
// Test QRCode.js Library
echo "<h1>🧪 Test QRCode.js Library</h1>";
echo "<p>Menguji apakah QRCode.js library berfungsi dengan benar</p><hr>";
?>

<div style="text-align: center; margin: 20px;">
    <h3>Test QR Code Generation:</h3>
    <div id="test-qrcode" style="display: inline-block; margin: 20px; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);"></div>
</div>

<div style="background: #e7f3ff; padding: 20px; border-radius: 10px; margin: 20px 0;">
    <h4>📋 Test Data:</h4>
    <p><strong>Text:</strong> "Hello QRIS World!"</p>
    <p><strong>Size:</strong> 200x200 pixels</p>
    <p><strong>Error Correction:</strong> Medium (M)</p>
</div>

<script src="qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Testing QRCode.js...');

    try {
        // Test QR code generation
        new QRCode(document.getElementById('test-qrcode'), {
            text: 'Hello QRIS World!',
            width: 200,
            height: 200,
            colorDark: '#000000',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.M
        });

        console.log('✅ QRCode generation successful');
    } catch (error) {
        console.error('❌ QRCode generation failed:', error);
        document.getElementById('test-qrcode').innerHTML = '<p style="color: red;">Error: ' + error.message + '</p>';
    }
});
</script>