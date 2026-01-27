<?php
// Test menambahkan produk dengan berbagai format gambar
echo "<h1>🧪 Test Tambah Produk dengan Berbagai Format Gambar</h1>";

require 'config/config.php';

// Test URLs dengan berbagai format
$test_products = [
    [
        'nama' => 'Sneaker Classic JPG',
        'merk' => 'Nike',
        'harga' => 1200000,
        'stok' => 10,
        'foto' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=400&h=400&fit=crop',
        'format' => 'JPG'
    ],
    [
        'nama' => 'Running Shoes PNG',
        'merk' => 'Adidas',
        'harga' => 1500000,
        'stok' => 8,
        'foto' => 'https://via.placeholder.com/400x400/FF6B6B/FFFFFF.png',
        'format' => 'PNG'
    ],
    [
        'nama' => 'Casual Shoes GIF',
        'merk' => 'Puma',
        'harga' => 900000,
        'stok' => 15,
        'foto' => 'https://via.placeholder.com/400x400.gif',
        'format' => 'GIF'
    ],
    [
        'nama' => 'Sport Shoes WebP',
        'merk' => 'Reebok',
        'harga' => 1100000,
        'stok' => 12,
        'foto' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=400&h=400&fit=crop&fm=webp',
        'format' => 'WebP'
    ]
];

echo "<h3>Test Products to Add:</h3>";
echo "<div style='display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:20px;margin:20px 0;'>";

foreach ($test_products as $index => $product) {
    echo "<div style='border:1px solid #ddd;padding:15px;border-radius:8px;'>";
    echo "<h5>{$product['nama']}</h5>";
    echo "<p><strong>Format:</strong> {$product['format']}</p>";
    echo "<p><strong>Merk:</strong> {$product['merk']}</p>";
    echo "<p><strong>Harga:</strong> Rp " . number_format($product['harga']) . "</p>";
    echo "<p><strong>Stok:</strong> {$product['stok']}</p>";
    echo "<img src='{$product['foto']}' style='max-width:150px;max-height:150px;border:1px solid #ccc;border-radius:4px;margin:10px 0;' alt='{$product['nama']}'>";
    echo "<p style='font-size:10px;color:#666;word-break:break-all;margin-top:10px;'>URL: {$product['foto']}</p>";
    echo "</div>";
}

echo "</div><br>";

// Add test products
echo "<h3>Adding Test Products:</h3>";
$added_count = 0;

foreach ($test_products as $product) {
    $query = "INSERT INTO produk (nama, merk, harga, stok, foto) VALUES (
        '{$product['nama']}',
        '{$product['merk']}',
        {$product['harga']},
        {$product['stok']},
        '{$product['foto']}'
    )";

    if (mysqli_query($conn, $query)) {
        $added_count++;
        echo "<span style='color:green;'>✅ Added: {$product['nama']} ({$product['format']})</span><br>";
    } else {
        echo "<span style='color:red;'>❌ Failed: {$product['nama']} - " . mysqli_error($conn) . "</span><br>";
    }
}

echo "<br><span style='color:blue;font-weight:bold;'>📊 Total products added: $added_count</span><br><br>";

// Show total products
$total = query("SELECT COUNT(*) as total FROM produk")[0]['total'];
echo "<h3>Total Products in Database: $total</h3><br>";

// Test display in different pages
echo "<h3>Test Display:</h3>";
echo "<a href='admin/products.php' style='background:#007bff;color:white;padding:12px 25px;text-decoration:none;border-radius:5px;margin-right:10px;'>📋 Admin Products</a>";
echo "<a href='home.php' style='background:#28a745;color:white;padding:12px 25px;text-decoration:none;border-radius:5px;margin-right:10px;'>🏠 User Home</a>";
echo "<a href='admin/tambah_produk.php' style='background:#ffc107;color:black;padding:12px 25px;text-decoration:none;border-radius:5px;'>➕ Add More Products</a><br><br>";

// Summary
echo "<div style='background:#d4edda;border:1px solid #c3e6cb;padding:15px;border-radius:5px;color:#155724;margin:20px 0;'>";
echo "<h4>✅ Format Gambar yang Didukung:</h4>";
echo "<ul style='margin:0;'>";
echo "<li>JPG / JPEG - dari Google Images, Unsplash, dll</li>";
echo "<li>PNG - transparan background, kualitas tinggi</li>";
echo "<li>GIF - animasi atau gambar sederhana</li>";
echo "<li>WebP - format modern, ukuran kecil</li>";
echo "<li>BMP - format Windows standar</li>";
echo "<li>SVG - vektor, scalable</li>";
echo "</ul>";
echo "<p><strong>Cara copy URL dari Google:</strong> Klik kanan gambar → 'Salin alamat gambar'</p>";
echo "</div>";
?>