<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../koneksi.php';
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit; }

$info = '';

if (isset($_POST['tblSave'])) {
    $nama = isset($_POST['nama_kategori']) ? trim($_POST['nama_kategori']) : '';
    $keterangan = isset($_POST['keterangan']) ? trim($_POST['keterangan']) : '';

    if ($nama === '') {
        $info = 'Nama kategori harus diisi.';
    }

    if ($info === '') {
        $nama_esc = mysqli_real_escape_string($konek, $nama);
        $ket_esc = $keterangan !== '' ? "'" . mysqli_real_escape_string($konek, $keterangan) . "'" : "NULL";

        $sql = "INSERT INTO kategori (nama_kategori, keterangan) VALUES ('{$nama_esc}', {$ket_esc})";

        if (mysqli_query($konek, $sql)) {
            $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Kategori berhasil ditambahkan.'];
            header("Location: kategori_data.php");
            exit;
        } else {
            $info = 'Gagal menyimpan ke database: ' . mysqli_error($konek);
        }
    }
}

include "header.php";
include "sidebar.php";
include "notif.php";
?>

<style>
.page-bg { background: #0f111a; color: #eaeaea; }
.card-dark { background:#14151b; border:1px solid rgba(255,255,255,0.04); color:#eaeaea; }
.form-control-dark { background:#0f111a; color:#eaeaea; border:1px solid rgba(255,255,255,0.06); }
.form-control-dark:focus { box-shadow:0 0 0 .15rem rgba(0,200,150,0.10); border-color:#00c896; }
.btn-cancel { background:#2b2d33; color:#eaeaea; }
.label-light { color:#d7d7d7; }
</style>
<div class="container-fluid page-bg">
  <div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 text-light">Tambah Kategori</h1>
    <a class="btn btn-primary" href="kategori_data.php">Lihat Kategori</a>
  </div>
  <div class="card card-dark shadow mb-4">
    <div class="card-body">
      <?php if ($info !== ''): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($info) ?></div>
      <?php endif; ?>
      <form method="post" class="mt-3">
        <div class="mb-3 row">
          <label class="col-sm-2 col-form-label label-light">Nama Kategori</label>
          <div class="col-sm-10">
            <input type="text" name="nama_kategori" class="form-control form-control-dark" required
            value="<?= isset($_POST['nama_kategori']) ? htmlspecialchars($_POST['nama_kategori']) : '' ?>">
          </div>
        </div>
        <div class="mb-3 row">
          <label class="col-sm-2 col-form-label label-light">Keterangan</label>
          <div class="col-sm-10">
            <textarea name="keterangan" rows="4" class="form-control form-control-dark"><?= isset($_POST['keterangan']) ? htmlspecialchars($_POST['keterangan']) : '' ?></textarea>
          </div>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" name="tblSave" class="btn btn-primary">Simpan</button>
          <a href="kategori_data.php" class="btn btn-cancel">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
