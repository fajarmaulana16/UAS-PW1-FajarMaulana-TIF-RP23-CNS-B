<?php
// Ultimate Debug: Check everything for admin products access
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔧 Ultimate Admin Products Debug</h1>";

// Step 1: Check PHP environment
echo "<h3>Step 1: PHP Environment</h3>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Server: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br><br>";

// Step 2: Check file permissions
echo "<h3>Step 2: File Permissions</h3>";
$files = [
    'admin/products.php',
    'config/config.php',
    'admin/',
    'config/'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $perms = substr(sprintf('%o', fileperms($file)), -4);
        echo "✅ $file exists (perms: $perms)<br>";
    } else {
        echo "❌ $file NOT found<br>";
    }
}
echo "<br>";

// Step 3: Test database connection
echo "<h3>Step 3: Database Connection</h3>";
try {
    $conn = mysqli_connect("localhost", "root", "", "toko_sepatu");
    if ($conn) {
        echo "✅ Database connected<br>";
        $result = mysqli_query($conn, "SELECT 1");
        if ($result) {
            echo "✅ Test query successful<br>";
        } else {
            echo "❌ Test query failed<br>";
        }
    } else {
        echo "❌ Database connection failed: " . mysqli_connect_error() . "<br>";
    }
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
}
echo "<br>";

// Step 4: Test session functionality
echo "<h3>Step 4: Session Test</h3>";
session_start();
echo "Session started<br>";
echo "Session ID: " . session_id() . "<br>";

// Force admin session
$_SESSION["login"] = true;
$_SESSION["username"] = "admin";
$_SESSION["role"] = "admin";

echo "Admin session set<br>";
echo "Session login: " . (isset($_SESSION["login"]) ? "true" : "false") . "<br>";
echo "Session role: " . ($_SESSION["role"] ?? "not set") . "<br><br>";

// Step 5: Test query function
echo "<h3>Step 5: Query Function Test</h3>";
function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "❌ Query failed: " . mysqli_error($conn) . "<br>";
        return false;
    }
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

$test_query = query("SELECT COUNT(*) as total FROM produk");
if ($test_query !== false) {
    echo "✅ Query function works, products count: " . $test_query[0]['total'] . "<br><br>";
} else {
    echo "❌ Query function failed<br><br>";
}

// Step 6: Test products page include
echo "<h3>Step 6: Products Page Include Test</h3>";
echo "<div style='border:1px solid #ccc;padding:10px;margin:10px 0;'>";

try {
    // Save current output buffer
    $current_content = ob_get_contents();
    ob_clean();

    // Include products page
    include 'admin/products.php';

    // Get the output
    $page_content = ob_get_contents();
    ob_clean();

    // Restore original content
    echo $current_content;

    if (strlen($page_content) > 100) {
        echo "✅ Products page included successfully (" . strlen($page_content) . " characters)<br>";
        echo "Page starts with: " . substr($page_content, 0, 100) . "...<br>";
    } else {
        echo "❌ Products page output too short or empty<br>";
        echo "Output: '$page_content'<br>";
    }

} catch (Exception $e) {
    echo "❌ Include error: " . $e->getMessage() . "<br>";
}

echo "</div><br>";

// Step 7: Direct browser test
echo "<h3>Step 7: Direct Browser Access</h3>";
echo "<a href='admin/products.php' target='_blank' style='background:#007bff;color:white;padding:15px 30px;text-decoration:none;border-radius:5px;font-size:16px;margin-right:10px;'>🚀 Open Admin Products</a>";
echo "<a href='login.php' target='_blank' style='background:#28a745;color:white;padding:15px 30px;text-decoration:none;border-radius:5px;font-size:16px;margin-right:10px;'>🔑 Login Page</a>";
echo "<a href='home.php' target='_blank' style='background:#ffc107;color:black;padding:15px 30px;text-decoration:none;border-radius:5px;font-size:16px;'>🏠 Home Page</a><br><br>";

// Step 8: Check for common issues
echo "<h3>Step 8: Common Issues Check</h3>";
$issues = [];

if (!function_exists('mysqli_connect')) {
    $issues[] = "MySQLi extension not loaded";
}

if (!is_writable(session_save_path())) {
    $issues[] = "Session save path not writable: " . session_save_path();
}

if (!file_exists('admin/products.php')) {
    $issues[] = "admin/products.php file missing";
}

if (!file_exists('config/config.php')) {
    $issues[] = "config/config.php file missing";
}

if (empty($issues)) {
    echo "✅ No common issues detected<br>";
} else {
    echo "❌ Issues found:<br>";
    foreach ($issues as $issue) {
        echo "- $issue<br>";
    }
}
echo "<br>";

// Step 9: Force redirect test
echo "<h3>Step 9: Force Redirect Test</h3>";
echo "<script>
function testRedirect() {
    window.open('admin/products.php', '_blank');
}
</script>";
echo "<button onclick='testRedirect()' style='background:#dc3545;color:white;padding:10px 20px;border:none;border-radius:5px;cursor:pointer;'>Force Open Products Page</button><br><br>";

// Step 10: Summary
echo "<h3>Step 10: Summary & Next Steps</h3>";
echo "<ol>";
echo "<li>Check if browser opens the products page</li>";
echo "<li>If blank page, check browser developer tools (F12) for errors</li>";
echo "<li>If redirected to login, session issue exists</li>";
echo "<li>Try accessing directly: http://localhost/toko_sepatu/admin/products.php</li>";
echo "<li>Check Apache/MySQL services are running</li>";
echo "</ol>";
?>