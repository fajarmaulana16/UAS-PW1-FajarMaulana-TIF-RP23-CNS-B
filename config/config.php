<?php
$conn = mysqli_connect("localhost", "root", "", "toko_sepatu");
if (!$conn) { die("Koneksi Gagal: " . mysqli_connect_error()); }

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
?>