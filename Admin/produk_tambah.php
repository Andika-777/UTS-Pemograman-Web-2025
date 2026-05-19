<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../koneksi.php';
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit; }
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
    $foto_name = null;
    if ($info === '' && !empty($_FILES['foto']['name']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/img/';
        if (!is_dir($uploadDir)) @mkdir($uploadDir, 0755, true);
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];
        if (!in_array($ext, $allowed)) {
            $info = 'Format file tidak diperbolehkan.';
        } elseif ($_FILES['foto']['size'] > 2 * 1024 * 1024) {
            $info = 'File terlalu besar (maks 2MB).';
        } else {
            $foto_name = time() . '_' . rand(1000,9999) . '.' . $ext;
            $target = $uploadDir . $foto_name;

            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
                $foto_name = null;
                $info = 'Gagal menyimpan file. Periksa permission folder img/.';
            }
        }
    }
    if ($info === '') {
        $sql = "INSERT INTO produk (nama_produk,kategori_id,harga,stok,foto) VALUES (
            '". mysqli_real_escape_string($konek, $nama) ."',
            ". (int)$kategori .",
            ". (float)$harga .",
            ". (int)$stok .",
            ". ($foto_name ? "'". mysqli_real_escape_string($konek, $foto_name) ."'" : "NULL") ."
        )";
        if (mysqli_query($konek, $sql)) {
            $_SESSION['flash'] = ['type'=>'success','msg'=>'Produk berhasil ditambahkan.'];
            header("Location: produk_data.php");
            exit;
        } else {
            if ($foto_name && file_exists(__DIR__ . '/img/' . $foto_name)) {
                @unlink(__DIR__ . '/img/' . $foto_name);
            }
            $info = 'Gagal menyimpan ke database.';
        }
    }
}
include "header.php";
include "sidebar.php";
include "notif.php";
?>
<div class="container-fluid page-bg">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-light">Tambah Produk</h1>
        <a class="btn btn-primary" href="produk_data.php">Lihat Produk</a>
    </div>
    <?php if ($info !== ''): ?>
        <div class="alert alert-warning"><?= htmlspecialchars($info) ?></div>
    <?php endif; ?>
    <div class="card card-dark shadow mb-4">
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="text-light">Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control form-control-dark"
                           value="<?= isset($_POST['nama_produk']) ? htmlspecialchars($_POST['nama_produk']) : '' ?>"
                           required>
                </div>
                <div class="mb-3">
                    <label class="text-light">Kategori</label>
                    <select name="kategori_id" class="form-select form-control-dark" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php
                        $qk = mysqli_query($konek, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
                        while ($rk = mysqli_fetch_assoc($qk)) {
                            $sel = (isset($_POST['kategori_id']) && $_POST['kategori_id'] == $rk['kategori_id']) ? 'selected' : '';
                            echo '<option value="'.$rk['kategori_id'].'" '.$sel.'>'.htmlspecialchars($rk['nama_kategori']).'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="text-light">Harga</label>
                    <input type="number" name="harga" class="form-control form-control-dark"
                           value="<?= isset($_POST['harga']) ? htmlspecialchars($_POST['harga']) : '' ?>"
                           required>
                </div>
                <div class="mb-3">
                    <label class="text-light">Stok</label>
                    <input type="number" name="stok" class="form-control form-control-dark"
                           value="<?= isset($_POST['stok']) ? htmlspecialchars($_POST['stok']) : '' ?>"
                           required>
                </div>
                <div class="mb-3">
                    <label class="text-light">Foto Produk</label>
                    <input type="file" name="foto" class="form-control form-control-dark" accept="image/*">
                </div>
                <button type="submit" name="tblSave" class="btn btn-primary">Simpan</button>
                <a href="produk_data.php" class="btn btn-cancel">Batal</a>
            </form>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
