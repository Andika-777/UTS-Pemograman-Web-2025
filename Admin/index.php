<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "header.php";
include "sidebar.php";

$q_produk    = mysqli_query($konek, "SELECT COUNT(*) AS total_produk FROM produk");
$q_kategori  = mysqli_query($konek, "SELECT COUNT(*) AS total_kategori FROM kategori");
$q_pembeli   = mysqli_query($konek, "SELECT COUNT(*) AS total_pembeli FROM pembeli");
$q_user      = mysqli_query($konek, "SELECT COUNT(*) AS total_user FROM user");
$q_penjualan = mysqli_query($konek, "SELECT COUNT(*) AS total_penjualan FROM penjualan");
$d_produk    = mysqli_fetch_assoc($q_produk);
$d_kategori  = mysqli_fetch_assoc($q_kategori);
$d_pembeli   = mysqli_fetch_assoc($q_pembeli);
$d_user      = mysqli_fetch_assoc($q_user);
$d_penjualan = mysqli_fetch_assoc($q_penjualan);
function status_badge($count) {
    return ($count > 0)
        ? '<span class="badge badge-success">Tersedia</span>'
        : '<span class="badge badge-danger">Kosong</span>';
}
?>
<div class="container-fluid">
  <h1 class="h3 mb-4 text-light-800">Dashboard My Style</h1>
  <div class="row">
    <div class="col-md-4 mb-3">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Produk</div>
          <div class="d-flex align-items-center justify-content-between">
            <div class="h5 mb-0 font-weight-bold text-light-800"><?= (int)$d_produk['total_produk']; ?></div>
            <?= status_badge($d_produk['total_produk']); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Kategori</div>
          <div class="d-flex align-items-center justify-content-between">
            <div class="h5 mb-0 font-weight-bold text-light-800"><?= (int)$d_kategori['total_kategori']; ?></div>
            <?= status_badge($d_kategori['total_kategori']); ?>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-3">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Pembeli</div>
          <div class="d-flex align-items-center justify-content-between">
            <div class="h5 mb-0 font-weight-bold text-light-800"><?= (int)$d_pembeli['total_pembeli']; ?></div>
            <?= status_badge($d_pembeli['total_pembeli']); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total User (Admin)</div>
          <div class="d-flex align-items-center justify-content-between">
            <div class="h5 mb-0 font-weight-bold text-light-800"><?= (int)$d_user['total_user']; ?></div>
            <?= status_badge($d_user['total_user']); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Penjualan</div>
          <div class="d-flex align-items-center justify-content-between">
            <div class="h5 mb-0 font-weight-bold text-light-800"><?= (int)$d_penjualan['total_penjualan']; ?></div>
            <?= status_badge($d_penjualan['total_penjualan']); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-12 mb-4">
      <div class="card shadow">
        <div class="card-body">
          <h6 class="text-uppercase mb-3">Grafik Penjualan per Produk</h6>
          <canvas id="barChart" style="min-height:300px;"></canvas>
        </div>
      </div>
    </div>

    <div class="col-12 mb-4">
      <div class="card shadow">
        <div class="card-body">
          <h6 class="text-uppercase mb-3">Pendapatan Harian</h6>
          <canvas id="lineChart" style="min-height:300px;"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
$q_chart1 = mysqli_query($konek, "
    SELECT p.nama_produk, 
           IFNULL(SUM(j.jumlah), 0) AS total_terjual
    FROM produk p
    LEFT JOIN penjualan j ON p.produk_id = j.produk_id
    GROUP BY p.produk_id, p.nama_produk");

if (!$q_chart1) {
    die("<b>SQL Error Grafik Produk:</b> " . mysqli_error($konek));
}

$q_chart2 = mysqli_query($konek, "
    SELECT DATE(tanggal) AS tgl, SUM(total_harga) AS total 
    FROM penjualan 
    GROUP BY DATE(tanggal)
    ORDER BY tgl ASC");

if (!$q_chart2) {
    die("<b>SQL Error Grafik Pendapatan:</b> " . mysqli_error($konek));}
$produk = [];
$total_terjual = [];
while ($row = mysqli_fetch_assoc($q_chart1)) {
    $produk[] = $row['nama_produk'];
    $total_terjual[] = $row['total_terjual'];
}

$tanggal = [];
$total = [];
while ($row = mysqli_fetch_assoc($q_chart2)) {
    $tanggal[] = $row['tgl'];
    $total[] = $row['total'];
}

?>
<script src="vendor/chart.js/Chart.min.js"></script>
<script>
const totalTerjual = <?= json_encode($total_terjual) ?>; 
const maxY = Math.max.apply(null, totalTerjual); 
const barCtx = document.getElementById('barChart').getContext('2d');
new Chart(barCtx, {
  type: 'bar',
  data: {
    labels: <?= json_encode($produk) ?>,
    datasets: [{
      label: 'Total Terjual',
      data: totalTerjual,
      backgroundColor: 'rgba(0, 200, 150, 0.7)',
      borderRadius: 8
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { labels: { color: '#fff' } },
      title: { color: '#fff' }
    },
    layout: {
      padding: {
        bottom: 20 
      }
    },
    scales: {
      x: {
        ticks: { color: '#fff' },
        grid: { color: 'rgba(255,255,255,0.1)' }
      },
      y: {
        beginAtZero: true,
        grace: '25%', 
        ticks: {
          color: '#fff',
          stepSize: 1
        },
        grid: { color: 'rgba(255,255,255,0.1)' }
      }
    }
  }
}); 
const lineCtx = document.getElementById('lineChart').getContext('2d');
new Chart(lineCtx, {
  type: 'line',
  data: {
    labels: <?= json_encode($tanggal) ?>,
    datasets: [{
      label: 'Total Pendapatan',
      data: <?= json_encode($total) ?>,
      fill: true,
      borderColor: '#00c896',
      backgroundColor: 'rgba(0, 200, 150, 0.2)',
      tension: 0.3
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { labels: { color: '#fff' } },
      title: { color: '#fff' }
    },
    scales: {
      x: { ticks: { color: '#fff' } },
      y: { ticks: { color: '#fff' } }
    }
  }
});
</script>
<?php include "footer.php"; ?>
