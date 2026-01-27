<?php
// Test berbagai format gambar dari Google Images
echo "<h1>🖼️ Test Berbagai Format Gambar</h1>";

$test_images = [
    [
        'url' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=300&h=300&fit=crop',
        'format' => 'JPG (Unsplash)',
        'expected' => true
    ],
    [
        'url' => 'https://picsum.photos/300/300?random=1',
        'format' => 'JPG (Picsum)',
        'expected' => true
    ],
    [
        'url' => 'https://via.placeholder.com/300x300/FF6B6B/FFFFFF.png',
        'format' => 'PNG',
        'expected' => true
    ],
    [
        'url' => 'https://via.placeholder.com/300x300.gif',
        'format' => 'GIF',
        'expected' => true
    ],
    [
        'url' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=300&h=300&fit=crop&fm=webp',
        'format' => 'WebP',
        'expected' => true
    ],
    [
        'url' => 'https://via.placeholder.com/300x300.bmp',
        'format' => 'BMP',
        'expected' => true
    ]
];

echo "<h3>Format Gambar yang Didukung:</h3>";
echo "<ul>";
echo "<li>✅ JPG / JPEG</li>";
echo "<li>✅ PNG</li>";
echo "<li>✅ GIF</li>";
echo "<li>✅ WebP</li>";
echo "<li>✅ BMP</li>";
echo "<li>✅ SVG</li>";
echo "</ul><br>";

echo "<h3>Test Preview Gambar:</h3>";
echo "<div style='display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;margin:20px 0;'>";

foreach ($test_images as $index => $image) {
    echo "<div style='border:1px solid #ddd;padding:15px;border-radius:8px;text-align:center;'>";
    echo "<h5>{$image['format']}</h5>";
    echo "<img src='{$image['url']}' style='max-width:200px;max-height:200px;border:1px solid #ccc;border-radius:4px;' alt='Test image' onerror=\"this.style.display='none';this.nextElementSibling.style.display='block';\">";
    echo "<div style='display:none;color:red;font-size:12px;'>❌ Gagal memuat gambar</div>";
    echo "<p style='font-size:11px;color:#666;margin-top:10px;word-break:break-all;'>{$image['url']}</p>";
    echo "</div>";
}

echo "</div><br>";

echo "<h3>Cara Menggunakan:</h3>";
echo "<ol>";
echo "<li>Buka <a href='https://images.google.com' target='_blank'>Google Images</a></li>";
echo "<li>Cari gambar sepatu yang diinginkan</li>";
echo "<li>Klik kanan gambar → 'Copy image address' atau 'Salin alamat gambar'</li>";
echo "<li>Paste URL ke form 'URL Gambar' di halaman tambah produk</li>";
echo "<li>Sistem akan mendukung semua format gambar populer</li>";
echo "</ol><br>";

echo "<h3>Test Form:</h3>";
echo "<a href='admin/tambah_produk.php' style='background:#007bff;color:white;padding:15px 30px;text-decoration:none;border-radius:5px;font-size:16px;margin-right:10px;'>🖼️ Test Tambah Produk</a>";
echo "<a href='admin/products.php' style='background:#28a745;color:white;padding:15px 30px;text-decoration:none;border-radius:5px;font-size:16px;margin-right:10px;'>📋 Lihat Produk</a>";
echo "<a href='home.php' style='background:#ffc107;color:black;padding:15px 30px;text-decoration:none;border-radius:5px;font-size:16px;'>🏠 Home</a><br><br>";

echo "<div style='background:#e7f3ff;border:1px solid #b3d7ff;padding:15px;border-radius:5px;margin:20px 0;'>";
echo "<h4>💡 Tips Mengambil Gambar dari Google:</h4>";
echo "<ul>";
echo "<li>Klik kanan pada gambar → <strong>'Salin alamat gambar'</strong></li>";
echo "<li>Atau klik gambar → <strong>'Lihat gambar'</strong> → Copy URL dari address bar</li>";
echo "<li>Pastikan URL dimulai dengan <code>https://</code></li>";
echo "<li>Gambar akan otomatis di-preview sebelum disimpan</li>";
echo "</ul>";
echo "</div>";
?>