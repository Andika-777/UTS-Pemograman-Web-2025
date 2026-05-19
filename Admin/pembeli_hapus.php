<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../koneksi.php';
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit; }
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    $res = mysqli_query($konek, "DELETE FROM pembeli WHERE pembeli_id = $id");
    if ($res) {
        $_SESSION['flash'] = ['type' => 'warning', 'msg' => 'Pembeli berhasil dihapus.'];
    } else {
        $_SESSION['flash'] = ['type' => 'danger', 'msg' => 'Gagal menghapus pembeli: ' . mysqli_error($konek)];
    }
}
header("Location: pembeli_data.php");
exit;
?>
