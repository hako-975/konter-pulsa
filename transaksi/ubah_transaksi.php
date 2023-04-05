<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

$id_transaksi = htmlspecialchars($_GET['id_transaksi']);
$data_transaksi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM transaksi INNER JOIN user ON transaksi.id_user = user.id_user WHERE id_transaksi = '$id_transaksi'"));

if (isset($_POST['btnUbahTransaksi'])) {
	$tanggal_transaksi = htmlspecialchars($_POST['tanggal_transaksi']);

	$ubah_transaksi = mysqli_query($koneksi, "UPDATE transaksi SET tanggal_transaksi = '$tanggal_transaksi' WHERE id_transaksi = '$id_transaksi'");

	if ($ubah_transaksi) {
		echo "
			<script>
				alert('Transaksi berhasil diubah!');
				window.location.href='transaksi.php';
			</script>
		";
		exit;
	} else {
		echo "
			<script>
				alert('Transaksi gagal diubah!');
				window.history.back();
			</script>
		";
		exit;
	}
}

?>

<html>
<head>
	<title>Ubah Transaksi - <?= $data_transaksi['id_transaksi']; ?></title>
	<?php include_once '../include/head.php'; ?>
</head>
<body class="bg-gradient">
	<div id="preloader">
      <div class="loader"></div>
    </div>
    <?php include_once '../include/topbar.php' ?>
	<?php include_once '../include/sidebar.php'; ?>
	<div class="main-content">
		<a href="<?= BASE_URL; ?>transaksi/transaksi.php" class="btn">Kembali</a>
		<div class="my">
			<h1>Ubah Transaksi - <?= $data_transaksi['id_transaksi']; ?></h1>
			<form method="post">
				<div class="form-group">
					<label for="tanggal_transaksi">Tanggal Transaksi</label>
					<input type="datetime-local" name="tanggal_transaksi" id="tanggal_transaksi" class="form-input"  value="<?= $data_transaksi['tanggal_transaksi']; ?>" required>
				</div>
				<div class="form-group">
					<label for="total_harga">Total Harga</label>
					<input style="cursor: not-allowed;" type="number" disabled name="total_harga" id="total_harga" class="form-input"  value="<?= $data_transaksi['total_harga']; ?>" required>
				</div>
				<div class="form-group">
					<label for="bayar">Bayar</label>
					<input style="cursor: not-allowed;" type="number" disabled name="bayar" id="bayar" class="form-input"  value="<?= $data_transaksi['bayar']; ?>" required>
				</div>
				<div class="form-group">
					<label for="kembalian">Kembalian</label>
					<input style="cursor: not-allowed;" type="number" disabled name="kembalian" id="kembalian" class="form-input"  value="<?= $data_transaksi['kembalian']; ?>" required>
				</div>
				<div class="form-group">
					<label for="id_user">User</label>
					<input style="cursor: not-allowed;" type="text" disabled name="id_user" id="id_user" class="form-input"  value="<?= $data_transaksi['username']; ?>" required>
				</div>
				<div class="form-group">
					<button type="submit" name="btnUbahTransaksi" class="btn">Ubah Transaksi</button>
				</div>
			</form>
		</div>
	</div>
    <?php include_once '../include/script.php'; ?>
</body>
</html>