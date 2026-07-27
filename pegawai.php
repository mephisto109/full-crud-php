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

$title = "Daftar pegawai";
include 'layout/header.php';



$data_pegawai = select("SELECT * FROM pegawai ORDER BY id_pegawai DESC");
?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar pegawai</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="pegawai.php">Home</a></li>
                        <li class="breadcrumb-item active">pegawai</li>
                    </ol>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data pegawai</h3>
                                    <div class="card-tools float-right">
                                        <a href="crud-modal.php" class="btn btn-primary btn-sm mr-2">
                                            <i class="fas fa-plus-circle"></i> Tambah Data
                                        </a>
                                        <button type="button" class="btn btn-success btn-sm">
                                            <i class="fas fa-search"></i> Filter Data
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    
                                    <table id="table" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Jabatan</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Telepon</th>
                                                <th scope="col">Alamat</th>
                                            </tr>
                                        </thead>

                                        <tbody id="live_data">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="chartPegawaiWrapper" style="display:none;">
                        <div class="col-12 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i> Distribusi Pegawai per Jabatan</h3>
                                </div>
                                <div class="card-body">
                                    <div style="position:relative; height:290px;">
                                        <canvas id="chartJabatanPegawai"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
    var chartJabatanPegawaiInstance = null;

    // Polling tabel dijalankan terpisah dari Chart.js, supaya tabel tetap jalan
    // walaupun Chart.js belum siap. Interval pendek cukup untuk demo, ubah jika perlu.
    $(document).ready(function() {
        setInterval(function() {
            getPegawai()
        }, 200);
    });

    function getPegawai() {
        $.ajax({
            url: "realtime-pegawai.php",
            type: "GET",
            success: function(response_rahma) {
                $('#live_data').html(response_rahma);
                updateChartJabatan();
            }
        });
    }

    // Menghitung distribusi jabatan langsung dari baris tabel yang sudah tampil
    function updateChartJabatan() {
        if (typeof Chart === 'undefined') return;

        var counts = {};
        $('#live_data tr').each(function () {
            var jabatan = $(this).find('td').eq(2).text().trim();
            if (jabatan) {
                counts[jabatan] = (counts[jabatan] || 0) + 1;
            }
        });

        var labels = Object.keys(counts);
        var values = Object.values(counts);
        var wrapper = document.getElementById('chartPegawaiWrapper');
        var ctx = document.getElementById('chartJabatanPegawai');

        if (labels.length === 0) {
            if (wrapper) wrapper.style.display = 'none';
            return;
        }
        if (wrapper) wrapper.style.display = '';

        var palette = ['#007bff', '#28a745', '#ffc107', '#17a2b8', '#e83e8c', '#6f42c1', '#fd7e14'];

        if (chartJabatanPegawaiInstance) {
            chartJabatanPegawaiInstance.data.labels = labels;
            chartJabatanPegawaiInstance.data.datasets[0].data = values;
            chartJabatanPegawaiInstance.update();
        } else if (ctx) {
            // Chart.js v2 defaults
            if (Chart.defaults && Chart.defaults.global) {
                Chart.defaults.global.defaultFontFamily = "'Source Sans Pro', -apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif";
                Chart.defaults.global.defaultFontColor = '#6c757d';
            }

            chartJabatanPegawaiInstance = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: palette,
                        borderColor: '#ffffff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutoutPercentage: 60,
                    legend: { position: 'bottom', labels: { boxWidth: 14, padding: 15 } },
                    tooltips: { backgroundColor: '#343a40' }
                }
            });
        }
    }
</script>
<script>
window.addEventListener("pageshow", function(event) {
    if (event.persisted) {
        window.location.reload();
    }
});
</script>

<?php include 'layout/footer.php' ?>