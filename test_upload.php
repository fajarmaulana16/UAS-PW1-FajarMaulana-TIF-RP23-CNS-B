<?php
// Test File Upload
echo "<h1>📁 Test File Upload</h1>";

// Check directory
$upload_dir = 'assets/img/';
echo "<h3>Directory Check:</h3>";
if (is_dir($upload_dir)) {
    echo "<span style='color:green;'>✅ Directory exists: $upload_dir</span><br>";
} else {
    echo "<span style='color:red;'>❌ Directory does not exist: $upload_dir</span><br>";
}

if (is_writable($upload_dir)) {
    echo "<span style='color:green;'>✅ Directory is writable</span><br><br>";
} else {
    echo "<span style='color:red;'>❌ Directory is not writable</span><br><br>";
}

// Create test file
$test_file = $upload_dir . 'test_upload_' . time() . '.txt';
$content = "Test upload file created at " . date('Y-m-d H:i:s');

if (file_put_contents($test_file, $content)) {
    echo "<h3>File Creation Test:</h3>";
    echo "<span style='color:green;'>✅ Test file created successfully: " . basename($test_file) . "</span><br>";
    echo "Content: $content<br><br>";
} else {
    echo "<span style='color:red;'>❌ Failed to create test file</span><br><br>";
}

// List files in directory
echo "<h3>Files in Upload Directory:</h3>";
$files = scandir($upload_dir);
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        $file_path = $upload_dir . $file;
        $size = filesize($file_path);
        $modified = date('Y-m-d H:i:s', filemtime($file_path));
        echo "📄 $file ($size bytes) - Modified: $modified<br>";
    }
}

echo "<br><a href='admin/tambah_produk.php' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Go to Add Product</a>";
?>