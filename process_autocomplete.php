<?php
// File: process_autocomplete.php

// Ambil koneksi database (sesuaikan dengan konfigurasi Anda)
$server = "192.168.1.199";
$username = "root";
$password = "royalmaa2*123";
$database = "MCI_070623";

// Buat koneksi ke server
$connectionServer = new mysqli($server, $username, $password, $database);

// Periksa koneksi ke server
if ($connectionServer->connect_error) {
    $hasil['STATUS'] = "000199";
    die(json_encode($hasil));
}

// Ambil data no rekening dari parameter GET
$term = $connectionServer->real_escape_string($_GET['term']);  // Menggunakan real_escape_string untuk mencegah SQL injection

// Query SQL untuk mencari no rekening yang sesuai dengan input pengguna
$query = "SELECT DISTINCT NO_REKENING FROM MCI_070623.kredit WHERE NO_REKENING LIKE '%$term%'";

$result = $connectionServer->query($query);

// Periksa apakah query berhasil dieksekusi
if ($result) {
    // Inisialisasi array untuk menyimpan hasil pencarian
    $rekeningArray = array();

    // Ambil data hasil query
    while ($row = $result->fetch_assoc()) {
        $rekeningArray[] = $row['NO_REKENING'];
    }

    // Kirim data sebagai respons JSON
    echo json_encode($rekeningArray);
} else {
    // Handle error jika query gagal dieksekusi
    $hasil['STATUS'] = "000199";
    die(json_encode($hasil));
}

// Tutup koneksi database
$connectionServer->close();
?>
