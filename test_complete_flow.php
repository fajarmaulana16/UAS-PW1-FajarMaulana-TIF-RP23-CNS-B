<?php
// Comprehensive Test: Admin Add → User View Flow
echo "<h1>🔄 Complete Admin → User Product Flow Test</h1>";

require 'config/config.php';

// Step 1: Check current products count
echo "<h3>Step 1: Current System State</h3>";
$current_products = query("SELECT COUNT(*) as total FROM produk")[0]['total'];
echo "Current products in database: $current_products<br><br>";

// Step 2: Simulate adding product via admin
echo "<h3>Step 2: Adding Product via Admin</h3>";
$test_product = [
    'nama' => 'Admin Test Product ' . time(),
    'merk' => 'TestBrand',
    'harga' => 250000,
    'stok' => 10,
    'foto' => 'admin-test-' . uniqid() . '.jpg'
];

$query = "INSERT INTO produk (nama, merk, harga, stok, foto) VALUES (
    '{$test_product['nama']}',
    '{$test_product['merk']}',
    {$test_product['harga']},
    {$test_product['stok']},
    '{$test_product['foto']}'
)";

if (mysqli_query($conn, $query)) {
    $new_product_id = mysqli_insert_id($conn);
    echo "<span style='color:green;'>✅ Product added successfully!</span><br>";
    echo "Product ID: $new_product_id<br>";
    echo "Name: {$test_product['nama']}<br><br>";
} else {
    die("<span style='color:red;'>❌ Failed to add product: " . mysqli_error($conn) . "</span>");
}

// Step 3: Verify in admin products page query
echo "<h3>Step 3: Admin Products Page Query</h3>";
$admin_query = "SELECT * FROM produk ORDER BY id DESC";
$admin_result = query($admin_query);
$found_in_admin = false;

foreach ($admin_result as $product) {
    if ($product['id'] == $new_product_id) {
        $found_in_admin = true;
        echo "<span style='color:green;'>✅ Product found in admin query</span><br>";
        echo "ID: {$product['id']}<br>";
        echo "Name: {$product['nama']}<br>";
        echo "Merk: {$product['merk']}<br><br>";
        break;
    }
}

if (!$found_in_admin) {
    echo "<span style='color:red;'>❌ Product NOT found in admin query</span><br><br>";
}

// Step 4: Verify in user home page query (same query as home.php)
echo "<h3>Step 4: User Home Page Query</h3>";
$user_query = "SELECT * FROM produk"; // Same as home.php
$user_result = query($user_query);
$found_in_user = false;

foreach ($user_result as $product) {
    if ($product['id'] == $new_product_id) {
        $found_in_user = true;
        echo "<span style='color:green;'>✅ Product found in user home query</span><br>";
        echo "ID: {$product['id']}<br>";
        echo "Name: {$product['nama']}<br>";
        echo "Merk: {$product['merk']}<br>";
        echo "Price: Rp " . number_format($product['harga']) . "<br><br>";
        break;
    }
}

if (!$found_in_user) {
    echo "<span style='color:red;'>❌ Product NOT found in user home query</span><br><br>";
}

// Step 5: Check final count
echo "<h3>Step 5: Final Verification</h3>";
$final_count = query("SELECT COUNT(*) as total FROM produk")[0]['total'];
echo "Final product count: $final_count<br>";
echo "Products added in this test: " . ($final_count - $current_products) . "<br><br>";

// Step 6: Test actual page access
echo "<h3>Step 6: Page Access Test</h3>";
echo "<p><strong>Admin Products Page:</strong> <a href='admin/products.php' target='_blank'>admin/products.php</a></p>";
echo "<p><strong>User Home Page:</strong> <a href='home.php' target='_blank'>home.php</a></p>";
echo "<p><strong>Add Product Page:</strong> <a href='admin/tambah_produk.php' target='_blank'>admin/tambah_produk.php</a></p><br>";

// Summary
echo "<h3>📊 Test Summary</h3>";
echo "<ul>";
echo "<li>Database Insert: " . ($new_product_id ? "✅ SUCCESS" : "❌ FAILED") . "</li>";
echo "<li>Admin Query: " . ($found_in_admin ? "✅ SUCCESS" : "❌ FAILED") . "</li>";
echo "<li>User Query: " . ($found_in_user ? "✅ SUCCESS" : "❌ FAILED") . "</li>";
echo "<li>Count Updated: " . (($final_count > $current_products) ? "✅ SUCCESS" : "❌ FAILED") . "</li>";
echo "</ul>";

if ($found_in_admin && $found_in_user) {
    echo "<div style='background:#d4edda;color:#155724;padding:15px;border-radius:5px;margin:10px 0;'>";
    echo "<strong>🎉 SUCCESS:</strong> Product flow from Admin → User is working correctly!";
    echo "</div>";
} else {
    echo "<div style='background:#f8d7da;color:#721c24;padding:15px;border-radius:5px;margin:10px 0;'>";
    echo "<strong>❌ ISSUE:</strong> There are problems with the product flow.";
    echo "</div>";
}
?>