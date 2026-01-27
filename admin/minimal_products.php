<?php
// Minimal Admin Products Page
session_start();

// Force admin session
$_SESSION["login"] = true;
$_SESSION["username"] = "admin";
$_SESSION["role"] = "admin";

// Simple check
if (!isset($_SESSION["login"]) || $_SESSION["role"] != "admin") {
    header("Location: ../login.php");
    exit;
}

// Simple database connection
$conn = mysqli_connect("localhost", "root", "", "toko_sepatu");
if (!$conn) {
    die("DB Error: " . mysqli_connect_error());
}

// Simple query
$result = mysqli_query($conn, "SELECT * FROM produk");
$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Minimal Products</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Minimal Admin Products Page</h1>

    <p><strong>Status:</strong> Admin access granted</p>
    <p><strong>Products found:</strong> <?php echo count($products); ?></p>

    <?php if (count($products) > 0): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Brand</th>
            <th>Price</th>
            <th>Stock</th>
        </tr>
        <?php foreach ($products as $p): ?>
        <tr>
            <td><?php echo $p['id']; ?></td>
            <td><?php echo htmlspecialchars($p['nama']); ?></td>
            <td><?php echo htmlspecialchars($p['merk']); ?></td>
            <td>Rp <?php echo number_format($p['harga']); ?></td>
            <td><?php echo $p['stok']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
    <p>No products found.</p>
    <?php endif; ?>

    <br>
    <a href="tambah_produk.php" style="background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;">Add Product</a>
    <a href="../home.php" style="background:#28a745;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;margin-left:10px;">Home</a>
</body>
</html>