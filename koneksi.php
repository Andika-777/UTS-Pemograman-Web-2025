<?php
//ganti 3307 dengan 3306
//atau cukup "localhost" 
$host = "localhost:3306";
$user = "root";
$pass = "";
$db = "db_mystyle";
//koneksi ke mysql
$konek = mysqli_connect($host,$user,$pass,$db);
if(!$konek) die(mysqli_error());
?>  