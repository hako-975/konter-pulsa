<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}

$id_transaksi = htmlspecialchars($_GET['id_transaksi']);
$data_transaksi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM transaksi INNER JOIN user ON transaksi.id_transaksi = user.id_user WHERE id_transaksi = '$id_transaksi'"));

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
	} else {
		echo "
			<script>
				alert('Transaksi gagal diubah!');
				window.history.back();
			</script>
		";
	}
}

?>

<html>
<head>
	<title>Ubah Transaksi - <?= $data_transaksi['id_transaksi']; ?></title>
</head>
<body>
	<a href="transaksi.php">Kembali</a>
	<form method="post">
		<div>
			<label for="tanggal_transaksi">Tanggal Transaksi</label>
			<input type="datetime-local" name="tanggal_transaksi" id="tanggal_transaksi" value="<?= $data_transaksi['tanggal_transaksi']; ?>" required>
		</div>
		<div>
			<label for="total_harga">Total Harga</label>
			<input style="cursor: not-allowed;" type="number" disabled name="total_harga" id="total_harga" value="<?= $data_transaksi['total_harga']; ?>" required>
		</div>
		<div>
			<label for="id_user">User</label>
			<input style="cursor: not-allowed;" type="text" disabled name="id_user" id="id_user" value="<?= $data_transaksi['username']; ?>" required>
		</div>
		<div>
			<button type="submit" name="btnUbahTransaksi">Ubah Transaksi</button>
		</div>
	</form>
</body>
</html>