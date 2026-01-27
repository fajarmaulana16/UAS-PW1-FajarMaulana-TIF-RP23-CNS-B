<?php
// Test: Add product and verify it appears on user page
echo "<h1>🧪 Test: Admin Add Product → User View</h1>";

require 'config/config.php';

// Step 1: Add a test product
$nama = "Test Product " . rand(1000,9999);
$merk = "Test Brand";
$harga = rand(100000, 500000);
$stok = rand(5, 20);
$foto = "test-" . uniqid() . ".jpg";

echo "<h3>Step 1: Adding Test Product</h3>";
echo "Nama: $nama<br>";
echo "Merk: $merk<br>";
echo "Harga: Rp " . number_format($harga) . "<br>";
echo "Stok: $stok<br>";
echo "Foto: $foto<br><br>";

$query = "INSERT INTO produk (nama, merk, harga, stok, foto) VALUES ('$nama', '$merk', '$harga', '$stok', '$foto')";

if (mysqli_query($conn, $query)) {
    $product_id = mysqli_insert_id($conn);
    echo "<span style='color:green;'>✅ Product added successfully! ID: $product_id</span><br><br>";
} else {
    die("<span style='color:red;'>❌ Failed to add product: " . mysqli_error($conn) . "</span><br><br>");
}

// Step 2: Verify product appears in admin products page
echo "<h3>Step 2: Verify in Admin Products</h3>";
$admin_products = query("SELECT * FROM produk WHERE id = $product_id");
if ($admin_products) {
    echo "<span style='color:green;'>✅ Product found in admin products: " . $admin_products[0]['nama'] . "</span><br><br>";
} else {
    echo "<span style='color:red;'>❌ Product not found in admin products</span><br><br>";
}

// Step 3: Verify product appears in user home page
echo "<h3>Step 3: Verify in User Home Page</h3>";
$user_products = query("SELECT * FROM produk ORDER BY id DESC LIMIT 5");
$found_in_user = false;
foreach ($user_products as $product) {
    if ($product['id'] == $product_id) {
        $found_in_user = true;
        echo "<span style='color:green;'>✅ Product found in user home page: " . $product['nama'] . "</span><br>";
        echo "Merk: " . $product['merk'] . "<br>";
        echo "Harga: Rp " . number_format($product['harga']) . "<br>";
        echo "Stok: " . $product['stok'] . "<br><br>";
        break;
    }
}

if (!$found_in_user) {
    echo "<span style='color:red;'>❌ Product not found in user home page</span><br><br>";
}

// Step 4: Show total products
$total_products = query("SELECT COUNT(*) as total FROM produk")[0]['total'];
echo "<h3>Step 4: Total Products in System</h3>";
echo "Total products: $total_products<br><br>";

// Step 5: Quick links to test
echo "<h3>Step 5: Test Links</h3>";
echo "<a href='admin/products.php' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;margin-right:10px;'>Admin Products</a>";
echo "<a href='home.php' style='background:#28a745;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;margin-right:10px;'>User Home</a>";
echo "<a href='admin/tambah_produk.php' style='background:#ffc107;color:black;padding:10px 20px;text-decoration:none;border-radius:5px;'>Add Product</a>";
?>