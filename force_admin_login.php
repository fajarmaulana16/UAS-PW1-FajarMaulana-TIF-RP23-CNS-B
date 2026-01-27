<?php
// Force Admin Login and Test Products Access
session_start();

// Force set admin session
$_SESSION["login"] = true;
$_SESSION["username"] = "admin";
$_SESSION["role"] = "admin";

echo "<h1>🔑 Force Admin Login & Test Access</h1>";

// Verify session is set
echo "<h3>Session Verification:</h3>";
echo "Login: " . (isset($_SESSION["login"]) ? "✅ Set" : "❌ Not set") . "<br>";
echo "Username: " . ($_SESSION["username"] ?? "Not set") . "<br>";
echo "Role: " . ($_SESSION["role"] ?? "Not set") . "<br><br>";

// Test database connection
echo "<h3>Database Test:</h3>";
require 'config/config.php';
if ($conn) {
    echo "✅ Database connected<br>";
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM produk");
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo "✅ Products table accessible, total: " . $row['total'] . "<br><br>";
    }
} else {
    echo "❌ Database connection failed<br><br>";
}

// Test products query
echo "<h3>Products Query Test:</h3>";
$sepatu = query("SELECT * FROM produk");
echo "Query result: " . (is_array($sepatu) ? "✅ Array with " . count($sepatu) . " items" : "❌ Not array") . "<br><br>";

// Now try to access the products page directly
echo "<h3>Direct Page Access Test:</h3>";
echo "<p>Click below to access admin products page:</p>";
echo "<a href='admin/products.php' target='_blank' style='background:#007bff;color:white;padding:15px 30px;text-decoration:none;border-radius:5px;font-size:16px;'>🚀 Open Admin Products Page</a><br><br>";

// Alternative: Show products directly here
echo "<h3>Products Display Test:</h3>";
if (is_array($sepatu) && count($sepatu) > 0) {
    echo "<table border='1' style='border-collapse:collapse;width:100%;'>";
    echo "<tr><th>ID</th><th>Nama</th><th>Merk</th><th>Harga</th><th>Stok</th><th>Foto</th></tr>";
    foreach ($sepatu as $s) {
        echo "<tr>";
        echo "<td>{$s['id']}</td>";
        echo "<td>{$s['nama']}</td>";
        echo "<td>{$s['merk']}</td>";
        echo "<td>Rp " . number_format($s['harga']) . "</td>";
        echo "<td>{$s['stok']}</td>";
        echo "<td>{$s['foto']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "❌ No products found or query failed<br>";
}

// Check if session persists
echo "<h3>Session Persistence Test:</h3>";
echo "<a href='check_session.php' target='_blank'>Check if session persists on new page</a>";
?>