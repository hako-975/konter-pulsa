<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}

$id_user = htmlspecialchars($_SESSION['id_user']);

$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

if (isset($_POST['btnUbahProfile'])) {
	$username = htmlspecialchars($_POST['username']);
	$nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
	$no_telp_user = htmlspecialchars($_POST['no_telp_user']);

	// check username 
	$check_username = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
	if (mysqli_num_rows($check_username)) {
		echo "
			<script>
				alert('Username telah digunakan!');
				window.history.back();
			</script>
		";
	}

	$ubah_profile = mysqli_query($koneksi, "UPDATE user SET username = '$username', nama_lengkap = '$nama_lengkap', no_telp_user = '$no_telp_user' WHERE id_user = '$id_user'");

	if ($ubah_profile) {
		echo "
			<script>
				alert('Profile berhasil diubah!');
				window.location.href='profile.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('Profile gagal diubah!');
				window.history.back();
			</script>
		";
	}
}

?>

<html>
<head>
	<title>Ubah Profile - <?= $data_user['username']; ?></title>
</head>
<body>
	<a href="profile.php">Kembali</a>
	<form method="post">
		<div>
			<label for="username">Username</label>
			<input type="text" name="username" id="username" value="<?= $data_user['username']; ?>" required>
		</div>
		<div>
			<label for="nama_lengkap">Nama Lengkap</label>
			<input type="text" name="nama_lengkap" id="nama_lengkap" value="<?= $data_user['nama_lengkap']; ?>" required>
		</div>
		<div>
			<label for="no_telp_user">No. Telp User</label>
			<input type="number" name="no_telp_user" id="no_telp_user" value="<?= $data_user['no_telp_user']; ?>" required>
		</div>
		<div>
			<button type="submit" name="btnUbahProfile">Ubah Profile</button>
		</div>
	</form>
</body>
</html>