<?php
// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$database = "wisata_rajaampat";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set charset
mysqli_set_charset($conn, "utf8");
?>