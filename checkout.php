<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'config/config.php';

$user_id = $_SESSION["user_id"];
$cart = query("SELECT cart.*, produk.nama, produk.harga, produk.stok FROM cart JOIN produk ON cart.produk_id = produk.id WHERE cart.user_id = $user_id");

if (empty($cart)) {
    header("Location: cart.php");
    exit;
}

// Hitung total
$total = 0;
foreach ($cart as $c) {
    $total += $c['harga'] * $c['jumlah'];
}

if (isset($_POST["checkout"])) {
    $nama = htmlspecialchars($_POST["nama"]);
    $alamat = htmlspecialchars($_POST["alamat"]);
    $telepon = htmlspecialchars($_POST["telepon"]);
    $payment_method = htmlspecialchars($_POST["payment_method"]);
    $selected_bank = isset($_POST["selected_bank"]) ? htmlspecialchars($_POST["selected_bank"]) : null;

    // Insert order
    $sql = "INSERT INTO orders (user_id, total, payment_method, selected_bank) VALUES ($user_id, $total, '$payment_method', " . ($selected_bank ? "'$selected_bank'" : "NULL") . ")";
    if (mysqli_query($conn, $sql)) {
        $order_id = mysqli_insert_id($conn);

        // Insert order items
        foreach ($cart as $c) {
            $produk_id = $c['produk_id'];
            $jumlah = $c['jumlah'];
            $harga = $c['harga'];
            mysqli_query($conn, "INSERT INTO order_items (order_id, produk_id, jumlah, harga) VALUES ($order_id, $produk_id, $jumlah, $harga)");

            // Update stok
            mysqli_query($conn, "UPDATE produk SET stok = stok - $jumlah WHERE id = $produk_id");
        }

        // Kosongkan cart
        mysqli_query($conn, "DELETE FROM cart WHERE user_id = $user_id");

        echo "<script>alert('Checkout berhasil!'); window.location.href = 'receipt.php?id=$order_id';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Toko Sepatu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .payment-methods {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            background: #f8f9fa;
        }
        .form-check-label {
            cursor: pointer;
            padding: 10px;
            border-radius: 6px;
            transition: background-color 0.3s;
        }
        .form-check-label:hover {
            background: rgba(0,123,255,0.1);
        }
        .payment-details {
            margin-top: 15px;
        }
        .alert {
            border-radius: 8px;
            border: none;
        }
        .alert-info {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            color: #0c5460;
        }
        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }
        .qris-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            position: relative;
            border: 2px solid #28a745;
            min-width: 240px;
            min-height: 240px;
        }
        #qris-qrcode {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
        }
        #qris-qrcode canvas {
            display: block;
            margin: 0 auto;
        }
        .qris-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }
        .qris-logo {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        .qris-text {
            font-size: 12px;
            font-weight: bold;
            color: #28a745;
        }
        #qris-canvas {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .qris-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="home.php">
            <i class="bi bi-shop me-2"></i>Sneaker Hub
        </a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="home.php">Home</a>
            <a class="nav-link" href="cart.php">Keranjang</a>
            <a class="nav-link" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2>Checkout</h2>
    <div class="row">
        <div class="col-md-8">
            <h4>Ringkasan Pesanan</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $c): ?>
                    <tr>
                        <td><?= $c['nama']; ?></td>
                        <td>Rp <?= number_format($c['harga']); ?></td>
                        <td><?= $c['jumlah']; ?></td>
                        <td>Rp <?= number_format($c['harga'] * $c['jumlah']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>Total: Rp <?= number_format($total); ?></h5>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Telepon</label>
                            <input type="text" name="telepon" class="form-control" required>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-credit-card me-2"></i>Metode Pembayaran</label>
                            <div class="payment-methods">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                                    <label class="form-check-label d-flex align-items-center" for="bank_transfer">
                                        <i class="bi bi-bank me-2"></i>
                                        <div>
                                            <strong>Bank Transfer</strong>
                                            <br><small class="text-muted">Transfer ke rekening bank pilihan Anda</small>
                                        </div>
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="payment_method" id="qris" value="qris" checked>
                                    <label class="form-check-label d-flex align-items-center" for="qris">
                                        <i class="bi bi-qr-code me-2"></i>
                                        <div>
                                            <strong>QRIS</strong>
                                            <br><small class="text-muted">Pembayaran via QR Code</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Bank Selection -->
                        <div id="bank-selection" class="mb-3" style="display: none;">
                            <label class="form-label">Pilih Bank Transfer</label>
                            <select name="selected_bank" class="form-select" id="selected_bank">
                                <option value="bca">🏦 BCA - Bank Central Asia</option>
                                <option value="mandiri">🏦 Mandiri - Bank Mandiri</option>
                                <option value="bni">🏦 BNI - Bank Negara Indonesia</option>
                                <option value="bri">🏦 BRI - Bank Rakyat Indonesia</option>
                                <option value="cimb">🏦 CIMB Niaga</option>
                                <option value="danamon">🏦 Danamon</option>
                                <option value="permata">🏦 Permata Bank</option>
                            </select>
                        </div>

                        <!-- Informasi Pembayaran -->
                        <div id="payment-info" class="mb-3">
                            <div id="bank-info" class="payment-details" style="display: none;">
                                <div class="alert alert-info">
                                    <h6><i class="bi bi-info-circle me-2"></i>Informasi Bank Transfer</h6>
                                    <div id="bank-details">
                                        <p class="mb-1"><strong id="bank-name">Bank BCA</strong></p>
                                        <p class="mb-1">No. Rekening: <strong id="bank-account">1234567890</strong></p>
                                        <p class="mb-1">Atas Nama: <strong id="bank-owner">PT. Sneaker Hub Indonesia</strong></p>
                                    </div>
                                    <hr>
                                    <p class="mb-0"><small>Silakan transfer sesuai nominal total dan konfirmasi pembayaran.</small></p>
                                </div>
                            </div>
                            <div id="qris-info" class="payment-details" style="display: block;">
                                <div class="alert alert-success">
                                    <h6><i class="bi bi-qr-code-scan me-2"></i>Informasi Pembayaran QRIS</h6>
                                    <p class="mb-2">Scan QR Code berikut untuk pembayaran:</p>
                                    <div class="text-center mb-3">
                                        <div id="qris-barcode" class="qris-container">
                                            <div id="qris-qrcode"></div>
                                            <div class="qris-overlay">
                                                <div class="qris-logo">
                                                    <div class="qris-text">QRIS</div>
                                                </div>
                                            </div>
                                            <div class="qris-text mt-2">
                                                <small class="text-muted">QRIS - Quick Response Code Indonesian Standard</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="qris-info mt-3">
                                        <div class="row text-center">
                                            <div class="col-4">
                                                <small class="text-muted">Merchant</small><br>
                                                <strong>Sneaker Hub</strong>
                                            </div>
                                            <div class="col-4">
                                                <small class="text-muted">Amount</small><br>
                                                <strong>Rp <?= number_format($total); ?></strong>
                                            </div>
                                            <div class="col-4">
                                                <small class="text-muted">Valid Until</small><br>
                                                <strong><?php echo date('d/m/Y', strtotime('+1 day')); ?></strong>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <p class="mb-0"><small>Gunakan aplikasi e-wallet atau mobile banking untuk scan QR code.</small></p>
                                </div>
                            </div>
                        </div>

                        <button type="submit" name="checkout" class="btn btn-success w-100">
                            <i class="bi bi-check-circle me-2"></i>Konfirmasi Pesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="qrcode.min.js"></script>
<script>
    // Bank information data
    const bankData = {
        bca: {
            name: "Bank BCA",
            account: "1234567890",
            owner: "PT. Sneaker Hub Indonesia"
        },
        mandiri: {
            name: "Bank Mandiri",
            account: "8876543210",
            owner: "PT. Sneaker Hub Indonesia"
        },
        bni: {
            name: "Bank BNI",
            account: "1122334455",
            owner: "PT. Sneaker Hub Indonesia"
        },
        bri: {
            name: "Bank BRI",
            account: "5566778899",
            owner: "PT. Sneaker Hub Indonesia"
        },
        cimb: {
            name: "CIMB Niaga",
            account: "9988776655",
            owner: "PT. Sneaker Hub Indonesia"
        },
        danamon: {
            name: "Danamon",
            account: "4433221100",
            owner: "PT. Sneaker Hub Indonesia"
        },
        permata: {
            name: "Permata Bank",
            account: "7788990011",
            owner: "PT. Sneaker Hub Indonesia"
        }
    };

    // Toggle payment method information
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const bankInfo = document.getElementById('bank-info');
            const qrisInfo = document.getElementById('qris-info');
            const bankSelection = document.getElementById('bank-selection');

            if (this.value === 'bank_transfer') {
                bankInfo.style.display = 'block';
                qrisInfo.style.display = 'none';
                bankSelection.style.display = 'block';
                updateBankInfo();
            } else if (this.value === 'qris') {
                bankInfo.style.display = 'none';
                qrisInfo.style.display = 'block';
                bankSelection.style.display = 'none';
                generateQRIS();
            }
        });
    });

    // Bank selection change
    document.getElementById('selected_bank').addEventListener('change', updateBankInfo);

    function updateBankInfo() {
        const selectedBank = document.getElementById('selected_bank').value;
        const bank = bankData[selectedBank];

        document.getElementById('bank-name').textContent = bank.name;
        document.getElementById('bank-account').textContent = bank.account;
        document.getElementById('bank-owner').textContent = bank.owner;
    }

    // Generate scannable QRIS code
    function generateQRIS() {
        // Clear previous QR code
        document.getElementById('qris-qrcode').innerHTML = '';

        // Get total amount
        const total = <?= $total ?>;

        // Generate QRIS data string (simplified format for demo)
        // In real implementation, this should follow proper QRIS specification
        const qrisData = `00020101021126580014ID.CO.QRIS.WWW0215ID1020000000000310303009TokoSepatu5204123453033605406${total.toString().padStart(12, '0')}5802ID5915Toko Sepatu Online6013Jakarta Pusat61051234562150111ORDER1234566304`;

        // Generate QR code
        new QRCode(document.getElementById('qris-qrcode'), {
            text: qrisData,
            width: 200,
            height: 200,
            colorDark: '#000000',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.M
        });
    }

    // Format phone number input
    document.querySelector('input[name="telepon"]').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = value;
    });

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        updateBankInfo();
        generateQRIS();
    });
</script>
</body>
</html>