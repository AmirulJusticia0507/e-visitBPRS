<?php
// Mulai sesi
session_start();

// Periksa apakah pengguna telah terautentikasi
if (!isset($_SESSION['userid'])) {
    // Jika tidak ada sesi pengguna, alihkan ke halaman login
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>E - Visit BPRS</title>
    <!-- Tambahkan link Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Tambahkan link AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    <link rel="icon" href="img/logo_white.png" type="image/png">
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
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
                
                        case 'dashboard':
                            if ($currentPage !== 'index.php') {
                                header("Location: index.php?page=dashboard");
                                exit;
                            }
                            break;
                
                        default:
                            // Handle cases for other pages or provide a default action
                            break;
                    }
                }
                ?>

                <div class="row">
                    <?php
                    include 'konekke_local.php';

                    // Query untuk mengambil jumlah kunjungan
                    $queryJumlahKunjungan = "SELECT COUNT(*) as jumlah_kunjungan FROM db_kunjungan.kunjungan_bprs";
                    $resultJumlahKunjungan = $koneklocalhost->query($queryJumlahKunjungan);

                    // Ambil nilai jumlah kunjungan
                    if ($resultJumlahKunjungan->num_rows > 0) {
                        $dataJumlahKunjungan = $resultJumlahKunjungan->fetch_assoc();
                        $jumlahKunjungan = $dataJumlahKunjungan['jumlah_kunjungan'];
                    } else {
                        $jumlahKunjungan = 0;
                    }

                    // Tutup koneksi ke database
                    $koneklocalhost->close();
                    ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body" align="center">
                                <center><h5 class="card-title"><b>Data Kunjungan</b></h5></center>
                                <img src="img/visiting.png" alt="" style="width: 200px; height: 150px;">
                                <p class="card-text">Jumlah Kunjungan: <?php echo $jumlahKunjungan; ?></p>
                                <a href="kunjungan.php?page=kunjungan" class="myButtonCekSaldo">
                                    <i class="fas fa-street-view"></i> Lihat Detail Kunjungan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </main>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <!-- Tambahkan skrip Bootstrap dan AdminLTE JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
    <script>
        $(document).ready(function() {
            // Tambahkan event click pada tombol pushmenu
            $('.nav-link[data-widget="pushmenu"]').on('click', function() {
                // Toggle class 'sidebar-collapse' pada elemen body
                $('body').toggleClass('sidebar-collapse');
            });
        });
    </script>
</body>
</html>
