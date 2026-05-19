<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../koneksi.php';
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit; }
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$q = mysqli_query($konek, "SELECT * FROM pembeli WHERE pembeli_id = $id LIMIT 1");
if (!$q || mysqli_num_rows($q) === 0) {
    $_SESSION['flash'] = ['type'=>'warning','msg'=>'Data pembeli tidak ditemukan.'];
    header("Location: pembeli_data.php");
    exit;
}
$data = mysqli_fetch_assoc($q);
$info = '';
if (isset($_POST['tblSave'])) {
    $nama = isset($_POST['nama_pembeli']) ? trim($_POST['nama_pembeli']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $no_hp = isset($_POST['no_hp']) ? trim($_POST['no_hp']) : '';
    $alamat = isset($_POST['alamat']) ? trim($_POST['alamat']) : '';
    if ($nama === '') {
        $info = 'Nama pembeli harus diisi.';
    } elseif ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $info = 'Format email tidak valid.';
    }
    if ($info === '') {
        $nama_esc = mysqli_real_escape_string($konek, $nama);
        $email_sql = $email !== '' ? "'" . mysqli_real_escape_string($konek, $email) . "'" : "NULL";
        $nohp_sql = $no_hp !== '' ? "'" . mysqli_real_escape_string($konek, $no_hp) . "'" : "NULL";
        $alamat_sql = $alamat !== '' ? "'" . mysqli_real_escape_string($konek, $alamat) . "'" : "NULL";

        $sql = "UPDATE pembeli SET
                  nama_pembeli = '{$nama_esc}',
                  email = {$email_sql},
                  no_hp = {$nohp_sql},
                  alamat = {$alamat_sql}
                WHERE pembeli_id = " . (int)$id;
        if (mysqli_query($konek, $sql)) {
            $_SESSION['flash'] = ['type'=>'success','msg'=>'Pembeli berhasil diperbarui.'];
            header("Location: pembeli_data.php");
            exit;
        } else {
            $info = 'Gagal menyimpan ke database: ' . mysqli_error($konek);
        }
    }
}
include "header.php";
include "sidebar.php";
?>
<style>
.page-bg { background: #0f111a; color: #eaeaea; }
.card-dark { background:#14151b; border:1px solid rgba(255,255,255,0.04); color:#eaeaea; }
.form-control-dark { background:#0f111a; color:#eaeaea; border:1px solid rgba(255,255,255,0.06); }
.form-control-dark:focus { box-shadow:0 0 0 .15rem rgba(0,200,150,0.08); border-color:#00c896; color:#fff; }
.btn-cancel { background:#2b2d33; color:#eaeaea; border:1px solid rgba(255,255,255,0.04); }
.alert-dark { background:#1a1b20; color:#ffd; border:1px solid rgba(255,255,255,0.04); padding:0.75rem 1rem; border-radius:6px; }
.label-light { color:#d7d7d7; }
</style>
<div class="container-fluid page-bg">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-light">Ubah Pembeli</h1>
    <a class="btn btn-primary" href="pembeli_data.php">Kembali</a>
  </div>

  <div class="card card-dark shadow mb-4">
    <div class="card-body">
      <?php if ($info !== ''): ?>
        <div class="alert alert-dark"><?= htmlspecialchars($info) ?></div>
      <?php endif; ?>

      <form method="post" class="mt-3">
        <div class="mb-3 row">
          <label class="col-sm-2 col-form-label label-light">Nama Pembeli</label>
          <div class="col-sm-10">
            <input type="text" name="nama_pembeli" class="form-control form-control-dark" required value="<?= isset($_POST['nama_pembeli']) ? htmlspecialchars($_POST['nama_pembeli']) : htmlspecialchars($data['nama_pembeli']) ?>">
          </div>
        </div>

        <div class="mb-3 row">
          <label class="col-sm-2 col-form-label label-light">Email</label>
          <div class="col-sm-4">
            <input type="email" name="email" class="form-control form-control-dark" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : htmlspecialchars($data['email']) ?>">
          </div>

          <label class="col-sm-1 col-form-label label-light">No. HP</label>
          <div class="col-sm-5">
            <input type="text" name="no_hp" class="form-control form-control-dark" value="<?= isset($_POST['no_hp']) ? htmlspecialchars($_POST['no_hp']) : htmlspecialchars($data['no_hp']) ?>">
          </div>
        </div>

        <div class="mb-3 row">
          <label class="col-sm-2 col-form-label label-light">Alamat</label>
          <div class="col-sm-10">
            <textarea name="alamat" class="form-control form-control-dark" rows="4"><?= isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : htmlspecialchars($data['alamat']) ?></textarea>
          </div>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" name="tblSave" class="btn btn-primary">Simpan</button>
          <a href="pembeli_data.php" class="btn btn-cancel">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
