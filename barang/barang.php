<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}

$barang = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN jenis_barang ON barang.id_jenis_barang = jenis_barang.id_jenis_barang ORDER BY nama_barang ASC");

if (isset($_GET['btnCari'])) {
	$cari = $_GET['cari'];
	$barang = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN jenis_barang ON barang.id_jenis_barang = jenis_barang.id_jenis_barang 
		WHERE barang.nama_barang LIKE '%$cari%' OR
		barang.harga_beli LIKE '%$cari%' OR
		barang.harga_jual LIKE '%$cari%' OR
		barang.stok_barang LIKE '%$cari%' OR
		jenis_barang.jenis_barang LIKE '%$cari%'
		ORDER BY barang.nama_barang ASC");
}

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
?>

<html>
<head>
	<title>Barang</title>
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
			<h1>Barang</h1>
			<form method="get" class="inline-block form-cari-input">
				<input type="text" name="cari" value="<?= (isset($_GET['btnCari'])? $cari : ''); ?>">
				<button type="submit" class="btn" name="btnCari">Cari</button>
				<?php if (isset($_GET['btnCari'])): ?>
					<a href="barang.php" class="btn">X</a>
				<?php endif ?>
			</form>
			<a href="<?= BASE_URL; ?>barang/tambah_barang.php" class="btn float-right">Tambah Barang</a>
			<?php if (isset($_GET['btnCari'])): ?>
				<h2>Data ditemukan: <?= mysqli_num_rows($barang); ?></h2>
			<?php endif ?>
			<table border="1" cellpadding="10" cellspacing="0">
				<thead class="thead">
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
									<a href="ubah_barang.php?id_barang=<?= $db['id_barang']; ?>" class="btn">Ubah</a>
									<a onclick="return confirm('Apakah Anda yakin ingin menghapus barang <?= $db['nama_barang']; ?>?')" href="hapus_barang.php?id_barang=<?= $db['id_barang']; ?>" class="btn">Hapus</a>
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