<?php
include 'config.php';
session_start();

if (empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit();
}

// Hitung total pesanan
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['subtotal'];
}

// Simpan pesanan ke database
$sql = "INSERT INTO pesanan (total) VALUES ($total)";
if ($conn->query($sql) === TRUE) {
    $pesanan_id = $conn->insert_id;
    
    // Simpan detail pesanan
    foreach ($_SESSION['cart'] as $item) {
        $makanan_id = $item['id'];
        $jumlah = $item['jumlah'];
        $subtotal = $item['subtotal'];
        
        $sql_detail = "INSERT INTO detail_pesanan (pesanan_id, makanan_id, jumlah, subtotal) 
                      VALUES ($pesanan_id, $makanan_id, $jumlah, $subtotal)";
        $conn->query($sql_detail);
        
        // Kurangi stok
        $sql_update = "UPDATE makanan SET stok = stok - $jumlah WHERE id = $makanan_id";
        $conn->query($sql_update);
    }
    
    // Simpan data pesanan untuk ditampilkan di struk
    $items = $_SESSION['cart'];
    
    // Kosongkan keranjang
    $_SESSION['cart'] = [];
    
    // Tampilkan struk
    echo "<!DOCTYPE html>
    <html lang='id'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Struk Pesanan - Kasir Makanan</title>
        <link rel='stylesheet' href='style.css'>
        <style>
            .struk-container {
                max-width: 400px;
                margin: 20px auto;
                padding: 20px;
                background: white;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                font-family: 'Courier New', monospace;
            }
            .struk-header {
                text-align: center;
                margin-bottom: 20px;
                padding-bottom: 15px;
                border-bottom: 1px dashed #ccc;
            }
            .struk-header h1 {
                font-size: 24px;
                margin: 0;
                color: #ff6b6b;
            }
            .struk-info {
                margin-bottom: 15px;
            }
            .struk-items {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 15px;
            }
            .struk-items th {
                border-bottom: 1px dashed #ccc;
                padding: 8px 0;
                text-align: left;
            }
            .struk-items td {
                padding: 5px 0;
            }
            .struk-total {
                border-top: 2px solid #333;
                padding-top: 10px;
                font-weight: bold;
                text-align: right;
            }
            .struk-footer {
                text-align: center;
                margin-top: 20px;
                padding-top: 15px;
                border-top: 1px dashed #ccc;
                font-size: 14px;
                color: #666;
            }
            .btn-container {
                text-align: center;
                margin-top: 30px;
            }
            .btn-print {
                padding: 10px 20px;
                background-color: #4ecdc4;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                margin-right: 10px;
            }
            .btn-back {
                padding: 10px 20px;
                background-color: #6c757d;
                color: white;
                text-decoration: none;
                border-radius: 4px;
            }
            @media print {
                .btn-container {
                    display: none;
                }
                .struk-container {
                    box-shadow: none;
                    border: 1px solid #ccc;
                }
            }
        </style>
    </head>
    <body>
        <div class='struk-container'>
            <div class='struk-header'>
                <h1>KASIR MAKANAN</h1>
                <p>Jl. Merdeka, Maja</p>
                <p>Telp: 081224152210</p>
            </div>
            
            <div class='struk-info'>
                <p><strong>No. Pesanan:</strong> #$pesanan_id</p>
                <p><strong>Tanggal:</strong> " . date('d/m/Y H:i') . "</p>
            </div>
            
            <table class='struk-items'>
                <tr>
                    <th>Item</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>";
                
                foreach ($items as $item) {
                    echo "<tr>
                        <td>" . htmlspecialchars($item['nama']) . "</td>
                        <td>" . htmlspecialchars($item['jumlah']) . "</td>
                        <td>Rp " . number_format($item['harga'], 0, ',', '.') . "</td>
                        <td>Rp " . number_format($item['subtotal'], 0, ',', '.') . "</td>
                    </tr>";
                }
                
                echo "<tr>
                    <td colspan='3' class='struk-total'>TOTAL</td>
                    <td class='struk-total'>Rp " . number_format($total, 0, ',', '.') . "</td>
                </tr>
            </table>
            
            <div class='struk-footer'>
                <p>Terima kasih atas kunjungan Anda</p>
                <p>*** Silahkan datang kembali ***</p>
            </div>
        </div>
        
        <div class='btn-container'>
            <button onclick='window.print()' class='btn-print'>Cetak Struk</button>
            <a href='index.php' class='btn-back'>Kembali ke Beranda</a>
        </div>
    </body>
    </html>";
} else {
    echo "<div style='padding: 20px; text-align: center;'>
            <h2>Error Memproses Pesanan</h2>
            <p>Terjadi kesalahan: " . $conn->error . "</p>
            <a href='index.php'>Kembali ke Kasir</a>
          </div>";
}

$conn->close();
?>