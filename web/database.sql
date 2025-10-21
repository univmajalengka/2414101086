CREATE DATABASE kasir_makanan;
USE kasir_makanan;

CREATE TABLE makanan (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    harga DECIMAL(10,2) NOT NULL,
    deskripsi TEXT,
    stok INT(11) DEFAULT 0,
    gambar VARCHAR(100)
);

CREATE TABLE pesanan (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    tanggal DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'selesai') DEFAULT 'pending'
);

CREATE TABLE detail_pesanan (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    pesanan_id INT(11),
    makanan_id INT(11),
    jumlah INT(11) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (pesanan_id) REFERENCES pesanan(id),
    FOREIGN KEY (makanan_id) REFERENCES makanan(id)
);

-- Contoh data makanan
INSERT INTO makanan (nama, harga, deskripsi, stok, gambar) VALUES
('Nasi Goreng', 15000, 'Nasi goreng spesial dengan telur dan ayam', 20, 'nasi_goreng.jpg'),
('Mie Ayam', 12000, 'Mie ayam dengan pangsit dan bakso', 15, 'mie_ayam.jpg'),
('Sate Ayam', 18000, 'Sate ayam dengan bumbu kacang', 25, 'sate_ayam.jpg'),
('Gado-gado', 10000, 'Salad sayur dengan bumbu kacang', 18, 'gado_gado.jpg'),
('Es Teh Manis', 5000, 'Es teh manis segar', 30, 'es_teh.jpg');

ALTER TABLE pesanan 
ADD COLUMN nama_pelanggan VARCHAR(100) DEFAULT 'Pelanggan',
ADD COLUMN meja VARCHAR(10) DEFAULT '';