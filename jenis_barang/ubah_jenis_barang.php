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
$data_jenis_barang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM jenis_barang WHERE id_jenis_barang = '$id_jenis_barang'"));

if (isset($_POST['btnUbahJenisBarang'])) {
	$jenis_barang = htmlspecialchars($_POST['jenis_barang']);

	$ubah_jenis_barang = mysqli_query($koneksi, "UPDATE jenis_barang SET jenis_barang = '$jenis_barang' WHERE id_jenis_barang = '$id_jenis_barang'");

	if ($ubah_jenis_barang) {
		echo "
			<script>
				alert('Jenis Barang berhasil diubah!');
				window.location.href='jenis_barang.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('Jenis Barang gagal diubah!');
				window.history.back();
			</script>
		";
	}
}

?>

<html>
<head>
	<title>Ubah Jenis Barang - <?= $data_jenis_barang['jenis_barang']; ?></title>
</head>
<body>
	<a href="jenis_barang.php">Kembali</a>
	<form method="post">
		<div>
			<label for="jenis_barang">Jenis Barang</label>
			<input type="text" name="jenis_barang" id="jenis_barang" value="<?= $data_jenis_barang['jenis_barang']; ?>" required>
		</div>
		<div>
			<button type="submit" name="btnUbahJenisBarang">Ubah Jenis Barang</button>
		</div>
	</form>
</body>
</html>