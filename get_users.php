<?php
include 'konekke_local.php';

// Mendapatkan parameter 'q' yang dikirimkan oleh permintaan autocomplete
$searchTerm = $_GET['q'];

// Query untuk mencari nama pengguna berdasarkan 'q'
$query = "SELECT fullname FROM db_kunjungan.users_new WHERE fullname LIKE '%$searchTerm%'";
$result = $koneklocalhost->query($query);

// Menyimpan hasil pencarian dalam bentuk array
$userList = array();
while ($row = $result->fetch_assoc()) {
    $userList[] = $row['fullname'];
}

// Mengembalikan daftar nama pengguna sebagai respons JSON
echo json_encode($userList);
?>
