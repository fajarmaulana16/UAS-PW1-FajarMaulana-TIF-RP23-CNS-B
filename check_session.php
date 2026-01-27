<?php
session_start();

echo "<h1>🔍 Session Check</h1>";

echo "<h3>Current Session Status:</h3>";
if (isset($_SESSION["login"])) {
    echo "<span style='color:green;'>✅ User is logged in</span><br>";
    echo "Username: " . ($_SESSION["username"] ?? "Not set") . "<br>";
    echo "Role: " . ($_SESSION["role"] ?? "Not set") . "<br><br>";
} else {
    echo "<span style='color:red;'>❌ User is NOT logged in</span><br><br>";
}

echo "<h3>All Session Variables:</h3>";
if (!empty($_SESSION)) {
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
} else {
    echo "No session variables set<br><br>";
}

echo "<h3>Session Configuration:</h3>";
echo "Session ID: " . session_id() . "<br>";
echo "Session Name: " . session_name() . "<br>";
echo "Session Save Path: " . session_save_path() . "<br><br>";

echo "<a href='admin/products.php' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Try Admin Products</a>";
?>