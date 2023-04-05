<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}

$user = mysqli_query($koneksi, "SELECT * FROM user ORDER BY hak_akses ASC");

$id_user = htmlspecialchars($_SESSION['id_user']);
$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));
?>

<html>
<head>
	<title>User</title>
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
			<h1 class="inline-block">User</h1>
			<a href="<?= BASE_URL; ?>user/tambah_user.php" class="btn float-right">Tambah User</a>
			<table border="1" cellpadding="10" cellspacing="0">
				<thead class="thead">
					<tr>
						<th>No.</th>
						<th>Username</th>
						<th>Hak Akses</th>
						<th>Nama Lengkap</th>
						<th>No. Telp User</th>
						<?php if ($data_profile['hak_akses'] == 'administrator'): ?>
							<th>Aksi</th>
						<?php endif ?>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1; ?>
					<?php foreach ($user as $du): ?>
						<tr>
							<td><?= $i++; ?></td>
							<td><?= $du['username']; ?></td>
							<td><?= ucwords($du['hak_akses']); ?></td>
							<td><?= $du['nama_lengkap']; ?></td>
							<td><?= $du['no_telp_user']; ?></td>
							<?php if ($data_profile['hak_akses'] == 'administrator'): ?>
								<td>
									<a href="ubah_user.php?id_user=<?= $du['id_user']; ?>" class="btn">Ubah</a>
									<a onclick="return confirm('Apakah Anda yakin ingin menghapus user <?= $du['username']; ?>?')" href="hapus_user.php?id_user=<?= $du['id_user']; ?>" class="btn">Hapus</a>
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