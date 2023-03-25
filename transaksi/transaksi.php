<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}

$transaksi = mysqli_query($koneksi, "SELECT * FROM transaksi INNER JOIN user ON transaksi.id_user = user.id_user ORDER BY tanggal_transaksi DESC");

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
?>

<html>
<head>
	<title>Transaksi</title>
</head>
<body>
	<a href="../index.php">Kembali</a>
	<a href="tambah_transaksi.php">Tambah Transaksi</a>
	<table border="1" cellpadding="10" cellspacing="0">
		<thead>
			<tr>
				<th>No.</th>
				<th>Tanggal Transaksi</th>
				<th>Total Harga</th>
				<th>Bayar</th>
				<th>Kembalian</th>
				<th>User</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1; ?>
			<?php foreach ($transaksi as $dt): ?>
				<tr>
					<td><?= $i++; ?></td>
					<td><?= $dt['tanggal_transaksi']; ?></td>
					<td>Rp. <?= str_replace(",", ".", number_format($dt['total_harga'])); ?></td>
					<td>Rp. <?= str_replace(",", ".", number_format($dt['bayar'])); ?></td>
					<td>Rp. <?= str_replace(",", ".", number_format($dt['kembalian'])); ?></td>
					<td><?= $dt['username']; ?></td>
					<td>
						<a href="detail_transaksi.php?id_transaksi=<?= $dt['id_transaksi']; ?>">Detail</a>
						<a href="ubah_transaksi.php?id_transaksi=<?= $dt['id_transaksi']; ?>">Ubah</a>
						<a onclick="return confirm('Apakah Anda yakin ingin menghapus Transaksi?')" href="hapus_transaksi.php?id_transaksi=<?= $dt['id_transaksi']; ?>">Hapus</a>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</body>
</html>