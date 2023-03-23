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
</head>
<body>
	<a href="barang.php">Kembali</a>
	<form method="post">
		<div>
			<label for="nama_barang">Nama Barang</label>
			<input type="text" name="nama_barang" id="nama_barang" required>
		</div>
		<div>
			<label for="harga_beli">Harga Beli</label>
			<input type="number" name="harga_beli" id="harga_beli" required>
		</div>
		<div>
			<label for="harga_jual">Harga Jual</label>
			<input type="number" name="harga_jual" id="harga_jual" required>
		</div>
		<div>
			<label for="stok_barang">Stok Barang</label>
			<input type="number" name="stok_barang" id="stok_barang" required>
		</div>
		<div>
			<label for="id_jenis_barang">Jenis Barang</label>
			<select name="id_jenis_barang" id="id_jenis_barang">
				<option value="0">--- Pilih Jenis Barang ---</option>
				<?php foreach ($jenis_barang as $djb): ?>
					<option value="<?= $djb['id_jenis_barang']; ?>"><?= $djb['jenis_barang']; ?></option>
				<?php endforeach ?>
			</select>
		</div>
		<div>
			<button type="submit" name="btnTambahBarang">Tambah Barang</button>
		</div>
	</form>
</body>
</html>