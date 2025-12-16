<?php
require_once 'koneksi.php';

$paket = isset($_GET['paket']) ? $_GET['paket'] : '';
$harga_paket = isset($_GET['harga']) ? (int)$_GET['harga'] : 0;

// Harga layanan (sesuai spesifikasi)
$harga_penginapan = 1500000;
$harga_transportasi = 2500000;
$harga_service = 500000;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan - Raja Ampat</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .booking-section {
            padding: 80px 0;
            background: #f8f9fa;
        }
        
        .booking-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .form-group {
            flex: 1;
        }
        
        .calculation-box {
            background: #e8f6f3;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid #3498db;
        }
        
        .price-display {
            font-size: 1.2rem;
            font-weight: bold;
            color: #e74c3c;
            padding: 10px;
            background: white;
            border-radius: 5px;
            margin: 5px 0;
        }
        
        .error-message {
            color: #e74c3c;
            font-size: 0.9rem;
            margin-top: 5px;
            display: none;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <section class="booking-section">
        <div class="container">
            <h2 class="section-title">Form Pemesanan Paket Wisata</h2>
            
            <div class="booking-container">
                <h3 style="color: #1a5276; margin-bottom: 20px;">
                    <?php echo htmlspecialchars($paket); ?> - 
                    <span style="color: #e74c3c;">Rp <?php echo number_format($harga_paket, 0, ',', '.'); ?></span>
                </h3>
                
                <form id="bookingForm" action="proses_pesan.php" method="POST" onsubmit="return validateForm()">
                    <input type="hidden" name="paket" value="<?php echo htmlspecialchars($paket); ?>">
                    <input type="hidden" name="harga_paket" value="<?php echo $harga_paket; ?>">
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nama">Nama Pemesan *</label>
                            <input type="text" id="nama" name="nama" required>
                            <div class="error-message" id="nama-error">Nama harus diisi</div>
                        </div>
                        <div class="form-group">
                            <label for="nomor_hp">Nomor HP/Telepon *</label>
                            <input type="tel" id="nomor_hp" name="nomor_hp" required>
                            <div class="error-message" id="hp-error">Nomor HP harus diisi</div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="tanggal_pesan">Tanggal Pesan *</label>
                            <input type="date" id="tanggal_pesan" name="tanggal_pesan" required>
                            <div class="error-message" id="tglpesan-error">Tanggal pesan harus diisi</div>
                        </div>
                        <div class="form-group">
                            <label for="waktu_pelaksanaan">Waktu Pelaksanaan *</label>
                            <input type="date" id="waktu_pelaksanaan" name="waktu_pelaksanaan" required>
                            <div class="error-message" id="waktupel-error">Waktu pelaksanaan harus diisi</div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="jumlah_hari">Jumlah Hari *</label>
                            <input type="number" id="jumlah_hari" name="jumlah_hari" min="1" value="3" required onchange="calculateTotal()">
                            <div class="error-message" id="hari-error">Jumlah hari harus diisi</div>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_peserta">Jumlah Peserta *</label>
                            <input type="number" id="jumlah_peserta" name="jumlah_peserta" min="1" value="1" required onchange="calculateTotal()">
                            <div class="error-message" id="peserta-error">Jumlah peserta harus diisi</div>
                        </div>
                    </div>
                    
                    <h4 style="color: #1a5276; margin: 30px 0 15px;">Pilih Layanan Tambahan:</h4>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label style="display: flex; align-items: center;">
                                <input type="checkbox" id="penginapan" name="penginapan" value="1" onchange="calculateTotal()">
                                <span style="margin-left: 10px;">Penginapan (Rp <?php echo number_format($harga_penginapan, 0, ',', '.'); ?>)</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label style="display: flex; align-items: center;">
                                <input type="checkbox" id="transportasi" name="transportasi" value="1" onchange="calculateTotal()">
                                <span style="margin-left: 10px;">Transportasi (Rp <?php echo number_format($harga_transportasi, 0, ',', '.'); ?>)</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label style="display: flex; align-items: center;">
                                <input type="checkbox" id="service_makan" name="service_makan" value="1" onchange="calculateTotal()">
                                <span style="margin-left: 10px;">Service/Makan (Rp <?php echo number_format($harga_service, 0, ',', '.'); ?>)</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="calculation-box">
                        <h4>Perhitungan Harga:</h4>
                        <div class="price-display" id="harga-layanan">
                            Harga Layanan: Rp 0
                        </div>
                        <div class="price-display" id="harga-paket">
                            Harga Paket: Rp <?php echo number_format($harga_paket, 0, ',', '.'); ?>
                        </div>
                        <div class="price-display" id="harga-total">
                            Total Tagihan: Rp <?php echo number_format($harga_paket, 0, ',', '.'); ?>
                        </div>
                    </div>
                    
                    <input type="hidden" id="harga_paket_total" name="harga_paket_total" value="<?php echo $harga_paket; ?>">
                    <input type="hidden" id="jumlah_tagihan" name="jumlah_tagihan" value="<?php echo $harga_paket; ?>">
                    
                    <button type="submit" class="submit-btn" style="width: 100%; padding: 15px; font-size: 1.1rem;">
                        Konfirmasi Pemesanan
                    </button>
                </form>
            </div>
        </div>
    </section>

    <script>
        // Harga layanan (sesuai spesifikasi)
        const hargaPenginapan = <?php echo $harga_penginapan; ?>;
        const hargaTransportasi = <?php echo $harga_transportasi; ?>;
        const hargaService = <?php echo $harga_service; ?>;
        let hargaPaketDasar = <?php echo $harga_paket; ?>;
        
        function calculateTotal() {
            // Hitung harga layanan tambahan
            let totalLayanan = 0;
            
            if (document.getElementById('penginapan').checked) {
                totalLayanan += hargaPenginapan;
            }
            if (document.getElementById('transportasi').checked) {
                totalLayanan += hargaTransportasi;
            }
            if (document.getElementById('service_makan').checked) {
                totalLayanan += hargaService;
            }
            
            // Ambil nilai input
            const jumlahHari = parseInt(document.getElementById('jumlah_hari').value) || 0;
            const jumlahPeserta = parseInt(document.getElementById('jumlah_peserta').value) || 0;
            
            // Hitung total harga paket (dasar + layanan)
            const hargaPaketTotal = hargaPaketDasar + totalLayanan;
            
            // Hitung jumlah tagihan (sesuai spesifikasi)
            const jumlahTagihan = jumlahHari * jumlahPeserta * hargaPaketTotal;
            
            // Update display
            document.getElementById('harga-layanan').textContent = 
                'Harga Layanan: Rp ' + totalLayanan.toLocaleString('id-ID');
            document.getElementById('harga-paket').textContent = 
                'Harga Paket: Rp ' + hargaPaketTotal.toLocaleString('id-ID');
            document.getElementById('harga-total').textContent = 
                'Total Tagihan: Rp ' + jumlahTagihan.toLocaleString('id-ID');
            
            // Update hidden fields
            document.getElementById('harga_paket_total').value = hargaPaketTotal;
            document.getElementById('jumlah_tagihan').value = jumlahTagihan;
        }
        
        function validateForm() {
            let isValid = true;
            const inputs = document.querySelectorAll('#bookingForm input[required], #bookingForm select[required]');
            
            inputs.forEach(input => {
                const errorId = input.id + '-error';
                const errorElement = document.getElementById(errorId);
                
                if (!input.value.trim()) {
                    errorElement.style.display = 'block';
                    input.style.borderColor = '#e74c3c';
                    isValid = false;
                } else {
                    errorElement.style.display = 'none';
                    input.style.borderColor = '#ddd';
                }
            });
            
            return isValid;
        }
        
        // Inisialisasi perhitungan pertama kali
        document.addEventListener('DOMContentLoaded', calculateTotal);
    </script>
</body>
</html>