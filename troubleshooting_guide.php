<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Troubleshooting Guide - Toko Sepatu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .step { margin: 20px 0; padding: 15px; border-left: 4px solid #007bff; background: #f8f9fa; }
        .error-symptom { background: #fff3cd; border: 1px solid #ffeaa7; padding: 10px; margin: 10px 0; border-radius: 5px; }
        .solution { background: #d1ecf1; border: 1px solid #bee5eb; padding: 10px; margin: 10px 0; border-radius: 5px; }
        .code-block { background: #f8f9fa; border: 1px solid #dee2e6; padding: 10px; border-radius: 5px; font-family: monospace; }
        .urgent { background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; margin: 15px 0; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">🔧 Complete Troubleshooting Guide</h1>
        <p class="lead text-center">Panduan lengkap mengatasi semua masalah sistem Toko Sepatu</p>

        <div class="urgent">
            <h4>🚨 SEBELUM MEMULAI:</h4>
            <p><strong>Pastikan XAMPP sudah running!</strong> (Apache dan MySQL harus hijau)</p>
            <p>Jika XAMPP mati, restart dan pastikan tidak ada program lain yang menggunakan port 80/443</p>
        </div>

        <!-- Step 1: Quick Diagnosis -->
        <div class="step">
            <h3>1️⃣ Quick Diagnosis (5 menit)</h3>
            <p>Jalankan tools diagnostik ini secara berurutan:</p>
            <div class="d-flex gap-2 flex-wrap">
                <a href="database_repair.php" class="btn btn-primary" target="_blank">🛠️ Database Repair</a>
                <a href="ultimate_solver.php" class="btn btn-success" target="_blank">🎯 Ultimate Solver</a>
                <a href="frontend_diagnostic.php" class="btn btn-info" target="_blank">🔍 Frontend Diagnostic</a>
                <a href="visual_diagnostic.php" class="btn btn-warning" target="_blank">👁️ Visual Diagnostic</a>
            </div>
            <p class="mt-2"><em>Tools ini akan mendeteksi dan memperbaiki masalah secara otomatis</em></p>
        </div>

        <!-- Common Symptoms and Solutions -->
        <h2 class="mt-5 mb-4">🔍 Masalah Umum & Solusi</h2>

        <!-- Symptom 1 -->
        <div class="error-symptom">
            <h4>❌ Halaman Putih/Kosong (Blank Page)</h4>
            <p><strong>Gejala:</strong> Browser menampilkan halaman kosong tanpa error</p>
        </div>
        <div class="solution">
            <h4>✅ Solusi:</h4>
            <ol>
                <li>Buka <code>php.ini</code> (di folder php XAMPP)</li>
                <li>Cari baris <code>display_errors = Off</code> dan ubah ke <code>On</code></li>
                <li>Restart Apache</li>
                <li>Atau gunakan tools diagnostik di atas</li>
            </ol>
        </div>

        <!-- Symptom 2 -->
        <div class="error-symptom">
            <h4>❌ "Muncul begitu" - Tidak jelas apa yang salah</h4>
            <p><strong>Gejala:</strong> Sistem tidak bekerja seperti yang diharapkan</p>
        </div>
        <div class="solution">
            <h4>✅ Solusi:</h4>
            <ol>
                <li>Jalankan semua 4 tools diagnostik di atas</li>
                <li>Periksa hasilnya dan ikuti rekomendasi</li>
                <li>Jika masih bingung, screenshot hasil tools dan kirim ke developer</li>
            </ol>
        </div>

        <!-- Symptom 3 -->
        <div class="error-symptom">
            <h4>❌ Tidak bisa login ke admin</h4>
            <p><strong>Gejala:</strong> Form login tidak merespons atau redirect ke halaman yang salah</p>
        </div>
        <div class="solution">
            <h4>✅ Solusi:</h4>
            <ol>
                <li>Username: <code>joko</code></li>
                <li>Password: <code>joko321</code></li>
                <li>Jika tidak bisa, jalankan Database Repair Tool</li>
                <li>Periksa apakah session sudah aktif</li>
            </ol>
        </div>

        <!-- Symptom 4 -->
        <div class="error-symptom">
            <h4>❌ Gambar tidak muncul</h4>
            <p><strong>Gejala:</strong> Produk tanpa gambar atau gambar error</p>
        </div>
        <div class="solution">
            <h4>✅ Solusi:</h4>
            <ol>
                <li>Pastikan folder <code>assets/img/</code> ada dan writable</li>
                <li>Untuk gambar URL: pastikan URL valid dan dapat diakses</li>
                <li>Untuk upload: periksa permission folder dan ukuran file</li>
                <li>Jalankan Ultimate Solver untuk auto-fix</li>
            </ol>
        </div>

        <!-- Symptom 5 -->
        <div class="error-symptom">
            <h4>❌ Database connection error</h4>
            <p><strong>Gejala:</strong> Error "Can't connect to MySQL" atau sejenisnya</p>
        </div>
        <div class="solution">
            <h4>✅ Solusi:</h4>
            <ol>
                <li>Pastikan MySQL di XAMPP sudah running (hijau)</li>
                <li>Periksa <code>config/config.php</code> - pastikan username/password benar</li>
                <li>Jalankan Database Repair Tool</li>
                <li>Default: host=localhost, user=root, password=(kosong)</li>
            </ol>
        </div>

        <!-- Step 2: Manual Checks -->
        <div class="step">
            <h3>2️⃣ Manual System Checks</h3>
            <p>Jika tools otomatis tidak cukup, periksa manual:</p>

            <h5>📁 File Structure Check:</h5>
            <div class="code-block">
Pastikan file-file ini ada:
/toko_sepatu/
├── index.php
├── login.php
├── home.php
├── config/
│   └── config.php
├── admin/
│   ├── products.php
│   └── tambah_produk.php
└── assets/
    └── img/
            </div>

            <h5>🗄️ Database Check:</h5>
            <div class="code-block">
phpMyAdmin → Database: toko_sepatu
Tables: produk, users, orders, order_items
            </div>

            <h5>🔐 Permission Check:</h5>
            <div class="code-block">
assets/img/ → 755 atau 777
config/config.php → 644
            </div>
        </div>

        <!-- Step 3: Browser Issues -->
        <div class="step">
            <h3>3️⃣ Browser & Cache Issues</h3>
            <p>Masalah sering disebabkan cache browser:</p>
            <ol>
                <li><strong>Hard Refresh:</strong> Ctrl+F5 (Windows) atau Cmd+Shift+R (Mac)</li>
                <li><strong>Clear Cache:</strong> Browser Settings → Clear browsing data</li>
                <li><strong>Incognito Mode:</strong> Coba buka di mode incognito</li>
                <li><strong>Different Browser:</strong> Coba browser lain (Chrome, Firefox, Edge)</li>
            </ol>
        </div>

        <!-- Step 4: XAMPP Issues -->
        <div class="step">
            <h3>4️⃣ XAMPP Troubleshooting</h3>
            <p>Jika XAMPP bermasalah:</p>

            <h5>🔴 Port Conflicts:</h5>
            <ol>
                <li>Stop XAMPP</li>
                <li>Buka Command Prompt sebagai Administrator</li>
                <li>Jalankan: <code>netstat -ano | findstr :80</code></li>
                <li>Jika ada process, kill dengan: <code>taskkill /PID [PID] /F</code></li>
                <li>Start XAMPP lagi</li>
            </ol>

            <h5>🟡 MySQL Won't Start:</h5>
            <ol>
                <li>Stop XAMPP</li>
                <li>Rename folder <code>xampp/mysql/data</code> ke <code>data_old</code></li>
                <li>Copy <code>xampp/mysql/backup</code> ke <code>data</code></li>
                <li>Start XAMPP</li>
            </ol>
        </div>

        <!-- Step 5: Advanced Fixes -->
        <div class="step">
            <h3>5️⃣ Advanced Fixes</h3>
            <p>Jika semua gagal, coba langkah advanced:</p>

            <h5>🔧 PHP Configuration:</h5>
            <div class="code-block">
php.ini changes:
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
display_errors = On
error_reporting = E_ALL
            </div>

            <h5>🗄️ Database Reset:</h5>
            <ol>
                <li>Backup data penting</li>
                <li>Drop database <code>toko_sepatu</code></li>
                <li>Jalankan <code>database_repair.php</code></li>
            </ol>
        </div>

        <!-- Emergency Contacts -->
        <div class="urgent">
            <h3>🚨 Emergency Actions</h3>
            <p><strong>Jika sistem benar-benar rusak:</strong></p>
            <ol>
                <li>Backup folder <code>toko_sepatu</code></li>
                <li>Delete folder <code>toko_sepatu</code></li>
                <li>Download ulang project dari GitHub</li>
                <li>Setup ulang dari awal</li>
                <li>Jalankan <code>setup.php</code></li>
            </ol>
        </div>

        <!-- Quick Access -->
        <div class="mt-5 p-4 bg-light rounded">
            <h3>🔗 Quick Access Links</h3>
            <div class="row">
                <div class="col-md-6">
                    <h5>Diagnostic Tools:</h5>
                    <ul>
                        <li><a href="database_repair.php">Database Repair</a></li>
                        <li><a href="ultimate_solver.php">Ultimate Solver</a></li>
                        <li><a href="frontend_diagnostic.php">Frontend Diagnostic</a></li>
                        <li><a href="visual_diagnostic.php">Visual Diagnostic</a></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h5>Main Pages:</h5>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="admin/products.php">Admin Products</a></li>
                        <li><a href="admin/tambah_produk.php">Add Product</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-5 text-muted">
            <p>📞 Jika semua solusi di atas tidak berhasil, berikan detail error spesifik yang muncul</p>
            <p>💡 Ingat: "Muncul begitu" terlalu samar - berikan screenshot atau pesan error yang tepat!</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>