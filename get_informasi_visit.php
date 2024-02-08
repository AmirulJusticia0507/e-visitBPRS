<?php
// File: get_informasi_visit.php

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

// Ambil no rekening dari parameter POST
$noRekening = $connectionServer->real_escape_string($_POST['noRekening']);  // Menggunakan real_escape_string untuk mencegah SQL injection

// Query SQL untuk mendapatkan informasi visit berdasarkan no rekening
$query = "
    SELECT 
        k1.KODE_GROUP1, 
        k1.DESKRIPSI_GROUP1,
        k2.no_rek_debet,
        k2.NO_REKENING, 
        k2.NASABAH_ID,
        k2.KOLEKTIBILITAS, 
        k2.POKOK_TUNGGAKAN_AKHIR,
        k2.BUNGA_TUNGGAKAN_AKHIR,
        k2.SALDO_NOMINATIF,
        n.NAMA_NASABAH, 
        n.alamat, 
        n.no_hp,
        k2.pokok_SALDO_AKHIR
    FROM MCI_070623.kodegroup1kredit k1
    LEFT JOIN MCI_070623.kredit k2 ON k1.KODE_GROUP1 = k2.KODE_GROUP1
    LEFT JOIN MCI_070623.nasabah n ON k2.NASABAH_ID = n.nasabah_id   
    LEFT JOIN MCI_070623.tabung t ON k2.NO_REKENING = t.NO_REKENING
    WHERE k2.NO_REKENING = '$noRekening'";

$result = $connectionServer->query($query);

// Periksa apakah query berhasil dieksekusi
if ($result) {
    // Ambil data hasil query
    $data = $result->fetch_assoc();

    // Kirim data sebagai respons JSON
    echo json_encode($data);
} else {
    // Handle error jika query gagal dieksekusi
    $hasil['STATUS'] = "000199";
    die(json_encode($hasil));
}

// Tutup koneksi database
$connectionServer->close();
?>
