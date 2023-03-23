<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}

$supplier = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY nama_supplier ASC");

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
?>

<html>
<head>
	<title>Supplier</title>
</head>
<body>
	<a href="../index.php">Kembali</a>
	<a href="tambah_supplier.php">Tambah Supplier</a>
	<table border="1" cellpadding="10" cellspacing="0">
		<thead>
			<tr>
				<th>No.</th>
				<th>Nama Supplier</th>
				<th>Alamat Supplier</th>
				<th>No. Telp Supplier</th>
				<?php if ($data_profile['hak_akses'] == 'administrator'): ?>
					<th>Aksi</th>
				<?php endif ?>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1; ?>
			<?php foreach ($supplier as $ds): ?>
				<tr>
					<td><?= $i++; ?></td>
					<td><?= $ds['nama_supplier']; ?></td>
					<td><?= $ds['alamat_supplier']; ?></td>
					<td><?= $ds['no_telp_supplier']; ?></td>
					<?php if ($data_profile['hak_akses'] == 'administrator'): ?>
						<td>
							<a href="ubah_supplier.php?id_supplier=<?= $ds['id_supplier']; ?>">Ubah</a>
							<a onclick="return confirm('Apakah Anda yakin ingin menghapus supplier <?= $ds['nama_supplier']; ?>?')" href="hapus_supplier.php?id_supplier=<?= $ds['id_supplier']; ?>">Hapus</a>
						</td>
					<?php endif ?>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</body>
</html>