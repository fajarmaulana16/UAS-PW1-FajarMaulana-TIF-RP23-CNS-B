<?php
// Test: Add product with URL image
echo "<h1>🧪 Test: Add Product with URL Image</h1>";

require 'config/config.php';

// Test URL image
$test_url = "https://images.unsplash.com/photo-1549298916-b41d501d3772?w=400&h=400&fit=crop"; // Sample sneaker image

// Test data
$nama = "Test Sneaker URL " . rand(100,999);
$merk = "Test Brand";
$harga = 150000;
$stok = 5;

echo "<h3>Test Data:</h3>";
echo "Nama: $nama<br>";
echo "Merk: $merk<br>";
echo "Harga: Rp " . number_format($harga) . "<br>";
echo "Stok: $stok<br>";
echo "Foto URL: <a href='$test_url' target='_blank'>$test_url</a><br>";
echo "<img src='$test_url' style='max-width:200px;max-height:200px;border:1px solid #ccc;'><br><br>";

// Insert test product
$query = "INSERT INTO produk (nama, merk, harga, stok, foto) VALUES ('$nama', '$merk', '$harga', '$stok', '$test_url')";

if (mysqli_query($conn, $query)) {
    $product_id = mysqli_insert_id($conn);
    echo "<span style='color:green;'>✅ Product added successfully with URL image! ID: $product_id</span><br><br>";

    // Verify the product
    $result = query("SELECT * FROM produk WHERE id = $product_id");
    if ($result) {
        echo "<h3>Verification:</h3>";
        echo "✅ Product found in database<br>";
        echo "✅ Image URL stored: " . $result[0]['foto'] . "<br>";
        echo "✅ Image displays: <img src='" . $result[0]['foto'] . "' style='max-width:100px;max-height:100px;border:1px solid #ccc;'><br><br>";
    }
} else {
    echo "<span style='color:red;'>❌ Failed to add product: " . mysqli_error($conn) . "</span><br><br>";
}

// Show total products
$total = query("SELECT COUNT(*) as total FROM produk")[0]['total'];
echo "<h3>Total Products: $total</h3><br>";

echo "<h3>Test Links:</h3>";
echo "<a href='admin/products.php' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;margin-right:10px;'>Admin Products</a>";
echo "<a href='home.php' style='background:#28a745;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;margin-right:10px;'>User Home</a>";
echo "<a href='admin/tambah_produk.php' style='background:#ffc107;color:black;padding:10px 20px;text-decoration:none;border-radius:5px;'>Add Product</a>";
?>