<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: ".BASE_URL."login.php");
	exit;
}

$id_user = htmlspecialchars($_SESSION['id_user']);

$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

?>

<html>
<head>
	<title>Profile - <?= $data_profile['username']; ?></title>
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
			<h1>Profile</h1>
			<table border="0" cellpadding="10" cellspacing="0">
				<tr>
					<th class="th-profile">Username</th>
					<td>: <?= $data_profile['username']; ?></td>
				</tr>
				<tr>
					<th class="th-profile">Hak Akses</th>
					<td>: <?= ucwords($data_profile['hak_akses']); ?></td>
				</tr>
				<tr>
					<th class="th-profile">Nama Lengkap</th>
					<td>: <?= $data_profile['nama_lengkap']; ?></td>
				</tr>
				<tr>
					<th class="th-profile">No. Telp User</th>
					<td>: <?= $data_profile['no_telp_user']; ?></td>
				</tr>
			</table>
		</div>
		<a href="ubah_profile.php" class="btn">Ubah Profile</a>
		<a href="ubah_password.php" class="btn">Ubah Password</a>
	</div>
	
    <?php include_once '../include/script.php'; ?>
</body>
</html>