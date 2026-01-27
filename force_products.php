<?php
// Force Open Admin Products Page
session_start();

// Set admin session
$_SESSION["login"] = true;
$_SESSION["username"] = "admin";
$_SESSION["role"] = "admin";

echo "<h1>🔓 Force Admin Products Access</h1>";
echo "<p>Admin session has been set.</p>";
echo "<p>Session login: " . (isset($_SESSION["login"]) ? "YES" : "NO") . "</p>";
echo "<p>Session role: " . ($_SESSION["role"] ?? "NOT SET") . "</p><br>";

// Try to redirect
echo "<p>Redirecting to products page...</p>";
echo "<script>
setTimeout(function() {
    window.location.href = 'admin/products.php';
}, 2000);
</script>";

// Alternative direct link
echo "<p>If redirect doesn't work, click here:</p>";
echo "<a href='admin/products.php' target='_blank' style='background:#007bff;color:white;padding:15px 30px;text-decoration:none;border-radius:5px;font-size:16px;'>🚀 Open Products Page</a><br><br>";

// Check if file exists
if (file_exists('admin/products.php')) {
    echo "<span style='color:green;'>✅ admin/products.php file exists</span><br>";
} else {
    echo "<span style='color:red;'>❌ admin/products.php file NOT found</span><br>";
}

// Check config
if (file_exists('config/config.php')) {
    echo "<span style='color:green;'>✅ config/config.php file exists</span><br>";
} else {
    echo "<span style='color:red;'>❌ config/config.php file NOT found</span><br>";
}
?>