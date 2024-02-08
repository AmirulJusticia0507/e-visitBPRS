<?php
$server = "192.168.1.199";
// $server = "e31d0e0561e3.sn.mynetname.net";
$username = "root";
$password = "royalmaa2*123";
$database = "MCI_070623";

// Buat koneksi ke server
$connectionServer1 = new mysqli($server, $username, $password, $database);

// Periksa koneksi ke server
if ($connectionServer1->connect_error) {
    $hasil['STATUS'] = "000199";
    die(json_encode($hasil));
}
?>
