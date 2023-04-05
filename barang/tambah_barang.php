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

$jenis_barang = mysqli_query($koneksi, "SELECT * FROM jenis_barang ORDER BY jenis_barang ASC");

if (isset($_POST['btnTambahBarang'])) {
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

	$tambah_barang = mysqli_query($koneksi, "INSERT INTO barang VALUES('', '$nama_barang', '$harga_beli', '$harga_jual', '$stok_barang', '$id_jenis_barang')");

	if ($tambah_barang) {
		echo "
			<script>
				alert('Barang berhasil ditambahkan!');
				window.location.href='barang.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('Barang gagal ditambahkan!');
				window.history.back();
			</script>
		";
	}
}

?>

<html>
<head>
	<title>Tambah Barang</title>
	<?php include_once '../include/head.php'; ?>
</head>
<body class="bg-gradient">
	<div id="preloader">
      <div class="loader"></div>
    </div>
    <?php include_once '../include/topbar.php' ?>
	<?php include_once '../include/sidebar.php'; ?>
	<div class="main-content">
		<a href="<?= BASE_URL; ?>barang/barang.php" class="btn">Kembali</a>
		<div class="my">
			<h1>Tambah Barang</h1>
			<form method="post">
				<div class="form-group">
					<label for="nama_barang">Nama Barang</label>
					<input type="text" name="nama_barang" id="nama_barang" class="form-input" required>
				</div>
				<div class="form-group">
					<label for="harga_beli">Harga Beli</label>
					<input type="number" name="harga_beli" id="harga_beli" class="form-input" required>
				</div>
				<div class="form-group">
					<label for="harga_jual">Harga Jual</label>
					<input type="number" name="harga_jual" id="harga_jual" class="form-input" required>
				</div>
				<div class="form-group">
					<label for="stok_barang">Stok Barang</label>
					<input type="number" name="stok_barang" id="stok_barang" class="form-input" required>
				</div>
				<div class="form-group">
					<label for="id_jenis_barang">Jenis Barang</label>
					<select name="id_jenis_barang" id="id_jenis_barang" class="form-input">
						<option value="0">--- Pilih Jenis Barang ---</option>
						<?php foreach ($jenis_barang as $djb): ?>
							<option value="<?= $djb['id_jenis_barang']; ?>"><?= $djb['jenis_barang']; ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form-group">
					<button type="submit" name="btnTambahBarang" class="btn">Tambah Barang</button>
				</div>
			</form>
		</div>
	</div>

    <?php include_once '../include/script.php'; ?>
</body>
</html>