<?php
// Comprehensive database and system check
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔍 Sistem Check - Toko Sepatu</h1>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .warning{color:orange;} table{border-collapse:collapse;width:100%;} th,td{border:1px solid #ddd;padding:8px;text-align:left;} th{background:#f2f2f2;}</style>";

// 1. PHP Version Check
echo "<h2>1. PHP Version</h2>";
echo "PHP Version: " . PHP_VERSION . "<br>";
echo "Required: 7.0+ - " . (version_compare(PHP_VERSION, '7.0.0') >= 0 ? "<span class='success'>✅ OK</span>" : "<span class='error'>❌ TOO OLD</span>") . "<br><br>";

// 2. Database Connection Check
echo "<h2>2. Database Connection</h2>";
try {
    $conn = mysqli_connect("localhost", "root", "", "toko_sepatu");
    if ($conn) {
        echo "<span class='success'>✅ Database connection successful</span><br>";
        echo "Host: localhost, User: root, Database: toko_sepatu<br><br>";

        // 3. Tables Check
        echo "<h2>3. Database Tables</h2>";
        $tables = ['users', 'produk', 'orders', 'order_items', 'cart'];
        echo "<table>";
        echo "<tr><th>Table Name</th><th>Status</th><th>Records</th></tr>";

        foreach ($tables as $table) {
            $result = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
            if (mysqli_num_rows($result) > 0) {
                $count_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM $table");
                $count = mysqli_fetch_assoc($count_result)['count'];
                echo "<tr><td>$table</td><td><span class='success'>✅ Exists</span></td><td>$count records</td></tr>";
            } else {
                echo "<tr><td>$table</td><td><span class='error'>❌ Missing</span></td><td>-</td></tr>";
            }
        }
        echo "</table><br>";

        // 4. Admin User Check
        echo "<h2>4. Admin User Check</h2>";
        $admin_result = mysqli_query($conn, "SELECT * FROM users WHERE role = 'admin'");
        if (mysqli_num_rows($admin_result) > 0) {
            $admin = mysqli_fetch_assoc($admin_result);
            echo "<span class='success'>✅ Admin user found</span><br>";
            echo "Username: " . $admin['username'] . "<br>";
            echo "Email: " . $admin['email'] . "<br>";
            echo "Role: " . $admin['role'] . "<br><br>";
        } else {
            echo "<span class='error'>❌ No admin user found</span><br><br>";
        }

        // 5. Sample Products Check
        echo "<h2>5. Sample Products</h2>";
        $produk_result = mysqli_query($conn, "SELECT * FROM produk LIMIT 5");
        if (mysqli_num_rows($produk_result) > 0) {
            echo "<span class='success'>✅ Products found</span><br>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Nama</th><th>Merk</th><th>Harga</th><th>Stok</th><th>Foto</th></tr>";
            while ($produk = mysqli_fetch_assoc($produk_result)) {
                $foto_status = $produk['foto'] && file_exists('assets/img/' . $produk['foto']) ? '✅' : '❌';
                echo "<tr>";
                echo "<td>" . $produk['id'] . "</td>";
                echo "<td>" . $produk['nama'] . "</td>";
                echo "<td>" . $produk['merk'] . "</td>";
                echo "<td>Rp " . number_format($produk['harga']) . "</td>";
                echo "<td>" . $produk['stok'] . "</td>";
                echo "<td>$foto_status</td>";
                echo "</tr>";
            }
            echo "</table><br>";
        } else {
            echo "<span class='warning'>⚠️ No products found</span><br><br>";
        }

        mysqli_close($conn);
    } else {
        echo "<span class='error'>❌ Database connection failed: " . mysqli_connect_error() . "</span><br><br>";
    }
} catch (Exception $e) {
    echo "<span class='error'>❌ Database error: " . $e->getMessage() . "</span><br><br>";
}

// 6. File System Check
echo "<h2>6. File System Check</h2>";
$files_to_check = [
    'config/config.php' => 'Database config',
    'admin/products.php' => 'Admin products page',
    'admin/tambah_produk.php' => 'Add product page',
    'admin/edit.php' => 'Edit product page',
    'assets/img/' => 'Image upload directory'
];

echo "<table>";
echo "<tr><th>File/Directory</th><th>Status</th><th>Details</th></tr>";

foreach ($files_to_check as $file => $description) {
    if (is_dir($file) || file_exists($file)) {
        $details = is_dir($file) ? 'Directory exists' : 'File exists (' . filesize($file) . ' bytes)';
        echo "<tr><td>$file</td><td><span class='success'>✅ OK</span></td><td>$details</td></tr>";
    } else {
        echo "<tr><td>$file</td><td><span class='error'>❌ Missing</span></td><td>$description</td></tr>";
    }
}
echo "</table><br>";

// 7. Recommendations
echo "<h2>7. Recommendations</h2>";
echo "<div style='background:#f9f9f9;padding:15px;border-left:4px solid #007bff;'>";

if (!file_exists('config/config.php')) {
    echo "❌ <strong>Critical:</strong> config/config.php missing - Create database config file<br>";
}

$conn_test = mysqli_connect("localhost", "root", "", "toko_sepatu");
if (!$conn_test) {
    echo "❌ <strong>Critical:</strong> Cannot connect to database - Run setup.php<br>";
} else {
    $admin_check = mysqli_query($conn_test, "SELECT COUNT(*) as count FROM users WHERE role='admin'");
    $admin_count = mysqli_fetch_assoc($admin_check)['count'];
    if ($admin_count == 0) {
        echo "❌ <strong>Critical:</strong> No admin user found - Create admin account<br>";
    }
    mysqli_close($conn_test);
}

echo "✅ <strong>Next Steps:</strong><br>";
echo "1. If database issues: Visit <a href='setup.php'>setup.php</a><br>";
echo "2. Login as admin: <a href='login.php'>login.php</a> (joko/joko321)<br>";
echo "3. Access admin: <a href='admin/products.php'>admin/products.php</a><br>";
echo "</div>";
?>