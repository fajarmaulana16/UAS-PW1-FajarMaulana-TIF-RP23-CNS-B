<?php
session_start();
if (!isset($_SESSION["login"])) { header("Location: ../login.php"); exit; }
require '../config/config.php';

if (isset($_POST["submit"])) {
    $nama  = htmlspecialchars($_POST["nama"]);
    $merk  = htmlspecialchars($_POST["merk"]);
    $harga = htmlspecialchars($_POST["harga"]);
    $stok  = htmlspecialchars($_POST["stok"]);
    $foto_type = $_POST["foto_type"];

    $namaFileBaru = ""; // Initialize variable

    if ($foto_type === "upload") {
        // Logika Upload Gambar
        $namaFile   = $_FILES['foto']['name'];
        $ukuranFile = $_FILES['foto']['size'];
        $error      = $_FILES['foto']['error'];
        $tmpName    = $_FILES['foto']['tmp_name'];

        // Cek apakah ada gambar yang diupload
        if ($error === 4) {
            echo "<script>alert('Pilih gambar terlebih dahulu!');</script>";
            $namaFileBaru = "";
        } else {
            $ekstensiValid = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'];
            $ekstensiGambar = explode('.', $namaFile);
            $ekstensiGambar = strtolower(end($ekstensiGambar));

            if (!in_array($ekstensiGambar, $ekstensiValid)) {
                echo "<script>alert('Yang anda upload bukan gambar!');</script>";
                $namaFileBaru = "";
            } elseif ($ukuranFile > 2000000) { // Max 2MB
                echo "<script>alert('Ukuran gambar terlalu besar!');</script>";
                $namaFileBaru = "";
            } else {
                // Generate nama baru agar tidak duplikat
                $namaFileBaru = uniqid() . '.' . $ekstensiGambar;
                move_uploaded_file($tmpName, '../assets/img/' . $namaFileBaru);
            }
        }
    } elseif ($foto_type === "url") {
        // Logika URL Gambar
        $foto_url = trim($_POST["foto_url"]);

        if (empty($foto_url)) {
            echo "<script>alert('Masukkan URL gambar!');</script>";
            $namaFileBaru = "";
        } elseif (!filter_var($foto_url, FILTER_VALIDATE_URL)) {
            echo "<script>alert('URL tidak valid!');</script>";
            $namaFileBaru = "";
        } else {
            // Validasi ekstensi dari URL
            $path_info = pathinfo($foto_url);
            $ekstensi = strtolower($path_info['extension'] ?? '');

            if (!in_array($ekstensi, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'])) {
                echo "<script>alert('URL harus mengarah ke file gambar (jpg, jpeg, png, gif, webp, bmp, svg)!');</script>";
                $namaFileBaru = "";
            } else {
                // Simpan URL langsung
                $namaFileBaru = $foto_url;
            }
        }
    }

    // Insert ke Database hanya jika ada foto (baik upload maupun URL)
    if (!empty($namaFileBaru)) {
        $query = "INSERT INTO produk (nama, merk, harga, stok, foto)
                  VALUES ('$nama', '$merk', '$harga', '$stok', '$namaFileBaru')";

        if (mysqli_query($conn, $query)) {
            echo "<script>
                    alert('Data Berhasil Ditambahkan!');
                    window.location.href = 'products.php';
                  </script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Toko Sepatu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #212529 0%, #343a40 100%);
            color: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar h4 {
            background: linear-gradient(45deg, #ff6b6b, #feca57);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }
        .nav-link {
            color: rgba(255,255,255,.75);
            transition: all 0.3s ease;
            border-radius: 10px;
            margin: 2px 0;
        }
        .nav-link:hover {
            color: white;
            background: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }
        .nav-link.active {
            color: white;
            background: linear-gradient(45deg, #667eea, #764ba2);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        .main-content {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }
        .page-header h1 {
            font-weight: 700;
            margin: 0;
        }
        .form-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border: none;
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }
        .btn {
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        .btn:hover::before {
            left: 100%;
        }
        .btn-primary {
            background: linear-gradient(45deg, #ff6b6b, #feca57);
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.6);
        }
        .btn-secondary {
            background: linear-gradient(45deg, #6c757d, #495057);
        }
        .btn-secondary:hover {
            background: linear-gradient(45deg, #495057, #343a40);
            transform: translateY(-2px);
        }
        .file-upload {
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        .file-upload:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }
        .file-upload.dragover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }
        .preview-img {
            max-width: 200px;
            max-height: 200px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse p-3">
            <h4 class="text-center mb-4">Sneaker Hub</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link mb-2 rounded" href="index.php">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-2 rounded" href="products.php">
                        <i class="bi bi-box-seam me-2"></i> Data Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active mb-2 rounded" href="tambah_produk.php">
                        <i class="bi bi-plus-circle me-2"></i> Tambah Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-2 rounded" href="laporan_pdf.php" target="_blank">
                        <i class="bi bi-file-earmark-pdf me-2"></i> Laporan PDF
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-2 rounded" href="laporan_excel.php">
                        <i class="bi bi-file-earmark-excel me-2"></i> Laporan Excel
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-2 rounded" href="laporan_pdf_lengkap.php" target="_blank">
                        <i class="bi bi-file-earmark-pdf me-2"></i> Laporan PDF Lengkap
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-2 rounded" href="laporan_excel_lengkap.php">
                        <i class="bi bi-file-earmark-excel me-2"></i> Laporan Excel Lengkap
                    </a>
                </li>
                <hr>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="../logout.php">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="page-header" data-aos="fade-down">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1><i class="bi bi-plus-circle me-3"></i>Tambah Produk Baru</h1>
                        <p class="mb-0 mt-2">Tambahkan produk sepatu baru ke katalog</p>
                    </div>
                    <a href="products.php" class="btn btn-light">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Data Produk
                    </a>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
                    <div class="form-card">
                        <form action="" method="post" enctype="multipart/form-data" id="productForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label">
                                        <i class="bi bi-tag me-2"></i>Nama Sepatu
                                    </label>
                                    <input type="text" class="form-control" id="nama" name="nama" 
                                           placeholder="Masukkan nama sepatu" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="merk" class="form-label">
                                        <i class="bi bi-shop me-2"></i>Merk
                                    </label>
                                    <input type="text" class="form-control" id="merk" name="merk" 
                                           placeholder="Masukkan merk sepatu" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="harga" class="form-label">
                                        <i class="bi bi-cash me-2"></i>Harga (Rp)
                                    </label>
                                    <input type="number" class="form-control" id="harga" name="harga" 
                                           placeholder="0" min="0" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="stok" class="form-label">
                                        <i class="bi bi-boxes me-2"></i>Stok
                                    </label>
                                    <input type="number" class="form-control" id="stok" name="stok" 
                                           placeholder="0" min="0" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="bi bi-image me-2"></i>Foto Produk
                                </label>

                                <!-- Toggle antara Upload dan URL -->
                                <div class="mb-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="foto_type" id="upload_type" value="upload" checked>
                                        <label class="form-check-label" for="upload_type">
                                            Upload File
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="foto_type" id="url_type" value="url">
                                        <label class="form-check-label" for="url_type">
                                            URL Gambar
                                        </label>
                                    </div>
                                </div>

                                <!-- Upload File Section -->
                                <div id="upload_section">
                                    <div class="file-upload" id="fileUpload">
                                        <i class="bi bi-cloud-upload fs-1 text-muted mb-3"></i>
                                        <h5 class="text-muted">Upload Foto Produk</h5>
                                        <p class="text-muted small">Pilih file gambar (JPG, PNG, GIF, WebP, BMP, SVG, max 2MB)</p>
                                        <input type="file" class="form-control d-none" id="foto" name="foto"
                                               accept="image/*" onchange="previewImage(this)">
                                    </div>
                                    <img id="preview" class="preview-img d-none" alt="Preview">
                                </div>

                                <!-- URL Input Section -->
                                <div id="url_section" style="display: none;">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
                                        <input type="url" class="form-control" id="foto_url" name="foto_url"
                                               placeholder="https://example.com/image.jpg">
                                    </div>
                                    <div class="form-text">
                                        Masukkan URL lengkap gambar dari internet (JPG, PNG, GIF, WebP, BMP, SVG)
                                    </div>
                                    <img id="url_preview" class="preview-img d-none mt-2" alt="URL Preview" style="max-width: 300px;">
                                </div>
                            </div>

                            <div class="d-flex gap-3">
                                <button type="submit" name="submit" class="btn btn-primary flex-fill">
                                    <i class="bi bi-save me-2"></i>Simpan Produk
                                </button>
                                <a href="products.php" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-2"></i>Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({
    duration: 800,
    once: true,
    offset: 100
});

// Preview image function
function previewImage(input) {
    const preview = document.getElementById('preview');
    const fileUpload = document.getElementById('fileUpload');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            fileUpload.innerHTML = `
                <i class="bi bi-check-circle fs-1 text-success mb-3"></i>
                <h5 class="text-success">Foto berhasil dipilih!</h5>
                <p class="text-muted small">Klik untuk mengganti foto</p>
            `;
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// File upload area click handler
document.getElementById('fileUpload').addEventListener('click', function() {
    document.getElementById('foto').click();
});

// Drag and drop functionality
const fileUpload = document.getElementById('fileUpload');
const fileInput = document.getElementById('foto');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    fileUpload.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    fileUpload.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    fileUpload.addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    fileUpload.classList.add('dragover');
}

function unhighlight(e) {
    fileUpload.classList.remove('dragover');
}

fileUpload.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    
    if (files.length > 0) {
        fileInput.files = files;
        previewImage(fileInput);
    }
}

// Toggle antara Upload dan URL
document.querySelectorAll('input[name="foto_type"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const uploadSection = document.getElementById('upload_section');
        const urlSection = document.getElementById('url_section');
        const fileInput = document.getElementById('foto');
        const urlInput = document.getElementById('foto_url');

        if (this.value === 'upload') {
            uploadSection.style.display = 'block';
            urlSection.style.display = 'none';
            fileInput.required = true;
            urlInput.required = false;
            // Reset URL input
            urlInput.value = '';
            document.getElementById('url_preview').classList.add('d-none');
        } else {
            uploadSection.style.display = 'none';
            urlSection.style.display = 'block';
            fileInput.required = false;
            urlInput.required = true;
            // Reset file input
            fileInput.value = '';
            document.getElementById('preview').classList.add('d-none');
            document.getElementById('fileUpload').innerHTML = `
                <i class="bi bi-cloud-upload fs-1 text-muted mb-3"></i>
                <h5 class="text-muted">Upload Foto Produk</h5>
                <p class="text-muted small">Pilih file gambar (JPG, PNG, GIF, WebP, BMP, SVG, max 2MB)</p>
            `;
        }
    });
});

// Preview URL image
document.getElementById('foto_url').addEventListener('input', function() {
    const url = this.value.trim();
    const preview = document.getElementById('url_preview');

    if (url) {
        // Basic URL validation
        if (url.match(/\.(jpg|jpeg|png|gif|webp|bmp|svg)$/i)) {
            preview.src = url;
            preview.classList.remove('d-none');
            preview.onerror = function() {
                preview.classList.add('d-none');
                alert('URL gambar tidak dapat dimuat. Pastikan URL valid dan gambar dapat diakses.');
            };
        } else {
            preview.classList.add('d-none');
        }
    } else {
        preview.classList.add('d-none');
    }
});

// Format number input
document.getElementById('harga').addEventListener('input', function(e) {
    // Remove non-numeric characters except decimal point
    let value = e.target.value.replace(/[^\d.]/g, '');
    e.target.value = value;
});

document.getElementById('stok').addEventListener('input', function(e) {
    // Remove non-numeric characters
    let value = e.target.value.replace(/[^\d]/g, '');
    e.target.value = value;
});
</script>
</body>
</html>