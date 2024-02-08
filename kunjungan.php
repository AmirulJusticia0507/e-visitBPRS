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
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kunjungan</li>
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
                            <center><legend><h3><b>=> E-Visit BPRS HIK MCI <=</b></h3></legend></center><br>
                            <form id="cekVisitForm" method="get">
                                <label for="searchNoRekening">Cari No Rekening Nasabah :</label>
                                <div class="row">
                                    <div class="col mb-3">
                                        <div class="form-group">
                                            <!-- <input type="text" name="SEARCH_NO_REKENING" id="searchNoRekening" class="form-control" style="width: 100%;" oninput="this.value = this.value.replace(/[^0-9.]/g, '');" maxlength="13" autocomplete="off"> -->                                            <input type="text" name="SEARCH_NO_REKENING" id="searchNoRekening" class="form-control" style="width: 100%;" placeholder="Masukkan nomor rekening Pembiayaan atau nama Nasabah" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col mb-3">
                                        <div class="form-group">
                                            <button type="submit" class="myButtonCekSaldo" id="cariNoRekening"><i class="fa fa-search"></i> Cari</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </fieldset>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <fieldset>
                            <legend>Informasi Visit :</legend>
                            <form action="process_entry_visit.php" method="post" id="informasiVisitForm" enctype="multipart/form-data">
                                <!-- Tambahkan input hidden untuk menyimpan noRekening -->
                                <input type="hidden" id="selectedNoRekening" name="noRekening">

                                <!-- <div class="row">
                                    <div class="col mb-3">
                                        <label for="kodeGroup1">Kode Group 1:</label>
                                        <input type="text" id="kodeGroup1" name="kodeGroup1" style="width: 100%;" class="form-control" readonly>
                                    </div>
                                </div> -->
                                <input type="hidden" id="kodeGroup1" name="kodeGroup1" style="width: 100%;" class="form-control" >
                                <div class="col mb-3">
                                    <label for="deskripsiGroup1">Nama Account Officer :</label>
                                    <!-- <textarea name="deskripsiGroup1" id="deskripsiGroup1" cols="3" rows="1" class="form-control" readonly></textarea> -->
                                    <input type="text" id="deskripsiGroup1" name="deskripsiGroup1" class="form-control" placeholder="Nama Account Officer" readonly>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="noRekening">No Rekening Pembiayaan:</label>
                                        <input type="text" id="noRekening" name="noRekening" class="form-control" placeholder="No Rekening Pembiayaan" readonly>
                                    </div>
                                    <input type="hidden" id="nasabahId" name="nasabahId" class="form-control" >
                                    <!-- <div class="col mb-3">
                                        <label for="nasabahId">Nasabah ID:</label>
                                        <input type="text" id="nasabahId" name="nasabahId" class="form-control" readonly>
                                    </div> -->
                                </div><hr>
                                <div class="col mb-3">
                                    <label for="namaNasabah">Nama Nasabah:</label>
                                    <input type="text" id="namaNasabah" name="namaNasabah" class="form-control" placeholder="Nama Nasabah" readonly>
                                    <!-- <textarea name="namaNasabah" id="namaNasabah" cols="1" rows="1" class="form-control" readonly></textarea> -->
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="noRekDebet">No Rek Tabungan:</label>
                                        <input type="text" id="noRekDebet" name="noRekDebet" class="form-control" placeholder="No Rekening Tabungan" readonly>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="kolektibilitas">Kolektibilitas:</label>
                                        <input type="text" id="kolektibilitas" name="kolektibilitas" class="form-control" placeholder="Kolektibilitas" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="pokokTunggakanAkhir">Pokok Tung. Akhir:</label>
                                        <input type="text" id="pokokTunggakanAkhir" name="pokokTunggakanAkhir" class="form-control" placeholder="Pokok Tunggakan Akhir" readonly>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="bungaTunggakanAkhir">Bunga Tung. Akhir:</label>
                                        <input type="text" id="bungaTunggakanAkhir" name="bungaTunggakanAkhir" class="form-control" placeholder="Bunga Tunggakan Akhir" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="pokokSaldoAkhir">Pokok Saldo Akhir:</label>
                                        <input type="text" id="pokokSaldoAkhir" name="pokokSaldoAkhir" class="form-control" placeholder="Pokok Saldo Akhir" readonly>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="saldoAkhirTabung">Saldo Tabungan :</label>
                                        <input type="text" id="saldoAkhirTabung" name="saldoAkhirTabung" class="form-control" placeholder="Saldo Tabungan" readonly>
                                    </div>
                                </div><hr>
                                <div class="row">
                                    <div class="col">
                                        <label for="alamat">Alamat:</label>
                                        <textarea name="alamat" id="alamat" cols="10" rows="10" placeholder="Alamat Nasabah" class="form-control" readonly></textarea>
                                        <!-- <input type="text" id="alamat" name="alamat" class="form-control" readonly> -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="noHp">Nomor HP:</label>
                                        <input type="text" id="noHp" name="noHp" class="form-control" placeholder="Nomor HP Nasabah" readonly>
                                    </div>
                                    <!-- <div class="col">
                                        <label for="saldoNominal">Saldo Nominal:</label>
                                        <input type="text" id="saldoNominal" name="saldoNominal" class="form-control" readonly>
                                    </div> -->
                                </div><hr>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="keteranganBayar">Hasil Kunjungan :</label>
                                        <textarea name="keteranganBayar" id="keteranganBayar" cols="10" rows="10" placeholder="Hasil Kunjungan Account Officer ke Nasabah" class="form-control" required></textarea>
                                        <!-- <input type="text" id="alamat" name="alamat" class="form-control" readonly> -->
                                    </div>
                                </div>
                                <div class="col mb-3">
                                    <label for="janjiBayar">Janji Bayar : </label>
                                    <input type="date" class="form-control" name="janjiBayar" id="janjiBayar" required min="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="kunjunganPath">Upload Foto Kunjungan:</label>
                                        <div class="drop-zone" id="dropZone">
                                            <span class="drop-zone__prompt">Please insert file photo in here</span>
                                            <input type="file" name="kunjunganPath[]" id="kunjunganPath" class="form-control" accept=".jpg" multiple>
                                        </div>
                                        <div id="fileList"></div>
                                    </div>
                                </div>
                                <br><br>
                                <!-- Tombol Submit -->
                                <div align="center">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-download"></i> Submit</button>
                                    <button type="reset" class="btn btn-danger"><i class="fa fa-power-off"> Reset</i></button>
                                </div>
                            </form>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!-- Tambahkan Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#searchNoRekening").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "autocomplete.php", // Ganti dengan URL yang sesuai untuk proses autocomplete
                        method: "POST",
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                minLength: 2, // Jumlah karakter minimal sebelum autocomplete diaktifkan
                select: function(event, ui) {
                    // Handle ketika item autocomplete dipilih
                    $("#searchNoRekening").val(ui.item.value);
                    $("#namaNasabah").val(ui.item.namaNasabah);
                    $("#cekVisitForm").submit(); // Otomatis submit form setelah memilih item
                }
            });

            function formatRupiah(number) {
                var reverse = number.toString().split('').reverse().join(''),
                    ribuan = reverse.match(/\d{1,3}/g);
                ribuan = ribuan.join('.').split('').reverse().join('');
                return 'Rp ' + ribuan;
            }

            $("#cekVisitForm").submit(function(e) {
                e.preventDefault();
                var noRekening = $("#searchNoRekening").val();
                
                $.ajax({
                    type: "GET",
                    url: "process_search_visit.php",
                    data: { SEARCH_NO_REKENING: noRekening },
                    success: function(data) {
                        var result = JSON.parse(data);
                        if (result) {
                            // Isi formulir informasi visit sesuai dengan data yang ditemukan
                            $("#kodeGroup1").val(result.KODE_GROUP1);
                            $("#deskripsiGroup1").val(result.DESKRIPSI_GROUP1);
                            $("#noRekening").val(result.NO_REKENING);
                            $("#nasabahId").val(result.NASABAH_ID);
                            $("#namaNasabah").val(result.NAMA_NASABAH);
                            $("#alamat").val(result.alamat);
                            $("#noHp").val(result.no_hp);
                            $("#saldoNominal").val(formatRupiah(result.SALDO_NOMINATIF));
                            // $("#saldoNominal").val(result.SALDO_NOMINATIF);
                            $("#noRekDebet").val(result.no_rek_debet);
                            $("#kolektibilitas").val(result.KOLEKTIBILITAS);
                            $("#pokokTunggakanAkhir").val(formatRupiah(result.POKOK_TUNGGAKAN_AKHIR));
                            $("#bungaTunggakanAkhir").val(formatRupiah(result.BUNGA_TUNGGAKAN_AKHIR));
                            $("#pokokSaldoAkhir").val(formatRupiah(result.pokok_SALDO_AKHIR));

                            // Atur nilai selectedNoRekening
                            $("#selectedNoRekening").val(result.NO_REKENING);

                            // Tampilkan formulir informasi visit
                            $("#informasiVisitForm").show();
                        } else {
                            // Tampilkan pesan jika data tidak ditemukan
                            alert("Data tidak ditemukan");
                        }
                    },
                    error: function() {
                        alert("Error saat melakukan permintaan data.");
                    }
                });
            });
        });
    </script>
    <script>
        const dropZone = document.getElementById('dropZone');
        const fileList = document.getElementById('fileList');
        const inputKunjunganPath = document.getElementById('kunjunganPath');

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('drop-zone--over');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('drop-zone--over');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();

            dropZone.classList.remove('drop-zone--over');

            const files = e.dataTransfer.files;
            updateFileList(files);
        });

        inputKunjunganPath.addEventListener('change', () => {
            const files = inputKunjunganPath.files;
            updateFileList(files);
        });

        function updateFileList(files) {
            fileList.innerHTML = '';

            for (const file of files) {
                const listItem = document.createElement('div');
                listItem.textContent = file.name;
                fileList.appendChild(listItem);
            }
        }
    </script>
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