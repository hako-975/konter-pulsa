<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}


$id_transaksi = htmlspecialchars($_GET['id_transaksi']);
$id_detail_transaksi = htmlspecialchars($_GET['id_detail_transaksi']);

$data_detail_transaksi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM detail_transaksi WHERE id_detail_transaksi = '$id_detail_transaksi'"));
$subtotal = $data_detail_transaksi['subtotal'];

$update_total_harga = mysqli_query($koneksi, "UPDATE transaksi SET total_harga = total_harga - '$subtotal' WHERE id_transaksi = '$id_transaksi'");

$hapus_detail_transaksi = mysqli_query($koneksi, "DELETE FROM detail_transaksi WHERE id_detail_transaksi = '$id_detail_transaksi'");

if ($hapus_detail_transaksi) {
	echo "
		<script>
			alert('Jenis Barang berhasil dihapus!');
			window.location.href='detail_transaksi.php?id_transaksi=$id_transaksi';
		</script>
	";
} else {
	echo "
		<script>
			alert('Jenis Barang gagal dihapus!');
			window.location.href='detail_transaksi.php?id_transaksi=$id_transaksi';
		</script>
	";
}

?>