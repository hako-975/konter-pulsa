<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}

$barang = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN jenis_barang ON barang.id_jenis_barang = jenis_barang.id_jenis_barang ORDER BY nama_barang ASC");

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
?>

<html>
<head>
	<title>Barang</title>
</head>
<body>
	<a href="../index.php">Kembali</a>
	<a href="tambah_barang.php">Tambah Barang</a>
	<table border="1" cellpadding="10" cellspacing="0">
		<thead>
			<tr>
				<th>No.</th>
				<th>Nama Barang</th>
				<th>Harga Beli</th>
				<th>Harga Jual</th>
				<th>Stok Barang</th>
				<th>Jenis Barang</th>
				<?php if ($data_profile['hak_akses'] == 'administrator'): ?>
					<th>Aksi</th>
				<?php endif ?>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1; ?>
			<?php foreach ($barang as $db): ?>
				<tr>
					<td><?= $i++; ?></td>
					<td><?= $db['nama_barang']; ?></td>
					<td>Rp. <?= str_replace(",", ".", number_format($db['harga_beli'])); ?></td>
					<td>Rp. <?= str_replace(",", ".", number_format($db['harga_jual'])); ?></td>
					<td><?= $db['stok_barang']; ?></td>
					<td><?= $db['jenis_barang']; ?></td>
					<?php if ($data_profile['hak_akses'] == 'administrator'): ?>
						<td>
							<a href="ubah_barang.php?id_barang=<?= $db['id_barang']; ?>">Ubah</a>
							<a onclick="return confirm('Apakah Anda yakin ingin menghapus barang <?= $db['nama_barang']; ?>?')" href="hapus_barang.php?id_barang=<?= $db['id_barang']; ?>">Hapus</a>
						</td>
					<?php endif ?>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</body>
</html>