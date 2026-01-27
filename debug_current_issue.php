<?php
// Debug: Check what's currently happening
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔍 Debug: Apa yang Muncul?</h1>";

// Check current session
echo "<h3>Session Status:</h3>";
session_start();
if (isset($_SESSION["login"])) {
    echo "<span style='color:green;'>✅ User logged in: " . ($_SESSION["username"] ?? "unknown") . "</span><br>";
    echo "Role: " . ($_SESSION["role"] ?? "unknown") . "<br><br>";
} else {
    echo "<span style='color:red;'>❌ User NOT logged in</span><br><br>";
}

// Check database
echo "<h3>Database Check:</h3>";
try {
    require 'config/config.php';
    $products = query("SELECT COUNT(*) as total FROM produk");
    if ($products) {
        echo "<span style='color:green;'>✅ Database OK - " . $products[0]['total'] . " products</span><br><br>";
    } else {
        echo "<span style='color:red;'>❌ Database query failed</span><br><br>";
    }
} catch (Exception $e) {
    echo "<span style='color:red;'>❌ Database error: " . $e->getMessage() . "</span><br><br>";
}

// Check current page
echo "<h3>Current Page Info:</h3>";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "Script Name: " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Server: " . $_SERVER['SERVER_SOFTWARE'] . "<br><br>";

// Check for common issues
echo "<h3>Common Issues Check:</h3>";
$issues = [];

if (!isset($_SESSION["login"])) {
    $issues[] = "User not logged in - redirecting to login page";
}

if (isset($_GET['hapus'])) {
    $issues[] = "Delete action detected - processing deletion";
}

if (isset($_POST['submit'])) {
    $issues[] = "Form submission detected - processing product addition";
}

if (empty($issues)) {
    echo "✅ No obvious issues detected<br><br>";
} else {
    echo "⚠️ Possible issues:<br>";
    foreach ($issues as $issue) {
        echo "- $issue<br>";
    }
    echo "<br>";
}

// Quick navigation
echo "<h3>Quick Navigation:</h3>";
echo "<a href='login.php' style='background:#6c757d;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;margin-right:10px;'>Login</a>";
echo "<a href='admin/products.php' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;margin-right:10px;'>Admin Products</a>";
echo "<a href='home.php' style='background:#28a745;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;margin-right:10px;'>Home</a>";
echo "<a href='admin/tambah_produk.php' style='background:#ffc107;color:black;padding:10px 20px;text-decoration:none;border-radius:5px;'>Add Product</a><br><br>";

// Show recent products
echo "<h3>Recent Products (Last 5):</h3>";
try {
    $recent = query("SELECT id, nama, merk, foto FROM produk ORDER BY id DESC LIMIT 5");
    if ($recent) {
        echo "<table border='1' style='border-collapse:collapse;margin:10px 0;'>";
        echo "<tr><th>ID</th><th>Name</th><th>Brand</th><th>Image</th></tr>";
        foreach ($recent as $p) {
            echo "<tr>";
            echo "<td>{$p['id']}</td>";
            echo "<td>{$p['nama']}</td>";
            echo "<td>{$p['merk']}</td>";
            echo "<td>";
            if ($p['foto']) {
                if (filter_var($p['foto'], FILTER_VALIDATE_URL)) {
                    echo "<img src='{$p['foto']}' width='50' height='50' style='border:1px solid #ccc;'> URL";
                } elseif (file_exists('assets/img/' . $p['foto'])) {
                    echo "<img src='assets/img/{$p['foto']}' width='50' height='50' style='border:1px solid #ccc;'> File";
                } else {
                    echo "❌ Image not found";
                }
            } else {
                echo "No image";
            }
            echo "</td>";
            echo "</tr>";
        }
        echo "</table><br>";
    }
} catch (Exception $e) {
    echo "<span style='color:red;'>❌ Error loading products: " . $e->getMessage() . "</span><br><br>";
}

// Instructions
echo "<div style='background:#fff3cd;border:1px solid #ffeaa7;padding:15px;border-radius:5px;margin:20px 0;'>";
echo "<h4>📋 Instructions:</h4>";
echo "<ol>";
echo "<li><strong>If you see a blank page:</strong> Check browser developer tools (F12) for errors</li>";
echo "<li><strong>If redirected to login:</strong> You need to login as admin first</li>";
echo "<li><strong>If you see 'Access Denied':</strong> Session expired, login again</li>";
echo "<li><strong>If images don't show:</strong> Check if URLs are valid or files exist</li>";
echo "<li><strong>Describe what you see:</strong> Tell me exactly what appears on your screen</li>";
echo "</ol>";
echo "</div>";
?>