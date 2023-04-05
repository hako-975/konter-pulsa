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

$id_pemasukan_barang = htmlspecialchars($_GET['id_pemasukan_barang']);
$data_pemasukan_barang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pemasukan_barang INNER JOIN barang ON pemasukan_barang.id_barang = barang.id_barang INNER JOIN supplier ON pemasukan_barang.id_supplier = supplier.id_supplier WHERE id_pemasukan_barang = '$id_pemasukan_barang'"));

$barang = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY nama_barang ASC");
$supplier = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY nama_supplier ASC");

if (isset($_POST['btnUbahPemasukanBarang'])) {
	$id_barang = htmlspecialchars($_POST['id_barang']);
	$id_supplier = htmlspecialchars($_POST['id_supplier']);
	$tanggal_pemasukan = htmlspecialchars($_POST['tanggal_pemasukan']);
	$jumlah_pemasukan = htmlspecialchars($_POST['jumlah_pemasukan']);
	$jumlah_pemasukan_old = $data_pemasukan_barang['jumlah_pemasukan'];

	$ubah_pemasukan_barang = mysqli_query($koneksi, "UPDATE pemasukan_barang SET id_barang = '$id_barang', id_supplier = '$id_supplier', tanggal_pemasukan = '$tanggal_pemasukan', jumlah_pemasukan = '$jumlah_pemasukan' WHERE id_pemasukan_barang = '$id_pemasukan_barang'");
	$update_stok_barang = mysqli_query($koneksi, "UPDATE barang SET stok_barang = (stok_barang - $jumlah_pemasukan_old) + '$jumlah_pemasukan' WHERE id_barang = '$id_barang'");

	if ($ubah_pemasukan_barang) {
		echo "
			<script>
				alert('Pemasukan Barang berhasil diubah!');
				window.location.href='pemasukan_barang.php';
			</script>
		";
		exit;
	} else {
		echo "
			<script>
				alert('Pemasukan Barang gagal diubah!');
				window.history.back();
			</script>
		";
		exit;
	}
}

?>

<html>
<head>
	<title>Ubah Pemasukan Barang - <?= $data_pemasukan_barang['nama_barang']; ?></title>
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
			<h1>Ubah Pemasukan Barang - <?= $data_pemasukan_barang['nama_barang']; ?></h1>
			<form method="post">
				<div class="form-group">
					<label for="id_barang">Nama Barang</label>
					<select name="id_barang" id="id_barang" class="form-input">
						<option value="<?= $data_pemasukan_barang['id_barang']; ?>"><?= $data_pemasukan_barang['nama_barang']; ?></option>
						<?php foreach ($barang as $db): ?>
							<?php if ($db['id_barang'] != $data_pemasukan_barang['id_barang']): ?>
								<option value="<?= $db['id_barang']; ?>"><?= $db['nama_barang']; ?></option>
							<?php endif ?>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form-group">
					<label for="id_supplier">Nama Supplier</label>
					<select name="id_supplier" id="id_supplier" class="form-input">
						<option value="<?= $data_pemasukan_barang['id_supplier']; ?>"><?= $data_pemasukan_barang['nama_supplier']; ?></option>
						<?php foreach ($supplier as $dp): ?>
							<?php if ($dp['id_supplier'] != $data_pemasukan_barang['id_supplier']): ?>
								<option value="<?= $dp['id_supplier']; ?>"><?= $dp['nama_supplier']; ?></option>
							<?php endif ?>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form-group">
					<label for="jumlah_pemasukan">Jumlah Pemasukan Barang</label>
					<input type="number" name="jumlah_pemasukan" id="jumlah_pemasukan" required class="form-input" value="<?= $data_pemasukan_barang['jumlah_pemasukan']; ?>">
				</div>
				<div class="form-group">
					<label for="tanggal_pemasukan">Tanggal Pemasukan Barang</label>
					<input type="datetime-local" name="tanggal_pemasukan" id="tanggal_pemasukan" class="form-input" required value="<?= $data_pemasukan_barang['tanggal_pemasukan']; ?>">
				</div>
				<div class="form-group">
					<button type="submit" name="btnUbahPemasukanBarang" class="btn">Ubah Pemasukan Barang</button>
				</div>
			</form>
		</div>
	</div>
    <?php include_once '../include/script.php'; ?>
</body>
</html>