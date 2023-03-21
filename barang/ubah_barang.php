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
</head>
<body>
	<a href="barang.php">Kembali</a>
	<form method="post">
		<div>
			<label for="nama_barang">Nama Barang</label>
			<input type="text" name="nama_barang" id="nama_barang" value="<?= $data_barang['nama_barang']; ?>" required>
		</div>
		<div>
			<label for="harga_beli">Harga Beli</label>
			<input type="number" name="harga_beli" id="harga_beli" value="<?= $data_barang['harga_beli']; ?>" required>
		</div>
		<div>
			<label for="harga_jual">Harga Jual</label>
			<input type="number" name="harga_jual" id="harga_jual" value="<?= $data_barang['harga_jual']; ?>" required>
		</div>
		<div>
			<label for="stok_barang">Stok Barang</label>
			<input type="number" name="stok_barang" id="stok_barang" value="<?= $data_barang['stok_barang']; ?>" required>
		</div>
		<div>
			<label for="id_jenis_barang">Jenis Barang</label>
			<select name="id_jenis_barang" id="id_jenis_barang">
				<option value="<?= $data_barang['id_jenis_barang']; ?>"><?= $data_barang['jenis_barang']; ?></option>
				<?php foreach ($jenis_barang as $djb): ?>
					<?php if ($data_barang['id_jenis_barang'] != $djb['id_jenis_barang']): ?>
						<option value="<?= $djb['id_jenis_barang']; ?>"><?= $djb['jenis_barang']; ?></option>
					<?php endif ?>
				<?php endforeach ?>
			</select>
		</div>
		<div>
			<button type="submit" name="btnUbahBarang">Ubah Barang</button>
		</div>
	</form>
</body>
</html>