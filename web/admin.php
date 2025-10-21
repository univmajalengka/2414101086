<?php
include 'config.php';
session_start();

// Redirect ke login jika bukan admin
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Buat folder uploads jika belum ada
$upload_dir = "uploads/";
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Proses tambah makanan
if (isset($_POST['tambah_makanan'])) {
    $nama = $conn->real_escape_string($_POST['nama']);
    $harga = floatval($_POST['harga']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $stok = intval($_POST['stok']);
    $gambar = ''; // Default kosong

    // Upload gambar jika ada
    if (!empty($_FILES['gambar']['name']) && $_FILES['gambar']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024; // 2MB
        
        $file_type = $_FILES['gambar']['type'];
        $file_size = $_FILES['gambar']['size'];
        
        // Validasi tipe file
        if (!in_array($file_type, $allowed_types)) {
            $error = "Tipe file tidak didukung. Gunakan JPG, JPEG, PNG, atau GIF.";
        } 
        // Validasi ukuran file
        elseif ($file_size > $max_size) {
            $error = "Ukuran file terlalu besar. Maksimal 2MB.";
        } 
        else {
            $file_extension = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '_' . time() . '.' . $file_extension;
            $target_file = $upload_dir . $filename;
            
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
                $gambar = $target_file;
            } else {
                $error = "Gagal mengupload gambar.";
            }
        }
    }

    // Jika tidak ada error, simpan ke database
    if (!isset($error)) {
        if ($gambar == '') {
            $sql = "INSERT INTO makanan (nama, harga, deskripsi, stok) 
                    VALUES ('$nama', $harga, '$deskripsi', $stok)";
        } else {
            $sql = "INSERT INTO makanan (nama, harga, deskripsi, stok, gambar) 
                    VALUES ('$nama', $harga, '$deskripsi', $stok, '$gambar')";
        }
        
        if ($conn->query($sql) === TRUE) {
            $success = "Makanan berhasil ditambahkan!";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}

// Proses edit makanan
if (isset($_POST['edit_makanan'])) {
    $id = intval($_POST['edit_id']);
    $nama = $conn->real_escape_string($_POST['edit_nama']);
    $harga = floatval($_POST['edit_harga']);
    $deskripsi = $conn->real_escape_string($_POST['edit_deskripsi']);
    $stok = intval($_POST['edit_stok']);
    $gambar = $_POST['gambar_lama']; // Default gunakan gambar lama

    // Upload gambar baru jika ada
    if (!empty($_FILES['edit_gambar']['name']) && $_FILES['edit_gambar']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024; // 2MB
        
        $file_type = $_FILES['edit_gambar']['type'];
        $file_size = $_FILES['edit_gambar']['size'];
        
        // Validasi tipe file
        if (!in_array($file_type, $allowed_types)) {
            $error = "Tipe file tidak didukung. Gunakan JPG, JPEG, PNG, atau GIF.";
        } 
        // Validasi ukuran file
        elseif ($file_size > $max_size) {
            $error = "Ukuran file terlalu besar. Maksimal 2MB.";
        } 
        else {
            $file_extension = pathinfo($_FILES['edit_gambar']['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '_' . time() . '.' . $file_extension;
            $target_file = $upload_dir . $filename;
            
            if (move_uploaded_file($_FILES['edit_gambar']['tmp_name'], $target_file)) {
                // Hapus gambar lama jika ada
                if (!empty($_POST['gambar_lama']) && file_exists($_POST['gambar_lama'])) {
                    unlink($_POST['gambar_lama']);
                }
                $gambar = $target_file;
            } else {
                $error = "Gagal mengupload gambar.";
            }
        }
    }

    // Jika tidak ada error, update database
    if (!isset($error)) {
        $sql = "UPDATE makanan SET 
                nama = '$nama', 
                harga = $harga, 
                deskripsi = '$deskripsi', 
                stok = $stok, 
                gambar = '$gambar' 
                WHERE id = $id";
        
        if ($conn->query($sql) === TRUE) {
            $success = "Makanan berhasil diupdate!";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}

// Proses hapus makanan
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    
    // Ambil data gambar sebelum hapus
    $sql_select = "SELECT gambar FROM makanan WHERE id = $id";
    $result = $conn->query($sql_select);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Hapus file gambar jika ada
        if (!empty($row['gambar']) && file_exists($row['gambar'])) {
            unlink($row['gambar']);
        }
    }
    
    $sql = "DELETE FROM makanan WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        $success = "Makanan berhasil dihapus!";
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Ambil data makanan untuk ditampilkan
$sql = "SELECT * FROM makanan ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kasir Makanan</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        .admin-nav a {
            margin-right: 15px;
            text-decoration: none;
            color: #4ecdc4;
            font-weight: bold;
        }
        .form-tambah, .form-edit {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            border-left: 4px solid #4ecdc4;
        }
        .form-edit {
            border-left-color: #ffa726;
            display: none;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        .form-group input:focus, .form-group textarea:focus {
            outline: none;
            border-color: #4ecdc4;
        }
        .btn-tambah, .btn-edit {
            padding: 12px 25px;
            background: #4ecdc4;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: background 0.3s;
        }
        .btn-edit {
            background: #ffa726;
        }
        .btn-tambah:hover {
            background: #45b7af;
        }
        .btn-edit:hover {
            background: #f57c00;
        }
        .btn-batal {
            padding: 12px 25px;
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            margin-left: 10px;
            transition: background 0.3s;
        }
        .btn-batal:hover {
            background: #5a6268;
        }
        .daftar-makanan {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .makanan-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
            border-bottom: 1px solid #eee;
            gap: 20px;
            transition: background 0.3s;
        }
        .makanan-item:hover {
            background: #f8f9fa;
        }
        .makanan-item:last-child {
            border-bottom: none;
        }
        .makanan-info {
            flex: 1;
        }
        .makanan-info h3 {
            margin-bottom: 10px;
            color: #333;
            font-size: 1.3em;
        }
        .makanan-info p {
            margin-bottom: 5px;
            color: #666;
        }
        .makanan-gambar {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #ddd;
        }
        .makanan-actions {
            display: flex;
            gap: 10px;
        }
        .btn-edit-item {
            padding: 8px 15px;
            background: #ffa726;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 13px;
            transition: background 0.3s;
        }
        .btn-edit-item:hover {
            background: #f57c00;
        }
        .btn-hapus {
            padding: 8px 15px;
            background: #ff6b6b;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 13px;
            transition: background 0.3s;
        }
        .btn-hapus:hover {
            background: #e55a5a;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            font-weight: 600;
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
        .empty-admin {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        .file-info {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        .no-image-admin {
            width: 120px;
            height: 120px;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            color: #999;
            font-size: 12px;
            text-align: center;
        }
        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Admin Panel - Kasir Makanan</h1>
            <div class="admin-nav">
                <a href="index.php">Kembali ke Kasir</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Form Tambah Makanan -->
        <div class="form-tambah">
            <h2>➕ Tambah Makanan Baru</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nama">Nama Makanan</label>
                    <input type="text" id="nama" name="nama" required placeholder="Masukkan nama makanan">
                </div>
                <div class="form-group">
                    <label for="harga">Harga (Rp)</label>
                    <input type="number" id="harga" name="harga" min="0" required placeholder="Masukkan harga">
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3" required placeholder="Masukkan deskripsi makanan"></textarea>
                </div>
                <div class="form-group">
                    <label for="stok">Stok</label>
                    <input type="number" id="stok" name="stok" min="0" required placeholder="Masukkan jumlah stok">
                </div>
                <div class="form-group">
                    <label for="gambar">Gambar (opsional)</label>
                    <input type="file" id="gambar" name="gambar" accept="image/*">
                    <div class="file-info">Format: JPG, JPEG, PNG, GIF | Maksimal: 2MB</div>
                </div>
                <button type="submit" name="tambah_makanan" class="btn-tambah">Tambah Makanan</button>
            </form>
        </div>

        <!-- Form Edit Makanan (Hidden by default) -->
        <div class="form-edit" id="formEdit">
            <h2>✏️ Edit Makanan</h2>
            <form method="POST" action="" enctype="multipart/form-data" id="editForm">
                <input type="hidden" name="edit_id" id="edit_id">
                <input type="hidden" name="gambar_lama" id="gambar_lama">
                
                <div class="form-group">
                    <label for="edit_nama">Nama Makanan</label>
                    <input type="text" id="edit_nama" name="edit_nama" required>
                </div>
                <div class="form-group">
                    <label for="edit_harga">Harga (Rp)</label>
                    <input type="number" id="edit_harga" name="edit_harga" min="0" required>
                </div>
                <div class="form-group">
                    <label for="edit_deskripsi">Deskripsi</label>
                    <textarea id="edit_deskripsi" name="edit_deskripsi" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="edit_stok">Stok</label>
                    <input type="number" id="edit_stok" name="edit_stok" min="0" required>
                </div>
                <div class="form-group">
                    <label for="edit_gambar">Gambar Baru (opsional)</label>
                    <input type="file" id="edit_gambar" name="edit_gambar" accept="image/*">
                    <div class="file-info">Kosongkan jika tidak ingin mengubah gambar</div>
                </div>
                <div class="form-actions">
                    <button type="submit" name="edit_makanan" class="btn-edit">Update Makanan</button>
                    <button type="button" class="btn-batal" onclick="batalEdit()">Batal</button>
                </div>
            </form>
        </div>

        <!-- Daftar Makanan -->
        <div class="daftar-makanan">
            <h2>📋 Daftar Makanan</h2>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="makanan-item" id="makanan-<?php echo $row['id']; ?>">
                        <div class="makanan-info">
                            <h3><?php echo htmlspecialchars($row['nama']); ?></h3>
                            <p><strong>Harga:</strong> Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                            <p><strong>Stok:</strong> <?php echo htmlspecialchars($row['stok']); ?></p>
                            <p><strong>Deskripsi:</strong> <?php echo htmlspecialchars($row['deskripsi']); ?></p>
                            <?php if (!empty($row['gambar'])): ?>
                                <p><strong>File Gambar:</strong> <?php echo basename($row['gambar']); ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (!empty($row['gambar']) && file_exists($row['gambar'])): ?>
                            <img src="<?php echo $row['gambar']; ?>" alt="<?php echo htmlspecialchars($row['nama']); ?>" class="makanan-gambar">
                        <?php else: ?>
                            <div class="no-image-admin">
                                No Image
                            </div>
                        <?php endif; ?>
                        
                        <div class="makanan-actions">
                            <button class="btn-edit-item" onclick="editMakanan(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['nama']); ?>', <?php echo $row['harga']; ?>, '<?php echo htmlspecialchars($row['deskripsi']); ?>', <?php echo $row['stok']; ?>, '<?php echo $row['gambar']; ?>')">
                                Edit
                            </button>
                            <button class="btn-hapus" onclick="hapusMakanan(<?php echo $row['id']; ?>)">Hapus</button>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-admin">
                    <h3>Belum ada makanan</h3>
                    <p>Tambahkan makanan pertama menggunakan form di atas.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function editMakanan(id, nama, harga, deskripsi, stok, gambar) {
            // Isi form edit dengan data yang ada
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_harga').value = harga;
            document.getElementById('edit_deskripsi').value = deskripsi;
            document.getElementById('edit_stok').value = stok;
            document.getElementById('gambar_lama').value = gambar;
            
            // Tampilkan form edit dan sembunyikan form tambah
            document.getElementById('formEdit').style.display = 'block';
            document.querySelector('.form-tambah').style.display = 'none';
            
            // Scroll ke form edit
            document.getElementById('formEdit').scrollIntoView({ behavior: 'smooth' });
        }
        
        function batalEdit() {
            // Sembunyikan form edit dan tampilkan form tambah
            document.getElementById('formEdit').style.display = 'none';
            document.querySelector('.form-tambah').style.display = 'block';
            
            // Reset form edit
            document.getElementById('editForm').reset();
        }
        
        function hapusMakanan(id) {
            if (confirm('Apakah Anda yakin ingin menghapus makanan ini?')) {
                window.location.href = 'admin.php?hapus=' + id;
            }
        }
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>