<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}

$id_user = htmlspecialchars($_SESSION['id_user']);

$data_profile = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

?>

<html>
<head>
	<title>Profile - <?= $data_profile['username']; ?></title>
</head>
<body>
	<a href="../index.php">Kembali</a>
	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>Username</th>
			<td><?= $data_profile['username']; ?></td>
		</tr>
		<tr>
			<th>Hak Akses</th>
			<td><?= ucwords($data_profile['hak_akses']); ?></td>
		</tr>
		<tr>
			<th>Nama Lengkap</th>
			<td><?= $data_profile['nama_lengkap']; ?></td>
		</tr>
		<tr>
			<th>No. Telp User</th>
			<td><?= $data_profile['no_telp_user']; ?></td>
		</tr>
	</table>
	<a href="ubah_profile.php">Ubah Profile</a>
	<a href="ubah_password.php">Ganti Password</a>
</body>
</html>