<?php
// Script untuk setup database dan tabel
$conn = mysqli_connect("localhost", "root", "", "");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Buat database jika belum ada
$sql = "CREATE DATABASE IF NOT EXISTS toko_sepatu";
if (mysqli_query($conn, $sql)) {
    echo "Database 'toko_sepatu' berhasil dibuat atau sudah ada.<br>";
} else {
    echo "Error creating database: " . mysqli_error($conn) . "<br>";
}

// Pilih database
mysqli_select_db($conn, "toko_sepatu");

// Drop tabel users jika perlu update
$sql = "DROP TABLE IF EXISTS users";
mysqli_query($conn, $sql);

// Buat tabel users (untuk admin dan user)
$sql = "CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if (mysqli_query($conn, $sql)) {
    echo "Tabel 'users' berhasil dibuat.<br>";
} else {
    echo "Error creating table users: " . mysqli_error($conn) . "<br>";
}

// Buat tabel cart
$sql = "CREATE TABLE IF NOT EXISTS cart (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    produk_id INT(11) NOT NULL,
    jumlah INT(11) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (produk_id) REFERENCES produk(id)
)";
if (mysqli_query($conn, $sql)) {
    echo "Tabel 'cart' berhasil dibuat atau sudah ada.<br>";
} else {
    echo "Error creating table cart: " . mysqli_error($conn) . "<br>";
}

// Buat tabel orders
$sql = "CREATE TABLE IF NOT EXISTS orders (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";
if (mysqli_query($conn, $sql)) {
    echo "Tabel 'orders' berhasil dibuat atau sudah ada.<br>";
} else {
    echo "Error creating table orders: " . mysqli_error($conn) . "<br>";
}

// Buat tabel order_items
$sql = "CREATE TABLE IF NOT EXISTS order_items (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    order_id INT(11) NOT NULL,
    produk_id INT(11) NOT NULL,
    jumlah INT(11) NOT NULL,
    harga DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (produk_id) REFERENCES produk(id)
)";
if (mysqli_query($conn, $sql)) {
    echo "Tabel 'order_items' berhasil dibuat atau sudah ada.<br>";
} else {
    echo "Error creating table order_items: " . mysqli_error($conn) . "<br>";
}

// Buat tabel produk
$sql = "CREATE TABLE IF NOT EXISTS produk (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    merk VARCHAR(50) NOT NULL,
    harga INT(11) NOT NULL,
    stok INT(11) NOT NULL,
    foto VARCHAR(255)
)";
if (mysqli_query($conn, $sql)) {
    echo "Tabel 'produk' berhasil dibuat atau sudah ada.<br>";
} else {
    echo "Error creating table produk: " . mysqli_error($conn) . "<br>";
}

// Insert user admin default jika belum ada
$username = "joko";
$email = "joko@sneakerhub.com";
$password = password_hash("joko321", PASSWORD_DEFAULT);
$sql = "INSERT IGNORE INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', 'admin')";
if (mysqli_query($conn, $sql)) {
    echo "User admin berhasil ditambahkan atau sudah ada.<br>";
} else {
    echo "Error inserting user: " . mysqli_error($conn) . "<br>";
}

echo "Setup database selesai. Username: joko, Password: joko321";
?></content>
<parameter name="filePath">c:\xampp\htdocs\toko_sepatu\setup.php