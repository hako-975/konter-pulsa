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

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));


$barang = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY nama_barang ASC");
$supplier = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY nama_supplier ASC");

if (isset($_POST['btnTambahPemasukanBarang'])) {
	$id_barang = htmlspecialchars($_POST['id_barang']);
	$id_supplier = htmlspecialchars($_POST['id_supplier']);
	$tanggal_pemasukan = date("Y-m-d H:i:s");
	$jumlah_pemasukan = htmlspecialchars($_POST['jumlah_pemasukan']);

	if ($id_barang == 0) {
		echo "
			<script>
				alert('Pilih Barang terlebih dahulu!');
				window.history.back();
			</script>
		";
		exit;
	}

	if ($id_supplier == 0) {
		echo "
			<script>
				alert('Pilih Supplier terlebih dahulu!');
				window.history.back();
			</script>
		";
		exit;
	}

	$tambah_pemasukan_barang = mysqli_query($koneksi, "INSERT INTO pemasukan_barang VALUES('', '$id_barang', '$id_supplier', '$tanggal_pemasukan', '$jumlah_pemasukan')");
	$update_stok_barang = mysqli_query($koneksi, "UPDATE barang SET stok_barang = stok_barang + '$jumlah_pemasukan' WHERE id_barang = '$id_barang'");
	if ($tambah_pemasukan_barang) {
		echo "
			<script>
				alert('Pemasukan Barang berhasil ditambahkan!');
				window.location.href='pemasukan_barang.php';
			</script>
		";
		exit;
	} else {
		echo "
			<script>
				alert('Pemasukan Barang gagal ditambahkan!');
				window.history.back();
			</script>
		";
		exit;
	}
}

?>

<html>
<head>
	<title>Tambah Pemasukan Barang</title>
	<?php include_once '../include/head.php'; ?>
</head>
<body class="bg-gradient">
	<div id="preloader">
      <div class="loader"></div>
    </div>
    <?php include_once '../include/topbar.php' ?>
	<?php include_once '../include/sidebar.php'; ?>
	<div class="main-content">
		<a href="<?= BASE_URL; ?>pemasukan_barang/pemasukan_barang.php" class="btn">Kembali</a>
		<div class="my">
			<h1>Tambah Pemasukan Barang</h1>
			<form method="post">
				<div class="form-group">
					<label for="id_barang">Nama Barang</label>
					<select name="id_barang" id="id_barang" class="form-input">
						<option value="0">--- Pilih Nama Barang ---</option>
						<?php foreach ($barang as $db): ?>
							<option value="<?= $db['id_barang']; ?>"><?= $db['nama_barang']; ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form-group">
					<label for="id_supplier">Nama Supplier</label>
					<select name="id_supplier" id="id_supplier" class="form-input">
						<option value="0">--- Pilih Nama Supplier ---</option>
						<?php foreach ($supplier as $dp): ?>
							<option value="<?= $dp['id_supplier']; ?>"><?= $dp['nama_supplier']; ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form-group">
					<label for="jumlah_pemasukan">Jumlah Pemasukan Barang</label>
					<input type="number" name="jumlah_pemasukan" id="jumlah_pemasukan" class="form-input" required>
				</div>
				<div class="form-group">
					<button type="submit" name="btnTambahPemasukanBarang" class="btn">Tambah Pemasukan Barang</button>
				</div>
			</form>
		</div>
	</div>

    <?php include_once '../include/script.php'; ?>

</body>
</html>