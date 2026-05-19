<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../koneksi.php';
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit; }
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    $res = mysqli_query($konek, "DELETE FROM kategori WHERE kategori_id = $id");
    if ($res) {
        $_SESSION['flash'] = ['type' => 'warning', 'msg' => 'Kategori berhasil dihapus.'];
    } else {
        $_SESSION['flash'] = ['type' => 'danger', 'msg' => 'Gagal menghapus kategori: ' . mysqli_error($konek)];
    }
}
header("Location: kategori_data.php");
exit;
?>
