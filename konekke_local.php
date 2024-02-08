<?php
$server = "localhost";
// $server = "192.168.1.184";
$username = "root";
$password = "";
$database = "db_kunjungan";

// Buat koneksi ke server
$koneklocalhost = new mysqli($server, $username, $password, $database);

// Periksa koneksi ke server
if ($koneklocalhost->connect_error) {
    $hasil['STATUS'] = "000199";
    die(json_encode($hasil));
}
?>