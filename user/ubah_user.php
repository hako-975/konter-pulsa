<?php 
require_once '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}

if ($_SESSION['hak_akses'] != 'administrator') {
	echo "
		<script>
			alert('Tidak dapat melakukan perubahan selain Administrator!');
			window.history.back();
		</script>
	";
	exit;
}

$id_user = htmlspecialchars($_GET['id_user']);

$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

if (isset($_POST['btnUbahUser'])) {
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

	$ubah_user = mysqli_query($koneksi, "UPDATE user SET username = '$username', nama_lengkap = '$nama_lengkap', no_telp_user = '$no_telp_user' WHERE id_user = '$id_user'");

	if ($ubah_user) {
		echo "
			<script>
				alert('User berhasil diubah!');
				window.location.href='user.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('User gagal diubah!');
				window.history.back();
			</script>
		";
	}
}

?>

<html>
<head>
	<title>Ubah User - <?= $data_user['username']; ?></title>
</head>
<body>
	<a href="user.php">Kembali</a>
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
			<button type="submit" name="btnUbahUser">Ubah User</button>
		</div>
	</form>
</body>
</html>