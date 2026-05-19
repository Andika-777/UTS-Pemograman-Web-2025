<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../koneksi.php';
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    $q = mysqli_query($konek, "SELECT foto FROM produk WHERE produk_id = $id");
    if ($q && mysqli_num_rows($q) > 0) {
        $r = mysqli_fetch_assoc($q);
        $file = __DIR__ . '/img/' . $r['foto'];
        if (!empty($r['foto']) && file_exists($file)) {
            unlink($file);
        }
    }
    mysqli_query($konek, "DELETE FROM produk WHERE produk_id = $id");

    $_SESSION['flash'] = [
        'type' => 'warning',
        'msg'  => 'Produk berhasil dihapus.'
    ];
}
header("Location: produk_data.php");
exit;
?>
