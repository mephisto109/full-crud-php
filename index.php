<?php
session_start();

// Membatasi halaman sebelum login
if (!isset($_SESSION['login'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            document.location.href = 'login.php';
        </script>";
    exit;
}

// Membatasi halaman berdasarkan user login
if ($_SESSION['level'] != 1 && $_SESSION['level'] != 2) {
    echo "<script>
            alert('Anda tidak memiliki akses ke halaman ini!');
            document.location.href = 'crud-modal.php';
        </script>";
    exit;
}

$title = "Data Barang";

// Include header cukup SEKALI di sini, setelah semua validasi lolos
include 'layout/header.php';

if (isset($_POST['filter'])) {
    $tgl_awal = strip_tags($_POST['tgl_awal'] . " 00:00:00");
    $tgl_akhir = strip_tags($_POST['tgl_akhir'] . " 23:59:59");

    // query filter data
    $data_barang = select("SELECT * FROM barang WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id_barang DESC");
} else {
    // query tampil data dengan pagination
    $jumlahDataPerHalaman = 10;
    $jumlahData = count(select("SELECT * FROM barang"));
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
    $halamanAktif = (isset($_GET['halaman'])) ? $_GET['halaman'] : 1;
    $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

    $data_barang = select("SELECT * FROM barang ORDER BY id_barang DESC LIMIT $awalData, $jumlahDataPerHalaman");
}

// agregasi data barang yang sedang tampil untuk kebutuhan grafik (tidak menambah data baru)
$chart_barang_nama = [];
$chart_barang_jumlah = [];
$chart_barang_harga = [];
foreach ($data_barang as $barang_c) {
    $chart_barang_nama[] = $barang_c['nama'];
    $chart_barang_jumlah[] = (int) $barang_c['jumlah'];
    $chart_barang_harga[] = (float) $barang_c['harga'];
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="tambah-barang.php" class="btn btn-primary btn-sm float-right"><i
                                            class="fas fa-plus-circle"></i> Tambah Data</a>

                                    <button type="button" class="btn btn-success btn-sm mb-2" data-toggle="modal"
                                        data-target="#modalFilter">
                                        <i class="fas fa-search"></i> Filter Data
                                    </button>
                                </div>
                                <div class="card-body">
                                    <!-- ID tabel disesuaikan ke 'table' agar JavaScript DataTables di footer.php berjalan sempurna -->
                                    <table class="table table-bordered table-striped" id="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Jumlah</th>
                                                <th scope="col">Harga</th>
                                                <th scope="col">Barcode</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach ($data_barang as $barang) {
                                                ?>
                                                <tr>
                                                    <th scope="row"><?= $no++; ?></th>
                                                    <td><?= $barang['nama']; ?></td>
                                                    <td><?= $barang['jumlah']; ?></td>
                                                    <td>Rp. <?= number_format($barang['harga'], 0, ',', '.'); ?></td>
                                                    <td class="text-center">
                                                        <img alt="barcode"
                                                            src="barcode.php?codetype=code128&size=15&text=<?= $barang['barcode']; ?>&print=true" />
                                                    </td>
                                                    <td><?= date('d/m/y | H:i:s', strtotime($barang['tanggal'])); ?>
                                                    </td>
                                                    <td>
                                                        <a href="ubah-barang.php?id_barang=<?= $barang['id_barang']; ?>"
                                                            class="btn btn-success">Edit</a>
                                                        <a href="hapus-barang.php?id_barang=<?= $barang['id_barang']; ?>"
                                                            class="btn btn-danger"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                                    </td>
                                                </tr>
                                                <?php
                                            } ?>
                                        </tbody>
                                    </table>
                                    <div class="mt-2 justify-content-endd-flex">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                <?php if ($halamanAktif > 1): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?halaman=<?= $halamanAktif - 1 ?>"
                                                            aria-label="Previous">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>

                                                <?php for ($i = 1; $i <= $jumlahHalaman; $i++): ?>
                                                    <?php if ($i == $halamanAktif): ?>
                                                        <li class="page-item active"><a class="page-link"
                                                                href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
                                                    <?php else: ?>
                                                        <li class="page-item"><a class="page-link"
                                                                href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
                                                    <?php endif; ?>
                                                <?php endfor; ?>

                                                <?php if ($halamanAktif < $jumlahHalaman): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?halaman=<?= $halamanAktif + 1 ?>"
                                                            aria-label="Next">
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (count($chart_barang_nama) > 0): ?>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-chart-bar mr-1"></i> Perbandingan Jumlah Barang</h3>
                                </div>
                                <div class="card-body">
                                    <div style="position:relative; height:300px;">
                                        <canvas id="chartJumlahBarang"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-chart-bar mr-1"></i> Perbandingan Harga Barang</h3>
                                </div>
                                <div class="card-body">
                                    <div style="position:relative; height:300px;">
                                        <canvas id="chartHargaBarang"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </section>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
</div>
<!-- /.content-wrapper -->

<!-- ./ Modal Filter Data: kotak popup buat filter data barang berdasarkan rentang tanggal -->
<div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="modalFilterLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <!-- Judul modal, ada ikon kaca pembesar di depannya -->
                <h5 class="modal-title" id="modalFilterLabel"><i class="fas fa-search"></i> Filter Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Form ini yang bakal bawa tanggal awal & akhir pas di-submit -->
            <form action="" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tgl_awal">Tanggal Awal</label>
                        <input type="date" name="tgl_awal" id="tgl_awal" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tgl_akhir">Tanggal Akhir</label>
                        <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="index.php" class="btn btn-outline-danger btn-sm mr-auto">Reset Filter</a>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm" name="filter">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#modalFilter').appendTo('body');
    });
</script>

<?php if (count($chart_barang_nama) > 0): ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
    (function () {
        Chart.defaults.font.family = "'Source Sans Pro', -apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif";
        Chart.defaults.color = '#6c757d';

        var namaBarang = <?= json_encode($chart_barang_nama); ?>;
        var jumlahBarang = <?= json_encode($chart_barang_jumlah); ?>;
        var hargaBarang = <?= json_encode($chart_barang_harga); ?>;

        var ctxJumlah = document.getElementById('chartJumlahBarang');
        if (ctxJumlah) {
            new Chart(ctxJumlah, {
                type: 'bar',
                data: {
                    labels: namaBarang,
                    datasets: [{
                        label: 'Jumlah',
                        data: jumlahBarang,
                        backgroundColor: '#007bff',
                        borderRadius: 4,
                        maxBarThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { backgroundColor: '#343a40', cornerRadius: 4 }
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#eef0f2' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        var ctxHarga = document.getElementById('chartHargaBarang');
        if (ctxHarga) {
            new Chart(ctxHarga, {
                type: 'bar',
                data: {
                    labels: namaBarang,
                    datasets: [{
                        label: 'Harga (Rp)',
                        data: hargaBarang,
                        backgroundColor: '#28a745',
                        borderRadius: 4,
                        maxBarThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#343a40',
                            cornerRadius: 4,
                            callbacks: {
                                label: function (ctx) {
                                    return 'Rp. ' + ctx.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#eef0f2' },
                            ticks: {
                                callback: function (value) {
                                    return 'Rp. ' + value.toLocaleString('id-ID');
                                }
                            }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
    })();
</script>
<script>
window.addEventListener("pageshow", function(event) {
    if (event.persisted) {
        window.location.reload();
    }
});
</script>
<?php endif; ?>

<?php include 'layout/footer.php' ?>