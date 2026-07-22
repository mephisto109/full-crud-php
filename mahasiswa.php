<?php
session_start();
// membatasi halaman sebelum login
if (!isset($_SESSION['login'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            document.location.href = 'login.php';
        </script>";
}

// membatasi halaman berdasarkan user login
if ($_SESSION['level'] != 1 && $_SESSION['level'] != 3) {
    echo "<script>
            alert('Anda tidak memiliki akses ke halaman ini!');
            document.location.href = 'crud-modal.php';
        </script>";
    exit;
}

$title = "Daftar Mahasiswa";
include 'layout/header.php';



$data_mahasiswa = select("SELECT * FROM mahasiswa ORDER BY id_mahasiswa DESC");

// agregasi jenis kelamin & program studi untuk grafik (dihitung dari data_mahasiswa yang sudah ada)
$chart_jk_labels = ['Laki-laki', 'Perempuan'];
$chart_jk_counts = [0, 0];
$chart_prodi_counts = [];
foreach ($data_mahasiswa as $mhs_c) {
    $jk = strtoupper(trim($mhs_c['jk']));
    if ($jk == 'L' || $jk == 'LAKI-LAKI') {
        $chart_jk_counts[0]++;
    } elseif ($jk == 'P' || $jk == 'PEREMPUAN') {
        $chart_jk_counts[1]++;
    }

    $prodi = $mhs_c['prodi'];
    if (!isset($chart_prodi_counts[$prodi])) {
        $chart_prodi_counts[$prodi] = 0;
    }
    $chart_prodi_counts[$prodi]++;
}
$chart_prodi_labels = array_keys($chart_prodi_counts);
$chart_prodi_values = array_values($chart_prodi_counts);
?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar Mahasiswa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="mahasiswa.php">Home</a></li>
                        <li class="breadcrumb-item active">Mahasiswa</li>
                    </ol>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data mahasiswa</h3>
                                </div>
                                <div class="card-body">
                                    <a href="tambah-mahasiswa.php" class="btn btn-primary mb-3"><i class="fas fa-plus-circle"></i> Tambah</a>
                                    <a href="download-excel-mahasiswa.php" class="btn btn-success mb-3"><i class="fas fa-file-excel"></i> Download Excel</a>
                                    <a href="download-pdf-mahasiswa.php" class="btn btn-danger mb-3"><i class="fas fa-file-pdf"></i> Download PDF</a>
                                    
                                    <table class="table table-bordered table-striped" id="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">prodi</th>
                                                <th scope="col">Jenis Kelamin</th>
                                                <th scope="col">Telepon</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach ($data_mahasiswa as $mahasiswa) {
                                            ?>
                                                <tr>
                                                    <th scope="row"><?= $no++; ?></th>
                                                    <td><?= strip_tags($mahasiswa['nama']); ?></td>
                                                    <td><?= strip_tags($mahasiswa['prodi']); ?></td>
                                                    <td><?= strip_tags($mahasiswa['jk']); ?></td>
                                                    <td><?= strip_tags($mahasiswa['telepon']); ?></td>
                                                    
                                                    <td>
                                                        <a href="detail-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa']; ?>" class="btn btn-secondary">Detail</a>
                                                        <a href="ubah-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa']; ?>" class="btn btn-success">Edit</a>
                                                        <a href="hapus-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                                    </td>
                                                </tr>
                                            <?php
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (count($data_mahasiswa) > 0): ?>
                    <div class="row">
                        <div class="col-12 col-lg-5">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i> Distribusi Jenis Kelamin</h3>
                                </div>
                                <div class="card-body">
                                    <div style="position:relative; height:290px;">
                                        <canvas id="chartJkMahasiswa"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-7">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-chart-bar mr-1"></i> Jumlah Mahasiswa per Program Studi</h3>
                                </div>
                                <div class="card-body">
                                    <div style="position:relative; height:290px;">
                                        <canvas id="chartProdiMahasiswa"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>
</div>

<?php if (count($data_mahasiswa) > 0): ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
    (function () {
        Chart.defaults.font.family = "'Source Sans Pro', -apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif";
        Chart.defaults.color = '#6c757d';

        var ctxJk = document.getElementById('chartJkMahasiswa');
        if (ctxJk) {
            new Chart(ctxJk, {
                type: 'doughnut',
                data: {
                    labels: <?= json_encode($chart_jk_labels); ?>,
                    datasets: [{
                        data: <?= json_encode($chart_jk_counts); ?>,
                        backgroundColor: ['#007bff', '#e83e8c'],
                        borderColor: '#ffffff',
                        borderWidth: 2,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '60%',
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 14, padding: 15 } },
                        tooltip: { backgroundColor: '#343a40', cornerRadius: 4 }
                    }
                }
            });
        }

        var ctxProdi = document.getElementById('chartProdiMahasiswa');
        if (ctxProdi) {
            new Chart(ctxProdi, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($chart_prodi_labels); ?>,
                    datasets: [{
                        label: 'Jumlah Mahasiswa',
                        data: <?= json_encode($chart_prodi_values); ?>,
                        backgroundColor: '#17a2b8',
                        borderRadius: 4,
                        maxBarThickness: 45
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { backgroundColor: '#343a40', cornerRadius: 4 }
                    },
                    scales: {
                        x: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#eef0f2' } },
                        y: { grid: { display: false } }
                    }
                }
            });
        }
    })();
</script>
<?php endif; ?>

<?php include 'layout/footer.php' ?>