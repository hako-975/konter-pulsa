<?php 
define('BASE_URL', 'http://localhost/konter_pulsa/');

session_start();
date_default_timezone_set("Asia/Jakarta");
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'konter_pulsa';
$koneksi = mysqli_connect($host, $user, $pass, $db);

// if ($koneksi) {
// 	echo "koneksi berhasil";
// }

?>