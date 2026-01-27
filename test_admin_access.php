<?php
// Test Admin Access to Products Page
session_start();

// Simulate admin login
$_SESSION["login"] = true;
$_SESSION["username"] = "admin";
$_SESSION["role"] = "admin";

echo "<h1>🔐 Test Admin Access to Products</h1>";

// Check session
echo "<h3>Session Check:</h3>";
if (isset($_SESSION["login"]) && $_SESSION["role"] == "admin") {
    echo "<span style='color:green;'>✅ Admin session active</span><br>";
    echo "Username: " . $_SESSION["username"] . "<br>";
    echo "Role: " . $_SESSION["role"] . "<br><br>";
} else {
    echo "<span style='color:red;'>❌ Admin session not active</span><br><br>";
}

// Test database connection
require 'config/config.php';
echo "<h3>Database Connection:</h3>";
if ($conn) {
    echo "<span style='color:green;'>✅ Database connected</span><br><br>";
} else {
    echo "<span style='color:red;'>❌ Database connection failed</span><br><br>";
}

// Test products query
echo "<h3>Products Query Test:</h3>";
try {
    $products = query("SELECT * FROM produk");
    if ($products) {
        $count = count($products);
        echo "<span style='color:green;'>✅ Query successful: $count products found</span><br>";
        echo "<h4>Sample Products:</h4>";
        foreach (array_slice($products, 0, 3) as $product) {
            echo "- " . $product['nama'] . " (" . $product['merk'] . ") - Rp " . number_format($product['harga']) . "<br>";
        }
        echo "<br>";
    } else {
        echo "<span style='color:orange;'>⚠️ Query returned empty result</span><br><br>";
    }
} catch (Exception $e) {
    echo "<span style='color:red;'>❌ Query error: " . $e->getMessage() . "</span><br><br>";
}

// Test file paths
echo "<h3>File Path Tests:</h3>";
$admin_products_path = 'admin/products.php';
$user_home_path = 'home.php';

if (file_exists($admin_products_path)) {
    echo "<span style='color:green;'>✅ Admin products file exists: $admin_products_path</span><br>";
} else {
    echo "<span style='color:red;'>❌ Admin products file missing: $admin_products_path</span><br>";
}

if (file_exists($user_home_path)) {
    echo "<span style='color:green;'>✅ User home file exists: $user_home_path</span><br><br>";
} else {
    echo "<span style='color:red;'>❌ User home file missing: $user_home_path</span><br><br>";
}

// Quick access links
echo "<h3>Quick Access:</h3>";
echo "<a href='admin/products.php' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;margin-right:10px;'>Admin Products</a>";
echo "<a href='home.php' style='background:#28a745;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;margin-right:10px;'>User Home</a>";
echo "<a href='admin/tambah_produk.php' style='background:#ffc107;color:black;padding:10px 20px;text-decoration:none;border-radius:5px;'>Add Product</a>";
?>