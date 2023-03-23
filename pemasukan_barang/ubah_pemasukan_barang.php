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
	} else {
		echo "
			<script>
				alert('Pemasukan Barang gagal diubah!');
				window.history.back();
			</script>
		";
	}
}

?>

<html>
<head>
	<title>Ubah Pemasukan Barang - <?= $data_pemasukan_barang['nama_barang']; ?></title>
</head>
<body>
	<a href="pemasukan_barang.php">Kembali</a>
	<form method="post">
		<div>
			<label for="id_barang">Nama Barang</label>
			<select name="id_barang" id="id_barang">
				<option value="<?= $data_pemasukan_barang['id_barang']; ?>"><?= $data_pemasukan_barang['nama_barang']; ?></option>
				<?php foreach ($barang as $db): ?>
					<?php if ($db['id_barang'] != $data_pemasukan_barang['id_barang']): ?>
						<option value="<?= $db['id_barang']; ?>"><?= $db['nama_barang']; ?></option>
					<?php endif ?>
				<?php endforeach ?>
			</select>
		</div>
		<div>
			<label for="id_supplier">Nama Supplier</label>
			<select name="id_supplier" id="id_supplier">
				<option value="<?= $data_pemasukan_barang['id_supplier']; ?>"><?= $data_pemasukan_barang['nama_supplier']; ?></option>
				<?php foreach ($supplier as $dp): ?>
					<?php if ($dp['id_supplier'] != $data_pemasukan_barang['id_supplier']): ?>
						<option value="<?= $dp['id_supplier']; ?>"><?= $dp['nama_supplier']; ?></option>
					<?php endif ?>
				<?php endforeach ?>
			</select>
		</div>
		<div>
			<label for="jumlah_pemasukan">Jumlah Pemasukan Barang</label>
			<input type="number" name="jumlah_pemasukan" id="jumlah_pemasukan" required value="<?= $data_pemasukan_barang['jumlah_pemasukan']; ?>">
		</div>
		<div>
			<label for="tanggal_pemasukan">Tanggal Pemasukan Barang</label>
			<input type="datetime-local" name="tanggal_pemasukan" id="tanggal_pemasukan" required value="<?= $data_pemasukan_barang['tanggal_pemasukan']; ?>">
		</div>
		<div>
			<button type="submit" name="btnUbahPemasukanBarang">Ubah Pemasukan Barang</button>
		</div>
	</form>
</body>
</html>