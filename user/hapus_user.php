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

$id_user = htmlspecialchars($_GET['id_user']);

// check if admin cannot delete
$check_admin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
if ($check_admin['hak_akses'] == 'administrator') {
	echo "
		<script>
			alert('Administrator tidak boleh dihapus!');
			window.history.back();
		</script>
	";
	exit;
}

$hapus_user = mysqli_query($koneksi, "DELETE FROM user WHERE id_user = '$id_user'");

if ($hapus_user) {
	echo "
		<script>
			alert('User berhasil dihapus!');
			window.location.href='user.php';
		</script>
	";
	exit;
} else {
	echo "
		<script>
			alert('User gagal dihapus!');
			window.location.href='user.php';
		</script>
	";
	exit;
}

?>