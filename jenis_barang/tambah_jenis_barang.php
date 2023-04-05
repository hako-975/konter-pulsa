<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
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

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));


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
		exit;
	} else {
		echo "
			<script>
				alert('Jenis Barang gagal ditambahkan!');
				window.history.back();
			</script>
		";
		exit;
	}
}

?>

<html>
<head>
	<title>Tambah Jenis Barang</title>
	<?php include_once '../include/head.php'; ?>
</head>
<body class="bg-gradient">
	<div id="preloader">
      <div class="loader"></div>
    </div>
    <?php include_once '../include/topbar.php' ?>
	<?php include_once '../include/sidebar.php'; ?>
	<div class="main-content">
		<a href="<?= BASE_URL; ?>jenis_barang/jenis_barang.php" class="btn">Kembali</a>
		<div class="my">
			<h1>Tambah Jenis Barang</h1>
			<form method="post">
				<div class="form-group">
					<label for="jenis_barang">Jenis Barang</label>
					<input type="text" name="jenis_barang" id="jenis_barang" class="form-input" required>
				</div>
				<div class="form-group">
					<button type="submit" name="btnTambahJenisBarang" class="btn">Tambah Jenis Barang</button>
				</div>
			</form>
		</div>
	</div>

    <?php include_once '../include/script.php'; ?>

</body>
</html>