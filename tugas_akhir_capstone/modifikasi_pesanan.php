<?php
require_once 'koneksi.php';

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $sql = "DELETE FROM pesanan WHERE id = $id";
    mysqli_query($conn, $sql);
}

// Handle edit form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = (int)$_POST['id'];
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
    
    $sql = "UPDATE pesanan SET 
            nama_pemesan = '$nama',
            nomor_hp = '$nomor_hp',
            tanggal_pesan = '$tanggal_pesan',
            waktu_pelaksanaan = '$waktu_pelaksanaan',
            penginapan = $penginapan,
            transportasi = $transportasi,
            service_makan = $service_makan,
            jumlah_peserta = $jumlah_peserta,
            jumlah_hari = $jumlah_hari,
            harga_paket = $harga_paket,
            jumlah_tagihan = $jumlah_tagihan
            WHERE id = $id";
    
    mysqli_query($conn, $sql);
}

// Get all orders
$sql = "SELECT * FROM pesanan ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

// Check if editing
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $edit_sql = "SELECT * FROM pesanan WHERE id = $edit_id";
    $edit_result = mysqli_query($conn, $edit_sql);
    if ($edit_result && mysqli_num_rows($edit_result) > 0) {
        $edit_data = mysqli_fetch_assoc($edit_result);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifikasi Pesanan</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-section {
            padding: 80px 0;
            background: #f8f9fa;
            min-height: 100vh;
        }
        
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .orders-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .orders-table th, .orders-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .orders-table th {
            background: #1a5276;
            color: white;
            position: sticky;
            top: 0;
        }
        
        .orders-table tr:hover {
            background: #f5f5f5;
        }
        
        .action-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 5px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .edit-btn {
            background: #3498db;
            color: white;
        }
        
        .delete-btn {
            background: #e74c3c;
            color: white;
        }
        
        .edit-btn:hover {
            background: #2980b9;
        }
        
        .delete-btn:hover {
            background: #c0392b;
        }
        
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <section class="admin-section">
        <div class="container">
            <h2 class="section-title">Kelola Pesanan</h2>
            
            <div class="admin-container">
                <?php if ($edit_data): ?>
                    <!-- Edit Form -->
                    <h3>Edit Pesanan #<?php echo $edit_data['id']; ?></h3>
                    <form method="POST" action="" style="margin-top: 20px;">
                        <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
                        <input type="hidden" name="update" value="1">
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div>
                                <label>Nama Pemesan</label>
                                <input type="text" name="nama" value="<?php echo htmlspecialchars($edit_data['nama_pemesan']); ?>" required style="width: 100%; padding: 10px; margin-top: 5px;">
                            </div>
                            <div>
                                <label>Nomor HP</label>
                                <input type="tel" name="nomor_hp" value="<?php echo htmlspecialchars($edit_data['nomor_hp']); ?>" required style="width: 100%; padding: 10px; margin-top: 5px;">
                            </div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div>
                                <label>Tanggal Pesan</label>
                                <input type="date" name="tanggal_pesan" value="<?php echo $edit_data['tanggal_pesan']; ?>" required style="width: 100%; padding: 10px; margin-top: 5px;">
                            </div>
                            <div>
                                <label>Waktu Pelaksanaan</label>
                                <input type="date" name="waktu_pelaksanaan" value="<?php echo $edit_data['waktu_pelaksanaan']; ?>" required style="width: 100%; padding: 10px; margin-top: 5px;">
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 10px;">Layanan Tambahan:</label>
                            <div style="display: flex; gap: 20px;">
                                <label>
                                    <input type="checkbox" name="penginapan" value="1" <?php echo $edit_data['penginapan'] ? 'checked' : ''; ?>>
                                    Penginapan
                                </label>
                                <label>
                                    <input type="checkbox" name="transportasi" value="1" <?php echo $edit_data['transportasi'] ? 'checked' : ''; ?>>
                                    Transportasi
                                </label>
                                <label>
                                    <input type="checkbox" name="service_makan" value="1" <?php echo $edit_data['service_makan'] ? 'checked' : ''; ?>>
                                    Service/Makan
                                </label>
                            </div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div>
                                <label>Jumlah Peserta</label>
                                <input type="number" name="jumlah_peserta" value="<?php echo $edit_data['jumlah_peserta']; ?>" min="1" required style="width: 100%; padding: 10px; margin-top: 5px;">
                            </div>
                            <div>
                                <label>Jumlah Hari</label>
                                <input type="number" name="jumlah_hari" value="<?php echo $edit_data['jumlah_hari']; ?>" min="1" required style="width: 100%; padding: 10px; margin-top: 5px;">
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 20px;">
                            <label>Harga Paket (Termasuk Layanan)</label>
                            <input type="number" name="harga_paket_total" value="<?php echo $edit_data['harga_paket']; ?>" required style="width: 100%; padding: 10px; margin-top: 5px;">
                        </div>
                        
                        <div style="margin-bottom: 20px;">
                            <label>Jumlah Tagihan</label>
                            <input type="number" name="jumlah_tagihan" value="<?php echo $edit_data['jumlah_tagihan']; ?>" required style="width: 100%; padding: 10px; margin-top: 5px;">
                            <small>Jumlah Tagihan = Hari × Peserta × Harga Paket</small>
                        </div>
                        
                        <div style="display: flex; gap: 10px; margin-top: 30px;">
                            <button type="submit" class="action-btn edit-btn" style="flex: 1;">Simpan Perubahan</button>
                            <a href="modifikasi_pesanan.php" class="action-btn delete-btn" style="flex: 1; text-align: center; text-decoration: none;">Batal</a>
                        </div>
                    </form>
                    
                <?php else: ?>
                    <!-- Orders Table -->
                    <h3>Daftar Semua Pesanan</h3>
                    
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <div style="overflow-x: auto;">
                            <table class="orders-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Pemesan</th>
                                        <th>Nomor HP</th>
                                        <th>Tanggal Pesan</th>
                                        <th>Pelaksanaan</th>
                                        <th>Peserta</th>
                                        <th>Hari</th>
                                        <th>Tagihan</th>
                                        <th>Layanan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo htmlspecialchars($row['nama_pemesan']); ?></td>
                                        <td><?php echo htmlspecialchars($row['nomor_hp']); ?></td>
                                        <td><?php echo $row['tanggal_pesan']; ?></td>
                                        <td><?php echo $row['waktu_pelaksanaan']; ?></td>
                                        <td><?php echo $row['jumlah_peserta']; ?> orang</td>
                                        <td><?php echo $row['jumlah_hari']; ?> hari</td>
                                        <td>Rp <?php echo number_format($row['jumlah_tagihan'], 0, ',', '.'); ?></td>
                                        <td>
                                            <?php 
                                            $layanan = [];
                                            if ($row['penginapan']) $layanan[] = "Hotel";
                                            if ($row['transportasi']) $layanan[] = "Transport";
                                            if ($row['service_makan']) $layanan[] = "Makan";
                                            echo implode(", ", $layanan);
                                            ?>
                                        </td>
                                        <td>
                                            <a href="modifikasi_pesanan.php?edit=<?php echo $row['id']; ?>" class="action-btn edit-btn">Edit</a>
                                            <button onclick="confirmDelete(<?php echo $row['id']; ?>)" class="action-btn delete-btn">Hapus</button>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p style="text-align: center; padding: 40px; color: #666;">
                            Belum ada pesanan. <a href="index.php">Buat pesanan pertama</a>
                        </p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <script>
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus pesanan ini?')) {
                window.location.href = 'modifikasi_pesanan.php?delete=' + id;
            }
        }
        
        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-overlay')) {
                window.location.href = 'modifikasi_pesanan.php';
            }
        });
    </script>
</body>
</html>
<?php
mysqli_close($conn);
?>