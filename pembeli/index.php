<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$baseDir = __DIR__;
require_once $baseDir . '/../koneksi.php';
$select_cols = "p.produk_id, p.nama_produk, p.harga, p.foto, k.keterangan AS keterangan";
$sql = "
    SELECT {$select_cols}
    FROM produk p
    LEFT JOIN kategori k ON p.kategori_id = k.kategori_id
    ORDER BY p.produk_id DESC
    LIMIT 12
";
$q = mysqli_query($konek, $sql);
$produk_list = [];
if ($q) {
    $admin_img_url = '../admin/img/';          
    $admin_img_dir = realpath($baseDir . '/../admin/img'); 
    $fallback = '../assets/img/no-image.png';
    while ($r = mysqli_fetch_assoc($q)) {
        $foto_val = trim((string)($r['foto'] ?? ''));
        $foto_url = $fallback;

        if ($foto_val !== '') {
            if (preg_match('#^https?://#i', $foto_val)) {
                $foto_url = $foto_val;
            } else {
                $base = basename($foto_val);
                if ($admin_img_dir && file_exists($admin_img_dir . '/' . $base) && is_file($admin_img_dir . '/' . $base)) {
                    $foto_url = $admin_img_url . $base;
                } else {
                    $foto_url = $fallback;
                }
            }
        }

        $r['foto_url'] = $foto_url;
        $produk_list[] = $r;
    }
} else {
    $produk_list = [];
}

function rupiah($n) {
    return 'Rp' . number_format((float)$n,0,',','.');
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>My Style - Toko Fashion</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root{
      --bg:#0f1116;
      --card:#16171c;
      --accent:#00c896;
      --accent-2:#00a97d;
      --muted-white: rgba(255,255,255,0.92);
      --muted-white-2: rgba(255,255,255,0.78);
      --surface:#0b0c0f;
    }
    body{font-family:"Poppins", Inter, system-ui, Arial, Helvetica, sans-serif; background:var(--bg); color:#eaeaea; margin:0;}
    a { color: inherit; text-decoration: none; }
    .navbar { background: rgba(0,0,0,0.12); backdrop-filter: blur(6px); border-bottom: 1px solid rgba(255,255,255,0.03); }
    .navbar-brand { font-weight:700; color:#fff; }
    .btn-accent { background: linear-gradient(90deg,var(--accent),var(--accent-2)); color:#fff; border-radius:10px; border:0; padding:10px 18px; }
    .hero { position:relative; min-height:72vh; display:flex; align-items:center; overflow:hidden; }
    .hero .bg-img {
      position:absolute;
      inset:0;
      background-image: url('../admin/img/model2.jpg');
      background-size:cover;
      background-position:center;
      z-index:0;
      transform: scale(1.02);
    }
    .hero::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,0.55);
      z-index:1;
    }
    .hero .hero-inner { position:relative; z-index:2; padding:80px 0; text-align:center; }
    .hero h1 { font-size:48px; font-weight:700; margin-bottom:10px; color:#fff; letter-spacing:-0.5px; }
    .hero p.lead { color:#d6eae3; font-size:18px; margin-bottom:20px; }

    .card-product { background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)); border:1px solid rgba(255,255,255,0.03); border-radius:12px; overflow:hidden; color:#fff; }
    .card-product .img { height:220px; background-size:cover; background-position:center; }
    .card-product .body { padding:14px; }

    .about { padding:60px 0; color:#e6e6e6; }
    .section-title { margin-bottom:28px; color:#fff; }

    footer { background:var(--surface); padding:40px 0; color:#bfc6c7; border-top:1px solid rgba(255,255,255,0.03); }

    @media (max-width:768px) {
      .hero h1 { font-size:32px; }
      .card-product .img { height:160px; }
    }
    .badge-available { background: linear-gradient(90deg,var(--accent),var(--accent-2)); color:#fff; border-radius:8px; padding:6px 10px; font-weight:600; }
    .product-price { color:var(--muted-white); font-weight:700; }
    .product-desc { color:var(--muted-white-2); }
    .contact-info { background:transparent; color:#eaeaea; }
    .contact-card { background:transparent; border-radius:8px; padding:12px; color:#eaeaea; }
    .contact-cta a { margin-right:8px; }
    #backToTop {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 42px;
        height: 42px;
        background: #00c896;
        color: #fff;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transition: 0.3s;
        z-index: 999;
    }
    #backToTop.show {
        opacity: 1;
        visibility: visible;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="#">My Style</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="navMenu" class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item"><a class="nav-link text-light" href="#hero">Beranda</a></li>
        <li class="nav-item"><a class="nav-link text-light" href="#about">About</a></li>
        <li class="nav-item"><a class="nav-link text-light" href="#produk">Produk</a></li>
        <li class="nav-item"><a class="nav-link text-light" href="#contact">Kontak</a></li>
      </ul>
    </div>
  </div>
</nav>
<header id="hero" class="hero">
  <div class="bg-img" aria-hidden="true"></div>
  <div class="container hero-inner">
    <h1>My Style</h1>
    <p class="lead">Koleksi fashion modern, nyaman, dan membuatmu percaya diri. Pilih gaya, tampil bersinar.</p>
    <a href="#produk" class="btn btn-accent btn-lg">Lihat Koleksi</a>
  </div>
</header>
<section id="about" class="about">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 mb-4 mb-lg-0">
        <h3 class="section-title">Tentang My Style</h3>
        <p>My Style menyediakan pakaian dan aksesori berkualitas dengan desain kekinian. Kami mengutamakan kenyamanan bahan, jahitan rapi, dan layanan pelanggan yang ramah. Dari kaos, jaket, hingga aksesori — semuanya dipilih untuk membuat tampilanmu standout.</p>
        <ul>
          <li>Produk berkualitas dengan detail rapi</li>
          <li>Layanan pemesanan & pengiriman cepat</li>
          <li>Customer support responsif</li>
        </ul>
      </div>
      <div class="col-lg-6 text-center">
        <img src="../admin/img/model3.jpg" alt="About" class="img-fluid rounded" style="max-height:300px; object-fit:cover; border-radius:12px;">
      </div>
    </div>
  </div>
</section>
<section id="produk" class="py-5">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="mb-0">Koleksi Pilihan</h4>
      <small class="text-muted">Produk terbaru</small>
    </div>
    <div class="row g-4">
      <?php if (count($produk_list) === 0): ?>
        <div class="col-12">
          <div class="alert alert-secondary">Belum ada produk untuk ditampilkan.</div>
        </div>
      <?php else: ?>
        <?php foreach ($produk_list as $p): ?>
          <div class="col-sm-6 col-md-4">
            <div class="card-product">
              <div class="img" style="background-image:url('<?= htmlspecialchars($p['foto_url']) ?>')"></div>
              <div class="body">
                <h5 class="mb-1"><?= htmlspecialchars($p['nama_produk']) ?></h5>
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <div class="product-price small"><?= rupiah($p['harga']) ?></div>
                  <div>
                    <a href="#contact" class="badge-available">Pesan</a>
                  </div>
                </div>
                <?php $ket = trim((string)($p['keterangan'] ?? '')); ?>
                <p class="small mb-0 product-desc"><?= $ket !== '' ? nl2br(htmlspecialchars($ket)) : 'Keterangan produk belum tersedia.' ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>
<section id="contact" class="py-5">
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-6">
        <h4>Kontak & Pesan</h4>
        <div class="contact-card">
          <p class="mb-2">Silakan hubungi kami melalui salah satu cara berikut untuk melakukan pemesanan atau menanyakan stok:</p>
          <p class="mb-1"><i class="bi bi-telephone-fill me-2"></i> <a  style="color:inherit;">+62 812 3456 7890</a></p>
          <p class="mb-1"><i class="bi bi-whatsapp me-2"></i> <a  target="_blank" rel="noopener" style="color:inherit;">Chat WhatsApp</a></p>
          <p class="mb-1"><i class="bi bi-envelope-fill me-2"></i> <a  style="color:inherit;">orders@mystyle.example</a></p>
          <div class="mt-3 contact-cta">
            <a  class="btn btn-outline-light btn-sm"><i class="bi bi-telephone-fill me-1"></i> Telepon</a>
            <a  target="_blank" rel="noopener" class="btn btn-success btn-sm"><i class="bi bi-whatsapp me-1"></i> WhatsApp</a>
            <a  class="btn btn-outline-light btn-sm"><i class="bi bi-envelope-fill me-1"></i> Email</a>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="contact-info">
          <h4>Alamat</h4>
          <p class="mb-1">Jl. Berbudi, Tangeran, Banten</p>
          <p class="mb-0 text-light">Jam operasional: Senin - Sabtu, 09:00 - 18:00</p>
        </div>
      </div>
    </div>
  </div>
</section>
<footer class="mt-5">
  <div class="container text-center">
    <p class="mb-1">© <?= date('Y') ?> My Style. All rights reserved.</p>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<button id="backToTop"><i class="bi bi-arrow-up"></i></button>
<script>
  const topBtn = document.getElementById("backToTop");
  window.addEventListener("scroll", () => {
    if (window.scrollY > 300) {
      topBtn.classList.add("show");
    } else {
      topBtn.classList.remove("show");
    }
  });
  topBtn.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
</script>
</body>
</html>
