<?php
// Comprehensive Issue Checker
echo "<h1>🔧 Comprehensive Issue Checker</h1>";
echo "<p>Checking all possible issues with your Toko Sepatu system</p><hr>";

// 1. Check PHP and Server
echo "<h3>1. Server & PHP Status</h3>";
echo "✅ PHP Version: " . phpversion() . "<br>";
echo "✅ Server: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "✅ Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "✅ Current Time: " . date('Y-m-d H:i:s') . "<br><br>";

// 2. Check File System
echo "<h3>2. File System Check</h3>";
$critical_files = [
    'index.php',
    'login.php',
    'home.php',
    'config/config.php',
    'admin/products.php',
    'admin/tambah_produk.php',
    'assets/img/'
];

foreach ($critical_files as $file) {
    if (file_exists($file)) {
        $perms = substr(sprintf('%o', fileperms($file)), -4);
        echo "✅ $file exists (perms: $perms)<br>";
    } else {
        echo "❌ $file MISSING<br>";
    }
}
echo "<br>";

// 3. Check Database Connection
echo "<h3>3. Database Connection</h3>";
try {
    require 'config/config.php';
    echo "✅ Config file loaded<br>";

    $test = mysqli_query($conn, "SELECT 1");
    if ($test) {
        echo "✅ Database connection OK<br>";
    } else {
        echo "❌ Database connection FAILED<br>";
    }

    $products = query("SELECT COUNT(*) as total FROM produk");
    echo "✅ Products table accessible: " . $products[0]['total'] . " products<br><br>";

} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br><br>";
}

// 4. Check Session
echo "<h3>4. Session Status</h3>";
session_start();
if (isset($_SESSION["login"])) {
    echo "✅ User logged in as: " . ($_SESSION["username"] ?? "unknown") . "<br>";
    echo "✅ Role: " . ($_SESSION["role"] ?? "unknown") . "<br>";
} else {
    echo "⚠️ User NOT logged in<br>";
}
echo "Session ID: " . session_id() . "<br><br>";

// 5. Test Page Access
echo "<h3>5. Page Access Test</h3>";
$pages_to_test = [
    'index.php' => 'Home Page',
    'login.php' => 'Login Page',
    'home.php' => 'User Home',
    'admin/products.php' => 'Admin Products',
    'admin/tambah_produk.php' => 'Add Product'
];

foreach ($pages_to_test as $page => $name) {
    if (file_exists($page)) {
        echo "✅ $name ($page) - File exists<br>";
    } else {
        echo "❌ $name ($page) - File MISSING<br>";
    }
}
echo "<br>";

// 6. Check Recent Activity
echo "<h3>6. Recent Products</h3>";
try {
    $recent = query("SELECT id, nama, merk, harga, foto FROM produk ORDER BY id DESC LIMIT 3");
    if ($recent && count($recent) > 0) {
        echo "<table border='1' style='border-collapse:collapse;width:100%;margin:10px 0;'>";
        echo "<tr><th>ID</th><th>Name</th><th>Brand</th><th>Price</th><th>Image</th></tr>";
        foreach ($recent as $p) {
            echo "<tr>";
            echo "<td>{$p['id']}</td>";
            echo "<td>{$p['nama']}</td>";
            echo "<td>{$p['merk']}</td>";
            echo "<td>Rp " . number_format($p['harga']) . "</td>";
            echo "<td>";
            if ($p['foto']) {
                if (filter_var($p['foto'], FILTER_VALIDATE_URL)) {
                    echo "🌐 URL Image";
                } elseif (file_exists('assets/img/' . $p['foto'])) {
                    echo "📁 Local File";
                } else {
                    echo "❌ Image missing";
                }
            } else {
                echo "No image";
            }
            echo "</td>";
            echo "</tr>";
        }
        echo "</table><br>";
    } else {
        echo "⚠️ No products found in database<br><br>";
    }
} catch (Exception $e) {
    echo "❌ Error loading products: " . $e->getMessage() . "<br><br>";
}

// 7. Quick Actions
echo "<h3>7. Quick Actions</h3>";
echo "<div style='display:flex;gap:10px;flex-wrap:wrap;margin:10px 0;'>";
echo "<a href='login.php' style='background:#6c757d;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Login</a>";
echo "<a href='home.php' style='background:#28a745;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>User Home</a>";
echo "<a href='admin/products.php' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Admin Products</a>";
echo "<a href='admin/tambah_produk.php' style='background:#ffc107;color:black;padding:10px 20px;text-decoration:none;border-radius:5px;'>Add Product</a>";
echo "<a href='force_admin_login.php' style='background:#dc3545;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Force Admin Login</a>";
echo "</div><br>";

// 8. Possible Issues & Solutions
echo "<h3>8. Possible Issues & Solutions</h3>";
echo "<div style='background:#f8f9fa;border:1px solid #dee2e6;padding:15px;border-radius:5px;margin:10px 0;'>";

$issues = [
    "Blank page" => "Check browser developer tools (F12) for PHP errors",
    "Redirect to login" => "You need to login as admin first (joko/joko321)",
    "Access denied" => "Session expired, login again",
    "Images not showing" => "Check if image URLs are valid or local files exist",
    "Database error" => "Check if MySQL is running and database exists",
    "File not found" => "Some PHP files might be missing or corrupted"
];

echo "<ul>";
foreach ($issues as $issue => $solution) {
    echo "<li><strong>$issue:</strong> $solution</li>";
}
echo "</ul>";
echo "</div>";

// 9. System Health
echo "<h3>9. System Health Check</h3>";
$health_checks = [
    "PHP Working" => true,
    "Session Working" => session_status() === PHP_SESSION_ACTIVE,
    "Database Connected" => isset($conn) && $conn,
    "Files Accessible" => file_exists('config/config.php'),
    "Images Directory" => is_dir('assets/img/') && is_writable('assets/img/')
];

echo "<ul>";
foreach ($health_checks as $check => $status) {
    $icon = $status ? "✅" : "❌";
    $color = $status ? "green" : "red";
    echo "<li style='color:$color;'>$icon $check</li>";
}
echo "</ul><br>";

echo "<div style='background:#d1ecf1;border:1px solid #bee5eb;padding:15px;border-radius:5px;color:#0c5460;margin:20px 0;'>";
echo "<h4>💡 What to do next:</h4>";
echo "<ol>";
echo "<li><strong>Tell me exactly what you see</strong> - Describe the screen/error message</li>";
echo "<li><strong>Check browser console</strong> - Press F12 and look for errors</li>";
echo "<li><strong>Try different pages</strong> - Use the links above to test each page</li>";
echo "<li><strong>Login as admin</strong> - Username: joko, Password: joko321</li>";
echo "</ol>";
echo "</div>";
?>