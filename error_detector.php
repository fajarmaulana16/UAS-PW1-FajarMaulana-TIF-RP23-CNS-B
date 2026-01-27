<?php
// Error Detector & Diagnostic Tool
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'error_log.txt');

echo "<h1>🔍 Error Detector & Diagnostic Tool</h1>";
echo "<p>Mendeteksi berbagai jenis error dan masalah sistem</p><hr>";

// Function to test page access
function testPageAccess($url, $name) {
    echo "<h4>Testing: $name</h4>";

    // Try to include the file
    $output = '';
    $error = '';

    ob_start();
    try {
        if (file_exists($url)) {
            include $url;
            $output = ob_get_contents();
        } else {
            $error = "File not found: $url";
        }
    } catch (Exception $e) {
        $error = "Exception: " . $e->getMessage();
    } catch (Error $e) {
        $error = "Error: " . $e->getMessage();
    }
    ob_end_clean();

    if ($error) {
        echo "<span style='color:red;'>❌ $error</span><br>";
    } else {
        $length = strlen($output);
        if ($length > 0) {
            echo "<span style='color:green;'>✅ Page loaded successfully ($length characters)</span><br>";
            // Show first 200 chars
            $preview = substr($output, 0, 200);
            echo "<div style='background:#f8f9fa;padding:10px;border-radius:3px;margin:5px 0;font-family:monospace;font-size:12px;'>Preview: " . htmlspecialchars($preview) . "...</div>";
        } else {
            echo "<span style='color:orange;'>⚠️ Page loaded but no output</span><br>";
        }
    }
    echo "<br>";
}

// 1. Test critical pages
echo "<h3>1. Page Access Tests</h3>";
testPageAccess('index.php', 'Index Page');
testPageAccess('login.php', 'Login Page');
testPageAccess('home.php', 'Home Page');
testPageAccess('admin/products.php', 'Admin Products');
testPageAccess('admin/tambah_produk.php', 'Add Product Page');

// 2. Test database operations
echo "<h3>2. Database Tests</h3>";
try {
    require 'config/config.php';
    echo "✅ Config loaded<br>";

    // Test basic query
    $result = mysqli_query($conn, "SELECT 1 as test");
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo "✅ Basic query works: " . $row['test'] . "<br>";
    }

    // Test products table
    $products = query("SELECT COUNT(*) as total FROM produk");
    echo "✅ Products query works: " . $products[0]['total'] . " products<br>";

} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
} catch (Error $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
}
echo "<br>";

// 3. Test session functionality
echo "<h3>3. Session Tests</h3>";
session_start();
echo "✅ Session started<br>";
echo "Session ID: " . session_id() . "<br>";

$_SESSION['test'] = 'working';
if ($_SESSION['test'] === 'working') {
    echo "✅ Session read/write works<br>";
} else {
    echo "❌ Session read/write failed<br>";
}
echo "<br>";

// 4. Test file operations
echo "<h3>4. File System Tests</h3>";
$test_file = 'test_write.txt';
if (file_put_contents($test_file, 'test content')) {
    echo "✅ File write works<br>";
    if (file_get_contents($test_file) === 'test content') {
        echo "✅ File read works<br>";
        unlink($test_file);
        echo "✅ File delete works<br>";
    }
} else {
    echo "❌ File operations failed<br>";
}

if (is_dir('assets/img/')) {
    echo "✅ Images directory exists<br>";
    if (is_writable('assets/img/')) {
        echo "✅ Images directory writable<br>";
    } else {
        echo "❌ Images directory not writable<br>";
    }
} else {
    echo "❌ Images directory missing<br>";
}
echo "<br>";

// 5. Check for common error patterns
echo "<h3>5. Common Error Patterns</h3>";
$errors_found = [];

if (!function_exists('mysqli_connect')) {
    $errors_found[] = "MySQLi extension not loaded";
}

if (!is_writable(session_save_path())) {
    $errors_found[] = "Session save path not writable: " . session_save_path();
}

if (ini_get('display_errors') === '0') {
    $errors_found[] = "Display errors disabled - errors might be hidden";
}

if (version_compare(PHP_VERSION, '7.0.0', '<')) {
    $errors_found[] = "PHP version too old: " . PHP_VERSION;
}

if (empty($errors_found)) {
    echo "✅ No common errors detected<br>";
} else {
    echo "❌ Found issues:<br><ul>";
    foreach ($errors_found as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul>";
}
echo "<br>";

// 6. Browser compatibility check
echo "<h3>6. Browser Info</h3>";
echo "User Agent: " . ($_SERVER['HTTP_USER_AGENT'] ?? 'Not available') . "<br>";
echo "Accept: " . ($_SERVER['HTTP_ACCEPT'] ?? 'Not available') . "<br><br>";

// 7. Performance check
echo "<h3>7. Performance</h3>";
$start_time = microtime(true);
// Simulate some operations
for ($i = 0; $i < 1000; $i++) {
    $x = $i * 2;
}
$end_time = microtime(true);
$execution_time = ($end_time - $start_time) * 1000;
echo "✅ PHP execution time: " . round($execution_time, 2) . "ms<br><br>";

// 8. Recommendations
echo "<h3>8. Recommendations</h3>";
echo "<div style='background:#e7f3ff;border:1px solid #b3d7ff;padding:15px;border-radius:5px;margin:10px 0;'>";
echo "<h4>If you see errors:</h4>";
echo "<ul>";
echo "<li><strong>Check browser console (F12)</strong> for JavaScript errors</li>";
echo "<li><strong>Check PHP error logs</strong> in XAMPP control panel</li>";
echo "<li><strong>Try different browsers</strong> (Chrome, Firefox, Edge)</li>";
echo "<li><strong>Clear browser cache</strong> and try again</li>";
echo "<li><strong>Restart XAMPP</strong> if database issues persist</li>";
echo "</ul>";
echo "</div>";

// 9. Direct links
echo "<h3>9. Direct Access Links</h3>";
echo "<div style='display:flex;gap:10px;flex-wrap:wrap;margin:10px 0;'>";
echo "<a href='index.php' style='background:#6c757d;color:white;padding:8px 16px;text-decoration:none;border-radius:3px;'>Index</a>";
echo "<a href='login.php' style='background:#007bff;color:white;padding:8px 16px;text-decoration:none;border-radius:3px;'>Login</a>";
echo "<a href='home.php' style='background:#28a745;color:white;padding:8px 16px;text-decoration:none;border-radius:3px;'>Home</a>";
echo "<a href='admin/products.php' style='background:#ffc107;color:black;padding:8px 16px;text-decoration:none;border-radius:3px;'>Products</a>";
echo "<a href='admin/tambah_produk.php' style='background:#dc3545;color:white;padding:8px 16px;text-decoration:none;border-radius:3px;'>Add Product</a>";
echo "</div><br>";

// 10. Emergency reset
echo "<h3>10. Emergency Actions</h3>";
echo "<a href='force_admin_login.php' style='background:#17a2b8;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;margin-right:10px;'>Force Admin Login</a>";
echo "<a href='test_connection.php' style='background:#28a745;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;margin-right:10px;'>Test Connection</a>";
echo "<a href='comprehensive_check.php' style='background:#ffc107;color:black;padding:10px 20px;text-decoration:none;border-radius:5px;'>Full Check</a><br><br>";

echo "<div style='background:#fff3cd;border:1px solid #ffeaa7;padding:15px;border-radius:5px;color:#856404;margin:20px 0;'>";
echo "<h4>🚨 IMPORTANT:</h4>";
echo "<p><strong>Please describe exactly what you see when you say 'muncul begitu'.</strong></p>";
echo "<ul>";
echo "<li>Do you see an error message?</li>";
echo "<li>Is the page completely blank?</li>";
echo "<li>Are you redirected somewhere?</li>";
echo "<li>Does only part of the page load?</li>";
echo "<li>Take a screenshot if possible</li>";
echo "</ul>";
echo "</div>";
?>