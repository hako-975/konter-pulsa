<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}

$tanggal_transaksi = date('Y-m-d H:i:s');

$id_user = htmlspecialchars($_SESSION['id_user']);

$tambah_transaksi = mysqli_query($koneksi, "INSERT INTO transaksi VALUES('', '$tanggal_transaksi', '', '$id_user')");
$id_transaksi = mysqli_insert_id($koneksi);
if ($tambah_transaksi) {
	echo "
		<script>
			window.location.href='detail_transaksi.php?id_transaksi=$id_transaksi';
		</script>
	";
} else {
	echo "
		<script>
			window.history.back();
		</script>
	";
}

?>