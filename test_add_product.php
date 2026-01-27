<?php
// Test Product Addition
echo "<h1>🧪 Test Product Addition</h1>";

require 'config/config.php';

// Test data
$nama = "Test Sepatu " . rand(100,999);
$merk = "Test Brand";
$harga = rand(500000, 2000000);
$stok = rand(1, 20);
$foto = "test-" . uniqid() . ".jpg";

echo "<h3>Test Data:</h3>";
echo "Nama: $nama<br>";
echo "Merk: $merk<br>";
echo "Harga: Rp " . number_format($harga) . "<br>";
echo "Stok: $stok<br>";
echo "Foto: $foto<br><br>";

// Test insert
$query = "INSERT INTO produk (nama, merk, harga, stok, foto) VALUES ('$nama', '$merk', '$harga', '$stok', '$foto')";

echo "<h3>Database Insert Test:</h3>";
if (mysqli_query($conn, $query)) {
    $last_id = mysqli_insert_id($conn);
    echo "<span style='color:green;'>✅ Product added successfully! ID: $last_id</span><br><br>";

    // Verify the product was added
    $result = query("SELECT * FROM produk WHERE id = $last_id");
    if ($result) {
        echo "<h3>Verification:</h3>";
        echo "<span style='color:green;'>✅ Product found in database:</span><br>";
        echo "ID: " . $result[0]['id'] . "<br>";
        echo "Nama: " . $result[0]['nama'] . "<br>";
        echo "Merk: " . $result[0]['merk'] . "<br>";
        echo "Harga: Rp " . number_format($result[0]['harga']) . "<br>";
        echo "Stok: " . $result[0]['stok'] . "<br>";
        echo "Foto: " . $result[0]['foto'] . "<br><br>";
    }
} else {
    echo "<span style='color:red;'>❌ Error adding product: " . mysqli_error($conn) . "</span><br><br>";
}

// Show total products
$result = query("SELECT COUNT(*) as total FROM produk");
if ($result) {
    echo "<h3>Total Products: " . $result[0]['total'] . "</h3>";
}

echo "<br><a href='admin/products.php' style='background:#28a745;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>View All Products</a>";
?>