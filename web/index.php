<?php
include 'config.php';
session_start();

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Tambah item ke keranjang
if (isset($_POST['add_to_cart'])) {
    $makanan_id = intval($_POST['makanan_id']);
    $jumlah = intval($_POST['jumlah']);
    
    // Ambil data makanan dari database
    $sql = "SELECT * FROM makanan WHERE id = $makanan_id AND stok > 0";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $makanan = $result->fetch_assoc();
        
        // Cek stok cukup
        if ($jumlah > $makanan['stok']) {
            $error = "Stok tidak cukup! Stok tersedia: " . $makanan['stok'];
        } else {
            // Cek apakah item sudah ada di keranjang
            $item_exists = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] == $makanan_id) {
                    $new_jumlah = $item['jumlah'] + $jumlah;
                    if ($new_jumlah <= $makanan['stok']) {
                        $item['jumlah'] = $new_jumlah;
                        $item['subtotal'] = $item['harga'] * $item['jumlah'];
                        $item_exists = true;
                    } else {
                        $error = "Stok tidak cukup! Stok tersedia: " . $makanan['stok'];
                    }
                    break;
                }
            }
            
            // Jika item belum ada, tambahkan ke keranjang
            if (!$item_exists && !isset($error)) {
                $_SESSION['cart'][] = array(
                    'id' => $makanan['id'],
                    'nama' => $makanan['nama'],
                    'harga' => $makanan['harga'],
                    'jumlah' => $jumlah,
                    'subtotal' => $makanan['harga'] * $jumlah
                );
            }
        }
    } else {
        $error = "Makanan tidak ditemukan atau stok habis!";
    }
}

// Hapus item dari keranjang
if (isset($_GET['remove'])) {
    $index = intval($_GET['remove']);
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    header("Location: index.php");
    exit();
}

// Kosongkan keranjang
if (isset($_GET['clear_cart'])) {
    $_SESSION['cart'] = array();
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Makanan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Kasir Makanan</h1>
            <div style="display: flex; align-items: center; gap: 15px;">
                <div class="search-container">
                    <form action="search.php" method="GET">
                        <input type="text" name="query" placeholder="Cari makanan...">
                        <button type="submit">Cari</button>
                    </form>
                </div>
                <a href="login.php" class="btn-admin">Admin</a>
                <a href="riwayat.php" class="btn-riwayat">Riwayat</a>
            </div>
        </header>

        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="main-content">
            <div class="product-list">
                <h2>Daftar Makanan</h2>
                <div class="products">
                    <?php
                    $sql = "SELECT * FROM makanan WHERE stok > 0 ORDER BY nama";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo '<div class="product-card">';
                            
                            // Container gambar
                            echo '<div class="product-image-container">';
                            if (!empty($row['gambar']) && file_exists($row['gambar'])) {
                                echo '<img src="' . $row['gambar'] . '" alt="' . htmlspecialchars($row['nama']) . '" class="product-image">';
                            } else {
                                echo '<div class="no-image">';
                                echo '<span>📷<br>No Image</span>';
                                echo '</div>';
                            }
                            echo '</div>';
                            
                            // Konten produk
                            echo '<div class="product-content">';
                            echo '<h3>' . htmlspecialchars($row['nama']) . '</h3>';
                            echo '<p class="description">' . htmlspecialchars($row['deskripsi']) . '</p>';
                            echo '<p class="price">Rp ' . number_format($row['harga'], 0, ',', '.') . '</p>';
                            echo '<p class="stock">Stok: ' . htmlspecialchars($row['stok']) . '</p>';
                            
                            // Form tambah ke keranjang
                            echo '<form method="POST" action="">';
                            echo '<input type="hidden" name="makanan_id" value="' . htmlspecialchars($row['id']) . '">';
                            echo '<input type="number" name="jumlah" value="1" min="1" max="' . htmlspecialchars($row['stok']) . '">';
                            echo '<button type="submit" name="add_to_cart">➕ Tambah ke Keranjang</button>';
                            echo '</form>';
                            
                            echo '</div>'; // tutup product-content
                            echo '</div>'; // tutup product-card
                        }
                    } else {
                        echo '<div class="empty-state">';
                        echo '<h3>Belum ada makanan tersedia</h3>';
                        echo '<p>Silahkan login sebagai admin untuk menambahkan makanan pertama.</p>';
                        echo '<a href="login.php" class="btn-add-first">Tambah Makanan Pertama</a>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            
            <div class="cart">
                <h2>Keranjang Belanja</h2>
                <?php if (!empty($_SESSION['cart'])): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total = 0;
                            foreach ($_SESSION['cart'] as $index => $item): 
                                $total += $item['subtotal'];
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['nama']); ?></td>
                                    <td>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                                    <td><?php echo htmlspecialchars($item['jumlah']); ?></td>
                                    <td>Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?></td>
                                    <td><a href="?remove=<?php echo $index; ?>" onclick="return confirm('Yakin hapus item?')">Hapus</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"><strong>Total</strong></td>
                                <td colspan="2"><strong>Rp <?php echo number_format($total, 0, ',', '.'); ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="cart-actions">
                        <a href="?clear_cart=true" class="btn-clear" onclick="return confirm('Yakin kosongkan keranjang?')">Kosongkan Keranjang</a>
                        <form action="process_order.php" method="POST">
                            <button type="submit" class="btn-checkout">Proses Pesanan</button>
                        </form>
                    </div>
                <?php else: ?>
                    <p>Keranjang belanja kosong.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>