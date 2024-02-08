<?php
include "konekke_server.php";

if (isset($_GET['SEARCH_NO_REKENING'])) {
    $noRekening = $_GET['SEARCH_NO_REKENING'];

    $query = "SELECT 
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
                -- t.SALDO_AKHIR AS SALDO_AKHIR_TABUNG
              FROM 
                MCI_070623.kodegroup1kredit k1
              LEFT JOIN 
                MCI_070623.kredit k2 ON k1.KODE_GROUP1 = k2.KODE_GROUP1
              LEFT JOIN 
                MCI_070623.nasabah n ON k2.NASABAH_ID = n.nasabah_id   
              LEFT JOIN 
                MCI_070623.tabung t ON k2.NO_REKENING = t.NO_REKENING
              WHERE 
                k2.NO_REKENING = '$noRekening'";

    $result = $connectionServer1->query($query);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(null); // Jika data tidak ditemukan
    }
} else {
    echo json_encode(null); // Jika parameter SEARCH_NO_REKENING tidak disertakan
}
?>
