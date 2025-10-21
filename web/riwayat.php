<?php
include 'config.php';
session_start();

// Proses hapus pesanan
if (isset($_GET['hapus'])) {
    $pesanan_id = intval($_GET['hapus']);
    
    // Mulai transaction untuk konsistensi data
    $conn->begin_transaction();
    
    try {
        // 1. Ambil detail pesanan untuk mengembalikan stok
        $sql_detail = "SELECT makanan_id, jumlah FROM detail_pesanan WHERE pesanan_id = $pesanan_id";
        $result_detail = $conn->query($sql_detail);
        
        if ($result_detail->num_rows > 0) {
            while ($detail = $result_detail->fetch_assoc()) {
                $makanan_id = $detail['makanan_id'];
                $jumlah = $detail['jumlah'];
                
                // Kembalikan stok
                $sql_update_stok = "UPDATE makanan SET stok = stok + $jumlah WHERE id = $makanan_id";
                $conn->query($sql_update_stok);
            }
        }
        
        // 2. Hapus detail pesanan
        $sql_delete_detail = "DELETE FROM detail_pesanan WHERE pesanan_id = $pesanan_id";
        $conn->query($sql_delete_detail);
        
        // 3. Hapus pesanan
        $sql_delete_pesanan = "DELETE FROM pesanan WHERE id = $pesanan_id";
        $conn->query($sql_delete_pesanan);
        
        // Commit transaction
        $conn->commit();
        $success = "Pesanan berhasil dihapus dan stok dikembalikan!";
        
    } catch (Exception $e) {
        // Rollback transaction jika error
        $conn->rollback();
        $error = "Error menghapus pesanan: " . $e->getMessage();
    }
    
    // Redirect untuk menghindari resubmit
    header("Location: riwayat.php?success=" . urlencode($success));
    exit();
}

// Proses ubah status pesanan
if (isset($_GET['ubah_status'])) {
    $pesanan_id = intval($_GET['ubah_status']);
    $status_baru = $conn->real_escape_string($_GET['status']);
    
    $sql = "UPDATE pesanan SET status = '$status_baru' WHERE id = $pesanan_id";
    if ($conn->query($sql) === TRUE) {
        $success = "Status pesanan berhasil diubah!";
    } else {
        $error = "Error mengubah status: " . $conn->error;
    }
    
    header("Location: riwayat.php?success=" . urlencode($success));
    exit();
}

// Ambil pesan success dari URL
if (isset($_GET['success'])) {
    $success = $_GET['success'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Kasir Makanan</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .riwayat-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        .riwayat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        .pesanan-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            position: relative;
        }
        .pesanan-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .pesanan-id {
            font-weight: bold;
            color: #ff6b6b;
            font-size: 1.2em;
        }
        .pesanan-tanggal {
            color: #666;
            font-size: 0.9em;
        }
        .pesanan-total {
            font-weight: bold;
            color: #28a745;
            font-size: 1.1em;
        }
        .pesanan-actions {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
        }
        .btn-hapus {
            padding: 5px 10px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 12px;
            border: none;
            cursor: pointer;
        }
        .btn-hapus:hover {
            background-color: #c82333;
        }
        .btn-selesai {
            padding: 5px 10px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 12px;
            border: none;
            cursor: pointer;
        }
        .btn-selesai:hover {
            background-color: #218838;
        }
        .btn-pending {
            padding: 5px 10px;
            background-color: #ffc107;
            color: black;
            text-decoration: none;
            border-radius: 4px;
            font-size: 12px;
            border: none;
            cursor: pointer;
        }
        .btn-pending:hover {
            background-color: #e0a800;
        }
        .pesanan-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .pesanan-items th {
            background-color: #f8f9fa;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #ddd;
            font-weight: bold;
        }
        .pesanan-items td {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
        }
        .pesanan-items tr:hover {
            background-color: #f8f9fa;
        }
        .empty-state {
            text-align: center;
            padding: 60px 40px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .empty-state h2 {
            color: #666;
            margin-bottom: 15px;
        }
        .empty-state p {
            color: #888;
            margin-bottom: 25px;
        }
        .btn-primary {
            padding: 12px 24px;
            background-color: #4ecdc4;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .btn-primary:hover {
            background-color: #45b7af;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: bold;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .total-row {
            background-color: #e9ecef;
            font-weight: bold;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-selesai {
            background-color: #d4edda;
            color: #155724;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="riwayat-container">
        <div class="riwayat-header">
            <h1>Riwayat Pesanan</h1>
            <div>
                <a href="index.php" style="margin-right: 15px; padding: 10px 15px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 4px;">Kembali ke Kasir</a>
                <a href="login.php" style="padding: 10px 15px; background-color: #4ecdc4; color: white; text-decoration: none; border-radius: 4px;">Admin</a>
            </div>
        </div>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php
        // Ambil data pesanan dari database
        $sql = "SELECT * FROM pesanan ORDER BY tanggal DESC";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($pesanan = $result->fetch_assoc()) {
                echo "<div class='pesanan-card'>";
                
                echo "<div class='pesanan-actions'>";
                // Tombol ubah status berdasarkan status saat ini
                if ($pesanan['status'] == 'pending') {
                    echo "<button class='btn-selesai' onclick=\"ubahStatus(" . $pesanan['id'] . ", 'selesai')\">Tandai Selesai</button>";
                } else {
                    echo "<button class='btn-pending' onclick=\"ubahStatus(" . $pesanan['id'] . ", 'pending')\">Tandai Pending</button>";
                }
                echo "<button class='btn-hapus' onclick=\"hapusPesanan(" . $pesanan['id'] . ")\">Hapus</button>";
                echo "</div>";
                
                echo "<div class='pesanan-header'>";
                echo "<div>";
                echo "<span class='pesanan-id'>Pesanan #" . $pesanan['id'] . "</span>";
                echo " - <span class='pesanan-tanggal'>" . date('d/m/Y H:i', strtotime($pesanan['tanggal'])) . "</span>";
                echo " <span class='status-badge status-" . $pesanan['status'] . "'>" . ucfirst($pesanan['status']) . "</span>";
                echo "</div>";
                echo "<div class='pesanan-total'>Rp " . number_format($pesanan['total'], 0, ',', '.') . "</div>";
                echo "</div>";
                
                // Ambil detail pesanan dengan query yang benar
                $pesanan_id = $pesanan['id'];
                $sql_detail = "SELECT d.*, m.nama, m.harga 
                               FROM detail_pesanan d 
                               JOIN makanan m ON d.makanan_id = m.id 
                               WHERE d.pesanan_id = $pesanan_id";
                $result_detail = $conn->query($sql_detail);
                
                if ($result_detail->num_rows > 0) {
                    echo "<table class='pesanan-items'>";
                    echo "<tr>
                            <th>Nama Makanan</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                          </tr>";
                    
                    $total_pesanan = 0;
                    while($detail = $result_detail->fetch_assoc()) {
                        // Gunakan harga dari tabel makanan, bukan menghitung ulang
                        $harga_satuan = $detail['harga'];
                        $subtotal = $detail['jumlah'] * $harga_satuan;
                        $total_pesanan += $subtotal;
                        
                        echo "<tr>
                                <td>" . htmlspecialchars($detail['nama']) . "</td>
                                <td>" . htmlspecialchars($detail['jumlah']) . "</td>
                                <td>Rp " . number_format($harga_satuan, 0, ',', '.') . "</td>
                                <td>Rp " . number_format($subtotal, 0, ',', '.') . "</td>
                              </tr>";
                    }
                    
                    echo "<tr class='total-row'>
                            <td colspan='3'><strong>Total Pesanan</strong></td>
                            <td><strong>Rp " . number_format($total_pesanan, 0, ',', '.') . "</strong></td>
                          </tr>";
                    
                    echo "</table>";
                }
                
                echo "</div>";
            }
        } else {
            echo "<div class='empty-state'>
                    <h2>Belum ada pesanan</h2>
                    <p>Silahkan melakukan pemesanan terlebih dahulu.</p>
                    <a href='index.php' class='btn-primary'>Pesan Sekarang</a>
                  </div>";
        }
        ?>
    </div>

    <script>
        function hapusPesanan(pesananId) {
            if (confirm('Apakah Anda yakin ingin menghapus pesanan #' + pesananId + '?\nStok makanan akan dikembalikan.')) {
                window.location.href = 'riwayat.php?hapus=' + pesananId;
            }
        }
        
        function ubahStatus(pesananId, statusBaru) {
            if (confirm('Apakah Anda yakin ingin mengubah status pesanan #' + pesananId + ' menjadi ' + statusBaru + '?')) {
                window.location.href = 'riwayat.php?ubah_status=' + pesananId + '&status=' + statusBaru;
            }
        }
        
        // Auto-hide success message after 5 seconds
        setTimeout(function() {
            const alert = document.querySelector('.alert-success');
            if (alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
        }, 5000);
    </script>
</body>
</html>
<?php
$conn->close();
?>