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

if (isset($_POST['btnTambahJenisBarang'])) {
	$jenis_barang = htmlspecialchars($_POST['jenis_barang']);

	$tambah_jenis_barang = mysqli_query($koneksi, "INSERT INTO jenis_barang VALUES('', '$jenis_barang')");

	if ($tambah_jenis_barang) {
		echo "
			<script>
				alert('Jenis Barang berhasil ditambahkan!');
				window.location.href='jenis_barang.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('Jenis Barang gagal ditambahkan!');
				window.history.back();
			</script>
		";
	}
}

?>

<html>
<head>
	<title>Tambah Jenis Barang</title>
</head>
<body>
	<a href="jenis_barang.php">Kembali</a>
	<form method="post">
		<div>
			<label for="jenis_barang">Jenis Barang</label>
			<input type="text" name="jenis_barang" id="jenis_barang" required>
		</div>
		<div>
			<button type="submit" name="btnTambahJenisBarang">Tambah Jenis Barang</button>
		</div>
	</form>
</body>
</html>