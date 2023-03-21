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

$id_barang = htmlspecialchars($_GET['id_barang']);

$hapus_barang = mysqli_query($koneksi, "DELETE FROM barang WHERE id_barang = '$id_barang'");

if ($hapus_barang) {
	echo "
		<script>
			alert('Barang berhasil dihapus!');
			window.location.href='barang.php';
		</script>
	";
} else {
	echo "
		<script>
			alert('Barang gagal dihapus!');
			window.location.href='barang.php';
		</script>
	";
}

?>