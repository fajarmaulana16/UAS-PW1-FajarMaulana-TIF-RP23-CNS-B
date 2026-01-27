<?php
// Force database setup
echo "<h1>🔄 Force Database Setup</h1>";

// Connect to MySQL
$conn = mysqli_connect("localhost", "root", "");

if (!$conn) {
    die("<span style='color:red;'>❌ Cannot connect to MySQL: " . mysqli_connect_error() . "</span>");
}

echo "<span style='color:green;'>✅ Connected to MySQL</span><br>";

// Drop and recreate database
$sql = "DROP DATABASE IF EXISTS toko_sepatu";
if (mysqli_query($conn, $sql)) {
    echo "✅ Old database dropped<br>";
}

$sql = "CREATE DATABASE toko_sepatu";
if (mysqli_query($conn, $sql)) {
    echo "✅ Database 'toko_sepatu' created<br>";
} else {
    die("<span style='color:red;'>❌ Error creating database: " . mysqli_error($conn) . "</span>");
}

// Select database
mysqli_select_db($conn, "toko_sepatu");

// Create tables
$tables = [
    "CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE,
        email VARCHAR(100) UNIQUE,
        password VARCHAR(255),
        role ENUM('admin', 'user') DEFAULT 'user',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    "CREATE TABLE produk (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama VARCHAR(100),
        merk VARCHAR(50),
        harga INT,
        stok INT,
        foto VARCHAR(255)
    )",

    "CREATE TABLE cart (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        produk_id INT NOT NULL,
        jumlah INT NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (produk_id) REFERENCES produk(id)
    )",

    "CREATE TABLE orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        total DECIMAL(10,2) NOT NULL,
        status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )",

    "CREATE TABLE order_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT NOT NULL,
        produk_id INT NOT NULL,
        jumlah INT NOT NULL,
        harga DECIMAL(10,2) NOT NULL,
        FOREIGN KEY (order_id) REFERENCES orders(id),
        FOREIGN KEY (produk_id) REFERENCES produk(id)
    )"
];

foreach ($tables as $table_sql) {
    if (mysqli_query($conn, $table_sql)) {
        echo "✅ Table created successfully<br>";
    } else {
        echo "<span style='color:red;'>❌ Error creating table: " . mysqli_error($conn) . "</span><br>";
    }
}

// Insert admin user
$password = password_hash("joko321", PASSWORD_DEFAULT);
$sql = "INSERT INTO users (username, email, password, role) VALUES ('joko', 'joko@sneakerhub.com', '$password', 'admin')";
if (mysqli_query($conn, $sql)) {
    echo "✅ Admin user created<br>";
    echo "Username: joko<br>";
    echo "Password: joko321<br>";
} else {
    echo "<span style='color:red;'>❌ Error creating admin: " . mysqli_error($conn) . "</span><br>";
}

// Insert sample products
$products = [
    ["Nike Air Max", "Nike", 1500000, 10, "nike-airmax.jpg"],
    ["Adidas Ultraboost", "Adidas", 2000000, 5, "adidas-ultraboost.jpg"],
    ["Puma RS-X", "Puma", 1200000, 8, "puma-rsx.jpg"],
    ["Converse Chuck Taylor", "Converse", 800000, 15, "converse-chuck.jpg"],
    ["Vans Old Skool", "Vans", 900000, 12, "vans-oldskool.jpg"]
];

foreach ($products as $product) {
    $sql = "INSERT INTO produk (nama, merk, harga, stok, foto) VALUES ('$product[0]', '$product[1]', $product[2], $product[3], '$product[4]')";
    if (mysqli_query($conn, $sql)) {
        echo "✅ Product '$product[0]' added<br>";
    } else {
        echo "<span style='color:red;'>❌ Error adding product: " . mysqli_error($conn) . "</span><br>";
    }
}

mysqli_close($conn);

echo "<br><h2>🎉 Setup Complete!</h2>";
echo "<a href='login.php' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Login as Admin</a><br><br>";
echo "<a href='admin/products.php' style='background:#28a745;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Go to Admin Products</a>";
?>