<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}

$jenis_barang = mysqli_query($koneksi, "SELECT * FROM jenis_barang ORDER BY jenis_barang ASC");

if (isset($_GET['btnCari'])) {
	$cari = $_GET['cari'];
	$jenis_barang = mysqli_query($koneksi, "SELECT * FROM jenis_barang 
		WHERE jenis_barang LIKE '%$cari%'
		ORDER BY jenis_barang ASC");
}

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
?>

<html>
<head>
	<title>Jenis Barang</title>
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
			<h1>Jenis Barang</h1>
			<form method="get" class="inline-block form-cari-input">
				<input type="text" name="cari" value="<?= (isset($_GET['btnCari'])? $cari : ''); ?>">
				<button type="submit" class="btn" name="btnCari">Cari</button>
				<?php if (isset($_GET['btnCari'])): ?>
					<a href="jenis_barang.php" class="btn">X</a>
				<?php endif ?>
			</form>
			<a href="<?= BASE_URL; ?>jenis_barang/tambah_jenis_barang.php" class="btn float-right">Tambah Jenis Barang</a>
			<?php if (isset($_GET['btnCari'])): ?>
				<h2>Data ditemukan: <?= mysqli_num_rows($jenis_barang); ?></h2>
			<?php endif ?>
			<table border="1" cellpadding="10" cellspacing="0">
				<thead class="thead">
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
									<a href="ubah_jenis_barang.php?id_jenis_barang=<?= $djb['id_jenis_barang']; ?>" class="btn">Ubah</a>
									<a onclick="return confirm('Apakah Anda yakin ingin menghapus jenis barang <?= $djb['jenis_barang']; ?>?')" href="hapus_jenis_barang.php?id_jenis_barang=<?= $djb['id_jenis_barang']; ?>" class="btn">Hapus</a>
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