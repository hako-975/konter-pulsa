<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}


$id_transaksi = htmlspecialchars($_GET['id_transaksi']);


$data_transaksi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM transaksi INNER JOIN user ON transaksi.id_user = user.id_user WHERE transaksi.id_transaksi = '$id_transaksi'"));

if ($data_transaksi == null) {
	echo "
		<script>
			window.location.href='transaksi.php';
		</script>
	";
	exit;
}

$detail_transaksi = mysqli_query($koneksi, "SELECT * FROM detail_transaksi INNER JOIN transaksi ON detail_transaksi.id_transaksi = transaksi.id_transaksi INNER JOIN barang ON detail_transaksi.id_barang = barang.id_barang WHERE detail_transaksi.id_transaksi = '$id_transaksi' ORDER BY barang.nama_barang ASC");

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
?>

<html>
<head>
	<title>Transaksi</title>
</head>
<body>
	<a href="transaksi.php">Kembali</a>
	<h4>Id Transaksi: <?= $data_transaksi['id_transaksi']; ?></h4>
	<h4>Total Harga: Rp. <?= str_replace(",", ".", number_format($data_transaksi['total_harga'])); ?></h4>
	<h4>Bayar: Rp. <?= str_replace(",", ".", number_format($data_transaksi['bayar'])); ?></h4>
	<h4>Kembalian: Rp. <?= str_replace(",", ".", number_format($data_transaksi['kembalian'])); ?></h4>
	<?php if ($data_transaksi['bayar'] == '0'): ?>
		<a href="bayar.php?id_transaksi=<?= $data_transaksi['id_transaksi']; ?>">Bayar</a><br><br>
	<?php endif ?>
	<a href="tambah_detail_transaksi.php?id_transaksi=<?= $data_transaksi['id_transaksi']; ?>">Tambah Transaksi Barang</a>
	<table border="1" cellpadding="10" cellspacing="0">
		<thead>
			<tr>
				<th>No.</th>
				<th>Nama Barang</th>
				<th>Kuantitas</th>
				<th>Subtotal</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1; ?>
			<?php foreach ($detail_transaksi as $ddt): ?>
				<tr>
					<td><?= $i++; ?></td>
					<td><?= $ddt['nama_barang']; ?></td>
					<td><?= $ddt['kuantitas']; ?></td>
					<td>Rp. <?= str_replace(",", ".", number_format($ddt['subtotal'])); ?></td>
					<td>
						<a href="ubah_detail_transaksi.php?id_detail_transaksi=<?= $ddt['id_detail_transaksi']; ?>&id_transaksi=<?= $id_transaksi; ?>">Ubah</a>
						<a onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi <?= $ddt['nama_barang']; ?>?')" href="hapus_detail_transaksi.php?id_detail_transaksi=<?= $ddt['id_detail_transaksi']; ?>&id_transaksi=<?= $id_transaksi; ?>">Hapus</a>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</body>
</html>