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

$id_supplier = htmlspecialchars($_GET['id_supplier']);

$hapus_supplier = mysqli_query($koneksi, "DELETE FROM supplier WHERE id_supplier = '$id_supplier'");

if ($hapus_supplier) {
	echo "
		<script>
			alert('Supplier berhasil dihapus!');
			window.location.href='supplier.php';
		</script>
	";
} else {
	echo "
		<script>
			alert('Supplier gagal dihapus!');
			window.location.href='supplier.php';
		</script>
	";
}

?>