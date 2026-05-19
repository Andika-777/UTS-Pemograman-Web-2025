<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../koneksi.php';
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit; }

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

        $sql = "INSERT INTO pembeli (nama_pembeli, email, no_hp, alamat) VALUES (
            '{$nama_esc}', {$email_sql}, {$nohp_sql}, {$alamat_sql}
        )";

        if (mysqli_query($konek, $sql)) {
            $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Pembeli berhasil ditambahkan.'];
            header("Location: pembeli_data.php");
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
.form-control-dark, .form-select-dark { background:#0f111a; color:#eaeaea; border:1px solid rgba(255,255,255,0.06); }
.form-control-dark:focus, .form-select-dark:focus { box-shadow:0 0 0 .15rem rgba(0,200,150,0.08); border-color:#00c896; color:#fff; }
.btn-cancel { background:#2b2d33; color:#eaeaea; border:1px solid rgba(255,255,255,0.04); }
.alert-dark { background:#1a1b20; color:#ffd; border:1px solid rgba(255,255,255,0.04); padding:0.75rem 1rem; border-radius:6px; }
.label-light { color:#d7d7d7; }
</style>

<div class="container-fluid page-bg">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-light">Tambah Pembeli</h1>
    <a class="btn btn-primary" href="pembeli_data.php">Lihat Pembeli</a>
  </div>

  <div class="card card-dark shadow mb-4">
    <div class="card-body">
      <?php if ($info !== ''): ?>
        <div class="alert alert-warning"><?= htmlspecialchars($info) ?></div>
      <?php endif; ?>

      <form method="post" class="mt-3">
        <div class="mb-3 row">
          <label class="col-sm-2 col-form-label label-light">Nama Pembeli</label>
          <div class="col-sm-10">
            <input type="text" name="nama_pembeli" class="form-control form-control-dark" required value="<?= isset($_POST['nama_pembeli']) ? htmlspecialchars($_POST['nama_pembeli']) : '' ?>">
          </div>
        </div>

        <div class="mb-3 row">
          <label class="col-sm-2 col-form-label label-light">Email</label>
          <div class="col-sm-4">
            <input type="email" name="email" class="form-control form-control-dark" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
          </div>

          <label class="col-sm-1 col-form-label label-light">No. HP</label>
          <div class="col-sm-5">
            <input type="text" name="no_hp" class="form-control form-control-dark" value="<?= isset($_POST['no_hp']) ? htmlspecialchars($_POST['no_hp']) : '' ?>">
          </div>
        </div>

        <div class="mb-3 row">
          <label class="col-sm-2 col-form-label label-light">Alamat</label>
          <div class="col-sm-10">
            <textarea name="alamat" class="form-control form-control-dark" rows="4"><?= isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : '' ?></textarea>
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
