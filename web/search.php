// Di dalam file search.php, cari bagian yang menampilkan hasil pencarian dan ganti dengan:

echo '<div class="product-card">';
echo '<div class="product-image-container">';
if (!empty($row['gambar']) && file_exists($row['gambar'])) {
    echo '<img src="' . $row['gambar'] . '" alt="' . htmlspecialchars($row['nama']) . '" class="product-image">';
} else {
    echo '<div class="no-image">';
    echo '<span>📷<br>No Image</span>';
    echo '</div>';
}
echo '</div>';
echo '<div class="product-content">';
echo '<h3>' . htmlspecialchars($row['nama']) . '</h3>';
echo '<p class="description">' . htmlspecialchars($row['deskripsi']) . '</p>';
echo '<p class="price">Rp ' . number_format($row['harga'], 0, ',', '.') . '</p>';
echo '<p class="stock">Stok: ' . htmlspecialchars($row['stok']) . '</p>';
echo '<form method="POST" action="index.php">';
echo '<input type="hidden" name="makanan_id" value="' . htmlspecialchars($row['id']) . '">';
echo '<input type="number" name="jumlah" value="1" min="1" max="' . htmlspecialchars($row['stok']) . '">';
echo '<button type="submit" name="add_to_cart">➕ Tambah ke Keranjang</button>';
echo '</form>';
echo '</div>';
echo '</div>';