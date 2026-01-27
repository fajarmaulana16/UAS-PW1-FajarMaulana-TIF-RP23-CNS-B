<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frontend Diagnostic - Toko Sepatu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .test-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .success { background-color: #d4edda; border-color: #c3e6cb; }
        .warning { background-color: #fff3cd; border-color: #ffeaa7; }
        .error { background-color: #f8d7da; border-color: #f5c6cb; }
        .test-image { max-width: 200px; height: auto; border: 1px solid #ddd; padding: 5px; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">🔍 Frontend Diagnostic Tool</h1>
        <p class="lead">Memeriksa masalah tampilan dan fungsionalitas frontend</p>

        <!-- Bootstrap Test -->
        <div class="test-section success" id="bootstrap-test">
            <h4>🎨 Bootstrap CSS Test</h4>
            <p>Jika Anda melihat tombol biru di bawah ini, Bootstrap bekerja:</p>
            <button class="btn btn-primary">Bootstrap Button Test</button>
            <div class="alert alert-success mt-2">Bootstrap Alert Test</div>
        </div>

        <!-- JavaScript Test -->
        <div class="test-section" id="js-test">
            <h4>⚡ JavaScript Test</h4>
            <p>Klik tombol di bawah untuk test JavaScript:</p>
            <button class="btn btn-secondary" onclick="testJavaScript()">Test JavaScript</button>
            <div id="js-result" class="mt-2"></div>
        </div>

        <!-- Image Loading Test -->
        <div class="test-section" id="image-test">
            <h4>🖼️ Image Loading Test</h4>
            <p>Test loading gambar dari berbagai sumber:</p>
            <div class="row">
                <div class="col-md-4">
                    <h6>Local Image Test:</h6>
                    <img src="assets/img/sample.jpg" alt="Sample Image" class="test-image" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <div style="display:none; color:red;">❌ Local image failed to load</div>
                </div>
                <div class="col-md-4">
                    <h6>External URL Test:</h6>
                    <img src="https://via.placeholder.com/200x150/cccccc/000000?text=Test+Image" alt="External Image" class="test-image" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <div style="display:none; color:red;">❌ External image failed to load</div>
                </div>
                <div class="col-md-4">
                    <h6>Base64 Test:</h6>
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==" alt="Base64 Image" class="test-image" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <div style="display:none; color:red;">❌ Base64 image failed to load</div>
                </div>
            </div>
        </div>

        <!-- AJAX Test -->
        <div class="test-section" id="ajax-test">
            <h4>🌐 AJAX Test</h4>
            <p>Test koneksi AJAX ke server:</p>
            <button class="btn btn-info" onclick="testAjax()">Test AJAX Connection</button>
            <div id="ajax-result" class="mt-2"></div>
        </div>

        <!-- Session Test -->
        <div class="test-section" id="session-test">
            <h4>🔐 Session Test</h4>
            <p>Test status session admin:</p>
            <button class="btn btn-warning" onclick="testSession()">Check Session</button>
            <div id="session-result" class="mt-2"></div>
        </div>

        <!-- Page Load Test -->
        <div class="test-section" id="page-test">
            <h4>📄 Page Load Test</h4>
            <p>Test loading halaman utama:</p>
            <div class="btn-group">
                <a href="index.php" class="btn btn-outline-primary" target="_blank">Index</a>
                <a href="home.php" class="btn btn-outline-success" target="_blank">Home</a>
                <a href="admin/products.php" class="btn btn-outline-danger" target="_blank">Products</a>
                <a href="admin/tambah_produk.php" class="btn btn-outline-info" target="_blank">Add Product</a>
            </div>
        </div>

        <!-- Browser Info -->
        <div class="test-section warning">
            <h4>🌐 Browser Information</h4>
            <div id="browser-info"></div>
        </div>

        <!-- Results Summary -->
        <div class="test-section" id="summary" style="display:none;">
            <h4>📊 Test Results Summary</h4>
            <div id="summary-content"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript Test Function
        function testJavaScript() {
            const resultDiv = document.getElementById('js-result');
            resultDiv.innerHTML = '<div class="alert alert-success">✅ JavaScript is working!</div>';
            document.getElementById('js-test').className = 'test-section success';
        }

        // AJAX Test Function
        function testAjax() {
            const resultDiv = document.getElementById('ajax-result');
            resultDiv.innerHTML = '<div class="alert alert-info">⏳ Testing AJAX...</div>';

            fetch('test_connection.php', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.text();
                } else {
                    throw new Error('Network response was not ok');
                }
            })
            .then(data => {
                resultDiv.innerHTML = '<div class="alert alert-success">✅ AJAX connection successful!</div>';
                document.getElementById('ajax-test').className = 'test-section success';
            })
            .catch(error => {
                resultDiv.innerHTML = '<div class="alert alert-danger">❌ AJAX failed: ' + error.message + '</div>';
                document.getElementById('ajax-test').className = 'test-section error';
            });
        }

        // Session Test Function
        function testSession() {
            const resultDiv = document.getElementById('session-result');
            resultDiv.innerHTML = '<div class="alert alert-info">⏳ Checking session...</div>';

            fetch('admin/products.php', {
                method: 'GET',
                headers: {
                    'Content-Type': 'text/html',
                }
            })
            .then(response => response.text())
            .then(data => {
                if (data.includes('login') || data.includes('admin')) {
                    resultDiv.innerHTML = '<div class="alert alert-success">✅ Session appears to be working</div>';
                    document.getElementById('session-test').className = 'test-section success';
                } else {
                    resultDiv.innerHTML = '<div class="alert alert-warning">⚠️ Session might not be set properly</div>';
                    document.getElementById('session-test').className = 'test-section warning';
                }
            })
            .catch(error => {
                resultDiv.innerHTML = '<div class="alert alert-danger">❌ Session check failed: ' + error.message + '</div>';
                document.getElementById('session-test').className = 'test-section error';
            });
        }

        // Browser Info
        document.addEventListener('DOMContentLoaded', function() {
            const browserInfo = document.getElementById('browser-info');
            browserInfo.innerHTML = `
                <strong>User Agent:</strong> ${navigator.userAgent}<br>
                <strong>Language:</strong> ${navigator.language}<br>
                <strong>Cookies Enabled:</strong> ${navigator.cookieEnabled ? 'Yes' : 'No'}<br>
                <strong>Online:</strong> ${navigator.onLine ? 'Yes' : 'No'}<br>
                <strong>Screen Resolution:</strong> ${screen.width}x${screen.height}
            `;
        });

        // Auto-run some tests
        document.addEventListener('DOMContentLoaded', function() {
            // Test JavaScript automatically
            testJavaScript();

            // Show summary after 2 seconds
            setTimeout(() => {
                const summary = document.getElementById('summary');
                const summaryContent = document.getElementById('summary-content');

                const tests = ['bootstrap-test', 'js-test', 'image-test', 'ajax-test', 'session-test'];
                let passed = 0;
                let failed = 0;

                tests.forEach(testId => {
                    const test = document.getElementById(testId);
                    if (test.classList.contains('success')) {
                        passed++;
                    } else if (test.classList.contains('error')) {
                        failed++;
                    }
                });

                summaryContent.innerHTML = `
                    <div class="alert alert-info">
                        <strong>Tests Passed:</strong> ${passed}<br>
                        <strong>Tests Failed:</strong> ${failed}<br>
                        <strong>Tests Pending:</strong> ${tests.length - passed - failed}
                    </div>
                    <p><em>Note: Run AJAX and Session tests manually by clicking their buttons.</em></p>
                `;

                summary.style.display = 'block';
            }, 2000);
        });
    </script>
</body>
</html>