<?php
// Visual Diagnostic Tool - Step by Step Troubleshooting
echo "<h1>👁️ Visual Diagnostic Tool</h1>";
echo "<p>Alat diagnostik visual untuk mengidentifikasi masalah yang Anda alami</p><hr>";

// Step 1: Basic Info
echo "<div style='background:#e7f3ff;border:1px solid #b3d7ff;padding:20px;border-radius:10px;margin:20px 0;'>";
echo "<h3>📋 Step 1: Basic System Info</h3>";
echo "<table style='width:100%;border-collapse:collapse;'>";
echo "<tr><td style='padding:8px;border:1px solid #ddd;background:#f8f9fa;font-weight:bold;'>PHP Version</td><td style='padding:8px;border:1px solid #ddd;'>" . phpversion() . "</td></tr>";
echo "<tr><td style='padding:8px;border:1px solid #ddd;background:#f8f9fa;font-weight:bold;'>Server</td><td style='padding:8px;border:1px solid #ddd;'>" . $_SERVER['SERVER_SOFTWARE'] . "</td></tr>";
echo "<tr><td style='padding:8px;border:1px solid #ddd;background:#f8f9fa;font-weight:bold;'>Current Time</td><td style='padding:8px;border:1px solid #ddd;'>" . date('Y-m-d H:i:s') . "</td></tr>";
echo "<tr><td style='padding:8px;border:1px solid #ddd;background:#f8f9fa;font-weight:bold;'>Document Root</td><td style='padding:8px;border:1px solid #ddd;'>" . $_SERVER['DOCUMENT_ROOT'] . "</td></tr>";
echo "</table>";
echo "</div>";

// Step 2: Visual Tests
echo "<div style='background:#f0f9ff;border:1px solid #b3e5fc;padding:20px;border-radius:10px;margin:20px 0;'>";
echo "<h3>🎨 Step 2: Visual Component Tests</h3>";

// Test Colors
echo "<h4>Color Test:</h4>";
echo "<div style='display:flex;gap:10px;margin:10px 0;'>";
echo "<div style='width:50px;height:50px;background:red;border:1px solid black;display:inline-block;'></div>";
echo "<div style='width:50px;height:50px;background:green;border:1px solid black;display:inline-block;'></div>";
echo "<div style='width:50px;height:50px;background:blue;border:1px solid black;display:inline-block;'></div>";
echo "<span style='margin-left:20px;'>Can you see 3 colored squares? <strong>YES/NO</strong></span>";
echo "</div><br>";

// Test Images
echo "<h4>Image Test:</h4>";
echo "<div style='display:flex;gap:20px;align-items:center;margin:10px 0;'>";
echo "<img src='https://via.placeholder.com/50x50/ff0000/ffffff?text=R' alt='Red' style='border:1px solid black;'>";
echo "<img src='https://via.placeholder.com/50x50/00ff00/000000?text=G' alt='Green' style='border:1px solid black;'>";
echo "<img src='https://via.placeholder.com/50x50/0000ff/ffffff?text=B' alt='Blue' style='border:1px solid black;'>";
echo "<span>Can you see 3 colored images? <strong>YES/NO</strong></span>";
echo "</div><br>";

// Test JavaScript
echo "<h4>JavaScript Test:</h4>";
echo "<button onclick='alert(\"JavaScript works!\")' style='padding:10px 20px;background:#007bff;color:white;border:none;border-radius:5px;cursor:pointer;'>Click Me</button>";
echo "<span style='margin-left:20px;'>Does clicking show alert popup? <strong>YES/NO</strong></span><br><br>";

// Test CSS
echo "<h4>CSS Test:</h4>";
echo "<div style='padding:15px;border:2px solid #007bff;border-radius:10px;background:linear-gradient(45deg,#007bff,#6610f2);color:white;margin:10px 0;'>";
echo "This should have blue border, rounded corners, gradient background, and white text.";
echo "</div>";
echo "<span>Does the box above look styled? <strong>YES/NO</strong></span>";
echo "</div>";

// Step 3: Functional Tests
echo "<div style='background:#fff3cd;border:1px solid #ffeaa7;padding:20px;border-radius:10px;margin:20px 0;'>";
echo "<h3>⚙️ Step 3: Functional Tests</h3>";

// Database Test
echo "<h4>Database Test:</h4>";
try {
    require 'config/config.php';
    $products = query("SELECT COUNT(*) as total FROM produk");
    echo "<span style='color:green;'>✅ Database: " . $products[0]['total'] . " products found</span><br>";
} catch (Exception $e) {
    echo "<span style='color:red;'>❌ Database: " . $e->getMessage() . "</span><br>";
}

// Session Test
echo "<h4>Session Test:</h4>";
session_start();
$_SESSION['diagnostic_test'] = 'passed';
if ($_SESSION['diagnostic_test'] === 'passed') {
    echo "<span style='color:green;'>✅ Session: Working correctly</span><br>";
} else {
    echo "<span style='color:red;'>❌ Session: Not working</span><br>";
}

// File Test
echo "<h4>File System Test:</h4>";
if (file_exists('admin/products.php')) {
    echo "<span style='color:green;'>✅ Files: Admin products page exists</span><br>";
} else {
    echo "<span style='color:red;'>❌ Files: Admin products page missing</span><br>";
}

if (is_dir('assets/img/')) {
    echo "<span style='color:green;'>✅ Files: Images directory exists</span><br>";
} else {
    echo "<span style='color:red;'>❌ Files: Images directory missing</span><br>";
}
echo "</div>";

// Step 4: Page Access Tests
echo "<div style='background:#d4edda;border:1px solid #c3e6cb;padding:20px;border-radius:10px;margin:20px 0;'>";
echo "<h3>🔗 Step 4: Page Access Tests</h3>";
echo "<p>Click each link below and report what happens:</p>";

$pages = [
    'index.php' => 'Home Page',
    'login.php' => 'Login Page',
    'home.php' => 'User Home',
    'admin/products.php' => 'Admin Products',
    'admin/tambah_produk.php' => 'Add Product'
];

echo "<div style='display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:10px;margin:15px 0;'>";
foreach ($pages as $url => $name) {
    echo "<a href='$url' target='_blank' style='background:#007bff;color:white;padding:10px;text-decoration:none;border-radius:5px;text-align:center;display:block;'>$name</a>";
}
echo "</div>";
echo "</div>";

// Step 5: Issue Identification
echo "<div style='background:#f8d7da;border:1px solid #f5c6cb;padding:20px;border-radius:10px;margin:20px 0;'>";
echo "<h3>🔍 Step 5: Issue Identification</h3>";
echo "<p><strong>What do you see when you say 'muncul begitu'? Answer these questions:</strong></p>";

$questions = [
    "1. Is the page completely blank (white screen)?",
    "2. Do you see an error message in red text?",
    "3. Are you redirected to the login page?",
    "4. Does the page load but looks broken (missing styles/images)?",
    "5. Do you see 'Access Denied' or similar message?",
    "6. Does only the header/footer load but main content missing?",
    "7. Do you see strange characters or encoding issues?",
    "8. Does the page load very slowly or timeout?"
];

echo "<ul style='line-height:1.8;'>";
foreach ($questions as $question) {
    echo "<li>$question <strong>YES/NO</strong></li>";
}
echo "</ul>";
echo "</div>";

// Step 6: Emergency Solutions
echo "<div style='background:#fff3cd;border:1px solid #ffeaa7;padding:20px;border-radius:10px;margin:20px 0;'>";
echo "<h3>🚨 Step 6: Emergency Solutions</h3>";

$solutions = [
    "If BLANK PAGE" => "Check browser developer tools (F12) → Console tab for errors",
    "If REDIRECTED" => "Login as admin first (username: joko, password: joko321)",
    "If BROKEN STYLES" => "CSS/JS files not loading - check internet connection",
    "If ACCESS DENIED" => "Session expired - login again",
    "If SLOW LOADING" => "Check if XAMPP Apache/MySQL are running",
    "If IMAGES MISSING" => "Image URLs might be broken - check network connection"
];

echo "<ul>";
foreach ($solutions as $problem => $solution) {
    echo "<li><strong>$problem:</strong> $solution</li>";
}
echo "</ul>";
echo "</div>";

// Step 7: Screenshot Instructions
echo "<div style='background:#e2e3e5;border:1px solid #d6d8db;padding:20px;border-radius:10px;margin:20px 0;'>";
echo "<h3>📸 Step 7: Screenshot Instructions</h3>";
echo "<p>If possible, please take a screenshot and describe:</p>";
echo "<ol>";
echo "<li>Press <strong>Windows Key + Shift + S</strong> (Windows) or <strong>Cmd + Shift + 4</strong> (Mac)</li>";
echo "<li>Select the problematic area</li>";
echo "<li>Save the screenshot</li>";
echo "<li>Describe what you see in the screenshot</li>";
echo "</ol>";
echo "<p><strong>Alternative:</strong> Press F12 → Go to Console tab → Copy any error messages you see</p>";
echo "</div>";

// Final Instructions
echo "<div style='background:#007bff;color:white;padding:20px;border-radius:10px;margin:20px 0;text-align:center;'>";
echo "<h3>🎯 FINAL STEP</h3>";
echo "<p style='font-size:18px;margin:10px 0;'><strong>Reply with answers to the questions above, or describe what you see!</strong></p>";
echo "<p style='margin:5px 0;'>Example: 'I see a blank white page' or 'I get redirected to login' or 'Page loads but images missing'</p>";
echo "</div>";
?>