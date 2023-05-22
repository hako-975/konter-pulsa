<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}

$transaksi = mysqli_query($koneksi, "SELECT * FROM transaksi INNER JOIN user ON transaksi.id_user = user.id_user ORDER BY tanggal_transaksi DESC");

if (isset($_GET['btnCari'])) {
	$cari = $_GET['cari'];
	$transaksi = mysqli_query($koneksi, "SELECT * FROM transaksi INNER JOIN user ON transaksi.id_user = user.id_user 
		WHERE transaksi.tanggal_transaksi LIKE '%$cari%' OR
		transaksi.total_harga LIKE '%$cari%' OR
		transaksi.bayar LIKE '%$cari%' OR
		transaksi.kembalian LIKE '%$cari%'
	 ORDER BY transaksi.tanggal_transaksi DESC");
}

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
?>

<html>
<head>
	<title>Transaksi</title>
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
			<h1>Transaksi</h1>
			<form method="get" class="inline-block form-cari-input">
				<input type="text" name="cari" value="<?= (isset($_GET['btnCari'])? $cari : ''); ?>">
				<button type="submit" class="btn" name="btnCari">Cari</button>
				<?php if (isset($_GET['btnCari'])): ?>
					<a href="transaksi.php" class="btn">X</a>
				<?php endif ?>
			</form>
			<a href="<?= BASE_URL; ?>transaksi/tambah_transaksi.php" class="btn float-right">Tambah Transaksi</a>
			<?php if (isset($_GET['btnCari'])): ?>
				<h2>Data ditemukan: <?= mysqli_num_rows($transaksi); ?></h2>
			<?php endif ?>
			<table border="1" cellpadding="10" cellspacing="0">
				<thead class="thead">
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
							<td><?= date("d-m-Y, H:i", strtotime($dt['tanggal_transaksi'])); ?></td>
							<td>Rp. <?= str_replace(",", ".", number_format($dt['total_harga'])); ?></td>
							<td>Rp. <?= str_replace(",", ".", number_format($dt['bayar'])); ?></td>
							<td>Rp. <?= str_replace(",", ".", number_format($dt['kembalian'])); ?></td>
							<td><?= $dt['username']; ?></td>
							<td>
								<a href="detail_transaksi.php?id_transaksi=<?= $dt['id_transaksi']; ?>" class="btn"><?php if ($dt['bayar'] == 0): ?> Bayar <?php else: ?> Detail <?php endif ?></a>
								<a href="ubah_transaksi.php?id_transaksi=<?= $dt['id_transaksi']; ?>" class="btn">Ubah</a>
								<a onclick="return confirm('Apakah Anda yakin ingin menghapus Transaksi?')" href="hapus_transaksi.php?id_transaksi=<?= $dt['id_transaksi']; ?>" class="btn">Hapus</a>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
    <?php include_once '../include/script.php'; ?>

</body>
</html>