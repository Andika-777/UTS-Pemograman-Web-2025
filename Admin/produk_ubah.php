<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../koneksi.php';
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit; }
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$q = mysqli_query($konek, "SELECT * FROM produk WHERE produk_id = $id LIMIT 1");
if (!$q || mysqli_num_rows($q) === 0) {
    $_SESSION['flash'] = ['type'=>'warning','msg'=>'Data produk tidak ditemukan.'];
    header("Location: produk_data.php");
    exit;
}
$data = mysqli_fetch_assoc($q);
$info = ''; 
if (isset($_POST['tblSave'])) {
    $nama = isset($_POST['nama_produk']) ? trim($_POST['nama_produk']) : '';
    $kategori = isset($_POST['kategori_id']) ? (int)$_POST['kategori_id'] : 0;
    $harga = isset($_POST['harga']) ? (float)$_POST['harga'] : 0;
    $stok = isset($_POST['stok']) ? (int)$_POST['stok'] : 0;
    if ($nama === '') {
        $info = 'Nama produk harus diisi.';
    } elseif ($kategori <= 0) {
        $info = 'Pilih kategori.';
    }
    $uploadDir = __DIR__ . '/img/';
    if (!is_dir($uploadDir)) @mkdir($uploadDir, 0755, true);
    $foto_name = $data['foto']; 
    if ($info === '' && !empty($_FILES['foto']['name']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];
        if (!in_array($ext, $allowed)) {
            $info = 'Format file tidak diperbolehkan.';
        } elseif ($_FILES['foto']['size'] > 2 * 1024 * 1024) {
            $info = 'File terlalu besar (maks 2MB).';
        } else {
            $newname = time() . '_' . rand(1000,9999) . '.' . $ext;
            $target = $uploadDir . $newname;
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
                if (!empty($foto_name) && file_exists($uploadDir . $foto_name)) @unlink($uploadDir . $foto_name);
                $foto_name = $newname;
            } else {
                $info = 'Gagal menyimpan file. Periksa permission folder img/.';
            }
        }
    }
    if ($info === '') {
        $nama_esc = mysqli_real_escape_string($konek, $nama);
        $foto_sql = $foto_name ? "'" . mysqli_real_escape_string($konek, $foto_name) . "'" : "NULL";
        $sql = "UPDATE produk SET
                  nama_produk = '{$nama_esc}',
                  kategori_id = " . (int)$kategori . ",
                  harga = " . (float)$harga . ",
                  stok = " . (int)$stok . ",
                  foto = {$foto_sql}
                WHERE produk_id = " . (int)$id;
        if (mysqli_query($konek, $sql)) {
            $_SESSION['flash'] = ['type'=>'success','msg'=>'Produk berhasil diperbarui.'];
            header("Location: produk_data.php");
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
.label-light { color:#d7d7d7; }
.thumb-preview { width:96px; height:96px; border-radius:8px; background-size:cover; background-position:center; border:1px solid rgba(255,255,255,0.06); display:block; }
</style>
<div class="container-fluid page-bg">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-light">Ubah Produk</h1>
    <a class="btn btn-primary" href="produk_data.php">Kembali</a>
  </div>

  <div class="card card-dark shadow mb-4">
    <div class="card-body">
      <?php if ($info !== ''): ?>
        <div class="alert alert-warning"><?= htmlspecialchars($info) ?></div>
      <?php endif; ?>

      <form method="post" enctype="multipart/form-data" class="mt-3">
        <div class="mb-3 row">
          <label class="col-sm-2 col-form-label label-light">Nama Produk</label>
          <div class="col-sm-10">
            <input type="text" name="nama_produk" class="form-control form-control-dark" required
                   value="<?= isset($_POST['nama_produk']) ? htmlspecialchars($_POST['nama_produk']) : htmlspecialchars($data['nama_produk']) ?>">
          </div>
        </div>
        <div class="mb-3 row">
          <label class="col-sm-2 col-form-label label-light">Kategori</label>
          <div class="col-sm-4">
            <select name="kategori_id" class="form-select form-select-dark" required>
              <?php
              $qk = mysqli_query($konek, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
              while ($rk = mysqli_fetch_assoc($qk)) {
                  $val = (int)$rk['kategori_id'];
                  $sel = (isset($_POST['kategori_id']) ? (int)$_POST['kategori_id'] : (int)$data['kategori_id']) === $val ? ' selected' : '';
                  echo '<option value="'. $val .'"'. $sel .'>'. htmlspecialchars($rk['nama_kategori']) .'</option>';
              }
              ?>
            </select>
          </div>
          <label class="col-sm-1 col-form-label label-light">Harga</label>
          <div class="col-sm-2">
            <input type="number" step="0.01" name="harga" class="form-control form-control-dark" required
                   value="<?= isset($_POST['harga']) ? htmlspecialchars($_POST['harga']) : htmlspecialchars($data['harga']) ?>">
          </div>
          <label class="col-sm-1 col-form-label label-light">Stok</label>
          <div class="col-sm-2">
            <input type="number" name="stok" class="form-control form-control-dark" required
                   value="<?= isset($_POST['stok']) ? htmlspecialchars($_POST['stok']) : htmlspecialchars($data['stok']) ?>">
          </div>
        </div>
        <div class="mb-3 row align-items-center">
          <label class="col-sm-2 col-form-label label-light">Foto Saat Ini</label>
          <div class="col-sm-1">
            <?php $currentFoto = (!empty($data['foto']) && file_exists(__DIR__.'/img/'.$data['foto'])) ? 'img/'.$data['foto'] : 'img/no-image.png'; ?>
            <div id="currentThumb" class="thumb-preview" style="background-image:url('<?= $currentFoto ?>');"></div>
          </div>
          <label class="col-sm-1 col-form-label label-light">Ganti Foto</label>
          <div class="col-sm-4">
            <input type="file" name="foto" id="fotoInput" accept="image/*" class="form-control form-control-dark">
            <small class="label-light">Maks 2MB. Format: jpg, jpeg, png, gif.</small>
          </div>
          <div class="col-sm-3">
            <div id="previewNew" class="thumb-preview" style="display:none;"></div>
          </div>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" name="tblSave" class="btn btn-primary">Simpan</button>
          <a href="produk_data.php" class="btn btn-cancel">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
const fotoInput = document.getElementById('fotoInput');
const previewNew = document.getElementById('previewNew');
if (fotoInput) {
  fotoInput.addEventListener('change', function(){
    const file = this.files[0];
    if (!file) { previewNew.style.display='none'; previewNew.style.backgroundImage=''; return; }
    if (!file.type.startsWith('image/')) { previewNew.style.display='none'; return; }
    const reader = new FileReader();
    reader.onload = function(e){
      previewNew.style.backgroundImage = 'url('+e.target.result+')';
      previewNew.style.display = 'block';
    };
    reader.readAsDataURL(file);
  });
}
</script>
<?php include "footer.php"; ?>
