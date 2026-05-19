<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - My Fit Admin</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link href="css/sb-admin-2.min.css" rel="stylesheet">
<style>
  body.bg-gradient-primary {
    background: #0e0e0e !important; 
  }
  .card {
    background-color: #1c1c1c !important;
    color: #f5f5f5 !important;
  }
  .form-control-user {
    background-color: #2a2a2a !important;
    border: none;
    color: #fff !important;
  }
  .form-control-user::placeholder {
    color: #aaa !important;
  }
  .btn-primary {
    background-color: #00c896 !important;
    border: none !important;
  }
  .btn-primary:hover {
    background-color: #00a97d !important;
  }
  .text-gray-900 {
    color: #fff !important;
  }
  .alert-danger {
    background-color: #a94442 !important;
    color: #fff !important;
    border: none;
  }
</style>
</head>
<body class="bg-gradient-primary">
<?php
include "../koneksi.php";
if (isset($_POST['tbllogin'])) {
    $user = $_POST['username'];
    $pass = md5($_POST['password']);

    $sql   = "SELECT * FROM user WHERE username='$user' AND password='$pass'";
    $query = mysqli_query($konek, $sql);
    if (mysqli_num_rows($query) == 0) {
        $error = "Username atau password salah!";
    } else {
        $dt = mysqli_fetch_array($query);
        $_SESSION['user_id']  = $dt['user_id'];
        $_SESSION['username'] = $dt['username'];
        $_SESSION['nama']     = $dt['name'];
        $_SESSION['hakakses'] = $dt['user_type'];
        header("Location:index.php");
    }
}
?>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-xl-6 col-lg-7 col-md-9">
      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <div class="p-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Login Admin My Fit</h1>
              <?php if (isset($error)) echo "<p class='alert alert-danger'>$error</p>"; ?>
            </div>
            <form class="user" method="post" name="frmlogin">
              <div class="form-group">
                <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Masukkan Username">
              </div>
              <div class="form-group">
                <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Masukkan Password">
              </div>
              <input type="submit" class="btn btn-primary btn-user btn-block" name="tbllogin" value="Login">
            </form>
            <hr>
            <div class="text-center text-gray-600 small">© My Fit 2025</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
</body>
</html>
