<?php
// Debug Version of Admin Products Page
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

echo "<!-- DEBUG INFO START -->\n";
echo "<div style='background:#f0f0f0;padding:10px;margin:10px;border:1px solid #ccc;font-family:monospace;font-size:12px;'>\n";
echo "<strong>DEBUG INFO:</strong><br>\n";
echo "Session login: " . (isset($_SESSION["login"]) ? "YES" : "NO") . "<br>\n";
echo "Session role: " . ($_SESSION["role"] ?? "NOT SET") . "<br>\n";
echo "Session username: " . ($_SESSION["username"] ?? "NOT SET") . "<br>\n";
echo "Current file: " . __FILE__ . "<br>\n";
echo "Current dir: " . __DIR__ . "<br>\n";
echo "</div>\n";
echo "<!-- DEBUG INFO END -->\n";

// Check session
if (!isset($_SESSION["login"]) || $_SESSION["role"] != "admin") {
    echo "<h1 style='color:red;'>Access Denied</h1>\n";
    echo "<p>You are not logged in as admin.</p>\n";
    echo "<a href='../login.php'>Go to Login</a><br><br>\n";

    // Force admin login for testing
    echo "<h3>For Testing - Force Admin Login:</h3>\n";
    $_SESSION["login"] = true;
    $_SESSION["username"] = "admin";
    $_SESSION["role"] = "admin";
    echo "<span style='color:green;'>✅ Admin session set</span><br>\n";
    echo "<a href='products.php'>Retry with admin session</a><br><br>\n";
    exit;
}

echo "<h1 style='color:green;'>✅ Admin Access Granted</h1>\n";

// Database connection
try {
    require '../config/config.php';
    echo "<span style='color:green;'>✅ Config loaded</span><br>\n";
} catch (Exception $e) {
    echo "<span style='color:red;'>❌ Config error: " . $e->getMessage() . "</span><br>\n";
    exit;
}

// Query products
try {
    $sepatu = query("SELECT * FROM produk");
    echo "<span style='color:green;'>✅ Query successful: " . count($sepatu) . " products</span><br><br>\n";
} catch (Exception $e) {
    echo "<span style='color:red;'>❌ Query error: " . $e->getMessage() . "</span><br>\n";
    exit;
}

// Handle delete
if (isset($_GET["hapus"])) {
    $id = $_GET["hapus"];
    mysqli_query($conn, "DELETE FROM produk WHERE id = $id");
    echo "<script>alert('Product deleted!'); window.location.href = 'products.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk - Debug Version</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .debug-info { background: #fff3cd; border: 1px solid #ffeaa7; padding: 10px; margin: 10px 0; }
    </style>
</head>
<body>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Data Produk (Debug Version)</h1>
                <a href="tambah_produk.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Produk
                </a>
            </div>

            <?php if (count($sepatu) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Merk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($sepatu as $s): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td>
                                <?php if ($s['foto'] && file_exists('../assets/img/' . $s['foto'])): ?>
                                    <img src="../assets/img/<?= $s['foto']; ?>" width="50" height="50" class="rounded">
                                <?php else: ?>
                                    <span class="text-muted">No image</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($s["nama"]); ?></td>
                            <td><?= htmlspecialchars($s["merk"]); ?></td>
                            <td>Rp <?= number_format($s["harga"]); ?></td>
                            <td><?= $s["stok"]; ?></td>
                            <td>
                                <a href="edit.php?id=<?= $s['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="?hapus=<?= $s['id']; ?>" class="btn btn-danger btn-sm"
                                   onclick="return confirm('Hapus produk ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="alert alert-info">
                Belum ada produk. <a href="tambah_produk.php">Tambah produk pertama</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="debug-info">
    <strong>Debug Info:</strong><br>
    - Products loaded: <?= count($sepatu) ?><br>
    - Session active: <?= isset($_SESSION["login"]) ? "Yes" : "No" ?><br>
    - User role: <?= $_SESSION["role"] ?? "Not set" ?><br>
    - Page loaded at: <?= date('Y-m-d H:i:s') ?><br>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>