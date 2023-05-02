<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}

$pemasukan_barang = mysqli_query($koneksi, "SELECT * FROM pemasukan_barang INNER JOIN barang ON pemasukan_barang.id_barang = barang.id_barang INNER JOIN supplier ON pemasukan_barang.id_supplier = supplier.id_supplier ORDER BY tanggal_pemasukan DESC");

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
?>

<html>
<head>
	<title>Pemasukan Barang</title>
	<?php include_once '../include/head.php'; ?>
</head>
<body class="bg-gradient">
	<div id="preloader">
      <div class="loader"></div>
    </div>
    <?php include_once '../include/topbar.php' ?>
	<?php include_once '../include/sidebar.php'; ?>
	<div class="main-content">
		<div class="my">
			<h1 class="inline-block">Pemasukan Barang</h1>
			<a href="<?= BASE_URL; ?>pemasukan_barang/tambah_pemasukan_barang.php" class="btn float-right">Tambah Pemasukan Barang</a>
			<table border="1" cellpadding="10" cellspacing="0">
				<thead class="thead">
					<tr>
						<th>No.</th>
						<th>Nama Barang</th>
						<th>Nama Supplier</th>
						<th>Tanggal Pemasukan</th>
						<th>Jumlah Pemasukan</th>
						<?php if ($data_profile['hak_akses'] == 'administrator'): ?>
							<th>Aksi</th>
						<?php endif ?>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1; ?>
					<?php foreach ($pemasukan_barang as $dpb): ?>
						<tr>
							<td><?= $i++; ?></td>
							<td><?= $dpb['nama_barang']; ?></td>
							<td><?= $dpb['nama_supplier']; ?></td>
							<td><?= date("d-m-Y, H:i", strtotime($dpb['tanggal_pemasukan'])); ?></td>
							<td><?= $dpb['jumlah_pemasukan']; ?></td>
							<?php if ($data_profile['hak_akses'] == 'administrator'): ?>
								<td>
									<a href="ubah_pemasukan_barang.php?id_pemasukan_barang=<?= $dpb['id_pemasukan_barang']; ?>" class="btn">Ubah</a>
									<a onclick="return confirm('Apakah Anda yakin ingin menghapus pemasukan barang <?= $dpb['nama_barang']; ?>?')" href="hapus_pemasukan_barang.php?id_pemasukan_barang=<?= $dpb['id_pemasukan_barang']; ?>" class="btn">Hapus</a>
								</td>
							<?php endif ?>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
    <?php include_once '../include/script.php'; ?>

</body>
</html>