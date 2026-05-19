<?php 
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Portofolio Saya</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:500,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,800,800i" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="assets/css/styles.css" rel="stylesheet" />
  </head>
  <body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">
        <span class="d-block d-lg-none">Wahyu Pramusinto</span>
        <span class="d-none d-lg-block"><img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="assets/img/profile.jpg" alt="..." /></span>
      </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#about">Profil</a></li>
        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#education">Pendidikan</a></li>
        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#experience">Pengalaman</a></li>
        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#skills">Keahlian</a></li>
        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#proyek">Proyek</a></li>
        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#layanan">Layanan</a></li>
        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#contact">Kontak</a></li>
      </ul>
    </div>
  </nav>
  <!-- Page Content-->
  <div class="container-fluid p-0">
    <!-- About-->
    <section class="resume-section" id="about">
      <div class="resume-section-content">
        <h1 class="mb-0">Wahyu
          <span class="text-primary">Pramusinto</span>
        </h1>
        <div class="subheading mb-5">
        Jakarta, Indonesia · 0812-9741-9994 ·
          <a href="mailto:wahyu.pramusinto@budiluhur.ac.id">wahyu.pramusinto@budiluhur.ac.id</a>
        </div>
        <p class="lead mb-5">Saya adalah seorang pengembang web berpengalaman yang berspesialisasi dalam PHP, pengembangan CMS, dan konsultasi IT. Selama 17 tahun terakhir, saya telah mengerjakan berbagai proyek mulai dari situs web bisnis kecil hingga aplikasi web yang kompleks.</p>
        <div class="social-icons">
          <a class="social-icon" href="https://facebook.com/wahyupramusinto"><i class="fab fa-facebook"></i></a>
          <a class="social-icon" href="#!"><i class="fab fa-instagram"></i></a>
          <a class="social-icon" href="#!"><i class="fab fa-twitter"></i></a>
          <a class="social-icon" href="#!"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
    </section>
    <hr class="m-0" />
                 
    <!-- Education-->
    <section class="resume-section" id="education">
    <div class="resume-section-content">
      <h2 class="mb-5">Pendidikan</h2>
      <?php
      $sql = "SELECT * from pendidikan order by id ";
      $kueri = mysqli_query($konek,$sql);
      $no = 1;
      //looping untuk menampilkan data
      while($dt = mysqli_fetch_array($kueri)){
      ?> 
      <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
        <div class="flex-grow-1">
          <h3 class="mb-0"><?=$dt['jenjang'];?></h3>
          <div class="subheading mb-3"><?=$dt['institusi'];?></div>
          <div><?=$dt['jurusan'];?></div>
        </div>
        <div class="flex-shrink-0"><span class="text-primary"><?=$dt['tahun'];?></span></div>
      </div>
      <?php } ?>
    </div>
    </section>
    <hr class="m-0" />
    <!-- Experience-->
    <section class="resume-section" id="experience">
      <div class="resume-section-content">
        <h2 class="mb-5">Pengalaman</h2>
        <?php
        $sql = "SELECT * from pengalaman order by id ";
        $kueri = mysqli_query($konek,$sql);
        $no = 1; //looping untuk menampilkan data
        while($dt = mysqli_fetch_array($kueri)){
        ?>
        <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
          <div class="flex-grow-1">
            <h3 class="mb-0"><?=$dt['jabatan'];?></h3>
            <div class="subheading mb-3"><?=$dt['instansi'];?></div>
            <p><?=$dt['deskripsi'];?></p>
          </div>
        <div class="flex-shrink-0"><span class="text-primary"><?=$dt['tahun'];?></span></div>
        </div>
      <?php } ?>
    </div>
    </section>
    <hr class="m-0" />
    <!-- Skills-->
    <section class="resume-section" id="skills">
      <div class="resume-section-content">
        <h2 class="mb-5">Keahlian</h2> 
        <?php
        $sql = "SELECT * from keahlian order by id ";
        $kueri = mysqli_query($konek,$sql);
        $no = 1; //looping untuk menampilkan data
        while($dt = mysqli_fetch_array($kueri)){
        ?>
        <div class="skill">
          <h3><?=$dt['nama'];?></h3>
          <div class="progress">
            <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: <?=$dt['nilai'];?>%" aria-valuenow="<?=$dt['nilai'];?>" aria-valuemin="0" aria-valuemax="100"><?=$dt['nilai'];?>%</div>
          </div>
        </div>
        <?php } ?>           
      </div>
    </section>
    <hr class="m-0" />
    <section class="resume-section" id="proyek">
      <div class="resume-section-content">
        <h2 class="mb-5">Proyek</h2>
          <div id="servicesCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
            <?php
            $sql = "SELECT * from proyek order by id ";
            $kueri = mysqli_query($konek,$sql);
            $no = 1;
            //looping untuk menampilkan data
            while($dt = mysqli_fetch_array($kueri)){
            ?>
              <div class="carousel-item <?php if($no==1) echo 'active';?>">
                <img src='assets/img/proyek/<?php echo $dt['cover'];?>'>
                <div class="carousel-caption d-none d-md-block">
                <h5><?php echo $dt['nama'];?></h5>
                <p><?php echo $dt['deskripsi'];?></p>
                <p><?php echo $dt['tahun'];?></p>
                </div>
              </div>
            <?php } ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#servicesCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#servicesCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
  </section>
  <hr class="m-0" />
  <section class="resume-section" id="layanan">
  <div class="resume-section-content">
    <h2 class="mb-5">Layanan</h2>    
    <div class="row">
      <?php
        $sql = "SELECT * from layanan order by id ";
        $kueri = mysqli_query($konek,$sql);
        $no = 1;
        //looping untuk menampilkan data
        while($dt = mysqli_fetch_array($kueri)){
      ?>
      <div class="col-md-4">
        <div class="card mb-4 shadow-sm">
          <img src="assets/img/layanan/<?php echo $dt['cover'];?>" class="card-img-top" alt="<?php echo $dt['nama'];?>">
          <div class="card-body">
            <h5 class="card-title"><?php echo $dt['nama'];?></h5>
            <p class="card-text"><?php echo $dt['deskripsi'];?></p>
          </div> 
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</section>
<hr class="m-0" />
<!-- Contact -->
<section class="resume-section" id="contact">
  <div class="resume-section-content">
    <h2 class="mb-5">Kontak</h2>
    <div class="row">
      <div class="col-md-8">
        <form id="contactForm" method="post">
          <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="wa" class="form-label">Nomor WA</label>
            <input type="text" class="form-control" id="wa" name="wa" required>
          </div>
          <div class="mb-3">
            <label for="message" class="form-label">Pesan</label>
            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Kirim</button>
        </form>
      <!-- Modal untuk alert -->
    <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="responseModalLabel">Kontak</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="responseMessage"></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div> 
    </div> <!-- end Modal-->
  </div>
</div> </div>
</section>
</div>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/scripts.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function(){
    //jika tombol kirim contactform diklik
    $("#contactForm").on("submit", function(event){
      event.preventDefault();
      $.ajax({
        url: "simpan_kontak.php",
        method: "POST",
        data: $(this).serialize(),
        success: function(data){
          $("#responseMessage").html(data);
          $("#responseModal").modal('show');
          $("#contactForm")[0].reset();
        }
      });
    });
  });
</script> </body> </html>
