<?php
include "header.php";
include "sidebar.php";
include "notif.php";
?>
<script>
function yakinhapus() {
  return confirm('Apakah Anda yakin ingin menghapus data produk ini?');
}
</script>
<style>
.thumb { width:60px; height:60px; object-fit:cover; border-radius:6px; border:1px solid rgba(0,0,0,0.06); }
.table td, .table th { vertical-align: middle; }
</style>
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-light">Data Produk</h1>
    <a href="produk_tambah.php" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Produk</a>
  </div>
  <div class="card border-0 shadow">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
          <thead class="thead-dark">
            <tr>
              <th style="width:60px">No</th>
              <th>Gambar</th>
              <th>Nama Produk</th>
              <th>Kategori</th>
              <th>Harga</th>
              <th>Stok</th>
              <th style="width:140px">Aksi</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $sql = "SELECT p.*, k.nama_kategori 
                  FROM produk p
                  LEFT JOIN kategori k ON p.kategori_id = k.kategori_id
                  ORDER BY p.produk_id ASC";
          $query = mysqli_query($konek, $sql);
          if (!$query) {
              echo '<tr><td colspan="7" class="text-danger">Query error: ' . mysqli_error($konek) . '</td></tr>';
          } else {
              $no = 1;
              if (mysqli_num_rows($query) == 0) {
                  echo '<tr><td colspan="7" class="text-center">Belum ada produk.</td></tr>';
              } else {
                  while ($row = mysqli_fetch_assoc($query)) {
                      $foto_file = (!empty($row['foto']) && file_exists(__DIR__.'/img/'.$row['foto'])) ? 'img/'.$row['foto'] : 'img/no-image.png';
                      $harga = is_numeric($row['harga']) ? 'Rp'.number_format($row['harga'],0,',','.') : '-';
                      $stok = isset($row['stok']) ? (int)$row['stok'] : 0;
                      $nama = htmlspecialchars($row['nama_produk']);
                      $kategori = htmlspecialchars($row['nama_kategori'] ?? '-');
                      $id = (int)$row['produk_id'];
                  ?>
            <tr>
              <td class="align-middle"><?= $no++; ?></td>
              <td class="align-middle"><img src="<?= $foto_file ?>" alt="foto" class="thumb"></td>
              <td class="align-middle"><?= $nama; ?></td>
              <td class="align-middle"><?= $kategori; ?></td>
              <td class="align-middle"><?= $harga; ?></td>
              <td class="align-middle"><?= $stok; ?></td>
              <td class="align-middle">
                <a href="produk_ubah.php?id=<?= $id; ?>" class="btn btn-warning btn-sm">Ubah</a>
                <a href="produk_hapus.php?id=<?= $id; ?>" onclick="return yakinhapus()" class="btn btn-danger btn-sm">Hapus</a>
              </td>
            </tr>
          <?php
                  }
              }
          }
          ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function(){
  $('#dataTable').DataTable({
    "order": [[0, "asc"]],
    "columnDefs": [{ "orderable": false, "targets": [1,6] }],
    "lengthMenu": [10,25,50,100],
    "language": {
      "search": "Cari:",
      "lengthMenu": "Tampilkan _MENU_ entri",
      "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
      "paginate": { "previous": "Previous", "next": "Next" },
      "zeroRecords": "Data tidak ditemukan"
    }
  });
});
</script>
<?php include "footer.php"; ?>
