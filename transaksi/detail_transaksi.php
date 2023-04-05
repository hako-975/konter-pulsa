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

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

$detail_transaksi = mysqli_query($koneksi, "SELECT * FROM detail_transaksi INNER JOIN transaksi ON detail_transaksi.id_transaksi = transaksi.id_transaksi INNER JOIN barang ON detail_transaksi.id_barang = barang.id_barang WHERE detail_transaksi.id_transaksi = '$id_transaksi' ORDER BY barang.nama_barang ASC");

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
		<a href="<?= BASE_URL; ?>transaksi/transaksi.php" class="btn">Kembali</a>
		<div class="my">
			<h1 class="inline-block">Transaksi Barang</h1>
            <?php if ($data_transaksi['bayar'] == 0): ?>
				<a href="<?= BASE_URL; ?>transaksi/tambah_detail_transaksi.php?id_transaksi=<?= $data_transaksi['id_transaksi']; ?>" class="btn float-right">Tambah Transaksi Barang</a>
			<?php endif ?>
			<table border="1" cellpadding="10" cellspacing="0">
				<tr>
					<th>
						Id Transaksi: <?= $data_transaksi['id_transaksi']; ?>
					</th>
					<th>
						Total Harga: Rp. <?= str_replace(",", ".", number_format($data_transaksi['total_harga'])); ?>
					</th>
					<th>
						Bayar: Rp. <?= str_replace(",", ".", number_format($data_transaksi['bayar'])); ?>
					</th>
					<th>
						Kembalian: Rp. <?= str_replace(",", ".", number_format($data_transaksi['kembalian'])); ?>
					</th>
				</tr>
			</table>
			<br>
			<?php if ($data_transaksi['bayar'] == '0' && $data_transaksi['total_harga'] != '0'): ?>
				<a href="<?= BASE_URL; ?>transaksi/bayar.php?id_transaksi=<?= $data_transaksi['id_transaksi']; ?>" class="btn">Bayar</a><br><br>
			<?php endif ?>
			<table border="1" cellpadding="10" cellspacing="0">
				<thead>
					<tr>
						<th>No.</th>
						<th>Nama Barang</th>
						<th>Kuantitas</th>
						<th>Subtotal</th>
			            <?php if ($data_transaksi['bayar'] == 0): ?>
							<th>Aksi</th>
						<?php endif ?>
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
				            <?php if ($data_transaksi['bayar'] == 0): ?>
								<td>
									<a href="ubah_detail_transaksi.php?id_detail_transaksi=<?= $ddt['id_detail_transaksi']; ?>&id_transaksi=<?= $id_transaksi; ?>" class="btn">Ubah</a>
									<a onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi <?= $ddt['nama_barang']; ?>?')" href="hapus_detail_transaksi.php?id_detail_transaksi=<?= $ddt['id_detail_transaksi']; ?>&id_transaksi=<?= $id_transaksi; ?>" class="btn">Hapus</a>
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