<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'config/config.php';

$order_id = $_GET["id"];
$user_id = $_SESSION["user_id"];

// Pastikan order milik user
$order = query("SELECT * FROM orders WHERE id = $order_id AND user_id = $user_id")[0];
if (!$order) {
    header("Location: home.php");
    exit;
}

$order_items = query("SELECT order_items.*, produk.nama FROM order_items JOIN produk ON order_items.produk_id = produk.id WHERE order_items.order_id = $order_id");

// Jika download PDF
if (isset($_GET["pdf"])) {
    if (!file_exists('lib/fpdf.php')) {
        die('FPDF library tidak ditemukan. Download dari https://www.fpdf.org/ dan letakkan di lib/fpdf.php');
    }
    require 'lib/fpdf.php';
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Struk Pembelian - Sneaker Hub', 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'ID Pesanan: #' . $order['id'], 0, 1);
    $pdf->Cell(0, 10, 'Tanggal: ' . date('d-m-Y H:i', strtotime($order['created_at'])), 0, 1);
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(80, 10, 'Produk', 1);
    $pdf->Cell(30, 10, 'Jumlah', 1);
    $pdf->Cell(40, 10, 'Harga', 1);
    $pdf->Cell(40, 10, 'Subtotal', 1);
    $pdf->Ln();
    $pdf->SetFont('Arial', '', 12);
    foreach ($order_items as $item) {
        $pdf->Cell(80, 10, $item['nama'], 1);
        $pdf->Cell(30, 10, $item['jumlah'], 1);
        $pdf->Cell(40, 10, 'Rp ' . number_format($item['harga']), 1);
        $pdf->Cell(40, 10, 'Rp ' . number_format($item['harga'] * $item['jumlah']), 1);
        $pdf->Ln();
    }
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(150, 10, 'Total:', 1);
    $pdf->Cell(40, 10, 'Rp ' . number_format($order['total']), 1);
    $pdf->Output('D', 'Struk_Order_' . $order_id . '.pdf');
    exit;
}

// Jika download Excel
if (isset($_GET["excel"])) {
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Struk_Order_" . $order_id . "_" . date('d-m-Y') . ".xls");
    ?>
    <table border="1">
        <tr>
            <th colspan="4">Struk Pembelian - Sneaker Hub</th>
        </tr>
        <tr>
            <td>ID Pesanan:</td>
            <td colspan="3">#<?= $order['id']; ?></td>
        </tr>
        <tr>
            <td>Tanggal:</td>
            <td colspan="3"><?= date('d-m-Y H:i', strtotime($order['created_at'])); ?></td>
        </tr>
        <tr>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach ($order_items as $item): ?>
        <tr>
            <td><?= $item['nama']; ?></td>
            <td><?= $item['jumlah']; ?></td>
            <td>Rp <?= number_format($item['harga']); ?></td>
            <td>Rp <?= number_format($item['harga'] * $item['jumlah']); ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" style="text-align: right; font-weight: bold;">Total:</td>
            <td style="font-weight: bold;">Rp <?= number_format($order['total']); ?></td>
        </tr>
    </table>
    <?php
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian - Toko Sepatu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .receipt { max-width: 600px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; }
        @media print { .no-print { display: none; } }
        .qris-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 15px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: relative;
            border: 2px solid #28a745;
            min-width: 180px;
            min-height: 180px;
        }
        #receipt-qris-qrcode {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
        }
        #receipt-qris-qrcode canvas {
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
            width: 30px;
            height: 30px;
            background: white;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        .qris-text {
            font-size: 10px;
            font-weight: bold;
            color: #28a745;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="receipt bg-white p-4 shadow">
        <h2 class="text-center mb-4">Struk Pembelian</h2>
        <h5 class="text-center">Sneaker Hub</h5>
        <p class="text-center">ID Pesanan: #<?= $order['id']; ?></p>
        <p class="text-center">Tanggal: <?= date('d-m-Y H:i', strtotime($order['created_at'])); ?></p>

        <!-- Informasi Metode Pembayaran -->
        <div class="text-center mb-3">
            <div class="alert alert-info d-inline-block">
                <strong>Metode Pembayaran:</strong>
                <?php if ($order['payment_method'] == 'bank_transfer'): ?>
                    <i class="bi bi-bank me-2"></i>Bank Transfer
                    <?php if ($order['selected_bank']): ?>
                        <br><small>(<?php
                        $bank_names = [
                            'bca' => 'BCA',
                            'mandiri' => 'Mandiri',
                            'bni' => 'BNI',
                            'bri' => 'BRI',
                            'cimb' => 'CIMB Niaga',
                            'danamon' => 'Danamon',
                            'permata' => 'Permata Bank'
                        ];
                        echo $bank_names[$order['selected_bank']] ?? ucfirst($order['selected_bank']);
                        ?>)</small>
                    <?php endif; ?>
                <?php elseif ($order['payment_method'] == 'qris'): ?>
                    <i class="bi bi-qr-code me-2"></i>QRIS
                <?php else: ?>
                    <i class="bi bi-cash me-2"></i><?php echo ucfirst(str_replace('_', ' ', $order['payment_method'])); ?>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($order['payment_method'] == 'bank_transfer'): ?>
        <div class="alert alert-warning text-center">
            <h6><i class="bi bi-info-circle me-2"></i>Informasi Pembayaran Bank Transfer</h6>
            <?php
            $bank_info = [
                'bca' => ['name' => 'Bank BCA', 'account' => '1234567890'],
                'mandiri' => ['name' => 'Bank Mandiri', 'account' => '8876543210'],
                'bni' => ['name' => 'Bank BNI', 'account' => '1122334455'],
                'bri' => ['name' => 'Bank BRI', 'account' => '5566778899'],
                'cimb' => ['name' => 'CIMB Niaga', 'account' => '9988776655'],
                'danamon' => ['name' => 'Danamon', 'account' => '4433221100'],
                'permata' => ['name' => 'Permata Bank', 'account' => '7788990011']
            ];
            $selected_bank = $order['selected_bank'] ?? 'bca';
            $bank = $bank_info[$selected_bank] ?? $bank_info['bca'];
            ?>
            <p class="mb-1"><strong><?php echo $bank['name']; ?></strong></p>
            <p class="mb-1">No. Rekening: <strong><?php echo $bank['account']; ?></strong></p>
            <p class="mb-1">Atas Nama: <strong>PT. Sneaker Hub Indonesia</strong></p>
            <p class="mb-1">Total Pembayaran: <strong>Rp <?= number_format($order['total']); ?></strong></p>
            <hr>
            <p class="mb-0"><small>Silakan transfer sesuai nominal di atas dan konfirmasi pembayaran.</small></p>
        </div>
        <?php elseif ($order['payment_method'] == 'qris'): ?>
        <div class="alert alert-success text-center">
            <h6><i class="bi bi-qr-code-scan me-2"></i>Informasi Pembayaran QRIS</h6>
            <p class="mb-2">Pembayaran telah dipilih via QRIS</p>
            <p class="mb-1">Total Pembayaran: <strong>Rp <?= number_format($order['total']); ?></strong></p>
            <div class="text-center mb-2">
                <div class="qris-container">
                    <div id="receipt-qris-qrcode"></div>
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
            <hr>
            <p class="mb-0"><small>Pembayaran via QRIS telah dipilih. Silakan lakukan pembayaran menggunakan aplikasi e-wallet.</small></p>
        </div>
        <?php endif; ?>

        <hr>
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_items as $item): ?>
                <tr>
                    <td><?= $item['nama']; ?></td>
                    <td><?= $item['jumlah']; ?></td>
                    <td>Rp <?= number_format($item['harga']); ?></td>
                    <td>Rp <?= number_format($item['harga'] * $item['jumlah']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total:</th>
                    <th>Rp <?= number_format($order['total']); ?></th>
                </tr>
            </tfoot>
        </table>
        <hr>
        <p class="text-center">Terima kasih telah berbelanja di Sneaker Hub!</p>
        <div class="text-center no-print">
            <a href="receipt.php?id=<?= $order_id; ?>&pdf=1" class="btn btn-danger">Download PDF</a>
            <a href="receipt.php?id=<?= $order_id; ?>&excel=1" class="btn btn-success">Download Excel</a>
            <button onclick="window.print()" class="btn btn-primary">Cetak Struk</button>
            <a href="home.php" class="btn btn-secondary">Kembali ke Home</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="qrcode.min.js"></script>
<script>
    // Generate scannable QRIS code for receipt
    function generateReceiptQRIS() {
        const qrisElement = document.getElementById('receipt-qris-qrcode');
        if (!qrisElement) return;

        // Clear previous QR code
        qrisElement.innerHTML = '';

        // Get order total
        const total = <?= $order['total'] ?>;

        // Generate QRIS data string (simplified format for demo)
        // In real implementation, this should follow proper QRIS specification
        const qrisData = `00020101021126580014ID.CO.QRIS.WWW0215ID1020000000000310303009TokoSepatu5204123453033605406${total.toString().padStart(12, '0')}5802ID5915Toko Sepatu Online6013Jakarta Pusat61051234562150111ORDER<?= $order_id ?>6304`;

        // Generate QR code
        new QRCode(qrisElement, {
            text: qrisData,
            width: 150,
            height: 150,
            colorDark: '#000000',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.M
        });
    }

    // Initialize QRIS when page loads
    document.addEventListener('DOMContentLoaded', function() {
        generateReceiptQRIS();
    });
</script>
</body>
</html>