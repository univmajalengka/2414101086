// Mobile Navigation Toggle
const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('.nav-menu');

hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    navMenu.classList.toggle('active');
});

// Close mobile menu when clicking on a link
document.querySelectorAll('.nav-link').forEach(n => n.addEventListener('click', () => {
    hamburger.classList.remove('active');
    navMenu.classList.remove('active');
}));

// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop - 80,
                behavior: 'smooth'
            });
        }
    });
});

// Header background change on scroll
window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 100) {
        navbar.style.background = 'rgba(44, 62, 80, 0.95)';
        navbar.style.backdropFilter = 'blur(10px)';
    } else {
        navbar.style.background = '#2c3e50';
        navbar.style.backdropFilter = 'none';
    }
});

// Package button click handler - DIUPDATE
document.querySelectorAll('.paket-btn').forEach(button => {
    button.addEventListener('click', function() {
        const paketName = this.getAttribute('data-paket');
        const paketCard = this.closest('.paket-card');
        const paketPrice = paketCard.querySelector('.paket-price').textContent;
        
        // Form booking modal
        const modalHTML = `
            <div class="booking-modal" id="bookingModal">
                <div class="modal-content">
                    <span class="close-modal">&times;</span>
                    <h3>Booking ${paketName}</h3>
                    <p class="modal-price">Harga: ${paketPrice}</p>
                    <form id="bookingForm">
                        <div class="form-group">
                            <label for="name">Nama Lengkap:</label>
                            <input type="text" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Nomor Telepon:</label>
                            <input type="tel" id="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="date">Tanggal Keberangkatan:</label>
                            <input type="date" id="date" required>
                        </div>
                        <div class="form-group">
                            <label for="participants">Jumlah Peserta:</label>
                            <select id="participants" required>
                                <option value="">Pilih jumlah</option>
                                <option value="1">1 orang</option>
                                <option value="2">2 orang</option>
                                <option value="3">3 orang</option>
                                <option value="4">4 orang</option>
                                <option value="5+">5+ orang</option>
                            </select>
                        </div>
                        <button type="submit" class="submit-btn">Kirim Booking</button>
                    </form>
                </div>
            </div>
        `;
        
        // Tambahkan modal ke body
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        
        // Styling modal
        const style = document.createElement('style');
        style.textContent = `
            .booking-modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.8);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 2000;
            }
            
            .modal-content {
                background: white;
                padding: 30px;
                border-radius: 15px;
                max-width: 500px;
                width: 90%;
                max-height: 80vh;
                overflow-y: auto;
                position: relative;
            }
            
            .close-modal {
                position: absolute;
                top: 15px;
                right: 20px;
                font-size: 24px;
                cursor: pointer;
                color: #e74c3c;
            }
            
            .modal-content h3 {
                color: #2c3e50;
                margin-bottom: 10px;
            }
            
            .modal-price {
                color: #e74c3c;
                font-weight: bold;
                margin-bottom: 20px;
                font-size: 1.2rem;
            }
            
            .form-group {
                margin-bottom: 15px;
            }
            
            .form-group label {
                display: block;
                margin-bottom: 5px;
                color: #2c3e50;
                font-weight: 500;
            }
            
            .form-group input,
            .form-group select {
                width: 100%;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
                font-size: 1rem;
            }
            
            .submit-btn {
                background: #e74c3c;
                color: white;
                border: none;
                padding: 12px 30px;
                border-radius: 5px;
                font-size: 1rem;
                cursor: pointer;
                width: 100%;
                margin-top: 10px;
                transition: background 0.3s ease;
            }
            
            .submit-btn:hover {
                background: #c0392b;
            }
        `;
        
        document.head.appendChild(style);
        
        // Modal functionality
        const modal = document.getElementById('bookingModal');
        const closeBtn = modal.querySelector('.close-modal');
        const bookingForm = document.getElementById('bookingForm');
        
        // Close modal
        closeBtn.addEventListener('click', () => {
            document.body.removeChild(modal);
            document.head.removeChild(style);
        });
        
        // Close modal when clicking outside
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                document.body.removeChild(modal);
                document.head.removeChild(style);
            }
        });
        
        // Form submission
        bookingForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const date = document.getElementById('date').value;
            const participants = document.getElementById('participants').value;
            
            // Simulasi pengiriman data
            alert(`Booking berhasil!\n\nPaket: ${paketName}\nNama: ${name}\nEmail: ${email}\nTelepon: ${phone}\nTanggal: ${date}\nPeserta: ${participants} orang\n\nTim kami akan menghubungi Anda dalam 1x24 jam.`);
            
            // Reset form dan tutup modal
            document.body.removeChild(modal);
            document.head.removeChild(style);
        });
    });
});

// Video lazy loading untuk performa
document.addEventListener('DOMContentLoaded', function() {
    const videoIframe = document.querySelector('.video-container iframe');
    if (videoIframe) {
        // Tambahkan loading="lazy" untuk iframe video
        videoIframe.setAttribute('loading', 'lazy');
    }
});
