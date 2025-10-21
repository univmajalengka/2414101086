<?php
$host = "localhost";
$username = "tugaspabw_2414101086";
$password = "tugaspabw_2414101086";
$database = "tugaspabw_2414101086";

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>