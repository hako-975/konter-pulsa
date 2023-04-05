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
		exit;
	} else {
		echo "
			<script>
				alert('Supplier gagal ditambahkan!');
				window.history.back();
			</script>
		";
		exit;
	}
}

?>

<html>
<head>
	<title>Tambah Supplier</title>
<?php include_once '../include/head.php'; ?>
</head>
<body class="bg-gradient">
	<div id="preloader">
      <div class="loader"></div>
    </div>
    <?php include_once '../include/topbar.php' ?>
	<?php include_once '../include/sidebar.php'; ?>
	<div class="main-content">
		<a href="<?= BASE_URL; ?>supplier/supplier.php" class="btn">Kembali</a>
		<div class="my">
			<h1>Tambah Supplier</h1>
			<form method="post">
				<div class="form-group">
					<label for="nama_supplier">Nama Supplier</label>
					<input type="text" name="nama_supplier" id="nama_supplier" class="form-input" required>
				</div>
				<div class="form-group">
					<label for="alamat_supplier">Alamat Supplier</label>
					<textarea name="alamat_supplier" id="alamat_supplier" class="form-input" required></textarea>
				</div>
				<div class="form-group">
					<label for="no_telp_supplier">No. Telp Supplier</label>
					<input type="number" name="no_telp_supplier" id="no_telp_supplier" class="form-input" required>
				</div>
				<div class="form-group">
					<button type="submit" name="btnTambahSupplier" class="btn">Tambah Supplier</button>
				</div>
			</form>
		</div>
	</div>

    <?php include_once '../include/script.php'; ?>

</body>
</html>