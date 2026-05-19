<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION['flash'])) return;

$flash = $_SESSION['flash'];
unset($_SESSION['flash']);

$map = [
    'success' => 'alert-success',
    'warning' => 'alert-warning',
    'danger'  => 'alert-danger',
    'info'    => 'alert-info',
];
$cls = isset($map[$flash['type']]) ? $map[$flash['type']] : 'alert-info';
$msg = htmlspecialchars($flash['msg'], ENT_QUOTES, 'UTF-8');
?>
<div class="container-fluid mt-3">
  <div class="row">
    <div class="col-12">
      <div class="alert <?= $cls ?> alert-dismissible fade show" role="alert">
        <?= $msg ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>
  </div>
</div>
<script>
  setTimeout(function(){
    var $a = $('.container-fluid .alert');
    if ($a.length) { $a.alert('close'); }
  }, 4000);
</script>
