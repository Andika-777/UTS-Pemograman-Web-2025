<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../koneksi.php';
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit; }
$monthlyMap = [];
$sql_month = "
  SELECT DATE_FORMAT(tanggal, '%Y-%m') AS ym, COALESCE(SUM(total_harga),0) AS total
  FROM penjualan
  WHERE tanggal IS NOT NULL
  GROUP BY ym
  ORDER BY ym ASC
";
$res_month = mysqli_query($konek, $sql_month);
if ($res_month) {
    while ($r = mysqli_fetch_assoc($res_month)) {
        $ym = isset($r['ym']) ? $r['ym'] : null;
        $t  = isset($r['total']) ? (float)$r['total'] : 0.0;
        if ($ym !== null) $monthlyMap[$ym] = $t;
    }
}
$monthlyLabels = [];
$monthlyData = [];
$now = new DateTime('first day of this month');
for ($i = 11; $i >= 0; $i--) {
    $d = clone $now;
    $d->modify("-{$i} months");
    $ym = $d->format('Y-m');
    $monthlyLabels[] = $ym;
    $monthlyData[] = isset($monthlyMap[$ym]) ? (float)$monthlyMap[$ym] : 0.0;
}
$sales = [];
$sql_sales = "
  SELECT p.penjualan_id, p.tanggal, p.jumlah, p.total_harga,
         b.nama_pembeli, prod.nama_produk
  FROM penjualan p
  LEFT JOIN pembeli b ON p.pembeli_id = b.pembeli_id
  LEFT JOIN produk prod ON p.produk_id = prod.produk_id
  ORDER BY p.tanggal DESC, p.penjualan_id DESC
  LIMIT 200
";
$res_sales = mysqli_query($konek, $sql_sales);
if ($res_sales) {
    while ($r = mysqli_fetch_assoc($res_sales)) $sales[] = $r;
}
include "header.php";
include "sidebar.php";
include "notif.php";
?>
<link rel="stylesheet" href="vendor/datatables/dataTables.bootstrap4.min.css">
<style>
.page-bg { background: #0f111a; color: #eaeaea; }
.card-dark { background:#14151b; border:1px solid rgba(255,255,255,0.04); color:#eaeaea; }
.chart-card { height: 360px; }
.table tbody tr { background: transparent; }
.label-light { color:#d7d7d7; }
.text-success { color:#00c896 !important; }
.text-danger { color:#ff4b5c !important; }
.text-right { text-align:right; }
</style>
<div class="container-fluid page-bg">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="h3 mb-0 text-light">Ringkasan Penjualan</h1>
      <div class="small text-muted">Grafik penjualan bulanan dan daftar transaksi terbaru (read only)</div>
    </div>
  </div>
  <div class="row mb-4">
    <div class="col-lg-8">
      <div class="card card-dark shadow chart-card">
  <div class="card-body">
    <h5 class="text-light">Grafik Penjualan Bulanan (12 bulan terakhir)</h5>
    <div class="chart-wrapper">
      <canvas id="salesChart"></canvas>
    </div>
  </div>
</div>
    </div>
    <div class="col-lg-4">
      <div class="card card-dark shadow mb-4">
        <div class="card-body">
          <h6 class="text-light">Total Ringkasan</h6>
          <?php
            $totalAll = array_sum($monthlyData);
            $lastMonth = count($monthlyData) ? end($monthlyData) : 0;
          ?>
          <div class="mt-3">
            <div class="mb-2"><strong class="text-light">Total Penjualan (12 bulan)</strong></div>
            <div class="h4 text-success">Rp<?= number_format($totalAll,0,',','.') ?></div>
            <div class="mt-3"><strong class="text-light">Penjualan Bulan Terakhir</strong></div>
            <div class="h5 text-light">Rp<?= number_format($lastMonth,0,',','.') ?></div>
          </div>
        </div>
      </div>

      <div class="card card-dark shadow">
        <div class="card-body">
          <h6 class="text-light">Catatan</h6>
          <p class="small text-muted mb-0">Grafik menampilkan total penjualan (dari kolom total_harga) per bulan. Tabel menampilkan hingga 200 transaksi terbaru tanpa fitur ubah/hapus.</p>
        </div>
      </div>
    </div>
  </div>

  <div class="card card-dark shadow">
    <div class="card-body">
      <h5 class="text-light mb-3">Daftar Transaksi Terbaru</h5>
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" id="salesTable" width="100%" cellspacing="0">
          <thead class="thead-dark">
            <tr>
              <th style="width:60px">No</th>
              <th>ID</th>
              <th>Tanggal</th>
              <th>Pembeli</th>
              <th>Produk</th>
              <th>Jumlah</th>
              <th class="text-right">Total Harga</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($sales)): ?>
              <tr><td colspan="7" class="text-center">Belum ada transaksi</td></tr>
            <?php else: $no=1; foreach ($sales as $row): ?>
              <tr>
                <td class="align-middle"><?= $no++; ?></td>
                <td class="align-middle"><?= (int)$row['penjualan_id']; ?></td>
                <td class="align-middle"><?= htmlspecialchars($row['tanggal']); ?></td>
                <td class="align-middle"><?= htmlspecialchars($row['nama_pembeli'] ?? '-'); ?></td>
                <td class="align-middle"><?= htmlspecialchars($row['nama_produk'] ?? '-'); ?></td>
                <td class="align-middle"><?= (int)$row['jumlah']; ?></td>
                <td class="align-middle text-right">Rp<?= number_format((float)$row['total_harga'],0,',','.'); ?></td>
              </tr>
            <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function(){
  $('#salesTable').DataTable({
    "order": [[1,"desc"]],
    "lengthMenu": [10,25,50,100],
    "columnDefs": [{ "orderable": false, "targets": [4] }],
    "language": {
      "search": "Cari:",
      "lengthMenu": "Tampilkan _MENU_ entri",
      "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
      "paginate": { "previous": "Previous", "next": "Next" },
      "zeroRecords": "Data tidak ditemukan"
    }
  });
  const ctx = document.getElementById('salesChart').getContext('2d');
  const labels = <?= json_encode($monthlyLabels, JSON_UNESCAPED_UNICODE) ?>;
  const data = <?= json_encode($monthlyData, JSON_UNESCAPED_UNICODE) ?>;
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: 'Total Penjualan',
        data: data,
        fill: true,
        tension: 0.3,
        borderWidth: 2,
        pointRadius: 3,
        backgroundColor: 'rgba(0,200,150,0.12)',
        borderColor: 'rgba(0,200,150,0.9)',
        pointBackgroundColor: 'rgba(0,200,150,0.9)'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          grid: { color: 'rgba(255,255,255,0.03)' },
          ticks: { color: '#cfd6da' }
        },
        y: {
          grid: { color: 'rgba(255,255,255,0.03)' },
          ticks: {
            color: '#cfd6da',
            callback: function(value){ return 'Rp' + value.toLocaleString(); }
          }
        }
      },
      plugins: {
        legend: { labels: { color: '#e9ecef' } },
        tooltip: {
          callbacks: {
            label: function(context){
              let v = context.parsed.y || 0;
              return 'Rp' + v.toLocaleString();
            }
          }
        }
      }
    }
  });
});
</script>
<?php include "footer.php"; ?>
