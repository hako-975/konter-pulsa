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

$id_supplier = htmlspecialchars($_GET['id_supplier']);
$data_supplier = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM supplier WHERE id_supplier = '$id_supplier'"));

if (isset($_POST['btnUbahSupplier'])) {
	$nama_supplier = htmlspecialchars(ucwords($_POST['nama_supplier']));
	$alamat_supplier = htmlspecialchars($_POST['alamat_supplier']);
	$no_telp_supplier = htmlspecialchars($_POST['no_telp_supplier']);

	$ubah_supplier = mysqli_query($koneksi, "UPDATE supplier SET nama_supplier = '$nama_supplier', alamat_supplier = '$alamat_supplier', no_telp_supplier = '$no_telp_supplier' WHERE id_supplier = '$id_supplier'");

	if ($ubah_supplier) {
		echo "
			<script>
				alert('Supplier berhasil diubah!');
				window.location.href='supplier.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('Supplier gagal diubah!');
				window.history.back();
			</script>
		";
	}
}

?>

<html>
<head>
	<title>Ubah Supplier - <?= $data_supplier['nama_supplier']; ?></title>
</head>
<body>
	<a href="supplier.php">Kembali</a>
	<form method="post">
		<div>
			<label for="nama_supplier">Nama Supplier</label>
			<input type="text" name="nama_supplier" id="nama_supplier" value="<?= $data_supplier['nama_supplier']; ?>" required>
		</div>
		<div>
			<label for="alamat_supplier">Alamat Supplier</label>
			<textarea name="alamat_supplier" id="alamat_supplier" required><?= $data_supplier['alamat_supplier']; ?></textarea>
		</div>
		<div>
			<label for="no_telp_supplier">No. Telp Supplier</label>
			<input type="number" name="no_telp_supplier" id="no_telp_supplier" value="<?= $data_supplier['no_telp_supplier']; ?>" required>
		</div>
		<div>
			<button type="submit" name="btnUbahSupplier">Ubah Supplier</button>
		</div>
	</form>
</body>
</html>