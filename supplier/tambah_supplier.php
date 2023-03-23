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

if (isset($_POST['btnTambahSupplier'])) {
	$nama_supplier = htmlspecialchars(ucwords($_POST['nama_supplier']));
	$alamat_supplier = htmlspecialchars($_POST['alamat_supplier']);
	$no_telp_supplier = htmlspecialchars($_POST['no_telp_supplier']);

	$tambah_supplier = mysqli_query($koneksi, "INSERT INTO supplier VALUES('', '$nama_supplier', '$alamat_supplier', '$no_telp_supplier')");

	if ($tambah_supplier) {
		echo "
			<script>
				alert('Supplier berhasil ditambahkan!');
				window.location.href='supplier.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('Supplier gagal ditambahkan!');
				window.history.back();
			</script>
		";
	}
}

?>

<html>
<head>
	<title>Tambah Supplier</title>
</head>
<body>
	<a href="supplier.php">Kembali</a>
	<form method="post">
		<div>
			<label for="nama_supplier">Nama Supplier</label>
			<input type="text" name="nama_supplier" id="nama_supplier" required>
		</div>
		<div>
			<label for="alamat_supplier">Alamat Supplier</label>
			<textarea name="alamat_supplier" id="alamat_supplier" required></textarea>
		</div>
		<div>
			<label for="no_telp_supplier">No. Telp Supplier</label>
			<input type="number" name="no_telp_supplier" id="no_telp_supplier" required>
		</div>
		<div>
			<button type="submit" name="btnTambahSupplier">Tambah Supplier</button>
		</div>
	</form>
</body>
</html>