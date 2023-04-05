<?php 
require_once 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

$omset = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT sum(total_harga) as omset FROM transaksi"));
$laba = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM((b.harga_jual - b.harga_beli) * dt.kuantitas) AS laba FROM detail_transaksi dt INNER JOIN barang b ON dt.id_barang = b.id_barang"));

$jumlah_transaksi = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM transaksi"));

$barang_paling_laku = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT barang.id_barang, barang.nama_barang, SUM(kuantitas) as laku FROM detail_transaksi INNER JOIN barang ON detail_transaksi.id_barang = barang.id_barang GROUP BY detail_transaksi.id_barang ORDER BY laku DESC LIMIT 1"));

$transaksi = mysqli_query($koneksi, "SELECT * FROM transaksi INNER JOIN user ON transaksi.id_user = user.id_user ORDER BY tanggal_transaksi DESC");

?>

<html>
<head>
	<title>Dashboard - Konter Pulsa</title>
	<?php include_once 'include/head.php'; ?>
</head>
<body class="bg-gradient">
	<div id="preloader">
      <div class="loader"></div>
    </div>
	<?php include_once 'include/topbar.php' ?>
	<?php include_once 'include/sidebar.php'; ?>
	<div class="main-content">
		<div class="my">
			<h1>Dashboard</h1>
			<div class="card">
				<h3>Omset</h3>
				<h4>Rp. <?= str_replace(",", ".", number_format($omset['omset'])); ?></h4>
			</div>
			<div class="card">
				<h3>Laba</h3>
				<h4>Rp. <?= str_replace(",", ".", number_format($laba['laba'])); ?></h4>
			</div>
			<div class="card">
				<h3>Jumlah Transaksi</h3>
				<h4><?= $jumlah_transaksi; ?></h4>
			</div>
			<div class="card">
				<h3>Barang Paling Laku</h3>
				<?php if ($barang_paling_laku): ?>
	                <h4><?= $barang_paling_laku['nama_barang']; ?> (<?= $barang_paling_laku['laku']; ?>)</h4>
	            <?php else: ?>
	                <h4>Tidak Ada</h4>
	            <?php endif ?>
			</div>
		</div>
		<hr class="bg-black">
		<div class="my">
			<h1 class="inline-block">Transaksi Terbaru</h1>
			<a href="<?= BASE_URL; ?>transaksi/tambah_transaksi.php" class="btn float-right">Tambah Transaksi</a>
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
							<td><?= $dt['tanggal_transaksi']; ?></td>
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
	
    <?php include_once 'include/script.php'; ?>
</body>
</html>