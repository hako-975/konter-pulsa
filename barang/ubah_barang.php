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

$id_barang = htmlspecialchars($_GET['id_barang']);
$data_barang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN jenis_barang ON barang.id_jenis_barang = jenis_barang.id_jenis_barang WHERE id_barang = '$id_barang'"));

$jenis_barang = mysqli_query($koneksi, "SELECT * FROM jenis_barang ORDER BY jenis_barang ASC");

if (isset($_POST['btnUbahBarang'])) {
	$nama_barang = htmlspecialchars(ucwords($_POST['nama_barang']));
	$harga_beli = htmlspecialchars($_POST['harga_beli']);
	$harga_jual = htmlspecialchars($_POST['harga_jual']);
	$stok_barang = htmlspecialchars($_POST['stok_barang']);
	$id_jenis_barang = htmlspecialchars($_POST['id_jenis_barang']);

	if ($id_jenis_barang == 0) {
		echo "
			<script>
				alert('Pilih Jenis Barang terlebih dahulu!');
				window.history.back();
			</script>
		";
		exit;
	}

	$ubah_barang = mysqli_query($koneksi, "UPDATE barang SET nama_barang = '$nama_barang', harga_beli = '$harga_beli', harga_jual = '$harga_jual', stok_barang = '$stok_barang', id_jenis_barang = '$id_jenis_barang' WHERE id_barang = '$id_barang'");

	if ($ubah_barang) {
		echo "
			<script>
				alert('Barang berhasil diubah!');
				window.location.href='barang.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('Barang gagal diubah!');
				window.history.back();
			</script>
		";
	}
}

?>

<html>
<head>
	<title>Ubah Barang - <?= $data_barang['nama_barang']; ?></title>
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
			<h1>Ubah Barang - <?= $data_barang['nama_barang']; ?></h1>
			<form method="post">
				<div class="form-group">
					<label for="nama_barang">Nama Barang</label>
					<input type="text" name="nama_barang" id="nama_barang" class="form-input" value="<?= $data_barang['nama_barang']; ?>" required>
				</div>
				<div class="form-group">
					<label for="harga_beli">Harga Beli</label>
					<input type="number" name="harga_beli" id="harga_beli" class="form-input" value="<?= $data_barang['harga_beli']; ?>" required>
				</div>
				<div class="form-group">
					<label for="harga_jual">Harga Jual</label>
					<input type="number" name="harga_jual" id="harga_jual" class="form-input" value="<?= $data_barang['harga_jual']; ?>" required>
				</div>
				<div class="form-group">
					<label for="stok_barang">Stok Barang</label>
					<input type="number" name="stok_barang" id="stok_barang" class="form-input" value="<?= $data_barang['stok_barang']; ?>" required>
				</div>
				<div class="form-group">
					<label for="id_jenis_barang">Jenis Barang</label>
					<select name="id_jenis_barang" id="id_jenis_barang" class="form-input">
						<option value="<?= $data_barang['id_jenis_barang']; ?>"><?= $data_barang['jenis_barang']; ?></option>
						<?php foreach ($jenis_barang as $djb): ?>
							<?php if ($data_barang['id_jenis_barang'] != $djb['id_jenis_barang']): ?>
								<option value="<?= $djb['id_jenis_barang']; ?>"><?= $djb['jenis_barang']; ?></option>
							<?php endif ?>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form-group">
					<button type="submit" name="btnUbahBarang" class="btn">Ubah Barang</button>
				</div>
			</form>
		</div>
	</div>
    <?php include_once '../include/script.php'; ?>
</body>
</html>