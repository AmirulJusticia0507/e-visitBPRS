<?php
session_start();
include 'konekke_local.php';

// Fungsi untuk membersihkan input dari potensi risiko SQL injection
function cleanInput($input) {
    $search = array(
        '@<script[^>]*?>.*?</script>@si',   // Hapus script
        '@<[\/\!]*?[^<>]*?>@si',            // Hapus tag HTML
        '@<style[^>]*?>.*?</style>@siU',    // Hapus style tag
        '@<![\s\S]*?--[ \t\n\r]*>@'         // Hapus komentar
    );
    $output = preg_replace($search, '', $input);
    return $output;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Bersihkan data input
    $noRekening = cleanInput($_POST["noRekening"]);
    $kodeGroup1 = cleanInput($_POST["kodeGroup1"]);
    $deskripsiGroup1 = cleanInput($_POST["deskripsiGroup1"]);
    $nasabahId = cleanInput($_POST["nasabahId"]);
    $namaNasabah = cleanInput($_POST["namaNasabah"]);
    $alamat = cleanInput($_POST["alamat"]);
    $noHp = cleanInput($_POST["noHp"]);
    $keteranganbayar = cleanInput($_POST["keteranganBayar"]);
    $janjibayar = cleanInput($_POST["janjiBayar"]);
    // $saldoNominal = cleanInput($_POST["saldoNominal"]);
    $noRekDebet = cleanInput($_POST["noRekDebet"]);
    $kolektibilitas = cleanInput($_POST["kolektibilitas"]);
    $pokokTunggakanAkhir = cleanInput($_POST["pokokTunggakanAkhir"]);
    $bungaTunggakanAkhir = cleanInput($_POST["bungaTunggakanAkhir"]);
    $pokokSaldoAkhir = cleanInput($_POST["pokokSaldoAkhir"]);
    $saldoNominal = $pokokSaldoAkhir;

    $usersid = $_SESSION['usersid'];

    // Proses upload file kunjungan
    $targetDir = "uploads/fotokunjungan/"; // Direktori tempat menyimpan file kunjungan
    $fileList = '';

    if (!empty($_FILES["kunjunganPath"]["name"])) {
        foreach ($_FILES["kunjunganPath"]["name"] as $key => $value) {
            $fileName = basename($_FILES["kunjunganPath"]["name"][$key]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // Menggabungkan file yang diupload ke daftar file
            $fileList .= $fileName . ', ';

            // Pindahkan file ke direktori upload
            if (move_uploaded_file($_FILES["kunjunganPath"]["tmp_name"][$key], $targetFilePath)) {
                // File berhasil diupload
            } else {
                // Gagal mengupload file
            }
        }
    }

    // Waktu saat ini
    date_default_timezone_set('Asia/Jakarta');
    // $createdDate = date('d-m-y'); // Format date (dd-mm-yy)
    $created_at = date('y-m-d H:i:s'); // Format timestamp (HH:mm:ss)

    // Proses penyimpanan data kunjungan ke database
    $query = "INSERT INTO db_kunjungan.kunjungan_bprs (
                NO_REKENING, 
                KODE_GROUP1, 
                DESKRIPSI_GROUP1, 
                NASABAH_ID, 
                NAMA_NASABAH, 
                ALAMAT, 
                NO_HP,
                keteranganbayar,
                janjibayar,
                SALDO_NOMINATIF, 
                KUNJUNGAN_PATH,
                NO_REK_DEBET, 
                KOLEKTIBILITAS, 
                POKOK_TUNGGAKAN_AKHIR, 
                BUNGA_TUNGGAKAN_AKHIR, 
                POKOK_SALDO_AKHIR,
                created_at,
                usersid
            ) VALUES (
                '$noRekening', 
                '$kodeGroup1', 
                '$deskripsiGroup1', 
                '$nasabahId', 
                '$namaNasabah', 
                '$alamat', 
                '$noHp',
                '$keteranganbayar',
                '$janjibayar',
                '$saldoNominal', 
                '$fileList',
                '$noRekDebet', 
                '$kolektibilitas', 
                '$pokokTunggakanAkhir', 
                '$bungaTunggakanAkhir', 
                '$pokokSaldoAkhir',
                '$created_at',
                '$usersid'
            )";

    if ($koneklocalhost->query($query) === TRUE) {
        // Data berhasil disimpan
        echo "Data berhasil disimpan.";
        header('Location: kunjungan.php?page=kunjungan');
        exit;
    } else {
        // Kesalahan saat menyimpan data
        echo "Error: " . $query . "<br>" . $koneklocalhost->error;
    }

    // Bersihkan session setelah data berhasil disimpan
    unset($_SESSION['searchResult']);

} else {
    // Redirect jika akses langsung ke file ini
    header('Location: kunjungan.php?page=kunjungan');
    exit;
}

// Tutup koneksi ke database
$koneklocalhost->close();
?>
