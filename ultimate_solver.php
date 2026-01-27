<?php
// Ultimate Problem Solver - Auto-detect and fix common issues
echo "<h1>🎯 Ultimate Problem Solver</h1>";
echo "<p>Deteksi otomatis dan perbaikan masalah umum sistem Toko Sepatu</p><hr>";

// Auto-detect issues
$issues_found = [];
$fixes_applied = [];

// 1. Check PHP errors
echo "<h3>🔍 1. PHP Error Detection</h3>";
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (ini_get('display_errors') == '1') {
    echo "✅ PHP error display enabled<br>";
} else {
    echo "⚠️ PHP error display disabled<br>";
    $issues_found[] = "PHP errors hidden";
}

// 2. Check database connection
echo "<h3>🗄️ 2. Database Connection Check</h3>";
try {
    require 'config/config.php';
    if ($conn) {
        echo "✅ Database connected<br>";
        $result = mysqli_query($conn, "SELECT 1");
        if ($result) {
            echo "✅ Database query works<br>";
        } else {
            echo "❌ Database query failed<br>";
            $issues_found[] = "Database query failed";
        }
    } else {
        echo "❌ Database connection failed<br>";
        $issues_found[] = "Database connection failed";
    }
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
    $issues_found[] = "Database exception: " . $e->getMessage();
}

// 3. Check session
echo "<h3>🔐 3. Session Check</h3>";
session_start();
if (session_status() === PHP_SESSION_ACTIVE) {
    echo "✅ Session active<br>";
    echo "Session ID: " . session_id() . "<br>";
} else {
    echo "❌ Session not active<br>";
    $issues_found[] = "Session not active";
}

// 4. Check critical files
echo "<h3>📁 4. Critical Files Check</h3>";
$critical_files = [
    'index.php',
    'login.php',
    'home.php',
    'config/config.php',
    'admin/products.php',
    'admin/tambah_produk.php'
];

foreach ($critical_files as $file) {
    if (file_exists($file)) {
        echo "✅ $file exists<br>";
    } else {
        echo "❌ $file MISSING<br>";
        $issues_found[] = "Missing file: $file";
    }
}

// 5. Check permissions
echo "<h3>🔑 5. Permissions Check</h3>";
$dirs_to_check = ['assets/', 'assets/img/', 'admin/'];

foreach ($dirs_to_check as $dir) {
    if (is_dir($dir)) {
        if (is_writable($dir)) {
            echo "✅ $dir writable<br>";
        } else {
            echo "⚠️ $dir not writable<br>";
            $issues_found[] = "Directory not writable: $dir";
        }
    } else {
        echo "❌ $dir missing<br>";
        $issues_found[] = "Missing directory: $dir";
    }
}

// 6. Auto-fix common issues
echo "<h3>🔧 6. Auto-Fix Attempts</h3>";

if (in_array("Session not active", $issues_found)) {
    session_start();
    echo "✅ Attempted to start session<br>";
    $fixes_applied[] = "Started session";
}

if (in_array("Missing directory: assets/img/", $issues_found)) {
    if (mkdir('assets/img/', 0755, true)) {
        echo "✅ Created assets/img/ directory<br>";
        $fixes_applied[] = "Created assets/img/ directory";
    } else {
        echo "❌ Failed to create assets/img/ directory<br>";
    }
}

// 7. Test admin access
echo "<h3>👤 7. Admin Access Test</h3>";
$_SESSION["login"] = true;
$_SESSION["username"] = "admin";
$_SESSION["role"] = "admin";
echo "✅ Forced admin session<br>";
$fixes_applied[] = "Set admin session";

// 8. Test products query
echo "<h3>📦 8. Products Query Test</h3>";
try {
    $products = query("SELECT COUNT(*) as total FROM produk");
    echo "✅ Products query successful: " . $products[0]['total'] . " products<br>";
} catch (Exception $e) {
    echo "❌ Products query failed: " . $e->getMessage() . "<br>";
    $issues_found[] = "Products query failed";
}

// 9. Test page includes
echo "<h3>📄 9. Page Include Test</h3>";
$test_pages = ['admin/products.php', 'admin/tambah_produk.php'];

foreach ($test_pages as $page) {
    if (file_exists($page)) {
        ob_start();
        try {
            include $page;
            $content = ob_get_clean();
            if (strlen($content) > 100) {
                echo "✅ $page includes successfully<br>";
            } else {
                echo "⚠️ $page includes but minimal content<br>";
            }
        } catch (Exception $e) {
            ob_end_clean();
            echo "❌ $page include error: " . $e->getMessage() . "<br>";
            $issues_found[] = "Include error in $page";
        }
    }
}

// 10. Summary
echo "<h3>📊 10. Summary</h3>";

if (empty($issues_found)) {
    echo "<div style='background:#d4edda;color:#155724;padding:15px;border-radius:5px;border:1px solid #c3e6cb;margin:10px 0;'>";
    echo "<h4>✅ No Critical Issues Found!</h4>";
    echo "<p>If you're still having problems, the issue might be:</p>";
    echo "<ul>";
    echo "<li>Browser cache - try Ctrl+F5 to refresh</li>";
    echo "<li>JavaScript disabled - enable JavaScript</li>";
    echo "<li>Browser compatibility - try different browser</li>";
    echo "<li>Network issues - check internet connection</li>";
    echo "</ul>";
    echo "</div>";
} else {
    echo "<div style='background:#f8d7da;color:#721c24;padding:15px;border-radius:5px;border:1px solid #f5c6cb;margin:10px 0;'>";
    echo "<h4>❌ Issues Found:</h4>";
    echo "<ul>";
    foreach ($issues_found as $issue) {
        echo "<li>$issue</li>";
    }
    echo "</ul>";
    echo "</div>";
}

if (!empty($fixes_applied)) {
    echo "<div style='background:#d1ecf1;color:#0c5460;padding:15px;border-radius:5px;border:1px solid #bee5eb;margin:10px 0;'>";
    echo "<h4>🔧 Fixes Applied:</h4>";
    echo "<ul>";
    foreach ($fixes_applied as $fix) {
        echo "<li>$fix</li>";
    }
    echo "</ul>";
    echo "</div>";
}

// 11. Direct access links
echo "<h3>🔗 11. Test Links</h3>";
echo "<div style='display:flex;gap:10px;flex-wrap:wrap;margin:15px 0;'>";
echo "<a href='index.php' style='background:#6c757d;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;'>Index</a>";
echo "<a href='login.php' style='background:#007bff;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;'>Login</a>";
echo "<a href='home.php' style='background:#28a745;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;'>Home</a>";
echo "<a href='admin/products.php' style='background:#ffc107;color:black;padding:10px 15px;text-decoration:none;border-radius:5px;'>Products</a>";
echo "<a href='admin/tambah_produk.php' style='background:#dc3545;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;'>Add Product</a>";
echo "</div>";

// 12. Emergency instructions
echo "<div style='background:#fff3cd;border:1px solid #ffeaa7;padding:20px;border-radius:10px;margin:20px 0;'>";
echo "<h3>🚨 Emergency Instructions</h3>";
echo "<p><strong>If nothing works:</strong></p>";
echo "<ol>";
echo "<li>Close your browser completely</li>";
echo "<li>Stop XAMPP (Apache & MySQL)</li>";
echo "<li>Wait 10 seconds</li>";
echo "<li>Start XAMPP again</li>";
echo "<li>Open new browser window</li>";
echo "<li>Go to: <code>http://localhost/toko_sepatu/</code></li>";
echo "</ol>";
echo "<p><strong>Still not working?</strong> Check if XAMPP is actually running (green indicators)</p>";
echo "</div>";

// 13. Debug info for developer
echo "<!-- DEBUG INFO FOR DEVELOPER\n";
echo "Issues Found: " . count($issues_found) . "\n";
echo "Fixes Applied: " . count($fixes_applied) . "\n";
echo "PHP Version: " . phpversion() . "\n";
echo "Session Status: " . (session_status() === PHP_SESSION_ACTIVE ? 'Active' : 'Inactive') . "\n";
echo "-->";
?>