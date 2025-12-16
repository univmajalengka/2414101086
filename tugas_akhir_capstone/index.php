<?php
require_once 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisata Raja Ampat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <h2>Raja Ampat</h2>
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="#beranda" class="nav-link">Beranda</a>
                </li>
                <li class="nav-item">
                    <a href="#obyek-wisata" class="nav-link">Obyek Wisata</a>
                </li>
                <li class="nav-item">
                    <a href="#fasilitas" class="nav-link">Fasilitas Wisata</a>
                </li>
                <li class="nav-item">
                    <a href="#paket-wisata" class="nav-link">Paket Wisata</a>
                </li>
                <li class="nav-item">
                    <a href="#about" class="nav-link">About</a>
                </li>
                <li class="nav-item">
                    <a href="modifikasi_pesanan.php" class="nav-link">Kelola Pesanan</a>
                </li>
            </ul>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>

    <!-- Header/Beranda Section -->
    <section id="beranda" class="hero">
        <div class="hero-content">
            <h1>Wisata Raja Ampat</h1>
            <p>Nikmati keindahan alam memukau di Raja Ampat</p>
            <a href="#paket-wisata" class="cta-btn">Jelajahi Sekarang</a>
        </div>
    </section>

        <!-- Obyek Wisata Section -->
    <section id="obyek-wisata" class="section">
        <div class="container">
            <h2 class="section-title">Obyek Wisata</h2>
            <div class="wisata-grid">
                <div class="wisata-card">
                    <div class="wisata-img">
                        <img src="https://www.cimbniaga.co.id/content/dam/cimb/inspirasi/pulau-misool.webp" alt="Pulau Misool">
                    </div>
                    <div class="wisata-info">
                        <h3>Pulau Misool</h3>
                        <p>Misool termasuk salah satu pulau yang memiliki pesona yang sangat indah karena memiliki air laut yang jernih. Keindahan Pulau Misool terlihat dari bukit-bukit, hutan lebat, dan rawa bakau yang memukau. Di bagian timur dan barat pulau Misool terdapat labirin batu kapur dengan warna biru turquoise yang cantik.</p>
                    </div>
                </div>
                <div class="wisata-card">
                    <div class="wisata-img">
                        <!-- Gambar dari website -->
                        <img src="https://www.cimbniaga.co.id/content/dam/cimb/inspirasi/laguna-bintang.webp" alt="Laguna Bintang">
                    </div>
                    <div class="wisata-info">
                        <h3>Laguna Bintang</h3>
                        <p>Tempat wisata Raja Ampat selanjutnya yang bisa Anda kunjungi adalah Star Lagoon yang berlokasi tepat di Pulau Pianemo. Laguna berbentuk bintang ini dikelilingi oleh pulau-pulau kecil yang indah dan dapat dinikmati dari ketinggian bukit.</p>
                    </div>
                </div>
                <div class="wisata-card">
                    <div class="wisata-img">
                        <!-- Gambar dari website -->
                        <img src="https://www.cimbniaga.co.id/content/dam/cimb/inspirasi/desa-arborek.webp" alt="Desa Arborek">
                    </div>
                    <div class="wisata-info">
                        <h3>Desa Arborek</h3>
                        <p>Desa wisata Arborek terkenal sebagai salah satu tempat wisata Raja Ampat yang tak kalah memukau. Di desa ini, Anda bisa menikmati hamparan pasir putih dan deretan pohon kelapa yang berjajar indah di sekeliling pulau. Selain keindahan alam, Desa Arborek juga memiliki daya tarik tersendiri karena para penduduknya yang ramah. Anda juga bisa menikmati secara langsung tradisi dan kesenian penduduk melalui penampilan tradisional, salah satunya tarian khas Papua.</p>
                    </div>
                </div>
                <div class="wisata-card">
                    <div class="wisata-img">
                        <!-- Gambar dari website -->
                        <img src="https://www.cimbniaga.co.id/content/dam/cimb/inspirasi/air-terjun-kitikiti.webp" alt="Air Terjun Kitikiti">
                    </div>
                    <div class="wisata-info">
                        <h3>Air Terjun Kitikiti</h3>
                        <p>Keindahan wisata Raja Ampat semakin sempurna dengan kehadiran Air Terjun Kiti Kiti. Air terjun ini memiliki keunikan tersendiri karena airnya langsung mengalir ke laut lepas. Selain itu, Anda juga bisa melihat keindahan pantai di bawah air terjun ketika airnya sedang surut. Keindahan semakin lengkap karena Anda bisa melihat berbagai tipe ikan dan terumbu karang yang cantik di bawah laut.</p>
                    </div>
                </div>
                <div class="wisata-card">
                    <div class="wisata-img">
                        <!-- Gambar dari website -->
                        <img src="https://www.cimbniaga.co.id/content/dam/cimb/inspirasi/pulau-kofiau.webp" alt="Pulau Kofiau">
                    </div>
                    <div class="wisata-info">
                        <h3>Pulau Kofiau</h3>
                        <p>Pulau Kofiau termasuk salah satu wisata Raja Ampat yang paling banyak dikunjungi oleh wisatawan. Terlebih lagi, Pulau Kofiau menyimpan keindahan terumbu karang dengan hamparan pasir putih di pesisir pantai. Pulau ini memiliki keunikan tersendiri karena Anda bisa menemukan beberapa bukit vulkanik yang ditutupi oleh hutan hujan dan batu kapur karang.</p>
                    </div>
                </div>
                <div class="wisata-card">
                    <div class="wisata-img">
                        <!-- Gambar dari website -->
                        <img src="https://www.cimbniaga.co.id/content/dam/cimb/inspirasi/desa-ayamaru.webp" alt="Danau Ayamaru">
                    </div>
                    <div class="wisata-info">
                        <h3>Danau Ayamaru</h3>
                        <p>Danau ini terkenal sebagai warisan nenek moyang suku Maybrat sehingga para penduduknya sangat menjaga habitat alam di sekitar danau agar tidak rusak. Keindahan danau ini sangat jelas terlihat karena memiliki air berwarna biru yang jernih. Saking jernihnya, Anda bisa melihat dasar danau yang dipenuhi oleh bebatuan menyerupai terumbu karang dan ikan-ikan yang indah.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

 <!-- Fasilitas Wisata Section - DIUBAH -->
    <section id="fasilitas" class="section bg-light">
        <div class="container">
            <h2 class="section-title">Fasilitas Wisata Raja Ampat</h2>
            <div class="fasilitas-grid">
                <div class="fasilitas-item">
                    <div class="fasilitas-icon">🏨</div>
                    <h3>Resort & Homestay</h3>
                    <p>Resort mewah hingga homestay tradisional di pulau-pulau utama seperti Waigeo, Misool, dan Batanta. Mulai dari Rp 500.000 - Rp 5.000.000/malam.</p>
                </div>
                <div class="fasilitas-item">
                    <div class="fasilitas-icon">🛶</div>
                    <h3>Transportasi Laut</h3>
                    <p>Speedboat dan kapal tradisional untuk antar-jemput wisatawan antar pulau. Sewa speedboat Rp 2.000.000 - Rp 5.000.000/hari.</p>
                </div>
                <div class="fasilitas-item">
                    <div class="fasilitas-icon">🤿</div>
                    <h3>Penyewaan Alat Selam</h3>
                    <p>Penyewaan peralatan snorkeling dan diving lengkap dengan guide profesional. Snorkeling Rp 150.000, Diving Rp 500.000/penyelaman.</p>
                </div>
                <div class="fasilitas-item">
                    <div class="fasilitas-icon">🍽️</div>
                    <h3>Restoran & Warung</h3>
                    <p>Restoran seafood segar dan warung tradisional menyajikan ikan bakar, papeda, dan kuliner khas Papua Barat.</p>
                </div>
                <div class="fasilitas-item">
                    <div class="fasilitas-icon">🏥</div>
                    <h3>Klinik & Apotek</h3>
                    <p>Fasilitas kesehatan dasar tersedia di Waisai (ibu kota) dan beberapa resort besar. Tersedia layanan emergency 24 jam.</p>
                </div>
                <div class="fasilitas-item">
                    <div class="fasilitas-icon">🎁</div>
                    <h3>Souvenir Center</h3>
                    <p>Toko cenderamata menjual kerajinan tangan khas Papua seperti ukiran kayu, noken, dan perhiasan mutiara.</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Paket Wisata Section -->
    <section id="paket-wisata" class="section">
        <div class="container">
            <h2 class="section-title">Paket Wisata Raja Ampat</h2>
            <div class="paket-grid">
                <?php
                // Ambil data paket wisata dari database
                $sql = "SELECT * FROM paket_wisata";
                $result = mysqli_query($conn, $sql);
                
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="paket-card">
                    <div class="paket-header">
                        <h3><?php echo htmlspecialchars($row['nama_paket']); ?></h3>
                        <span class="paket-price">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></span>
                    </div>
                    <div class="paket-img">
                        <img src="<?php echo htmlspecialchars($row['gambar_url']); ?>" alt="<?php echo htmlspecialchars($row['nama_paket']); ?>">
                    </div>
                    <div class="paket-content">
                        <p><?php echo htmlspecialchars($row['deskripsi']); ?></p>
                        <p>
                            <strong>Video Promosi:</strong><br>
                            <a href="<?php echo htmlspecialchars($row['video_url']); ?>" target="_blank" class="cta-btn">Tonton Video</a>
                        </p>
                        <button class="paket-btn" onclick="window.location.href='pemesanan.php?paket=<?php echo urlencode($row['nama_paket']); ?>&harga=<?php echo $row['harga']; ?>'">
                            Pesan Sekarang
                        </button>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section bg-light">
        <div class="container">
            <h2 class="section-title">Tentang Raja Ampat</h2>
            <div class="about-content">
                <div class="about-text">
                    <h3>Raja Ampat</h3>
                    <p>Raja Ampat yang bermakna "Empat Raja" adalah gugusan kepulauan eksotis yang terletak di jantung Papua Barat Daya, Indonesia, dan dikenal sebagai Episentrum Keanekaragaman Hayati Laut Dunia. Kawasan ini menawarkan lanskap visual yang spektakuler, di mana ribuan pulau karst yang diselimuti vegetasi hijau menjulang dramatis dari perairan toska yang jernih, menciptakan pemandangan ikonik seperti Wayag dan Piaynemo.</p>
                    <p>Namun, keajaiban sesungguhnya terletak di bawah permukaan laut; Raja Ampat menampung hingga 75% spesies karang keras dunia, menjadikannya surga tak tertandingi bagi para penyelam dan snorkeler. Kami hadir untuk memandu Anda menjelajahi warisan alam langka ini, menikmati kekayaan bahari yang tak terlukiskan, dan berpartisipasi dalam upaya konservasi ekosistem yang rapuh namun megah ini.</p>
                    <div class="about-features">
                        <div class="feature">
                            <span class="feature-number">75%</span>
                            <span class="feature-text">Spesies Karang Dunia</span>
                        </div>
                        <div class="feature">
                            <span class="feature-number">1.500+</span>
                            <span class="feature-text">Spesies Ikan</span>
                        </div>
                        <div class="feature">
                            <span class="feature-number">700+</span>
                            <span class="feature-text">Spesies Moluska</span>
                        </div>
                    </div>
                </div>
                <div class="about-video">
                    <div class="video-container">
                        <iframe 
                            src="https://www.youtube.com/embed/quOTe_3G5B4"
                            title="Raja Ampat - The Amazon of the Ocean"
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    </div>
                    <p class="video-caption">Video: Keindahan Raja Ampat yang Menakjubkan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Wisata Raja Ampat</h3>
                    <p>Menawarkan pengalaman wisata alam dan budaya yang tak terlupakan di surga bawah laut Indonesia.</p>
                </div>
                <div class="footer-section">
                    <h3>Kontak</h3>
                    <p>📧 Email: info@rajaampat-tour.com</p>
                    <p>📞 Telepon: +62 851-5410-0182</p>
                    <p>📍 Alamat: Jl. Raya Waisai, Kota Waisai, Papua Barat</p>
                </div>
                <div class="footer-section">
                    <h3>Jam Operasional</h3>
                    <p>📅 Senin - Minggu: 08.00 - 17.00 WIT</p>
                    <p>🎫 Tiket masuk: Rp 1.000.000/orang (wisatawan asing)</p>
                    <p>🎫 Tiket lokal: Rp 500.000/orang (wisatawan domestik)</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Raja Ampat Tourism. All rights reserved. | Developed by Riziq Damar Maulida</p>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
<?php
mysqli_close($conn);
?>