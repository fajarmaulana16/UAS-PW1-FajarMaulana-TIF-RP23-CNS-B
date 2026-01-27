<?php
session_start();

// Test database connection
echo "<h1>🔍 Database & Session Test</h1>";

require 'config/config.php';

echo "<h3>Database Connection:</h3>";
if ($conn) {
    echo "<span style='color:green;'>✅ Connected to MySQL</span><br>";
    echo "Host: localhost<br>";
    echo "Database: toko_sepatu<br><br>";
} else {
    echo "<span style='color:red;'>❌ Cannot connect to database</span><br>";
}

// Test session
echo "<h3>Session Test:</h3>";
if (isset($_SESSION["login"])) {
    echo "<span style='color:green;'>✅ User logged in: " . $_SESSION["username"] . "</span><br>";
    echo "Role: " . $_SESSION["role"] . "<br><br>";
} else {
    echo "<span style='color:orange;'>⚠️ No active session</span><br>";
    echo "<a href='login.php'>Login first</a><br><br>";
}

// Test products query
echo "<h3>Products Query Test:</h3>";
try {
    $result = query("SELECT COUNT(*) as total FROM produk");
    if ($result) {
        $count = $result[0]['total'];
        echo "<span style='color:green;'>✅ Query successful: $count products found</span><br><br>";
    } else {
        echo "<span style='color:red;'>❌ Query failed</span><br><br>";
    }
} catch (Exception $e) {
    echo "<span style='color:red;'>❌ Error: " . $e->getMessage() . "</span><br><br>";
}

// Test file permissions
echo "<h3>File Permissions:</h3>";
$img_dir = 'assets/img/';
if (is_dir($img_dir)) {
    echo "<span style='color:green;'>✅ Image directory exists</span><br>";
    if (is_writable($img_dir)) {
        echo "<span style='color:green;'>✅ Image directory is writable</span><br><br>";
    } else {
        echo "<span style='color:red;'>❌ Image directory is not writable</span><br><br>";
    }
} else {
    echo "<span style='color:red;'>❌ Image directory does not exist</span><br><br>";
}

// Quick links
echo "<h3>Quick Links:</h3>";
echo "<a href='login.php' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;margin-right:10px;'>Login</a>";
echo "<a href='admin/products.php' style='background:#28a745;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;margin-right:10px;'>Admin Products</a>";
echo "<a href='home.php' style='background:#6c757d;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Home</a>";
?>