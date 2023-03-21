<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}


if ($_SESSION['hak_akses'] != 'administrator') {
	echo "
		<script>
			alert('Tidak dapat melakukan perubahan selain Administrator!');
			window.history.back();
		</script>
	";
	exit;
}

$id_jenis_barang = htmlspecialchars($_GET['id_jenis_barang']);

$hapus_jenis_barang = mysqli_query($koneksi, "DELETE FROM jenis_barang WHERE id_jenis_barang = '$id_jenis_barang'");

if ($hapus_jenis_barang) {
	echo "
		<script>
			alert('Jenis Barang berhasil dihapus!');
			window.location.href='jenis_barang.php';
		</script>
	";
} else {
	echo "
		<script>
			alert('Jenis Barang gagal dihapus!');
			window.location.href='jenis_barang.php';
		</script>
	";
}

?>