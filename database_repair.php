<?php
// Database Repair Tool
echo "<h1>🛠️ Database Repair Tool</h1>";
echo "<p>Memperbaiki masalah database dan tabel yang rusak</p><hr>";

// Connect to database
require 'config/config.php';

$repairs = [];
$errors = [];

// 1. Check if database exists
echo "<h3>🗄️ 1. Database Existence Check</h3>";
$db_selected = mysqli_select_db($conn, "toko_sepatu");
if (!$db_selected) {
    echo "❌ Database 'toko_sepatu' tidak ada<br>";
    $sql = "CREATE DATABASE toko_sepatu";
    if (mysqli_query($conn, $sql)) {
        echo "✅ Database 'toko_sepatu' berhasil dibuat<br>";
        $repairs[] = "Created database 'toko_sepatu'";
        mysqli_select_db($conn, "toko_sepatu");
    } else {
        echo "❌ Gagal membuat database: " . mysqli_error($conn) . "<br>";
        $errors[] = "Failed to create database";
    }
} else {
    echo "✅ Database 'toko_sepatu' ada<br>";
}

// 2. Check and create tables
echo "<h3>📋 2. Table Creation Check</h3>";

$tables = [
    'produk' => "CREATE TABLE produk (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        nama VARCHAR(255) NOT NULL,
        harga DECIMAL(10,2) NOT NULL,
        deskripsi TEXT,
        gambar VARCHAR(500),
        gambar_url VARCHAR(500),
        stok INT(11) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    'users' => "CREATE TABLE users (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin','user') DEFAULT 'user',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    'orders' => "CREATE TABLE orders (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        user_id INT(11),
        total DECIMAL(10,2) NOT NULL,
        status ENUM('pending','completed','cancelled') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )",
    'order_items' => "CREATE TABLE order_items (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        order_id INT(11),
        product_id INT(11),
        quantity INT(11) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        FOREIGN KEY (order_id) REFERENCES orders(id),
        FOREIGN KEY (product_id) REFERENCES produk(id)
    )"
];

foreach ($tables as $table_name => $create_sql) {
    $check_sql = "SHOW TABLES LIKE '$table_name'";
    $result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($result) == 0) {
        echo "❌ Tabel '$table_name' tidak ada<br>";
        if (mysqli_query($conn, $create_sql)) {
            echo "✅ Tabel '$table_name' berhasil dibuat<br>";
            $repairs[] = "Created table '$table_name'";
        } else {
            echo "❌ Gagal membuat tabel '$table_name': " . mysqli_error($conn) . "<br>";
            $errors[] = "Failed to create table '$table_name'";
        }
    } else {
        echo "✅ Tabel '$table_name' ada<br>";
    }
}

// 3. Check table structure
echo "<h3>🔍 3. Table Structure Check</h3>";

$required_columns = [
    'produk' => ['id', 'nama', 'harga', 'deskripsi', 'gambar', 'gambar_url', 'stok'],
    'users' => ['id', 'username', 'password', 'role']
];

foreach ($required_columns as $table => $columns) {
    echo "<h5>Tabel: $table</h5>";
    $result = mysqli_query($conn, "DESCRIBE $table");

    if ($result) {
        $existing_columns = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $existing_columns[] = $row['Field'];
        }

        foreach ($columns as $column) {
            if (in_array($column, $existing_columns)) {
                echo "✅ Kolom '$column' ada<br>";
            } else {
                echo "❌ Kolom '$column' hilang<br>";
                // Try to add missing columns
                $alter_sql = "";
                switch ($column) {
                    case 'gambar_url':
                        $alter_sql = "ALTER TABLE produk ADD COLUMN gambar_url VARCHAR(500) AFTER gambar";
                        break;
                    case 'stok':
                        $alter_sql = "ALTER TABLE produk ADD COLUMN stok INT(11) DEFAULT 0 AFTER gambar_url";
                        break;
                }

                if ($alter_sql && mysqli_query($conn, $alter_sql)) {
                    echo "✅ Kolom '$column' berhasil ditambahkan<br>";
                    $repairs[] = "Added column '$column' to table '$table'";
                } else {
                    $errors[] = "Failed to add column '$column' to table '$table'";
                }
            }
        }
    } else {
        echo "❌ Gagal memeriksa struktur tabel $table<br>";
        $errors[] = "Failed to check table structure for '$table'";
    }
}

// 4. Insert default admin user
echo "<h3>👤 4. Default Admin User Check</h3>";

 $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE username = 'joko'");
if ($result) {
    $row = mysqli_fetch_assoc($result);
    if ($row['count'] == 0) {
        echo "❌ Admin user tidak ada<br>";
        $password_hash = password_hash('joko321', PASSWORD_DEFAULT);
        $insert_sql = "INSERT INTO users (username, password, role) VALUES ('joko', '$password_hash', 'admin')";

        if (mysqli_query($conn, $insert_sql)) {
            echo "✅ Admin user berhasil dibuat (username: joko, password: joko321)<br>";
            $repairs[] = "Created default admin user";
        } else {
            echo "❌ Gagal membuat admin user: " . mysqli_error($conn) . "<br>";
            $errors[] = "Failed to create admin user";
        }
    } else {
        echo "✅ Admin user sudah ada<br>";
    }
} else {
    echo "❌ Gagal memeriksa admin user<br>";
    $errors[] = "Failed to check admin user";
}

// 5. Insert sample products
echo "<h3>📦 5. Sample Products Check</h3>";

$result = mysqli_query($conn, "SELECT COUNT(*) as count FROM produk");
if ($result) {
    $row = mysqli_fetch_assoc($result);
    if ($row['count'] == 0) {
        echo "❌ Tidak ada produk<br>";
        $sample_products = [
            ["Nike Air Max", 1500000, "Sepatu olahraga premium dengan teknologi Air Max", "https://via.placeholder.com/300x200/cccccc/000000?text=Nike+Air+Max", "", 10],
            ["Adidas Ultraboost", 2000000, "Sepatu running dengan Boost technology", "https://via.placeholder.com/300x200/cccccc/000000?text=Adidas+Ultraboost", "", 8],
            ["Puma RS-X", 1200000, "Sepatu lifestyle dengan desain retro", "https://via.placeholder.com/300x200/cccccc/000000?text=Puma+RS-X", "", 15]
        ];

        $inserted = 0;
        foreach ($sample_products as $product) {
            $insert_sql = "INSERT INTO produk (nama, harga, deskripsi, gambar, gambar_url, stok) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insert_sql);
            mysqli_stmt_bind_param($stmt, "sdsssi", $product[0], $product[1], $product[2], $product[3], $product[4], $product[5]);

            if (mysqli_stmt_execute($stmt)) {
                $inserted++;
            }
            mysqli_stmt_close($stmt);
        }

        if ($inserted > 0) {
            echo "✅ $inserted produk sample berhasil ditambahkan<br>";
            $repairs[] = "Added $inserted sample products";
        } else {
            echo "❌ Gagal menambahkan produk sample<br>";
            $errors[] = "Failed to add sample products";
        }
    } else {
        echo "✅ Sudah ada " . $row['count'] . " produk<br>";
    }
} else {
    echo "❌ Gagal memeriksa produk<br>";
    $errors[] = "Failed to check products";
}

// 6. Repair summary
echo "<h3>📊 6. Repair Summary</h3>";

if (empty($errors)) {
    echo "<div style='background:#d4edda;color:#155724;padding:15px;border-radius:5px;border:1px solid #c3e6cb;margin:10px 0;'>";
    echo "<h4>✅ Database Repair Complete!</h4>";
    if (!empty($repairs)) {
        echo "<p>Perbaikan yang dilakukan:</p>";
        echo "<ul>";
        foreach ($repairs as $repair) {
            echo "<li>$repair</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Database sudah dalam kondisi baik, tidak ada perbaikan yang diperlukan.</p>";
    }
    echo "</div>";
} else {
    echo "<div style='background:#f8d7da;color:#721c24;padding:15px;border-radius:5px;border:1px solid #f5c6cb;margin:10px 0;'>";
    echo "<h4>❌ Repair Errors:</h4>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul>";
    echo "</div>";
}

// 7. Test queries
echo "<h3>🧪 7. Query Tests</h3>";

$test_queries = [
    "SELECT COUNT(*) as total FROM produk" => "Count products",
    "SELECT COUNT(*) as total FROM users" => "Count users",
    "SELECT * FROM produk LIMIT 1" => "Select first product",
    "SELECT * FROM users WHERE role = 'admin' LIMIT 1" => "Select admin user"
];

foreach ($test_queries as $query => $description) {
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "✅ $description: OK<br>";
    } else {
        echo "❌ $description: FAILED - " . mysqli_error($conn) . "<br>";
        $errors[] = "Query test failed: $description";
    }
}

mysqli_close($conn);
?>

<hr>
<div style="background:#e7f3ff;padding:20px;border-radius:10px;margin:20px 0;">
    <h3>🔄 Next Steps</h3>
    <p>Setelah perbaikan database selesai:</p>
    <ol>
        <li>Jalankan <a href="ultimate_solver.php" target="_blank">Ultimate Problem Solver</a></li>
        <li>Jalankan <a href="frontend_diagnostic.php" target="_blank">Frontend Diagnostic</a></li>
        <li>Coba akses <a href="admin/products.php" target="_blank">halaman admin products</a></li>
        <li>Jika masih bermasalah, berikan detail error yang muncul</li>
    </ol>
</div>