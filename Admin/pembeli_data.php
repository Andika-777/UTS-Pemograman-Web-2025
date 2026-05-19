<?php
include "header.php";
include "sidebar.php";
include "notif.php";
?>
<script>
function yakinhapus() {
  return confirm('Apakah Anda yakin ingin menghapus data ini?');
}
</script>
<style>
.table td, .table th { vertical-align: middle; }
</style>

<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-light">Data Pembeli</h1>
    <a href="pembeli_tambah.php" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Pembeli</a>
  </div>

  <div class="card border-0 shadow">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
          <thead class="thead-dark">
            <tr>
              <th style="width:60px">No</th>
              <th>ID</th>
              <th>Nama Pembeli</th>
              <th>Email</th>
              <th>No. HP</th>
              <th>Alamat</th>
              <th style="width:140px">Aksi</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $sql = "SELECT * FROM pembeli ORDER BY pembeli_id ASC";
          $query = mysqli_query($konek, $sql);
          if (!$query) {
              echo '<tr><td colspan="7" class="text-danger">Query error: ' . mysqli_error($konek) . '</td></tr>';
          } else {
              $no = 1;
              if (mysqli_num_rows($query) == 0) {
                  echo '<tr><td colspan="7" class="text-center">Belum ada data pembeli.</td></tr>';
              } else {
                  while ($row = mysqli_fetch_assoc($query)) {
                      $id = (int)$row['pembeli_id'];
                      $nama = htmlspecialchars($row['nama_pembeli'] ?? '-');
                      $email = htmlspecialchars($row['email'] ?? '-');
                      $nohp = htmlspecialchars($row['no_hp'] ?? '-');
                      $alamat = htmlspecialchars($row['alamat'] ?? '-');
                  ?>
            <tr>
              <td class="align-middle"><?= $no++; ?></td>
              <td class="align-middle"><?= $id; ?></td>
              <td class="align-middle"><?= $nama; ?></td>
              <td class="align-middle"><?= $email; ?></td>
              <td class="align-middle"><?= $nohp; ?></td>
              <td class="align-middle"><?= $alamat; ?></td>
              <td class="align-middle">
                <a href="pembeli_ubah.php?id=<?= $id; ?>" class="btn btn-warning btn-sm">Ubah</a>
                <a href="pembeli_hapus.php?id=<?= $id; ?>" onclick="return yakinhapus()" class="btn btn-danger btn-sm">Hapus</a>
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
    "columnDefs": [{ "orderable": false, "targets": [6] }],
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
