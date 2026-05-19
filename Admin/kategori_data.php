<?php
include "header.php";
include "sidebar.php";
include "notif.php";
?>

<script>
function yakinhapus() {
  return confirm('Apakah Anda yakin ingin menghapus data kategori ini?');
}
</script>
<style>
.table td, .table th { vertical-align: middle; }
</style>
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-light">Data Kategori</h1>
    <a href="kategori_tambah.php" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Kategori</a>
  </div>
  <div class="card border-0 shadow">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" id="dataTableKategori" width="100%" cellspacing="0">
          <thead class="thead-dark">
            <tr>
              <th style="width:60px">No</th>
              <th>Nama Kategori</th>
              <th>Keterangan</th>
              <th style="width:140px">Aksi</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $sql = "SELECT * FROM kategori ORDER BY kategori_id ASC";
          $query = mysqli_query($konek, $sql);
          if (!$query) {
              echo '<tr><td colspan="4" class="text-danger">Query error: ' . mysqli_error($konek) . '</td></tr>';
          } else {
              $no = 1;
              if (mysqli_num_rows($query) == 0) {
                  echo '<tr><td colspan="4" class="text-center">Belum ada kategori.</td></tr>';
              } else {
                  while ($row = mysqli_fetch_assoc($query)) {
                      $id = (int)$row['kategori_id'];
                      $nama = htmlspecialchars($row['nama_kategori'] ?? '-');
                      $ket = htmlspecialchars($row['keterangan'] ?? '');
                      ?>
            <tr>
              <td class="align-middle"><?= $no++; ?></td>
              <td class="align-middle"><?= $nama; ?></td>
              <td class="align-middle"><?= $ket; ?></td>
              <td class="align-middle">
                <a href="kategori_ubah.php?id=<?= $id; ?>" class="btn btn-warning btn-sm">Ubah</a>
                <a href="kategori_hapus.php?id=<?= $id; ?>" onclick="return yakinhapus()" class="btn btn-danger btn-sm">Hapus</a>
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
  $('#dataTableKategori').DataTable({
    "order": [[0, "asc"]],
    "columnDefs": [{ "orderable": false, "targets": [3] }],
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
