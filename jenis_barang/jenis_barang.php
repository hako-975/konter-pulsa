<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}

$jenis_barang = mysqli_query($koneksi, "SELECT * FROM jenis_barang ORDER BY jenis_barang ASC");

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
?>

<html>
<head>
	<title>Jenis Barang</title>
</head>
<body>
	<a href="../index.php">Kembali</a>
	<a href="tambah_jenis_barang.php">Tambah Jenis Barang</a>
	<table border="1" cellpadding="10" cellspacing="0">
		<thead>
			<tr>
				<th>No.</th>
				<th>Jenis Barang</th>
				<?php if ($data_profile['hak_akses'] == 'administrator'): ?>
					<th>Aksi</th>
				<?php endif ?>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1; ?>
			<?php foreach ($jenis_barang as $djb): ?>
				<tr>
					<td><?= $i++; ?></td>
					<td><?= $djb['jenis_barang']; ?></td>
					<?php if ($data_profile['hak_akses'] == 'administrator'): ?>
						<td>
							<a href="ubah_jenis_barang.php?id_jenis_barang=<?= $djb['id_jenis_barang']; ?>">Ubah</a>
							<a onclick="return confirm('Apakah Anda yakin ingin menghapus jenis barang <?= $djb['jenis_barang']; ?>?')" href="hapus_jenis_barang.php?id_jenis_barang=<?= $djb['id_jenis_barang']; ?>">Hapus</a>
						</td>
					<?php endif ?>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</body>
</html>