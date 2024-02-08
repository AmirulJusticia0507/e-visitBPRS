<?php
include 'konekke_server.php';

if (isset($_POST['term'])) {
    $term = $_POST['term'];

    // Query to fetch data from the database
    $query = "SELECT NO_REKENING, NAMA_NASABAH FROM kredit LEFT JOIN nasabah ON kredit.NASABAH_ID = nasabah.nasabah_id WHERE NO_REKENING LIKE '%$term%' OR NAMA_NASABAH LIKE '%$term%'";
    $result = $connectionServer1->query($query);

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            'label' => $row['NO_REKENING'] . ' | ' . $row['NAMA_NASABAH'],
            'value' => $row['NO_REKENING'],
            'no_rekening' => $row['NO_REKENING'], // Include NO_REKENING in the data
            'nama_nasabah' => $row['NAMA_NASABAH'] // Include NAMA_NASABAH in the data
        );
    }

    echo json_encode($data);
}
?>
