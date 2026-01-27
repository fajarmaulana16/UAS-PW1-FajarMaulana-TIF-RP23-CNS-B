<?php
// Simple Admin Products Test Page
session_start();

// Force admin session for testing
$_SESSION["login"] = true;
$_SESSION["username"] = "admin";
$_SESSION["role"] = "admin";

echo "<h1>🧪 Simple Admin Products Test</h1>";

// Check session
if (!isset($_SESSION["login"]) || $_SESSION["role"] != "admin") {
    echo "<span style='color:red;'>❌ Access denied - not admin</span><br>";
    echo "<a href='../login.php'>Login</a><br><br>";
    exit;
}

echo "<span style='color:green;'>✅ Admin access granted</span><br><br>";

// Database connection
require '../config/config.php';
echo "<span style='color:green;'>✅ Config loaded</span><br>";

// Query products
$sepatu = query("SELECT * FROM produk");
echo "<span style='color:green;'>✅ Query executed</span><br>";
echo "Found " . count($sepatu) . " products<br><br>";

// Display products
if (count($sepatu) > 0) {
    echo "<h3>Products List:</h3>";
    echo "<table border='1' style='border-collapse:collapse;'>";
    echo "<tr><th>ID</th><th>Nama</th><th>Merk</th><th>Harga</th><th>Stok</th></tr>";

    foreach ($sepatu as $s) {
        echo "<tr>";
        echo "<td>{$s['id']}</td>";
        echo "<td>{$s['nama']}</td>";
        echo "<td>{$s['merk']}</td>";
        echo "<td>Rp " . number_format($s['harga']) . "</td>";
        echo "<td>{$s['stok']}</td>";
        echo "</tr>";
    }
    echo "</table><br>";
} else {
    echo "<span style='color:orange;'>⚠️ No products found</span><br><br>";
}

// Links
echo "<h3>Navigation:</h3>";
echo "<a href='../home.php' style='background:#28a745;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;margin-right:10px;'>Home</a>";
echo "<a href='tambah_produk.php' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;margin-right:10px;'>Add Product</a>";
echo "<a href='../logout.php' style='background:#dc3545;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Logout</a><br><br>";

// Test original page
echo "<h3>Test Original Page:</h3>";
echo "<a href='products.php' style='background:#ffc107;color:black;padding:10px 20px;text-decoration:none;border-radius:5px;'>Open Real Products Page</a>";
?>