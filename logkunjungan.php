<?php
// Mulai sesi
session_start();

// Periksa apakah pengguna telah terautentikasi
if (!isset($_SESSION['user_id'])) {
    // Jika tidak ada sesi pengguna, alihkan ke halaman login
    header('Location: login.php');
    exit;
}

// $namalengkap = $_SESSION['fullname'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>E-Visit - BPRS HIK MCI Yogyakarta</title>
    <!-- Tambahkan link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tambahkan link AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <!-- Tambahkan link DataTables CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Sertakan CSS Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <link rel="icon" href="img/visit.png" type="image/png">
    <style>
        /* Tambahkan CSS agar tombol accordion terlihat dengan baik */
        .btn-link {
            text-decoration: none;
            color: #007bff; /* Warna teks tombol */
        }

        .btn-link:hover {
            text-decoration: underline;
        }

        .card-header {
            background-color: #f7f7f7; /* Warna latar belakang header card */
        }

        #notification {
            display: none;
            margin-top: 10px; /* Adjust this value based on your layout */
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f8f8f8;
            color: #333;
        }
    </style>
    <style>
        .myButtonCekSaldo {
            box-shadow: 3px 4px 0px 0px #899599;
            background:linear-gradient(to bottom, #ededed 5%, #bab1ba 100%);
            background-color:#ededed;
            border-radius:15px;
            border:1px solid #d6bcd6;
            display:inline-block;
            cursor:pointer;
            color:#3a8a9e;
            font-family:Arial;
            font-size:17px;
            padding:7px 25px;
            text-decoration:none;
            text-shadow:0px 1px 0px #e1e2ed;
        }
        .myButtonCekSaldo:hover {
            background:linear-gradient(to bottom, #bab1ba 5%, #ededed 100%);
            background-color:#bab1ba;
        }
        .myButtonCekSaldo:active {
            position:relative;
            top:1px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <?php include 'header.php'; ?>
        </nav>
        
        <?php include 'sidebar.php'; ?>

        <div class="content-wrapper">
            <!-- Konten Utama -->
            <main class="content">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="kunjungan.php?page=kunjungan">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Log Laporan Kunjungan</li>
                    </ol>
                </nav>
                <?php
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                    $currentPage = basename($_SERVER['PHP_SELF']); // Mendapatkan halaman saat ini
                
                    switch ($page) {
                        case 'logkunjungan':
                            if ($currentPage !== 'logkunjungan.php') {
                                header("Location: logkunjungan.php?page=logkunjungan");
                                exit;
                            }
                            break;
                
                        case 'logkunjungan':
                            if ($currentPage !== 'logkunjungan.php') {
                                header("Location: logkunjungan.php?page=logkunjungan");
                                exit;
                            }
                            break;
                
                        // case 'dashboard':
                        //     if ($currentPage !== 'index.php') {
                        //         header("Location: index.php?page=dashboard");
                        //         exit;
                        //     }
                        //     break;
                
                        default:
                            // Handle cases for other pages or provide a default action
                            break;
                    }
                }
                ?>

                <div class="card">
                    <div class="card-body">
                       <fieldset>
                            <legend>Log Kunjungan :</legend><br>
                            <h3>Nama Pegawai: <?php echo $namalengkap; ?></h3><br>
                            <div class="form-group">
                                <label for="userSearch">Cari User:</label>
                                <select class="form-control" id="userSearch" name="userSearch"></select>
                            </div>
                            <div class="col">
                                 <button class="btn btn-info" onclick="refreshPage()"><i class='fa fa-sync'></i> Refresh</button>
                            </div><br>
                            <table class="display table table-bordered table-striped table-hover nowrap" style="width:100%" id="visitTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pegawai</th>
                                        <!-- <th>Kode Group1</th> -->
                                        <th>Account Officer</th>
                                        <!-- Tambahkan kolom sesuai kebutuhan -->
                                        <!-- <th>Nasabah ID</th> -->
                                        <th>Nama Nasabah</th>
                                        <th>Alamat</th>
                                        <th>No HP</th>
                                        <!-- Tambahkan kolom sesuai kebutuhan -->
                                        <th>Keterangan Bayar</th>
                                        <th>Janji Bayar</th>
                                        <th>Saldo Nominal</th>
                                        <th>No Rek Debet</th>
                                        <th>Kolektibilitas</th>
                                        <th>Pokok Tunggakan Akhir</th>
                                        <th>Bunga Tunggakan Akhir</th>
                                        <th>Pokok Saldo Akhir</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        include 'konekke_local.php';
                                        $userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';

                                        $kunjunganId = isset($_GET['kunjungan_id']) ? $_GET['kunjungan_id'] : null;
                                        $query = "SELECT 
                                        kunjungan_id,
                                        usersid, 
                                        kode_group1, 
                                        DESKRIPSI_GROUP1, 
                                        no_rek_debet, 
                                        NO_REKENING, 
                                        NASABAH_ID, 
                                        KOLEKTIBILITAS, 
                                        POKOK_TUNGGAKAN_AKHIR, 
                                        BUNGA_TUNGGAKAN_AKHIR, 
                                        SALDO_NOMINATIF, 
                                        POKOK_SALDO_AKHIR, 
                                        SALDO_AKHIR, 
                                        NAMA_NASABAH, 
                                        alamat, 
                                        no_hp, 
                                        keteranganbayar, 
                                        janjibayar, 
                                        kunjungan_path, 
                                        created_at FROM db_kunjungan.kunjungan_bprs 
                                        WHERE kunjungan_id = '$kunjunganId' ORDER BY created_at ASC";
                                        $result = $koneklocalhost->query($query);

                                        $nomorUrutTerakhir = 1;
                                        // Loop melalui hasil query
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<tr>';
                                            // echo '<td>' . $row['kunjungan_id'] . '</td>';
                                            echo "<td>" . $nomorUrutTerakhir . "</td>";
                                            echo '<td>' . $row['usersid'] . '</td>';
                                            // echo '<td>' . $row['KODE_GROUP1'] . '</td>';
                                            echo '<td>' . $row['DESKRIPSI_GROUP1'] . '</td>';
                                            // Tambahkan kolom sesuai kebutuhan
                                            // echo '<td>' . $row['NASABAH_ID'] . '</td>';
                                            echo '<td>' . $row['NAMA_NASABAH'] . '</td>';
                                            echo '<td>' . $row['ALAMAT'] . '</td>';
                                            echo '<td>' . $row['NO_HP'] . '</td>';
                                            // Tambahkan kolom sesuai kebutuhan
                                            echo '<td>' . $row['keteranganbayar'] . '</td>';
                                            echo '<td>' . $row['janjibayar'] . '</td>';
                                            echo '<td>' . $row['SALDO_NOMINATIF'] . '</td>';
                                            echo '<td>' . $row['NO_REK_DEBET'] . '</td>';
                                            echo '<td>' . $row['KOLEKTIBILITAS'] . '</td>';
                                            echo '<td>' . $row['POKOK_TUNGGAKAN_AKHIR'] . '</td>';
                                            echo '<td>' . $row['BUNGA_TUNGGAKAN_AKHIR'] . '</td>';
                                            echo '<td>' . $row['POKOK_SALDO_AKHIR'] . '</td>';
                                            echo '<td>' . $row['created_at'] . '</td>';
                                            $nomorUrutTerakhir++;
                                            echo '</tr>';
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </fieldset>
                    </div>
                </div>


            </main>
        </div>
    </div>
    <?php include 'footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.11.15/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!-- Tambahkan Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Tambahkan event click pada tombol pushmenu
            $('.nav-link[data-widget="pushmenu"]').on('click', function() {
                // Toggle class 'sidebar-collapse' pada elemen body
                $('body').toggleClass('sidebar-collapse');
            });
        });
    </script>
    <script>
            $(document).ready(function () {
            $('#visitTable').DataTable({
                responsive: true,
                scrollX: true,
                searching: true,
                lengthMenu: [25, 50, 100, 500],
                pageLength: 10,
                dom: 'lBfrtip'
            });
        });
    </script>
    <script>
        function refreshPage() {
            location.reload(true);
        }
    </script>
</body>
</html>