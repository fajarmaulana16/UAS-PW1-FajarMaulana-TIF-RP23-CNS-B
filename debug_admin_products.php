<?php
// Debug Admin Products Page Access
session_start();

echo "<h1>🔍 Debug Admin Products Page</h1>";

// Check session status
echo "<h3>Session Status:</h3>";
if (isset($_SESSION["login"])) {
    echo "<span style='color:green;'>✅ User is logged in</span><br>";
    echo "Username: " . ($_SESSION["username"] ?? "Not set") . "<br>";
    echo "Role: " . ($_SESSION["role"] ?? "Not set") . "<br><br>";
} else {
    echo "<span style='color:red;'>❌ User is NOT logged in</span><br>";
    echo "<a href='login.php'>Please login first</a><br><br>";
}

// Check database connection
echo "<h3>Database Connection:</h3>";
try {
    require 'config/config.php';
    if ($conn) {
        echo "<span style='color:green;'>✅ Database connected</span><br><br>";
    } else {
        echo "<span style='color:red;'>❌ Database connection failed</span><br><br>";
    }
} catch (Exception $e) {
    echo "<span style='color:red;'>❌ Database error: " . $e->getMessage() . "</span><br><br>";
}

// Check products query
echo "<h3>Products Query Test:</h3>";
try {
    $sepatu = query("SELECT * FROM produk");
    if ($sepatu !== false) {
        $count = count($sepatu);
        echo "<span style='color:green;'>✅ Query successful: $count products found</span><br>";
        if ($count > 0) {
            echo "<h4>Sample Products:</h4>";
            foreach (array_slice($sepatu, 0, 3) as $product) {
                echo "- ID: {$product['id']}, Name: {$product['nama']}, Merk: {$product['merk']}<br>";
            }
        }
        echo "<br>";
    } else {
        echo "<span style='color:red;'>❌ Query failed or returned false</span><br><br>";
    }
} catch (Exception $e) {
    echo "<span style='color:red;'>❌ Query error: " . $e->getMessage() . "</span><br><br>";
}

// Check file paths
echo "<h3>File Path Check:</h3>";
$files_to_check = [
    'admin/products.php',
    'config/config.php',
    'assets/img/'
];

foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        echo "<span style='color:green;'>✅ $file exists</span><br>";
    } else {
        echo "<span style='color:red;'>❌ $file NOT found</span><br>";
    }
}
echo "<br>";

// Simulate admin login for testing
echo "<h3>Force Admin Login (for testing):</h3>";
$_SESSION["login"] = true;
$_SESSION["username"] = "admin";
$_SESSION["role"] = "admin";
echo "<span style='color:green;'>✅ Admin session set</span><br><br>";

// Test direct access to products page
echo "<h3>Test Direct Access:</h3>";
echo "<a href='admin/products.php' target='_blank' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Open Admin Products</a><br><br>";

// Check for any PHP errors
echo "<h3>PHP Error Check:</h3>";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Try to include the products page
echo "<h3>Include Test:</h3>";
try {
    ob_start();
    include 'admin/products.php';
    $output = ob_get_clean();
    if (strlen($output) > 0) {
        echo "<span style='color:green;'>✅ Page included successfully (" . strlen($output) . " characters)</span><br>";
    } else {
        echo "<span style='color:orange;'>⚠️ Page included but no output</span><br>";
    }
} catch (Exception $e) {
    echo "<span style='color:red;'>❌ Include error: " . $e->getMessage() . "</span><br>";
}
?>