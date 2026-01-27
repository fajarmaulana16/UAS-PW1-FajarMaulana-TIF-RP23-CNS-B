<?php
// Test Edit Product with URL Image Feature
echo "<h1>🧪 Test Edit Product - URL Image Feature</h1>";
echo "<p>Testing fitur edit produk dengan URL gambar</p><hr>";

// Connect to database
require 'config/config.php';

// Get first product for testing
$result = mysqli_query($conn, "SELECT * FROM produk LIMIT 1");
if ($result && mysqli_num_rows($result) > 0) {
    $product = mysqli_fetch_assoc($result);
    echo "<h3>📦 Test Product Found:</h3>";
    echo "<p><strong>ID:</strong> {$product['id']}</p>";
    echo "<p><strong>Name:</strong> {$product['nama']}</p>";
    echo "<p><strong>Current Image:</strong> {$product['foto']}</p>";

    // Test URL update
    $test_url = "https://via.placeholder.com/300x200/4CAF50/FFFFFF?text=Updated+Image";
    $update_query = "UPDATE produk SET foto = '$test_url' WHERE id = {$product['id']}";

    if (mysqli_query($conn, $update_query)) {
        echo "<div style='background:#d4edda;color:#155724;padding:15px;border-radius:5px;border:1px solid #c3e6cb;margin:10px 0;'>";
        echo "<h4>✅ URL Image Update Test Successful!</h4>";
        echo "<p>Product image updated to URL: <code>$test_url</code></p>";
        echo "<img src='$test_url' style='max-width:200px;border-radius:5px;margin-top:10px;' alt='Test Image'>";
        echo "</div>";

        // Test revert back to original
        $revert_query = "UPDATE produk SET foto = '{$product['foto']}' WHERE id = {$product['id']}";
        if (mysqli_query($conn, $revert_query)) {
            echo "<div style='background:#cce5ff;color:#004085;padding:15px;border-radius:5px;border:1px solid #b3d7ff;margin:10px 0;'>";
            echo "<h4>🔄 Reverted to Original Image</h4>";
            echo "<p>Product image reverted to: <code>{$product['foto']}</code></p>";
            echo "</div>";
        }
    } else {
        echo "<div style='background:#f8d7da;color:#721c24;padding:15px;border-radius:5px;border:1px solid #f5c6cb;margin:10px 0;'>";
        echo "<h4>❌ URL Image Update Test Failed!</h4>";
        echo "<p>Error: " . mysqli_error($conn) . "</p>";
        echo "</div>";
    }

    echo "<hr>";
    echo "<h3>🔗 Test Links:</h3>";
    echo "<div style='display:flex;gap:10px;flex-wrap:wrap;margin:15px 0;'>";
    echo "<a href='admin/edit.php?id={$product['id']}' style='background:#007bff;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;' target='_blank'>Edit Product</a>";
    echo "<a href='admin/products.php' style='background:#28a745;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;' target='_blank'>View Products</a>";
    echo "</div>";

} else {
    echo "<div style='background:#fff3cd;border:1px solid #ffeaa7;padding:20px;border-radius:10px;margin:20px 0;'>";
    echo "<h4>⚠️ No Products Found</h4>";
    echo "<p>Tambah produk dulu sebelum test fitur edit.</p>";
    echo "<a href='admin/tambah_produk.php' style='background:#ffc107;color:black;padding:10px 15px;text-decoration:none;border-radius:5px;display:inline-block;margin-top:10px;'>Add Product</a>";
    echo "</div>";
}

mysqli_close($conn);
?>