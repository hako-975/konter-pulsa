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
		exit;
	} else {
		echo "
			<script>
				alert('Jenis Barang gagal diubah!');
				window.history.back();
			</script>
		";
		exit;
	}
}

?>

<html>
<head>
	<title>Ubah Jenis Barang - <?= $data_jenis_barang['jenis_barang']; ?></title>
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
			<h1>Ubah Jenis Barang - <?= $data_jenis_barang['jenis_barang']; ?></h1>
			<form method="post">
				<div class="form-group">
					<label for="jenis_barang">Jenis Barang</label>
					<input type="text" name="jenis_barang" id="jenis_barang" class="form-input" value="<?= $data_jenis_barang['jenis_barang']; ?>" required>
				</div>
				<div class="form-group">
					<button type="submit" name="btnUbahJenisBarang" class="btn">Ubah Jenis Barang</button>
				</div>
			</form>
		</div>
	</div>
    <?php include_once '../include/script.php'; ?>
</body>
</html>