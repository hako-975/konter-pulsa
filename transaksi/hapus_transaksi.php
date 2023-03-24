<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}

$id_transaksi = htmlspecialchars($_GET['id_transaksi']);

$hapus_transaksi = mysqli_query($koneksi, "DELETE FROM transaksi WHERE id_transaksi = '$id_transaksi'");

if ($hapus_transaksi) {
	echo "
		<script>
			alert('Transaksi berhasil dihapus!');
			window.location.href='transaksi.php';
		</script>
	";
} else {
	echo "
		<script>
			alert('Transaksi gagal dihapus!');
			window.location.href='transaksi.php';
		</script>
	";
}

?>