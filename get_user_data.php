<?php
include 'konekke_local.php';

$selectedUser = $_POST['selectedUser'];

$query = "SELECT * FROM db_kunjungan.users_new WHERE fullname = '$selectedUser'";
$result = $koneklocalhost->query($query);

$userData = array();
if ($result && $result->num_rows > 0) {
    $userData = $result->fetch_assoc();
}

echo json_encode($userData);
?>
