<?php
require_once 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $nomor_hp = mysqli_real_escape_string($conn, $_POST['nomor_hp']);
    $tanggal_pesan = $_POST['tanggal_pesan'];
    $waktu_pelaksanaan = $_POST['waktu_pelaksanaan'];
    $penginapan = isset($_POST['penginapan']) ? 1 : 0;
    $transportasi = isset($_POST['transportasi']) ? 1 : 0;
    $service_makan = isset($_POST['service_makan']) ? 1 : 0;
    $jumlah_peserta = (int)$_POST['jumlah_peserta'];
    $jumlah_hari = (int)$_POST['jumlah_hari'];
    $harga_paket = (int)$_POST['harga_paket_total'];
    $jumlah_tagihan = (int)$_POST['jumlah_tagihan'];
    $paket = mysqli_real_escape_string($conn, $_POST['paket']);
    
    // Validasi
    $errors = [];
    if (empty($nama)) $errors[] = "Nama harus diisi";
    if (empty($nomor_hp)) $errors[] = "Nomor HP harus diisi";
    if (empty($tanggal_pesan)) $errors[] = "Tanggal pesan harus diisi";
    if (empty($waktu_pelaksanaan)) $errors[] = "Waktu pelaksanaan harus diisi";
    if ($jumlah_peserta <= 0) $errors[] = "Jumlah peserta harus lebih dari 0";
    if ($jumlah_hari <= 0) $errors[] = "Jumlah hari harus lebih dari 0";
    
    if (empty($errors)) {
        // Insert ke database
        $sql = "INSERT INTO pesanan (nama_pemesan, nomor_hp, tanggal_pesan, waktu_pelaksanaan, 
                penginapan, transportasi, service_makan, jumlah_peserta, jumlah_hari, 
                harga_paket, jumlah_tagihan) 
                VALUES ('$nama', '$nomor_hp', '$tanggal_pesan', '$waktu_pelaksanaan', 
                $penginapan, $transportasi, $service_makan, $jumlah_peserta, $jumlah_hari, 
                $harga_paket, $jumlah_tagihan)";
        
        if (mysqli_query($conn, $sql)) {
            $success = true;
            $last_id = mysqli_insert_id($conn);
        } else {
            $errors[] = "Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Pemesanan</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .result-container {
            max-width: 800px;
            margin: 100px auto;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .success {
            color: #27ae60;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        
        .error {
            color: #e74c3c;
            margin-bottom: 20px;
        }
        
        .booking-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: left;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="result-container">
        <?php if (isset($success) && $success): ?>
            <div class="success">✅ Pemesanan Berhasil!</div>
            <div class="booking-details">
                <h3>Detail Pemesanan:</h3>
                <p><strong>ID Pesanan:</strong> <?php echo $last_id; ?></p>
                <p><strong>Nama:</strong> <?php echo htmlspecialchars($nama); ?></p>
                <p><strong>Paket:</strong> <?php echo htmlspecialchars($paket); ?></p>
                <p><strong>Tanggal Pelaksanaan:</strong> <?php echo $waktu_pelaksanaan; ?></p>
                <p><strong>Jumlah Peserta:</strong> <?php echo $jumlah_peserta; ?> orang</p>
                <p><strong>Jumlah Hari:</strong> <?php echo $jumlah_hari; ?> hari</p>
                <p><strong>Total Tagihan:</strong> Rp <?php echo number_format($jumlah_tagihan, 0, ',', '.'); ?></p>
                <p><strong>Layanan:</strong> 
                    <?php 
                    $layanan = [];
                    if ($penginapan) $layanan[] = "Penginapan";
                    if ($transportasi) $layanan[] = "Transportasi";
                    if ($service_makan) $layanan[] = "Service/Makan";
                    echo empty($layanan) ? "Tidak ada layanan tambahan" : implode(", ", $layanan);
                    ?>
                </p>
            </div>
            <div style="margin-top: 30px;">
                <a href="index.php" class="cta-btn" style="margin-right: 10px;">Kembali ke Beranda</a>
                <a href="modifikasi_pesanan.php" class="cta-btn" style="background: #2c3e50;">Lihat Daftar Pesanan</a>
            </div>
        <?php else: ?>
            <div class="error">❌ Pemesanan Gagal!</div>
            <?php if (!empty($errors)): ?>
                <div class="booking-details">
                    <h3>Error:</h3>
                    <ul style="color: #e74c3c; text-align: left;">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div style="margin-top: 30px;">
                <a href="javascript:history.back()" class="cta-btn">Kembali ke Form</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
mysqli_close($conn);
?>