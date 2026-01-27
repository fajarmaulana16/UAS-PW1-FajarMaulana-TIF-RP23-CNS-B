<?php
session_start();
header('Content-Type: text/plain');

if (!isset($_SESSION["login"])) {
    echo 'not_logged_in';
    exit;
}

require 'config/config.php';

$id = intval($_GET["id"]);
$user_id = intval($_SESSION["user_id"]);

$produk = query("SELECT * FROM produk WHERE id = $id");
if (empty($produk)) {
    echo 'product_not_found';
    exit;
}

$produk = $produk[0];

// Cek apakah sudah ada di cart
$result = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $user_id AND produk_id = $id");
if (mysqli_num_rows($result) > 0) {
    // Update jumlah
    if (mysqli_query($conn, "UPDATE cart SET jumlah = jumlah + 1 WHERE user_id = $user_id AND produk_id = $id")) {
        echo 'success';
    } else {
        echo 'error: ' . mysqli_error($conn);
    }
} else {
    // Insert baru
    if (mysqli_query($conn, "INSERT INTO cart (user_id, produk_id, jumlah) VALUES ($user_id, $id, 1)")) {
        echo 'success';
    } else {
        echo 'error: ' . mysqli_error($conn);
    }
}